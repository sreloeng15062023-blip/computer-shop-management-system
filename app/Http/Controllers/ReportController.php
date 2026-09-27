<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\RepairService;
use App\Models\RepairPart;
use App\Models\Warranty;
use App\Models\WarrantyClaim;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display Report Management View (Feature #14)
     */
    public function index(Request $request)
    {
        $reportType = $request->input('type', 'sales'); // 'sales', 'inventory', 'profit_loss', 'warranty'
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        // Process data based on requested report type
        $data = $this->buildReportData($reportType, $startDate, $endDate, $request);

        // Fetch categories and brands for filter dropdowns
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('brand_name')->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'reportType' => $reportType,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'summary' => $data['summary'],
                'records' => $data['records'],
                'chart' => $data['chart'] ?? null,
            ]);
        }

        return view('reports', array_merge($data, [
            'reportType' => $reportType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'categories' => $categories,
            'brands' => $brands,
        ]));
    }

    /**
     * Get Report Data via AJAX Endpoint
     */
    public function getReportData(Request $request)
    {
        $reportType = $request->input('type', 'sales');
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
     * Export Report to Excel / CSV
     */
    public function export(Request $request)
    {
        $reportType = $request->input('type', 'sales');
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $data = $this->buildReportData($reportType, $startDate, $endDate, $request);
        $fileName = 'TECHZONE_' . ucfirst($reportType) . '_Report_' . date('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () use ($reportType, $data, $startDate, $endDate) {
            $handle = fopen('php://output', 'w');
            
            // Output UTF-8 BOM for Microsoft Excel compatibility
            fputs($handle, "\xEF\xBB\xBF");

            // Company Title and Header
            fputcsv($handle, ['TECHZONE Computer Shop Management System']);
            fputcsv($handle, [strtoupper($reportType) . ' REPORT', 'Date Range:', $startDate . ' to ' . $endDate]);
            fputcsv($handle, ['Generated At:', date('Y-m-d H:i:s')]);
            fputcsv($handle, []); // Blank line

            // Summary Section
            fputcsv($handle, ['--- SUMMARY METRICS ---']);
            foreach ($data['summary'] as $key => $val) {
                fputcsv($handle, [ucwords(str_replace('_', ' ', $key)), is_numeric($val) ? number_format($val, 2) : $val]);
            }
            fputcsv($handle, []); // Blank line

            // Detail Table Header & Rows
            fputcsv($handle, ['--- DETAILED RECORDS ---']);
            if ($reportType === 'sales') {
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
            } elseif ($reportType === 'inventory') {
                fputcsv($handle, ['#', 'Product Name', 'SKU', 'Category', 'Brand', 'Cost ($)', 'Price ($)', 'In Stock', 'Min Alert', 'Total Cost Value ($)', 'Total Retail Value ($)', 'Status']);
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
            } elseif ($reportType === 'profit_loss') {
                fputcsv($handle, ['#', 'Date', 'Orders Count', 'Gross Sales ($)', 'Cost of Goods ($)', 'Gross Profit ($)', 'Margin (%)']);
                $i = 1;
                foreach ($data['records'] as $day) {
                    fputcsv($handle, [
                        $i++,
                        $day['date'],
                        $day['orders_count'],
                        number_format($day['revenue'], 2),
                        number_format($day['cost'], 2),
                        number_format($day['profit'], 2),
                        $day['margin'] . '%',
                    ]);
                }
            } elseif ($reportType === 'warranty') {
                fputcsv($handle, ['#', 'Warranty Code', 'Product', 'Customer', 'Serial Number', 'Purchase Date', 'Expiry Date', 'Warranty (Months)', 'Claims Count', 'Status']);
                $i = 1;
                foreach ($data['records'] as $w) {
                    fputcsv($handle, [
                        $i++,
                        $w->warranty_code,
                        $w->product->name ?? $w->product_name,
                        $w->customer->name ?? 'N/A',
                        $w->serial_number ?? 'N/A',
                        $w->purchase_date ? Carbon::parse($w->purchase_date)->format('Y-m-d') : 'N/A',
                        $w->expiry_date ? Carbon::parse($w->expiry_date)->format('Y-m-d') : 'N/A',
                        $w->warranty_period_months,
                        $w->claims->count(),
                        $w->status,
                    ]);
                }
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
     * Print View for Reports
     */
    public function printReport(Request $request)
    {
        $reportType = $request->input('type', 'sales');
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
     * Centralized Builder for Report Calculations & Queries
     */
    private function buildReportData($type, $startDate, $endDate, Request $request)
    {
        switch ($type) {
            case 'inventory':
                return $this->buildInventoryReport($request);
            case 'profit_loss':
                return $this->buildProfitLossReport($startDate, $endDate, $request);
            case 'warranty':
                return $this->buildWarrantyReport($startDate, $endDate, $request);
            case 'sales':
            default:
                return $this->buildSalesReport($startDate, $endDate, $request);
        }
    }

    /**
     * 1. Daily Sales Report
     */
    private function buildSalesReport($startDate, $endDate, Request $request)
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

        // Calculate summary
        $totalRevenue = $records->sum('total_amount');
        $totalOrders = $records->count();
        $totalItems = $records->sum(function ($s) {
            return $s->details->sum('quantity');
        });
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 0;
        $totalDiscount = $records->sum('discount_amount');
        $totalTax = $records->sum('tax_amount');

        // Cash vs Digital breakdown
        $cashSales = $records->where('payment_method', 'Cash')->sum('total_amount');
        $digitalSales = $totalRevenue - $cashSales;

        // Daily chart data
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
     * 2. Inventory & Stock Valuation Report
     */
    private function buildInventoryReport(Request $request)
    {
        $query = Product::with(['category', 'brand']);

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
     * 3. Profit & Loss Report
     */
    private function buildProfitLossReport($startDate, $endDate, Request $request)
    {
        $sales = Sale::with(['details.product'])
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->get();

        // Calculate Revenue, COGS, and Gross Profit
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

        // Finalize daily profit map
        foreach ($dailyMap as &$d) {
            $d['profit'] = round($d['revenue'] - $d['cost'], 2);
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

    /**
     * 4. Warranty & Claims Report
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
}
