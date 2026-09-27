<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHZONE - {{ ucfirst($reportType) }} Report ({{ $startDate }} to {{ $endDate }})</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', 'Kantumruy Pro', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
            @page { margin: 12mm; size: auto; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 p-6 md:p-10">

<div class="max-w-5xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
    
    <!-- Print Action Bar -->
    <div class="no-print flex items-center justify-between pb-6 mb-6 border-b border-slate-200">
        <a href="{{ route('reports') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Back to Reports
        </a>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/20 transition flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Print Report / Save PDF
            </button>
        </div>
    </div>

    <!-- Company Header -->
    <div class="flex items-start justify-between border-b pb-6 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-2xl font-bold">
                <i class="fa-solid fa-cube"></i>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-wider">TECHZONE</h1>
                <p class="text-xs text-slate-500">Computer Shop Management System</p>
                <p class="text-xs text-slate-400">Phnom Penh, Cambodia • Tel: +855 12 345 678</p>
            </div>
        </div>
        <div class="text-right">
            <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-extrabold uppercase tracking-wider mb-1">
                {{ strtoupper($reportType) }} REPORT
            </span>
            <div class="text-xs text-slate-500">Date Range: <span class="font-bold text-slate-800">{{ $startDate }}</span> to <span class="font-bold text-slate-800">{{ $endDate }}</span></div>
            <div class="text-[11px] text-slate-400">Generated: {{ date('Y-m-d H:i') }}</div>
        </div>
    </div>

    <!-- Summary Metrics Grid -->
    <div class="mb-8">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Report Summary Overview</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach($summary as $key => $val)
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                <div class="text-[11px] font-bold text-slate-500 uppercase">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                <div class="text-lg font-black text-slate-900 mt-0.5">
                    @if(str_contains($key, 'revenue') || str_contains($key, 'profit') || str_contains($key, 'cost') || str_contains($key, 'value') || str_contains($key, 'tax') || str_contains($key, 'discount') || str_contains($key, 'sales'))
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
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Detailed Records</h3>

        @if($reportType === 'sales')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2.5 border">#</th>
                    <th class="p-2.5 border">Sale No</th>
                    <th class="p-2.5 border">Date</th>
                    <th class="p-2.5 border">Customer</th>
                    <th class="p-2.5 border text-center">Items</th>
                    <th class="p-2.5 border">Method</th>
                    <th class="p-2.5 border text-right">Total</th>
                    <th class="p-2.5 border text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($records as $idx => $r)
                <tr>
                    <td class="p-2.5 border text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2.5 border font-bold text-blue-600">{{ $r->sale_number }}</td>
                    <td class="p-2.5 border text-slate-500">{{ \Carbon\Carbon::parse($r->sale_date)->format('Y-m-d') }}</td>
                    <td class="p-2.5 border font-semibold text-slate-800">{{ $r->customer->name ?? 'Walk-in' }}</td>
                    <td class="p-2.5 border text-center">{{ $r->details->sum('quantity') }}</td>
                    <td class="p-2.5 border">{{ $r->payment_method ?? 'Cash' }}</td>
                    <td class="p-2.5 border text-right font-black">${{ number_format($r->total_amount, 2) }}</td>
                    <td class="p-2.5 border text-center font-bold">{{ ucfirst($r->status ?? 'Completed') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @elseif($reportType === 'inventory')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2.5 border">#</th>
                    <th class="p-2.5 border">Product Name</th>
                    <th class="p-2.5 border">SKU</th>
                    <th class="p-2.5 border">Category</th>
                    <th class="p-2.5 border text-right">Cost ($)</th>
                    <th class="p-2.5 border text-right">Price ($)</th>
                    <th class="p-2.5 border text-center">In Stock</th>
                    <th class="p-2.5 border text-right">Value ($)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($records as $idx => $p)
                <tr>
                    <td class="p-2.5 border text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2.5 border font-bold text-slate-800">{{ $p->name }}</td>
                    <td class="p-2.5 border text-slate-500">{{ $p->sku }}</td>
                    <td class="p-2.5 border">{{ $p->category->name ?? 'N/A' }}</td>
                    <td class="p-2.5 border text-right">${{ number_format($p->cost_price, 2) }}</td>
                    <td class="p-2.5 border text-right font-semibold">${{ number_format($p->selling_price, 2) }}</td>
                    <td class="p-2.5 border text-center font-bold {{ $p->stock_quantity <= $p->min_stock_alert ? 'text-rose-600' : 'text-emerald-600' }}">{{ $p->stock_quantity }}</td>
                    <td class="p-2.5 border text-right font-black">${{ number_format($p->stock_quantity * $p->cost_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @elseif($reportType === 'profit_loss')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2.5 border">#</th>
                    <th class="p-2.5 border">Date</th>
                    <th class="p-2.5 border text-center">Orders</th>
                    <th class="p-2.5 border text-right">Gross Sales ($)</th>
                    <th class="p-2.5 border text-right">Cost of Goods ($)</th>
                    <th class="p-2.5 border text-right">Gross Profit ($)</th>
                    <th class="p-2.5 border text-center">Margin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($records as $idx => $day)
                <tr>
                    <td class="p-2.5 border text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2.5 border font-bold text-slate-800">{{ $day['date'] }}</td>
                    <td class="p-2.5 border text-center">{{ $day['orders_count'] }}</td>
                    <td class="p-2.5 border text-right font-bold text-slate-900">${{ number_format($day['revenue'], 2) }}</td>
                    <td class="p-2.5 border text-right text-rose-600 font-medium">${{ number_format($day['cost'], 2) }}</td>
                    <td class="p-2.5 border text-right text-emerald-600 font-black">${{ number_format($day['profit'], 2) }}</td>
                    <td class="p-2.5 border text-center font-extrabold text-blue-600">{{ $day['margin'] }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @elseif($reportType === 'warranty')
        <table class="w-full text-left text-xs border border-slate-200">
            <thead class="bg-slate-100 text-slate-700 font-bold uppercase text-[10px]">
                <tr>
                    <th class="p-2.5 border">#</th>
                    <th class="p-2.5 border">Warranty Code</th>
                    <th class="p-2.5 border">Product</th>
                    <th class="p-2.5 border">Customer</th>
                    <th class="p-2.5 border">Purchase Date</th>
                    <th class="p-2.5 border">Expiry Date</th>
                    <th class="p-2.5 border text-center">Claims</th>
                    <th class="p-2.5 border text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($records as $idx => $w)
                <tr>
                    <td class="p-2.5 border text-slate-400 font-bold">{{ $idx + 1 }}</td>
                    <td class="p-2.5 border font-bold text-blue-600">{{ $w->warranty_code }}</td>
                    <td class="p-2.5 border font-semibold text-slate-800">{{ $w->product->name ?? $w->product_name }}</td>
                    <td class="p-2.5 border">{{ $w->customer->name ?? 'N/A' }}</td>
                    <td class="p-2.5 border text-slate-500">{{ $w->purchase_date ? \Carbon\Carbon::parse($w->purchase_date)->format('Y-m-d') : 'N/A' }}</td>
                    <td class="p-2.5 border text-slate-500">{{ $w->expiry_date ? \Carbon\Carbon::parse($w->expiry_date)->format('Y-m-d') : 'N/A' }}</td>
                    <td class="p-2.5 border text-center font-bold">{{ $w->claims->count() }}</td>
                    <td class="p-2.5 border text-center font-extrabold {{ strtolower($w->status) === 'active' ? 'text-emerald-600' : 'text-slate-400' }}">{{ $w->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Sign-off Block -->
    <div class="mt-12 pt-8 border-t border-slate-200 grid grid-cols-3 gap-6 text-center text-xs text-slate-500">
        <div>
            <p class="font-bold text-slate-700">Prepared By</p>
            <div class="mt-12 border-b border-slate-300 w-36 mx-auto"></div>
            <p class="mt-1 text-[11px]">{{ Auth::user()->name ?? 'Staff' }}</p>
        </div>
        <div>
            <p class="font-bold text-slate-700">Verified By</p>
            <div class="mt-12 border-b border-slate-300 w-36 mx-auto"></div>
            <p class="mt-1 text-[11px]">Finance Department</p>
        </div>
        <div>
            <p class="font-bold text-slate-700">Approved By</p>
            <div class="mt-12 border-b border-slate-300 w-36 mx-auto"></div>
            <p class="mt-1 text-[11px]">Shop Manager / Director</p>
        </div>
    </div>

</div>

</body>
</html>
