<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Report Management | TECHZONE Computer Shop</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', 'Kantumruy Pro', sans-serif; }
        .scrollbar-thin::-webkit-scrollbar { width: 5px; height: 5px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #f1f5f9; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 9999px; }
    </style>
</head>
<body class="bg-[#F4F6FA] text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

<div class="flex min-h-screen">

    {{-- ========================================================================= --}}
    {{-- 1. TECHZONE SIDEBAR NAVIGATION                                            --}}
    {{-- ========================================================================= --}}
    <aside id="sidebarMenu" class="w-64 bg-[#0B132B] text-slate-300 flex-shrink-0 hidden lg:flex flex-col fixed h-screen z-30 shadow-2xl transition-all duration-300 select-none">
        
        <!-- Brand Header -->
        <div class="px-5 py-5 border-b border-slate-800/80 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                <i class="fa-solid fa-cube text-xl"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-lg text-white tracking-wider leading-none">TECHZONE</h1>
                <p class="text-[10px] text-blue-400 font-medium tracking-tight mt-1">Computer Shop Management</p>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto scrollbar-thin">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-house w-5 text-center text-sm"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-box-open w-5 text-center text-sm"></i>
                <span>Product Management</span>
            </a>

            <a href="{{ route('purchases') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('purchases*') || request()->routeIs('purchase-orders*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-cart-shopping w-5 text-center text-sm"></i>
                <span>Purchase Management</span>
            </a>

            <a href="{{ route('inventory') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('inventory*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-warehouse w-5 text-center text-sm"></i>
                <span>Inventory Management</span>
            </a>

            <a href="{{ route('pos.sales') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('pos.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-cash-register w-5 text-center text-sm"></i>
                <span>Sales Management (POS)</span>
            </a>

            <a href="{{ route('repair.service') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('repair.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-wrench w-5 text-center text-sm"></i>
                <span>Repair Service Management</span>
            </a>

            <a href="{{ route('warranty') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('warranty*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-shield-halved w-5 text-center text-sm"></i>
                <span>Warranty Management</span>
            </a>

            <a href="{{ route('invoices') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('invoices*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-sm"></i>
                <span>Payment & Invoice</span>
            </a>

            <a href="{{ route('employees') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('employees*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-user-gear w-5 text-center text-sm"></i>
                <span>Employee Management</span>
            </a>

            <a href="{{ route('customers') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('customers*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-users w-5 text-center text-sm"></i>
                <span>Customer Management</span>
            </a>

            <!-- Report Management (Active) -->
            <a href="{{ route('reports') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-md {{ request()->routeIs('reports*') ? 'bg-blue-600 text-white shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-chart-pie w-5 text-center text-sm"></i>
                    <span>Report Management</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            </a>

            <a href="{{ route('notifications') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('notifications*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-bell w-5 text-center text-sm"></i>
                    <span>Notification</span>
                </div>
                <span class="px-2 py-0.5 text-[11px] font-bold bg-rose-500 text-white rounded-full">3</span>
            </a>

            <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('settings*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-gear w-5 text-center text-sm"></i>
                <span>Settings</span>
            </a>
        </nav>

        <!-- Sidebar User Footer -->
        <div class="p-3 border-t border-slate-800/80 bg-slate-900/50">
            <div class="flex items-center justify-between p-2 rounded-xl bg-slate-800/40">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold text-xs ring-2 ring-blue-500/20">
                        {{ strtoupper(substr(Auth::user()->name ?? 'SD', 0, 2)) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Sok Dara' }}</div>
                        <div class="text-[10px] text-slate-400 truncate">{{ Auth::user()->role->role_name ?? 'Administrator' }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" title="Logout" class="text-slate-400 hover:text-rose-400 text-sm p-1 transition">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ========================================================================= --}}
    {{-- 2. MAIN CONTENT AREA                                                     --}}
    {{-- ========================================================================= --}}
    <main class="flex-1 lg:ml-64 flex flex-col min-w-0 min-h-screen">
        
        <!-- Top Navigation Bar -->
        <header class="bg-white border-b border-slate-200/80 px-6 py-3.5 flex items-center justify-between sticky top-0 z-20 shadow-sm backdrop-blur-md bg-white/95">
            <div class="flex items-center gap-4 flex-1 max-w-xl">
                <button onclick="document.getElementById('sidebarMenu').classList.toggle('hidden')" class="lg:hidden text-slate-600 hover:text-blue-600 p-2 rounded-lg hover:bg-slate-100 transition">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="relative w-full">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" placeholder="Search reports, sales, or products..." class="w-full pl-10 pr-4 py-2 bg-slate-100/80 border border-transparent rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition text-slate-700">
                </div>
            </div>

            <div class="flex items-center gap-4 pl-4">
                <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                        {{ strtoupper(substr(Auth::user()->name ?? 'SD', 0, 2)) }}
                    </div>
                    <div class="hidden md:block text-left">
                        <div class="text-xs font-bold text-slate-800 leading-tight">{{ Auth::user()->name ?? 'Sok Dara' }}</div>
                        <div class="text-[11px] font-semibold text-blue-600 leading-tight">{{ Auth::user()->role->role_name ?? 'Administrator' }}</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Body Container -->
        <div class="p-5 lg:p-7 space-y-6">

            <!-- Page Title & Top Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shadow-sm">
                        <i class="fa-solid fa-chart-line text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Report Management</h2>
                        <p class="text-xs font-medium text-slate-500">Comprehensive sales, inventory, profit & loss, and warranty analytics.</p>
                    </div>
                </div>

                <!-- Export & Print Action Buttons -->
                <div class="flex items-center gap-2.5">
                    <a href="{{ route('reports.export', request()->all()) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm flex items-center gap-2 transition hover:scale-105">
                        <i class="fa-solid fa-file-excel"></i>
                        <span>Export Excel (CSV)</span>
                    </a>
                    <a href="{{ route('reports.print', request()->all()) }}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-sm flex items-center gap-2 transition hover:scale-105">
                        <i class="fa-solid fa-print"></i>
                        <span>Print / PDF</span>
                    </a>
                </div>
            </div>

            <!-- Report Navigation Tabs -->
            <div class="bg-white p-1.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-wrap gap-1">
                <a href="{{ route('reports', ['type' => 'sales', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="flex-1 min-w-[130px] py-2.5 px-4 text-center rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 {{ $reportType === 'sales' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-cash-register"></i>
                    <span>Daily Sales</span>
                </a>
                <a href="{{ route('reports', ['type' => 'inventory', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="flex-1 min-w-[130px] py-2.5 px-4 text-center rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 {{ $reportType === 'inventory' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <span>Inventory Status</span>
                </a>
                <a href="{{ route('reports', ['type' => 'profit_loss', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="flex-1 min-w-[130px] py-2.5 px-4 text-center rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 {{ $reportType === 'profit_loss' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-scale-balanced"></i>
                    <span>Profit & Loss</span>
                </a>
                <a href="{{ route('reports', ['type' => 'warranty', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="flex-1 min-w-[130px] py-2.5 px-4 text-center rounded-xl text-xs font-bold transition flex items-center justify-center gap-2 {{ $reportType === 'warranty' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Warranty & Claims</span>
                </a>
            </div>

            <!-- Filter Bar Card -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                <form method="GET" action="{{ route('reports') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 items-end">
                    <input type="hidden" name="type" value="{{ $reportType }}">

                    <!-- Start Date -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Start Date</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-blue-500">
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">End Date</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-blue-500">
                    </div>

                    <!-- Conditional Extra Filter -->
                    @if($reportType === 'inventory')
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Category</label>
                        <select name="category_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-blue-500">
                            <option value="all">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Status / Method</label>
                        <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-blue-500">
                            <option value="all">All Statuses</option>
                            <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                        </select>
                    </div>
                    @endif

                    <!-- Search Input -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Search Keyword</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Invoice, customer, or code..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-blue-500">
                    </div>

                    <!-- Filter Actions -->
                    <div class="flex items-center gap-2">
                        <button type="submit" class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-filter"></i> Apply Filter
                        </button>
                        <a href="{{ route('reports', ['type' => $reportType]) }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Summary KPI Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($summary as $key => $val)
                <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                    <div class="text-xl font-black text-slate-900 mt-2">
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

            <!-- Detailed Table Card -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <h3 class="font-extrabold text-sm text-slate-900 capitalize">{{ str_replace('_', ' ', $reportType) }} Detailed Report</h3>
                    <span class="text-xs text-slate-400">Total: <strong class="text-slate-800">{{ is_array($records) ? count($records) : $records->count() }}</strong> items</span>
                </div>

                @if($reportType === 'sales')
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-slate-400 uppercase text-[10px] font-bold border-b border-slate-100">
                                <th class="py-2.5 px-3">#</th>
                                <th class="py-2.5 px-3">Sale Number</th>
                                <th class="py-2.5 px-3">Date</th>
                                <th class="py-2.5 px-3">Customer</th>
                                <th class="py-2.5 px-3 text-center">Items</th>
                                <th class="py-2.5 px-3">Payment</th>
                                <th class="py-2.5 px-3 text-right">Total ($)</th>
                                <th class="py-2.5 px-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @forelse($records as $idx => $r)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-2.5 px-3 font-bold text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-2.5 px-3 font-bold text-blue-600">{{ $r->sale_number }}</td>
                                <td class="py-2.5 px-3 text-slate-500">{{ \Carbon\Carbon::parse($r->sale_date)->format('Y-m-d') }}</td>
                                <td class="py-2.5 px-3 font-semibold text-slate-800">{{ $r->customer->name ?? 'Walk-in' }}</td>
                                <td class="py-2.5 px-3 text-center font-bold">{{ $r->details->sum('quantity') }}</td>
                                <td class="py-2.5 px-3"><span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded-md text-[10px] font-bold">{{ $r->payment_method ?? 'Cash' }}</span></td>
                                <td class="py-2.5 px-3 text-right font-black text-slate-900">${{ number_format($r->total_amount, 2) }}</td>
                                <td class="py-2.5 px-3 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ strtolower($r->status) === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ ucfirst($r->status ?? 'Completed') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center py-6 text-slate-400">No sales transactions found for this period.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @elseif($reportType === 'inventory')
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-slate-400 uppercase text-[10px] font-bold border-b border-slate-100">
                                <th class="py-2.5 px-3">#</th>
                                <th class="py-2.5 px-3">Product</th>
                                <th class="py-2.5 px-3">SKU</th>
                                <th class="py-2.5 px-3">Category</th>
                                <th class="py-2.5 px-3 text-right">Cost ($)</th>
                                <th class="py-2.5 px-3 text-right">Price ($)</th>
                                <th class="py-2.5 px-3 text-center">In Stock</th>
                                <th class="py-2.5 px-3 text-right">Valuation ($)</th>
                                <th class="py-2.5 px-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @forelse($records as $idx => $p)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-2.5 px-3 font-bold text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-2.5 px-3 font-bold text-slate-800">{{ $p->name }}</td>
                                <td class="py-2.5 px-3 text-slate-500">{{ $p->sku }}</td>
                                <td class="py-2.5 px-3">{{ $p->category->name ?? 'N/A' }}</td>
                                <td class="py-2.5 px-3 text-right">${{ number_format($p->cost_price, 2) }}</td>
                                <td class="py-2.5 px-3 text-right font-bold text-slate-900">${{ number_format($p->selling_price, 2) }}</td>
                                <td class="py-2.5 px-3 text-center font-bold">{{ $p->stock_quantity }}</td>
                                <td class="py-2.5 px-3 text-right font-black text-slate-900">${{ number_format($p->stock_quantity * $p->cost_price, 2) }}</td>
                                <td class="py-2.5 px-3 text-center">
                                    @if($p->stock_quantity <= 0)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700">Out of Stock</span>
                                    @elseif($p->stock_quantity <= $p->min_stock_alert)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">Low Stock</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="text-center py-6 text-slate-400">No inventory products matched.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @elseif($reportType === 'profit_loss')
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-slate-400 uppercase text-[10px] font-bold border-b border-slate-100">
                                <th class="py-2.5 px-3">#</th>
                                <th class="py-2.5 px-3">Date</th>
                                <th class="py-2.5 px-3 text-center">Orders</th>
                                <th class="py-2.5 px-3 text-right">Revenue ($)</th>
                                <th class="py-2.5 px-3 text-right">Cost (COGS) ($)</th>
                                <th class="py-2.5 px-3 text-right">Gross Profit ($)</th>
                                <th class="py-2.5 px-3 text-center">Margin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @forelse($records as $idx => $day)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-2.5 px-3 font-bold text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-2.5 px-3 font-bold text-slate-800">{{ $day['date'] }}</td>
                                <td class="py-2.5 px-3 text-center font-semibold">{{ $day['orders_count'] }}</td>
                                <td class="py-2.5 px-3 text-right font-bold text-slate-900">${{ number_format($day['revenue'], 2) }}</td>
                                <td class="py-2.5 px-3 text-right text-rose-600 font-medium">${{ number_format($day['cost'], 2) }}</td>
                                <td class="py-2.5 px-3 text-right text-emerald-600 font-black">${{ number_format($day['profit'], 2) }}</td>
                                <td class="py-2.5 px-3 text-center font-extrabold text-blue-600">{{ $day['margin'] }}%</td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-6 text-slate-400">No profit & loss data available for this range.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @elseif($reportType === 'warranty')
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-slate-400 uppercase text-[10px] font-bold border-b border-slate-100">
                                <th class="py-2.5 px-3">#</th>
                                <th class="py-2.5 px-3">Warranty Code</th>
                                <th class="py-2.5 px-3">Product</th>
                                <th class="py-2.5 px-3">Customer</th>
                                <th class="py-2.5 px-3">Purchase Date</th>
                                <th class="py-2.5 px-3">Expiry Date</th>
                                <th class="py-2.5 px-3 text-center">Claims Count</th>
                                <th class="py-2.5 px-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @forelse($records as $idx => $w)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-2.5 px-3 font-bold text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-2.5 px-3 font-bold text-blue-600">{{ $w->warranty_code }}</td>
                                <td class="py-2.5 px-3 font-semibold text-slate-800">{{ $w->product->name ?? $w->product_name }}</td>
                                <td class="py-2.5 px-3">{{ $w->customer->name ?? 'N/A' }}</td>
                                <td class="py-2.5 px-3 text-slate-500">{{ $w->purchase_date ? \Carbon\Carbon::parse($w->purchase_date)->format('Y-m-d') : 'N/A' }}</td>
                                <td class="py-2.5 px-3 text-slate-500">{{ $w->expiry_date ? \Carbon\Carbon::parse($w->expiry_date)->format('Y-m-d') : 'N/A' }}</td>
                                <td class="py-2.5 px-3 text-center font-bold">{{ $w->claims->count() }}</td>
                                <td class="py-2.5 px-3 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ strtolower($w->status) === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($w->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center py-6 text-slate-400">No warranty records found for this period.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @endif

            </div>

        </div>

    </main>

</div>

</body>
</html>
