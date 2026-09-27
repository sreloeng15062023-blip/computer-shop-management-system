@extends('layouts.app')

@section('title', 'Report Management - TECHZONE')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Kantumruy+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<style>
    body {
        font-family: 'Plus Jakarta Sans', 'Kantumruy Pro', sans-serif;
        background: #F4F6FA;
    }

    [x-cloak] {
        display: none !important;
    }

    .sidebar-link {
        transition: all .15s ease;
    }

    .sidebar-link:hover {
        background: rgba(37, 99, 235, 0.12);
        color: #fff;
    }

    .sidebar-link.active {
        background: #2563EB;
        color: #fff;
        box-shadow: 0 4px 10px rgba(37, 99, 235, .35);
    }

    .tab-link {
        transition: all .15s ease;
    }

    .table-row:hover {
        background: #F8FAFF;
    }

    ::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }

    ::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 10px;
    }
</style>
@endpush

@php
// ---- KPI card definitions per report type (icon, color, label, value) ----
$kpiColorMap = [
'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
'emerald'=> ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600'],
'amber' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-600'],
'violet' => ['bg' => 'bg-violet-100', 'text' => 'text-violet-600'],
'rose' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-600'],
'slate' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600'],
];

if ($reportType === 'sales') {
$kpis = [
['icon' => 'fa-sack-dollar', 'color' => 'blue', 'label' => 'Total Revenue', 'value' => '$' . number_format($summary['total_revenue'] ?? 0, 2)],
['icon' => 'fa-receipt', 'color' => 'emerald', 'label' => 'Total Orders', 'value' => number_format($summary['total_orders'] ?? 0)],
['icon' => 'fa-boxes-packing', 'color' => 'amber', 'label' => 'Total Items Sold', 'value' => number_format($summary['total_items_sold'] ?? 0)],
['icon' => 'fa-chart-simple', 'color' => 'violet', 'label' => 'Average Order Value', 'value' => '$' . number_format($summary['average_order_value'] ?? 0, 2)],
];
} elseif ($reportType === 'inventory') {
$kpis = [
['icon' => 'fa-cubes', 'color' => 'blue', 'label' => 'Total Products', 'value' => number_format($summary['total_products'] ?? 0)],
['icon' => 'fa-layer-group', 'color' => 'emerald', 'label' => 'Total Units', 'value' => number_format($summary['total_units'] ?? 0)],
['icon' => 'fa-money-bill-wave', 'color' => 'amber', 'label' => 'Cost Valuation', 'value' => '$' . number_format($summary['cost_valuation'] ?? 0, 2)],
['icon' => 'fa-arrow-trend-up', 'color' => 'violet', 'label' => 'Potential Profit', 'value' => '$' . number_format($summary['potential_profit'] ?? 0, 2)],
];
} elseif ($reportType === 'profit_loss') {
$kpis = [
['icon' => 'fa-arrow-up-right-dots', 'color' => 'blue', 'label' => 'Sales Revenue', 'value' => '$' . number_format($summary['sales_revenue'] ?? 0, 2)],
['icon' => 'fa-truck-ramp-box', 'color' => 'rose', 'label' => 'Cost of Goods (COGS)', 'value' => '$' . number_format($summary['cost_of_goods_sold'] ?? 0, 2)],
['icon' => 'fa-hand-holding-dollar', 'color' => 'emerald', 'label' => 'Net Profit', 'value' => '$' . number_format($summary['net_profit'] ?? 0, 2)],
['icon' => 'fa-percent', 'color' => 'violet', 'label' => 'Profit Margin', 'value' => number_format($summary['profit_margin'] ?? 0, 1) . '%'],
];
} else {
$kpis = [
['icon' => 'fa-shield-halved', 'color' => 'emerald', 'label' => 'Active Warranties', 'value' => number_format($summary['active_warranties'] ?? 0)],
['icon' => 'fa-shield-heart', 'color' => 'slate', 'label' => 'Expired Warranties', 'value' => number_format($summary['expired_warranties'] ?? 0)],
['icon' => 'fa-file-shield', 'color' => 'blue', 'label' => 'Total Claims', 'value' => number_format($summary['total_claims'] ?? 0)],
['icon' => 'fa-percent', 'color' => 'amber', 'label' => 'Claim Rate', 'value' => number_format($summary['claim_rate'] ?? 0, 1) . '%'],
];
}

// ---- status badge color helper ----
$badgeClass = function ($status) {
$status = strtolower(trim((string) $status));
return match(true) {
in_array($status, ['completed', 'in stock', 'active', 'approved', 'success']) => 'bg-emerald-100 text-emerald-700',
in_array($status, ['pending', 'low stock']) => 'bg-amber-100 text-amber-700',
in_array($status, ['out of stock', 'expired', 'rejected', 'cancelled']) => 'bg-rose-100 text-rose-700',
default => 'bg-slate-100 text-slate-600',
};
};
@endphp

@section('content')
<div class="flex min-h-screen bg-[#F4F6FA]" x-data="{ sidebarOpen:false }">

    {{-- ============================= SIDEBAR ============================= --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed z-40 inset-y-0 left-0 w-72 bg-[#0B132B] text-slate-300 flex flex-col transition-transform duration-300 lg:static lg:translate-x-0">
        <div class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
            <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-900/40">
                <i class="fa-solid fa-cube text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-white font-extrabold tracking-wide text-lg leading-none">TECHZONE</h1>
                <p class="text-[11px] text-slate-400 mt-1">Computer Shop Management System</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-4 py-5 space-y-1 text-sm font-medium">
            <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house w-5 text-center"></i> Dashboard
            </a>
            <a href="{{ route('products.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="fa-solid fa-boxes-packing w-5 text-center"></i> Product Management
            </a>
            <a href="{{ route('purchases') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('purchases') ? 'active' : '' }}">
                <i class="fa-solid fa-cart-shopping w-5 text-center"></i> Purchase Management
            </a>
            <a href="{{ route('inventory') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('inventory') ? 'active' : '' }}">
                <i class="fa-solid fa-warehouse w-5 text-center"></i> Inventory Management
            </a>
            <a href="{{ route('pos.sales') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('pos.sales') ? 'active' : '' }}">
                <i class="fa-solid fa-cash-register w-5 text-center"></i> Sales Management (POS)
            </a>
            <a href="{{ route('repair.service') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('repair.service') ? 'active' : '' }}">
                <i class="fa-solid fa-screwdriver-wrench w-5 text-center"></i> Repair Service Management
            </a>
            <a href="{{ route('warranty') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('warranty') ? 'active' : '' }}">
                <i class="fa-solid fa-shield-halved w-5 text-center"></i> Warranty Management
            </a>
            <a href="{{ route('invoices') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('invoices') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Payment &amp; Invoice
            </a>
            <a href="{{ route('employees') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('employees') ? 'active' : '' }}">
                <i class="fa-solid fa-user-tie w-5 text-center"></i> Employee Management
            </a>
            <a href="{{ route('customers') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('customers') ? 'active' : '' }}">
                <i class="fa-solid fa-users w-5 text-center"></i> Customer Management
            </a>
            <a href="{{ route('reports') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl active">
                <i class="fa-solid fa-chart-column w-5 text-center"></i> Report Management
            </a>
            <a href="{{ route('settings') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl {{ request()->routeIs('settings') ? 'active' : '' }}">
                <i class="fa-solid fa-gear w-5 text-center"></i> Settings
            </a>
        </nav>

        <div class="px-4 py-4 border-t border-white/10 flex items-center gap-3">
            <img src="{{ Auth::user()->avatar ?? asset('images/avatar-default.png') }}" class="w-10 h-10 rounded-full object-cover border border-white/20" alt="avatar">
            <div class="flex-1 min-w-0">
                <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name ?? 'Sok Dara' }}</p>
                <p class="text-xs text-slate-400">{{ Auth::user()->role ?? 'Administrator' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-slate-400 hover:text-white transition" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    <div class="fixed inset-0 bg-black/40 z-30 lg:hidden" x-show="sidebarOpen" @click="sidebarOpen=false" x-cloak></div>

    {{-- ============================= MAIN ============================= --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- TOP NAVBAR --}}
        <header class="sticky top-0 z-20 bg-white/90 backdrop-blur border-b border-slate-200/80 px-4 sm:px-6 py-3 flex items-center gap-4">
            <button @click="sidebarOpen=true" class="lg:hidden text-slate-600 text-xl"><i class="fa-solid fa-bars"></i></button>

            <div class="flex-1 max-w-xl relative hidden sm:block">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" placeholder="Search reports, transactions, or products..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-100 border border-transparent focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 text-sm outline-none transition">
            </div>

            <div class="ml-auto flex items-center gap-4">
                <button class="relative w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition">
                    <i class="fa-regular fa-bell"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-500 text-white text-[10px] flex items-center justify-center">3</span>
                </button>
                <div class="hidden sm:flex items-center gap-3 pl-4 border-l border-slate-200">
                    <img src="{{ Auth::user()->avatar ?? asset('images/avatar-default.png') }}" class="w-10 h-10 rounded-full object-cover" alt="avatar">
                    <div class="leading-tight">
                        <p class="text-sm font-bold text-slate-800">{{ Auth::user()->name ?? 'Sok Dara' }}</p>
                        <p class="text-xs text-slate-500">{{ Auth::user()->role ?? 'Administrator' }}</p>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 space-y-6">

            {{-- PAGE HEADER --}}
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <i class="fa-solid fa-chart-column text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-800">Report Management</h2>
                        <p class="text-sm text-slate-500 mt-0.5">View, filter and export all business reports from your shop system.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('reports.export', request()->all()) }}"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold shadow-md shadow-emerald-500/30 transition">
                        <i class="fa-solid fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('reports.print', request()->all()) }}" target="_blank"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-md shadow-blue-600/30 transition">
                        <i class="fa-solid fa-print"></i> Print / PDF
                    </a>
                </div>
            </div>

            {{-- REPORT CATEGORY TABS --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl p-2 flex flex-wrap gap-2">
                @php
                $tabs = [
                'sales' => ['label' => 'Daily Sales', 'icon' => 'fa-cash-register'],
                'inventory' => ['label' => 'Inventory Status', 'icon' => 'fa-boxes-stacked'],
                'profit_loss' => ['label' => 'Profit & Loss', 'icon' => 'fa-scale-balanced'],
                'warranty' => ['label' => 'Warranty & Claims', 'icon' => 'fa-shield-halved'],
                ];
                @endphp
                @foreach($tabs as $key => $tab)
                <a href="{{ route('reports', ['type' => $key, 'start_date' => $startDate, 'end_date' => $endDate]) }}"
                    class="tab-link flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold
                       {{ $reportType === $key ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-500 hover:bg-slate-100' }}">
                    <i class="fa-solid {{ $tab['icon'] }}"></i> {{ $tab['label'] }}
                </a>
                @endforeach
            </div>

            {{-- FILTER BAR --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5">
                <form method="GET" action="{{ route('reports') }}" class="flex flex-wrap items-end gap-4">
                    <input type="hidden" name="type" value="{{ $reportType }}">

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-slate-500">Start Date</label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                            class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none">
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-slate-500">End Date</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none">
                    </div>

                    @if($reportType === 'inventory')
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-slate-500">Category</label>
                        <select name="category_id" class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none min-w-[160px]">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-slate-500">Status</label>
                        <select name="status" class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none min-w-[160px]">
                            <option value="" {{ request('status') === null ? 'selected' : '' }}>All Status</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        </select>
                    </div>
                    @endif

                    <div class="flex flex-col gap-1 flex-1 min-w-[220px]">
                        <label class="text-xs font-semibold text-slate-500">Search</label>
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search invoice, customer, or code..."
                                class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none">
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-md shadow-blue-600/30 transition">
                            <i class="fa-solid fa-filter"></i> Apply Filter
                        </button>
                        <a href="{{ route('reports', ['type' => $reportType]) }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- KPI SUMMARY CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                @foreach($kpis as $kpi)
                @php $colors = $kpiColorMap[$kpi['color']]; @endphp
                <div class="bg-white border border-slate-200/80 rounded-2xl p-5 flex items-center gap-4 hover:shadow-lg hover:shadow-slate-200/60 transition">
                    <div class="w-14 h-14 rounded-2xl {{ $colors['bg'] }} flex items-center justify-center shrink-0">
                        <i class="fa-solid {{ $kpi['icon'] }} {{ $colors['text'] }} text-xl"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-slate-500 truncate">{{ $kpi['label'] }}</p>
                        <p class="text-2xl font-extrabold text-slate-800 mt-1 truncate">{{ $kpi['value'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- CHART --}}
            @if($reportType === 'sales' || $reportType === 'profit_loss')
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                            <i class="fa-solid fa-chart-line text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">{{ $reportType === 'sales' ? 'Sales Trend Overview' : 'Revenue vs Cost Trend' }}</h3>
                            <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="h-72">
                    <canvas id="reportTrendChart"></canvas>
                </div>
            </div>
            @endif

            {{-- DETAILED DATA TABLE --}}
            <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800">
                        @if($reportType === 'sales') Daily Sales Detailed Report
                        @elseif($reportType === 'inventory') Inventory Status Detailed Report
                        @elseif($reportType === 'profit_loss') Profit &amp; Loss Detailed Report
                        @else Warranty &amp; Claims Detailed Report
                        @endif
                    </h3>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-50 text-blue-600">{{ count($records) }} Records</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                                @if($reportType === 'sales')
                                <th class="px-5 py-3 text-left">Invoice #</th>
                                <th class="px-5 py-3 text-left">Date</th>
                                <th class="px-5 py-3 text-left">Customer</th>
                                <th class="px-5 py-3 text-left">Items</th>
                                <th class="px-5 py-3 text-right">Total</th>
                                <th class="px-5 py-3 text-center">Status</th>
                                @elseif($reportType === 'inventory')
                                <th class="px-5 py-3 text-left">Code</th>
                                <th class="px-5 py-3 text-left">Product Name</th>
                                <th class="px-5 py-3 text-left">Category</th>
                                <th class="px-5 py-3 text-right">Stock Qty</th>
                                <th class="px-5 py-3 text-right">Unit Cost</th>
                                <th class="px-5 py-3 text-center">Status</th>
                                @elseif($reportType === 'profit_loss')
                                <th class="px-5 py-3 text-left">Date</th>
                                <th class="px-5 py-3 text-left">Reference</th>
                                <th class="px-5 py-3 text-right">Revenue</th>
                                <th class="px-5 py-3 text-right">COGS</th>
                                <th class="px-5 py-3 text-right">Profit</th>
                                <th class="px-5 py-3 text-center">Margin</th>
                                @else
                                <th class="px-5 py-3 text-left">Claim #</th>
                                <th class="px-5 py-3 text-left">Product</th>
                                <th class="px-5 py-3 text-left">Customer</th>
                                <th class="px-5 py-3 text-left">Claim Date</th>
                                <th class="px-5 py-3 text-left">Expiry Date</th>
                                <th class="px-5 py-3 text-center">Status</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $record)
                            @php
                            // supports both Eloquent model objects and plain arrays
                            $get = fn($key) => is_array($record) ? ($record[$key] ?? null) : ($record->{$key} ?? null);
                            @endphp
                            <tr class="table-row transition">
                                @if($reportType === 'sales')
                                <td class="px-5 py-3.5 font-semibold text-blue-600">{{ $get('invoice_no') }}</td>
                                <td class="px-5 py-3.5 text-slate-600">{{ \Carbon\Carbon::parse($get('date'))->format('Y-m-d') }}</td>
                                <td class="px-5 py-3.5 text-slate-700 font-medium">{{ $get('customer_name') }}</td>
                                <td class="px-5 py-3.5 text-slate-600">{{ $get('items_count') }}</td>
                                <td class="px-5 py-3.5 text-right font-bold text-slate-800">${{ number_format($get('total'), 2) }}</td>
                                <td class="px-5 py-3.5 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold capitalize {{ $badgeClass($get('status')) }}">{{ $get('status') }}</span>
                                </td>
                                @elseif($reportType === 'inventory')
                                <td class="px-5 py-3.5 font-semibold text-blue-600">{{ $get('code') }}</td>
                                <td class="px-5 py-3.5 text-slate-700 font-medium">{{ $get('name') }}</td>
                                <td class="px-5 py-3.5 text-slate-600">{{ $get('category_name') }}</td>
                                <td class="px-5 py-3.5 text-right text-slate-700">{{ $get('stock_qty') }}</td>
                                <td class="px-5 py-3.5 text-right font-bold text-slate-800">${{ number_format($get('unit_cost'), 2) }}</td>
                                <td class="px-5 py-3.5 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold capitalize {{ $badgeClass($get('stock_status')) }}">{{ $get('stock_status') }}</span>
                                </td>
                                @elseif($reportType === 'profit_loss')
                                <td class="px-5 py-3.5 text-slate-600">{{ \Carbon\Carbon::parse($get('date'))->format('Y-m-d') }}</td>
                                <td class="px-5 py-3.5 font-semibold text-blue-600">{{ $get('reference') }}</td>
                                <td class="px-5 py-3.5 text-right text-slate-700">${{ number_format($get('revenue'), 2) }}</td>
                                <td class="px-5 py-3.5 text-right text-rose-500">${{ number_format($get('cogs'), 2) }}</td>
                                <td class="px-5 py-3.5 text-right font-bold text-emerald-600">${{ number_format($get('profit'), 2) }}</td>
                                <td class="px-5 py-3.5 text-center font-semibold text-slate-600">{{ number_format($get('margin'), 1) }}%</td>
                                @else
                                <td class="px-5 py-3.5 font-semibold text-blue-600">{{ $get('claim_no') }}</td>
                                <td class="px-5 py-3.5 text-slate-700 font-medium">{{ $get('product_name') }}</td>
                                <td class="px-5 py-3.5 text-slate-600">{{ $get('customer_name') }}</td>
                                <td class="px-5 py-3.5 text-slate-600">{{ \Carbon\Carbon::parse($get('claim_date'))->format('Y-m-d') }}</td>
                                <td class="px-5 py-3.5 text-slate-600">{{ \Carbon\Carbon::parse($get('expiry_date'))->format('Y-m-d') }}</td>
                                <td class="px-5 py-3.5 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold capitalize {{ $badgeClass($get('status')) }}">{{ $get('status') }}</span>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-400">
                                        <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center">
                                            <i class="fa-solid fa-folder-open text-2xl"></i>
                                        </div>
                                        <p class="font-semibold text-slate-500">No records found</p>
                                        <p class="text-xs">Try adjusting your date range or filters.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('reportTrendChart');
        if (!canvas) return;

        const chartLabels = @json($chartLabels ?? []);
        const chartRevenue = @json($chartRevenue ?? []);
        const chartCost = @json($chartCost ?? []);

        const datasets = [{
            label: 'Revenue',
            data: chartRevenue,
            borderColor: '#2563EB',
            backgroundColor: 'rgba(37,99,235,0.08)',
            fill: true,
            tension: 0.4,
            pointRadius: 3,
            pointBackgroundColor: '#2563EB',
        }];

        @if($reportType === 'profit_loss')
        datasets.push({
            label: 'Cost of Goods',
            data: chartCost,
            borderColor: '#EF4444',
            backgroundColor: 'rgba(239,68,68,0.05)',
            fill: true,
            tension: 0.4,
            pointRadius: 3,
            pointBackgroundColor: '#EF4444',
        });
        @endif

        new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 10,
                            usePointStyle: true
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F1F5F9'
                        },
                        ticks: {
                            callback: v => '$' + v
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endpush