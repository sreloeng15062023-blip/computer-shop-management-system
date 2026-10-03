<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\RepairService;
use App\Models\RepairPart;
use App\Models\Warranty;
use App\Models\WarrantyClaim;
use App\Models\InventoryTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display Report Management View (Feature #14)
     * Supports 12 distinct reports + Print + PDF + Excel export.
     */
    public function index(Request $request)
    {
        $reportType = $request->input('type', 'daily_sales');
        if ($reportType === 'sales') {
            $reportType = 'daily_sales';
        }

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        // Process report data
        $data = $this->buildReportData($reportType, $startDate, $endDate, $request);

        // Filter metadata
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('brand_name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(array_merge([
                'success' => true,
                'reportType' => $reportType,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ], $data));
        }

        return view('reports', array_merge($data, [
            'reportType' => $reportType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'categories' => $categories,
            'brands' => $brands,
            'suppliers' => $suppliers,
        ]));
    }

    /**
     * Get Report Data via AJAX Endpoint
     */
    public function getReportData(Request $request)
    {
        $reportType = $request->input('type', 'daily_sales');
        if ($reportType === 'sales') {
            $reportType = 'daily_sales';
        }

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $data = $this->buildReportData($reportType, $startDate, $endDate, $request);

        return response()->json(array_merge([
            'success' => true,
            'reportType' => $reportType,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ], $data));
    }

    /**
     * Export Report to Excel / CSV with UTF-8 BOM
     */
    public function export(Request $request)
    {
        $reportType = $request->input('type', 'daily_sales');
        if ($reportType === 'sales') {
            $reportType = 'daily_sales';
        }

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $data = $this->buildReportData($reportType, $startDate, $endDate, $request);
        $fileName = 'TECHZONE_' . ucfirst($reportType) . '_Report_' . date('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () use ($reportType, $data, $startDate, $endDate) {
            $handle = fopen('php://output', 'w');
            
            // Output UTF-8 BOM for Microsoft Excel compatibility (Khmer & English)
            fputs($handle, "\xEF\xBB\xBF");

            // Company Title and Header
            fputcsv($handle, ['TECHZONE Computer Shop Management System']);
            fputcsv($handle, [strtoupper(str_replace('_', ' ', $reportType)) . ' REPORT', 'Period:', $startDate . ' to ' . $endDate]);
            fputcsv($handle, ['Generated At:', date('Y-m-d H:i:s')]);
            fputcsv($handle, []); // Blank line

            // Summary Section
            fputcsv($handle, ['--- SUMMARY OVERVIEW ---']);
            if (isset($data['summary']) && is_array($data['summary'])) {
                foreach ($data['summary'] as $key => $val) {
                    $formattedVal = is_numeric($val) ? (str_contains($key, 'margin') || str_contains($key, 'rate') ? $val . '%' : number_format($val, 2)) : $val;
                    fputcsv($handle, [ucwords(str_replace('_', ' ', $key)), $formattedVal]);
                }
            }
            fputcsv($handle, []); // Blank line

            // Detailed Records
            fputcsv($handle, ['--- DETAILED RECORDS ---']);

            switch ($reportType) {
                case 'daily_sales':
                case 'sales':
                    fputcsv($handle, ['#', 'Sale Number', 'Date', 'Customer', 'Items Count', 'Payment Method', 'Subtotal ($)', 'Discount ($)', 'Tax ($)', 'Total ($)', 'Status']);
                    $i = 1;
                    foreach ($data['records'] as $r) {
                        fputcsv($handle, [
                            $i++,
                            $r->sale_number,
                            Carbon::parse($r->sale_date)->format('Y-m-d H:i'),
                            $r->customer->name ?? 'Walk-in Customer',
                            $r->details->sum('quantity'),
                            $r->payment_method ?? 'Cash',
                            number_format($r->subtotal, 2),
                            number_format($r->discount_amount, 2),
                            number_format($r->tax_amount, 2),
                            number_format($r->total_amount, 2),
                            $r->status ?? 'Completed',
                        ]);
                    }
                    break;

                case 'monthly_sales':
                    fputcsv($handle, ['#', 'Month / Year', 'Orders Count', 'Total Items Sold', 'Cash Sales ($)', 'Digital / QR Sales ($)', 'Total Revenue ($)', 'Avg Order Value ($)']);
                    $i = 1;
                    foreach ($data['records'] as $m) {
                        fputcsv($handle, [
                            $i++,
                            $m['month_label'],
                            $m['orders_count'],
                            $m['items_sold'],
                            number_format($m['cash_total'], 2),
                            number_format($m['digital_total'], 2),
                            number_format($m['total_revenue'], 2),
                            number_format($m['avg_order_value'], 2),
                        ]);
                    }
                    break;

                case 'inventory':
                    fputcsv($handle, ['#', 'Product Name', 'SKU', 'Category', 'Brand', 'Cost ($)', 'Selling Price ($)', 'In Stock', 'Min Alert', 'Cost Valuation ($)', 'Retail Valuation ($)', 'Status']);
                    $i = 1;
                    foreach ($data['records'] as $p) {
                        $costVal = $p->stock_quantity * $p->cost_price;
                        $retailVal = $p->stock_quantity * $p->selling_price;
                        $status = $p->stock_quantity <= 0 ? 'Out of Stock' : ($p->stock_quantity <= $p->min_stock_alert ? 'Low Stock' : 'In Stock');
                        fputcsv($handle, [
                            $i++,
                            $p->name,
                            $p->sku,
                            $p->category->name ?? 'N/A',
                            $p->brand->brand_name ?? ($p->brand->name ?? 'N/A'),
                            number_format($p->cost_price, 2),
                            number_format($p->selling_price, 2),
                            $p->stock_quantity,
                            $p->min_stock_alert,
                            number_format($costVal, 2),
                            number_format($retailVal, 2),
                            $status,
                        ]);
                    }
                    break;

                case 'low_stock':
                    fputcsv($handle, ['#', 'Product Name', 'SKU', 'Category', 'Brand', 'Current Stock', 'Min Alert Level', 'Deficit / Shortage', 'Unit Cost ($)', 'Est. Restock Cost ($)', 'Supplier', 'Status']);
                    $i = 1;
                    foreach ($data['records'] as $p) {
                        $shortage = max(0, $p->min_stock_alert - $p->stock_quantity);
                        $restockCost = $shortage * $p->cost_price;
                        $status = $p->stock_quantity <= 0 ? 'Out of Stock' : 'Low Stock';
                        fputcsv($handle, [
                            $i++,
                            $p->name,
                            $p->sku,
                            $p->category->name ?? 'N/A',
                            $p->brand->brand_name ?? ($p->brand->name ?? 'N/A'),
                            $p->stock_quantity,
                            $p->min_stock_alert,
                            $shortage,
                            number_format($p->cost_price, 2),
                            number_format($restockCost, 2),
                            $p->supplier->name ?? 'N/A',
                            $status,
                        ]);
                    }
                    break;

                case 'best_selling':
                    fputcsv($handle, ['Rank #', 'Product Name', 'SKU', 'Category', 'Brand', 'Unit Price ($)', 'Units Sold', 'Total Revenue ($)', 'Est. Gross Profit ($)', 'Current Stock']);
                    $i = 1;
                    foreach ($data['records'] as $p) {
                        fputcsv($handle, [
                            $i++,
                            $p['name'],
                            $p['sku'],
                            $p['category'],
                            $p['brand'],
                            number_format($p['unit_price'], 2),
                            $p['units_sold'],
                            number_format($p['total_revenue'], 2),
                            number_format($p['gross_profit'], 2),
                            $p['current_stock'],
                        ]);
                    }
                    break;

                case 'purchase':
                    fputcsv($handle, ['#', 'PO Number', 'Order Date', 'Supplier', 'Expected Delivery', 'Items Count', 'Total Amount ($)', 'Payment Status', 'Status']);
                    $i = 1;
                    foreach ($data['records'] as $po) {
                        fputcsv($handle, [
                            $i++,
                            $po->po_number,
                            $po->order_date ? Carbon::parse($po->order_date)->format('Y-m-d') : 'N/A',
                            $po->supplier->name ?? 'N/A',
                            $po->expected_delivery_date ? Carbon::parse($po->expected_delivery_date)->format('Y-m-d') : 'N/A',
                            $po->details->sum('quantity'),
                            number_format($po->total_amount, 2),
                            $po->payment_status,
                            $po->status,
                        ]);
                    }
                    break;

                case 'customer':
                    fputcsv($handle, ['#', 'Customer Name', 'Phone', 'Email', 'Customer Type', 'Total Orders', 'Total Spent ($)', 'Reward Points', 'Status']);
                    $i = 1;
                    foreach ($data['records'] as $c) {
                        fputcsv($handle, [
                            $i++,
                            $c->name,
                            $c->phone ?? 'N/A',
                            $c->email ?? 'N/A',
                            ucfirst($c->customer_type ?? 'Regular'),
                            $c->total_orders ?? 0,
                            number_format($c->total_spent ?? 0, 2),
                            $c->points ?? 0,
                            $c->status ?? 'Active',
                        ]);
                    }
                    break;

                case 'supplier':
                    fputcsv($handle, ['#', 'Supplier Name', 'Contact Person', 'Phone', 'Email', 'Address', 'Total Purchase Orders', 'Total Sourced Amount ($)', 'Status']);
                    $i = 1;
                    foreach ($data['records'] as $s) {
                        fputcsv($handle, [
                            $i++,
                            $s->name,
                            $s->contact_name ?? 'N/A',
                            $s->phone ?? 'N/A',
                            $s->email ?? 'N/A',
                            $s->address ?? 'N/A',
                            $s->total_pos ?? 0,
                            number_format($s->total_sourced ?? 0, 2),
                            $s->status ?? 'Active',
                        ]);
                    }
                    break;

                case 'repair_service':
                    fputcsv($handle, ['#', 'Ticket Code', 'Date', 'Customer', 'Device / Model', 'Technician', 'Service Fee ($)', 'Parts Cost ($)', 'Total Cost ($)', 'Payment Status', 'Status']);
                    $i = 1;
                    foreach ($data['records'] as $rep) {
                        fputcsv($handle, [
                            $i++,
                            $rep->repair_code,
                            Carbon::parse($rep->created_at)->format('Y-m-d H:i'),
                            $rep->customer->name ?? 'Walk-in',
                            ($rep->device_type ?? '') . ' - ' . ($rep->model ?? ''),
                            $rep->technician->name ?? 'Unassigned',
                            number_format($rep->service_fee, 2),
                            number_format($rep->parts_total, 2),
                            number_format($rep->total_cost, 2),
                            $rep->payment_status ?? 'Unpaid',
                            $rep->status,
                        ]);
                    }
                    break;

                case 'warranty':
                    fputcsv($handle, ['#', 'Warranty Code', 'Product', 'Customer', 'Serial Number', 'Purchase Date', 'Expiry Date', 'Warranty (Months)', 'Claims Count', 'Status']);
                    $i = 1;
                    foreach ($data['records'] as $w) {
                        fputcsv($handle, [
                            $i++,
                            $w->warranty_code,
                            $w->product->name ?? ($w->product_name ?? 'N/A'),
                            $w->customer->name ?? 'N/A',
                            $w->serial_number ?? 'N/A',
                            $w->purchase_date ? Carbon::parse($w->purchase_date)->format('Y-m-d') : 'N/A',
                            $w->expiry_date ? Carbon::parse($w->expiry_date)->format('Y-m-d') : 'N/A',
                            $w->warranty_period_months,
                            $w->claims->count(),
                            $w->status,
                        ]);
                    }
                    break;

                case 'revenue':
                    fputcsv($handle, ['#', 'Date', 'POS Sales Revenue ($)', 'Repair Service Revenue ($)', 'Total Gross Revenue ($)', 'Cash Payments ($)', 'Digital / QR Payments ($)']);
                    $i = 1;
                    foreach ($data['records'] as $rev) {
                        fputcsv($handle, [
                            $i++,
                            $rev['date'],
                            number_format($rev['pos_revenue'], 2),
                            number_format($rev['repair_revenue'], 2),
                            number_format($rev['total_revenue'], 2),
                            number_format($rev['cash_revenue'], 2),
                            number_format($rev['digital_revenue'], 2),
                        ]);
                    }
                    break;

                case 'profit_loss':
                    fputcsv($handle, ['#', 'Date', 'Sales Revenue ($)', 'Cost of Goods ($)', 'Gross Profit ($)', 'Repair Revenue ($)', 'Repair Parts Cost ($)', 'Net Profit ($)', 'Margin (%)']);
                    $i = 1;
                    foreach ($data['records'] as $day) {
                        fputcsv($handle, [
                            $i++,
                            $day['date'],
                            number_format($day['revenue'], 2),
                            number_format($day['cost'], 2),
                            number_format($day['profit'], 2),
                            number_format($day['repair_revenue'] ?? 0, 2),
                            number_format($day['repair_parts_cost'] ?? 0, 2),
                            number_format($day['net_profit'] ?? $day['profit'], 2),
                            $day['margin'] . '%',
                        ]);
                    }
                    break;
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }

    /**
     * Print View for Reports (Feature #14 Print & PDF)
     */
    public function printReport(Request $request)
    {
        $reportType = $request->input('type', 'daily_sales');
        if ($reportType === 'sales') {
            $reportType = 'daily_sales';
        }

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $data = $this->buildReportData($reportType, $startDate, $endDate, $request);

        return view('reports.print', array_merge($data, [
            'reportType' => $reportType,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]));
    }

    /**
     * Centralized Builder for Report Calculations & Queries (All 12 Reports)
     */
    private function buildReportData($type, $startDate, $endDate, Request $request)
    {
        switch ($type) {
            case 'inventory':
                return $this->buildInventoryReport($request);
            case 'monthly_sales':
                return $this->buildMonthlySalesReport($startDate, $endDate, $request);
            case 'purchase':
                return $this->buildPurchaseReport($startDate, $endDate, $request);
            case 'customer':
                return $this->buildCustomerReport($startDate, $endDate, $request);
            case 'supplier':
                return $this->buildSupplierReport($startDate, $endDate, $request);
            case 'repair_service':
                return $this->buildRepairServiceReport($startDate, $endDate, $request);
            case 'warranty':
                return $this->buildWarrantyReport($startDate, $endDate, $request);
            case 'revenue':
                return $this->buildRevenueReport($startDate, $endDate, $request);
            case 'profit_loss':
                return $this->buildProfitLossReport($startDate, $endDate, $request);
            case 'best_selling':
                return $this->buildBestSellingReport($startDate, $endDate, $request);
            case 'low_stock':
                return $this->buildLowStockReport($request);
            case 'daily_sales':
            case 'sales':
            default:
                return $this->buildDailySalesReport($startDate, $endDate, $request);
        }
    }

    /**
     * 1. Daily Sales Report
     */
    private function buildDailySalesReport($startDate, $endDate, Request $request)
    {
        $query = Sale::with(['customer', 'user', 'details.product'])
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate);

        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('sale_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $records = $query->orderBy('sale_date', 'desc')->get();

        $totalRevenue = $records->sum('total_amount');
        $totalOrders = $records->count();
        $totalItems = $records->sum(function ($s) {
            return $s->details->sum('quantity');
        });
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 0;
        $totalDiscount = $records->sum('discount_amount');
        $totalTax = $records->sum('tax_amount');
        $cashSales = $records->where('payment_method', 'Cash')->sum('total_amount');
        $digitalSales = $totalRevenue - $cashSales;

        // Daily aggregated chart
        $dailyAggregates = $records->groupBy(function ($item) {
            return Carbon::parse($item->sale_date)->format('Y-m-d');
        })->map(function ($dayRecords, $date) {
            return [
                'date' => $date,
                'orders' => $dayRecords->count(),
                'revenue' => round($dayRecords->sum('total_amount'), 2),
            ];
        })->values();

        return [
            'summary' => [
                'total_revenue' => (float) $totalRevenue,
                'total_orders' => (int) $totalOrders,
                'total_items_sold' => (int) $totalItems,
                'average_order_value' => (float) $avgOrderValue,
                'total_discount' => (float) $totalDiscount,
                'total_tax' => (float) $totalTax,
                'cash_sales' => (float) $cashSales,
                'digital_sales' => (float) $digitalSales,
            ],
            'records' => $records,
            'chart' => [
                'labels' => $dailyAggregates->pluck('date'),
                'values' => $dailyAggregates->pluck('revenue'),
            ],
        ];
    }

    /**
     * 2. Monthly Sales Report
     */
    private function buildMonthlySalesReport($startDate, $endDate, Request $request)
    {
        $sales = Sale::with(['details'])
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->orderBy('sale_date', 'asc')
            ->get();

        $monthlyGroups = $sales->groupBy(function ($sale) {
            return Carbon::parse($sale->sale_date)->format('Y-m');
        });

        $records = [];
        foreach ($monthlyGroups as $month => $items) {
            $monthRev = $items->sum('total_amount');
            $ordersCount = $items->count();
            $itemsSold = $items->sum(function ($s) {
                return $s->details->sum('quantity');
            });
            $cash = $items->where('payment_method', 'Cash')->sum('total_amount');
            $digital = $monthRev - $cash;

            $records[] = [
                'month' => $month,
                'month_label' => Carbon::createFromFormat('Y-m', $month)->format('M Y'),
                'orders_count' => $ordersCount,
                'items_sold' => $itemsSold,
                'cash_total' => (float) $cash,
                'digital_total' => (float) $digital,
                'total_revenue' => (float) $monthRev,
                'avg_order_value' => $ordersCount > 0 ? round($monthRev / $ordersCount, 2) : 0,
            ];
        }

        $totalRevenue = collect($records)->sum('total_revenue');
        $totalOrders = collect($records)->sum('orders_count');
        $totalItems = collect($records)->sum('items_sold');
        $avgMonthlyRevenue = count($records) > 0 ? round($totalRevenue / count($records), 2) : 0;
        $bestMonth = collect($records)->sortByDesc('total_revenue')->first()['month_label'] ?? 'N/A';

        return [
            'summary' => [
                'total_revenue' => (float) $totalRevenue,
                'total_orders' => (int) $totalOrders,
                'total_items_sold' => (int) $totalItems,
                'monthly_average' => (float) $avgMonthlyRevenue,
                'best_performing_month' => $bestMonth,
            ],
            'records' => $records,
            'chart' => [
                'labels' => array_column($records, 'month_label'),
                'values' => array_column($records, 'total_revenue'),
            ],
        ];
    }

    /**
     * 3. Product Inventory Report
     */
    private function buildInventoryReport(Request $request)
    {
        $query = Product::with(['category', 'brand', 'supplier']);

        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id') && $request->brand_id !== 'all') {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('stock_status') && $request->stock_status !== 'all') {
            if ($request->stock_status === 'out_of_stock') {
                $query->where('stock_quantity', '<=', 0);
            } elseif ($request->stock_status === 'low_stock') {
                $query->where('stock_quantity', '>', 0)
                      ->whereColumn('stock_quantity', '<=', 'min_stock_alert');
            } elseif ($request->stock_status === 'in_stock') {
                $query->whereColumn('stock_quantity', '>', 'min_stock_alert');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        $records = $query->orderBy('name')->get();

        $totalProducts = $records->count();
        $totalUnits = $records->sum('stock_quantity');
        $totalCostValue = $records->sum(function ($p) {
            return $p->stock_quantity * $p->cost_price;
        });
        $totalRetailValue = $records->sum(function ($p) {
            return $p->stock_quantity * $p->selling_price;
        });
        $potentialProfit = max(0, $totalRetailValue - $totalCostValue);
        $lowStockCount = $records->where('stock_quantity', '>', 0)->filter(function ($p) {
            return $p->stock_quantity <= $p->min_stock_alert;
        })->count();
        $outOfStockCount = $records->where('stock_quantity', '<=', 0)->count();
        $inStockCount = max(0, $totalProducts - $lowStockCount - $outOfStockCount);

        return [
            'summary' => [
                'total_products' => (int) $totalProducts,
                'total_units' => (int) $totalUnits,
                'total_cost_value' => (float) round($totalCostValue, 2),
                'total_retail_value' => (float) round($totalRetailValue, 2),
                'potential_profit' => (float) round($potentialProfit, 2),
                'in_stock_count' => (int) $inStockCount,
                'low_stock_count' => (int) $lowStockCount,
                'out_of_stock_count' => (int) $outOfStockCount,
            ],
            'records' => $records,
            'chart' => [
                'labels' => ['In Stock', 'Low Stock', 'Out of Stock'],
                'values' => [$inStockCount, $lowStockCount, $outOfStockCount],
            ],
        ];
    }

    /**
     * 4. Low Stock Alert Report
     */
    private function buildLowStockReport(Request $request)
    {
        $query = Product::with(['category', 'brand', 'supplier'])
            ->whereColumn('stock_quantity', '<=', 'min_stock_alert');

        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $records = $query->orderBy('stock_quantity', 'asc')->get();

        $totalItems = $records->count();
        $outOfStock = $records->where('stock_quantity', '<=', 0)->count();
        $lowStock = $totalItems - $outOfStock;
        $totalDeficitUnits = $records->sum(function ($p) {
            return max(0, $p->min_stock_alert - $p->stock_quantity);
        });
        $estRestockCost = $records->sum(function ($p) {
            return max(0, $p->min_stock_alert - $p->stock_quantity) * $p->cost_price;
        });

        return [
            'summary' => [
                'critical_items_count' => (int) $totalItems,
                'out_of_stock_count' => (int) $outOfStock,
                'low_stock_count' => (int) $lowStock,
                'units_needed_to_restock' => (int) $totalDeficitUnits,
                'estimated_restock_cost' => (float) round($estRestockCost, 2),
            ],
            'records' => $records,
            'chart' => [
                'labels' => ['Out of Stock (0 units)', 'Low Stock (<= Min Alert)'],
                'values' => [$outOfStock, $lowStock],
            ],
        ];
    }

    /**
     * 5. Best Selling Products Report
     */
    private function buildBestSellingReport($startDate, $endDate, Request $request)
    {
        $saleDetails = SaleDetail::with(['product.category', 'product.brand', 'sale'])
            ->whereHas('sale', function ($q) use ($startDate, $endDate) {
                $q->whereDate('sale_date', '>=', $startDate)
                  ->whereDate('sale_date', '<=', $endDate);
            })
            ->get();

        $grouped = $saleDetails->groupBy('product_id')->map(function ($items, $productId) {
            $product = $items->first()->product;
            $unitsSold = $items->sum('quantity');
            $totalRevenue = $items->sum('subtotal');
            $costPrice = $product ? (float) $product->cost_price : 0;
            $grossProfit = $totalRevenue - ($unitsSold * $costPrice);

            return [
                'product_id' => $productId,
                'name' => $product->name ?? 'Unknown Product',
                'sku' => $product->sku ?? 'N/A',
                'category' => $product->category->name ?? 'N/A',
                'brand' => $product->brand->brand_name ?? ($product->brand->name ?? 'N/A'),
                'unit_price' => $product ? (float) $product->selling_price : 0,
                'units_sold' => (int) $unitsSold,
                'total_revenue' => (float) round($totalRevenue, 2),
                'gross_profit' => (float) round($grossProfit, 2),
                'current_stock' => $product ? (int) $product->stock_quantity : 0,
            ];
        })->sortByDesc('units_sold')->values();

        $totalUnitsSold = $grouped->sum('units_sold');
        $totalBestSellingRevenue = $grouped->sum('total_revenue');
        $totalGrossProfit = $grouped->sum('gross_profit');
        $topProduct = $grouped->first()['name'] ?? 'N/A';

        // Chart: Top 7 products
        $top7 = $grouped->take(7);

        return [
            'summary' => [
                'total_products_sold' => $grouped->count(),
                'total_units_sold' => (int) $totalUnitsSold,
                'total_revenue' => (float) round($totalBestSellingRevenue, 2),
                'total_gross_profit' => (float) round($totalGrossProfit, 2),
                'top_selling_product' => $topProduct,
            ],
            'records' => $grouped,
            'chart' => [
                'labels' => $top7->pluck('name'),
                'values' => $top7->pluck('units_sold'),
            ],
        ];
    }

    /**
     * 6. Purchase Report (Feature #7 / POs)
     */
    private function buildPurchaseReport($startDate, $endDate, Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'user', 'details.product'])
            ->whereDate('order_date', '>=', $startDate)
            ->whereDate('order_date', '<=', $endDate);

        if ($request->filled('supplier_id') && $request->supplier_id !== 'all') {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('po_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $records = $query->orderBy('order_date', 'desc')->get();

        $totalSpent = $records->sum('total_amount');
        $totalPOs = $records->count();
        $receivedPOs = $records->where('status', 'Received')->count();
        $pendingPOs = $records->where('status', 'Pending')->count();
        $totalItemsOrdered = $records->sum(function ($po) {
            return $po->details->sum('quantity');
        });

        // Supplier distribution
        $bySupplier = $records->groupBy(function ($po) {
            return $po->supplier->name ?? 'Other';
        })->map(function ($items) {
            return $items->sum('total_amount');
        });

        return [
            'summary' => [
                'total_purchase_amount' => (float) round($totalSpent, 2),
                'total_purchase_orders' => (int) $totalPOs,
                'received_orders' => (int) $receivedPOs,
                'pending_orders' => (int) $pendingPOs,
                'total_items_ordered' => (int) $totalItemsOrdered,
            ],
            'records' => $records,
            'chart' => [
                'labels' => $bySupplier->keys(),
                'values' => $bySupplier->values(),
            ],
        ];
    }

    /**
     * 7. Customer Report
     */
    private function buildCustomerReport($startDate, $endDate, Request $request)
    {
        $customers = Customer::with(['sales' => function ($q) use ($startDate, $endDate) {
            $q->whereDate('sale_date', '>=', $startDate)
              ->whereDate('sale_date', '<=', $endDate);
        }])->get();

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $customers = $customers->filter(function ($c) use ($search) {
                return str_contains(strtolower($c->name), $search) || str_contains(strtolower($c->phone ?? ''), $search);
            });
        }

        $records = $customers->map(function ($c) {
            $salesCount = $c->sales->count();
            $totalSpent = $c->sales->sum('total_amount');
            $c->total_orders = $salesCount;
            $c->total_spent = (float) $totalSpent;
            return $c;
        })->sortByDesc('total_spent')->values();

        $totalCustomers = $records->count();
        $activeWithSales = $records->where('total_orders', '>', 0)->count();
        $totalCustomerRevenue = $records->sum('total_spent');
        $avgSpend = $activeWithSales > 0 ? round($totalCustomerRevenue / $activeWithSales, 2) : 0;
        $topCustomer = $records->first()->name ?? 'N/A';

        // Top 5 customers chart
        $top5 = $records->take(5);

        return [
            'summary' => [
                'total_customers' => (int) $totalCustomers,
                'active_purchasers' => (int) $activeWithSales,
                'total_customer_revenue' => (float) round($totalCustomerRevenue, 2),
                'average_spend_per_customer' => (float) round($avgSpend, 2),
                'top_customer' => $topCustomer,
            ],
            'records' => $records,
            'chart' => [
                'labels' => $top5->pluck('name'),
                'values' => $top5->pluck('total_spent'),
            ],
        ];
    }

    /**
     * 8. Supplier Report
     */
    private function buildSupplierReport($startDate, $endDate, Request $request)
    {
        $suppliers = Supplier::with(['purchaseOrders' => function ($q) use ($startDate, $endDate) {
            $q->whereDate('order_date', '>=', $startDate)
              ->whereDate('order_date', '<=', $endDate);
        }])->get();

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $suppliers = $suppliers->filter(function ($s) use ($search) {
                return str_contains(strtolower($s->name), $search) || str_contains(strtolower($s->phone ?? ''), $search);
            });
        }

        $records = $suppliers->map(function ($s) {
            $posCount = $s->purchaseOrders->count();
            $totalSourced = $s->purchaseOrders->sum('total_amount');
            $s->total_pos = $posCount;
            $s->total_sourced = (float) $totalSourced;
            return $s;
        })->sortByDesc('total_sourced')->values();

        $totalSuppliers = $records->count();
        $activeSuppliers = $records->where('total_pos', '>', 0)->count();
        $grandSourced = $records->sum('total_sourced');
        $topSupplier = $records->first()->name ?? 'N/A';

        $top5 = $records->take(5);

        return [
            'summary' => [
                'total_suppliers' => (int) $totalSuppliers,
                'active_suppliers' => (int) $activeSuppliers,
                'total_sourced_amount' => (float) round($grandSourced, 2),
                'top_supplier' => $topSupplier,
            ],
            'records' => $records,
            'chart' => [
                'labels' => $top5->pluck('name'),
                'values' => $top5->pluck('total_sourced'),
            ],
        ];
    }

    /**
     * 9. Repair Service Report
     */
    private function buildRepairServiceReport($startDate, $endDate, Request $request)
    {
        $query = RepairService::with(['customer', 'technician', 'parts.product'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('repair_code', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $records = $query->orderBy('created_at', 'desc')->get();

        $totalJobs = $records->count();
        $completedJobs = $records->whereIn('status', ['Completed', 'Delivered'])->count();
        $pendingJobs = $records->whereIn('status', ['Pending', 'In Progress', 'Diagnosing'])->count();
        $totalRepairRevenue = $records->sum('total_cost');
        $totalServiceFee = $records->sum('service_fee');
        $totalPartsCost = $records->sum('parts_total');
        $netRepairProfit = $totalRepairRevenue - $totalPartsCost;

        $statusGroup = $records->groupBy('status')->map->count();

        return [
            'summary' => [
                'total_repair_jobs' => (int) $totalJobs,
                'completed_jobs' => (int) $completedJobs,
                'pending_jobs' => (int) $pendingJobs,
                'total_repair_revenue' => (float) round($totalRepairRevenue, 2),
                'total_service_fee' => (float) round($totalServiceFee, 2),
                'total_parts_cost' => (float) round($totalPartsCost, 2),
                'net_repair_profit' => (float) round($netRepairProfit, 2),
            ],
            'records' => $records,
            'chart' => [
                'labels' => $statusGroup->keys(),
                'values' => $statusGroup->values(),
            ],
        ];
    }

    /**
     * 10. Warranty & Claims Report
     */
    private function buildWarrantyReport($startDate, $endDate, Request $request)
    {
        $query = Warranty::with(['customer', 'product', 'claims'])
            ->whereDate('purchase_date', '>=', $startDate)
            ->whereDate('purchase_date', '<=', $endDate);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('warranty_code', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('product_name', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $records = $query->orderBy('purchase_date', 'desc')->get();

        $totalWarranties = $records->count();
        $today = Carbon::today();
        $activeWarranties = $records->filter(function ($w) use ($today) {
            return strtolower($w->status) === 'active' && (!$w->expiry_date || Carbon::parse($w->expiry_date)->gte($today));
        })->count();
        $expiredWarranties = $totalWarranties - $activeWarranties;

        $totalClaims = WarrantyClaim::whereDate('claim_date', '>=', $startDate)
            ->whereDate('claim_date', '<=', $endDate)
            ->count();

        $pendingClaims = WarrantyClaim::whereDate('claim_date', '>=', $startDate)
            ->whereDate('claim_date', '<=', $endDate)
            ->whereIn('status', ['Pending', 'In Review', 'Received'])
            ->count();

        $resolvedClaims = WarrantyClaim::whereDate('claim_date', '>=', $startDate)
            ->whereDate('claim_date', '<=', $endDate)
            ->whereIn('status', ['Approved', 'Resolved', 'Replaced', 'Completed'])
            ->count();

        $claimRate = $totalWarranties > 0 ? round(($totalClaims / $totalWarranties) * 100, 1) : 0;

        return [
            'summary' => [
                'total_warranties' => (int) $totalWarranties,
                'active_warranties' => (int) $activeWarranties,
                'expired_warranties' => (int) $expiredWarranties,
                'total_claims' => (int) $totalClaims,
                'pending_claims' => (int) $pendingClaims,
                'resolved_claims' => (int) $resolvedClaims,
                'claim_rate' => (float) $claimRate,
            ],
            'records' => $records,
            'chart' => [
                'labels' => ['Active Warranties', 'Expired Warranties', 'Claims Filed'],
                'values' => [$activeWarranties, $expiredWarranties, $totalClaims],
            ],
        ];
    }

    /**
     * 11. Revenue Report (Unified Sales + Repair Services)
     */
    private function buildRevenueReport($startDate, $endDate, Request $request)
    {
        $sales = Sale::whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->get();

        $repairs = RepairService::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

        $dailyMap = [];

        foreach ($sales as $s) {
            $day = Carbon::parse($s->sale_date)->format('Y-m-d');
            if (!isset($dailyMap[$day])) {
                $dailyMap[$day] = [
                    'date' => $day,
                    'pos_revenue' => 0,
                    'repair_revenue' => 0,
                    'total_revenue' => 0,
                    'cash_revenue' => 0,
                    'digital_revenue' => 0,
                ];
            }
            $dailyMap[$day]['pos_revenue'] += (float) $s->total_amount;
            $dailyMap[$day]['total_revenue'] += (float) $s->total_amount;
            if ($s->payment_method === 'Cash') {
                $dailyMap[$day]['cash_revenue'] += (float) $s->total_amount;
            } else {
                $dailyMap[$day]['digital_revenue'] += (float) $s->total_amount;
            }
        }

        foreach ($repairs as $r) {
            $day = Carbon::parse($r->created_at)->format('Y-m-d');
            if (!isset($dailyMap[$day])) {
                $dailyMap[$day] = [
                    'date' => $day,
                    'pos_revenue' => 0,
                    'repair_revenue' => 0,
                    'total_revenue' => 0,
                    'cash_revenue' => 0,
                    'digital_revenue' => 0,
                ];
            }
            $dailyMap[$day]['repair_revenue'] += (float) $r->total_cost;
            $dailyMap[$day]['total_revenue'] += (float) $r->total_cost;
            $dailyMap[$day]['cash_revenue'] += (float) $r->total_cost; // default repair cash
        }

        ksort($dailyMap);
        $records = array_values($dailyMap);

        $totalPosRevenue = $sales->sum('total_amount');
        $totalRepairRevenue = $repairs->sum('total_cost');
        $grandTotalRevenue = $totalPosRevenue + $totalRepairRevenue;
        $totalCash = collect($records)->sum('cash_revenue');
        $totalDigital = collect($records)->sum('digital_revenue');

        return [
            'summary' => [
                'gross_total_revenue' => (float) round($grandTotalRevenue, 2),
                'pos_sales_revenue' => (float) round($totalPosRevenue, 2),
                'repair_service_revenue' => (float) round($totalRepairRevenue, 2),
                'cash_collected' => (float) round($totalCash, 2),
                'digital_collected' => (float) round($totalDigital, 2),
            ],
            'records' => $records,
            'chart' => [
                'labels' => array_column($records, 'date'),
                'values' => array_column($records, 'total_revenue'),
            ],
        ];
    }

    /**
     * 12. Profit & Loss Report
     */
    private function buildProfitLossReport($startDate, $endDate, Request $request)
    {
        $sales = Sale::with(['details.product'])
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->get();

        $totalRevenue = 0;
        $totalCOGS = 0;
        $dailyMap = [];

        foreach ($sales as $sale) {
            $day = Carbon::parse($sale->sale_date)->format('Y-m-d');
            if (!isset($dailyMap[$day])) {
                $dailyMap[$day] = [
                    'date' => $day,
                    'orders_count' => 0,
                    'revenue' => 0,
                    'cost' => 0,
                    'profit' => 0,
                    'repair_revenue' => 0,
                    'repair_parts_cost' => 0,
                    'net_profit' => 0,
                    'margin' => 0,
                ];
            }

            $dailyMap[$day]['orders_count']++;
            $dailyMap[$day]['revenue'] += (float) $sale->total_amount;
            $totalRevenue += (float) $sale->total_amount;

            $saleCost = 0;
            foreach ($sale->details as $item) {
                $cost = $item->product ? ($item->product->cost_price * $item->quantity) : 0;
                $saleCost += $cost;
            }
            $dailyMap[$day]['cost'] += $saleCost;
            $totalCOGS += $saleCost;
        }

        // Repair Service Revenue & Parts Cost
        $repairRevenue = RepairService::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('total_cost');

        $repairPartsCost = RepairPart::with('product')
            ->whereHas('repairService', function ($q) use ($startDate, $endDate) {
                $q->whereDate('created_at', '>=', $startDate)
                  ->whereDate('created_at', '<=', $endDate);
            })->get()->sum(function ($part) {
                return $part->product ? ($part->quantity * $part->product->cost_price) : ($part->subtotal ?? 0);
            });

        $grossSalesProfit = $totalRevenue - $totalCOGS;
        $netRepairProfit = $repairRevenue - $repairPartsCost;
        $netTotalRevenue = $totalRevenue + $repairRevenue;
        $netTotalCosts = $totalCOGS + $repairPartsCost;
        $netProfit = $netTotalRevenue - $netTotalCosts;
        $overallMargin = $netTotalRevenue > 0 ? round(($netProfit / $netTotalRevenue) * 100, 1) : 0;

        foreach ($dailyMap as &$d) {
            $d['profit'] = round($d['revenue'] - $d['cost'], 2);
            $d['net_profit'] = $d['profit'];
            $d['margin'] = $d['revenue'] > 0 ? round(($d['profit'] / $d['revenue']) * 100, 1) : 0;
        }
        ksort($dailyMap);
        $records = array_values($dailyMap);

        return [
            'summary' => [
                'sales_revenue' => (float) round($totalRevenue, 2),
                'cost_of_goods_sold' => (float) round($totalCOGS, 2),
                'gross_sales_profit' => (float) round($grossSalesProfit, 2),
                'repair_revenue' => (float) round($repairRevenue, 2),
                'repair_parts_cost' => (float) round($repairPartsCost, 2),
                'net_repair_profit' => (float) round($netRepairProfit, 2),
                'net_total_revenue' => (float) round($netTotalRevenue, 2),
                'net_total_costs' => (float) round($netTotalCosts, 2),
                'net_profit' => (float) round($netProfit, 2),
                'overall_margin' => (float) $overallMargin,
            ],
            'records' => $records,
            'chart' => [
                'labels' => array_column($records, 'date'),
                'revenue' => array_column($records, 'revenue'),
                'profit' => array_column($records, 'profit'),
            ],
        ];
    }
}
