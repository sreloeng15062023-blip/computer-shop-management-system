<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Purchase Management | TECHZONE Computer Shop</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af', // TECHZONE signature blue
                        techblue: '#2563eb',
                        techdark: '#0B132B',
                        sidebardark: '#0B1528',
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .scrollbar-thin::-webkit-scrollbar { width: 5px; height: 5px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #f1f5f9; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 9999px; }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }

        @media print {
            body * { visibility: hidden !important; }
            #printableSlipArea, #printableSlipArea * { visibility: visible !important; }
            #printableSlipArea { position: absolute; left: 0; top: 0; width: 100%; display: block !important; padding: 20px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-[#F4F6F9] text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

<div class="flex min-h-screen">

    {{-- ========================================================================= --}}
    {{-- 1. SIDEBAR (TECHZONE Sidebar with Expanded Purchase Management Sub-Menu)  --}}
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

            <!-- Purchase Management (Active Section with Dropdown Sub-menu) -->
            <div class="space-y-1 pt-0.5">
                <a href="javascript:void(0)" onclick="switchTab('index')" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30 transition">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-cart-shopping w-4 text-center"></i> Purchase Management
                    </span>
                    <i class="fa-solid fa-chevron-down text-[11px] opacity-80"></i>
                </a>

                <!-- Sub-items exactly matching the design -->
                <div class="pl-7 pr-2 py-1 space-y-1">
                    <a href="javascript:void(0)" onclick="switchTab('create')" id="subnav_create" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-circle-plus text-[10px] text-blue-400"></i> Create Purchase Order
                    </a>
                    <a href="javascript:void(0)" onclick="openFirstPendingReceive()" id="subnav_receive" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-truck-ramp-box text-[10px] text-emerald-400"></i> Receive Products
                    </a>
                    <a href="javascript:void(0)" onclick="switchTab('index')" id="subnav_history" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-blue-400 bg-slate-800/60 transition">
                        <i class="fa-solid fa-clock-rotate-left text-[10px]"></i> Purchase History
                    </a>
                </div>
            </div>

            <a href="{{ route('inventory-transactions.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-warehouse w-4 text-center"></i> Inventory Management
            </a>

            <a href="{{ route('sales.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-cash-register w-4 text-center"></i> Sales Management (POS)
            </a>

            <a href="{{ route('repairs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-screwdriver-wrench w-4 text-center"></i> Repair Service Management
            </a>

            <a href="{{ route('warranties.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-shield-halved w-4 text-center"></i> Warranty Management
            </a>

            <a href="{{ route('invoices') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-file-invoice-dollar w-4 text-center"></i> Payment &amp; Invoice
            </a>

            <a href="{{ route('employees') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-user-group w-4 text-center"></i> Employee Management
            </a>

            <a href="{{ route('customers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-address-book w-4 text-center"></i> Customer Management
            </a>

            <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-truck-field w-4 text-center"></i> Supplier Management
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

        <!-- Bottom Copyright -->
        <div class="px-5 py-3 border-t border-slate-800/80 text-[11px] text-slate-500">
            &copy; {{ date('Y') }} TECHZONE Computer Shop
        </div>
    </aside>

    {{-- ========================================================================= --}}
    {{-- 2. MAIN VIEWPORT WRAPPER                                                  --}}
    {{-- ========================================================================= --}}
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">

        {{-- Top App Bar --}}
        <header class="bg-white border-b border-slate-200/90 px-6 py-3 flex items-center justify-between sticky top-0 z-20 shadow-sm no-print">
            <div class="relative w-72 md:w-96">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" placeholder="Search purchase orders, suppliers, products..."
                       oninput="filterTableClientSide(this.value)"
                       class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none text-xs transition text-slate-700">
            </div>

            <div class="flex items-center gap-4">
                <button class="relative w-9 h-9 rounded-xl bg-slate-50 hover:bg-slate-100 flex items-center justify-center text-slate-500 transition border border-slate-200">
                    <i class="fa-solid fa-bell text-sm"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center shadow">3</span>
                </button>

                <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&h=120&q=80"
                         alt="Admin Avatar" class="w-9 h-9 rounded-xl object-cover ring-2 ring-blue-500/20 shadow-sm">
                    <div class="hidden sm:block leading-tight">
                        <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-[10px] text-slate-400 font-medium">Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Alerts --}}
        <div class="px-6 pt-4 no-print">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-xs font-semibold flex items-center gap-2 shadow-sm mb-2">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-xs font-semibold flex items-center gap-2 shadow-sm mb-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-sm"></i> {{ session('error') }}
                </div>
            @endif
            @if(isset($errors) && $errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-xs font-medium shadow-sm mb-2">
                    <p class="font-bold mb-1 flex items-center gap-1.5"><i class="fa-solid fa-triangle-exclamation"></i> Form validation error:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- ========================================================================= --}}
        {{-- VIEW TAB 1: MAIN PURCHASE MANAGEMENT DASHBOARD                            --}}
        {{-- ========================================================================= --}}
        <main id="tab_index" class="p-6 space-y-6 flex-1 no-print">

            <!-- Title Header -->
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-600/30">
                    <i class="fa-solid fa-cart-shopping text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-slate-800 leading-tight">Purchase Management</h2>
                    <p class="text-xs text-slate-400 font-medium">Manage your purchase orders and supplier transactions</p>
                </div>
            </div>

            <!-- 4 Stat Cards Matching Image Exactly -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <!-- Card 1: Total Purchase Orders -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Purchase Orders</p>
                            <h3 class="text-2xl font-black text-slate-800 mt-1.5">{{ $totalOrders ?? 28 }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-regular fa-file-lines"></i>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center gap-1.5 text-[11px] font-semibold text-emerald-600">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        <span>12%</span>
                        <span class="text-slate-400 font-normal">(This month)</span>
                    </div>
                </div>

                <!-- Card 2: Received Orders -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Received Orders</p>
                            <h3 class="text-2xl font-black text-slate-800 mt-1.5">{{ $receivedOrders ?? 22 }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center gap-1.5 text-[11px] font-semibold text-emerald-600">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        <span>10%</span>
                        <span class="text-slate-400 font-normal">(This month)</span>
                    </div>
                </div>

                <!-- Card 3: Pending Orders -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pending Orders</p>
                            <h3 class="text-2xl font-black text-slate-800 mt-1.5">{{ $pendingOrders ?? 4 }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center gap-1.5 text-[11px] font-semibold text-rose-500">
                        <i class="fa-solid fa-arrow-trend-down"></i>
                        <span>20%</span>
                        <span class="text-slate-400 font-normal">(This month)</span>
                    </div>
                </div>

                <!-- Card 4: Total Purchase Amount -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Purchase Amount</p>
                            <h3 class="text-2xl font-black text-slate-800 mt-1.5">${{ number_format($totalSpend ?? 12450, 2) }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center gap-1.5 text-[11px] font-semibold text-emerald-600">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        <span>15%</span>
                    </div>
                </div>
            </div>

            <!-- Two-Column Layout: Left (Table Area ~75%) + Right (Recent POs & Top Suppliers ~25%) -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">

                <!-- LEFT SECTION: Toolbar, Filters, and Purchase Orders Table (3 Columns Span) -->
                <div class="xl:col-span-3 space-y-4">

                    <!-- Search & Filter Bar -->
                    <form method="GET" action="{{ route('purchase-orders.index') }}" class="bg-white rounded-2xl border border-slate-200/80 p-3 shadow-sm flex flex-col md:flex-row items-stretch md:items-center gap-2.5">
                        <div class="relative flex-1">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by PO number, supplier name, product..."
                                   class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:border-blue-500 focus:outline-none transition">
                        </div>

                        <select name="supplier_id" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 focus:outline-none focus:border-blue-500 font-medium">
                            <option value="">All Suppliers</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}" {{ request('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                            @endforeach
                        </select>

                        <select name="status" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 focus:outline-none focus:border-blue-500 font-medium">
                            <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Received" {{ request('status') == 'Received' ? 'selected' : '' }}>Received</option>
                            <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>

                        <div class="flex items-center gap-1.5">
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-2.5 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 focus:outline-none">
                            <span class="text-slate-400 text-xs">to</span>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-2.5 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 focus:outline-none">
                        </div>

                        <button type="button" onclick="switchTab('create')" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center justify-center gap-1.5 whitespace-nowrap">
                            <i class="fa-solid fa-plus text-[11px]"></i> Create Purchase Order
                        </button>
                    </form>

                    <!-- Table Container -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto scrollbar-thin">
                            <table class="w-full text-xs text-left" id="poDataTable">
                                <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10.5px] border-b border-slate-200">
                                    <tr>
                                        <th class="px-4 py-3.5 w-10 text-center">#</th>
                                        <th class="px-4 py-3.5">PO Number</th>
                                        <th class="px-4 py-3.5">Supplier</th>
                                        <th class="px-4 py-3.5">Purchase Date</th>
                                        <th class="px-4 py-3.5">Expected Date</th>
                                        <th class="px-4 py-3.5">Total Amount</th>
                                        <th class="px-4 py-3.5 text-center">Status</th>
                                        <th class="px-4 py-3.5">Created By</th>
                                        <th class="px-4 py-3.5 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    @forelse($purchaseOrders as $index => $po)
                                        <tr class="hover:bg-slate-50/80 transition po-table-row">
                                            <td class="px-4 py-3 text-center text-slate-400 font-medium">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3">
                                                <button onclick="viewPoDetails({{ json_encode($po->load(['supplier', 'user', 'details.product'])) }})" class="font-bold text-blue-600 hover:text-blue-800 font-mono tracking-tight text-left">
                                                    {{ $po->po_number }}
                                                </button>
                                            </td>
                                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $po->supplier->name ?? '—' }}</td>
                                            <td class="px-4 py-3 text-slate-500">{{ \Carbon\Carbon::parse($po->order_date)->format('Y-m-d') }}</td>
                                            <td class="px-4 py-3 text-slate-500">{{ $po->expected_delivery_date ? \Carbon\Carbon::parse($po->expected_delivery_date)->format('Y-m-d') : '—' }}</td>
                                            <td class="px-4 py-3 font-extrabold text-slate-800">${{ number_format($po->total_amount, 2) }}</td>
                                            <td class="px-4 py-3 text-center">
                                                @if($po->status === 'Received')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                        Received
                                                    </span>
                                                @elseif($po->status === 'Pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-600 border border-amber-200">
                                                        Pending
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-600 border border-rose-200">
                                                        Cancelled
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-slate-500">{{ $po->user->name ?? 'Admin' }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    <!-- View Button (Eye) -->
                                                    <button title="View PO Details"
                                                            onclick="viewPoDetails({{ json_encode($po->load(['supplier', 'user', 'details.product'])) }})"
                                                            class="w-7 h-7 rounded-lg bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center transition shadow-sm">
                                                        <i class="fa-solid fa-eye text-[11px]"></i>
                                                    </button>

                                                    <!-- Receive / Edit Button (Pen) -->
                                                    @if($po->status === 'Pending')
                                                        <button title="Receive Products"
                                                                onclick="openReceiveView({{ json_encode($po->load(['supplier', 'user', 'details.product'])) }})"
                                                                class="w-7 h-7 rounded-lg bg-cyan-500 hover:bg-cyan-600 text-white flex items-center justify-center transition shadow-sm">
                                                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                                        </button>
                                                    @else
                                                        <button title="Order already received" disabled
                                                                class="w-7 h-7 rounded-lg bg-slate-200 text-slate-400 flex items-center justify-center cursor-not-allowed">
                                                            <i class="fa-solid fa-check text-[11px]"></i>
                                                        </button>
                                                    @endif

                                                    <!-- Delete Button (Trash) -->
                                                    @if($po->status !== 'Received')
                                                        <form action="{{ route('purchase-orders.destroy', $po->id) }}" method="POST" class="inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" title="Delete PO" onclick="confirmDelete(this)"
                                                                    class="w-7 h-7 rounded-lg bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center transition shadow-sm">
                                                                <i class="fa-solid fa-trash text-[11px]"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button title="Cannot delete received order" disabled
                                                                class="w-7 h-7 rounded-lg bg-slate-200 text-slate-400 flex items-center justify-center cursor-not-allowed">
                                                            <i class="fa-solid fa-lock text-[11px]"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="px-4 py-16 text-center">
                                                <div class="flex flex-col items-center justify-center text-slate-400 gap-2">
                                                    <i class="fa-solid fa-box-open text-3xl text-slate-300"></i>
                                                    <p class="font-bold text-slate-600">No purchase orders found</p>
                                                    <p class="text-xs">Click "+ Create Purchase Order" to restock your shop inventory.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Footer Matching Image -->
                        <div class="px-4 py-3.5 bg-white border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                            <div>
                                Showing 1 to {{ count($purchaseOrders) }} of {{ $purchaseOrders->total() ?? count($purchaseOrders) }} entries
                            </div>
                            <div class="text-xs">
                                {{ $purchaseOrders->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SECTION: Widgets (Recent Purchase Orders & Top Suppliers) -->
                <div class="space-y-6">

                    <!-- Widget 1: Recent Purchase Orders Matching Image -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                        <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center justify-between">
                            <span>Recent Purchase Orders</span>
                            <i class="fa-solid fa-clock-rotate-left text-slate-400 text-xs"></i>
                        </h4>

                        <div class="space-y-3.5">
                            @php
                                $sampleRecents = (isset($recentOrders) && count($recentOrders) > 0) ? $recentOrders : $purchaseOrders->take(5);
                            @endphp
                            @forelse($sampleRecents as $ro)
                                <div class="flex items-start gap-2.5 pb-3 border-b border-slate-100 last:border-b-0 last:pb-0">
                                    <!-- Status Dot Indicator -->
                                    <span class="w-2.5 h-2.5 rounded-full mt-1.5 flex-shrink-0 {{ $ro->status === 'Received' ? 'bg-emerald-500' : ($ro->status === 'Pending' ? 'bg-amber-500' : 'bg-rose-500') }}"></span>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-xs font-bold text-slate-800 font-mono">{{ $ro->po_number }}</p>
                                            <span class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($ro->order_date)->format('Y-m-d') }}</span>
                                        </div>
                                        <p class="text-[11px] text-slate-500 truncate">{{ $ro->supplier->name ?? 'Supplier' }}</p>
                                        <div class="flex items-center justify-between mt-0.5">
                                            <span class="text-xs font-black text-slate-800">${{ number_format($ro->total_amount, 2) }}</span>
                                            <span class="text-[10px] font-semibold {{ $ro->status === 'Received' ? 'text-emerald-600' : ($ro->status === 'Pending' ? 'text-amber-600' : 'text-rose-600') }}">
                                                {{ $ro->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 text-center py-4">No recent orders</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Widget 2: Top Suppliers Matching Image -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-bold text-slate-800">Top Suppliers</h4>
                            <a href="{{ route('suppliers.index') }}" class="text-[11px] font-semibold text-blue-600 hover:text-blue-700">View All</a>
                        </div>

                        <div class="space-y-3.5">
                            @forelse($topSuppliers as $sup)
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs flex-shrink-0">
                                            {{ strtoupper(substr($sup->name, 0, 2)) }}
                                        </div>
                                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $sup->name }}</p>
                                    </div>
                                    <span class="text-xs font-black text-slate-800 whitespace-nowrap">
                                        ${{ number_format($sup->purchase_orders_sum_total_amount ?? 1200, 2) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 text-center py-4">No supplier statistics</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </main>

        {{-- ========================================================================= --}}
        {{-- VIEW TAB 2: CREATE PURCHASE ORDER (Bottom-Left View in Image)             --}}
        {{-- ========================================================================= --}}
        <main id="tab_create" class="p-6 space-y-6 flex-1 hidden no-print">
            <!-- Breadcrumbs -->
            <p class="text-xs text-slate-400 font-medium">
                <a href="javascript:void(0)" onclick="switchTab('index')" class="hover:text-blue-600">Purchase Management</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-1.5"></i>
                <span class="text-slate-700 font-bold">Create Purchase Order</span>
            </p>

            <!-- Title Header -->
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-600/30">
                    <i class="fa-solid fa-cart-plus text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-slate-800 leading-tight">Create Purchase Order</h2>
                    <p class="text-xs text-slate-400 font-medium">Create a new purchase order for your supplier</p>
                </div>
            </div>

            <form id="createPoMainForm" method="POST" action="{{ route('purchase-orders.store') }}" class="space-y-6">
                @csrf

                <!-- Section 1: Purchase Order Information -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-3">Purchase Order Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Supplier <span class="text-rose-500">*</span></label>
                            <select name="supplier_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:border-blue-500 focus:outline-none font-medium">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">PO Number <span class="text-rose-500">*</span></label>
                            <input type="text" name="po_number" readonly value="{{ $suggestedPoNumber ?? 'PO-'.date('Y').'-001' }}"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100 border border-slate-200 text-xs font-mono font-bold text-slate-700 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Purchase Date <span class="text-rose-500">*</span></label>
                            <input type="date" name="order_date" required value="{{ date('Y-m-d') }}"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:border-blue-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Expected Date <span class="text-rose-500">*</span></label>
                            <input type="date" name="expected_delivery_date" value="{{ date('Y-m-d', strtotime('+3 days')) }}"
                                   class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:border-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Notes</label>
                        <textarea name="notes" rows="3" placeholder="Enter additional notes..."
                                  class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:border-blue-500 focus:outline-none resize-none"></textarea>
                    </div>

                    <input type="hidden" name="status" value="Pending">
                </div>

                <!-- Section 2: Add Products Table -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h3 class="text-sm font-bold text-slate-800">Add Products</h3>
                        <button type="button" onclick="addNewProductRow()" class="px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-plus text-[10px]"></i> Add Product
                        </button>
                    </div>

                    <div class="overflow-x-auto scrollbar-thin">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px]">
                                <tr>
                                    <th class="px-3 py-2.5 w-10 text-center">#</th>
                                    <th class="px-3 py-2.5 min-w-[220px]">Product</th>
                                    <th class="px-3 py-2.5 w-28 text-center">Quantity</th>
                                    <th class="px-3 py-2.5 w-36 text-right">Unit Price ($)</th>
                                    <th class="px-3 py-2.5 w-36 text-right">Subtotal ($)</th>
                                    <th class="px-3 py-2.5 w-12 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="dynamicItemRows" class="divide-y divide-slate-100">
                                <!-- Dynamic rows injected by JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Total Calculation -->
                    <div class="flex justify-end pt-3 border-t border-slate-100">
                        <div class="flex items-center gap-4 text-sm font-bold">
                            <span class="text-slate-500">Total Amount:</span>
                            <span id="createGrandTotal" class="text-xl font-black text-blue-600">$0.00</span>
                        </div>
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="switchTab('index')" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-lg shadow-blue-600/30 transition">
                        Save Purchase Order
                    </button>
                </div>
            </form>
        </main>

        {{-- ========================================================================= --}}
        {{-- VIEW TAB 3: RECEIVE PRODUCTS (Bottom-Center View in Image)                --}}
        {{-- ========================================================================= --}}
        <main id="tab_receive" class="p-6 space-y-6 flex-1 hidden no-print">
            <p class="text-xs text-slate-400 font-medium">
                <a href="javascript:void(0)" onclick="switchTab('index')" class="hover:text-blue-600">Purchase Management</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-1.5"></i>
                <span class="text-slate-700 font-bold">Receive Products</span>
            </p>

            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-600/30">
                    <i class="fa-solid fa-truck-ramp-box text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-slate-800 leading-tight">Receive Products</h2>
                    <p class="text-xs text-slate-400 font-medium">Record received products from purchase orders</p>
                </div>
            </div>

            <!-- Banner Box of PO Info Matching Image -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 font-medium block">PO Number</span>
                        <span id="rec_po_number" class="text-sm font-extrabold font-mono text-slate-800">PO-2025-001</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Supplier</span>
                        <span id="rec_supplier_name" class="text-sm font-bold text-slate-800">ASUS Official Supplier</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Purchase Date</span>
                        <span id="rec_purchase_date" class="text-sm font-bold text-slate-800">2025-09-10</span>
                    </div>
                    <div class="flex items-center md:justify-end">
                        <span id="rec_status_badge" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                            Pending
                        </span>
                    </div>
                </div>
            </div>

            <!-- Products to Receive Table -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-3">Products to Receive</h3>

                <div class="overflow-x-auto scrollbar-thin">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px]">
                            <tr>
                                <th class="px-4 py-3 w-10 text-center">#</th>
                                <th class="px-4 py-3">Product</th>
                                <th class="px-4 py-3 text-center">Ordered Qty</th>
                                <th class="px-4 py-3 text-center">Received Qty</th>
                                <th class="px-4 py-3 text-right">Unit Price</th>
                                <th class="px-4 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="rec_items_body" class="divide-y divide-slate-100 text-slate-700">
                            <!-- Injected by JS -->
                        </tbody>
                    </table>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Notes</label>
                    <textarea id="rec_notes" rows="3" placeholder="Enter notes (optional)..."
                              class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:border-blue-500 focus:outline-none resize-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="switchTab('index')" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Cancel
                    </button>
                    <button type="button" id="confirmReceiveBtn" onclick="submitStockReceive()" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-lg shadow-blue-600/30 transition">
                        Confirm Receive
                    </button>
                </div>
            </div>
        </main>

        {{-- ========================================================================= --}}
        {{-- VIEW TAB 4: PURCHASE DETAILS (Bottom-Right View in Image)                  --}}
        {{-- ========================================================================= --}}
        <main id="tab_show" class="p-6 space-y-6 flex-1 hidden no-print">
            <p class="text-xs text-slate-400 font-medium">
                <a href="javascript:void(0)" onclick="switchTab('index')" class="hover:text-blue-600">Purchase Management</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-1.5"></i>
                <a href="javascript:void(0)" onclick="switchTab('index')" class="hover:text-blue-600">Purchase History</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-1.5"></i>
                <span id="show_breadcrumb_po" class="text-slate-700 font-bold">PO-2025-001</span>
            </p>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <i class="fa-solid fa-file-invoice text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-800 leading-tight">Purchase Details</h2>
                        <p class="text-xs text-slate-400 font-medium">Detailed order summary, line items, and invoice view</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-print"></i> Print
                    </button>
                    <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white text-xs font-bold shadow-md shadow-blue-700/30 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-file-arrow-down"></i> Download PDF
                    </button>
                </div>
            </div>

            <!-- Banner Box Matching Image -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 font-medium block">PO Number</span>
                        <span id="show_po_number" class="text-sm font-extrabold font-mono text-slate-800">PO-2025-001</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Supplier</span>
                        <span id="show_supplier" class="text-sm font-bold text-slate-800">ASUS Official Supplier</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Purchase Date</span>
                        <span id="show_date" class="text-sm font-bold text-slate-800">2025-09-10</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Expected Date</span>
                        <span id="show_exp_date" class="text-sm font-bold text-slate-800">2025-09-12</span>
                    </div>
                    <div class="flex items-center md:justify-end">
                        <span id="show_status" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                            Received
                        </span>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation: Products, Payment, Notes Matching Image -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <div class="flex items-center gap-6 border-b border-slate-200 pb-2 text-xs font-bold">
                    <button class="text-blue-600 border-b-2 border-blue-600 pb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-box"></i> Products
                    </button>
                    <button class="text-slate-400 hover:text-slate-600 pb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-credit-card"></i> Payment
                    </button>
                    <button class="text-slate-400 hover:text-slate-600 pb-2 flex items-center gap-1.5">
                        <i class="fa-solid fa-note-sticky"></i> Notes
                    </button>
                </div>

                <div class="overflow-x-auto scrollbar-thin">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px]">
                            <tr>
                                <th class="px-4 py-3 w-10 text-center">#</th>
                                <th class="px-4 py-3">Product</th>
                                <th class="px-4 py-3 text-center">Quantity</th>
                                <th class="px-4 py-3 text-right">Unit Price</th>
                                <th class="px-4 py-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody id="show_items_body" class="divide-y divide-slate-100 text-slate-700">
                            <!-- Injected by JS -->
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end pt-3 border-t border-slate-100">
                    <div class="flex items-center gap-6">
                        <span class="text-sm font-bold text-slate-500">Total Amount</span>
                        <span id="show_total_amount" class="text-2xl font-black text-blue-600">$7,700.00</span>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                    <button type="button" onclick="switchTab('index')" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-100 transition flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Back to List
                    </button>
                    <div class="flex gap-2">
                        <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-print"></i> Print
                        </button>
                        <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white text-xs font-bold shadow-md shadow-blue-700/30 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-file-arrow-down"></i> Download PDF
                        </button>
                    </div>
                </div>
            </div>
        </main>

    </div>
</div>

{{-- ========================================================================= --}}
{{-- 3. PRINTABLE PO SLIP (Formatted for Clean Paper / PDF Printing)           --}}
{{-- ========================================================================= --}}
<div id="printableSlipArea" class="hidden">
    <div class="max-w-3xl mx-auto p-8 border border-slate-300 rounded-2xl bg-white font-sans text-slate-800">
        <div class="flex items-center justify-between border-b border-slate-300 pb-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xl">
                    TZ
                </div>
                <div>
                    <h2 class="text-xl font-extrabold tracking-wide">TECHZONE COMPUTER SHOP</h2>
                    <p class="text-xs text-slate-500">Phnom Penh, Cambodia &bull; Tel: +855 23 888 999</p>
                </div>
            </div>
            <div class="text-right">
                <span class="text-xs uppercase font-bold text-slate-400">PURCHASE ORDER</span>
                <p id="print_po_number" class="text-base font-black font-mono text-slate-900"></p>
                <p id="print_date" class="text-xs text-slate-500"></p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6 text-xs">
            <div>
                <p class="text-[10px] uppercase font-bold text-slate-400">SUPPLIER</p>
                <p id="print_supplier" class="font-bold text-sm text-slate-800"></p>
            </div>
            <div class="text-right">
                <p class="text-[10px] uppercase font-bold text-slate-400">STATUS</p>
                <p id="print_status" class="font-bold text-sm text-slate-800"></p>
            </div>
        </div>

        <table class="w-full text-xs text-left mb-6">
            <thead class="border-y border-slate-300 bg-slate-50 uppercase text-[10px]">
                <tr>
                    <th class="py-2.5 px-2">Product Name</th>
                    <th class="py-2.5 px-2 text-center">Qty</th>
                    <th class="py-2.5 px-2 text-right">Unit Price</th>
                    <th class="py-2.5 px-2 text-right">Total</th>
                </tr>
            </thead>
            <tbody id="print_items_body" class="divide-y divide-slate-200"></tbody>
        </table>

        <div class="flex justify-end mb-8">
            <div class="w-56 space-y-1 text-xs">
                <div class="flex justify-between font-black text-sm border-t border-slate-400 pt-2">
                    <span>Total Amount:</span>
                    <span id="print_total" class="text-blue-600"></span>
                </div>
            </div>
        </div>

        <div class="border-t border-dashed border-slate-300 pt-8 mt-12 grid grid-cols-2 text-center text-xs">
            <div>
                <p class="border-t border-slate-400 pt-1 w-48 mx-auto font-semibold">Authorized Signature</p>
            </div>
            <div>
                <p class="border-t border-slate-400 pt-1 w-48 mx-auto font-semibold">Supplier Acknowledgement</p>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 4. JAVASCRIPT LOGIC (Dynamic Tabs, Product Repeater, Live Calculations)   --}}
{{-- ========================================================================= --}}
<script>
    const allProducts = @json($products);
    let currentRowCount = 0;
    let currentReceivePoId = null;

    // Tab Switching
    function switchTab(tabId) {
        document.getElementById('tab_index').classList.add('hidden');
        document.getElementById('tab_create').classList.add('hidden');
        document.getElementById('tab_receive').classList.add('hidden');
        document.getElementById('tab_show').classList.add('hidden');

        document.getElementById('tab_' + tabId).classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Update sidebar highlights
        document.getElementById('subnav_create').classList.remove('text-blue-400', 'bg-slate-800/60');
        document.getElementById('subnav_receive').classList.remove('text-blue-400', 'bg-slate-800/60');
        document.getElementById('subnav_history').classList.remove('text-blue-400', 'bg-slate-800/60');

        if (tabId === 'create') {
            document.getElementById('subnav_create').classList.add('text-blue-400', 'bg-slate-800/60');
            if (currentRowCount === 0) addNewProductRow();
        } else if (tabId === 'receive') {
            document.getElementById('subnav_receive').classList.add('text-blue-400', 'bg-slate-800/60');
        } else {
            document.getElementById('subnav_history').classList.add('text-blue-400', 'bg-slate-800/60');
        }
    }

    // Dynamic Product Rows in Create PO
    function addNewProductRow() {
        const tbody = document.getElementById('dynamicItemRows');
        const idx = currentRowCount++;
        const tr = document.createElement('tr');
        tr.dataset.index = idx;
        tr.className = 'hover:bg-slate-50 transition';

        let optionsHtml = '<option value="">Select a product...</option>';
        allProducts.forEach(p => {
            optionsHtml += `<option value="${p.id}" data-cost="${p.cost_price || 0}">${p.name} (${p.sku})</option>`;
        });

        tr.innerHTML = `
            <td class="px-3 py-2.5 text-center text-slate-400 font-bold row-num">${tbody.children.length + 1}</td>
            <td class="px-3 py-2.5">
                <select name="items[${idx}][product_id]" required onchange="onProductChange(this)" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:border-blue-500 focus:outline-none font-medium">
                    ${optionsHtml}
                </select>
            </td>
            <td class="px-3 py-2.5 text-center">
                <input type="number" name="items[${idx}][quantity]" value="1" min="1" required oninput="calcLineTotal(this)"
                       class="w-20 px-2 py-1.5 text-center rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:border-blue-500 focus:outline-none font-bold qty-input">
            </td>
            <td class="px-3 py-2.5 text-right">
                <input type="number" name="items[${idx}][unit_cost]" value="0.00" min="0" step="0.01" required oninput="calcLineTotal(this)"
                       class="w-28 px-2 py-1.5 text-right rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:border-blue-500 focus:outline-none font-bold cost-input">
            </td>
            <td class="px-3 py-2.5 text-right font-black text-slate-800 line-total">$0.00</td>
            <td class="px-3 py-2.5 text-center">
                <button type="button" onclick="removeProductRow(this)" class="w-7 h-7 rounded-lg text-rose-500 hover:bg-rose-50 flex items-center justify-center mx-auto transition">
                    <i class="fa-solid fa-trash text-xs"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    }

    function onProductChange(select) {
        const row = select.closest('tr');
        const opt = select.options[select.selectedIndex];
        const cost = parseFloat(opt.dataset.cost) || 0;
        row.querySelector('.cost-input').value = cost.toFixed(2);
        calcLineTotal(select);
    }

    function calcLineTotal(input) {
        const row = input.closest('tr');
        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const cost = parseFloat(row.querySelector('.cost-input').value) || 0;
        const total = qty * cost;
        row.querySelector('.line-total').textContent = '$' + total.toFixed(2);
        recalcGrandTotal();
    }

    function recalcGrandTotal() {
        let grand = 0;
        document.querySelectorAll('#dynamicItemRows tr').forEach(tr => {
            const qty = parseFloat(tr.querySelector('.qty-input')?.value) || 0;
            const cost = parseFloat(tr.querySelector('.cost-input')?.value) || 0;
            grand += (qty * cost);
        });
        document.getElementById('createGrandTotal').textContent = '$' + grand.toFixed(2);
    }

    function removeProductRow(btn) {
        const tbody = document.getElementById('dynamicItemRows');
        if (tbody.children.length <= 1) {
            Swal.fire({ icon: 'warning', title: 'At least 1 product required', timer: 1500, showConfirmButton: false });
            return;
        }
        btn.closest('tr').remove();
        Array.from(tbody.children).forEach((tr, i) => {
            tr.querySelector('.row-num').textContent = i + 1;
        });
        recalcGrandTotal();
    }

    // View PO Details (Tab Show)
    function viewPoDetails(po) {
        document.getElementById('show_breadcrumb_po').textContent = po.po_number;
        document.getElementById('show_po_number').textContent = po.po_number;
        document.getElementById('show_supplier').textContent = po.supplier ? po.supplier.name : '—';
        document.getElementById('show_date').textContent = po.order_date;
        document.getElementById('show_exp_date').textContent = po.expected_delivery_date || '—';
        document.getElementById('show_total_amount').textContent = '$' + parseFloat(po.total_amount || 0).toFixed(2);

        const statusEl = document.getElementById('show_status');
        statusEl.textContent = po.status;
        if (po.status === 'Received') {
            statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200';
        } else if (po.status === 'Pending') {
            statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200';
        } else {
            statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600 border border-rose-200';
        }

        // Fill Items
        let rowsHtml = '';
        (po.details || []).forEach((d, idx) => {
            const prodName = d.product ? d.product.name : 'Product #' + d.product_id;
            rowsHtml += `
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 text-center text-slate-400 font-medium">${idx + 1}</td>
                    <td class="px-4 py-3 font-bold text-slate-800">${prodName}</td>
                    <td class="px-4 py-3 text-center font-semibold text-slate-700">${d.quantity}</td>
                    <td class="px-4 py-3 text-right text-slate-600">$${parseFloat(d.unit_cost).toFixed(2)}</td>
                    <td class="px-4 py-3 text-right font-black text-slate-900">$${parseFloat(d.subtotal).toFixed(2)}</td>
                </tr>
            `;
        });
        document.getElementById('show_items_body').innerHTML = rowsHtml || '<tr><td colspan="5" class="py-4 text-center text-slate-400">No items</td></tr>';

        // Prepare print slip area
        document.getElementById('print_po_number').textContent = po.po_number;
        document.getElementById('print_date').textContent = 'Date: ' + po.order_date;
        document.getElementById('print_supplier').textContent = po.supplier ? po.supplier.name : '—';
        document.getElementById('print_status').textContent = po.status;
        document.getElementById('print_total').textContent = '$' + parseFloat(po.total_amount || 0).toFixed(2);
        document.getElementById('print_items_body').innerHTML = rowsHtml;

        switchTab('show');
    }

    // Open Receive View
    function openReceiveView(po) {
        currentReceivePoId = po.id;
        document.getElementById('rec_po_number').textContent = po.po_number;
        document.getElementById('rec_supplier_name').textContent = po.supplier ? po.supplier.name : '—';
        document.getElementById('rec_purchase_date').textContent = po.order_date;

        let rowsHtml = '';
        (po.details || []).forEach((d, idx) => {
            const prodName = d.product ? d.product.name : 'Product #' + d.product_id;
            rowsHtml += `
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 text-center text-slate-400 font-medium">${idx + 1}</td>
                    <td class="px-4 py-3 font-bold text-slate-800">${prodName}</td>
                    <td class="px-4 py-3 text-center font-bold text-slate-700">${d.quantity}</td>
                    <td class="px-4 py-3 text-center">
                        <input type="number" readonly value="${d.quantity}" class="w-16 px-2 py-1 text-center bg-slate-100 border border-slate-200 rounded-lg text-xs font-bold text-emerald-600">
                    </td>
                    <td class="px-4 py-3 text-right text-slate-600">$${parseFloat(d.unit_cost).toFixed(2)}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
                            Pending
                        </span>
                    </td>
                </tr>
            `;
        });
        document.getElementById('rec_items_body').innerHTML = rowsHtml;
        switchTab('receive');
    }

    function openFirstPendingReceive() {
        const pendingRow = document.querySelector('.po-table-row span.text-amber-600');
        if (pendingRow) {
            const btn = pendingRow.closest('tr').querySelector('button[title="Receive Products"]');
            if (btn) {
                btn.click();
                return;
            }
        }
        Swal.fire({
            icon: 'info',
            title: 'No Pending Orders',
            text: 'All purchase orders have already been received into stock.',
            confirmButtonColor: '#2563eb'
        });
    }

    // Submit Stock Receive (Auto Stock-In)
    function submitStockReceive() {
        if (!currentReceivePoId) return;

        Swal.fire({
            title: 'Confirm Stock Receive?',
            text: 'This will automatically add these items into product inventory and generate stock-in transaction logs.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Yes, Receive into Stock'
        }).then(result => {
            if (result.isConfirmed) {
                fetch(`/purchase-orders/${currentReceivePoId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: 'Received' })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({ icon: 'success', title: 'Stock Received!', text: data.message, timer: 1800, showConfirmButton: false })
                            .then(() => location.reload());
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: data.message });
                    }
                })
                .catch(() => {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Network or server error.' });
                });
            }
        });
    }

    // Confirm Delete PO
    function confirmDelete(btn) {
        Swal.fire({
            title: 'Delete Purchase Order?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Yes, Delete'
        }).then(result => {
            if (result.isConfirmed) {
                btn.closest('form').submit();
            }
        });
    }

    // Client-side quick filter
    function filterTableClientSide(query) {
        const q = query.toLowerCase();
        document.querySelectorAll('#poDataTable tbody tr').forEach(tr => {
            const text = tr.textContent.toLowerCase();
            tr.style.display = text.includes(q) ? '' : 'none';
        });
    }

    // Initialize first product row if creating
    document.addEventListener('DOMContentLoaded', () => {
        addNewProductRow();
    });
</script>

</body>
</html>
