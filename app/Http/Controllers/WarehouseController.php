<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * 1. Display list of warehouses with search, filters & stats
     */
    public function index(Request $request)
    {
        $query = Warehouse::withCount('serials');

        // Search by Code, Name, Location or Manager
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('manager_name', 'like', "%{$search}%");
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $warehouses = $query->latest()->paginate(10)->withQueryString();

        // Metric Statistics for top Cards
        $totalWarehouses = Warehouse::count();
        $activeWarehouses = Warehouse::where('status', 'Active')->count();
        $inactiveWarehouses = Warehouse::where('status', 'Inactive')->count();
        $totalStoredSerials = \App\Models\ProductSerial::whereNotNull('warehouse_id')->count();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => true,
                'data'   => $warehouses,
            ], 200);
        }

        return view('warehouses', compact(
            'warehouses',
            'totalWarehouses',
            'activeWarehouses',
            'inactiveWarehouses',
            'totalStoredSerials'
        ));
    }

    /**
     * 2. Store a newly created warehouse
     */
    public function store(StoreWarehouseRequest $request)
    {
        $warehouse = Warehouse::create($request->validated());

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status'  => true,
                'message' => 'Warehouse created successfully',
                'data'    => $warehouse,
            ], 201);
        }

        return redirect()->route('warehouses.index')->with('success', 'ឃ្លាំងថ្មីត្រូវបានបង្កើតដោយជោគជ័យ (Warehouse created successfully)!');
    }

    /**
     * 3. Display specific warehouse with its inventory serials
     */
    public function show(Request $request, Warehouse $warehouse)
    {
        $warehouse->load(['serials.product']);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => true,
                'data'   => $warehouse,
            ], 200);
        }

        return view('warehouses', compact('warehouse'));
    }

    /**
     * 4. Update warehouse details
     */
    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        $warehouse->update($request->validated());

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status'  => true,
                'message' => 'Warehouse updated successfully',
                'data'    => $warehouse,
            ], 200);
        }

        return redirect()->route('warehouses.index')->with('success', 'ទិន្នន័យឃ្លាំងត្រូវបានកែប្រែដោយជោគជ័យ (Warehouse updated successfully)!');
    }

    /**
     * 5. Safely delete warehouse with relational integrity guard
     */
    public function destroy(Request $request, Warehouse $warehouse)
    {
        // Safety guard: Prevent deleting warehouse if serial numbers are stored inside it
        $serialCount = $warehouse->serials()->count();
        if ($serialCount > 0) {
            $msg = "មិនអាចលុបឃ្លាំងនេះបានទេ ពីព្រោះមានទំនិញ/សេរៀលចំនួន {$serialCount} គ្រឿងកំពុងរក្សាទុកនៅទីនេះ (Cannot delete warehouse containing {$serialCount} stored items).";
            
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'status'  => false,
                    'message' => $msg,
                ], 422);
            }

            return redirect()->route('warehouses.index')->with('error', $msg);
        }

        $warehouse->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status'  => true,
                'message' => 'Warehouse deleted successfully',
            ], 200);
        }

        return redirect()->route('warehouses.index')->with('success', 'ឃ្លាំងត្រូវបានលុបដោយជោគជ័យ (Warehouse deleted successfully)!');
    }
}
