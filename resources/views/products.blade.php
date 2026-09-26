<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog Management | TECHZONE</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .modal-backdrop {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(2px);
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .table-scroll::-webkit-scrollbar {
            height: 6px;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased">

    <div class="flex min-h-screen">

        {{-- ============================== SIDEBAR ============================== --}}
        <aside id="sidebar" class="fixed z-40 inset-y-0 left-0 w-72 bg-[#0f172a] text-slate-300 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
            <!-- Logo -->
            <div class="h-20 flex items-center gap-3 px-6 border-b border-white/10 shrink-0">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-600/30">
                    <i class="fa-solid fa-desktop text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-white font-extrabold text-lg leading-tight tracking-wide">TECHZONE</h1>
                    <p class="text-[11px] text-slate-400 font-medium">Computer Store System</p>
                </div>
                <button onclick="toggleSidebar()" class="ml-auto lg:hidden text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto sidebar-scroll py-5 px-4 space-y-1">
                <p class="px-3 text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Main</p>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-gauge-high w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <p class="px-3 text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 mt-4">Catalog</p>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30">
                    <i class="fa-solid fa-boxes-stacked w-5 text-center"></i>
                    <span>Product Management</span>
                </a>
                <a href="{{ route('brands.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-tags w-5 text-center"></i>
                    <span>Brands</span>
                </a>
                <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-truck-field w-5 text-center"></i>
                    <span>Suppliers</span>
                </a>
                <a href="{{ route('customers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span>Customers</span>
                </a>

                <p class="px-3 text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 mt-4">Operations</p>
                <a href="{{ route('purchases') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-cart-shopping w-5 text-center"></i>
                    <span>Purchases</span>
                </a>
                <a href="{{ route('pos.sales') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-cash-register w-5 text-center"></i>
                    <span>POS / Sales</span>
                </a>
                <a href="{{ route('inventory') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-warehouse w-5 text-center"></i>
                    <span>Inventory</span>
                </a>
                <a href="{{ route('repair.service') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-screwdriver-wrench w-5 text-center"></i>
                    <span>Repair Service</span>
                </a>
                <a href="{{ route('warranty') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-shield-halved w-5 text-center"></i>
                    <span>Warranty</span>
                </a>
                <a href="{{ route('invoices') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i>
                    <span>Invoices</span>
                </a>

                <p class="px-3 text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2 mt-4">Management</p>
                <a href="{{ route('employees') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-user-tie w-5 text-center"></i>
                    <span>Employees</span>
                </a>
                <a href="{{ route('reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                    <span>Reports</span>
                </a>
                <a href="{{ route('notifications') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-bell w-5 text-center"></i>
                    <span>Notifications</span>
                </a>
                <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                    <i class="fa-solid fa-gear w-5 text-center"></i>
                    <span>Settings</span>
                </a>
            </nav>

            <!-- Bottom user mini card -->
            <div class="p-4 border-t border-white/10 shrink-0">
                <div class="flex items-center gap-3 bg-white/5 rounded-xl px-3 py-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin User') }}&background=2563eb&color=fff&bold=true" class="w-9 h-9 rounded-full" alt="avatar">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin User' }}</p>
                        <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->role ?? 'Administrator' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Sidebar overlay for mobile -->
        <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 z-30 hidden lg:hidden"></div>

        {{-- ============================== MAIN CONTENT ============================== --}}
        <div class="flex-1 flex flex-col lg:ml-72 min-h-screen">

            {{-- TOPBAR --}}
            <header class="sticky top-0 z-20 h-20 bg-white border-b border-slate-200 flex items-center gap-4 px-4 sm:px-6">
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-500 hover:text-slate-800">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <div class="relative flex-1 max-w-md hidden sm:block">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" placeholder="Quick search..." class="w-full bg-slate-100 border border-transparent focus:border-blue-500 focus:bg-white rounded-xl pl-11 pr-4 py-2.5 text-sm outline-none transition">
                </div>

                <div class="ml-auto flex items-center gap-3 sm:gap-5">
                    <button class="sm:hidden text-slate-500 hover:text-slate-800">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>

                    <a href="{{ route('notifications') }}" class="relative w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition">
                        <i class="fa-solid fa-bell text-slate-600"></i>
                        <span class="absolute top-2 right-2.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    </a>

                    <div class="w-px h-8 bg-slate-200 hidden sm:block"></div>

                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin User') }}&background=0f172a&color=fff&bold=true" class="w-10 h-10 rounded-full border-2 border-slate-100" alt="avatar">
                        <div class="hidden sm:block">
                            <p class="text-sm font-bold text-slate-800 leading-tight">{{ Auth::user()->name ?? 'Admin User' }}</p>
                            <p class="text-xs text-slate-400 leading-tight">{{ Auth::user()->role ?? 'Administrator' }}</p>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400 hidden sm:block"></i>
                    </div>
                </div>
            </header>

            {{-- PAGE CONTENT --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6">

                {{-- Session messages --}}
                @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 rounded-xl flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-700 text-sm font-medium px-4 py-3 rounded-xl flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
                @endif

                {{-- HEADER --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Product Catalog Management</h2>
                        <p class="text-slate-500 text-sm mt-1">Manage computer products, SKU, barcodes, serial numbers and warranty</p>
                    </div>
                    <button onclick="openModal('addProductModal')" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-xl shadow-lg shadow-blue-600/25 transition whitespace-nowrap">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Product</span>
                    </button>
                </div>

                {{-- STAT CARDS --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">
                    <div class="bg-white rounded-2xl p-5 border border-slate-200 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                        <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-boxes-stacked text-blue-600 text-xl"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide">Total Products</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-0.5">{{ $totalProducts ?? 0 }}</h3>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-slate-200 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                        <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide">In Stock</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-0.5">{{ $inStockCount ?? 0 }}</h3>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-slate-200 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                        <div class="w-14 h-14 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-triangle-exclamation text-amber-500 text-xl"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide">Low Stock Alert</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-0.5">{{ $lowStockCount ?? 0 }}</h3>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 border border-slate-200 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                        <div class="w-14 h-14 rounded-xl bg-rose-50 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-xmark text-rose-500 text-xl"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide">Out of Stock</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-0.5">{{ $outOfStockCount ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                {{-- FILTER & SEARCH BAR --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-sm">
                    <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                        <div class="lg:col-span-2 relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, SKU or barcode..."
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl pl-11 pr-4 py-2.5 text-sm outline-none transition">
                        </div>

                        <div>
                            <select name="category_id" class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 rounded-xl px-4 py-2.5 text-sm outline-none transition">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <select name="brand_id" class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 rounded-xl px-4 py-2.5 text-sm outline-none transition">
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->brand_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <select name="status" class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 rounded-xl px-4 py-2.5 text-sm outline-none transition">
                                <option value="">All Status</option>
                                <option value="In Stock" {{ request('status') == 'In Stock' ? 'selected' : '' }}>In Stock</option>
                                <option value="Low Stock" {{ request('status') == 'Low Stock' ? 'selected' : '' }}>Low Stock</option>
                                <option value="Out of Stock" {{ request('status') == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                                <option value="Discontinued" {{ request('status') == 'Discontinued' ? 'selected' : '' }}>Discontinued</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2 lg:col-span-5 flex flex-wrap gap-3 justify-end pt-1">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold px-5 py-2.5 rounded-xl text-sm transition">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </a>
                            <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm shadow-md shadow-blue-600/25 transition">
                                <i class="fa-solid fa-filter"></i> Apply Filters
                            </button>
                        </div>
                    </form>
                </div>

                {{-- DATA TABLE --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto table-scroll">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold tracking-wider border-b border-slate-200">
                                    <th class="px-4 py-4 w-10"><input type="checkbox" id="selectAll" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500"></th>
                                    <th class="px-2 py-4 w-10">#</th>
                                    <th class="px-4 py-4 min-w-[260px]">Product</th>
                                    <th class="px-4 py-4">Category</th>
                                    <th class="px-4 py-4">Brand</th>
                                    <th class="px-4 py-4 text-right">Cost Price</th>
                                    <th class="px-4 py-4 text-right">Selling Price</th>
                                    <th class="px-4 py-4 text-center">Stock</th>
                                    <th class="px-4 py-4 text-center">Warranty</th>
                                    <th class="px-4 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($products as $index => $product)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-4 py-4">
                                        <input type="checkbox" class="row-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500" value="{{ $product->id }}">
                                    </td>
                                    <td class="px-2 py-4 text-slate-400 font-medium">
                                        {{ $products->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $product->thumbnail ? asset('storage/'.$product->thumbnail) : 'https://ui-avatars.com/api/?name='.urlencode($product->name).'&background=e2e8f0&color=475569' }}"
                                                class="w-12 h-12 rounded-lg object-cover border border-slate-200 shrink-0" alt="{{ $product->name }}">
                                            <div class="min-w-0">
                                                <p class="font-bold text-slate-800 truncate max-w-[220px]">{{ $product->name }}</p>
                                                <p class="text-xs text-slate-400 mt-0.5">
                                                    SKU: <span class="font-medium text-slate-500">{{ $product->sku }}</span>
                                                    @if($product->barcode)
                                                    &nbsp;&bull;&nbsp; {{ $product->barcode }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600">{{ $product->category->name ?? '—' }}</td>
                                    <td class="px-4 py-4 text-slate-600">{{ $product->brand->brand_name ?? '—' }}</td>
                                    <td class="px-4 py-4 text-right text-slate-600 font-medium">${{ number_format($product->cost_price, 2) }}</td>
                                    <td class="px-4 py-4 text-right text-slate-800 font-bold">${{ number_format($product->selling_price, 2) }}</td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="inline-flex flex-col items-center gap-1">
                                            <span class="text-slate-700 font-semibold text-xs">{{ $product->stock_quantity }} pcs</span>
                                            @if($product->status === 'In Stock')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">In Stock</span>
                                            @elseif($product->status === 'Low Stock')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-600 border border-amber-200">Low Stock</span>
                                            @elseif($product->status === 'Out of Stock')
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-600 border border-rose-200">Out of Stock</span>
                                            @else
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500 border border-slate-200">Discontinued</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="inline-flex items-center gap-1.5 text-slate-600 font-medium text-xs">
                                            <i class="fa-solid fa-shield-halved text-slate-400"></i>
                                            {{ $product->warranty_period_months ?? 0 }} mo
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" onclick='openViewModal(@json($product))'
                                                title="View Details"
                                                class="w-8 h-8 rounded-lg bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center transition">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </button>
                                            <button type="button" onclick='openEditModal(@json($product))'
                                                title="Edit Product"
                                                class="w-8 h-8 rounded-lg bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </button>
                                            <button type="button" onclick="openDeleteModal({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                                title="Delete Product"
                                                class="w-8 h-8 rounded-lg bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center transition">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3 text-slate-400">
                                            <i class="fa-solid fa-box-open text-4xl"></i>
                                            <p class="font-semibold text-slate-500">No products found</p>
                                            <p class="text-xs">Try adjusting your filters or add a new product.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION FOOTER --}}
                    @if($products->count() > 0)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-4 sm:px-6 py-4 border-t border-slate-200">
                        <p class="text-xs sm:text-sm text-slate-500">
                            Showing <span class="font-semibold text-slate-700">{{ $products->firstItem() }}</span>
                            to <span class="font-semibold text-slate-700">{{ $products->lastItem() }}</span>
                            of <span class="font-semibold text-slate-700">{{ $products->total() }}</span> results
                        </p>
                        <div class="text-sm">
                            {{ $products->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </main>

            {{-- FOOTER --}}
            <footer class="px-6 py-4 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} TECHZONE Computer Store Management System. All rights reserved.
            </footer>
        </div>
    </div>

    {{-- ============================== ADD PRODUCT MODAL ============================== --}}
    <div id="addProductModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" onclick="closeModal('addProductModal')"></div>
        <div class="relative bg-white w-full max-w-4xl max-h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200 shrink-0">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Add New Product</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Fill in the details below to add a new computer product</p>
                </div>
                <button onclick="closeModal('addProductModal')" class="w-9 h-9 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-700 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="addProductForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="overflow-y-auto px-6 py-5 space-y-6">
                @csrf

                <div>
                    <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-info-circle text-blue-500"></i> Basic Information</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Product Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" required placeholder="e.g. ASUS ROG Strix G16"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">SKU <span class="text-rose-500">*</span></label>
                            <input type="text" name="sku" required placeholder="e.g. LAP-ASU-0012"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Barcode</label>
                            <input type="text" name="barcode" placeholder="e.g. 8901234567890"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Category <span class="text-rose-500">*</span></label>
                            <select name="category_id" required class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 rounded-xl px-4 py-2.5 text-sm outline-none transition">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Brand <span class="text-rose-500">*</span></label>
                            <select name="brand_id" required class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 rounded-xl px-4 py-2.5 text-sm outline-none transition">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Supplier</label>
                            <select name="supplier_id" class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 rounded-xl px-4 py-2.5 text-sm outline-none transition">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-tag text-emerald-500"></i> Pricing & Stock</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Cost Price ($) <span class="text-rose-500">*</span></label>
                            <input type="number" step="0.01" min="0" name="cost_price" required placeholder="0.00"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Selling Price ($) <span class="text-rose-500">*</span></label>
                            <input type="number" step="0.01" min="0" name="selling_price" required placeholder="0.00"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Stock Quantity <span class="text-rose-500">*</span></label>
                            <input type="number" min="0" name="stock_quantity" required placeholder="0"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Min Stock Alert</label>
                            <input type="number" min="0" name="min_stock_alert" placeholder="e.g. 5"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Warranty Period (Months)</label>
                            <input type="number" min="0" name="warranty_period_months" placeholder="e.g. 12"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-microchip text-indigo-500"></i> Specifications</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">CPU</label>
                            <input type="text" name="specifications[cpu]" placeholder="e.g. Core i7-13700H"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">RAM</label>
                            <input type="text" name="specifications[ram]" placeholder="e.g. 16GB DDR5"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Storage</label>
                            <input type="text" name="specifications[storage]" placeholder="e.g. 512GB SSD"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">GPU</label>
                            <input type="text" name="specifications[gpu]" placeholder="e.g. RTX 4060 8GB"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-images text-amber-500"></i> Media</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Main Thumbnail</label>
                            <label class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-slate-300 hover:border-blue-500 rounded-xl py-6 cursor-pointer transition bg-slate-50">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400"></i>
                                <span class="text-xs text-slate-500 font-medium">Click to upload thumbnail</span>
                                <input type="file" name="thumbnail" accept="image/*" class="hidden">
                            </label>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Additional Gallery Images</label>
                            <label class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-slate-300 hover:border-blue-500 rounded-xl py-6 cursor-pointer transition bg-slate-50">
                                <i class="fa-solid fa-images text-2xl text-slate-400"></i>
                                <span class="text-xs text-slate-500 font-medium">Click to upload gallery images</span>
                                <input type="file" name="gallery_images[]" accept="image/*" multiple class="hidden">
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-barcode text-rose-500"></i> Serial Numbers</h4>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Enter one serial number per line</label>
                    <textarea name="serial_numbers" rows="4" placeholder="SN-0001-A1B2C3&#10;SN-0002-D4E5F6&#10;SN-0003-G7H8I9"
                        class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition font-mono"></textarea>
                </div>
            </form>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200 bg-slate-50 shrink-0">
                <button type="button" onclick="closeModal('addProductModal')" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-200 transition">Cancel</button>
                <button type="button" onclick="document.getElementById('addProductForm').requestSubmit()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-blue-600 hover:bg-blue-700 text-white shadow-md shadow-blue-600/25 transition">
                    <i class="fa-solid fa-floppy-disk"></i> Save Product
                </button>
            </div>
        </div>
    </div>

    {{-- ============================== EDIT PRODUCT MODAL ============================== --}}
    <div id="editProductModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" onclick="closeModal('editProductModal')"></div>
        <div class="relative bg-white w-full max-w-4xl max-h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200 shrink-0">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Edit Product</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Update the product details below</p>
                </div>
                <button onclick="closeModal('editProductModal')" class="w-9 h-9 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-700 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="editProductForm" action="{{ url('/products') }}" method="POST" enctype="multipart/form-data" class="overflow-y-auto px-6 py-5 space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="product_id" id="edit_product_id">

                <div>
                    <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-info-circle text-blue-500"></i> Basic Information</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Product Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" id="edit_name" required
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">SKU <span class="text-rose-500">*</span></label>
                            <input type="text" name="sku" id="edit_sku" required
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Barcode</label>
                            <input type="text" name="barcode" id="edit_barcode"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Category <span class="text-rose-500">*</span></label>
                            <select name="category_id" id="edit_category_id" required class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 rounded-xl px-4 py-2.5 text-sm outline-none transition">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Brand <span class="text-rose-500">*</span></label>
                            <select name="brand_id" id="edit_brand_id" required class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 rounded-xl px-4 py-2.5 text-sm outline-none transition">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Supplier</label>
                            <select name="supplier_id" id="edit_supplier_id" class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 rounded-xl px-4 py-2.5 text-sm outline-none transition">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-tag text-emerald-500"></i> Pricing & Stock</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Cost Price ($) <span class="text-rose-500">*</span></label>
                            <input type="number" step="0.01" min="0" name="cost_price" id="edit_cost_price" required
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Selling Price ($) <span class="text-rose-500">*</span></label>
                            <input type="number" step="0.01" min="0" name="selling_price" id="edit_selling_price" required
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Stock Quantity <span class="text-rose-500">*</span></label>
                            <input type="number" min="0" name="stock_quantity" id="edit_stock_quantity" required
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Min Stock Alert</label>
                            <input type="number" min="0" name="min_stock_alert" id="edit_min_stock_alert"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Warranty Period (Months)</label>
                            <input type="number" min="0" name="warranty_period_months" id="edit_warranty_period_months"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status</label>
                            <select name="status" id="edit_status" class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 rounded-xl px-4 py-2.5 text-sm outline-none transition">
                                <option value="In Stock">In Stock</option>
                                <option value="Low Stock">Low Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                                <option value="Discontinued">Discontinued</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-microchip text-indigo-500"></i> Specifications</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">CPU</label>
                            <input type="text" name="specifications[cpu]" id="edit_spec_cpu"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">RAM</label>
                            <input type="text" name="specifications[ram]" id="edit_spec_ram"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Storage</label>
                            <input type="text" name="specifications[storage]" id="edit_spec_storage"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">GPU</label>
                            <input type="text" name="specifications[gpu]" id="edit_spec_gpu"
                                class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition">
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-images text-amber-500"></i> Media</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Replace Main Thumbnail</label>
                            <label class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-slate-300 hover:border-blue-500 rounded-xl py-6 cursor-pointer transition bg-slate-50">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400"></i>
                                <span class="text-xs text-slate-500 font-medium">Click to upload new thumbnail</span>
                                <input type="file" name="thumbnail" accept="image/*" class="hidden">
                            </label>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Add More Gallery Images</label>
                            <label class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-slate-300 hover:border-blue-500 rounded-xl py-6 cursor-pointer transition bg-slate-50">
                                <i class="fa-solid fa-images text-2xl text-slate-400"></i>
                                <span class="text-xs text-slate-500 font-medium">Click to upload gallery images</span>
                                <input type="file" name="gallery_images[]" accept="image/*" multiple class="hidden">
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-barcode text-rose-500"></i> Serial Numbers</h4>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">One serial number per line (existing serials listed)</label>
                    <textarea name="serial_numbers" id="edit_serial_numbers" rows="4"
                        class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:bg-white rounded-xl px-4 py-2.5 text-sm outline-none transition font-mono"></textarea>
                </div>
            </form>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200 bg-slate-50 shrink-0">
                <button type="button" onclick="closeModal('editProductModal')" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-200 transition">Cancel</button>
                <button type="button" onclick="document.getElementById('editProductForm').requestSubmit()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-sky-500 hover:bg-sky-600 text-white shadow-md shadow-sky-500/25 transition">
                    <i class="fa-solid fa-floppy-disk"></i> Update Product
                </button>
            </div>
        </div>
    </div>

    {{-- ============================== VIEW PRODUCT DETAILS MODAL ============================== --}}
    <div id="viewProductModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" onclick="closeModal('viewProductModal')"></div>
        <div class="relative bg-white w-full max-w-5xl max-h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200 shrink-0">
                <div>
                    <h3 id="view_product_name" class="text-lg font-extrabold text-slate-900">Product Name</h3>
                    <p id="view_product_sku" class="text-xs text-slate-400 mt-0.5">SKU: —</p>
                </div>
                <button onclick="closeModal('viewProductModal')" class="w-9 h-9 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-700 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="overflow-y-auto px-6 py-5">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                    {{-- Image Gallery --}}
                    <div class="lg:col-span-2 space-y-3">
                        <div class="w-full aspect-square rounded-2xl overflow-hidden bg-slate-100 border border-slate-200">
                            <img id="view_main_image" src="" alt="Product image" class="w-full h-full object-cover">
                        </div>
                        <div id="view_gallery_thumbs" class="grid grid-cols-4 gap-2"></div>
                    </div>

                    {{-- Details --}}
                    <div class="lg:col-span-3 space-y-6">
                        <div class="flex flex-wrap items-center gap-2">
                            <span id="view_status_badge" class="px-3 py-1.5 rounded-full text-xs font-bold border">Status</span>
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-200">
                                <i class="fa-solid fa-shield-halved mr-1"></i> <span id="view_warranty">0</span> Months Warranty
                            </span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <p class="text-[11px] font-semibold text-slate-400 uppercase">Category</p>
                                <p id="view_category" class="text-sm font-bold text-slate-800 mt-1">—</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <p class="text-[11px] font-semibold text-slate-400 uppercase">Brand</p>
                                <p id="view_brand" class="text-sm font-bold text-slate-800 mt-1">—</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <p class="text-[11px] font-semibold text-slate-400 uppercase">Barcode</p>
                                <p id="view_barcode" class="text-sm font-bold text-slate-800 mt-1">—</p>
                            </div>
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                                <p class="text-[11px] font-semibold text-blue-400 uppercase">Cost Price</p>
                                <p id="view_cost_price" class="text-sm font-extrabold text-blue-700 mt-1">$0.00</p>
                            </div>
                            <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                                <p class="text-[11px] font-semibold text-emerald-500 uppercase">Selling Price</p>
                                <p id="view_selling_price" class="text-sm font-extrabold text-emerald-700 mt-1">$0.00</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <p class="text-[11px] font-semibold text-slate-400 uppercase">Stock Qty</p>
                                <p id="view_stock_quantity" class="text-sm font-bold text-slate-800 mt-1">0</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-microchip text-indigo-500"></i> Full Specifications</h4>
                            <div id="view_specs" class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm"></div>
                        </div>
                    </div>
                </div>

                {{-- Serial Numbers Tab --}}
                <div class="mt-8">
                    <h4 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-barcode text-rose-500"></i> Individual Serial Numbers</h4>
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 uppercase text-[11px] font-bold tracking-wider">
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">Serial Number</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody id="view_serials_body" class="divide-y divide-slate-100">
                                <tr>
                                    <td colspan="3" class="px-4 py-6 text-center text-slate-400">No serial numbers recorded</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200 bg-slate-50 shrink-0">
                <button type="button" onclick="closeModal('viewProductModal')" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-200 transition">Close</button>
            </div>
        </div>
    </div>

    {{-- ============================== DELETE PRODUCT MODAL ============================== --}}
    <div id="deleteProductModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" onclick="closeModal('deleteProductModal')"></div>
        <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-rose-50 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-extrabold text-slate-900">Delete Product</h3>
                <p class="text-sm text-slate-500 mt-2">
                    Are you sure you want to delete <span id="delete_product_name" class="font-bold text-slate-700">this product</span>?
                    This action cannot be undone and will remove all associated images and serial numbers.
                </p>
            </div>
            <form id="deleteProductForm" action="{{ url('/products') }}" method="POST" class="flex items-center gap-3 px-6 pb-6">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal('deleteProductModal')" class="flex-1 px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">Cancel</button>
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold bg-rose-500 hover:bg-rose-600 text-white shadow-md shadow-rose-500/25 transition">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    {{-- ============================== SCRIPTS ============================== --}}
    <script>
        // Sidebar toggle (mobile)
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Generic modal open/close
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id$="Modal"]').forEach(function(modal) {
                    if (!modal.classList.contains('hidden')) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        document.body.style.overflow = '';
                    }
                });
            }
        });

        // Select all checkbox
        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.row-checkbox').forEach(function(cb) {
                    cb.checked = selectAll.checked;
                });
            });
        }

        // File upload label preview text
        document.querySelectorAll('input[type="file"]').forEach(function(input) {
            input.addEventListener('change', function() {
                const label = input.closest('label').querySelector('span');
                if (!label) return;
                if (input.multiple && input.files.length > 0) {
                    label.textContent = input.files.length + ' file(s) selected';
                } else if (input.files.length > 0) {
                    label.textContent = input.files[0].name;
                }
            });
        });

        // Populate & open Edit Product Modal
        function openEditModal(product) {
            document.getElementById('editProductForm').action = "{{ url('/products') }}/" + product.id;
            document.getElementById('edit_product_id').value = product.id;
            document.getElementById('edit_name').value = product.name ?? '';
            document.getElementById('edit_sku').value = product.sku ?? '';
            document.getElementById('edit_barcode').value = product.barcode ?? '';
            document.getElementById('edit_category_id').value = product.category_id ?? '';
            document.getElementById('edit_brand_id').value = product.brand_id ?? '';
            document.getElementById('edit_supplier_id').value = product.supplier_id ?? '';
            document.getElementById('edit_cost_price').value = product.cost_price ?? '';
            document.getElementById('edit_selling_price').value = product.selling_price ?? '';
            document.getElementById('edit_stock_quantity').value = product.stock_quantity ?? '';
            document.getElementById('edit_min_stock_alert').value = product.min_stock_alert ?? '';
            document.getElementById('edit_warranty_period_months').value = product.warranty_period_months ?? '';
            document.getElementById('edit_status').value = product.status ?? 'In Stock';

            let specs = product.specifications;
            if (typeof specs === 'string') {
                try {
                    specs = JSON.parse(specs);
                } catch (e) {
                    specs = {};
                }
            }
            specs = specs || {};
            document.getElementById('edit_spec_cpu').value = specs.cpu ?? '';
            document.getElementById('edit_spec_ram').value = specs.ram ?? '';
            document.getElementById('edit_spec_storage').value = specs.storage ?? '';
            document.getElementById('edit_spec_gpu').value = specs.gpu ?? '';

            let serialsText = '';
            if (Array.isArray(product.serials)) {
                serialsText = product.serials.map(function(s) {
                    return s.serial_number ?? s;
                }).join('\n');
            }
            document.getElementById('edit_serial_numbers').value = serialsText;

            openModal('editProductModal');
        }

        // Populate & open View Product Modal
        function openViewModal(product) {
            document.getElementById('view_product_name').textContent = product.name ?? 'Product Name';
            document.getElementById('view_product_sku').textContent = 'SKU: ' + (product.sku ?? '—') + (product.barcode ? '  •  Barcode: ' + product.barcode : '');
            document.getElementById('view_category').textContent = (product.category && product.category.name) ? product.category.name : '—';
            document.getElementById('view_brand').textContent = (product.brand && product.brand.brand_name) ? product.brand.brand_name : '—';
            document.getElementById('view_barcode').textContent = product.barcode ?? '—';
            document.getElementById('view_cost_price').textContent = '$' + parseFloat(product.cost_price ?? 0).toFixed(2);
            document.getElementById('view_selling_price').textContent = '$' + parseFloat(product.selling_price ?? 0).toFixed(2);
            document.getElementById('view_stock_quantity').textContent = product.stock_quantity ?? 0;
            document.getElementById('view_warranty').textContent = product.warranty_period_months ?? 0;

            const badge = document.getElementById('view_status_badge');
            badge.textContent = product.status ?? 'In Stock';
            badge.className = 'px-3 py-1.5 rounded-full text-xs font-bold border ' + statusBadgeClasses(product.status);

            let specs = product.specifications;
            if (typeof specs === 'string') {
                try {
                    specs = JSON.parse(specs);
                } catch (e) {
                    specs = {
                        details: specs
                    };
                }
            }
            specs = specs || {};
            const specsContainer = document.getElementById('view_specs');
            specsContainer.innerHTML = '';
            const specLabels = {
                cpu: 'CPU / Processor',
                ram: 'RAM / Memory',
                storage: 'Storage',
                gpu: 'Graphics (GPU)'
            };
            let hasSpecs = false;
            Object.keys(specLabels).forEach(function(key) {
                if (specs[key]) {
                    hasSpecs = true;
                    specsContainer.innerHTML += '<div class="bg-slate-50 rounded-xl p-3 border border-slate-100 flex items-center justify-between">' +
                        '<span class="text-xs font-semibold text-slate-400">' + specLabels[key] + '</span>' +
                        '<span class="text-sm font-bold text-slate-800">' + specs[key] + '</span></div>';
                }
            });
            if (!hasSpecs && specs.details) {
                specsContainer.innerHTML = '<div class="col-span-2 bg-slate-50 rounded-xl p-3 border border-slate-100 text-sm text-slate-700">' + specs.details + '</div>';
            } else if (!hasSpecs) {
                specsContainer.innerHTML = '<div class="col-span-2 text-sm text-slate-400">No specifications recorded.</div>';
            }

            // Images
            const mainImage = document.getElementById('view_main_image');
            const thumbsContainer = document.getElementById('view_gallery_thumbs');
            const placeholder = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(product.name ?? 'Product') + '&background=e2e8f0&color=475569&size=256';
            let images = [];
            if (product.thumbnail) images.push('/storage/' + product.thumbnail);
            if (Array.isArray(product.images)) {
                product.images.forEach(function(img) {
                    const path = img.path || img.image_path || img.url || img;
                    if (path) images.push(typeof path === 'string' && path.startsWith('http') ? path : '/storage/' + path);
                });
            }
            if (images.length === 0) images.push(placeholder);

            mainImage.src = images[0];
            thumbsContainer.innerHTML = '';
            images.forEach(function(src, idx) {
                const thumb = document.createElement('button');
                thumb.type = 'button';
                thumb.className = 'aspect-square rounded-lg overflow-hidden border-2 ' + (idx === 0 ? 'border-blue-500' : 'border-slate-200') + ' hover:border-blue-400 transition';
                thumb.innerHTML = '<img src="' + src + '" class="w-full h-full object-cover" alt="thumb">';
                thumb.onclick = function() {
                    mainImage.src = src;
                    thumbsContainer.querySelectorAll('button').forEach(function(b) {
                        b.classList.remove('border-blue-500');
                        b.classList.add('border-slate-200');
                    });
                    thumb.classList.remove('border-slate-200');
                    thumb.classList.add('border-blue-500');
                };
                thumbsContainer.appendChild(thumb);
            });

            // Serial numbers
            const serialsBody = document.getElementById('view_serials_body');
            serialsBody.innerHTML = '';
            if (Array.isArray(product.serials) && product.serials.length > 0) {
                product.serials.forEach(function(serial, idx) {
                    const sNumber = serial.serial_number ?? serial;
                    const sStatus = serial.status ?? 'Available';
                    serialsBody.innerHTML += '<tr>' +
                        '<td class="px-4 py-3 text-slate-400">' + (idx + 1) + '</td>' +
                        '<td class="px-4 py-3 font-mono font-semibold text-slate-700">' + sNumber + '</td>' +
                        '<td class="px-4 py-3">' + serialStatusBadge(sStatus) + '</td></tr>';
                });
            } else {
                serialsBody.innerHTML = '<tr><td colspan="3" class="px-4 py-6 text-center text-slate-400">No serial numbers recorded</td></tr>';
            }

            openModal('viewProductModal');
        }

        function statusBadgeClasses(status) {
            switch (status) {
                case 'In Stock':
                    return 'bg-emerald-50 text-emerald-600 border-emerald-200';
                case 'Low Stock':
                    return 'bg-amber-50 text-amber-600 border-amber-200';
                case 'Out of Stock':
                    return 'bg-rose-50 text-rose-600 border-rose-200';
                default:
                    return 'bg-slate-100 text-slate-500 border-slate-200';
            }
        }

        function serialStatusBadge(status) {
            let classes = 'bg-slate-100 text-slate-500 border-slate-200';
            if (status === 'Available') classes = 'bg-emerald-50 text-emerald-600 border-emerald-200';
            else if (status === 'Sold') classes = 'bg-blue-50 text-blue-600 border-blue-200';
            else if (status === 'Under Repair') classes = 'bg-amber-50 text-amber-600 border-amber-200';
            return '<span class="px-2.5 py-1 rounded-full text-[11px] font-bold border ' + classes + '">' + status + '</span>';
        }

        // Populate & open Delete Product Modal
        function openDeleteModal(id, name) {
            document.getElementById('deleteProductForm').action = "{{ url('/products') }}/" + id;
            document.getElementById('delete_product_name').textContent = name;
            openModal('deleteProductModal');
        }
    </script>

</body>

</html>