<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\InventoryTransaction;
use App\Http\Requests\StorePurchaseOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    /**
     * =========================================================================
     * 1. INDEX: បង្ហាញបញ្ជីប័ណ្ណបញ្ជាទិញ (Purchase Orders List & History)
     * =========================================================================
     * Frontend ហៅមកកាន់: GET /purchase-orders ឬ GET /api/purchase-orders
     * Frontend Parameters (Query Strings):
     *   - ?search=PO-2026... (ស្វែងរកតាមលេខ PO ឬឈ្មោះ Supplier)
     *   - ?status=Pending|Received|Cancelled (ចម្រាញ់តាមស្ថានភាព)
     *   - ?supplier_id=1 (ចម្រាញ់តាមក្រុមហ៊ុនផ្គត់ផ្គង់)
     *   - ?date_from=2026-09-01&date_to=2026-09-30 (ចម្រាញ់តាមកាលបរិច្ឆេទ)
     */
    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'user', 'details.product']);

        // Search តាម លេខ PO (po_number) ឬ Notes
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('po_number', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter តាម ស្ថានភាព (Pending, Received, Cancelled)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter តាម ក្រុមហ៊ុនផ្គត់ផ្គង់ (Supplier)
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // Filter តាម កាលបរិច្ឆេទបញ្ជាទិញ (Order Date Range)
        if ($request->filled('date_from')) {
            $query->whereDate('order_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        // ទាញយកទិន្នន័យប័ណ្ណបញ្ជាទិញតាមលំដាប់ថ្មីបំផុតមុនគេ (Pagination: 10 ក្នុងមួយទំព័រ)
        $purchaseOrders = $query->latest('id')->paginate(10)->withQueryString();

        // គណនាស្ថិតិសរុប (Summary Stats Cards សម្រាប់ Frontend បង្ហាញ)
        $totalOrders     = PurchaseOrder::count();
        $pendingOrders   = PurchaseOrder::where('status', 'Pending')->count();
        $receivedOrders  = PurchaseOrder::where('status', 'Received')->count();
        $totalSpend      = PurchaseOrder::where('status', 'Received')->sum('total_amount');

        // Dropdown Lists សម្រាប់ Filter & Form
        $suppliers = Supplier::where('status', 'Active')->select('id', 'name', 'phone')->get();
        $products  = Product::where('status', '!=', 'Discontinued')->select('id', 'name', 'sku', 'cost_price', 'stock_quantity')->get();

        // 5 ប័ណ្ណថ្មីបំផុតសម្រាប់ Recent Purchase Orders Widget
        $recentOrders = PurchaseOrder::with('supplier')->latest('id')->take(6)->get();

        // ក្រុមហ៊ុនផ្គត់ផ្គង់កំពូលទាំង ៥ (Top Suppliers Widget)
        $topSuppliers = Supplier::where('status', 'Active')
            ->withSum('purchaseOrders', 'total_amount')
            ->orderByDesc('purchase_orders_sum_total_amount')
            ->take(5)
            ->get();

        // លេខ PO បន្ទាប់ (ឧ. PO-2025-009 ឬ PO-2026-003)
        $latestPo = PurchaseOrder::latest('id')->first();
        $nextNum = $latestPo ? ((int)preg_replace('/[^0-9]/', '', substr($latestPo->po_number, -4))) + 1 : 1;
        $suggestedPoNumber = 'PO-' . date('Y') . '-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        // ប្រសិនបើ Frontend ហៅតាម AJAX / API / Postman
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data'    => $purchaseOrders,
                'summary' => [
                    'total_orders'    => $totalOrders,
                    'pending_orders'  => $pendingOrders,
                    'received_orders' => $receivedOrders,
                    'total_spend'     => round($totalSpend, 2),
                ],
                'recent_orders' => $recentOrders,
                'top_suppliers' => $topSuppliers
            ], 200);
        }

        // បញ្ជូនទៅកាន់ Blade View
        $viewName = view()->exists('purchases') ? 'purchases' : 'purchase-orders';
        return view($viewName, compact(
            'purchaseOrders',
            'suppliers',
            'products',
            'totalOrders',
            'pendingOrders',
            'receivedOrders',
            'totalSpend',
            'recentOrders',
            'topSuppliers',
            'suggestedPoNumber'
        ));
    }

    /**
     * =========================================================================
     * 2. CREATE: ផ្តល់ទិន្នន័យសម្រាប់ទម្រង់បង្កើត PO ថ្មី
     * =========================================================================
     * Frontend ហៅមកកាន់: GET /purchase-orders/create
     */
    public function create()
    {
        $suppliers = Supplier::where('status', 'Active')->get();
        $products  = Product::where('status', '!=', 'Discontinued')->get();

        return response()->json([
            'success'   => true,
            'suppliers' => $suppliers,
            'products'  => $products,
        ]);
    }

    /**
     * =========================================================================
     * 3. STORE: បង្កើតប័ណ្ណបញ្ជាទិញទំនិញចូលថ្មី (Step 3.1 & Auto Stock-In Step 3.2)
     * =========================================================================
     * Frontend ហៅមកកាន់: POST /purchase-orders ឬ POST /api/purchase-orders
     * Frontend Form Data / JSON Payload:
     * {
     *   "supplier_id": 1,
     *   "order_date": "2026-09-26",
     *   "expected_delivery_date": "2026-09-30",
     *   "status": "Pending", // ឬ "Received"
     *   "notes": "បញ្ជាទិញគ្រឿងកុំព្យូទ័រ ASUS ROG & RAM",
     *   "items": [
     *      { "product_id": 1, "quantity": 10, "unit_cost": 250.00 },
     *      { "product_id": 2, "quantity": 5,  "unit_cost": 120.00 }
     *   ]
     * }
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            // កំណត់បុគ្គលិកអ្នកបញ្ជាទិញ (Authenticated User)
            $userId = Auth::id() ?? 1;

            // បង្កើតលេខកូដប័ណ្ណបញ្ជាទិញស្វ័យប្រវត្តិ (ឧ. PO-20260926-0001)
            $today = date('Ymd');
            $latestPo = PurchaseOrder::whereDate('created_at', today())->latest('id')->first();
            $nextSequence = $latestPo ? ((int)substr($latestPo->po_number, -4)) + 1 : 1;
            $poNumber = 'PO-' . $today . '-' . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);

            // គណនាតម្លៃសរុបនៃមុខទំនិញទាំងអស់ (Total Amount)
            $totalAmount = 0;
            $itemsData = [];
            foreach ($data['items'] as $item) {
                $subtotal = $item['quantity'] * $item['unit_cost'];
                $totalAmount += $subtotal;
                $itemsData[] = [
                    'product_id'        => $item['product_id'],
                    'quantity'          => $item['quantity'],
                    'unit_cost'         => $item['unit_cost'],
                    'subtotal'          => $subtotal,
                    'received_quantity' => ($data['status'] === 'Received') ? $item['quantity'] : 0,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
            }

            // បង្កើត Purchase Order Header
            $purchaseOrder = PurchaseOrder::create([
                'po_number'              => $poNumber,
                'supplier_id'            => $data['supplier_id'],
                'user_id'                => $userId,
                'order_date'             => $data['order_date'],
                'expected_delivery_date' => $data['expected_delivery_date'] ?? null,
                'received_date'          => ($data['status'] === 'Received') ? now() : null,
                'total_amount'           => $totalAmount,
                'status'                 => $data['status'],
                'payment_status'         => 'Unpaid',
                'notes'                  => $data['notes'] ?? null,
            ]);

            // បង្កើត Purchase Order Details (ទំនិញលម្អិតទាំងអស់)
            $purchaseOrder->details()->createMany($itemsData);

            // [Step 3.2]: ប្រសិនបើស្ថានភាពត្រូវបានជ្រើសរើសជា "Received" ភ្លាមៗ -> បូកបញ្ចូលស្តុកភ្លាម
            if ($data['status'] === 'Received') {
                $this->processStockInForOrder($purchaseOrder, $userId);
            }

            DB::commit();

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'បានបង្កើតប័ណ្ណបញ្ជាទិញ ' . $poNumber . ' ដោយជោគជ័យ!',
                    'data'    => $purchaseOrder->load(['supplier', 'user', 'details.product']),
                ], 201);
            }

            return redirect()->route('purchase-orders.index')
                             ->with('success', 'បានបង្កើតប័ណ្ណបញ្ជាទិញ ' . $poNumber . ' ដោយជោគជ័យ!');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'មានបញ្ហាក្នុងការបង្កើតប័ណ្ណបញ្ជាទិញ: ' . $e->getMessage()
                ], 500);
            }
            return back()->withInput()->with('error', 'មានបញ្ហាក្នុងការបង្កើតប័ណ្ណបញ្ជាទិញ: ' . $e->getMessage());
        }
    }

    /**
     * =========================================================================
     * 4. SHOW: បង្ហាញព័ត៌មានលម្អិតប័ណ្ណបញ្ជាទិញ (សម្រាប់ PO Slip & View Detail)
     * =========================================================================
     * Frontend ហៅមកកាន់: GET /purchase-orders/{id}
     * ត្រឡប់ទិន្នន័យ: ក្រុមហ៊ុនផ្គត់ផ្គង់, អ្នកទិញ, បញ្ជីទំនិញ, និងប្រវត្តិ Inventory Transactions
     */
    public function show(Request $request, $id)
    {
        $purchaseOrder = PurchaseOrder::with(['supplier', 'user', 'details.product', 'inventoryTransactions.product'])
                                      ->findOrFail($id);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data'    => $purchaseOrder
            ], 200);
        }

        return view('purchase-orders-show', compact('purchaseOrder'));
    }

    /**
     * =========================================================================
     * 5. UPDATE STATUS: ផ្លាស់ប្តូរ Status PO (Step 3.2 Core Logic: Auto Stock-In)
     * =========================================================================
     * Frontend ហៅមកកាន់: PATCH /purchase-orders/{id}/status
     * Frontend Payload:
     * {
     *   "status": "Received" // ឬ "Cancelled", "Pending"
     * }
     * 
     * Logic សំខាន់ (Step 3.2):
     * នៅពេល Status ប្តូរទៅ "Received":
     *   1. បូក stock_quantity ចូលក្នុងតារាង products
     *   2. កត់ត្រាប្រតិបត្តិការចូលក្នុង inventory_transactions (Stock In)
     *   3. កត់ត្រា received_date = now()
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Received,Cancelled',
        ], [
            'status.required' => 'សូមជ្រើសរើសស្ថានភាពប័ណ្ណបញ្ជាទិញ',
            'status.in'       => 'ស្ថានភាពត្រូវតែជា Pending, Received, ឬ Cancelled'
        ]);

        $purchaseOrder = PurchaseOrder::with('details.product')->findOrFail($id);

        // ការពារកុំឱ្យទទួលចូលស្តុកលើសពីមួយដង (Duplicate Stock-In Prevention)
        if ($purchaseOrder->status === 'Received' && $request->status === 'Received') {
            return response()->json([
                'success' => false,
                'message' => 'ប័ណ្ណបញ្ជាទិញនេះត្រូវបានទទួលចូលស្តុករួចរាល់ហើយ មិនអាចធ្វើឡើងវិញបានទេ!'
            ], 422);
        }

        DB::beginTransaction();
        try {
            $previousStatus = $purchaseOrder->status;
            $newStatus = $request->status;

            // ប្រសិនបើប្តូរទៅកាន់ 'Received' -> បូកចំនួនចូលស្តុកស្វ័យប្រវត្តិ
            if ($newStatus === 'Received' && $previousStatus !== 'Received') {
                $userId = Auth::id() ?? 1;
                $this->processStockInForOrder($purchaseOrder, $userId);

                $purchaseOrder->status        = 'Received';
                $purchaseOrder->received_date = now();
                $purchaseOrder->save();
            } else {
                // ប្តូរទៅ Pending ឬ Cancelled
                $purchaseOrder->status = $newStatus;
                $purchaseOrder->save();
            }

            DB::commit();

            $msg = 'បានផ្លាស់ប្តូរស្ថានភាពប័ណ្ណបញ្ជាទិញទៅជា "' . $newStatus . '" ដោយជោគជ័យ!';

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => $msg,
                    'data'    => $purchaseOrder->fresh(['supplier', 'details.product']),
                ], 200);
            }

            return back()->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'មានបញ្ហាក្នុងការផ្លាស់ប្តូរស្ថានភាព: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'មានបញ្ហាក្នុងការផ្លាស់ប្តូរស្ថានភាព: ' . $e->getMessage());
        }
    }

    /**
     * =========================================================================
     * 6. DESTROY: លុបប័ណ្ណបញ្ជាទិញ (Delete PO)
     * =========================================================================
     * Frontend ហៅមកកាន់: DELETE /purchase-orders/{id}
     * លក្ខខណ្ឌ: ប័ណ្ណដែលមានស្ថានភាព 'Received' មិនអនុញ្ញាតឱ្យលុបឡើយ ដើម្បីការពារទិន្នន័យស្តុក
     */
    public function destroy(Request $request, $id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        if ($purchaseOrder->status === 'Received') {
            $msg = 'មិនអាចលុបប័ណ្ណបញ្ជាទិញដែលបានទទួលទំនិញចូលស្តុករួចរាល់ឡើយ (Cannot delete Received PO)!';
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        $purchaseOrder->delete();

        $msg = 'បានលុបប័ណ្ណបញ្ជាទិញ ' . $purchaseOrder->po_number . ' ដោយជោគជ័យ!';

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['success' => true, 'message' => $msg], 200);
        }

        return redirect()->route('purchase-orders.index')->with('success', $msg);
    }

    /**
     * =========================================================================
     * HELPER METHOD: ដំណើរការបូកស្តុកទំនិញ និងកត់ត្រាចរន្តស្តុក (Step 3.2 Logic)
     * =========================================================================
     */
    protected function processStockInForOrder(PurchaseOrder $order, $userId)
    {
        foreach ($order->details as $detail) {
            $product = Product::lockForUpdate()->find($detail->product_id);
            if (!$product) continue;

            $stockBefore = $product->stock_quantity;
            $quantityAdded = $detail->quantity;
            $stockAfter  = $stockBefore + $quantityAdded;

            // 1. បូក stock_quantity លើតារាង products
            $product->stock_quantity = $stockAfter;

            // ធ្វើបច្ចុប្បន្នភាព Status របស់ទំនិញ ប្រសិនបើមុននេះ Out of Stock
            if ($stockAfter > ($product->min_stock_level ?? 5)) {
                $product->status = 'In Stock';
            } elseif ($stockAfter > 0) {
                $product->status = 'Low Stock';
            }

            // Update cost_price ប្រសិនបើតម្លៃទិញចូលលើកនេះថ្មី
            if ($detail->unit_cost > 0) {
                $product->cost_price = $detail->unit_cost;
            }

            $product->save();

            // 2. Update received_quantity លើ purchase_order_details
            $detail->received_quantity = $quantityAdded;
            $detail->save();

            // 3. កត់ត្រាចូលក្នុង inventory_transactions (ប្រភេទ Stock In)
            InventoryTransaction::create([
                'product_id'       => $product->id,
                'user_id'          => $userId,
                'transaction_type' => 'Stock In',
                'quantity'         => $quantityAdded,
                'stock_before'     => $stockBefore,
                'stock_after'      => $stockAfter,
                'reference_type'   => 'PurchaseOrder',
                'reference_id'     => $order->id,
                'reason'           => 'ទំនិញចូលស្តុកតាមប័ណ្ណបញ្ជាទិញ ' . $order->po_number . ' ពីក្រុមហ៊ុន ' . ($order->supplier->name ?? 'Supplier'),
            ]);
        }
    }
}
