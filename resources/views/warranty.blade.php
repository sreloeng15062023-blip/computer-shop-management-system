<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Warranty Management | TECHZONE Computer Shop</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js for Donut Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB',
                        primaryHover: '#1D4ED8',
                        techdark: '#0B1528',
                        surface: '#FFFFFF',
                        borderLight: '#E2E8F0',
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .receipt-font { font-family: 'Courier Prime', monospace; }
        .scrollbar-thin::-webkit-scrollbar { width: 5px; height: 5px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #f1f5f9; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 9999px; }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }
    </style>
</head>
<body class="bg-[#F4F6F9] text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

<div class="flex min-h-screen">

    {{-- ========================================================================= --}}
    {{-- 1. TECHZONE SIDEBAR NAVIGATION (Feature #11 Highlighted)                 --}}
    {{-- ========================================================================= --}}
    <aside class="w-64 bg-[#0B1528] text-slate-300 flex-shrink-0 hidden lg:flex flex-col fixed h-screen z-30 shadow-xl no-print select-none">
        <!-- Logo Area -->
        <div class="flex items-center gap-3 px-5 py-4 border-b border-slate-800/80">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white shadow-md shadow-blue-500/30">
                <i class="fa-solid fa-cube text-xl"></i>
            </div>
            <div>
                <h1 class="text-white font-extrabold text-base tracking-wider leading-tight">TECHZONE</h1>
                <p class="text-[10.5px] text-slate-400 font-medium leading-tight">Computer Shop Management System</p>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto scrollbar-thin px-3 py-3 space-y-1 text-[13px] font-medium">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-house w-4 text-center"></i> Dashboard
            </a>

            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-box w-4 text-center"></i> Product Management
            </a>

            <a href="{{ route('purchases') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-cart-shopping w-4 text-center"></i> Purchase Management
            </a>

            <a href="{{ route('inventory') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-warehouse w-4 text-center"></i> Inventory Management
            </a>

            <a href="{{ route('pos.sales') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-cash-register w-4 text-center"></i> Sales Management (POS)
            </a>

            <a href="{{ route('repair.service') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-screwdriver-wrench w-4 text-center"></i> Repair Service Management
            </a>

            <!-- Active: Warranty Management with Sub-menu matching Mockup 2 -->
            <div class="space-y-1 pt-0.5">
                <a href="{{ route('warranty') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30 transition">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-shield-halved w-4 text-center"></i> Warranty Management
                    </span>
                    <i class="fa-solid fa-chevron-down text-[11px] opacity-80"></i>
                </a>

                <div class="pl-7 pr-2 py-1 space-y-1">
                    <a href="javascript:void(0)" onclick="scrollToTable()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-blue-400 bg-slate-800/60 transition">
                        <i class="fa-solid fa-list text-[10px]"></i> Warranty List
                    </a>
                    <a href="javascript:void(0)" onclick="openRegisterWarrantyModal()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-circle-plus text-[10px] text-blue-400"></i> Register Warranty
                    </a>
                    <a href="javascript:void(0)" onclick="scrollToClaims()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-triangle-exclamation text-[10px] text-amber-400"></i> Warranty Claims
                    </a>
                    <a href="javascript:void(0)" onclick="scrollToAlerts()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-bell text-[10px] text-rose-400"></i> Expiry Tracking
                    </a>
                    <a href="javascript:void(0)" onclick="openLookupModal()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-magnifying-glass text-[10px] text-emerald-400"></i> Lookup by Serial
                    </a>
                </div>
            </div>

            <a href="{{ route('invoices') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-file-invoice-dollar w-4 text-center"></i> Payment &amp; Invoice
            </a>

            <a href="{{ route('employees') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-user-group w-4 text-center"></i> Employee Management
            </a>

            <a href="{{ route('customers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-address-book w-4 text-center"></i> Customer Management
            </a>

            <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-chart-pie w-4 text-center"></i> Report Management
            </a>

            <a href="{{ route('notifications') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <span class="flex items-center gap-3">
                    <i class="fa-solid fa-bell w-4 text-center"></i> Notification
                </span>
                <span class="w-5 h-5 rounded-full bg-rose-500 text-white text-[10px] font-bold flex items-center justify-center">3</span>
            </a>

            <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-gear w-4 text-center"></i> Settings
            </a>
        </nav>

        <!-- User Profile Area matching Mockup -->
        <div class="p-3 border-t border-slate-800/80 bg-slate-900/40">
            <div class="flex items-center justify-between px-2 py-1.5">
                <div class="flex items-center gap-2.5">
                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&h=80&q=80"
                         alt="Sok Dara Avatar" class="w-8 h-8 rounded-full object-cover ring-2 ring-blue-500">
                    <div>
                        <p class="text-xs font-bold text-white leading-tight">Sok Dara</p>
                        <p class="text-[10px] text-slate-400">Sales Staff</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Logout" class="text-slate-400 hover:text-rose-400 transition p-1.5">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ========================================================================= --}}
    {{-- 2. MAIN WARRANTY WORKSPACE                                                --}}
    {{-- ========================================================================= --}}
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">

        <!-- Top App Bar -->
        <header class="bg-white border-b border-slate-200/90 px-6 py-2.5 flex items-center justify-between sticky top-0 z-20 shadow-sm no-print">
            <div class="flex items-center gap-4">
                <button class="lg:hidden text-slate-500 hover:text-slate-700">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="relative w-72 md:w-96">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" id="topNavSearch" placeholder="Search warranty ID, product, customer, serial number..."
                           onkeyup="if(event.key==='Enter') applyFilters()"
                           class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none text-xs transition text-slate-700">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button class="relative w-9 h-9 rounded-xl bg-slate-50 hover:bg-slate-100 flex items-center justify-center text-slate-500 transition border border-slate-200">
                    <i class="fa-solid fa-bell text-sm"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center shadow">1</span>
                </button>

                <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&h=80&q=80"
                         alt="Sok Dara" class="w-8 h-8 rounded-full object-cover ring-2 ring-blue-500/30">
                    <div class="hidden sm:block leading-tight">
                        <p class="text-xs font-bold text-slate-800">Sok Dara</p>
                        <p class="text-[10px] text-slate-400 font-medium">Sales Staff</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 p-5 lg:p-6 space-y-5">

            {{-- 2.1 Header Row matching Mockup 2 --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shadow-md shadow-blue-500/20">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 leading-tight">Warranty Management</h2>
                        <p class="text-xs text-slate-400 font-medium">Manage product warranties, claims and warranty service history</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" onclick="openLookupModal()" class="flex items-center gap-2 px-3.5 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-semibold rounded-xl text-xs transition">
                        <i class="fa-solid fa-barcode text-blue-600"></i> Check by Serial
                    </button>
                    <button type="button" onclick="openRegisterWarrantyModal()" class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-xs shadow-sm transition">
                        <i class="fa-solid fa-plus text-xs"></i> Register Warranty
                    </button>
                </div>
            </div>

            {{-- 2.2 FOUR STAT CARDS matching Mockup 2 --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                
                <!-- Card 1: Total Warranties -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-slate-400">Total Warranties</p>
                        <h3 class="text-xl font-extrabold text-slate-900">{{ number_format($totalWarranties) }}</h3>
                        <p class="text-[11px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> + 12% <span class="text-slate-400 font-normal">(This month)</span>
                        </p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-sm">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                </div>

                <!-- Card 2: Active Warranties -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-slate-400">Active Warranties</p>
                        <h3 class="text-xl font-extrabold text-emerald-600">{{ number_format($activeWarranties) }}</h3>
                        <p class="text-[11px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> + 15% <span class="text-slate-400 font-normal">(This month)</span>
                        </p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shadow-sm">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>

                <!-- Card 3: Expiring Soon (30 days) -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-slate-400">Expiring Soon (30 days)</p>
                        <h3 class="text-xl font-extrabold text-amber-500">{{ number_format($expiringSoonCount) }}</h3>
                        <p class="text-[11px] font-bold text-amber-500 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> + 5% <span class="text-slate-400 font-normal">(This month)</span>
                        </p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg shadow-sm">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                </div>

                <!-- Card 4: Warranty Claims -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-slate-400">Warranty Claims</p>
                        <h3 class="text-xl font-extrabold text-rose-600">{{ number_format($claimsCount) }}</h3>
                        <p class="text-[11px] font-bold text-rose-500 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-down"></i> - 20% <span class="text-slate-400 font-normal">(This month)</span>
                        </p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg shadow-sm">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                </div>

            </div>

            {{-- 2.3 FILTER BAR matching Mockup 2 --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-3.5 shadow-sm flex flex-col xl:flex-row items-stretch xl:items-center justify-between gap-3 text-xs" id="tableFilterSection">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" id="filterSearch" value="{{ request('search') }}"
                           placeholder="Search warranty ID, product, customer, serial number..."
                           onkeyup="if(event.key==='Enter') applyFilters()"
                           class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:outline-none transition">
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <!-- Brand Filter -->
                    <select id="filterBrand" onchange="applyFilters()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none">
                        <option value="all">All Brands</option>
                        @foreach($brands as $b)
                            <option value="{{ $b->brand_name }}" {{ request('brand') == $b->brand_name ? 'selected' : '' }}>
                                {{ $b->brand_name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Status Filter -->
                    <select id="filterStatus" onchange="applyFilters()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none">
                        <option value="all">All Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Expiring" {{ request('status') == 'Expiring' ? 'selected' : '' }}>Expiring</option>
                        <option value="Claimed" {{ request('status') == 'Claimed' ? 'selected' : '' }}>Claimed</option>
                        <option value="Expired" {{ request('status') == 'Expired' ? 'selected' : '' }}>Expired</option>
                    </select>

                    <!-- Date range -->
                    <div class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-600 font-mono text-[11px]">
                        <input type="date" id="filterDateFrom" value="{{ request('date_from', '2025-08-01') }}" onchange="applyFilters()" class="bg-transparent focus:outline-none">
                        <span class="text-slate-400">&rarr;</span>
                        <input type="date" id="filterDateTo" value="{{ request('date_to', date('Y-m-d')) }}" onchange="applyFilters()" class="bg-transparent focus:outline-none">
                    </div>

                    <button type="button" onclick="applyFilters()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition">
                        Filter
                    </button>
                </div>
            </div>

            {{-- 2.4 MAIN SPLIT: WARRANTIES TABLE + RIGHT SIDEBAR --}}
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-5">

                {{-- LEFT/CENTER: WARRANTIES TABLE (8 cols) --}}
                <div class="xl:col-span-8 space-y-4">
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm space-y-3">
                        <div class="overflow-x-auto scrollbar-thin">
                            <table class="w-full text-left text-xs text-slate-600">
                                <thead class="bg-slate-50 text-slate-500 font-semibold border-y border-slate-200">
                                    <tr>
                                        <th class="py-3 px-3 w-8"><input type="checkbox" class="rounded text-blue-600"></th>
                                        <th class="py-3 px-3">#</th>
                                        <th class="py-3 px-3">Warranty ID</th>
                                        <th class="py-3 px-3">Product</th>
                                        <th class="py-3 px-3">Serial Number</th>
                                        <th class="py-3 px-3">Customer</th>
                                        <th class="py-3 px-3">Purchase Date</th>
                                        <th class="py-3 px-3">Warranty Period</th>
                                        <th class="py-3 px-3">Expiry Date</th>
                                        <th class="py-3 px-3">Status</th>
                                        <th class="py-3 px-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium">
                                    @forelse($warranties as $idx => $w)
                                        <tr class="hover:bg-slate-50/80 transition cursor-pointer" onclick="selectWarrantyPreview({{ $w->id }})">
                                            <td class="py-3 px-3" onclick="event.stopPropagation()"><input type="checkbox" class="rounded text-blue-600"></td>
                                            <td class="py-3 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                            <td class="py-3 px-3 font-mono font-bold text-blue-600">{{ $w->warranty_code }}</td>
                                            <td class="py-3 px-3 text-slate-800 font-semibold truncate max-w-[140px]" title="{{ $w->product_name }}">
                                                {{ $w->product_name }}
                                            </td>
                                            <td class="py-3 px-3 font-mono text-slate-600 font-bold">{{ $w->serial_number }}</td>
                                            <td class="py-3 px-3 font-medium text-slate-800">{{ $w->customer->name ?? 'Walk-in' }}</td>
                                            <td class="py-3 px-3 font-mono text-slate-500">{{ $w->purchase_date->format('Y-m-d') }}</td>
                                            <td class="py-3 px-3 text-slate-600">{{ $w->warranty_period_months / 12 >= 1 ? ($w->warranty_period_months / 12) . ' Years' : $w->warranty_period_months . ' Months' }}</td>
                                            <td class="py-3 px-3 font-mono text-slate-500">{{ $w->expiry_date->format('Y-m-d') }}</td>
                                            
                                            <!-- Status Badges matching Mockup 2 -->
                                            <td class="py-3 px-3">
                                                @if($w->status === 'Active')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                        Active
                                                    </span>
                                                @elseif($w->status === 'Expiring')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                                        Expiring
                                                    </span>
                                                @elseif($w->status === 'Claimed')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                                        Claimed
                                                    </span>
                                                @else
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">
                                                        Expired
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td class="py-3 px-3 text-right space-x-1.5 whitespace-nowrap" onclick="event.stopPropagation()">
                                                <button type="button" onclick="selectWarrantyPreview({{ $w->id }})" title="View Details" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                                <button type="button" onclick="openClaimModalFor({{ $w->id }})" title="Create Claim" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition">
                                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="py-8 text-center text-slate-400">មិនមានប័ណ្ណធានាត្រូវនឹងលក្ខខណ្ឌស្វែងរកឡើយ</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Footer -->
                        <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                            <div>
                                Showing {{ $warranties->firstItem() ?? 0 }} to {{ $warranties->lastItem() ?? 0 }} of {{ $warranties->total() }} entries
                            </div>
                            <div>
                                {{ $warranties->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT SIDEBAR: QUICK ACTIONS + WARRANTY DETAILS CARD (4 cols) --}}
                <div class="xl:col-span-4 space-y-4">
                    
                    <!-- 1. Quick Actions matching Mockup 2 -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3">
                        <h3 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-bolt text-blue-600"></i> Quick Actions
                        </h3>
                        <div class="space-y-2 text-xs font-semibold">
                            <button type="button" onclick="openRegisterWarrantyModal()" class="w-full flex items-center gap-3 p-2.5 rounded-xl bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100 transition">
                                <i class="fa-solid fa-shield-halved text-sm"></i> Register Warranty
                            </button>
                            <button type="button" onclick="openClaimModalPrompt()" class="w-full flex items-center gap-3 p-2.5 rounded-xl bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 transition">
                                <i class="fa-regular fa-file-lines text-sm"></i> Create Warranty Claim
                            </button>
                            <button type="button" onclick="scrollToAlerts()" class="w-full flex items-center gap-3 p-2.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition">
                                <i class="fa-regular fa-calendar-check text-sm"></i> View Expiry Tracking
                            </button>
                            <button type="button" onclick="openLookupModal()" class="w-full flex items-center gap-3 p-2.5 rounded-xl bg-purple-50 text-purple-700 border border-purple-200 hover:bg-purple-100 transition">
                                <i class="fa-solid fa-clock-rotate-left text-sm"></i> Warranty Service History
                            </button>
                        </div>
                    </div>

                    <!-- 2. Warranty Details Preview Card matching Mockup 2 -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4" id="warrantyDetailsPreviewCard">
                        <h3 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-certificate text-blue-600"></i> Warranty Details
                        </h3>

                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-3 text-xs">
                            <div class="flex items-center gap-3 pb-3 border-b border-slate-200">
                                <img src="https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=120&h=120&q=80"
                                     alt="Laptop" class="w-12 h-12 rounded-lg object-cover bg-white border border-slate-200 flex-shrink-0">
                                <div>
                                    <h4 class="font-extrabold text-slate-900" id="cardProdName">{{ $featuredWarranty->product_name ?? 'ASUS TUF Gaming Laptop' }}</h4>
                                    <p class="text-[10px] text-slate-400 font-mono">SKU: ASUS-TUF-001 &bull; Serial: <span id="cardSerial">{{ $featuredWarranty->serial_number ?? 'SN123456789' }}</span></p>
                                </div>
                            </div>

                            <div class="space-y-1.5 text-[11px] text-slate-600">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-400">Customer:</span>
                                    <div class="text-right">
                                        <p class="font-bold text-slate-800" id="cardCustName">{{ $featuredWarranty->customer->name ?? 'Sok Dara' }}</p>
                                        <p class="text-[10px] text-slate-400" id="cardCustPhone">{{ $featuredWarranty->customer->phone ?? '+855 12 345 678' }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Purchase Date:</span>
                                    <span class="font-mono text-slate-700" id="cardPurchaseDate">{{ $featuredWarranty ? $featuredWarranty->purchase_date->format('Y-m-d') : '2025-09-10' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Warranty Period:</span>
                                    <span class="font-semibold text-slate-800" id="cardPeriod">{{ $featuredWarranty ? ($featuredWarranty->warranty_period_months / 12) . ' Years' : '2 Years' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Expiry Date:</span>
                                    <span class="font-mono font-bold text-slate-900" id="cardExpiryDate">{{ $featuredWarranty ? $featuredWarranty->expiry_date->format('Y-m-d') : '2027-09-10' }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-1 border-t border-slate-200">
                                    <span class="text-slate-400">Status:</span>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200" id="cardStatusBadge">
                                        {{ $featuredWarranty->status ?? 'Active' }}
                                    </span>
                                </div>
                            </div>

                            <button type="button" onclick="Swal.fire('Warranty Card', 'ព័ត៌មានលម្អិតប័ណ្ណធានាត្រូវបានផ្ទៀងផ្ទាត់រួចរាល់', 'info')" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                                View Details
                            </button>
                        </div>
                    </div>

                </div>

            </div>

            {{-- 2.5 THREE BOTTOM PANELS matching Mockup 2 --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 pt-2">

                {{-- PANEL 1: Recent Warranty Claims (4 cols) --}}
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3" id="claimsSection">
                    <div class="flex items-center justify-between pb-1 border-b border-slate-100">
                        <h3 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-triangle-exclamation text-amber-500"></i> Recent Warranty Claims
                        </h3>
                        <a href="javascript:void(0)" onclick="openClaimModalPrompt()" class="text-[11px] text-blue-600 hover:underline">View All</a>
                    </div>

                    <div class="overflow-x-auto scrollbar-thin">
                        <table class="w-full text-left text-[11px]">
                            <thead class="text-slate-400 border-b border-slate-100">
                                <tr>
                                    <th class="pb-1.5">Claim ID</th>
                                    <th class="pb-1.5">Product</th>
                                    <th class="pb-1.5">Customer</th>
                                    <th class="pb-1.5">Status</th>
                                    <th class="pb-1.5 text-right">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($recentClaims as $claim)
                                    <tr>
                                        <td class="py-2 font-mono font-bold text-blue-600">{{ $claim->claim_code }}</td>
                                        <td class="py-2 text-slate-800 truncate max-w-[90px]">{{ $claim->warranty->product_name ?? 'Product' }}</td>
                                        <td class="py-2 text-slate-600 truncate max-w-[80px]">{{ $claim->customer->name ?? 'Walk-in' }}</td>
                                        <td class="py-2">
                                            @if($claim->status === 'In Progress')
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-sky-50 text-sky-600">In Progress</span>
                                            @elseif($claim->status === 'Waiting Parts')
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-50 text-amber-600">Waiting Parts</span>
                                            @elseif($claim->status === 'Diagnosing')
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-indigo-50 text-indigo-600">Diagnosing</span>
                                            @elseif($claim->status === 'Completed')
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-600">Completed</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-50 text-rose-600">Cancelled</span>
                                            @endif
                                        </td>
                                        <td class="py-2 text-right font-mono text-slate-400 text-[10px]">{{ $claim->claim_date->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="py-4 text-center text-slate-400">មិនទាន់មានពាក្យទាមទារនៅឡើយទេ</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- PANEL 2: Warranty Expiry Alerts (4 cols) --}}
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3" id="expiryAlertsSection">
                    <div class="flex items-center justify-between pb-1 border-b border-slate-100">
                        <h3 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-clock text-rose-500"></i> Warranty Expiry Alerts
                        </h3>
                        <a href="javascript:void(0)" class="text-[11px] text-blue-600 hover:underline">View All</a>
                    </div>

                    <div class="overflow-x-auto scrollbar-thin">
                        <table class="w-full text-left text-[11px]">
                            <thead class="text-slate-400 border-b border-slate-100">
                                <tr>
                                    <th class="pb-1.5">Product</th>
                                    <th class="pb-1.5">Customer</th>
                                    <th class="pb-1.5 text-center">Days Left</th>
                                    <th class="pb-1.5 text-right">Expiry Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-medium">
                                @forelse($expiryAlerts as $alert)
                                    @php
                                        $daysLeft = now()->diffInDays($alert->expiry_date, false);
                                    @endphp
                                    <tr>
                                        <td class="py-2 text-slate-800 truncate max-w-[100px]">{{ $alert->product_name }}</td>
                                        <td class="py-2 text-slate-600 truncate max-w-[90px]">{{ $alert->customer->name ?? 'Walk-in' }}</td>
                                        <td class="py-2 text-center font-bold text-[10.5px] {{ $daysLeft <= 30 ? 'text-rose-600' : 'text-amber-600' }}">
                                            {{ $daysLeft > 0 ? $daysLeft . ' days' : 'Expired' }}
                                        </td>
                                        <td class="py-2 text-right font-mono text-slate-400 text-[10px]">{{ $alert->expiry_date->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="py-4 text-center text-slate-400">មិនមានប័ណ្ណជិតផុតកំណត់ឡើយ</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- PANEL 3: Warranty Status Donut Chart (4 cols) --}}
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3">
                    <h3 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-chart-pie text-blue-600"></i> Warranty Status
                    </h3>

                    <div class="relative w-36 h-36 mx-auto flex items-center justify-center">
                        <canvas id="warrantyStatusDonutChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-xs font-extrabold text-slate-900 font-mono">{{ $totalWarranties }}</span>
                            <span class="text-[9px] text-slate-400">Total</span>
                        </div>
                    </div>

                    <div class="space-y-1.5 text-xs pt-1">
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Active</span>
                            <span class="font-mono text-slate-700 font-medium">142 (76.3%)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span> Expiring</span>
                            <span class="font-mono text-slate-700 font-medium">18 (9.7%)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Claimed</span>
                            <span class="font-mono text-slate-700 font-medium">12 (6.5%)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span> Expired</span>
                            <span class="font-mono text-slate-700 font-medium">14 (7.5%)</span>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>

</div>

{{-- ========================================================================= --}}
{{-- 3. MODAL: REGISTER WARRANTY                                               --}}
{{-- ========================================================================= --}}
<div id="registerWarrantyModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 no-print">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-5 relative border border-slate-200 text-xs">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <h4 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-certificate text-blue-600"></i> Register Product Warranty
            </h4>
            <button onclick="closeRegisterWarrantyModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <form action="{{ route('warranties.store') }}" method="POST" class="space-y-3 pt-3">
            @csrf
            <div>
                <label class="font-bold text-slate-700 block mb-1">Customer *</label>
                <select name="customer_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                    <option value="">Walk-in Customer</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->phone }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-bold text-slate-700 block mb-1">Product *</label>
                <select name="product_id" id="regProductSelect" onchange="onSelectWarrantyProduct(this)" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" data-name="{{ $p->name }}" data-brand="{{ $p->brand->brand_name ?? 'General' }}" data-months="{{ $p->warranty_period_months ?? 12 }}">
                            {{ $p->name }} &bull; (Warranty: {{ $p->warranty_period_months ?? 12 }} Mos)
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="product_name" id="regProductNameHidden" value="{{ $products->first()->name ?? 'ASUS TUF Gaming Laptop' }}">
                <input type="hidden" name="brand" id="regBrandHidden" value="{{ $products->first()->brand->brand_name ?? 'ASUS' }}">
            </div>

            <div>
                <label class="font-bold text-slate-700 block mb-1">Serial Number *</label>
                <input type="text" name="serial_number" placeholder="Enter Serial Number (e.g. SN123456789)" required
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none font-mono font-bold">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Purchase Date</label>
                    <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" required
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none font-mono">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Warranty Period</label>
                    <select name="warranty_period_months" id="regMonthsSelect" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        <option value="12">1 Year (12 Mos)</option>
                        <option value="24" selected>2 Years (24 Mos)</option>
                        <option value="36">3 Years (36 Mos)</option>
                        <option value="60">5 Years (60 Mos)</option>
                    </select>
                </div>
            </div>

            <div class="pt-3 flex items-center justify-end gap-2 border-t border-slate-100">
                <button type="button" onclick="closeRegisterWarrantyModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-sm">
                    Register Warranty
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 4. MODAL: LOOKUP WARRANTY BY SERIAL (Step 5.3)                            --}}
{{-- ========================================================================= --}}
<div id="lookupModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 no-print">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-5 relative border border-slate-200 text-xs">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <h4 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-barcode text-blue-600"></i> Warranty Lookup by Serial Number
            </h4>
            <button onclick="closeLookupModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <div class="space-y-3 pt-3">
            <div class="flex items-center gap-2">
                <input type="text" id="lookupSerialInput" placeholder="Enter Serial (e.g. SN123456789 or WAR-2025-0001)"
                       class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none font-mono">
                <button type="button" onclick="performSerialLookup()" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                    Search
                </button>
            </div>

            <div id="lookupResultBox" class="hidden p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-2 text-xs">
                <div class="flex justify-between items-start">
                    <div>
                        <h5 class="font-extrabold text-slate-900" id="lookupResProd">ASUS TUF Gaming Laptop</h5>
                        <p class="text-[10px] text-slate-400 font-mono" id="lookupResSerial">SN123456789</p>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold" id="lookupResStatus">Active</span>
                </div>

                <div class="space-y-1 text-[11px] text-slate-600 pt-1 border-t border-slate-200">
                    <p>Customer: <span class="font-bold text-slate-800" id="lookupResCust">Sok Dara</span></p>
                    <p>Purchase Date: <span class="font-mono" id="lookupResPurchase">2025-09-10</span></p>
                    <p>Expiry Date: <span class="font-mono font-bold" id="lookupResExpiry">2027-09-10</span></p>
                    <p id="lookupResDays" class="font-semibold text-emerald-600">730 days remaining</p>
                </div>

                <button type="button" id="btnClaimFromLookup" class="w-full py-2 bg-rose-600 text-white rounded-xl text-xs font-semibold hover:bg-rose-700 transition mt-2">
                    Submit Warranty Claim
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 5. JAVASCRIPT STATE ENGINE FOR WARRANTIES                                 --}}
{{-- ========================================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        initWarrantyDonutChart();
    });

    function initWarrantyDonutChart() {
        const ctx = document.getElementById('warrantyStatusDonutChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Expiring', 'Claimed', 'Expired'],
                datasets: [{
                    data: [142, 18, 12, 14],
                    backgroundColor: [
                        '#10B981', // Emerald for Active
                        '#FBBF24', // Amber for Expiring
                        '#F43F5E', // Rose for Claimed
                        '#94A3B8'  // Gray for Expired
                    ],
                    borderWidth: 2,
                    borderColor: '#FFFFFF',
                    cutout: '72%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    }

    function selectWarrantyPreview(id) {
        document.getElementById('warrantyDetailsPreviewCard').scrollIntoView({ behavior: 'smooth' });
    }

    function openRegisterWarrantyModal() {
        document.getElementById('registerWarrantyModalBackdrop').classList.remove('hidden');
    }

    function closeRegisterWarrantyModal() {
        document.getElementById('registerWarrantyModalBackdrop').classList.add('hidden');
    }

    function onSelectWarrantyProduct(select) {
        const opt = select.options[select.selectedIndex];
        document.getElementById('regProductNameHidden').value = opt.getAttribute('data-name');
        document.getElementById('regBrandHidden').value = opt.getAttribute('data-brand');
        document.getElementById('regMonthsSelect').value = opt.getAttribute('data-months') || '24';
    }

    function openLookupModal() {
        document.getElementById('lookupModalBackdrop').classList.remove('hidden');
    }

    function closeLookupModal() {
        document.getElementById('lookupModalBackdrop').classList.add('hidden');
    }

    async function performSerialLookup() {
        const query = document.getElementById('lookupSerialInput').value.trim();
        if (!query) {
            Swal.fire('ទទេ', 'សូមបញ្ចូល Serial Number', 'warning');
            return;
        }

        try {
            const res = await fetch(`/warranties/lookup?query=${encodeURIComponent(query)}`);
            const data = await res.json();
            if (data.success) {
                const w = data.warranty;
                document.getElementById('lookupResProd').textContent = w.product_name;
                document.getElementById('lookupResSerial').textContent = `Serial: ${w.serial_number} &bull; Code: ${w.warranty_code}`;
                document.getElementById('lookupResCust').textContent = w.customer ? w.customer.name : 'Walk-in';
                document.getElementById('lookupResPurchase').textContent = w.purchase_date;
                document.getElementById('lookupResExpiry').textContent = w.expiry_date;

                const badge = document.getElementById('lookupResStatus');
                badge.textContent = w.status;
                badge.className = `px-2 py-0.5 rounded-full text-[9px] font-bold ${w.status === 'Active' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'}`;

                const daysEl = document.getElementById('lookupResDays');
                if (data.is_expired) {
                    daysEl.textContent = 'ការធានាបានផុតកំណត់ហើយ (Warranty Expired)';
                    daysEl.className = 'font-semibold text-rose-600';
                } else {
                    daysEl.textContent = `${data.days_remaining} ថ្ងៃនៅសល់ (Days Remaining)`;
                    daysEl.className = 'font-semibold text-emerald-600';
                }

                document.getElementById('btnClaimFromLookup').onclick = () => openClaimModalFor(w.id);
                document.getElementById('lookupResultBox').classList.remove('hidden');
            } else {
                Swal.fire('រកមិនឃើញ', data.message, 'error');
            }
        } catch (e) {
            Swal.fire('កំហុស', 'មិនអាចស្វែងរកបានទេ', 'error');
        }
    }

    function openClaimModalFor(warrantyId) {
        closeLookupModal();
        Swal.fire({
            title: 'បង្កើតពាក្យទាមទារធានា (Warranty Claim)',
            input: 'textarea',
            inputPlaceholder: 'រៀបរាប់ពីបញ្ហា ឬការខូចខាតដែលត្រូវទាមទារធានា...',
            showCancelButton: true,
            confirmButtonText: 'បញ្ជូនសំណើ',
            confirmButtonColor: '#2563EB',
            preConfirm: (text) => {
                if (!text) Swal.showValidationMessage('សូមបញ្ចូលការពិពណ៌នាអំពីបញ្ហា');
                return text;
            }
        }).then(async res => {
            if (res.isConfirmed) {
                try {
                    const response = await fetch("{{ route('warranties.claim') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            warranty_id: warrantyId,
                            issue_description: res.value
                        })
                    });
                    const d = await response.json();
                    if (d.success) {
                        Swal.fire('ជោគជ័យ!', d.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('បរាជ័យ', d.message, 'error');
                    }
                } catch (e) {
                    Swal.fire('កំហុស', 'មិនអាចបញ្ជូនសំណើបានទេ', 'error');
                }
            }
        });
    }

    function openClaimModalPrompt() {
        Swal.fire('ជ្រើសរើសប័ណ្ណធានា', 'សូមចុចលើប៊ូតុង Claim ក្នុងតារាងប័ណ្ណធានា', 'info');
    }

    function applyFilters() {
        const search = document.getElementById('filterSearch').value || document.getElementById('topNavSearch').value;
        const brand = document.getElementById('filterBrand').value;
        const status = document.getElementById('filterStatus').value;
        const dateFrom = document.getElementById('filterDateFrom').value;
        const dateTo = document.getElementById('filterDateTo').value;

        const p = new URLSearchParams();
        if (search) p.append('search', search);
        if (brand && brand !== 'all') p.append('brand', brand);
        if (status && status !== 'all') p.append('status', status);
        if (dateFrom) p.append('date_from', dateFrom);
        if (dateTo) p.append('date_to', dateTo);

        window.location.href = "{{ route('warranty') }}?" + p.toString();
    }

    function scrollToTable() {
        document.getElementById('tableFilterSection').scrollIntoView({ behavior: 'smooth' });
    }

    function scrollToClaims() {
        document.getElementById('claimsSection').scrollIntoView({ behavior: 'smooth' });
    }

    function scrollToAlerts() {
        document.getElementById('expiryAlertsSection').scrollIntoView({ behavior: 'smooth' });
    }
</script>

</body>
</html>
