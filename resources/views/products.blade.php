@php
use Illuminate\Support\Str;

$navItems = [
['label' => 'Dashboard', 'icon' => 'fa-gauge-high', 'route' => 'dashboard'],
['label' => 'Product Management', 'icon' => 'fa-boxes-stacked', 'route' => 'products.index'],
['label' => 'Brands', 'icon' => 'fa-copyright', 'route' => 'brands.index'],
['label' => 'Suppliers', 'icon' => 'fa-truck-field', 'route' => 'suppliers.index'],
['label' => 'Customers', 'icon' => 'fa-users', 'route' => 'customers.index'],
['label' => 'Purchases', 'icon' => 'fa-cart-shopping', 'route' => 'purchases'],
['label' => 'POS / Sales', 'icon' => 'fa-cash-register', 'route' => 'pos.sales'],
['label' => 'Inventory', 'icon' => 'fa-warehouse', 'route' => 'inventory'],
['label' => 'Repair Service', 'icon' => 'fa-screwdriver-wrench', 'route' => 'repair.service'],
['label' => 'Warranty', 'icon' => 'fa-shield-halved', 'route' => 'warranty'],
['label' => 'Invoices', 'icon' => 'fa-file-invoice-dollar', 'route' => 'invoices'],
['label' => 'Employees', 'icon' => 'fa-id-badge', 'route' => 'employees'],
['label' => 'Reports', 'icon' => 'fa-chart-line', 'route' => 'reports'],
['label' => 'Notifications', 'icon' => 'fa-bell', 'route' => 'notifications'],
['label' => 'Settings', 'icon' => 'fa-gear', 'route' => 'settings'],
];
@endphp
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
                    colors: {
                        techdark: '#0f172a',
                    }
                }
            }
        }
    </script>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .modal-backdrop {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(2px);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased">

    <div class="flex min-h-screen">

        <!-- ================= SIDEBAR ================= -->
        <aside class="hidden lg:flex lg:flex-col w-72 shrink-0 bg-[#0f172a] text-slate-300 min-h-screen sticky top-0 h-screen overflow-y-auto">
            <div class="flex items-center gap-3 px-6 py-6 border-b border-white/10">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-md shadow-blue-600/30">
                    <i class="fa-solid fa-desktop text-white text-lg"></i>
                </div>
                <div>
                    <p class="text-white font-extrabold text-lg leading-none tracking-wide">TECHZONE</p>
                    <p class="text-[11px] text-slate-400 mt-1">Computer Store System</p>
                </div>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-1">
                <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-2">Main Menu</p>
                @foreach ($navItems as $item)
                @php
                $isActive = Route::currentRouteName() === $item['route'] || ($item['route'] === 'products.index' && Str::startsWith(Route::currentRouteName() ?? '', 'products'));
                @endphp
                <a href="{{ route($item['route']) }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
                   {{ $isActive
                        ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30'
                        : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid {{ $item['icon'] }} w-5 text-center {{ $isActive ? 'text-white' : 'text-slate-400' }}"></i>
                    <span>{{ $item['label'] }}</span>
                    @if ($isActive)
                    <i class="fa-solid fa-circle text-[6px] ml-auto text-white"></i>
                    @endif
                </a>
                @endforeach
            </nav>

            <div class="px-4 py-5 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-rose-400 hover:bg-rose-500/10 transition">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Sidebar -->
        <aside id="mobileSidebar" class="lg:hidden fixed inset-y-0 left-0 z-50 w-72 bg-[#0f172a] text-slate-300 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">
            <div class="flex items-center justify-between px-6 py-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-md shadow-blue-600/30">
                        <i class="fa-solid fa-desktop text-white text-lg"></i>
                    </div>
                    <p class="text-white font-extrabold text-lg tracking-wide">TECHZONE</p>
                </div>
                <button onclick="toggleMobileSidebar()" class="text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <nav class="px-3 py-5 space-y-1">
                @foreach ($navItems as $item)
                @php
                $isActive = Route::currentRouteName() === $item['route'] || ($item['route'] === 'products.index' && Str::startsWith(Route::currentRouteName() ?? '', 'products'));
                @endphp
                <a href="{{ route($item['route']) }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150
                   {{ $isActive ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid {{ $item['icon'] }} w-5 text-center"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
                @endforeach
            </nav>
        </aside>
        <div id="mobileOverlay" onclick="toggleMobileSidebar()" class="hidden fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

        <!-- ================= MAIN CONTENT ================= -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- ============ TOPBAR ============ -->
            <header class="sticky top-0 z-30 bg-white border-b border-slate-200 px-4 sm:px-6 py-3 flex items-center gap-4">
                <button onclick="toggleMobileSidebar()" class="lg:hidden text-slate-500 hover:text-slate-800">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <div class="hidden sm:flex items-center flex-1 max-w-md relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 text-slate-400 text-sm"></i>
                    <input type="text" placeholder="Quick search products, SKU, barcode..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-100 border border-transparent focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                </div>

                <div class="flex items-center gap-3 ml-auto">
                    <button class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
                        <i class="fa-regular fa-bell text-lg"></i>
                        <span class="absolute top-2 right-2.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    </button>

                    <div class="w-px h-8 bg-slate-200 hidden sm:block"></div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="hidden sm:block leading-tight">
                            <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name ?? 'Admin User' }}</p>
                            <p class="text-xs text-slate-500">{{ Auth::user()->role ?? 'Administrator' }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- ============ PAGE CONTENT ============ -->
            <main class="flex-1 p-4 sm:p-6 space-y-6">

                @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
                @endif

                <!-- Page Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-extrabold text-slate-800">Product Catalog Management</h1>
                        <p class="text-sm text-slate-500 mt-1">Manage computer products, SKU, barcodes, serial numbers and warranty</p>
                    </div>
                    <button onclick="openModal('addProductModal')"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-blue-600/30 transition">
                        <i class="fa-solid fa-plus"></i> Add Product
                    </button>
                </div>

                <!-- Stat Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center justify-between shadow-sm">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Products</p>
                            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $totalProducts ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center justify-between shadow-sm">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">In Stock</p>
                            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $inStockCount ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center justify-between shadow-sm">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Low Stock Alert</p>
                            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $lowStockCount ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center justify-between shadow-sm">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Out of Stock</p>
                            <p class="text-3xl font-extrabold text-slate-800 mt-1">{{ $outOfStockCount ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                    </div>
                </div>

                <!-- Filter & Search Bar -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 shadow-sm">
                    <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                        <div class="md:col-span-2 relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by name, SKU or barcode..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-100 border border-transparent focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                        </div>

                        <div>
                            <select name="category_id" class="w-full px-3 py-2.5 rounded-xl bg-slate-100 border border-transparent focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ (string) request('category_id') === (string) $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <select name="brand_id" class="w-full px-3 py-2.5 rounded-xl bg-slate-100 border border-transparent focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                                <option value="">All Brands</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ (string) request('brand_id') === (string) $brand->id ? 'selected' : '' }}>
                                    {{ $brand->brand_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <select name="status" class="w-full px-3 py-2.5 rounded-xl bg-slate-100 border border-transparent focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                                <option value="">All Status</option>
                                @foreach (['In Stock', 'Low Stock', 'Out of Stock', 'Discontinued'] as $statusOption)
                                <option value="{{ $statusOption }}" {{ request('status') === $statusOption ? 'selected' : '' }}>
                                    {{ $statusOption }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-5 flex flex-wrap items-center gap-2 pt-1">
                            <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                                <i class="fa-solid fa-filter"></i> Apply Filters
                            </button>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold px-4 py-2 rounded-xl transition">
                                <i class="fa-solid fa-rotate-right"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Data Table -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 uppercase text-[11px] tracking-wider border-b border-slate-200">
                                    <th class="px-4 py-3 w-10"><input type="checkbox" onclick="toggleAllCheckboxes(this)" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500"></th>
                                    <th class="px-4 py-3 w-12">#</th>
                                    <th class="px-4 py-3 min-w-[220px]">Product</th>
                                    <th class="px-4 py-3">Category</th>
                                    <th class="px-4 py-3">Brand</th>
                                    <th class="px-4 py-3">Cost Price</th>
                                    <th class="px-4 py-3">Selling Price</th>
                                    <th class="px-4 py-3">Stock</th>
                                    <th class="px-4 py-3">Warranty</th>
                                    <th class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($products as $index => $product)
                                @php
                                $statusClasses = match($product->status) {
                                'In Stock' => 'bg-emerald-100 text-emerald-700',
                                'Low Stock' => 'bg-amber-100 text-amber-700',
                                'Out of Stock' => 'bg-rose-100 text-rose-700',
                                'Discontinued' => 'bg-slate-200 text-slate-600',
                                default => 'bg-slate-100 text-slate-600',
                                };

                                $rawSpecs = $product->specifications;
                                $specsArray = is_array($rawSpecs) ? $rawSpecs : (json_decode($rawSpecs ?? '', true) ?: null);
                                $specsText = $specsArray ? implode(' / ', array_filter([
                                $specsArray['cpu'] ?? null,
                                $specsArray['ram'] ?? null,
                                $specsArray['storage'] ?? null,
                                $specsArray['gpu'] ?? null,
                                ])) : ($rawSpecs ?? '');

                                $images = collect($product->images ?? [])->map(function ($img) {
                                return $img->image_url ?? (isset($img->image_path) ? asset('storage/' . $img->image_path) : null);
                                })->filter()->values();

                                $serials = collect($product->serials ?? []);

                                $productPayload = [
                                'id' => $product->id,
                                'name' => $product->name,
                                'sku' => $product->sku,
                                'barcode' => $product->barcode,
                                'category_id' => $product->category->id ?? '',
                                'brand_id' => $product->brand->id ?? '',
                                'supplier_id' => $product->supplier->id ?? '',
                                'category_name' => $product->category->name ?? 'Uncategorized',
                                'brand_name' => $product->brand->brand_name ?? 'No Brand',
                                'supplier_name' => $product->supplier->name ?? 'N/A',
                                'cost_price' => $product->cost_price,
                                'selling_price' => $product->selling_price,
                                'stock_quantity' => $product->stock_quantity,
                                'min_stock_alert' => $product->min_stock_alert,
                                'warranty_period_months' => $product->warranty_period_months,
                                'status' => $product->status,
                                'thumbnail' => $product->thumbnail ? asset('storage/' . $product->thumbnail) : null,
                                'specs' => $specsArray,
                                'specs_text' => $specsText,
                                'images' => $images,
                                'serials' => $serials->map(fn($s) => ['serial_number' => $s->serial_number, 'status' => $s->status])->values(),
                                ];
                                @endphp
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-4 py-3">
                                        <input type="checkbox" class="row-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="px-4 py-3 text-slate-500">{{ $products->firstItem() + $index }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                                @if ($product->thumbnail)
                                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                @else
                                                <i class="fa-solid fa-image text-slate-300 text-lg"></i>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <p class="font-semibold text-slate-800 truncate">{{ $product->name }}</p>
                                                <p class="text-xs text-slate-500 truncate">SKU: {{ $product->sku }} @if($product->barcode) &bull; {{ $product->barcode }} @endif</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">{{ $product->category->name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $product->brand->brand_name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-slate-600">${{ number_format($product->cost_price, 2) }}</td>
                                    <td class="px-4 py-3 font-semibold text-slate-800">${{ number_format($product->selling_price, 2) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClasses }}">
                                            <i class="fa-solid fa-circle text-[6px]"></i>
                                            {{ $product->status }} ({{ $product->stock_quantity }})
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">{{ $product->warranty_period_months }} mo</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" title="View Details"
                                                onclick='openViewModal(@json($productPayload))'
                                                class="w-8 h-8 rounded-lg bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center transition">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </button>
                                            <button type="button" title="Edit Product"
                                                onclick='openEditModal(@json($productPayload))'
                                                class="w-8 h-8 rounded-lg bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </button>
                                            <button type="button" title="Delete Product"
                                                onclick="openDeleteModal({{ $product->id }}, @js($product->name))"
                                                class="w-8 h-8 rounded-lg bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center transition">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="px-4 py-16 text-center text-slate-400">
                                        <i class="fa-solid fa-box-open text-4xl mb-3"></i>
                                        <p class="font-semibold text-slate-500">No products found</p>
                                        <p class="text-sm">Try adjusting your filters or add a new product.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($products->count() > 0)
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-4 sm:px-6 py-4 border-t border-slate-200">
                        <p class="text-sm text-slate-500">
                            Showing <span class="font-semibold text-slate-700">{{ $products->firstItem() }}</span>
                            to <span class="font-semibold text-slate-700">{{ $products->lastItem() }}</span>
                            of <span class="font-semibold text-slate-700">{{ $products->total() }}</span> products
                        </p>
                        <div class="text-sm">
                            {{ $products->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- ================= ADD PRODUCT MODAL ================= -->
    <div id="addProductModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" onclick="closeModal('addProductModal')"></div>
        <div class="relative bg-white w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 sticky top-0 bg-white z-10">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Add New Product</h2>
                        <p class="text-xs text-slate-500">Fill in the details below to add a new product to the catalog</p>
                    </div>
                    <button type="button" onclick="closeModal('addProductModal')" class="w-9 h-9 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-circle-info text-blue-500"></i> Basic Information</h3>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Product Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="e.g. ASUS ROG Strix G16"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">SKU <span class="text-rose-500">*</span></label>
                        <input type="text" name="sku" required placeholder="e.g. LAP-ASUS-001"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Barcode</label>
                        <input type="text" name="barcode" placeholder="e.g. 8901234567890"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Category <span class="text-rose-500">*</span></label>
                        <select name="category_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Brand <span class="text-rose-500">*</span></label>
                        <select name="brand_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Supplier</label>
                        <select name="supplier_id" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-tags text-blue-500"></i> Pricing & Stock</h3>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Cost Price ($) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" min="0" name="cost_price" required placeholder="0.00"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Selling Price ($) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" min="0" name="selling_price" required placeholder="0.00"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Stock Quantity <span class="text-rose-500">*</span></label>
                        <input type="number" min="0" name="stock_quantity" required placeholder="0"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Min Stock Alert</label>
                        <input type="number" min="0" name="min_stock_alert" placeholder="e.g. 5"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Warranty Period (Months)</label>
                        <input type="number" min="0" name="warranty_period_months" placeholder="e.g. 12"
                            class="w-full md:w-1/2 px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-microchip text-blue-500"></i> Specifications</h3>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">CPU / Processor</label>
                        <input type="text" name="specifications[cpu]" placeholder="e.g. Intel Core i7-13700H"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">RAM</label>
                        <input type="text" name="specifications[ram]" placeholder="e.g. 16GB DDR5"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Storage</label>
                        <input type="text" name="specifications[storage]" placeholder="e.g. 512GB NVMe SSD"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">GPU / Graphics</label>
                        <input type="text" name="specifications[gpu]" placeholder="e.g. RTX 4060 8GB"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-images text-blue-500"></i> Media & Serial Numbers</h3>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Main Thumbnail</label>
                        <input type="file" name="thumbnail" accept="image/*"
                            class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 border border-slate-200 rounded-xl bg-slate-50 cursor-pointer">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Additional Gallery Images</label>
                        <input type="file" name="gallery_images[]" accept="image/*" multiple
                            class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 border border-slate-200 rounded-xl bg-slate-50 cursor-pointer">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Serial Numbers <span class="text-slate-400 font-normal">(one per line, optional)</span></label>
                        <textarea name="serial_numbers" rows="4" placeholder="SN-0001&#10;SN-0002&#10;SN-0003"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition font-mono"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200 sticky bottom-0 bg-white">
                    <button type="button" onclick="closeModal('addProductModal')" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold shadow-md shadow-blue-600/30 transition">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= EDIT PRODUCT MODAL ================= -->
    <div id="editProductModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" onclick="closeModal('editProductModal')"></div>
        <div class="relative bg-white w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl">
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="product_id" id="edit_product_id">

                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 sticky top-0 bg-white z-10">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Edit Product</h2>
                        <p class="text-xs text-slate-500">Update the details of this product</p>
                    </div>
                    <button type="button" onclick="closeModal('editProductModal')" class="w-9 h-9 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Product Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="edit_name" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">SKU <span class="text-rose-500">*</span></label>
                        <input type="text" name="sku" id="edit_sku" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Barcode</label>
                        <input type="text" name="barcode" id="edit_barcode"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Category <span class="text-rose-500">*</span></label>
                        <select name="category_id" id="edit_category_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Brand <span class="text-rose-500">*</span></label>
                        <select name="brand_id" id="edit_brand_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Supplier</label>
                        <select name="supplier_id" id="edit_supplier_id" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Cost Price ($) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" min="0" name="cost_price" id="edit_cost_price" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Selling Price ($) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" min="0" name="selling_price" id="edit_selling_price" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Stock Quantity <span class="text-rose-500">*</span></label>
                        <input type="number" min="0" name="stock_quantity" id="edit_stock_quantity" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Min Stock Alert</label>
                        <input type="number" min="0" name="min_stock_alert" id="edit_min_stock_alert"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Warranty Period (Months)</label>
                        <input type="number" min="0" name="warranty_period_months" id="edit_warranty_period_months"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-microchip text-sky-500"></i> Specifications</h3>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">CPU / Processor</label>
                        <input type="text" name="specifications[cpu]" id="edit_spec_cpu"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">RAM</label>
                        <input type="text" name="specifications[ram]" id="edit_spec_ram"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Storage</label>
                        <input type="text" name="specifications[storage]" id="edit_spec_storage"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">GPU / Graphics</label>
                        <input type="text" name="specifications[gpu]" id="edit_spec_gpu"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm outline-none transition">
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2"><i class="fa-solid fa-images text-sky-500"></i> Media</h3>
                    </div>

                    <div class="md:col-span-2 flex items-center gap-4">
                        <div id="edit_current_thumbnail" class="w-16 h-16 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-image text-slate-300 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Replace Thumbnail</label>
                            <input type="file" name="thumbnail" accept="image/*"
                                class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-600 hover:file:bg-sky-100 border border-slate-200 rounded-xl bg-slate-50 cursor-pointer">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Add More Gallery Images</label>
                        <input type="file" name="gallery_images[]" accept="image/*" multiple
                            class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-600 hover:file:bg-sky-100 border border-slate-200 rounded-xl bg-slate-50 cursor-pointer">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200 sticky bottom-0 bg-white">
                    <button type="button" onclick="closeModal('editProductModal')" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold shadow-md shadow-sky-500/30 transition">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= VIEW PRODUCT DETAILS MODAL ================= -->
    <div id="viewProductModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" onclick="closeModal('viewProductModal')"></div>
        <div class="relative bg-white w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 sticky top-0 bg-white z-10">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Product Details</h2>
                    <p class="text-xs text-slate-500" id="view_sku_barcode">—</p>
                </div>
                <button type="button" onclick="closeModal('viewProductModal')" class="w-9 h-9 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Image Gallery -->
                <div>
                    <div class="w-full aspect-square rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center mb-3">
                        <img id="view_main_image" src="" alt="Product image" class="w-full h-full object-cover hidden">
                        <i id="view_main_image_placeholder" class="fa-solid fa-image text-slate-300 text-5xl"></i>
                    </div>
                    <div id="view_thumbnails" class="flex gap-2 overflow-x-auto pb-1"></div>
                </div>

                <!-- Details -->
                <div class="space-y-5">
                    <div>
                        <h3 id="view_name" class="text-xl font-extrabold text-slate-800">—</h3>
                        <span id="view_status_badge" class="inline-flex items-center gap-1.5 mt-2 px-2.5 py-1 rounded-full text-xs font-semibold">
                            <i class="fa-solid fa-circle text-[6px]"></i> <span id="view_status_text">—</span>
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-[11px] text-slate-500 font-semibold uppercase">Cost Price</p>
                            <p id="view_cost_price" class="text-lg font-bold text-slate-800">$0.00</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-[11px] text-slate-500 font-semibold uppercase">Selling Price</p>
                            <p id="view_selling_price" class="text-lg font-bold text-blue-600">$0.00</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-[11px] text-slate-500 font-semibold uppercase">Category</p>
                            <p id="view_category" class="text-sm font-semibold text-slate-700">—</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-[11px] text-slate-500 font-semibold uppercase">Brand</p>
                            <p id="view_brand" class="text-sm font-semibold text-slate-700">—</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-[11px] text-slate-500 font-semibold uppercase">Supplier</p>
                            <p id="view_supplier" class="text-sm font-semibold text-slate-700">—</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-[11px] text-slate-500 font-semibold uppercase">Warranty</p>
                            <p id="view_warranty" class="text-sm font-semibold text-slate-700 flex items-center gap-1.5">
                                <i class="fa-solid fa-shield-halved text-emerald-500"></i> <span>—</span>
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] text-slate-500 font-semibold uppercase mb-1.5">Full Specifications</p>
                        <div id="view_specs" class="bg-slate-50 rounded-xl p-3 text-sm text-slate-700 space-y-1">—</div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="px-6">
                <div class="flex border-b border-slate-200">
                    <button type="button" onclick="switchViewTab('overview')" id="tab_btn_overview"
                        class="view-tab-btn px-4 py-2.5 text-sm font-semibold border-b-2 border-blue-600 text-blue-600">
                        Overview
                    </button>
                    <button type="button" onclick="switchViewTab('serials')" id="tab_btn_serials"
                        class="view-tab-btn px-4 py-2.5 text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700">
                        Serial Numbers <span id="serial_count_badge" class="ml-1 text-xs bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded-full">0</span>
                    </button>
                </div>
            </div>

            <div class="p-6 pt-4">
                <div id="tab_content_overview" class="text-sm text-slate-500">
                    Use the tabs above to view individual serial numbers and their current status.
                </div>
                <div id="tab_content_serials" class="hidden">
                    <div class="overflow-x-auto rounded-xl border border-slate-200">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 uppercase text-[11px] tracking-wider">
                                    <th class="px-4 py-2.5">#</th>
                                    <th class="px-4 py-2.5">Serial Number</th>
                                    <th class="px-4 py-2.5">Status</th>
                                </tr>
                            </thead>
                            <tbody id="view_serials_table" class="divide-y divide-slate-100"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200">
                <button type="button" onclick="closeModal('viewProductModal')" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Close</button>
            </div>
        </div>
    </div>

    <!-- ================= DELETE PRODUCT MODAL ================= -->
    <div id="deleteProductModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" onclick="closeModal('deleteProductModal')"></div>
        <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-500 flex items-center justify-center text-2xl mx-auto mb-4">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h2 class="text-lg font-bold text-slate-800">Delete Product?</h2>
            <p class="text-sm text-slate-500 mt-2">
                Are you sure you want to delete <span id="delete_product_name" class="font-semibold text-slate-700">this product</span>?
                This action cannot be undone and will remove all associated images and serial numbers.
            </p>

            <form id="deleteProductForm" method="POST" class="mt-6 flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal('deleteProductModal')" class="flex-1 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold transition">Cancel</button>
                <button type="submit" class="flex-1 px-5 py-2.5 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-sm font-semibold shadow-md shadow-rose-500/30 transition">
                    <i class="fa-solid fa-trash mr-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <!-- ================= SCRIPTS ================= -->
    <script>
        // ---------- Generic modal open/close ----------
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                ['addProductModal', 'editProductModal', 'viewProductModal', 'deleteProductModal'].forEach(closeModal);
            }
        });

        // ---------- Mobile sidebar ----------
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // ---------- Checkbox helpers ----------
        function toggleAllCheckboxes(source) {
            document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = source.checked);
        }

        // ---------- Currency formatter ----------
        function formatMoney(value) {
            const num = parseFloat(value ?? 0) || 0;
            return '$' + num.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // ---------- Edit Product ----------
        function openEditModal(product) {
            document.getElementById('edit_product_id').value = product.id;
            document.getElementById('editProductForm').action = '/products/' + product.id;

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

            const specs = product.specs || {};
            document.getElementById('edit_spec_cpu').value = specs.cpu ?? '';
            document.getElementById('edit_spec_ram').value = specs.ram ?? '';
            document.getElementById('edit_spec_storage').value = specs.storage ?? '';
            document.getElementById('edit_spec_gpu').value = specs.gpu ?? '';

            const thumbBox = document.getElementById('edit_current_thumbnail');
            if (product.thumbnail) {
                thumbBox.innerHTML = '<img src="' + product.thumbnail + '" class="w-full h-full object-cover" alt="thumbnail">';
            } else {
                thumbBox.innerHTML = '<i class="fa-solid fa-image text-slate-300 text-xl"></i>';
            }

            openModal('editProductModal');
        }

        // ---------- View Product ----------
        const statusStyles = {
            'In Stock': 'bg-emerald-100 text-emerald-700',
            'Low Stock': 'bg-amber-100 text-amber-700',
            'Out of Stock': 'bg-rose-100 text-rose-700',
            'Discontinued': 'bg-slate-200 text-slate-600',
        };

        const serialStatusStyles = {
            'Available': 'bg-emerald-100 text-emerald-700',
            'Sold': 'bg-slate-200 text-slate-600',
            'Under Repair': 'bg-amber-100 text-amber-700',
        };

        function openViewModal(product) {
            document.getElementById('view_sku_barcode').textContent =
                'SKU: ' + (product.sku ?? '—') + (product.barcode ? '  •  Barcode: ' + product.barcode : '');
            document.getElementById('view_name').textContent = product.name ?? '—';
            document.getElementById('view_cost_price').textContent = formatMoney(product.cost_price);
            document.getElementById('view_selling_price').textContent = formatMoney(product.selling_price);
            document.getElementById('view_category').textContent = product.category_name ?? '—';
            document.getElementById('view_brand').textContent = product.brand_name ?? '—';
            document.getElementById('view_supplier').textContent = product.supplier_name ?? '—';
            document.getElementById('view_warranty').querySelector('span').textContent =
                (product.warranty_period_months ?? 0) + ' Month(s)';

            const badge = document.getElementById('view_status_badge');
            badge.className = 'inline-flex items-center gap-1.5 mt-2 px-2.5 py-1 rounded-full text-xs font-semibold ' +
                (statusStyles[product.status] || 'bg-slate-100 text-slate-600');
            document.getElementById('view_status_text').textContent =
                (product.status ?? '—') + ' (' + (product.stock_quantity ?? 0) + ' units)';

            const specsBox = document.getElementById('view_specs');
            const specs = product.specs;
            if (specs && (specs.cpu || specs.ram || specs.storage || specs.gpu)) {
                specsBox.innerHTML = `
                ${specs.cpu ? '<p><span class="font-semibold text-slate-500">CPU:</span> ' + specs.cpu + '</p>' : ''}
                ${specs.ram ? '<p><span class="font-semibold text-slate-500">RAM:</span> ' + specs.ram + '</p>' : ''}
                ${specs.storage ? '<p><span class="font-semibold text-slate-500">Storage:</span> ' + specs.storage + '</p>' : ''}
                ${specs.gpu ? '<p><span class="font-semibold text-slate-500">GPU:</span> ' + specs.gpu + '</p>' : ''}
            `;
            } else {
                specsBox.textContent = product.specs_text || 'No specifications provided.';
            }

            // Image gallery
            const images = (product.images && product.images.length) ? product.images : (product.thumbnail ? [product.thumbnail] : []);
            const mainImage = document.getElementById('view_main_image');
            const placeholder = document.getElementById('view_main_image_placeholder');
            const thumbsBox = document.getElementById('view_thumbnails');
            thumbsBox.innerHTML = '';

            if (images.length > 0) {
                mainImage.src = images[0];
                mainImage.classList.remove('hidden');
                placeholder.classList.add('hidden');

                images.forEach((src, i) => {
                    const thumb = document.createElement('button');
                    thumb.type = 'button';
                    thumb.className = 'w-16 h-16 rounded-lg overflow-hidden border-2 shrink-0 ' + (i === 0 ? 'border-blue-600' : 'border-transparent');
                    thumb.innerHTML = '<img src="' + src + '" class="w-full h-full object-cover" alt="thumb-' + i + '">';
                    thumb.onclick = () => {
                        mainImage.src = src;
                        thumbsBox.querySelectorAll('button').forEach(b => b.classList.remove('border-blue-600'));
                        thumbsBox.querySelectorAll('button').forEach(b => b.classList.add('border-transparent'));
                        thumb.classList.remove('border-transparent');
                        thumb.classList.add('border-blue-600');
                    };
                    thumbsBox.appendChild(thumb);
                });
            } else {
                mainImage.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }

            // Serial numbers
            const serials = product.serials || [];
            document.getElementById('serial_count_badge').textContent = serials.length;
            const serialsTable = document.getElementById('view_serials_table');
            if (serials.length > 0) {
                serialsTable.innerHTML = serials.map((s, i) => `
                <tr>
                    <td class="px-4 py-2.5 text-slate-500">${i + 1}</td>
                    <td class="px-4 py-2.5 font-mono text-slate-700">${s.serial_number}</td>
                    <td class="px-4 py-2.5">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold ${serialStatusStyles[s.status] || 'bg-slate-100 text-slate-600'}">
                            ${s.status}
                        </span>
                    </td>
                </tr>
            `).join('');
            } else {
                serialsTable.innerHTML = '<tr><td colspan="3" class="px-4 py-6 text-center text-slate-400">No serial numbers recorded for this product.</td></tr>';
            }

            switchViewTab('overview');
            openModal('viewProductModal');
        }

        function switchViewTab(tab) {
            const tabs = ['overview', 'serials'];
            tabs.forEach(t => {
                const btn = document.getElementById('tab_btn_' + t);
                const content = document.getElementById('tab_content_' + t);
                if (t === tab) {
                    btn.classList.add('border-blue-600', 'text-blue-600');
                    btn.classList.remove('border-transparent', 'text-slate-500');
                    content.classList.remove('hidden');
                } else {
                    btn.classList.remove('border-blue-600', 'text-blue-600');
                    btn.classList.add('border-transparent', 'text-slate-500');
                    content.classList.add('hidden');
                }
            });
        }

        // ---------- Delete Product ----------
        function openDeleteModal(id, name) {
            document.getElementById('delete_product_name').textContent = name;
            document.getElementById('deleteProductForm').action = '/products/' + id;
            openModal('deleteProductModal');
        }
    </script>

</body>

</html>