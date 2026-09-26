<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inventory Management | TECHZONE Computer Shop</title>

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
                        techblue: '#2563eb',
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

        .adj-radio:checked + label {
            border-color: #2563eb;
            background-color: #eff6ff;
            box-shadow: 0 0 0 1px #2563eb inset;
        }
    </style>
</head>
<body class="bg-[#F4F6F9] text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

<div class="flex min-h-screen">

    {{-- ========================================================================= --}}
    {{-- 1. SIDEBAR (TECHZONE Sidebar with Expanded Inventory Sub-Menu)            --}}
    {{-- ========================================================================= --}}
    <aside class="w-64 bg-[#0B1528] text-slate-300 flex-shrink-0 hidden lg:flex flex-col fixed h-screen z-30 shadow-xl select-none">
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

            <a href="{{ route('purchase-orders.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-cart-shopping w-4 text-center"></i> Purchase Management
            </a>

            <!-- Inventory Management (Active Section with Dropdown Sub-menu Matching Image) -->
            <div class="space-y-1 pt-0.5">
                <a href="javascript:void(0)" onclick="switchTab('inventory_main')" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30 transition">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-warehouse w-4 text-center"></i> Inventory Management
                    </span>
                    <i class="fa-solid fa-chevron-down text-[11px] opacity-80"></i>
                </a>

                <!-- Sub-items exactly matching the design -->
                <div class="pl-7 pr-2 py-1 space-y-1">
                    <a href="javascript:void(0)" onclick="openStockInModal()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-box-archive text-[10px] text-emerald-400"></i> Stock In
                    </a>
                    <a href="javascript:void(0)" onclick="openStockOutModal()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-dolly text-[10px] text-blue-400"></i> Stock Out
                    </a>
                    <a href="javascript:void(0)" onclick="openAdjustmentModal()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-sliders text-[10px] text-purple-400"></i> Stock Adjustment
                    </a>
                    <a href="javascript:void(0)" onclick="switchTab('inventory_history')" id="subnav_history" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-clock-rotate-left text-[10px] text-amber-400"></i> Inventory History
                    </a>
                    <a href="javascript:void(0)" onclick="filterStatus('Low Stock')" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-triangle-exclamation text-[10px] text-amber-500"></i> Low Stock Alert
                    </a>
                    <a href="javascript:void(0)" onclick="Swal.fire({icon: 'info', title: 'Barcode Tracking', text: 'Scans & tracks product barcodes automatically.'})" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-barcode text-[10px] text-slate-400"></i> Barcode Tracking
                    </a>
                    <a href="javascript:void(0)" onclick="Swal.fire({icon: 'info', title: 'Serial Number Tracking', text: 'Hardware serial tracking active.'})" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-qrcode text-[10px] text-slate-400"></i> Serial Number Tracking
                    </a>
                </div>
            </div>

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

        <div class="px-5 py-3 border-t border-slate-800/80 text-[11px] text-slate-500">
            &copy; {{ date('Y') }} TECHZONE Computer Shop
        </div>
    </aside>

    {{-- ========================================================================= --}}
    {{-- 2. MAIN VIEWPORT WRAPPER                                                  --}}
    {{-- ========================================================================= --}}
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">

        {{-- Top App Bar --}}
        <header class="bg-white border-b border-slate-200/90 px-6 py-3 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div class="flex items-center gap-3 flex-1 max-w-lg">
                <button class="lg:hidden text-slate-500 hover:text-slate-800 text-lg">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="relative w-full">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" placeholder="Search products, SKU, barcode..."
                           oninput="filterClientTable(this.value)"
                           class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none text-xs transition text-slate-700">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <p class="hidden md:flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                    <i class="fa-solid fa-house text-[10px]"></i> Dashboard
                    <i class="fa-solid fa-chevron-right text-[9px]"></i>
                    <span class="text-slate-600 font-semibold">Inventory Management</span>
                </p>

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
        <div class="px-6 pt-4">
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
        {{-- VIEW TAB 1: MAIN INVENTORY DASHBOARD (Product Inventory & Widgets)        --}}
        {{-- ========================================================================= --}}
        <main id="tab_inventory_main" class="p-6 space-y-6 flex-1">

            <!-- Title Header -->
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-600/30">
                    <i class="fa-solid fa-boxes-stacked text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-slate-800 leading-tight">Inventory Management</h2>
                    <p class="text-xs text-slate-400 font-medium">Manage stock, stock in/out, adjustments and inventory history</p>
                </div>
            </div>

            <!-- 5 Stat Cards Matching Image Exactly -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                <!-- Card 1: Total Products -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-cube"></i>
                        </div>
                    </div>
                    <div class="mt-2.5">
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Products</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-0.5">{{ $totalProducts ?? 256 }}</h3>
                        <p class="text-[10px] text-slate-400 mt-1 font-medium">Active: <span class="text-emerald-600 font-bold">{{ $activeCount ?? 238 }}</span> | Inactive: {{ $inactiveCount ?? 18 }}</p>
                    </div>
                </div>

                <!-- Card 2: Total Stock Quantity -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-warehouse"></i>
                        </div>
                    </div>
                    <div class="mt-2.5">
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Stock Quantity</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-0.5">{{ number_format($totalStockQuantity ?? 12480) }}</h3>
                        <p class="text-[10px] text-slate-400 mt-1 font-medium">Units</p>
                    </div>
                </div>

                <!-- Card 3: Low Stock Items -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                    </div>
                    <div class="mt-2.5">
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Low Stock Items</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-0.5">{{ $lowStockCount ?? 12 }}</h3>
                        <p class="text-[10px] text-amber-600 mt-1 font-semibold">Need to restock</p>
                    </div>
                </div>

                <!-- Card 4: Out of Stock -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                    </div>
                    <div class="mt-2.5">
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Out of Stock</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-0.5">{{ $outOfStockCount ?? 3 }}</h3>
                        <p class="text-[10px] text-rose-500 mt-1 font-semibold">No stock available</p>
                    </div>
                </div>

                <!-- Card 5: Total Value (Cost) -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                    </div>
                    <div class="mt-2.5">
                        <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Value (Cost)</p>
                        <h3 class="text-2xl font-black text-slate-800 mt-0.5">${{ number_format($totalStockValue ?? 48750, 2) }}</h3>
                        <p class="text-[10px] text-slate-400 mt-1 font-medium">Purchase cost</p>
                    </div>
                </div>
            </div>

            <!-- Two-Column Layout: Left (Product Inventory ~75%) + Right (Quick Actions & Stock Status ~25%) -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">

                <!-- LEFT SECTION: Product Inventory Table (3 Columns Span) -->
                <div class="xl:col-span-3 space-y-4">

                    <!-- Toolbar & Filters -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-3.5 shadow-sm space-y-3">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                            <h3 class="text-sm font-bold text-slate-800">Product Inventory</h3>
                            <div class="flex items-center gap-2">
                                <button onclick="Swal.fire({icon: 'success', title: 'Exporting...', text: 'Product inventory list is being downloaded.', timer: 1500, showConfirmButton: false})"
                                        class="px-3 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-xs font-bold text-slate-600 transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-arrow-up-from-bracket text-[11px]"></i> Export
                                </button>
                                <button onclick="openAddProductModal()" class="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md shadow-blue-600/30 transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-plus text-[11px]"></i> Add Product
                                </button>
                            </div>
                        </div>

                        <form method="GET" action="{{ route('inventory-transactions.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center gap-2.5 pt-1">
                            <div class="relative flex-1">
                                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product name, SKU, barcode..."
                                       class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:border-blue-500 focus:outline-none transition">
                            </div>

                            <select name="category_id" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 focus:outline-none focus:border-blue-500 font-medium">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>

                            <select name="brand_id" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 focus:outline-none focus:border-blue-500 font-medium">
                                <option value="">All Brands</option>
                                @foreach($brands as $br)
                                    <option value="{{ $br->id }}" {{ request('brand_id') == $br->id ? 'selected' : '' }}>{{ $br->brand_name }}</option>
                                @endforeach
                            </select>

                            <select name="status" onchange="this.form.submit()" class="px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600 focus:outline-none focus:border-blue-500 font-medium">
                                <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Status</option>
                                <option value="In Stock" {{ request('status') == 'In Stock' ? 'selected' : '' }}>Available</option>
                                <option value="Low Stock" {{ request('status') == 'Low Stock' ? 'selected' : '' }}>Low Stock</option>
                                <option value="Out of Stock" {{ request('status') == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </form>
                    </div>

                    <!-- Product Inventory Table Matching Image -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto scrollbar-thin">
                            <table class="w-full text-xs text-left" id="inventoryProductsTable">
                                <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px] border-b border-slate-200">
                                    <tr>
                                        <th class="px-3 py-3 w-8 text-center"><input type="checkbox" class="rounded"></th>
                                        <th class="px-3 py-3 w-8 text-center">#</th>
                                        <th class="px-3 py-3 w-12 text-center">Image</th>
                                        <th class="px-3 py-3">Product Name</th>
                                        <th class="px-3 py-3">SKU</th>
                                        <th class="px-3 py-3">Brand</th>
                                        <th class="px-3 py-3">Category</th>
                                        <th class="px-3 py-3 text-center">Stock Qty</th>
                                        <th class="px-3 py-3 text-right">Unit Price</th>
                                        <th class="px-3 py-3 text-right">Total Value</th>
                                        <th class="px-3 py-3 text-center">Status</th>
                                        <th class="px-3 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    @forelse($productItems as $index => $item)
                                        @php
                                            $totalVal = ($item->stock_quantity ?? 0) * ($item->cost_price ?? $item->selling_price ?? 0);
                                        @endphp
                                        <tr class="hover:bg-slate-50/80 transition">
                                            <td class="px-3 py-2.5 text-center"><input type="checkbox" class="rounded"></td>
                                            <td class="px-3 py-2.5 text-center text-slate-400 font-medium">{{ $index + 1 }}</td>
                                            <td class="px-3 py-2.5 text-center">
                                                <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center mx-auto">
                                                    @if($item->images && $item->images->count() > 0)
                                                        <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <i class="fa-solid fa-laptop text-slate-400 text-xs"></i>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-3 py-2.5 font-bold text-slate-800">{{ $item->name }}</td>
                                            <td class="px-3 py-2.5 text-slate-500 font-mono text-[11px]">{{ $item->sku }}</td>
                                            <td class="px-3 py-2.5 text-slate-600">{{ $item->brand->brand_name ?? '—' }}</td>
                                            <td class="px-3 py-2.5 text-slate-600">{{ $item->category->name ?? '—' }}</td>
                                            <td class="px-3 py-2.5 text-center font-extrabold {{ $item->stock_quantity <= 0 ? 'text-rose-500' : 'text-slate-800' }}">
                                                {{ $item->stock_quantity }}
                                            </td>
                                            <td class="px-3 py-2.5 text-right font-semibold text-slate-700">
                                                ${{ number_format($item->cost_price ?? $item->selling_price ?? 0, 2) }}
                                            </td>
                                            <td class="px-3 py-2.5 text-right font-black text-slate-800">
                                                ${{ number_format($totalVal, 2) }}
                                            </td>
                                            <td class="px-3 py-2.5 text-center">
                                                @if($item->stock_quantity <= 0 || $item->status === 'Out of Stock')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                                        Out of Stock
                                                    </span>
                                                @elseif($item->stock_quantity <= ($item->min_stock_alert ?? 5) || $item->status === 'Low Stock')
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                                        Low Stock
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                        Available
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2.5 text-center">
                                                <div class="flex items-center justify-center gap-1">
                                                    <button title="View Product History" onclick="openProductQuickView({{ json_encode($item) }})" class="w-6 h-6 rounded-lg bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center transition">
                                                        <i class="fa-solid fa-eye text-[10px]"></i>
                                                    </button>
                                                    <button title="Adjust Stock" onclick="presetAdjustment({{ $item->id }}, {{ $item->stock_quantity }})" class="w-6 h-6 rounded-lg bg-cyan-500 hover:bg-cyan-600 text-white flex items-center justify-center transition">
                                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                                    </button>
                                                    <button title="Delete Item" onclick="Swal.fire({icon: 'warning', title: 'Protected Action', text: 'Manage product deletion through Product Management module.'})" class="w-6 h-6 rounded-lg bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center transition">
                                                        <i class="fa-solid fa-trash text-[10px]"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="px-4 py-16 text-center text-slate-400">
                                                <i class="fa-solid fa-boxes-stacked text-3xl mb-2 text-slate-300"></i>
                                                <p class="font-bold text-slate-600">No products found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Footer Matching Image -->
                        <div class="px-4 py-3 bg-white border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                            <div>
                                Showing 1 to {{ count($productItems) }} of {{ $productItems->total() ?? count($productItems) }} entries
                            </div>
                            <div class="text-xs">
                                {{ $productItems->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SECTION: Widgets (Quick Actions & Stock Status Donut Chart) -->
                <div class="space-y-6">

                    <!-- Widget 1: Quick Actions Matching Image -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-3">
                        <h4 class="text-sm font-bold text-slate-800 mb-2">Quick Actions</h4>

                        <!-- Action 1: Stock In -->
                        <button onclick="openStockInModal()" class="w-full flex items-center gap-3 p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50/50 border border-slate-200/80 hover:border-emerald-200 transition text-left group">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/30 flex-shrink-0 group-hover:scale-105 transition">
                                <i class="fa-solid fa-box-archive text-base"></i>
                            </div>
                            <div>
                                <p class="text-xs font-extrabold text-slate-800">Stock In</p>
                                <p class="text-[10.5px] text-slate-400">Add new stock to inventory</p>
                            </div>
                        </button>

                        <!-- Action 2: Stock Out -->
                        <button onclick="openStockOutModal()" class="w-full flex items-center gap-3 p-3 rounded-2xl bg-slate-50 hover:bg-blue-50/50 border border-slate-200/80 hover:border-blue-200 transition text-left group">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-600/30 flex-shrink-0 group-hover:scale-105 transition">
                                <i class="fa-solid fa-dolly text-base"></i>
                            </div>
                            <div>
                                <p class="text-xs font-extrabold text-slate-800">Stock Out</p>
                                <p class="text-[10.5px] text-slate-400">Remove stock from inventory</p>
                            </div>
                        </button>

                        <!-- Action 3: Stock Adjustment -->
                        <button onclick="openAdjustmentModal()" class="w-full flex items-center gap-3 p-3 rounded-2xl bg-slate-50 hover:bg-purple-50/50 border border-slate-200/80 hover:border-purple-200 transition text-left group">
                            <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center shadow-md shadow-purple-600/30 flex-shrink-0 group-hover:scale-105 transition">
                                <i class="fa-solid fa-sliders text-base"></i>
                            </div>
                            <div>
                                <p class="text-xs font-extrabold text-slate-800">Stock Adjustment</p>
                                <p class="text-[10.5px] text-slate-400">Adjust stock quantity</p>
                            </div>
                        </button>

                        <!-- Action 4: Import Products -->
                        <button onclick="Swal.fire({icon: 'info', title: 'Import Products', text: 'Select a CSV / Excel file to bulk import.'})" class="w-full flex items-center gap-3 p-3 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-200/80 transition text-left">
                            <div class="w-10 h-10 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-file-arrow-up text-base"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Import Products</p>
                                <p class="text-[10.5px] text-slate-400">Upload from CSV/Excel</p>
                            </div>
                        </button>

                        <!-- Action 5: Export Products -->
                        <button onclick="Swal.fire({icon: 'success', title: 'Exporting...', text: 'Exporting product list to Excel.'})" class="w-full flex items-center gap-3 p-3 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-200/80 transition text-left">
                            <div class="w-10 h-10 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-file-arrow-down text-base"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Export Products</p>
                                <p class="text-[10.5px] text-slate-400">Download product list</p>
                            </div>
                        </button>
                    </div>

                    <!-- Widget 2: Stock Status (Donut Chart Matching Image) -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                        <h4 class="text-sm font-bold text-slate-800 mb-4">Stock Status</h4>

                        <div class="flex items-center justify-between gap-4">
                            <!-- Circular Donut Ring Badge -->
                            <div class="relative w-28 h-28 flex items-center justify-center flex-shrink-0">
                                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                    <path class="text-slate-100" stroke-width="3.5" stroke="currentColor" fill="none"
                                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <!-- Available Arc (Green) -->
                                    <path class="text-emerald-500" stroke-dasharray="80, 100" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none"
                                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <!-- Low Stock Arc (Amber) -->
                                    <path class="text-amber-500" stroke-dasharray="15, 100" stroke-dashoffset="-80" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none"
                                          d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                                    <span class="text-base font-black text-slate-800 leading-none">{{ $totalProducts ?? 256 }}</span>
                                    <span class="text-[9px] text-slate-400 font-semibold uppercase mt-0.5">Products</span>
                                </div>
                            </div>

                            <!-- Legend List Matching Image -->
                            <div class="space-y-2.5 flex-1 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-2 text-slate-600 font-medium">
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Available
                                    </span>
                                    <span class="font-bold text-slate-800">{{ $availableCount ?? 238 }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-2 text-slate-600 font-medium">
                                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Low Stock
                                    </span>
                                    <span class="font-bold text-slate-800">{{ $lowStockCount ?? 12 }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center gap-2 text-slate-600 font-medium">
                                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Out of Stock
                                    </span>
                                    <span class="font-bold text-slate-800">{{ $outOfStockCount ?? 3 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        {{-- ========================================================================= --}}
        {{-- VIEW TAB 2: INVENTORY HISTORY (Bottom-Panel 3 in Image)                    --}}
        {{-- ========================================================================= --}}
        <main id="tab_inventory_history" class="p-6 space-y-6 flex-1 hidden">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="switchTab('inventory_main')" class="w-8 h-8 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 flex items-center justify-center text-slate-600 transition">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                    </button>
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-800">Inventory History</h2>
                        <p class="text-xs text-slate-400">Complete audit log of all stock movements and adjustments</p>
                    </div>
                </div>
            </div>

            <!-- Top Filter Bar Matching Image -->
            <form method="GET" action="{{ route('inventory-transactions.index') }}" class="bg-white rounded-2xl border border-slate-200/80 p-3.5 shadow-sm flex flex-wrap items-center gap-3 text-xs">
                <input type="date" name="date_from" value="{{ request('date_from', '2025-09-01') }}" class="px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700">
                <span class="text-slate-400 font-bold">&rarr;</span>
                <input type="date" name="date_to" value="{{ request('date_to', date('Y-m-d')) }}" class="px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700">

                <select name="tx_product_id" class="px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium">
                    <option value="">All Products</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>

                <select name="transaction_type" class="px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium">
                    <option value="">All Transactions</option>
                    <option value="Stock In">Stock In</option>
                    <option value="Stock Out">Stock Out</option>
                    <option value="Adjustment">Adjustment</option>
                    <option value="Sale">Sale</option>
                </select>

                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold transition shadow-md shadow-blue-600/30">
                    Apply
                </button>
            </form>

            <!-- Inventory History Table Matching Image -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="overflow-x-auto scrollbar-thin">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px] border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Product</th>
                                <th class="px-4 py-3 text-center">Type</th>
                                <th class="px-4 py-3 text-center">Quantity</th>
                                <th class="px-4 py-3">Reference</th>
                                <th class="px-4 py-3">User</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($transactions as $tx)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ $tx->created_at->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3 font-bold text-slate-800">{{ $tx->product->name ?? 'Product' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if($tx->transaction_type === 'Stock In')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">Stock In</span>
                                        @elseif($tx->transaction_type === 'Stock Out')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200">Stock Out</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200">{{ $tx->transaction_type }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center font-extrabold {{ $tx->quantity >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $tx->quantity >= 0 ? '+' : '' }}{{ $tx->quantity }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 font-mono text-[11px]">
                                        {{ $tx->reference_type ? ($tx->reference_type . ' #' . ($tx->reference_id ?? '')) : ($tx->reason ?? 'Manual') }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 font-semibold">{{ $tx->user->name ?? 'Admin' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-12 text-center text-slate-400 font-medium">No transaction records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Low Stock Alert Section Matching Image -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500"></i> Low Stock Alert
                    </h3>
                    <a href="javascript:void(0)" onclick="filterStatus('Low Stock')" class="text-xs font-bold text-blue-600 hover:text-blue-700">View All</a>
                </div>

                <div class="overflow-x-auto scrollbar-thin">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px]">
                            <tr>
                                <th class="px-4 py-2.5">Product</th>
                                <th class="px-4 py-2.5 text-center">Current Stock</th>
                                <th class="px-4 py-2.5 text-center">Min Stock</th>
                                <th class="px-4 py-2.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($lowStockProducts as $lp)
                                <tr>
                                    <td class="px-4 py-2.5 font-bold text-slate-800">{{ $lp->name }}</td>
                                    <td class="px-4 py-2.5 text-center font-extrabold text-amber-600">{{ $lp->stock_quantity }}</td>
                                    <td class="px-4 py-2.5 text-center text-slate-500">{{ $lp->min_stock_alert ?? 10 }}</td>
                                    <td class="px-4 py-2.5 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                            Low Stock
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-slate-400">All products have sufficient stock!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL 1: STOCK IN (Bottom-Panel 2 in Image)                               --}}
{{-- ========================================================================= --}}
<div id="modalStockIn" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden animate-fade-in">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <button onclick="closeModal('modalStockIn')" class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </button>
                <h3 class="font-bold text-base text-slate-800">Stock In</h3>
            </div>
            <button onclick="closeModal('modalStockIn')" class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('inventory.adjust') }}" method="POST" class="p-6 space-y-4 text-xs">
            @csrf
            <input type="hidden" name="adjustment_type" value="add">

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Supplier <span class="text-rose-500">*</span></label>
                <select name="supplier_id" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none">
                    <option value="">Select supplier</option>
                    @foreach($suppliers as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Product <span class="text-rose-500">*</span></label>
                <select name="product_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-medium">
                    <option value="">Select product</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} (Stock: {{ $p->stock_quantity }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Quantity <span class="text-rose-500">*</span></label>
                    <input type="number" name="quantity" min="1" value="1" required placeholder="Enter quantity"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-bold">
                </div>
                <div>
                    <label class="block font-semibold text-slate-600 mb-1">Unit Price ($)</label>
                    <input type="number" name="unit_cost" step="0.01" placeholder="Enter unit price"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-bold">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Reference No.</label>
                <input type="text" name="reference_no" placeholder="Enter reference number (e.g. PO-001)"
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-mono">
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Notes</label>
                <textarea name="reason" rows="2" placeholder="Enter notes..." required
                          class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none resize-none"></textarea>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Date <span class="text-rose-500">*</span></label>
                <input type="date" name="date" value="{{ date('Y-m-d') }}"
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalStockIn')" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-100 transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-md shadow-blue-600/30 transition">
                    Save Stock In
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL 2: STOCK OUT                                                        --}}
{{-- ========================================================================= --}}
<div id="modalStockOut" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-base text-slate-800">Stock Out (Deduct Stock)</h3>
            <button onclick="closeModal('modalStockOut')" class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('inventory.adjust') }}" method="POST" class="p-6 space-y-4 text-xs">
            @csrf
            <input type="hidden" name="adjustment_type" value="subtract">

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Product <span class="text-rose-500">*</span></label>
                <select name="product_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-medium">
                    <option value="">Select product to remove</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }} (Available: {{ $p->stock_quantity }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Quantity to Deduct <span class="text-rose-500">*</span></label>
                <input type="number" name="quantity" min="1" value="1" required
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-bold">
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Reason / Notes <span class="text-rose-500">*</span></label>
                <textarea name="reason" rows="3" required placeholder="e.g. Broken display unit, internal testing, customer return..."
                          class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none resize-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalStockOut')" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-100 transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold shadow-md shadow-rose-600/30 transition">
                    Deduct Stock
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL 3: STOCK ADJUSTMENT (Add, Subtract, Set with Live Calculation)       --}}
{{-- ========================================================================= --}}
<div id="modalAdjustment" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <h3 class="font-bold text-base text-slate-800">Stock Adjustment</h3>
            </div>
            <button onclick="closeModal('modalAdjustment')" class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('inventory.adjust') }}" method="POST" class="p-6 space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-semibold text-slate-600 mb-1">Product <span class="text-rose-500">*</span></label>
                <select id="adj_prod_select" name="product_id" required onchange="calculateAdjLive()"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-medium">
                    <option value="">Select a product</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" data-stock="{{ $p->stock_quantity }}">{{ $p->name }} (Stock: {{ $p->stock_quantity }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1.5">Adjustment Type <span class="text-rose-500">*</span></label>
                <div class="grid grid-cols-3 gap-2 text-center">
                    <div>
                        <input type="radio" id="type_add" name="adjustment_type" value="add" checked class="hidden adj-radio" onchange="calculateAdjLive()">
                        <label for="type_add" class="cursor-pointer block border-2 border-slate-200 rounded-xl p-2.5 text-center hover:border-emerald-300 transition">
                            <i class="fa-solid fa-circle-plus text-emerald-500 text-base block mb-0.5"></i>
                            <span class="font-bold text-slate-700">Add</span>
                            <span class="text-[10px] text-slate-400 block leading-tight">Surplus</span>
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="type_sub" name="adjustment_type" value="subtract" class="hidden adj-radio" onchange="calculateAdjLive()">
                        <label for="type_sub" class="cursor-pointer block border-2 border-slate-200 rounded-xl p-2.5 text-center hover:border-rose-300 transition">
                            <i class="fa-solid fa-circle-minus text-rose-500 text-base block mb-0.5"></i>
                            <span class="font-bold text-slate-700">Subtract</span>
                            <span class="text-[10px] text-slate-400 block leading-tight">Damaged</span>
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="type_set" name="adjustment_type" value="set" class="hidden adj-radio" onchange="calculateAdjLive()">
                        <label for="type_set" class="cursor-pointer block border-2 border-slate-200 rounded-xl p-2.5 text-center hover:border-blue-300 transition">
                            <i class="fa-solid fa-rotate text-blue-500 text-base block mb-0.5"></i>
                            <span class="font-bold text-slate-700">Set</span>
                            <span class="text-[10px] text-slate-400 block leading-tight">Recount</span>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Quantity <span class="text-rose-500">*</span></label>
                <input type="number" id="adj_qty_input" name="quantity" min="0" value="1" required oninput="calculateAdjLive()"
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-bold">
            </div>

            <!-- Live Preview Calculation Box -->
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3.5 space-y-1.5 text-xs">
                <div class="flex justify-between text-slate-500">
                    <span>Current Stock</span>
                    <span id="adj_preview_current" class="font-bold text-slate-700">—</span>
                </div>
                <div class="flex justify-between text-slate-500">
                    <span>Adjustment Delta</span>
                    <span id="adj_preview_delta" class="font-bold text-slate-700">—</span>
                </div>
                <div class="flex justify-between font-black text-slate-800 border-t border-slate-200 pt-1.5 text-sm">
                    <span>New Stock After Adjustment</span>
                    <span id="adj_preview_after" class="text-blue-600">—</span>
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-600 mb-1">Reason / Audit Notes <span class="text-rose-500">*</span></label>
                <textarea name="reason" rows="2" required placeholder="e.g. Physical inventory recount discrepancy, broken during demonstration..."
                          class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none resize-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('modalAdjustment')" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-100 transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold shadow-md shadow-purple-600/30 transition">
                    Apply Adjustment
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL 4: ADD PRODUCT (Bottom-Panel 1 in Image)                            --}}
{{-- ========================================================================= --}}
<div id="modalAddProduct" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-3xl shadow-2xl overflow-hidden max-h-[92vh] flex flex-col">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <h3 class="font-bold text-base text-slate-800">Add Product</h3>
            </div>
            <button onclick="closeModal('modalAddProduct')" class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="flex-1 flex overflow-hidden">
            <!-- Left Tabs Matching Image -->
            <div class="w-48 bg-slate-50 border-r border-slate-100 p-3 space-y-1 text-xs font-semibold text-slate-500">
                <button class="w-full text-left px-3 py-2 rounded-xl bg-white text-blue-600 shadow-sm border border-slate-200 flex items-center gap-2">
                    <i class="fa-regular fa-file-lines text-xs"></i> General
                </button>
                <button class="w-full text-left px-3 py-2 rounded-xl hover:bg-white transition flex items-center gap-2">
                    <i class="fa-regular fa-image text-xs"></i> Images
                </button>
                <button class="w-full text-left px-3 py-2 rounded-xl hover:bg-white transition flex items-center gap-2">
                    <i class="fa-solid fa-barcode text-xs"></i> Barcode
                </button>
                <button class="w-full text-left px-3 py-2 rounded-xl hover:bg-white transition flex items-center gap-2">
                    <i class="fa-solid fa-dollar-sign text-xs"></i> Pricing
                </button>
                <button class="w-full text-left px-3 py-2 rounded-xl hover:bg-white transition flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-xs"></i> Warranty
                </button>
            </div>

            <!-- Form Content -->
            <form action="{{ route('products.store') }}" method="POST" class="flex-1 p-6 overflow-y-auto scrollbar-thin space-y-4 text-xs">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-600 mb-1">Product Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Enter product name"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-600 mb-1">SKU <span class="text-rose-500">*</span></label>
                        <input type="text" name="sku" required placeholder="Enter SKU"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-600 mb-1">Barcode</label>
                        <input type="text" name="barcode" placeholder="Enter barcode"
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-mono">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-600 mb-1">Brand</label>
                        <select name="brand_id" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none">
                            <option value="">Select brand</option>
                            @foreach($brands as $b)
                                <option value="{{ $b->id }}">{{ $b->brand_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-600 mb-1">Category <span class="text-rose-500">*</span></label>
                        <select name="category_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none">
                            <option value="">Select category</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-600 mb-1">Initial Stock <span class="text-rose-500">*</span></label>
                        <input type="number" name="stock_quantity" value="10" min="0" required
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-bold">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-600 mb-1">Cost Price ($) <span class="text-rose-500">*</span></label>
                        <input type="number" name="cost_price" step="0.01" value="100.00" required
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-bold">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-600 mb-1">Selling Price ($) <span class="text-rose-500">*</span></label>
                        <input type="number" name="selling_price" step="0.01" value="130.00" required
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none font-bold">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('modalAddProduct')" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-100 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-md shadow-blue-600/30 transition">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 4. JAVASCRIPT LOGIC (Interactive Tabs, Modals, Quick Actions)             --}}
{{-- ========================================================================= --}}
<script>
    // Tab switching
    function switchTab(tabId) {
        document.getElementById('tab_inventory_main').classList.add('hidden');
        document.getElementById('tab_inventory_history').classList.add('hidden');

        document.getElementById('tab_' + tabId).classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });

        if (tabId === 'inventory_history') {
            document.getElementById('subnav_history')?.classList.add('text-blue-400', 'bg-slate-800/60');
        } else {
            document.getElementById('subnav_history')?.classList.remove('text-blue-400', 'bg-slate-800/60');
        }
    }

    // Modal helpers
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function openStockInModal() { openModal('modalStockIn'); }
    function openStockOutModal() { openModal('modalStockOut'); }
    function openAdjustmentModal() {
        calculateAdjLive();
        openModal('modalAdjustment');
    }
    function openAddProductModal() { openModal('modalAddProduct'); }

    function presetAdjustment(prodId, stock) {
        const select = document.getElementById('adj_prod_select');
        select.value = prodId;
        calculateAdjLive();
        openModal('modalAdjustment');
    }

    // Live Stock Adjustment Calculator
    function calculateAdjLive() {
        const select = document.getElementById('adj_prod_select');
        const opt = select.options[select.selectedIndex];
        const stock = opt && opt.value ? parseInt(opt.dataset.stock, 10) : 0;
        const qty = parseInt(document.getElementById('adj_qty_input').value, 10) || 0;
        const type = document.querySelector('input[name="adjustment_type"]:checked')?.value || 'add';

        let delta = 0;
        let finalStock = stock;

        if (type === 'add') {
            delta = qty;
            finalStock = stock + qty;
        } else if (type === 'subtract') {
            delta = -qty;
            finalStock = stock - qty;
        } else if (type === 'set') {
            delta = qty - stock;
            finalStock = qty;
        }

        document.getElementById('adj_preview_current').textContent = stock + ' units';
        document.getElementById('adj_preview_delta').textContent = (delta >= 0 ? '+' : '') + delta + ' units';

        const afterEl = document.getElementById('adj_preview_after');
        afterEl.textContent = finalStock + ' units';
        if (finalStock < 0) {
            afterEl.className = 'text-rose-600 font-black';
        } else {
            afterEl.className = 'text-blue-600 font-black';
        }
    }

    // Quick client-side filter
    function filterClientTable(query) {
        const q = query.toLowerCase();
        document.querySelectorAll('#inventoryProductsTable tbody tr').forEach(tr => {
            const text = tr.textContent.toLowerCase();
            tr.style.display = text.includes(q) ? '' : 'none';
        });
    }

    function filterStatus(status) {
        const select = document.querySelector('select[name="status"]');
        if (select) {
            select.value = status;
            select.form.submit();
        }
    }

    function openProductQuickView(prod) {
        Swal.fire({
            title: prod.name,
            html: `
                <div class="text-left text-xs space-y-2 p-2 font-sans">
                    <p><b>SKU:</b> ${prod.sku}</p>
                    <p><b>Brand:</b> ${prod.brand ? prod.brand.brand_name : '—'}</p>
                    <p><b>Category:</b> ${prod.category ? prod.category.name : '—'}</p>
                    <p><b>Current Stock:</b> <span class="font-bold text-blue-600 text-sm">${prod.stock_quantity} units</span></p>
                    <p><b>Cost Price:</b> $${parseFloat(prod.cost_price || 0).toFixed(2)}</p>
                    <p><b>Selling Price:</b> $${parseFloat(prod.selling_price || 0).toFixed(2)}</p>
                </div>
            `,
            icon: 'info',
            confirmButtonColor: '#2563eb'
        });
    }

    // Close on click backdrop
    window.onclick = function(e) {
        ['modalStockIn', 'modalStockOut', 'modalAdjustment', 'modalAddProduct'].forEach(id => {
            const el = document.getElementById(id);
            if (e.target === el) closeModal(id);
        });
    }
</script>

</body>
</html>
