<?php

namespace App\Http\Controllers;

use App\Models\RepairService;
use App\Models\RepairPart;
use App\Models\Product;
use App\Models\Customer;
use App\Models\User;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class RepairServiceController extends Controller
{
    /**
     * Display Repair Service Management (Feature #10)
     */
    public function index(Request $request)
    {
        // 1. Query Repair Orders with filters
        $query = RepairService::with(['customer', 'technician', 'parts.product']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('repair_code', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('issue_description', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('technician_id') && $request->technician_id !== 'all') {
            $query->where('technician_id', $request->technician_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $repairs = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // 2. Calculate 5 Stat Cards matching Mockup 1
        $totalOrders = RepairService::count();
        $inProgressCount = RepairService::whereIn('status', ['Diagnosing', 'Repairing', 'Testing'])->count();
        $completedCount = RepairService::where('status', 'Completed')->count();
        $waitingPartsCount = RepairService::where('status', 'Waiting for Parts')->count();
        $cancelledCount = RepairService::where('status', 'Cancelled')->count();

        // 3. Status Breakdown for Donut Chart
        $statusCounts = [
            'Diagnosing'        => RepairService::where('status', 'Diagnosing')->count(),
            'Waiting for Parts' => RepairService::where('status', 'Waiting for Parts')->count(),
            'Repairing'         => RepairService::where('status', 'Repairing')->count(),
            'Testing'           => RepairService::where('status', 'Testing')->count(),
            'Completed'         => RepairService::where('status', 'Completed')->count(),
            'Cancelled'         => RepairService::where('status', 'Cancelled')->count(),
        ];

        // 4. Technicians and Customers for Create/Assign Forms
        $technicians = User::orderBy('name', 'asc')->get();
        $customers = Customer::where('status', 'Active')->orderBy('name', 'asc')->get();
        $spareParts = Product::where('status', 'In Stock')->orderBy('name', 'asc')->get();

        // 5. Recent repair for preview detail card
        $featuredRepair = RepairService::with(['customer', 'technician', 'parts.product'])
            ->orderBy('id', 'desc')
            ->first();

        return view('repair-service', compact(
            'repairs',
            'totalOrders',
            'inProgressCount',
            'completedCount',
            'waitingPartsCount',
            'cancelledCount',
            'statusCounts',
            'technicians',
            'customers',
            'spareParts',
            'featuredRepair'
        ));
    }

    /**
     * Store a new repair request (Step 5.1)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'       => 'nullable|exists:customers,id',
            'customer_name'     => 'nullable|string|max:255',
            'customer_phone'    => 'nullable|string|max:50',
            'device_type'       => 'required|string|max:100',
            'brand'             => 'nullable|string|max:100',
            'model'             => 'required|string|max:255',
            'serial_number'     => 'nullable|string|max:100',
            'issue_description' => 'required|string|max:1000',
            'technician_id'     => 'nullable|exists:users,id',
            'estimated_cost'    => 'nullable|numeric|min:0',
        ]);

        // Auto-create customer if new name provided
        $customerId = $validated['customer_id'] ?? null;
        if (!$customerId && !empty($validated['customer_name'])) {
            $customer = Customer::create([
                'name'          => $validated['customer_name'],
                'phone'         => $validated['customer_phone'] ?? 'N/A',
                'customer_type' => 'Retail',
                'status'        => 'Active',
            ]);
            $customerId = $customer->id;
        }

        // Generate Repair Code (e.g. RE-2025-0098)
        $nextId = (RepairService::max('id') ?? 0) + 1;
        $repairCode = 'RE-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $repair = RepairService::create([
            'repair_code'          => $repairCode,
            'customer_id'          => $customerId,
            'technician_id'        => $validated['technician_id'] ?? 1,
            'device_type'          => $validated['device_type'],
            'brand'                => $validated['brand'] ?? 'General',
            'model'                => $validated['model'],
            'serial_number'        => $validated['serial_number'] ?? 'SN-' . strtoupper(uniqid()),
            'issue_description'    => $validated['issue_description'],
            'status'               => 'Received',
            'estimated_cost'       => $validated['estimated_cost'] ?? 50.00,
            'estimated_completion' => now()->addDays(3),
            'service_fee'          => 20.00,
            'total_cost'           => 20.00,
        ]);

        return redirect()->route('repair.service')->with('success', "សំណើជួសជុល {$repairCode} ត្រូវបានបង្កើតដោយជោគជ័យ!");
    }

    /**
     * Update Repair Status (Step 5.1: Received -> Diagnosing -> Waiting for Parts -> Repairing -> Testing -> Completed)
     */
    public function updateStatus(Request $request, $id)
    {
        $repair = RepairService::findOrFail($id);

        $validated = $request->validate([
            'status'               => 'required|in:Received,Diagnosing,Waiting for Parts,Repairing,Testing,Ready for Pickup,Completed,Cancelled',
            'diagnosis'            => 'nullable|string',
            'technician_id'        => 'nullable|exists:users,id',
            'estimated_cost'       => 'nullable|numeric|min:0',
            'service_fee'          => 'nullable|numeric|min:0',
            'notes'                => 'nullable|string',
        ]);

        $repair->status = $validated['status'];
        if (isset($validated['diagnosis'])) $repair->diagnosis = $validated['diagnosis'];
        if (isset($validated['technician_id'])) $repair->technician_id = $validated['technician_id'];
        if (isset($validated['estimated_cost'])) $repair->estimated_cost = $validated['estimated_cost'];
        if (isset($validated['service_fee'])) {
            $repair->service_fee = $validated['service_fee'];
            $repair->total_cost = $repair->service_fee + $repair->parts_total;
        }
        if (isset($validated['notes'])) $repair->notes = $validated['notes'];

        if ($validated['status'] === 'Completed') {
            $repair->completed_at = now();
        }

        $repair->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'ស្ថានភាពជួសជុលត្រូវបានកែប្រែដោយជោគជ័យ',
                'repair'  => $repair
            ]);
        }

        return redirect()->route('repair.service')->with('success', 'ស្ថានភាពត្រូវបានកែប្រែដោយជោគជ័យ!');
    }

    /**
     * Step 5.2: Add Spare Part to Repair
     * - Decrements Product stock
     * - Logs Stock Out in inventory_transactions
     * - Adds to repair_parts table
     * - Recalculates repair_services total_cost
     */
    public function addPart(Request $request, $id)
    {
        $repair = RepairService::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($validated['product_id']);
            $qty = $validated['quantity'];

            if ($product->stock_quantity < $qty) {
                throw new Exception("គ្រឿងបន្លាស់ '{$product->name}' មិនមានស្តុកគ្រប់គ្រាន់ឡើយ (នៅសល់ {$product->stock_quantity})");
            }

            $unitPrice = $product->selling_price;
            $subtotal = $unitPrice * $qty;

            // 1. Create Repair Part Record
            $part = RepairPart::create([
                'repair_service_id' => $repair->id,
                'product_id'        => $product->id,
                'part_name'         => $product->name,
                'quantity'          => $qty,
                'unit_price'        => $unitPrice,
                'subtotal'          => $subtotal,
            ]);

            // 2. Decrement Product Stock
            $stockBefore = $product->stock_quantity;
            $product->stock_quantity -= $qty;
            if ($product->stock_quantity <= 0) {
                $product->status = 'Out of Stock';
            }
            $product->save();

            // 3. Log Stock Out
            InventoryTransaction::create([
                'product_id'       => $product->id,
                'user_id'          => Auth::id() ?? 1,
                'transaction_type' => 'Stock Out',
                'quantity'         => -$qty,
                'stock_before'     => $stockBefore,
                'stock_after'      => $product->stock_quantity,
                'reference_type'   => 'Repair',
                'reference_id'     => $repair->id,
                'reason'           => "Used for Repair #{$repair->repair_code}",
            ]);

            // 4. Update Repair Service Totals
            $repair->parts_total = $repair->parts()->sum('subtotal');
            $repair->total_cost = $repair->service_fee + $repair->parts_total;
            $repair->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "បានបន្ថែមគ្រឿងបន្លាស់ '{$product->name}' ដោយជោគជ័យ",
                'part'    => $part,
                'repair'  => $repair->fresh(['parts.product'])
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Step 5.3: Repair Ticket Slip (80mm or A5 receipt for customer pickup)
     */
    public function ticket($id)
    {
        $repair = RepairService::with(['customer', 'technician', 'parts.product'])->findOrFail($id);
        return view('repair.ticket', compact('repair'));
    }

    /**
     * Show repair details JSON
     */
    public function show($id)
    {
        $repair = RepairService::with(['customer', 'technician', 'parts.product'])->findOrFail($id);
        return response()->json([
            'success' => true,
            'repair'  => $repair
        ]);
    }
}
