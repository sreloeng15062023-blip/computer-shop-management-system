<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use App\Http\Requests\StoreStockAdjustmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryTransactionController extends Controller
{
    /**
     * =========================================================================
     * 1. INDEX: បង្ហាញបញ្ជីប្រវត្តិ និងចរន្តស្តុកទាំងអស់ (Inventory Logs & History)
     * =========================================================================
     * Frontend ហៅមកកាន់: GET /inventory-transactions ឬ GET /api/inventory-transactions
     */
    public function index(Request $request)
    {
        // 1. Query សម្រាប់ Product Inventory Table (Main Table ក្នុងរូប)
        $prodQuery = Product::with(['category', 'brand', 'images']);

        if ($request->filled('search')) {
            $search = $request->search;
            $prodQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $prodQuery->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $prodQuery->where('brand_id', $request->brand_id);
        }

        if ($request->filled('status')) {
            $prodQuery->where('status', $request->status);
        }

        $productItems = $prodQuery->latest('id')->paginate(10)->withQueryString();

        // 2. Query សម្រាប់ Inventory History (Transactions Log Tab)
        $txQuery = InventoryTransaction::with(['product.category', 'product.brand', 'user']);

        if ($request->filled('tx_search')) {
            $txSearch = $request->tx_search;
            $txQuery->where(function ($q) use ($txSearch) {
                $q->where('reason', 'like', "%{$txSearch}%")
                  ->orWhereHas('product', function ($pq) use ($txSearch) {
                      $pq->where('name', 'like', "%{$txSearch}%")
                         ->orWhere('sku', 'like', "%{$txSearch}%");
                  });
            });
        }

        if ($request->filled('transaction_type')) {
            $txQuery->where('transaction_type', $request->transaction_type);
        }

        if ($request->filled('date_from')) {
            $txQuery->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $txQuery->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $txQuery->latest('id')->paginate(10, ['*'], 'tx_page')->withQueryString();

        // 3. គណនាស្ថិតិ 5 Stat Cards ដូចរូបភាពបេះបិទ
        $totalProducts       = Product::count();
        $activeCount         = Product::where('status', '!=', 'Discontinued')->count();
        $inactiveCount       = Product::where('status', 'Discontinued')->count();
        $totalStockQuantity  = (int)Product::sum('stock_quantity');
        $lowStockCount       = Product::where('status', 'Low Stock')->count();
        $outOfStockCount     = Product::where('status', 'Out of Stock')->count();
        $availableCount      = Product::where('status', 'In Stock')->count();
        $totalStockValue     = Product::sum(DB::raw('stock_quantity * cost_price'));

        // Dropdown Lists សម្រាប់ Filters & Modals
        $categories = Category::where('status', 'Active')->select('id', 'name')->get();
        $brands     = Brand::where('status', 'Active')->select('id', 'brand_name')->get();
        $suppliers  = Supplier::where('status', 'Active')->select('id', 'name')->get();
        $products   = Product::where('status', '!=', 'Discontinued')->select('id', 'name', 'sku', 'stock_quantity', 'cost_price', 'min_stock_alert')->get();

        // Low Stock Alert Products (Widget ក្នុង Inventory History)
        $lowStockProducts = Product::where('status', 'Low Stock')
                                   ->orWhere('status', 'Out of Stock')
                                   ->take(5)
                                   ->get();

        // ប្រសិនបើ Frontend ហៅតាម AJAX / API / Postman
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data'    => $transactions,
                'products' => $productItems,
                'summary' => [
                    'total_products'       => $totalProducts,
                    'active_products'      => $activeCount,
                    'inactive_products'    => $inactiveCount,
                    'total_stock_quantity' => $totalStockQuantity,
                    'low_stock_items'      => $lowStockCount,
                    'out_of_stock_items'   => $outOfStockCount,
                    'total_stock_value'    => round($totalStockValue, 2),
                ]
            ], 200);
        }

        $viewName = view()->exists('inventory') ? 'inventory' : 'inventory-transactions';
        return view($viewName, compact(
            'productItems',
            'transactions',
            'products',
            'categories',
            'brands',
            'suppliers',
            'lowStockProducts',
            'totalProducts',
            'activeCount',
            'inactiveCount',
            'totalStockQuantity',
            'lowStockCount',
            'outOfStockCount',
            'availableCount',
            'totalStockValue'
        ));
    }

    /**
     * =========================================================================
     * 2. ADJUST STOCK: កែសម្រួលចំនួនស្តុក (Step 3.3 Core Logic)
     * =========================================================================
     * Frontend ហៅមកកាន់: POST /inventory/adjust ឬ POST /api/inventory/adjust
     * Frontend Form / JSON Payload:
     * {
     *    "product_id": 1,
     *    "adjustment_type": "subtract", // 'add' (បូក), 'subtract' (ដក), 'set' (កំណត់ចំនួនផ្ទាល់)
     *    "quantity": 2,
     *    "reason": "ទំនិញខូចខាតពេលតាំងបង្ហាញ (Damaged display item)"
     * }
     *
     * Logic:
     * 1. គណនា stock_before និង stock_after ដោយផ្អែកលើ adjustment_type
     * 2. Update stock_quantity លើតារាង products
     * 3. ធ្វើបច្ចុប្បន្នភាព Status របស់ Product (In Stock, Low Stock, Out of Stock)
     * 4. កត់ត្រាចូលក្នុង inventory_transactions (Transaction Type: 'Adjustment')
     */
    public function adjustStock(StoreStockAdjustmentRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $userId = Auth::id() ?? 1;

            // ចាក់សោជួរទិន្នន័យ (Lock for Update) ដើម្បីការពារ Race Condition ពេលកែប្រែស្តុកដំណាលគ្នា
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);

            $stockBefore = $product->stock_quantity;
            $deltaQuantity = 0; // ចំនួនដែលត្រូវកត់ត្រា (+ ឬ -)
            $stockAfter = $stockBefore;

            if ($data['adjustment_type'] === 'add') {
                // បូកបន្ថែមស្តុក (ឧ. រាប់ស្តុកឃើញលើស)
                $deltaQuantity = +abs($data['quantity']);
                $stockAfter = $stockBefore + $deltaQuantity;

            } elseif ($data['adjustment_type'] === 'subtract') {
                // ដកស្តុកចេញ (ឧ. ទំនិញបាត់ ឬខូច)
                $qtyToSubtract = abs($data['quantity']);
                if ($qtyToSubtract > $stockBefore) {
                    return response()->json([
                        'success' => false,
                        'message' => "មិនអាចដកស្តុកចំនួន {$qtyToSubtract} បានទេ ព្រោះស្តុកបច្ចុប្បន្នមានត្រឹមតែ {$stockBefore} ប៉ុណ្ណោះ!"
                    ], 422);
                }
                $deltaQuantity = -$qtyToSubtract;
                $stockAfter = $stockBefore - $qtyToSubtract;

            } elseif ($data['adjustment_type'] === 'set') {
                // កំណត់ចំនួនស្តុកថ្មីផ្ទាល់ (ឧ. រាប់ស្តុកប្រចាំខែឃើញជាក់ស្តែង)
                $newStock = (int)$data['quantity'];
                $deltaQuantity = $newStock - $stockBefore;
                $stockAfter = $newStock;
            }

            // 1. Update ស្តុកលើតារាង products
            $product->stock_quantity = $stockAfter;

            // 2. Update ស្ថានភាព Product Status ស្វ័យប្រវត្តិ
            if ($stockAfter <= 0) {
                $product->status = 'Out of Stock';
            } elseif ($stockAfter <= ($product->min_stock_alert ?? 5)) {
                $product->status = 'Low Stock';
            } else {
                $product->status = 'In Stock';
            }

            $product->save();

            // 3. កត់ត្រាប្រវត្តិចូលក្នុង inventory_transactions
            $transaction = InventoryTransaction::create([
                'product_id'       => $product->id,
                'user_id'          => $userId,
                'transaction_type' => 'Adjustment',
                'quantity'         => $deltaQuantity,
                'stock_before'     => $stockBefore,
                'stock_after'      => $stockAfter,
                'reference_type'   => 'StockAdjustment',
                'reference_id'     => null,
                'reason'           => $data['reason'] . " [កែប្រែដោយ: " . ($data['adjustment_type'] == 'add' ? 'បូកបន្ថែម' : ($data['adjustment_type'] == 'subtract' ? 'ដកចេញ' : 'កំណត់ចំនួនផ្ទាល់')) . "]",
            ]);

            DB::commit();

            $msg = "បានកែសម្រួលស្តុកទំនិញ \"{$product->name}\" ពី {$stockBefore} ទៅ {$stockAfter} ដោយជោគជ័យ!";

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success'     => true,
                    'message'     => $msg,
                    'product'     => $product->fresh(),
                    'transaction' => $transaction,
                ], 200);
            }

            return back()->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'មានបញ្ហាក្នុងការកែសម្រួលស្តុក: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'មានបញ្ហាក្នុងការកែសម្រួលស្តុក: ' . $e->getMessage());
        }
    }
}
