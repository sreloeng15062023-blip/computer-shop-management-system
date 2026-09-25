<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * 1. បង្ហាញបញ្ជី Customers (Search + Type Filter + Status Filter + Pagination)
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search តាមឈ្មោះ, លេខទូរស័ព្ទ, អ៊ីមែល, ឬ អាសយដ្ឋាន
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Filter តាមប្រភេទអតិថិជន (Retail / Wholesale)
        if ($request->filled('customer_type')) {
            $query->where('customer_type', $request->customer_type);
        }

        // Filter តាមស្ថានភាព (Active / Inactive)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ទាញទិន្នន័យ ១០ នាក់ក្នុងមួយទំព័រ
        $customers = $query->latest()->paginate(10)->withQueryString();

        // គណនាទិន្នន័យស្ថិតិសម្រាប់ Cards ទាំង ៤
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('status', 'Active')->count();
        $wholesaleCustomers = Customer::where('customer_type', 'Wholesale')->count();
        $totalRewardPoints = Customer::sum('points');

        // Support JSON សម្រាប់ Postman API
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'data' => $customers], 200);
        }

        return view('customers', compact(
            'customers',
            'totalCustomers',
            'activeCustomers',
            'wholesaleCustomers',
            'totalRewardPoints'
        ));
    }

    /**
     * 2. បង្កើត Customer ថ្មី
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status'  => true,
                'message' => 'Customer created successfully',
                'data'    => $customer
            ], 201);
        }

        return redirect()->route('customers.index')->with('success', 'Customer created successfully');
    }

    /**
     * 3. មើលព័ត៌មានលម្អិត Customer ម្នាក់
     */
    public function show(Request $request, Customer $customer)
    {
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'data' => $customer], 200);
        }

        // compact('customer') គឺជា PHP built-in function សម្រាប់វេចខ្ចប់ Variable $customer
        // ទៅជា Array ['customer' => $customer] ដើម្បីផ្ញើទៅប្រើក្នុងផ្ទាំង Blade View (customers.blade.php)
        return view('customers', compact('customer'));
    }

    /**
     * 4. កែប្រែទិន្នន័យ Customer
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status'  => true,
                'message' => 'Customer updated successfully',
                'data'    => $customer
            ], 200);
        }

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }

    /**
     * 5. លុប Customer
     */
    public function destroy(Request $request, Customer $customer)
    {
        $customer->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status'  => true,
                'message' => 'Customer deleted successfully'
            ], 200);
        }

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }
}
