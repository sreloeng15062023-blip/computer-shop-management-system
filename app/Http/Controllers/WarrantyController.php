<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use App\Models\WarrantyClaim;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WarrantyController extends Controller
{
    /**
     * Display Warranty Management (Feature #11)
     */
    public function index(Request $request)
    {
        // 1. Warranties Query with filters
        $query = Warranty::with(['product', 'customer']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('warranty_code', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%")
                  ->orWhere('product_name', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('brand') && $request->brand !== 'all') {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('purchase_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('purchase_date', '<=', $request->date_to);
        }

        $warranties = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // 2. Calculate 4 Stat Cards matching Mockup 2
        $totalWarranties = Warranty::count();
        $activeWarranties = Warranty::where('status', 'Active')->count();
        
        // Expiring soon (within 30 days)
        $expiringSoonCount = Warranty::where('status', 'Active')
            ->whereBetween('expiry_date', [now(), now()->addDays(30)])
            ->count();
        if ($expiringSoonCount == 0) {
            $expiringSoonCount = Warranty::where('status', 'Expiring')->count();
        }

        $claimsCount = WarrantyClaim::count();

        // 3. Status Breakdown for Donut Chart
        $statusCounts = [
            'Active'   => $activeWarranties,
            'Expiring' => max(1, Warranty::where('status', 'Expiring')->count()),
            'Claimed'  => Warranty::where('status', 'Claimed')->count(),
            'Expired'  => Warranty::where('status', 'Expired')->count(),
        ];

        // 4. Recent Warranty Claims matching Mockup 2 bottom table
        $recentClaims = WarrantyClaim::with(['warranty.product', 'customer'])
            ->orderBy('id', 'desc')
            ->take(5)
            ->get();

        // 5. Expiry Alerts list matching Mockup 2 bottom table
        $expiryAlerts = Warranty::with(['customer', 'product'])
            ->where('status', '!=', 'Expired')
            ->whereDate('expiry_date', '<=', now()->addDays(90))
            ->orderBy('expiry_date', 'asc')
            ->take(5)
            ->get();

        // 6. Featured Warranty for Right Sidebar Preview
        $featuredWarranty = Warranty::with(['product', 'customer'])
            ->orderBy('id', 'desc')
            ->first();

        // 7. Customers and Products for Register Modal
        $customers = Customer::where('status', 'Active')->orderBy('name', 'asc')->get();
        $products = Product::where('status', '!=', 'Discontinued')->orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('brand_name', 'asc')->get();

        return view('warranty', compact(
            'warranties',
            'totalWarranties',
            'activeWarranties',
            'expiringSoonCount',
            'claimsCount',
            'statusCounts',
            'recentClaims',
            'expiryAlerts',
            'featuredWarranty',
            'customers',
            'products',
            'brands'
        ));
    }

    /**
     * Store new product warranty
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'            => 'nullable|exists:customers,id',
            'customer_name'          => 'nullable|string|max:255',
            'product_id'             => 'nullable|exists:products,id',
            'product_name'           => 'required|string|max:255',
            'brand'                  => 'nullable|string|max:100',
            'serial_number'          => 'required|string|max:100',
            'purchase_date'          => 'required|date',
            'warranty_period_months' => 'required|integer|min:1',
        ]);

        $customerId = $validated['customer_id'] ?? null;
        if (!$customerId && !empty($validated['customer_name'])) {
            $cust = Customer::create([
                'name'          => $validated['customer_name'],
                'phone'         => 'N/A',
                'customer_type' => 'Retail',
                'status'        => 'Active'
            ]);
            $customerId = $cust->id;
        }

        $purchaseDate = Carbon::parse($validated['purchase_date']);
        $expiryDate = (clone $purchaseDate)->addMonths($validated['warranty_period_months']);

        $nextId = (Warranty::max('id') ?? 0) + 1;
        $warrantyCode = 'WAR-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        Warranty::create([
            'warranty_code'          => $warrantyCode,
            'customer_id'            => $customerId,
            'product_id'             => $validated['product_id'] ?? null,
            'product_name'           => $validated['product_name'],
            'brand'                  => $validated['brand'] ?? 'General',
            'serial_number'          => $validated['serial_number'],
            'purchase_date'          => $purchaseDate,
            'warranty_period_months' => $validated['warranty_period_months'],
            'expiry_date'            => $expiryDate,
            'status'                 => $expiryDate->isPast() ? 'Expired' : 'Active',
            'terms'                  => 'Standard 1-to-1 hardware replacement warranty',
        ]);

        return redirect()->route('warranty')->with('success', "ប័ណ្ណធានា {$warrantyCode} ត្រូវបានចុះឈ្មោះដោយជោគជ័យ!");
    }

    /**
     * Lookup Warranty by Serial Number or Warranty Code (Step 5.3)
     */
    public function lookup(Request $request)
    {
        $serial = $request->query('query');
        if (!$serial) {
            return response()->json(['success' => false, 'message' => 'សូមបញ្ចូល Serial Number ឬ Warranty ID'], 422);
        }

        $warranty = Warranty::with(['customer', 'product', 'claims'])
            ->where('serial_number', $serial)
            ->orWhere('warranty_code', $serial)
            ->first();

        if (!$warranty) {
            return response()->json([
                'success' => false,
                'message' => "រកមិនឃើញទិន្នន័យធានាសម្រាប់ '{$serial}' ឡើយ"
            ], 404);
        }

        $isExpired = $warranty->expiry_date->isPast();
        $daysRemaining = now()->diffInDays($warranty->expiry_date, false);

        return response()->json([
            'success'        => true,
            'warranty'       => $warranty,
            'is_expired'     => $isExpired,
            'days_remaining' => $daysRemaining,
        ]);
    }

    /**
     * Submit Warranty Claim
     */
    public function storeClaim(Request $request)
    {
        $validated = $request->validate([
            'warranty_id'       => 'required|exists:warranties,id',
            'issue_description' => 'required|string|max:1000',
        ]);

        $warranty = Warranty::findOrFail($validated['warranty_id']);

        $nextClaimId = (WarrantyClaim::max('id') ?? 0) + 1;
        $claimCode = 'CLM-' . date('Y') . '-' . str_pad($nextClaimId, 4, '0', STR_PAD_LEFT);

        $claim = WarrantyClaim::create([
            'claim_code'        => $claimCode,
            'warranty_id'       => $warranty->id,
            'customer_id'       => $warranty->customer_id,
            'claim_date'        => now(),
            'issue_description' => $validated['issue_description'],
            'status'            => 'In Progress',
        ]);

        $warranty->status = 'Claimed';
        $warranty->save();

        return response()->json([
            'success' => true,
            'message' => "ពាក្យស្នើសុំធានា {$claimCode} ត្រូវបានទទួលយក",
            'claim'   => $claim
        ]);
    }
}
