<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display Payment & Invoice Management (Feature #12)
     */
    public function index(Request $request)
    {
        // 1. Invoices Query with Search and Filters
        $query = Invoice::with(['customer', 'sale.details.product', 'payments', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  })
                  ->orWhereHas('sale.details.product', function ($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('invoice_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('invoice_date', '<=', $request->date_to);
        }

        $invoices = $query->orderBy('invoice_date', 'desc')->paginate(10)->withQueryString();

        // 2. Calculate 4 Stat Cards
        $totalInvoicesCount = Invoice::count();
        $totalSalesAmount = Invoice::sum('total_amount');
        $totalPaymentsReceived = Invoice::sum('paid_amount');
        $outstandingBalance = Invoice::sum('balance_due');

        // 3. Payment Summary Breakdown for Donut Chart
        $paymentMethods = ['Cash', 'Card', 'ABA', 'Wing', 'Other'];
        $paymentsByMethod = [];
        $totalSumForDonut = Payment::where('status', 'Completed')->sum('amount');
        if ($totalSumForDonut == 0) {
            $totalSumForDonut = max(1, $totalPaymentsReceived);
        }

        foreach ($paymentMethods as $method) {
            $methodSum = Payment::where('status', 'Completed')
                ->where('payment_method', $method)
                ->sum('amount');

            // Fallback from invoices if payments table has 0
            if ($methodSum == 0) {
                $methodSum = Invoice::where('payment_method', $method)->sum('paid_amount');
            }

            $percentage = $totalSumForDonut > 0 ? round(($methodSum / $totalSumForDonut) * 100, 1) : 0;
            $paymentsByMethod[$method] = [
                'amount'     => $methodSum,
                'percentage' => $percentage,
            ];
        }

        // 4. Recent Invoice for Right Sidebar Preview
        $recentInvoice = Invoice::with(['customer', 'sale.details.product', 'user'])
            ->orderBy('id', 'desc')
            ->first();

        // 5. Customer list and Products for Create New Invoice Panel
        $customers = Customer::where('status', 'Active')->orderBy('name', 'asc')->get();
        $products = Product::where('status', '!=', 'Discontinued')->orderBy('name', 'asc')->get();

        return view('invoices', compact(
            'invoices',
            'totalInvoicesCount',
            'totalSalesAmount',
            'totalPaymentsReceived',
            'outstandingBalance',
            'paymentsByMethod',
            'totalSumForDonut',
            'recentInvoice',
            'customers',
            'products'
        ));
    }

    /**
     * Show Invoice details JSON
     */
    public function show($id)
    {
        $invoice = Invoice::with(['customer', 'sale.details.product', 'payments', 'user'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'invoice' => $invoice,
        ]);
    }

    /**
     * Print Invoice or Receipt layout
     */
    public function print($id)
    {
        $invoice = Invoice::with(['customer', 'sale.details.product', 'payments', 'user'])->findOrFail($id);
        return view('invoices.print', compact('invoice'));
    }
}
