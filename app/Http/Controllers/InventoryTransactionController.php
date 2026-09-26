<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransaction;
use App\Models\Product;
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
     * Frontend Query Parameters:
     *   - ?search=Laptop (ស្វែងរកតាមឈ្មោះទំនិញ, SKU, ឬមូលហេតុ Reason)
     *   - ?transaction_type=Stock In|Stock Out|Adjustment|Sale|Return
     *   - ?product_id=5 (ចម្រាញ់តាមមុខទំនិញជាក់លាក់)
     *   - ?date_from=2026-09-01&date_to=2026-09-30 (ចម្រាញ់តាមកាលបរិច្ឆេទ)
     */
    public function index(Request $request)
    {
        $query = InventoryTransaction::with(['product.category', 'product.brand', 'user']);

        // Search តាមឈ្មោះទំនិញ, SKU, ឬមូលហេតុ (Reason)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reason', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%")
                         ->orWhere('sku', 'like', "%{$search}%");
                  });
            });
        }

        // Filter តាម ប្រភេទប្រតិបត្តិការ (Stock In, Stock Out, Adjustment, Sale, Return)
        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }

        // Filter តាម មុខទំនិញ (Product ID)
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Filter តាម កាលបរិច្ឆេទ (Date Range)
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Pagination: 15 កំណត់ត្រាក្នុងមួយទំព័រ តម្រៀបពីថ្មីបំផុតទៅចាស់បំផុត
        $transactions = $query->latest('id')->paginate(15)->withQueryString();

        // ស្ថិតិចរន្តស្តុកសរុប (Summary Stats Cards សម្រាប់ Frontend)
        $totalTransactions = InventoryTransaction::count();
        $totalStockIn      = InventoryTransaction::where('transaction_type', 'Stock In')->sum('quantity');
        $totalStockOut     = InventoryTransaction::where('transaction_type', 'Stock Out')->sum('quantity');
        $totalAdjustments  = InventoryTransaction::where('transaction_type', 'Adjustment')->count();

        // បញ្ជីទំនិញសម្រាប់ Modal កែសម្រួលស្តុក (Stock Adjustment Modal Dropdown)
        $products = Product::where('status', '!=', 'Discontinued')
                           ->select('id', 'name', 'sku', 'stock_quantity', 'min_stock_alert')
                           ->get();

        // ប្រសិនបើ Frontend ហៅតាម AJAX / API / Postman
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data'    => $transactions,
                'summary' => [
                    'total_transactions' => $totalTransactions,
                    'total_stock_in'     => (int)$totalStockIn,
                    'total_stock_out'    => (int)$totalStockOut,
                    'total_adjustments'  => $totalAdjustments,
                ],
                'products' => $products
            ], 200);
        }

        $viewName = view()->exists('inventory') ? 'inventory' : 'inventory-transactions';
        return view($viewName, compact(
            'transactions',
            'products',
            'totalTransactions',
            'totalStockIn',
            'totalStockOut',
            'totalAdjustments'
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
