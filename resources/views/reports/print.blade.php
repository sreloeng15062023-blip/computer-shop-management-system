<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHZONE - {{ ucwords(str_replace('_', ' ', $reportType)) }} Report ({{ $startDate }} to {{ $endDate }})</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', 'Kantumruy Pro', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; padding: 0 !important; }
            .print-card { box-shadow: none !important; border: none !important; padding: 0 !important; }
            @page { margin: 10mm; size: auto; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 p-4 md:p-8">

<div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-200 print-card">
    
    <!-- Print Action Bar -->
    <div class="no-print flex items-center justify-between pb-6 mb-6 border-b border-slate-200">
        <a href="{{ route('reports', ['type' => $reportType, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Back to Reports
        </a>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/20 transition flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Print Report / Save as PDF
            </button>
        </div>
    </div>

    <!-- Company Header -->
    <div class="flex items-start justify-between border-b pb-6 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">
                <i class="fa-solid fa-cube"></i>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-wider">TECHZONE</h1>
                <p class="text-xs text-slate-500">Computer Shop Management System</p>
                <p class="text-[11px] text-slate-400">Phnom Penh, Cambodia • Tel: +855 12 345 678 • Email: support@techzone.com</p>
            </div>
        </div>
        <div class="text-right">
            <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-extrabold uppercase tracking-wider mb-1">
                {{ strtoupper(str_replace('_', ' ', $reportType)) }} REPORT
            </span>
            <div class="text-xs text-slate-500">Period: <span class="font-bold text-slate-800">{{ $startDate }}</span> to <span class="font-bold text-slate-800">{{ $endDate }}</span></div>
            <div class="text-[11px] text-slate-400">Generated: {{ date('Y-m-d H:i') }} | By: {{ Auth::user()->name ?? 'Administrator' }}</div>
        </div>
    </div>

    <!-- Summary Metrics Grid -->
    <div class="mb-8">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Report Summary Overview</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5">
            @foreach($summary as $key => $val)
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                <div class="text-[10px] font-bold text-slate-500 uppercase">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                <div class="text-base font-black text-slate-900 mt-0.5 truncate">
                    @if(str_contains($key, 'revenue') || str_contains($key, 'profit') || str_contains($key, 'cost') || str_contains($key, 'value') || str_contains($key, 'tax') || str_contains($key, 'discount') || str_contains($key, 'sales') || str_contains($key, 'amount') || str_contains($key, 'spend') || str_contains($key, 'fee') || str_contains($key, 'sourced'))
                        ${{ is_numeric($val) ? number_format($val, 2) : $val }}
                    @elseif(str_contains($key, 'margin') || str_contains($key, 'rate'))
                        {{ $val }}%
                    @else
                        {{ is_numeric($val) ? number_format($val) : $val }}
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Detailed Records Table -->
    <div>
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Detailed Records ({{ count($records) }} Entries)</h3>

        @if($reportType === 'daily_sales' || $reportType === 'sales')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2 border text-center">#</th>
                    <th class="p-2 border">Sale No</th>
                    <th class="p-2 border">Date</th>
                    <th class="p-2 border">Customer</th>
                    <th class="p-2 border text-center">Items</th>
                    <th class="p-2 border">Payment</th>
                    <th class="p-2 border text-right">Subtotal</th>
                    <th class="p-2 border text-right">Discount</th>
                    <th class="p-2 border text-right">Total</th>
                    <th class="p-2 border text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($records as $idx => $r)
                <tr>
                    <td class="p-2 border text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2 border font-bold text-blue-600">{{ $r->sale_number }}</td>
                    <td class="p-2 border text-slate-500">{{ \Carbon\Carbon::parse($r->sale_date)->format('Y-m-d H:i') }}</td>
                    <td class="p-2 border font-semibold text-slate-800">{{ $r->customer->name ?? 'Walk-in' }}</td>
                    <td class="p-2 border text-center">{{ $r->details->sum('quantity') }}</td>
                    <td class="p-2 border">{{ $r->payment_method ?? 'Cash' }}</td>
                    <td class="p-2 border text-right">${{ number_format($r->subtotal, 2) }}</td>
                    <td class="p-2 border text-right text-rose-500">-${{ number_format($r->discount_amount, 2) }}</td>
                    <td class="p-2 border text-right font-black">${{ number_format($r->total_amount, 2) }}</td>
                    <td class="p-2 border text-center font-bold">{{ ucfirst($r->status ?? 'Completed') }}</td>
                </tr>
                @empty
                <tr><td colspan="10" class="p-4 text-center text-slate-400">No sales recorded in this period.</td></tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'monthly_sales')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2 border text-center">#</th>
                    <th class="p-2 border">Month / Year</th>
                    <th class="p-2 border text-center">Total Orders</th>
                    <th class="p-2 border text-center">Items Sold</th>
                    <th class="p-2 border text-right">Cash Sales ($)</th>
                    <th class="p-2 border text-right">Digital / QR ($)</th>
                    <th class="p-2 border text-right">Total Revenue ($)</th>
                    <th class="p-2 border text-right">Avg Order ($)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($records as $idx => $m)
                <tr>
                    <td class="p-2 border text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2 border font-bold text-slate-800">{{ $m['month_label'] }}</td>
                    <td class="p-2 border text-center">{{ $m['orders_count'] }}</td>
                    <td class="p-2 border text-center">{{ $m['items_sold'] }}</td>
                    <td class="p-2 border text-right">${{ number_format($m['cash_total'], 2) }}</td>
                    <td class="p-2 border text-right">${{ number_format($m['digital_total'], 2) }}</td>
                    <td class="p-2 border text-right font-black text-blue-600">${{ number_format($m['total_revenue'], 2) }}</td>
                    <td class="p-2 border text-right font-semibold">${{ number_format($m['avg_order_value'], 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="p-4 text-center text-slate-400">No monthly sales data available.</td></tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'inventory')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2 border text-center">#</th>
                    <th class="p-2 border">Product Name</th>
                    <th class="p-2 border">SKU</th>
                    <th class="p-2 border">Category</th>
                    <th class="p-2 border">Brand</th>
                    <th class="p-2 border text-right">Cost ($)</th>
                    <th class="p-2 border text-right">Price ($)</th>
                    <th class="p-2 border text-center">In Stock</th>
                    <th class="p-2 border text-right">Cost Value ($)</th>
                    <th class="p-2 border text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($records as $idx => $p)
                <tr>
                    <td class="p-2 border text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2 border font-bold text-slate-800">{{ $p->name }}</td>
                    <td class="p-2 border text-slate-500">{{ $p->sku }}</td>
                    <td class="p-2 border">{{ $p->category->name ?? 'N/A' }}</td>
                    <td class="p-2 border">{{ $p->brand->brand_name ?? ($p->brand->name ?? 'N/A') }}</td>
                    <td class="p-2 border text-right">${{ number_format($p->cost_price, 2) }}</td>
                    <td class="p-2 border text-right font-semibold">${{ number_format($p->selling_price, 2) }}</td>
                    <td class="p-2 border text-center font-bold {{ $p->stock_quantity <= $p->min_stock_alert ? 'text-rose-600' : 'text-emerald-600' }}">{{ $p->stock_quantity }}</td>
                    <td class="p-2 border text-right font-black">${{ number_format($p->stock_quantity * $p->cost_price, 2) }}</td>
                    <td class="p-2 border text-center font-bold text-[10px]">{{ $p->stock_quantity <= 0 ? 'Out of Stock' : ($p->stock_quantity <= $p->min_stock_alert ? 'Low Stock' : 'In Stock') }}</td>
                </tr>
                @empty
                <tr><td colspan="10" class="p-4 text-center text-slate-400">No inventory products found.</td></tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'low_stock')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-rose-50 text-rose-800 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2 border text-center">#</th>
                    <th class="p-2 border">Product Name</th>
                    <th class="p-2 border">SKU</th>
                    <th class="p-2 border">Category</th>
                    <th class="p-2 border text-center">Current Stock</th>
                    <th class="p-2 border text-center">Min Alert</th>
                    <th class="p-2 border text-center">Shortage Units</th>
                    <th class="p-2 border text-right">Unit Cost ($)</th>
                    <th class="p-2 border text-right">Est. Restock Cost ($)</th>
                    <th class="p-2 border text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($records as $idx => $p)
                <tr>
                    <td class="p-2 border text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2 border font-bold text-slate-900">{{ $p->name }}</td>
                    <td class="p-2 border text-slate-500">{{ $p->sku }}</td>
                    <td class="p-2 border">{{ $p->category->name ?? 'N/A' }}</td>
                    <td class="p-2 border text-center font-bold text-rose-600">{{ $p->stock_quantity }}</td>
                    <td class="p-2 border text-center">{{ $p->min_stock_alert }}</td>
                    <td class="p-2 border text-center font-extrabold text-amber-600">{{ max(0, $p->min_stock_alert - $p->stock_quantity) }}</td>
                    <td class="p-2 border text-right">${{ number_format($p->cost_price, 2) }}</td>
                    <td class="p-2 border text-right font-black text-rose-600">${{ number_format(max(0, $p->min_stock_alert - $p->stock_quantity) * $p->cost_price, 2) }}</td>
                    <td class="p-2 border text-center font-bold text-[10px] {{ $p->stock_quantity <= 0 ? 'text-rose-600' : 'text-amber-600' }}">{{ $p->stock_quantity <= 0 ? 'OUT OF STOCK' : 'LOW STOCK' }}</td>
                </tr>
                @empty
                <tr><td colspan="10" class="p-4 text-center text-slate-400">All products are healthy above minimum stock alert levels.</td></tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'best_selling')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2 border text-center">Rank</th>
                    <th class="p-2 border">Product Name</th>
                    <th class="p-2 border">SKU</th>
                    <th class="p-2 border">Category</th>
                    <th class="p-2 border text-right">Unit Price ($)</th>
                    <th class="p-2 border text-center">Units Sold</th>
                    <th class="p-2 border text-right">Revenue ($)</th>
                    <th class="p-2 border text-right">Gross Profit ($)</th>
                    <th class="p-2 border text-center">In Stock</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($records as $idx => $p)
                <tr>
                    <td class="p-2 border text-center font-black {{ $idx < 3 ? 'text-amber-600' : 'text-slate-400' }}">#{{ $idx + 1 }}</td>
                    <td class="p-2 border font-bold text-slate-900">{{ $p['name'] }}</td>
                    <td class="p-2 border text-slate-500">{{ $p['sku'] }}</td>
                    <td class="p-2 border">{{ $p['category'] }}</td>
                    <td class="p-2 border text-right">${{ number_format($p['unit_price'], 2) }}</td>
                    <td class="p-2 border text-center font-bold text-blue-600">{{ $p['units_sold'] }}</td>
                    <td class="p-2 border text-right font-black">${{ number_format($p['total_revenue'], 2) }}</td>
                    <td class="p-2 border text-right text-emerald-600 font-bold">${{ number_format($p['gross_profit'], 2) }}</td>
                    <td class="p-2 border text-center">{{ $p['current_stock'] }}</td>
                </tr>
                @empty
                <tr><td colspan="9" class="p-4 text-center text-slate-400">No sales transactions available for top selling products analysis.</td></tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'purchase')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2 border text-center">#</th>
                    <th class="p-2 border">PO Number</th>
                    <th class="p-2 border">Order Date</th>
                    <th class="p-2 border">Supplier</th>
                    <th class="p-2 border">Expected Delivery</th>
                    <th class="p-2 border text-center">Items</th>
                    <th class="p-2 border text-right">Total ($)</th>
                    <th class="p-2 border text-center">Payment</th>
                    <th class="p-2 border text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($records as $idx => $po)
                <tr>
                    <td class="p-2 border text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2 border font-bold text-blue-600">{{ $po->po_number }}</td>
                    <td class="p-2 border text-slate-500">{{ $po->order_date ? \Carbon\Carbon::parse($po->order_date)->format('Y-m-d') : 'N/A' }}</td>
                    <td class="p-2 border font-semibold text-slate-800">{{ $po->supplier->name ?? 'N/A' }}</td>
                    <td class="p-2 border text-slate-500">{{ $po->expected_delivery_date ? \Carbon\Carbon::parse($po->expected_delivery_date)->format('Y-m-d') : 'N/A' }}</td>
                    <td class="p-2 border text-center">{{ $po->details->sum('quantity') }}</td>
                    <td class="p-2 border text-right font-black">${{ number_format($po->total_amount, 2) }}</td>
                    <td class="p-2 border text-center">{{ $po->payment_status }}</td>
                    <td class="p-2 border text-center font-bold">{{ $po->status }}</td>
                </tr>
                @empty
                <tr><td colspan="9" class="p-4 text-center text-slate-400">No purchase orders found for this period.</td></tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'customer')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2 border text-center">#</th>
                    <th class="p-2 border">Customer Name</th>
                    <th class="p-2 border">Phone</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Type</th>
                    <th class="p-2 border text-center">Total Orders</th>
                    <th class="p-2 border text-right">Total Spent ($)</th>
                    <th class="p-2 border text-center">Points</th>
                    <th class="p-2 border text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($records as $idx => $c)
                <tr>
                    <td class="p-2 border text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2 border font-bold text-slate-900">{{ $c->name }}</td>
                    <td class="p-2 border text-slate-600">{{ $c->phone ?? 'N/A' }}</td>
                    <td class="p-2 border text-slate-500">{{ $c->email ?? 'N/A' }}</td>
                    <td class="p-2 border"><span class="capitalize">{{ $c->customer_type ?? 'Regular' }}</span></td>
                    <td class="p-2 border text-center font-bold text-blue-600">{{ $c->total_orders ?? 0 }}</td>
                    <td class="p-2 border text-right font-black text-emerald-600">${{ number_format($c->total_spent ?? 0, 2) }}</td>
                    <td class="p-2 border text-center font-bold text-amber-600">{{ $c->points ?? 0 }}</td>
                    <td class="p-2 border text-center">{{ $c->status ?? 'Active' }}</td>
                </tr>
                @empty
                <tr><td colspan="9" class="p-4 text-center text-slate-400">No customer records found.</td></tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'supplier')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2 border text-center">#</th>
                    <th class="p-2 border">Supplier Name</th>
                    <th class="p-2 border">Contact Person</th>
                    <th class="p-2 border">Phone</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border text-center">Total POs</th>
                    <th class="p-2 border text-right">Sourced Amount ($)</th>
                    <th class="p-2 border text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($records as $idx => $s)
                <tr>
                    <td class="p-2 border text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2 border font-bold text-slate-900">{{ $s->name }}</td>
                    <td class="p-2 border text-slate-700">{{ $s->contact_name ?? 'N/A' }}</td>
                    <td class="p-2 border text-slate-600">{{ $s->phone ?? 'N/A' }}</td>
                    <td class="p-2 border text-slate-500">{{ $s->email ?? 'N/A' }}</td>
                    <td class="p-2 border text-center font-bold">{{ $s->total_pos ?? 0 }}</td>
                    <td class="p-2 border text-right font-black text-blue-600">${{ number_format($s->total_sourced ?? 0, 2) }}</td>
                    <td class="p-2 border text-center font-bold">{{ $s->status ?? 'Active' }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="p-4 text-center text-slate-400">No supplier records found.</td></tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'repair_service')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2 border text-center">#</th>
                    <th class="p-2 border">Ticket Code</th>
                    <th class="p-2 border">Date</th>
                    <th class="p-2 border">Customer</th>
                    <th class="p-2 border">Device / Model</th>
                    <th class="p-2 border">Technician</th>
                    <th class="p-2 border text-right">Service Fee ($)</th>
                    <th class="p-2 border text-right">Parts Cost ($)</th>
                    <th class="p-2 border text-right">Total ($)</th>
                    <th class="p-2 border text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($records as $idx => $rep)
                <tr>
                    <td class="p-2 border text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2 border font-bold text-blue-600">{{ $rep->repair_code }}</td>
                    <td class="p-2 border text-slate-500">{{ \Carbon\Carbon::parse($rep->created_at)->format('Y-m-d') }}</td>
                    <td class="p-2 border font-semibold text-slate-800">{{ $rep->customer->name ?? 'Walk-in' }}</td>
                    <td class="p-2 border text-slate-600">{{ ($rep->device_type ?? '') . ' - ' . ($rep->model ?? '') }}</td>
                    <td class="p-2 border text-slate-600">{{ $rep->technician->name ?? 'Unassigned' }}</td>
                    <td class="p-2 border text-right">${{ number_format($rep->service_fee, 2) }}</td>
                    <td class="p-2 border text-right">${{ number_format($rep->parts_total, 2) }}</td>
                    <td class="p-2 border text-right font-black">${{ number_format($rep->total_cost, 2) }}</td>
                    <td class="p-2 border text-center font-bold">{{ $rep->status }}</td>
                </tr>
                @empty
                <tr><td colspan="10" class="p-4 text-center text-slate-400">No repair tickets recorded in this period.</td></tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'warranty')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2 border text-center">#</th>
                    <th class="p-2 border">Warranty Code</th>
                    <th class="p-2 border">Product</th>
                    <th class="p-2 border">Customer</th>
                    <th class="p-2 border">Purchase Date</th>
                    <th class="p-2 border">Expiry Date</th>
                    <th class="p-2 border text-center">Claims</th>
                    <th class="p-2 border text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($records as $idx => $w)
                <tr>
                    <td class="p-2 border text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2 border font-bold text-blue-600">{{ $w->warranty_code }}</td>
                    <td class="p-2 border font-semibold text-slate-800">{{ $w->product->name ?? ($w->product_name ?? 'N/A') }}</td>
                    <td class="p-2 border">{{ $w->customer->name ?? 'N/A' }}</td>
                    <td class="p-2 border text-slate-500">{{ $w->purchase_date ? \Carbon\Carbon::parse($w->purchase_date)->format('Y-m-d') : 'N/A' }}</td>
                    <td class="p-2 border text-slate-500">{{ $w->expiry_date ? \Carbon\Carbon::parse($w->expiry_date)->format('Y-m-d') : 'N/A' }}</td>
                    <td class="p-2 border text-center font-bold">{{ $w->claims->count() }}</td>
                    <td class="p-2 border text-center font-extrabold {{ strtolower($w->status) === 'active' ? 'text-emerald-600' : 'text-slate-400' }}">{{ $w->status }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="p-4 text-center text-slate-400">No warranty records found.</td></tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'revenue')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2 border text-center">#</th>
                    <th class="p-2 border">Date</th>
                    <th class="p-2 border text-right">POS Sales Revenue ($)</th>
                    <th class="p-2 border text-right">Repair Revenue ($)</th>
                    <th class="p-2 border text-right">Gross Total ($)</th>
                    <th class="p-2 border text-right">Cash Received ($)</th>
                    <th class="p-2 border text-right">Digital / Bank ($)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($records as $idx => $rev)
                <tr>
                    <td class="p-2 border text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2 border font-bold text-slate-800">{{ $rev['date'] }}</td>
                    <td class="p-2 border text-right">${{ number_format($rev['pos_revenue'], 2) }}</td>
                    <td class="p-2 border text-right">${{ number_format($rev['repair_revenue'], 2) }}</td>
                    <td class="p-2 border text-right font-black text-blue-600">${{ number_format($rev['total_revenue'], 2) }}</td>
                    <td class="p-2 border text-right text-emerald-600">${{ number_format($rev['cash_revenue'], 2) }}</td>
                    <td class="p-2 border text-right text-violet-600">${{ number_format($rev['digital_revenue'], 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="p-4 text-center text-slate-400">No revenue data for this date range.</td></tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'profit_loss')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2 border text-center">#</th>
                    <th class="p-2 border">Date</th>
                    <th class="p-2 border text-center">Orders</th>
                    <th class="p-2 border text-right">Gross Sales ($)</th>
                    <th class="p-2 border text-right">Cost of Goods ($)</th>
                    <th class="p-2 border text-right">Gross Profit ($)</th>
                    <th class="p-2 border text-right">Repair Net ($)</th>
                    <th class="p-2 border text-right">Net Profit ($)</th>
                    <th class="p-2 border text-center">Margin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($records as $idx => $day)
                <tr>
                    <td class="p-2 border text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2 border font-bold text-slate-800">{{ $day['date'] }}</td>
                    <td class="p-2 border text-center">{{ $day['orders_count'] }}</td>
                    <td class="p-2 border text-right font-bold text-slate-900">${{ number_format($day['revenue'], 2) }}</td>
                    <td class="p-2 border text-right text-rose-600 font-medium">${{ number_format($day['cost'], 2) }}</td>
                    <td class="p-2 border text-right text-emerald-600 font-bold">${{ number_format($day['profit'], 2) }}</td>
                    <td class="p-2 border text-right text-blue-600 font-bold">${{ number_format(($day['repair_revenue'] ?? 0) - ($day['repair_parts_cost'] ?? 0), 2) }}</td>
                    <td class="p-2 border text-right text-emerald-700 font-black">${{ number_format($day['net_profit'] ?? $day['profit'], 2) }}</td>
                    <td class="p-2 border text-center font-extrabold text-blue-600">{{ $day['margin'] }}%</td>
                </tr>
                @empty
                <tr><td colspan="9" class="p-4 text-center text-slate-400">No profit and loss data recorded for this period.</td></tr>
                @endforelse
            </tbody>
        </table>
        @endif
    </div>

    <!-- Sign-off Block for Formal Reports -->
    <div class="mt-12 pt-8 border-t border-slate-200 grid grid-cols-3 gap-6 text-center text-xs text-slate-500">
        <div>
            <p class="font-bold text-slate-700 uppercase tracking-wider text-[11px]">Prepared By</p>
            <div class="mt-14 border-b border-slate-300 w-40 mx-auto"></div>
            <p class="mt-1.5 text-[11px] font-semibold text-slate-800">{{ Auth::user()->name ?? 'Staff / Cashier' }}</p>
            <p class="text-[10px] text-slate-400">System Operator</p>
        </div>
        <div>
            <p class="font-bold text-slate-700 uppercase tracking-wider text-[11px]">Verified By</p>
            <div class="mt-14 border-b border-slate-300 w-40 mx-auto"></div>
            <p class="mt-1.5 text-[11px] font-semibold text-slate-800">Finance & Accounting</p>
            <p class="text-[10px] text-slate-400">Auditor</p>
        </div>
        <div>
            <p class="font-bold text-slate-700 uppercase tracking-wider text-[11px]">Approved By</p>
            <div class="mt-14 border-b border-slate-300 w-40 mx-auto"></div>
            <p class="mt-1.5 text-[11px] font-semibold text-slate-800">Shop Manager</p>
            <p class="text-[10px] text-slate-400">Managing Director</p>
        </div>
    </div>

</div>

</body>
</html>
