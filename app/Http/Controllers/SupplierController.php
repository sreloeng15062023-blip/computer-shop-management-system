<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * 1. បង្ហាញបញ្ជី Suppliers ទាំងអស់ (ជាមួយ Search & Status Filter & Pagination)
     */
    public function index(Request $request)
    {
        $query = Supplier::query();

        // មុខងារ Search រកឈ្មោះក្រុមហ៊ុន, អ្នកតំណាង, លេខទូរស័ព្ទ ឬ អ៊ីមែល
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // មុខងារ Filter តាម Status (Active / Inactive)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ទាញទិន្នន័យចុងក្រោយគេបង្អស់ និងចែកទំព័រ (10 ក្នុងមួយទំព័រ)
        $suppliers = $query->latest()->paginate(10)->withQueryString();

        // Support សម្រាប់ Postman JSON API
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'data' => $suppliers], 200);
        }

        return view('suppliers', compact('suppliers'));
    }

    /**
     * 2. បង្ហាញ Form បង្កើត Supplier ថ្មី
     */
    public function create()
    {
        return view('suppliers');
    }

    /**
     * 3. រក្សាទុក Supplier ថ្មីចូលក្នុង Database
     */
    public function store(StoreSupplierRequest $request)
    {
        $supplier = Supplier::create($request->validated());

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'message' => 'Add Supplier Successfully', 'data' => $supplier], 201);
        }

        return redirect()->route('suppliers.index')
                         ->with('success', 'Add Supplier Successfully');
    }

    /**
     * 4. បង្ហាញព័ត៌មានលម្អិត Supplier មួយ
     */
    public function show(Request $request, Supplier $supplier)
    {
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'data' => $supplier], 200);
        }

        return view('suppliers', compact('supplier'));
    }

    /**
     * 5. បង្ហាញ Form កែប្រែ Supplier
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers', compact('supplier'));
    }

    /**
     * 6. ធ្វើបច្ចុប្បន្នភាព (Update) Supplier ក្នុង Database
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'message' => 'Updated Supplier Successfully', 'data' => $supplier], 200);
        }

        return redirect()->route('suppliers.index')
                         ->with('success', 'Updated Supplier Successfully');
    }

    /**
     * 7. លុប Supplier ចេញពី Database
     */
    public function destroy(Request $request, Supplier $supplier)
    {
        $supplier->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'message' => 'Deleted Supplier Successfully'], 200);
        }

        return redirect()->route('suppliers.index')
                         ->with('success', 'Deleted Supplier Successfully');
    }
}
