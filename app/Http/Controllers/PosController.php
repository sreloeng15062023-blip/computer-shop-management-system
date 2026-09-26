<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;
use App\Models\InventoryTransaction;
use App\Http\Requests\StoreSaleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class PosController extends Controller
{
    /**
     * Display the POS screen (Feature #9 Sales Management)
     */
    public function index(Request $request)
    {
        // 1. Fetch categories for filtering
        $categories = Category::withCount('products')->get();

        // 2. Fetch products for catalog grid with category & brand
        $productsQuery = Product::with(['category', 'brand'])
            ->where('status', '!=', 'Discontinued');

        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $productsQuery->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $productsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        $products = $productsQuery->orderBy('name', 'asc')->get();

        // 3. Fetch active customers with loyalty points
        $customers = Customer::where('status', 'Active')
            ->orderBy('name', 'asc')
            ->get();

        // 4. Fetch recent sales for Sales Order List in Mockup
        $recentSales = Sale::with(['customer', 'user', 'details.product'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // 5. Generate next Sale Number preview (e.g. POS-2025-0099)
        $latestSale = Sale::latest('id')->first();
        $nextNumber = $latestSale ? ($latestSale->id + 1) : 1;
        $year = date('Y');
        $suggestedSaleNumber = 'POS-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // 6. Summary stats for POS
        $todaySalesCount = Sale::whereDate('sale_date', today())->count();
        $todayTotalRevenue = Sale::whereDate('sale_date', today())->where('payment_status', 'Paid')->sum('total_amount');

        return view('pos-sales', compact(
            'categories',
            'products',
            'customers',
            'recentSales',
            'suggestedSaleNumber',
            'todaySalesCount',
            'todayTotalRevenue'
        ));
    }

    /**
     * Checkout process (Step 4.2: PosController@checkout)
     * - Create Sale
     * - Decrement StockQuantity
     * - Record Stock Out in inventory_transactions
     * - Add Loyalty Points to Customer
     * - Generate Invoice & Payment records
     */
    public function checkout(StoreSaleRequest $request)
    {
        $validated = $request->validator ? $request->validated() : $request->all();

        DB::beginTransaction();
        try {
            $userId = Auth::id() ?? 1; // Default to admin if unauthenticated
            $customerId = $validated['customer_id'] ?? null;
            $items = $validated['items'];

            // 1. Calculate Financials
            $subtotal = 0;
            $saleItemsData = [];

            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Verify stock availability
                if ($product->stock_quantity < $item['quantity']) {
                    throw new Exception("ទំនិញ '{$product->name}' នៅសល់ត្រឹមតែ {$product->stock_quantity} ប៉ុណ្ណោះ មិនគ្រប់គ្រាន់តាមចំនួនបញ្ជាទិញឡើយ។");
                }

                $itemSubtotal = $product->selling_price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $saleItemsData[] = [
                    'product'      => $product,
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $product->selling_price,
                    'subtotal'     => $itemSubtotal,
                    'warranty'     => $product->warranty_period_months ?? 12,
                ];
            }

            $discountPercent = floatval($validated['discount_percentage'] ?? 0);
            $discountAmount = round(($subtotal * $discountPercent) / 100, 2);

            $taxPercent = floatval($validated['tax_percentage'] ?? 10);
            $taxableAmount = max(0, $subtotal - $discountAmount);
            $taxAmount = round(($taxableAmount * $taxPercent) / 100, 2);

            $totalAmount = round($taxableAmount + $taxAmount, 2);
            $paidAmount = isset($validated['paid_amount']) && $validated['paid_amount'] > 0
                ? floatval($validated['paid_amount'])
                : $totalAmount;

            $changeAmount = max(0, round($paidAmount - $totalAmount, 2));
            $paymentStatus = $paidAmount >= $totalAmount ? 'Paid' : ($paidAmount > 0 ? 'Partial' : 'Pending');

            // 2. Generate Sale Number (e.g. POS-2025-0098)
            $nextSaleId = (Sale::max('id') ?? 0) + 1;
            $saleNumber = 'POS-' . date('Y') . '-' . str_pad($nextSaleId, 4, '0', STR_PAD_LEFT);

            // 3. Create Sale Record
            $sale = Sale::create([
                'sale_number'         => $saleNumber,
                'customer_id'         => $customerId,
                'user_id'             => $userId,
                'sale_date'           => now(),
                'subtotal'            => $subtotal,
                'discount_percentage' => $discountPercent,
                'discount_amount'     => $discountAmount,
                'tax_percentage'      => $taxPercent,
                'tax_amount'          => $taxAmount,
                'total_amount'        => $totalAmount,
                'paid_amount'         => $paidAmount,
                'change_amount'       => $changeAmount,
                'payment_method'      => $validated['payment_method'],
                'payment_status'      => $paymentStatus,
                'status'              => 'Completed',
                'notes'               => $validated['notes'] ?? null,
            ]);

            // 4. Save Sale Details & Decrement Product Stock & Log Inventory Transaction (Stock Out)
            foreach ($saleItemsData as $itemData) {
                $product = $itemData['product'];
                $qtySold = $itemData['quantity'];
                $stockBefore = $product->stock_quantity;
                $stockAfter = $stockBefore - $qtySold;

                // Create Sale Detail item
                SaleDetail::create([
                    'sale_id'         => $sale->id,
                    'product_id'      => $product->id,
                    'quantity'        => $qtySold,
                    'unit_price'      => $itemData['unit_price'],
                    'subtotal'        => $itemData['subtotal'],
                    'warranty_months' => $itemData['warranty'],
                ]);

                // Decrement Stock
                $product->stock_quantity = $stockAfter;
                if ($stockAfter <= 0) {
                    $product->status = 'Out of Stock';
                }
                $product->save();

                // Log Stock Out in inventory_transactions
                InventoryTransaction::create([
                    'product_id'       => $product->id,
                    'user_id'          => $userId,
                    'transaction_type' => 'Stock Out',
                    'quantity'         => -$qtySold,
                    'stock_before'     => $stockBefore,
                    'stock_after'      => $stockAfter,
                    'reference_type'   => 'Sale',
                    'reference_id'     => $sale->id,
                    'reason'           => "POS Checkout Sale #{$saleNumber}",
                ]);
            }

            // 5. Reward Loyalty Points to Customer (1 point per $10 spent)
            if ($customerId) {
                $customer = Customer::find($customerId);
                if ($customer) {
                    $earnedPoints = intval(floor($totalAmount / 10));
                    $customer->increment('points', $earnedPoints);
                }
            }

            // 6. Generate Invoice Number & Create Invoice Record
            $nextInvoiceId = (Invoice::max('id') ?? 0) + 1;
            $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($nextInvoiceId, 4, '0', STR_PAD_LEFT);
            $balanceDue = max(0, round($totalAmount - $paidAmount, 2));

            $invoice = Invoice::create([
                'invoice_number'  => $invoiceNumber,
                'sale_id'         => $sale->id,
                'customer_id'     => $customerId,
                'user_id'         => $userId,
                'invoice_date'    => now(),
                'due_date'        => now()->addDays(7),
                'subtotal'        => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_amount'      => $taxAmount,
                'total_amount'    => $totalAmount,
                'paid_amount'     => min($paidAmount, $totalAmount),
                'balance_due'     => $balanceDue,
                'payment_method'  => $validated['payment_method'],
                'status'          => $balanceDue == 0 ? 'Paid' : 'Pending',
                'notes'           => $validated['notes'] ?? 'Auto-generated invoice from POS sale',
            ]);

            // 7. Auto-create Payment Record
            if ($paidAmount > 0) {
                $nextPaymentId = (Payment::max('id') ?? 0) + 1;
                $paymentNumber = 'PAY-' . date('Y') . '-' . str_pad($nextPaymentId, 4, '0', STR_PAD_LEFT);

                Payment::create([
                    'payment_number'        => $paymentNumber,
                    'sale_id'               => $sale->id,
                    'invoice_id'            => $invoice->id,
                    'customer_id'           => $customerId,
                    'user_id'               => $userId,
                    'amount'                => min($paidAmount, $totalAmount),
                    'payment_method'        => $validated['payment_method'],
                    'payment_date'          => now(),
                    'transaction_reference' => $validated['payment_method'] === 'ABA' ? 'ABA-' . strtoupper(uniqid()) : null,
                    'status'                => 'Completed',
                    'notes'                 => 'Direct payment at POS counter',
                ]);
            }

            DB::commit();

            // Load full relationships for receipt response
            $sale->load(['customer', 'user', 'details.product', 'invoice']);

            return response()->json([
                'success' => true,
                'message' => 'ការលក់ទំនិញបានជោគជ័យ (Sale completed successfully)',
                'sale'    => $sale,
                'receipt' => [
                    'sale_number'     => $sale->sale_number,
                    'invoice_number'  => $invoice->invoice_number,
                    'date'            => $sale->sale_date->format('Y-m-d h:i A'),
                    'cashier'         => $sale->user->name ?? 'Sales Staff',
                    'customer_name'   => $sale->customer->name ?? 'Walk-in Customer',
                    'customer_phone'  => $sale->customer->phone ?? 'N/A',
                    'customer_points' => $sale->customer->points ?? 0,
                    'items'           => $sale->details->map(function ($d) {
                        return [
                            'name'     => $d->product->name,
                            'quantity' => $d->quantity,
                            'price'    => number_format($d->unit_price, 2),
                            'total'    => number_format($d->subtotal, 2),
                        ];
                    }),
                    'subtotal'        => number_format($sale->subtotal, 2),
                    'discount_amount' => number_format($sale->discount_amount, 2),
                    'tax_amount'      => number_format($sale->tax_amount, 2),
                    'total_amount'    => number_format($sale->total_amount, 2),
                    'paid_amount'     => number_format($sale->paid_amount, 2),
                    'change_amount'   => number_format($sale->change_amount, 2),
                    'payment_method'  => $sale->payment_method,
                    'barcode'         => $sale->sale_number,
                ]
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'បរាជ័យក្នុងការលក់: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Get Receipt Data JSON
     */
    public function receipt($id)
    {
        $sale = Sale::with(['customer', 'user', 'details.product', 'invoice'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'receipt' => [
                'sale_number'     => $sale->sale_number,
                'invoice_number'  => $sale->invoice->invoice_number ?? $sale->sale_number,
                'date'            => $sale->sale_date->format('Y-m-d h:i A'),
                'cashier'         => $sale->user->name ?? 'Sales Staff',
                'customer_name'   => $sale->customer->name ?? 'Walk-in Customer',
                'customer_phone'  => $sale->customer->phone ?? 'N/A',
                'customer_points' => $sale->customer->points ?? 0,
                'items'           => $sale->details->map(function ($d) {
                    return [
                        'name'     => $d->product->name,
                        'quantity' => $d->quantity,
                        'price'    => number_format($d->unit_price, 2),
                        'total'    => number_format($d->subtotal, 2),
                    ];
                }),
                'subtotal'        => number_format($sale->subtotal, 2),
                'discount_amount' => number_format($sale->discount_amount, 2),
                'tax_amount'      => number_format($sale->tax_amount, 2),
                'total_amount'    => number_format($sale->total_amount, 2),
                'paid_amount'     => number_format($sale->paid_amount, 2),
                'change_amount'   => number_format($sale->change_amount, 2),
                'payment_method'  => $sale->payment_method,
                'barcode'         => $sale->sale_number,
            ]
        ]);
    }
}
