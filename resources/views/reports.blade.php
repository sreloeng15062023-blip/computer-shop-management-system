<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ucwords(str_replace('_', ' ', $reportType)) }} Report | TECHZONE Computer Shop</title>

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
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Report Management (Feature #14)</h2>
                        <p class="text-xs font-medium text-slate-500">12 Specialized Business Reports with Export to Excel (CSV), PDF, and Direct Printing.</p>
                    </div>
                </div>

                <!-- Export & Print Action Buttons -->
                <div class="flex items-center gap-2.5">
                    <a href="{{ route('reports.export', request()->all()) }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm flex items-center gap-2 transition hover:scale-105" title="Export as Excel CSV with UTF-8 BOM">
                        <i class="fa-solid fa-file-excel"></i>
                        <span>Export Excel (CSV)</span>
                    </a>
                    <a href="{{ route('reports.print', request()->all()) }}" target="_blank" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-sm flex items-center gap-2 transition hover:scale-105" title="Open Print View / Save as PDF">
                        <i class="fa-solid fa-print"></i>
                        <span>Print</span>
                    </a>
                    <a href="{{ route('reports.print', request()->all()) }}" target="_blank" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-sm flex items-center gap-2 transition hover:scale-105" title="Save report directly as PDF">
                        <i class="fa-solid fa-file-pdf"></i>
                        <span>PDF</span>
                    </a>
                </div>
            </div>

            {{-- ========================================================================= --}}
            {{-- 12 REPORT SELECTOR CATEGORY PILLS                                         --}}
            {{-- ========================================================================= --}}
            <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-sm space-y-2">
                <div class="flex items-center justify-between px-2 pb-1 border-b border-slate-100">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Select Report Type (12 Total Reports)</span>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full">
                        Active: {{ ucwords(str_replace('_', ' ', $reportType)) }}
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2">
                    @php
                        $reportsList = [
                            ['key' => 'inventory', 'name' => '1. Product Inventory', 'icon' => 'fa-boxes-stacked'],
                            ['key' => 'daily_sales', 'name' => '2. Daily Sales', 'icon' => 'fa-cash-register'],
                            ['key' => 'monthly_sales', 'name' => '3. Monthly Sales', 'icon' => 'fa-calendar-days'],
                            ['key' => 'purchase', 'name' => '4. Purchase Report', 'icon' => 'fa-cart-shopping'],
                            ['key' => 'customer', 'name' => '5. Customer Report', 'icon' => 'fa-users'],
                            ['key' => 'supplier', 'name' => '6. Supplier Report', 'icon' => 'fa-truck-field'],
                            ['key' => 'repair_service', 'name' => '7. Repair Service', 'icon' => 'fa-wrench'],
                            ['key' => 'warranty', 'name' => '8. Warranty Report', 'icon' => 'fa-shield-halved'],
                            ['key' => 'revenue', 'name' => '9. Revenue Report', 'icon' => 'fa-sack-dollar'],
                            ['key' => 'profit_loss', 'name' => '10. Profit & Loss', 'icon' => 'fa-scale-balanced'],
                            ['key' => 'best_selling', 'name' => '11. Best Selling', 'icon' => 'fa-fire'],
                            ['key' => 'low_stock', 'name' => '12. Low Stock Alert', 'icon' => 'fa-triangle-exclamation'],
                        ];
                    @endphp

                    @foreach($reportsList as $rItem)
                    <a href="{{ route('reports', ['type' => $rItem['key'], 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                       class="py-2.5 px-3 rounded-xl text-xs font-bold transition flex items-center gap-2 truncate {{ ($reportType === $rItem['key'] || ($reportType === 'sales' && $rItem['key'] === 'daily_sales')) ? 'bg-blue-600 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-600/30' : 'bg-slate-50 hover:bg-slate-100 text-slate-700' }}">
                        <i class="fa-solid {{ $rItem['icon'] }} w-4 text-center"></i>
                        <span class="truncate">{{ $rItem['name'] }}</span>
                    </a>
                    @endforeach
                </div>
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

                    <!-- Conditional Extra Filter 1 -->
                    @if(in_array($reportType, ['inventory', 'low_stock']))
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Category</label>
                        <select name="category_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-blue-500">
                            <option value="all">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @elseif($reportType === 'purchase')
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Supplier</label>
                        <select name="supplier_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-blue-500">
                            <option value="all">All Suppliers</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}" {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
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

                    <!-- Search Filter -->
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Keyword Search</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search record..." class="w-full pl-8 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:border-blue-500">
                            <i class="fa-solid fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        </div>
                    </div>

                    <!-- Submit / Reset Buttons -->
                    <div class="flex items-center gap-2">
                        <button type="submit" class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-filter"></i>
                            <span>Apply</span>
                        </button>
                        <a href="{{ route('reports', ['type' => $reportType]) }}" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition" title="Reset Filters">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Summary KPI Metric Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($summary as $key => $val)
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm relative overflow-hidden group hover:border-blue-300 transition">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 truncate">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">
                            <i class="fa-solid fa-chart-simple"></i>
                        </div>
                    </div>
                    <div class="mt-3 text-2xl font-black text-slate-900 tracking-tight truncate">
                        @if(str_contains($key, 'revenue') || str_contains($key, 'profit') || str_contains($key, 'cost') || str_contains($key, 'value') || str_contains($key, 'tax') || str_contains($key, 'discount') || str_contains($key, 'sales') || str_contains($key, 'amount') || str_contains($key, 'spend') || str_contains($key, 'fee') || str_contains($key, 'sourced'))
                            ${{ is_numeric($val) ? number_format($val, 2) : $val }}
                        @elseif(str_contains($key, 'margin') || str_contains($key, 'rate'))
                            {{ $val }}%
                        @else
                            {{ is_numeric($val) ? number_format($val) : $val }}
                        @endif
                    </div>
                    <div class="mt-1 text-[11px] text-slate-400 flex items-center gap-1">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i> Live calculated metric
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Chart Card -->
            @if(isset($chart) && count($chart['labels'] ?? []) > 0)
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-chart-area text-blue-600"></i>
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Visual Analytics Overview</h3>
                    </div>
                    <span class="text-xs text-slate-400">Period: {{ $startDate }} to {{ $endDate }}</span>
                </div>
                <div class="h-64 sm:h-72">
                    <canvas id="reportChart"></canvas>
                </div>
            </div>
            @endif

            <!-- Data Table Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">
                            {{ ucwords(str_replace('_', ' ', $reportType)) }} Records
                        </h3>
                        <p class="text-xs text-slate-400">Total of {{ count($records) }} items found matching current filters.</p>
                    </div>
                    <div class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                        Showing all results
                    </div>
                </div>

                <div class="overflow-x-auto scrollbar-thin">

                    {{-- 1. DAILY SALES TABLE --}}
                    @if($reportType === 'daily_sales' || $reportType === 'sales')
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5 text-center">#</th>
                                <th class="p-3.5">Sale No</th>
                                <th class="p-3.5">Date & Time</th>
                                <th class="p-3.5">Customer</th>
                                <th class="p-3.5 text-center">Items</th>
                                <th class="p-3.5">Payment</th>
                                <th class="p-3.5 text-right">Subtotal</th>
                                <th class="p-3.5 text-right">Discount</th>
                                <th class="p-3.5 text-right">Total ($)</th>
                                <th class="p-3.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $idx => $r)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-3.5 font-bold text-blue-600">{{ $r->sale_number }}</td>
                                <td class="p-3.5 text-slate-500">{{ \Carbon\Carbon::parse($r->sale_date)->format('Y-m-d H:i') }}</td>
                                <td class="p-3.5 font-semibold text-slate-800">{{ $r->customer->name ?? 'Walk-in' }}</td>
                                <td class="p-3.5 text-center font-bold">{{ $r->details->sum('quantity') }}</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[11px] font-semibold">{{ $r->payment_method ?? 'Cash' }}</span></td>
                                <td class="p-3.5 text-right font-medium">${{ number_format($r->subtotal, 2) }}</td>
                                <td class="p-3.5 text-right text-rose-500">-${{ number_format($r->discount_amount, 2) }}</td>
                                <td class="p-3.5 text-right font-black text-slate-900">${{ number_format($r->total_amount, 2) }}</td>
                                <td class="p-3.5 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ strtolower($r->status) === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $r->status ?? 'Completed' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="10" class="p-8 text-center text-slate-400">No sales transactions found for this period.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- 2. MONTHLY SALES TABLE --}}
                    @elseif($reportType === 'monthly_sales')
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5 text-center">#</th>
                                <th class="p-3.5">Month / Year</th>
                                <th class="p-3.5 text-center">Orders Count</th>
                                <th class="p-3.5 text-center">Items Sold</th>
                                <th class="p-3.5 text-right">Cash Revenue</th>
                                <th class="p-3.5 text-right">Digital / QR</th>
                                <th class="p-3.5 text-right">Total Revenue ($)</th>
                                <th class="p-3.5 text-right">Average Order Value</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $idx => $m)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-3.5 font-bold text-slate-800">{{ $m['month_label'] }}</td>
                                <td class="p-3.5 text-center font-bold text-blue-600">{{ $m['orders_count'] }}</td>
                                <td class="p-3.5 text-center font-semibold">{{ $m['items_sold'] }}</td>
                                <td class="p-3.5 text-right text-emerald-600">${{ number_format($m['cash_total'], 2) }}</td>
                                <td class="p-3.5 text-right text-violet-600">${{ number_format($m['digital_total'], 2) }}</td>
                                <td class="p-3.5 text-right font-black text-slate-900">${{ number_format($m['total_revenue'], 2) }}</td>
                                <td class="p-3.5 text-right font-semibold text-slate-700">${{ number_format($m['avg_order_value'], 2) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="p-8 text-center text-slate-400">No monthly aggregated sales records available.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- 3. PRODUCT INVENTORY TABLE --}}
                    @elseif($reportType === 'inventory')
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5 text-center">#</th>
                                <th class="p-3.5">Product Name</th>
                                <th class="p-3.5">SKU</th>
                                <th class="p-3.5">Category</th>
                                <th class="p-3.5">Brand</th>
                                <th class="p-3.5 text-right">Cost Price</th>
                                <th class="p-3.5 text-right">Selling Price</th>
                                <th class="p-3.5 text-center">In Stock</th>
                                <th class="p-3.5 text-right">Cost Valuation</th>
                                <th class="p-3.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $idx => $p)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-3.5 font-bold text-slate-900">{{ $p->name }}</td>
                                <td class="p-3.5 text-slate-500 font-mono">{{ $p->sku }}</td>
                                <td class="p-3.5">{{ $p->category->name ?? 'N/A' }}</td>
                                <td class="p-3.5">{{ $p->brand->brand_name ?? ($p->brand->name ?? 'N/A') }}</td>
                                <td class="p-3.5 text-right text-slate-600 font-medium">${{ number_format($p->cost_price, 2) }}</td>
                                <td class="p-3.5 text-right font-bold text-blue-600">${{ number_format($p->selling_price, 2) }}</td>
                                <td class="p-3.5 text-center font-extrabold {{ $p->stock_quantity <= $p->min_stock_alert ? 'text-rose-600' : 'text-emerald-600' }}">
                                    {{ $p->stock_quantity }}
                                </td>
                                <td class="p-3.5 text-right font-black text-slate-900">${{ number_format($p->stock_quantity * $p->cost_price, 2) }}</td>
                                <td class="p-3.5 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $p->stock_quantity <= 0 ? 'bg-rose-100 text-rose-700' : ($p->stock_quantity <= $p->min_stock_alert ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700') }}">
                                        {{ $p->stock_quantity <= 0 ? 'Out of Stock' : ($p->stock_quantity <= $p->min_stock_alert ? 'Low Stock' : 'In Stock') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="10" class="p-8 text-center text-slate-400">No inventory products found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- 4. LOW STOCK ALERT TABLE --}}
                    @elseif($reportType === 'low_stock')
                    <table class="w-full text-left text-xs">
                        <thead class="bg-rose-50/50 text-rose-700 font-bold uppercase text-[10px] tracking-wider border-b border-rose-100">
                            <tr>
                                <th class="p-3.5 text-center">#</th>
                                <th class="p-3.5">Product Name</th>
                                <th class="p-3.5">SKU</th>
                                <th class="p-3.5">Category</th>
                                <th class="p-3.5 text-center">Current Stock</th>
                                <th class="p-3.5 text-center">Min Alert Level</th>
                                <th class="p-3.5 text-center">Shortage Units</th>
                                <th class="p-3.5 text-right">Cost ($)</th>
                                <th class="p-3.5 text-right">Est. Restock Cost</th>
                                <th class="p-3.5 text-center">Action Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $idx => $p)
                            <tr class="hover:bg-rose-50/30 transition">
                                <td class="p-3.5 text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-3.5 font-bold text-slate-900">{{ $p->name }}</td>
                                <td class="p-3.5 text-slate-500 font-mono">{{ $p->sku }}</td>
                                <td class="p-3.5">{{ $p->category->name ?? 'N/A' }}</td>
                                <td class="p-3.5 text-center font-extrabold text-rose-600">{{ $p->stock_quantity }}</td>
                                <td class="p-3.5 text-center font-medium">{{ $p->min_stock_alert }}</td>
                                <td class="p-3.5 text-center font-black text-amber-600">+{{ max(0, $p->min_stock_alert - $p->stock_quantity) }}</td>
                                <td class="p-3.5 text-right">${{ number_format($p->cost_price, 2) }}</td>
                                <td class="p-3.5 text-right font-black text-rose-600">${{ number_format(max(0, $p->min_stock_alert - $p->stock_quantity) * $p->cost_price, 2) }}</td>
                                <td class="p-3.5 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $p->stock_quantity <= 0 ? 'bg-rose-100 text-rose-700 ring-1 ring-rose-300' : 'bg-amber-100 text-amber-700 ring-1 ring-amber-300' }}">
                                        {{ $p->stock_quantity <= 0 ? 'OUT OF STOCK' : 'LOW STOCK' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="10" class="p-8 text-center text-slate-400">All product stocks are well above minimum alert levels!</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- 5. BEST SELLING PRODUCTS TABLE --}}
                    @elseif($reportType === 'best_selling')
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5 text-center">Rank</th>
                                <th class="p-3.5">Product Name</th>
                                <th class="p-3.5">SKU</th>
                                <th class="p-3.5">Category</th>
                                <th class="p-3.5">Brand</th>
                                <th class="p-3.5 text-right">Selling Price</th>
                                <th class="p-3.5 text-center">Units Sold</th>
                                <th class="p-3.5 text-right">Total Revenue</th>
                                <th class="p-3.5 text-right">Est. Gross Profit</th>
                                <th class="p-3.5 text-center">In Stock</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $idx => $p)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 text-center font-black {{ $idx === 0 ? 'text-amber-500 text-sm' : ($idx < 3 ? 'text-blue-600' : 'text-slate-400') }}">
                                    @if($idx === 0) 🥇 #1 @elseif($idx === 1) 🥈 #2 @elseif($idx === 2) 🥉 #3 @else #{{ $idx + 1 }} @endif
                                </td>
                                <td class="p-3.5 font-bold text-slate-900">{{ $p['name'] }}</td>
                                <td class="p-3.5 text-slate-500 font-mono">{{ $p['sku'] }}</td>
                                <td class="p-3.5">{{ $p['category'] }}</td>
                                <td class="p-3.5">{{ $p['brand'] }}</td>
                                <td class="p-3.5 text-right font-medium">${{ number_format($p['unit_price'], 2) }}</td>
                                <td class="p-3.5 text-center font-extrabold text-blue-600">{{ $p['units_sold'] }}</td>
                                <td class="p-3.5 text-right font-black text-slate-900">${{ number_format($p['total_revenue'], 2) }}</td>
                                <td class="p-3.5 text-right font-bold text-emerald-600">${{ number_format($p['gross_profit'], 2) }}</td>
                                <td class="p-3.5 text-center font-semibold text-slate-700">{{ $p['current_stock'] }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="10" class="p-8 text-center text-slate-400">No sales transactions available to rank top selling items.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- 6. PURCHASE REPORT TABLE --}}
                    @elseif($reportType === 'purchase')
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5 text-center">#</th>
                                <th class="p-3.5">PO Number</th>
                                <th class="p-3.5">Order Date</th>
                                <th class="p-3.5">Supplier</th>
                                <th class="p-3.5">Expected Delivery</th>
                                <th class="p-3.5 text-center">Items</th>
                                <th class="p-3.5 text-right">Total Amount</th>
                                <th class="p-3.5 text-center">Payment</th>
                                <th class="p-3.5 text-center">PO Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $idx => $po)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-3.5 font-bold text-blue-600">{{ $po->po_number }}</td>
                                <td class="p-3.5 text-slate-500">{{ $po->order_date ? \Carbon\Carbon::parse($po->order_date)->format('Y-m-d') : 'N/A' }}</td>
                                <td class="p-3.5 font-semibold text-slate-800">{{ $po->supplier->name ?? 'N/A' }}</td>
                                <td class="p-3.5 text-slate-500">{{ $po->expected_delivery_date ? \Carbon\Carbon::parse($po->expected_delivery_date)->format('Y-m-d') : 'N/A' }}</td>
                                <td class="p-3.5 text-center font-bold">{{ $po->details->sum('quantity') }}</td>
                                <td class="p-3.5 text-right font-black text-slate-900">${{ number_format($po->total_amount, 2) }}</td>
                                <td class="p-3.5 text-center">
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-bold {{ strtolower($po->payment_status) === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $po->payment_status }}
                                    </span>
                                </td>
                                <td class="p-3.5 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ strtolower($po->status) === 'received' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $po->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="p-8 text-center text-slate-400">No purchase orders found for this period.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- 7. CUSTOMER REPORT TABLE --}}
                    @elseif($reportType === 'customer')
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5 text-center">#</th>
                                <th class="p-3.5">Customer Name</th>
                                <th class="p-3.5">Phone</th>
                                <th class="p-3.5">Email</th>
                                <th class="p-3.5">Customer Type</th>
                                <th class="p-3.5 text-center">Total Orders</th>
                                <th class="p-3.5 text-right">Total Spent ($)</th>
                                <th class="p-3.5 text-center">Points</th>
                                <th class="p-3.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $idx => $c)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-3.5 font-bold text-slate-900">{{ $c->name }}</td>
                                <td class="p-3.5 text-slate-600">{{ $c->phone ?? 'N/A' }}</td>
                                <td class="p-3.5 text-slate-500">{{ $c->email ?? 'N/A' }}</td>
                                <td class="p-3.5"><span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-medium capitalize">{{ $c->customer_type ?? 'Regular' }}</span></td>
                                <td class="p-3.5 text-center font-bold text-blue-600">{{ $c->total_orders ?? 0 }}</td>
                                <td class="p-3.5 text-right font-black text-emerald-600">${{ number_format($c->total_spent ?? 0, 2) }}</td>
                                <td class="p-3.5 text-center font-bold text-amber-600">{{ $c->points ?? 0 }}</td>
                                <td class="p-3.5 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ strtolower($c->status) === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $c->status ?? 'Active' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="p-8 text-center text-slate-400">No customer records found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- 8. SUPPLIER REPORT TABLE --}}
                    @elseif($reportType === 'supplier')
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5 text-center">#</th>
                                <th class="p-3.5">Supplier Name</th>
                                <th class="p-3.5">Contact Person</th>
                                <th class="p-3.5">Phone</th>
                                <th class="p-3.5">Email</th>
                                <th class="p-3.5 text-center">Purchase Orders</th>
                                <th class="p-3.5 text-right">Total Sourced ($)</th>
                                <th class="p-3.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $idx => $s)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-3.5 font-bold text-slate-900">{{ $s->name }}</td>
                                <td class="p-3.5 text-slate-700 font-medium">{{ $s->contact_name ?? 'N/A' }}</td>
                                <td class="p-3.5 text-slate-600">{{ $s->phone ?? 'N/A' }}</td>
                                <td class="p-3.5 text-slate-500">{{ $s->email ?? 'N/A' }}</td>
                                <td class="p-3.5 text-center font-bold text-blue-600">{{ $s->total_pos ?? 0 }}</td>
                                <td class="p-3.5 text-right font-black text-slate-900">${{ number_format($s->total_sourced ?? 0, 2) }}</td>
                                <td class="p-3.5 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ strtolower($s->status) === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $s->status ?? 'Active' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="p-8 text-center text-slate-400">No supplier records found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- 9. REPAIR SERVICE REPORT TABLE --}}
                    @elseif($reportType === 'repair_service')
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5 text-center">#</th>
                                <th class="p-3.5">Ticket Code</th>
                                <th class="p-3.5">Date</th>
                                <th class="p-3.5">Customer</th>
                                <th class="p-3.5">Device & Model</th>
                                <th class="p-3.5">Technician</th>
                                <th class="p-3.5 text-right">Service Fee</th>
                                <th class="p-3.5 text-right">Parts Cost</th>
                                <th class="p-3.5 text-right">Total Cost ($)</th>
                                <th class="p-3.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $idx => $rep)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-3.5 font-bold text-blue-600">{{ $rep->repair_code }}</td>
                                <td class="p-3.5 text-slate-500">{{ \Carbon\Carbon::parse($rep->created_at)->format('Y-m-d') }}</td>
                                <td class="p-3.5 font-semibold text-slate-800">{{ $rep->customer->name ?? 'Walk-in' }}</td>
                                <td class="p-3.5 text-slate-600">{{ ($rep->device_type ?? '') . ' - ' . ($rep->model ?? '') }}</td>
                                <td class="p-3.5 text-slate-700">{{ $rep->technician->name ?? 'Unassigned' }}</td>
                                <td class="p-3.5 text-right">${{ number_format($rep->service_fee, 2) }}</td>
                                <td class="p-3.5 text-right text-rose-500">${{ number_format($rep->parts_total, 2) }}</td>
                                <td class="p-3.5 text-right font-black text-slate-900">${{ number_format($rep->total_cost, 2) }}</td>
                                <td class="p-3.5 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ in_array($rep->status, ['Completed', 'Delivered']) ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $rep->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="10" class="p-8 text-center text-slate-400">No repair service tickets found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- 10. WARRANTY REPORT TABLE --}}
                    @elseif($reportType === 'warranty')
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5 text-center">#</th>
                                <th class="p-3.5">Warranty Code</th>
                                <th class="p-3.5">Product</th>
                                <th class="p-3.5">Customer</th>
                                <th class="p-3.5">Purchase Date</th>
                                <th class="p-3.5">Expiry Date</th>
                                <th class="p-3.5 text-center">Warranty (Mos)</th>
                                <th class="p-3.5 text-center">Claims</th>
                                <th class="p-3.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $idx => $w)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-3.5 font-bold text-blue-600">{{ $w->warranty_code }}</td>
                                <td class="p-3.5 font-semibold text-slate-800">{{ $w->product->name ?? ($w->product_name ?? 'N/A') }}</td>
                                <td class="p-3.5">{{ $w->customer->name ?? 'N/A' }}</td>
                                <td class="p-3.5 text-slate-500">{{ $w->purchase_date ? \Carbon\Carbon::parse($w->purchase_date)->format('Y-m-d') : 'N/A' }}</td>
                                <td class="p-3.5 text-slate-500">{{ $w->expiry_date ? \Carbon\Carbon::parse($w->expiry_date)->format('Y-m-d') : 'N/A' }}</td>
                                <td class="p-3.5 text-center font-bold">{{ $w->warranty_period_months }}</td>
                                <td class="p-3.5 text-center font-bold text-blue-600">{{ $w->claims->count() }}</td>
                                <td class="p-3.5 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ strtolower($w->status) === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $w->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="p-8 text-center text-slate-400">No warranty records found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- 11. REVENUE REPORT TABLE --}}
                    @elseif($reportType === 'revenue')
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5 text-center">#</th>
                                <th class="p-3.5">Date</th>
                                <th class="p-3.5 text-right">POS Sales Revenue</th>
                                <th class="p-3.5 text-right">Repair Revenue</th>
                                <th class="p-3.5 text-right">Total Gross Inflow ($)</th>
                                <th class="p-3.5 text-right">Cash Received</th>
                                <th class="p-3.5 text-right">Digital / QR Bank</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $idx => $rev)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-3.5 font-bold text-slate-800">{{ $rev['date'] }}</td>
                                <td class="p-3.5 text-right font-medium text-slate-700">${{ number_format($rev['pos_revenue'], 2) }}</td>
                                <td class="p-3.5 text-right font-medium text-blue-600">${{ number_format($rev['repair_revenue'], 2) }}</td>
                                <td class="p-3.5 text-right font-black text-slate-900">${{ number_format($rev['total_revenue'], 2) }}</td>
                                <td class="p-3.5 text-right text-emerald-600 font-bold">${{ number_format($rev['cash_revenue'], 2) }}</td>
                                <td class="p-3.5 text-right text-violet-600 font-bold">${{ number_format($rev['digital_revenue'], 2) }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="p-8 text-center text-slate-400">No revenue data available for this range.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- 12. PROFIT & LOSS REPORT TABLE --}}
                    @elseif($reportType === 'profit_loss')
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5 text-center">#</th>
                                <th class="p-3.5">Date</th>
                                <th class="p-3.5 text-center">Orders</th>
                                <th class="p-3.5 text-right">Sales Revenue</th>
                                <th class="p-3.5 text-right">Cost of Goods (COGS)</th>
                                <th class="p-3.5 text-right">Gross Sales Profit</th>
                                <th class="p-3.5 text-right">Repair Net</th>
                                <th class="p-3.5 text-right">Net Profit ($)</th>
                                <th class="p-3.5 text-center">Margin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($records as $idx => $day)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="p-3.5 text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-3.5 font-bold text-slate-800">{{ $day['date'] }}</td>
                                <td class="p-3.5 text-center">{{ $day['orders_count'] }}</td>
                                <td class="p-3.5 text-right font-bold text-slate-900">${{ number_format($day['revenue'], 2) }}</td>
                                <td class="p-3.5 text-right text-rose-600 font-medium">${{ number_format($day['cost'], 2) }}</td>
                                <td class="p-3.5 text-right text-emerald-600 font-bold">${{ number_format($day['profit'], 2) }}</td>
                                <td class="p-3.5 text-right text-blue-600 font-medium">${{ number_format(($day['repair_revenue'] ?? 0) - ($day['repair_parts_cost'] ?? 0), 2) }}</td>
                                <td class="p-3.5 text-right text-emerald-700 font-black">${{ number_format($day['net_profit'] ?? $day['profit'], 2) }}</td>
                                <td class="p-3.5 text-center font-extrabold text-blue-600">{{ $day['margin'] }}%</td>
                            </tr>
                            @empty
                            <tr><td colspan="9" class="p-8 text-center text-slate-400">No profit & loss records available for this period.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    @endif

                </div>
            </div>

        </div>
    </main>

</div>

<!-- Chart.js Script Initialization -->
@if(isset($chart) && count($chart['labels'] ?? []) > 0)
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('reportChart');
    if (!ctx) return;

    const labels = @json($chart['labels'] ?? []);
    const values = @json($chart['values'] ?? []);
    const reportType = @json($reportType);

    let chartType = 'line';
    let bgColor = 'rgba(37, 99, 235, 0.1)';
    let borderColor = '#2563EB';

    if (reportType === 'inventory' || reportType === 'warranty' || reportType === 'low_stock') {
        chartType = 'doughnut';
        bgColor = ['#10B981', '#F59E0B', '#EF4444', '#6366F1'];
        borderColor = '#FFFFFF';
    } else if (reportType === 'best_selling' || reportType === 'monthly_sales' || reportType === 'purchase') {
        chartType = 'bar';
        bgColor = 'rgba(37, 99, 235, 0.7)';
        borderColor = '#2563EB';
    }

    new Chart(ctx, {
        type: chartType,
        data: {
            labels: labels,
            datasets: [{
                label: 'Volume / Revenue ($)',
                data: values,
                backgroundColor: bgColor,
                borderColor: borderColor,
                borderWidth: 2,
                fill: true,
                tension: 0.35,
                borderRadius: chartType === 'bar' ? 6 : 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: chartType === 'doughnut',
                    position: 'bottom'
                }
            },
            scales: chartType === 'doughnut' ? {} : {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(226, 232, 240, 0.6)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endif

</body>
</html>
