<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS - Sales Management | TECHZONE Computer Shop</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@600;700&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JsBarcode for 80mm Thermal Receipt Barcode -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

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

        /* 80mm Thermal Receipt Print Specific Styles */
        @media print {
            body * { visibility: hidden !important; }
            #thermalReceiptModal, #thermalReceiptModal * { visibility: visible !important; }
            #thermalReceiptModal {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 80mm !important;
                margin: 0 auto !important;
                padding: 4mm !important;
                background: #ffffff !important;
                display: block !important;
                box-shadow: none !important;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-[#F4F6F9] text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

<div class="flex min-h-screen">

    {{-- ========================================================================= --}}
    {{-- 1. TECHZONE SIDEBAR NAVIGATION (Feature #9 Highlighted)                  --}}
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

            <!-- Active: Sales Management (POS) -->
            <a href="{{ route('pos.sales') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30 transition">
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

            <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-chart-pie w-4 text-center"></i> Report Management
            </a>

            <a href="{{ route('notifications') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <span class="flex items-center gap-3">
                    <i class="fa-solid fa-bell w-4 text-center"></i> Notification
                </span>
                <span class="w-5 h-5 rounded-full bg-rose-500 text-white text-[10px] font-bold flex items-center justify-center">1</span>
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
    {{-- 2. MAIN POS WORKSPACE                                                     --}}
    {{-- ========================================================================= --}}
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">

        <!-- Top App Bar matching Mockup -->
        <header class="bg-white border-b border-slate-200/90 px-6 py-2.5 flex items-center justify-between sticky top-0 z-20 shadow-sm no-print">
            <div class="flex items-center gap-4">
                <button class="lg:hidden text-slate-500 hover:text-slate-700">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="relative w-72 md:w-96">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" id="topSearchInput" placeholder="Search products by name, SKU, barcode..."
                           oninput="filterCatalog(this.value)"
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

            {{-- 2.1 POS Action Header matching Mockup --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shadow-md shadow-blue-500/20">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 leading-tight">POS - New Sale</h2>
                        <p class="text-xs text-slate-400 font-medium">Fast &bull; Easy &bull; Professional</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 text-xs">
                    <!-- Date & Time -->
                    <div class="flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-600 font-medium">
                        <i class="fa-regular fa-calendar text-blue-600"></i>
                        <span id="currentLiveClock">{{ date('Y-m-d h:i A') }}</span>
                    </div>

                    <!-- Current Sale Number Preview -->
                    <div class="flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium">
                        <span class="text-slate-400">Sale #:</span>
                        <span class="font-bold text-blue-600 font-mono" id="currentSaleNumberDisplay">{{ $suggestedSaleNumber }}</span>
                    </div>

                    <!-- New Sale Button -->
                    <button type="button" onclick="startNewSale()" class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition">
                        <i class="fa-solid fa-plus text-xs"></i> New Sale
                    </button>

                    <!-- Hold Order Button -->
                    <button type="button" onclick="holdSale()" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-semibold rounded-xl shadow-sm transition">
                        <i class="fa-regular fa-bookmark text-xs"></i> Hold
                    </button>
                </div>
            </div>

            {{-- 2.2 TWO-COLUMN POS INTERACTION AREA --}}
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-5">

                {{-- LEFT COLUMN: PRODUCT CATALOG GRID (7 cols on xl) --}}
                <div class="xl:col-span-7 space-y-4">

                    <!-- Search Bar & Barcode Scan -->
                    <div class="flex items-center gap-3">
                        <div class="relative flex-1">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" id="catalogSearch" placeholder="Search product name, SKU, barcode..."
                                   oninput="filterCatalog(this.value)"
                                   class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-white border border-slate-200 focus:border-blue-500 focus:outline-none text-xs transition text-slate-700 shadow-sm">
                        </div>
                        <button type="button" onclick="triggerBarcodeScanPrompt()" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-sm transition">
                            <i class="fa-solid fa-barcode text-blue-600"></i> Scan
                        </button>
                    </div>

                    <!-- Category Filter Tabs -->
                    <div class="flex items-center gap-2 overflow-x-auto scrollbar-thin pb-1 text-xs font-semibold">
                        <button type="button" onclick="selectCategory('all', this)" class="category-pill-btn px-4 py-2 rounded-xl bg-blue-600 text-white shadow-sm transition">
                            All
                        </button>
                        <button type="button" onclick="selectCategory('Laptops', this)" class="category-pill-btn px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                            Laptops
                        </button>
                        <button type="button" onclick="selectCategory('Monitors', this)" class="category-pill-btn px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                            Monitors
                        </button>
                        <button type="button" onclick="selectCategory('Accessories', this)" class="category-pill-btn px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                            Accessories
                        </button>
                        <button type="button" onclick="selectCategory('Components', this)" class="category-pill-btn px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                            Components
                        </button>
                        <button type="button" onclick="selectCategory('Printers', this)" class="category-pill-btn px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                            Printers
                        </button>
                        <button type="button" onclick="selectCategory('Others', this)" class="category-pill-btn px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                            Others
                        </button>
                    </div>

                    <!-- Products Grid -->
                    <div id="productGridContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3.5">
                        @forelse($products as $product)
                            <div class="product-card bg-white rounded-2xl border border-slate-200 p-3 shadow-sm hover:shadow-md hover:border-blue-400 transition cursor-pointer flex flex-col justify-between group"
                                 onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ $product->sku }}', {{ $product->selling_price }}, {{ $product->stock_quantity }}, '{{ $product->thumbnail ?? 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=200&h=200&q=80' }}')"
                                 data-name="{{ strtolower($product->name) }}"
                                 data-sku="{{ strtolower($product->sku) }}"
                                 data-barcode="{{ strtolower($product->barcode ?? '') }}"
                                 data-category="{{ $product->category->name ?? 'Others' }}">
                                
                                <div class="relative w-full aspect-square rounded-xl overflow-hidden bg-slate-50 mb-2.5 flex items-center justify-center">
                                    <img src="{{ $product->thumbnail ?: 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=200&h=200&q=80' }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @if($product->stock_quantity <= 0)
                                        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[1px] flex items-center justify-center text-white text-[11px] font-bold">
                                            Out of Stock
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <h4 class="text-xs font-bold text-slate-800 line-clamp-1 group-hover:text-blue-600 transition" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </h4>
                                    <p class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $product->sku }}</p>
                                </div>

                                <div class="mt-2.5 pt-2 border-t border-slate-100 flex items-center justify-between">
                                    <span class="text-xs font-extrabold text-blue-600 font-mono">
                                        ${{ number_format($product->selling_price, 2) }}
                                    </span>
                                    @if($product->stock_quantity <= ($product->min_stock_alert ?? 3) && $product->stock_quantity > 0)
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                            Low Stock
                                        </span>
                                    @elseif($product->stock_quantity > 0)
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                            In Stock
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                            0 Left
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-slate-400 text-xs">
                                <i class="fa-solid fa-box-open text-3xl mb-2 text-slate-300"></i>
                                <p>មិនមានទំនិញក្នុងស្តុកឡើយ (No products found)</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- RIGHT COLUMN: CURRENT CART & CHECKOUT (5 cols on xl) --}}
                <div class="xl:col-span-5 space-y-4">

                    <!-- Cart Header -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-cart-shopping text-blue-600"></i>
                                Current Cart (<span id="cartTotalItemsCount">0</span> items)
                            </h3>
                            <button type="button" onclick="clearCart()" class="text-xs text-rose-500 hover:text-rose-700 font-semibold flex items-center gap-1.5 transition">
                                <i class="fa-regular fa-trash-can"></i> Clear
                            </button>
                        </div>

                        <!-- Cart Items Scrollable List -->
                        <div id="cartItemsList" class="divide-y divide-slate-100 max-h-72 overflow-y-auto scrollbar-thin py-2">
                            <!-- Populated dynamically via JS -->
                            <div id="cartEmptyState" class="py-10 text-center text-slate-400 text-xs">
                                <i class="fa-solid fa-basket-shopping text-3xl mb-2 text-slate-200"></i>
                                <p>កន្ត្រកទំនិញនៅទំនេរ (Cart is empty)</p>
                                <p class="text-[11px] text-slate-300 mt-1">សូមចុចលើទំនិញខាងឆ្វេងដើម្បីបន្ថែមចូលកន្ត្រក</p>
                            </div>
                        </div>

                        <!-- Customer Selection Block matching Mockup -->
                        <div class="pt-3 border-t border-slate-100 space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="fa-solid fa-user text-blue-600"></i> Customer
                                </label>
                                <button type="button" onclick="openNewCustomerModal()" class="text-[11px] text-blue-600 hover:underline font-semibold flex items-center gap-1">
                                    <i class="fa-solid fa-plus"></i> New
                                </button>
                            </div>

                            <!-- Customer Select Dropdown -->
                            <select id="customerSelect" onchange="onCustomerChange(this.value)"
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:bg-white focus:border-blue-500 focus:outline-none transition">
                                <option value="">Walk-in Customer (ទូទៅ)</option>
                                @foreach($customers as $c)
                                    <option value="{{ $c->id }}" data-name="{{ $c->name }}" data-points="{{ $c->points }}" data-phone="{{ $c->phone }}" data-type="{{ $c->customer_type }}">
                                        {{ $c->name }} ({{ $c->phone }}) &bull; {{ $c->points }} Pts
                                    </option>
                                @endforeach
                            </select>

                            <!-- Customer Info Card -->
                            <div id="selectedCustomerCard" class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-user-check"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800" id="custNameDisplay">Walk-in Customer</p>
                                        <p class="text-[10px] text-slate-400" id="custTypeDisplay">Standard Retail</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                                        <i class="fa-solid fa-star text-[9px]"></i> <span id="custPointsDisplay">0</span> Points
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method Selector matching Mockup buttons -->
                        <div class="pt-3 border-t border-slate-100 space-y-2">
                            <label class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                <i class="fa-solid fa-wallet text-blue-600"></i> Payment Method
                            </label>
                            <div class="grid grid-cols-3 gap-2 text-xs font-semibold">
                                <button type="button" onclick="selectPaymentMethod('Cash', this)" class="payment-method-btn flex items-center justify-center gap-2 py-2 px-3 rounded-xl border border-blue-500 bg-blue-50 text-blue-700 shadow-sm transition">
                                    <i class="fa-solid fa-money-bill-wave"></i> Cash
                                </button>
                                <button type="button" onclick="selectPaymentMethod('Card', this)" class="payment-method-btn flex items-center justify-center gap-2 py-2 px-3 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition">
                                    <i class="fa-regular fa-credit-card"></i> Card
                                </button>
                                <button type="button" onclick="selectPaymentMethod('ABA', this)" class="payment-method-btn flex items-center justify-center gap-2 py-2 px-3 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition">
                                    <span class="font-bold tracking-tight text-[11px] text-sky-700">ABA</span> Bank
                                </button>
                                <button type="button" onclick="selectPaymentMethod('Wing', this)" class="payment-method-btn flex items-center justify-center gap-2 py-2 px-3 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition">
                                    <span class="font-bold text-[11px] text-lime-600">Wing</span> Bank
                                </button>
                                <button type="button" onclick="selectPaymentMethod('QR', this)" class="payment-method-btn flex items-center justify-center gap-2 py-2 px-3 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition">
                                    <i class="fa-solid fa-qrcode"></i> QR
                                </button>
                                <button type="button" onclick="selectPaymentMethod('Other', this)" class="payment-method-btn flex items-center justify-center gap-2 py-2 px-3 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition">
                                    <i class="fa-solid fa-ellipsis"></i> Other
                                </button>
                            </div>
                            <input type="hidden" id="selectedPaymentMethod" value="Cash">
                        </div>

                        <!-- Calculation Summary matching Mockup -->
                        <div class="pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-600">
                            <div class="flex justify-between items-center">
                                <span>Subtotal</span>
                                <span class="font-bold text-slate-800 font-mono" id="subtotalDisplay">$0.00</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="flex items-center gap-1.5">
                                    Discount
                                    <div class="inline-flex items-center border border-slate-200 rounded-lg overflow-hidden bg-slate-50 px-1 py-0.5">
                                        <input type="number" id="discountPercentInput" min="0" max="100" value="0" oninput="calculateTotals()"
                                               class="w-10 text-center bg-transparent text-xs font-bold focus:outline-none text-slate-700">
                                        <span class="text-[10px] text-slate-400">%</span>
                                    </div>
                                </span>
                                <span class="font-bold text-rose-500 font-mono" id="discountAmountDisplay">- $0.00</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span>Tax (10%)</span>
                                <span class="font-bold text-slate-800 font-mono" id="taxAmountDisplay">$0.00</span>
                            </div>

                            <div class="flex justify-between items-center pt-2 border-t border-slate-200 text-sm">
                                <span class="font-bold text-slate-900">Total Amount</span>
                                <span class="text-lg font-extrabold text-blue-600 font-mono" id="totalAmountDisplay">$0.00</span>
                            </div>
                        </div>

                        <!-- Paid Amount input for cash calculation -->
                        <div class="pt-2 text-xs flex items-center justify-between gap-3">
                            <span class="text-slate-500 font-medium">Customer Paid ($):</span>
                            <input type="number" id="customerPaidInput" step="0.01" min="0" placeholder="Optional"
                                   oninput="calculateChange()"
                                   class="w-28 px-2 py-1 text-right border border-slate-200 rounded-lg text-xs font-mono font-bold focus:border-blue-500 focus:outline-none">
                        </div>
                        <div class="text-[11px] text-slate-500 flex justify-between items-center pt-1" id="changeAmountRow">
                            <span>Change (ប្រាក់អាប់):</span>
                            <span class="font-mono font-bold text-emerald-600" id="changeAmountDisplay">$0.00</span>
                        </div>

                        <!-- Main Action Buttons -->
                        <div class="pt-4 flex items-center gap-3">
                            <button type="button" onclick="holdSale()" class="w-1/3 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 font-bold text-xs text-slate-700 shadow-sm transition">
                                Save
                            </button>
                            <button type="button" id="btnProcessPayment" onclick="processCheckout()" class="w-2/3 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 font-bold text-xs text-white shadow-md shadow-blue-500/20 flex items-center justify-center gap-2 transition">
                                <i class="fa-solid fa-credit-card"></i> Process Payment
                            </button>
                        </div>

                        <!-- Quick Actions Grid matching Mockup -->
                        <div class="pt-3 border-t border-slate-100 mt-4">
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Quick Actions</p>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <a href="{{ route('invoices') }}" class="flex items-center gap-2 p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium transition">
                                    <i class="fa-regular fa-file-lines text-blue-600"></i> Create Invoice
                                </a>
                                <button type="button" onclick="openReceiptModalForLatest()" class="flex items-center gap-2 p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium transition text-left">
                                    <i class="fa-solid fa-print text-emerald-600"></i> Print Receipt
                                </button>
                                <button type="button" onclick="Swal.fire('Return / Exchange', 'មុខងារប្តូរទំនិញត្រូវបានបើកដំណើរការ', 'info')" class="flex items-center gap-2 p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium transition text-left">
                                    <i class="fa-solid fa-rotate-left text-amber-600"></i> Return / Exchange
                                </button>
                                <button type="button" onclick="quickApplyLoyaltyDiscount()" class="flex items-center gap-2 p-2 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium transition text-left">
                                    <i class="fa-solid fa-tag text-purple-600"></i> Apply Discount
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- 2.3 RECENT SALES ORDER LIST TABLE (shown at bottom of Mockup 2) --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">Sales Order List</h3>
                            <p class="text-xs text-slate-400">Recent completed transactions at POS counter</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="startNewSale()" class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition">
                            <i class="fa-solid fa-plus text-[10px]"></i> New Sale
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto scrollbar-thin">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-semibold border-y border-slate-200">
                            <tr>
                                <th class="py-2.5 px-3">#</th>
                                <th class="py-2.5 px-3">Sale No.</th>
                                <th class="py-2.5 px-3">Customer</th>
                                <th class="py-2.5 px-3">Total Amount</th>
                                <th class="py-2.5 px-3">Status</th>
                                <th class="py-2.5 px-3">Date</th>
                                <th class="py-2.5 px-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($recentSales as $index => $sale)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-2.5 px-3 font-mono text-slate-400">{{ $index + 1 }}</td>
                                    <td class="py-2.5 px-3 font-mono font-bold text-blue-600">{{ $sale->sale_number }}</td>
                                    <td class="py-2.5 px-3 text-slate-800 font-semibold">{{ $sale->customer->name ?? 'Walk-in' }}</td>
                                    <td class="py-2.5 px-3 font-mono font-bold text-slate-900">${{ number_format($sale->total_amount, 2) }}</td>
                                    <td class="py-2.5 px-3">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                            {{ $sale->status }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-3 font-mono text-slate-500">{{ $sale->sale_date->format('Y-m-d H:i') }}</td>
                                    <td class="py-2.5 px-3 text-right space-x-2">
                                        <button type="button" onclick="printReceiptForSale({{ $sale->id }})" title="Print 80mm Receipt" class="p-1.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition">
                                            <i class="fa-solid fa-print"></i>
                                        </button>
                                        <button type="button" onclick="viewSaleDetailsModal({{ $sale->id }})" title="View Details" class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-center text-slate-400">មិនទាន់មានប្រតិបត្តិការលក់នៅឡើយទេ</td>
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
{{-- 3. THERMAL RECEIPT PRINT MODAL (80mm Layout matching Mockup)             --}}
{{-- ========================================================================= --}}
<div id="thermalReceiptModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 overflow-y-auto no-print">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-5 relative border border-slate-200">
        
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-3">
            <h4 class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="fa-solid fa-receipt text-blue-600"></i> Thermal Receipt Preview (80mm)
            </h4>
            <button onclick="closeReceiptModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- The actual 80mm Printable slip container -->
        <div id="thermalReceiptModal" class="receipt-font text-[11px] leading-tight text-black bg-white p-3 border border-dashed border-slate-300 rounded-lg">
            
            <!-- Store Header -->
            <div class="text-center pb-2 border-b border-black">
                <div class="flex justify-center items-center gap-1.5 mb-1">
                    <i class="fa-solid fa-cube text-base"></i>
                    <h2 class="text-sm font-bold tracking-widest uppercase">TECHZONE</h2>
                </div>
                <p class="text-[9.5px]">Computer Shop Management System</p>
                <p class="text-[9px]">Phnom Penh, Cambodia &bull; Tel: +855 12 345 678</p>
                <h3 class="text-xs font-bold mt-1.5 uppercase">SALES RECEIPT</h3>
            </div>

            <!-- Meta info -->
            <div class="py-2 border-b border-black space-y-0.5 text-[10px]">
                <div class="flex justify-between">
                    <span>Sale No:</span>
                    <span class="font-bold" id="rcptSaleNo">POS-2025-0098</span>
                </div>
                <div class="flex justify-between">
                    <span>Invoice No:</span>
                    <span class="font-bold" id="rcptInvoiceNo">INV-2025-0098</span>
                </div>
                <div class="flex justify-between">
                    <span>Date:</span>
                    <span id="rcptDate">2025-09-10 10:32 AM</span>
                </div>
                <div class="flex justify-between">
                    <span>Cashier:</span>
                    <span id="rcptCashier">Sok Dara</span>
                </div>
                <div class="flex justify-between">
                    <span>Customer:</span>
                    <span class="font-bold" id="rcptCustomer">Walk-in Customer</span>
                </div>
                <div class="flex justify-between">
                    <span>Payment:</span>
                    <span class="font-bold uppercase" id="rcptPaymentMethod">Cash</span>
                </div>
            </div>

            <!-- Items Table -->
            <table class="w-full my-2 text-[10px]">
                <thead>
                    <tr class="border-b border-black text-left">
                        <th class="py-1">No</th>
                        <th class="py-1">Product</th>
                        <th class="py-1 text-center">Qty</th>
                        <th class="py-1 text-right">Price</th>
                        <th class="py-1 text-right">Total</th>
                    </tr>
                </thead>
                <tbody id="rcptItemsBody" class="divide-y divide-dotted divide-slate-300">
                    <!-- Populated via JS -->
                </tbody>
            </table>

            <!-- Calculation Totals -->
            <div class="pt-2 border-t border-black space-y-1 text-[10px]">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span id="rcptSubtotal">$0.00</span>
                </div>
                <div class="flex justify-between" id="rcptDiscountRow">
                    <span>Discount:</span>
                    <span id="rcptDiscount">- $0.00</span>
                </div>
                <div class="flex justify-between">
                    <span>Tax (10%):</span>
                    <span id="rcptTax">$0.00</span>
                </div>
                <div class="flex justify-between text-xs font-bold pt-1 border-t border-black">
                    <span>Total:</span>
                    <span id="rcptTotal">$0.00</span>
                </div>
                <div class="flex justify-between pt-1">
                    <span>Paid Amount:</span>
                    <span id="rcptPaid">$0.00</span>
                </div>
                <div class="flex justify-between">
                    <span>Change:</span>
                    <span id="rcptChange">$0.00</span>
                </div>
            </div>

            <!-- Barcode & Footer -->
            <div class="text-center pt-3 mt-2 border-t border-dotted border-slate-400">
                <p class="text-[9.5px] font-bold">Thank you for shopping with TECHZONE!</p>
                <p class="text-[8.5px] text-slate-600">Goods sold are non-refundable. Warranty requires this slip.</p>
                
                <div class="flex justify-center mt-2">
                    <svg id="receiptBarcodeSvg" class="max-w-full h-10"></svg>
                </div>
                <p class="text-[8px] font-mono tracking-wider text-slate-500 mt-0.5" id="rcptBarcodeText">POS-2025-0098</p>
            </div>

        </div>

        <!-- Print Action Buttons in Modal -->
        <div class="mt-4 flex items-center justify-end gap-2">
            <button type="button" onclick="closeReceiptModal()" class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                Close
            </button>
            <button type="button" onclick="window.print()" class="px-4 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-xs font-semibold text-white shadow-sm flex items-center gap-1.5 transition">
                <i class="fa-solid fa-print"></i> Print Now (80mm)
            </button>
        </div>

    </div>
</div>

{{-- ========================================================================= --}}
{{-- 4. POS JAVASCRIPT STATE ENGINE                                            --}}
{{-- ========================================================================= --}}
<script>
    // Global Cart State
    let cart = [];
    let selectedCustomerId = null;
    let selectedPayment = 'Cash';
    let currentSaleNumber = '{{ $suggestedSaleNumber }}';
    let latestCompletedSaleId = {{ $recentSales->first()->id ?? 'null' }};

    // Initialize Default Cart Items matching Mockup 2 for instant ready-to-sell demonstration
    document.addEventListener('DOMContentLoaded', () => {
        // Pre-add items if cart is empty to match Mockup 2: ASUS TUF Laptop, Logitech Mouse, Razer Keyboard, Samsung SSD
        const sampleProducts = @json($products);
        if (sampleProducts && sampleProducts.length >= 4) {
            // Add initial 4 items to match mockup screenshot
            addToCart(sampleProducts[0].id, sampleProducts[0].name, sampleProducts[0].sku, sampleProducts[0].selling_price, sampleProducts[0].stock_quantity, sampleProducts[0].thumbnail, 1);
            addToCart(sampleProducts[2].id, sampleProducts[2].name, sampleProducts[2].sku, sampleProducts[2].selling_price, sampleProducts[2].stock_quantity, sampleProducts[2].thumbnail, 1);
            addToCart(sampleProducts[3].id, sampleProducts[3].name, sampleProducts[3].sku, sampleProducts[3].selling_price, sampleProducts[3].stock_quantity, sampleProducts[3].thumbnail, 1);
            addToCart(sampleProducts[4].id, sampleProducts[4].name, sampleProducts[4].sku, sampleProducts[4].selling_price, sampleProducts[4].stock_quantity, sampleProducts[4].thumbnail, 1);
        }
    });

    /**
     * Add product to cart or increment quantity
     */
    function addToCart(productId, name, sku, price, maxStock, thumbnail, quantity = 1) {
        if (maxStock <= 0) {
            Swal.fire('អស់ពីស្តុក (Out of Stock)', `ទំនិញ '${name}' អស់ពីស្តុកហើយ`, 'warning');
            return;
        }

        const existingItemIndex = cart.findIndex(item => item.product_id === productId);

        if (existingItemIndex > -1) {
            if (cart[existingItemIndex].quantity + quantity > maxStock) {
                Swal.fire('ស្តុកមិនគ្រប់គ្រាន់', `ទំនិញ '${name}' នៅសល់តែ ${maxStock} ប៉ុណ្ណោះ`, 'warning');
                return;
            }
            cart[existingItemIndex].quantity += quantity;
        } else {
            cart.push({
                product_id: productId,
                name: name,
                sku: sku,
                price: parseFloat(price),
                max_stock: maxStock,
                thumbnail: thumbnail,
                quantity: quantity
            });
        }

        renderCart();
    }

    /**
     * Update item quantity stepper [- 1 +]
     */
    function updateQuantity(productId, delta) {
        const item = cart.find(i => i.product_id === productId);
        if (!item) return;

        const newQty = item.quantity + delta;

        if (newQty <= 0) {
            removeFromCart(productId);
            return;
        }

        if (newQty > item.max_stock) {
            Swal.fire('ស្តុកមិនគ្រប់គ្រាន់', `ទំនិញនៅសល់តែ ${item.max_stock} ក្នុងស្តុកប៉ុណ្ណោះ`, 'warning');
            return;
        }

        item.quantity = newQty;
        renderCart();
    }

    /**
     * Remove item from cart
     */
    function removeFromCart(productId) {
        cart = cart.filter(i => i.product_id !== productId);
        renderCart();
    }

    /**
     * Clear all items in cart
     */
    function clearCart() {
        if (cart.length === 0) return;
        cart = [];
        renderCart();
    }

    /**
     * Render the Cart UI
     */
    function renderCart() {
        const listContainer = document.getElementById('cartItemsList');
        const emptyState = document.getElementById('cartEmptyState');
        const totalItemsCount = document.getElementById('cartTotalItemsCount');

        let totalQty = 0;
        cart.forEach(item => totalQty += item.quantity);
        totalItemsCount.textContent = totalQty;

        if (cart.length === 0) {
            listContainer.innerHTML = `
                <div class="py-10 text-center text-slate-400 text-xs">
                    <i class="fa-solid fa-basket-shopping text-3xl mb-2 text-slate-200"></i>
                    <p>កន្ត្រកទំនិញនៅទំនេរ (Cart is empty)</p>
                    <p class="text-[11px] text-slate-300 mt-1">សូមចុចលើទំនិញខាងឆ្វេងដើម្បីបន្ថែមចូលកន្ត្រក</p>
                </div>
            `;
            calculateTotals();
            return;
        }

        let html = '';
        cart.forEach((item, index) => {
            const itemSubtotal = (item.price * item.quantity).toFixed(2);
            html += `
                <div class="py-2.5 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 flex-1 min-w-0">
                        <span class="text-[11px] font-mono text-slate-400 w-4">${index + 1}</span>
                        <img src="${item.thumbnail}" alt="${item.name}" class="w-9 h-9 rounded-lg object-cover bg-slate-50 border border-slate-100 flex-shrink-0">
                        <div class="min-w-0 flex-1">
                            <h5 class="text-xs font-bold text-slate-800 truncate" title="${item.name}">${item.name}</h5>
                            <p class="text-[10px] text-slate-400 font-mono">${item.sku}</p>
                        </div>
                    </div>

                    <!-- Quantity Stepper matching Mockup [- 1 +] -->
                    <div class="flex items-center border border-slate-200 rounded-lg bg-slate-50 overflow-hidden">
                        <button type="button" onclick="updateQuantity(${item.product_id}, -1)" class="w-6 h-6 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition text-xs font-bold">
                            &minus;
                        </button>
                        <span class="w-7 text-center font-bold font-mono text-xs text-slate-800">${item.quantity}</span>
                        <button type="button" onclick="updateQuantity(${item.product_id}, 1)" class="w-6 h-6 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition text-xs font-bold">
                            &plus;
                        </button>
                    </div>

                    <!-- Prices -->
                    <div class="text-right w-16">
                        <div class="text-xs font-extrabold text-slate-800 font-mono">$${itemSubtotal}</div>
                        <div class="text-[9.5px] text-slate-400 font-mono">$${item.price.toFixed(2)}/ea</div>
                    </div>

                    <!-- Trash button -->
                    <button type="button" onclick="removeFromCart(${item.product_id})" class="text-slate-400 hover:text-rose-500 transition p-1">
                        <i class="fa-regular fa-trash-can text-xs"></i>
                    </button>
                </div>
            `;
        });

        listContainer.innerHTML = html;
        calculateTotals();
    }

    /**
     * Calculate Subtotal, Discount %, Tax 10%, and Grand Total
     */
    function calculateTotals() {
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += item.price * item.quantity;
        });

        const discountInput = document.getElementById('discountPercentInput');
        let discountPercent = parseFloat(discountInput.value) || 0;
        if (discountPercent < 0) discountPercent = 0;
        if (discountPercent > 100) discountPercent = 100;

        const discountAmount = (subtotal * discountPercent) / 100;
        const taxableAmount = Math.max(0, subtotal - discountAmount);
        const taxAmount = (taxableAmount * 0.10); // 10% Tax rate
        const totalAmount = taxableAmount + taxAmount;

        document.getElementById('subtotalDisplay').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('discountAmountDisplay').textContent = `- $${discountAmount.toFixed(2)}`;
        document.getElementById('taxAmountDisplay').textContent = `$${taxAmount.toFixed(2)}`;
        document.getElementById('totalAmountDisplay').textContent = `$${totalAmount.toFixed(2)}`;

        calculateChange();
    }

    /**
     * Calculate change return when customer gives cash
     */
    function calculateChange() {
        const totalText = document.getElementById('totalAmountDisplay').textContent.replace('$', '').trim();
        const totalAmount = parseFloat(totalText) || 0;
        const paidInput = document.getElementById('customerPaidInput');
        const paidVal = parseFloat(paidInput.value);

        if (!isNaN(paidVal) && paidVal >= totalAmount) {
            const change = paidVal - totalAmount;
            document.getElementById('changeAmountDisplay').textContent = `$${change.toFixed(2)}`;
        } else {
            document.getElementById('changeAmountDisplay').textContent = `$0.00`;
        }
    }

    /**
     * Filter Products in catalog by text or category
     */
    function filterCatalog(searchQuery) {
        const query = (searchQuery || '').toLowerCase();
        const cards = document.querySelectorAll('.product-card');

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const sku = card.getAttribute('data-sku');
            const barcode = card.getAttribute('data-barcode');

            if (name.includes(query) || sku.includes(query) || barcode.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    /**
     * Category tab selection
     */
    function selectCategory(categoryName, btnElement) {
        document.querySelectorAll('.category-pill-btn').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-600');
        });

        btnElement.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-600');
        btnElement.classList.add('bg-blue-600', 'text-white');

        const cards = document.querySelectorAll('.product-card');
        cards.forEach(card => {
            const cat = card.getAttribute('data-category');
            if (categoryName === 'all' || cat.toLowerCase().includes(categoryName.toLowerCase())) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    /**
     * Select Payment Method
     */
    function selectPaymentMethod(method, btnElement) {
        selectedPayment = method;
        document.getElementById('selectedPaymentMethod').value = method;

        document.querySelectorAll('.payment-method-btn').forEach(btn => {
            btn.classList.remove('border-blue-500', 'bg-blue-50', 'text-blue-700');
            btn.classList.add('border-slate-200', 'bg-white', 'text-slate-600');
        });

        btnElement.classList.remove('border-slate-200', 'bg-white', 'text-slate-600');
        btnElement.classList.add('border-blue-500', 'bg-blue-50', 'text-blue-700');
    }

    /**
     * Customer Selection Event
     */
    function onCustomerChange(customerId) {
        selectedCustomerId = customerId ? parseInt(customerId) : null;
        const select = document.getElementById('customerSelect');
        const selectedOption = select.options[select.selectedIndex];

        if (!customerId) {
            document.getElementById('custNameDisplay').textContent = 'Walk-in Customer';
            document.getElementById('custTypeDisplay').textContent = 'Standard Retail';
            document.getElementById('custPointsDisplay').textContent = '0';
            document.getElementById('discountPercentInput').value = '0';
        } else {
            const name = selectedOption.getAttribute('data-name');
            const points = selectedOption.getAttribute('data-points') || 0;
            const type = selectedOption.getAttribute('data-type') || 'Retail';

            document.getElementById('custNameDisplay').textContent = name;
            document.getElementById('custTypeDisplay').textContent = `${type} Member`;
            document.getElementById('custPointsDisplay').textContent = points;

            // Apply loyalty discount based on member points
            if (parseInt(points) >= 500) {
                document.getElementById('discountPercentInput').value = '10'; // VIP 10%
            } else if (parseInt(points) >= 200) {
                document.getElementById('discountPercentInput').value = '5'; // Gold 5%
            } else {
                document.getElementById('discountPercentInput').value = '0';
            }
        }

        calculateTotals();
    }

    /**
     * Quick Apply Discount button
     */
    function quickApplyLoyaltyDiscount() {
        const discountInput = document.getElementById('discountPercentInput');
        const current = parseInt(discountInput.value) || 0;
        const next = current === 10 ? 0 : 10;
        discountInput.value = next;
        calculateTotals();
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: `បញ្ចុះតម្លៃ ${next}% ត្រូវបានកំណត់`,
            showConfirmButton: false,
            timer: 1500
        });
    }

    /**
     * Barcode scan prompt emulator
     */
    function triggerBarcodeScanPrompt() {
        Swal.fire({
            title: 'ស្កេនបារកូដ (Scan Barcode)',
            input: 'text',
            inputPlaceholder: 'បញ្ចូល ឬស្កេន Barcode / SKU...',
            showCancelButton: true,
            confirmButtonText: 'ស្វែងរក',
            confirmButtonColor: '#2563EB',
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                const query = result.value.trim().toLowerCase();
                const matchedCard = Array.from(document.querySelectorAll('.product-card')).find(c => {
                    return c.getAttribute('data-barcode').includes(query) || c.getAttribute('data-sku').includes(query);
                });

                if (matchedCard) {
                    matchedCard.click();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'បានបន្ថែមទំនិញចូលកន្ត្រក',
                        showConfirmButton: false,
                        timer: 1200
                    });
                } else {
                    Swal.fire('រកមិនឃើញ', 'មិនមានទំនិញត្រូវនឹងបារកូដនេះឡើយ', 'error');
                }
            }
        });
    }

    /**
     * Start a fresh new sale
     */
    function startNewSale() {
        cart = [];
        renderCart();
        document.getElementById('discountPercentInput').value = 0;
        document.getElementById('customerPaidInput').value = '';
        calculateTotals();
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: 'បានបើកការលក់ថ្មី (New Sale Started)',
            showConfirmButton: false,
            timer: 1500
        });
    }

    /**
     * Hold Sale
     */
    function holdSale() {
        if (cart.length === 0) {
            Swal.fire('កន្ត្រកទទេ', 'សូមបន្ថែមទំនិញមុននឹងរក្សាទុក', 'warning');
            return;
        }
        localStorage.setItem('techzone_pos_hold', JSON.stringify({
            cart: cart,
            customer: selectedCustomerId,
            discount: document.getElementById('discountPercentInput').value,
            time: new Date().toLocaleTimeString()
        }));
        Swal.fire('រក្សាទុកបណ្តោះអាសន្ន', 'ការលក់នេះត្រូវបាន Hold ទុកដោយជោគជ័យ', 'success');
    }

    /**
     * Step 4.2 & 4.3: PosController@checkout Submission
     */
    async function processCheckout() {
        if (cart.length === 0) {
            Swal.fire('កន្ត្រកទំនិញទទេ', 'សូមជ្រើសរើសទំនិញយ៉ាងហោចណាស់មួយមុខ', 'warning');
            return;
        }

        const btn = document.getElementById('btnProcessPayment');
        btn.disabled = true;
        btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> កំពុងទូទាត់...`;

        const payload = {
            customer_id: selectedCustomerId,
            payment_method: selectedPayment,
            discount_percentage: parseFloat(document.getElementById('discountPercentInput').value) || 0,
            tax_percentage: 10,
            paid_amount: parseFloat(document.getElementById('customerPaidInput').value) || null,
            items: cart.map(item => ({
                product_id: item.product_id,
                quantity: item.quantity,
                unit_price: item.price
            }))
        };

        try {
            const response = await fetch("{{ route('pos.checkout') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (data.success) {
                latestCompletedSaleId = data.sale.id;

                // Show Success Message with option to print receipt immediately
                Swal.fire({
                    icon: 'success',
                    title: 'ការទូទាត់ជោគជ័យ!',
                    html: `វិក្កយបត្រ <b>${data.receipt.invoice_number}</b> ត្រូវបានបង្កើត។<br>ទឹកប្រាក់សរុប: <b>$${data.receipt.total_amount}</b>`,
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-print"></i> ព្រីនវិក្កយបត្រ (Print 80mm)',
                    cancelButtonText: 'ការលក់បន្ទាប់',
                    confirmButtonColor: '#2563EB',
                    cancelButtonColor: '#64748B',
                }).then((res) => {
                    displayReceiptData(data.receipt);
                    if (res.isConfirmed) {
                        openReceiptModal();
                    } else {
                        startNewSale();
                    }
                });

                // Clear cart for next sale
                cart = [];
                renderCart();
            } else {
                Swal.fire('បរាជ័យក្នុងការលក់', data.message || 'មានបញ្ហាបច្ចេកទេស', 'error');
            }
        } catch (error) {
            console.error(error);
            Swal.fire('បញ្ហាប្រព័ន្ធ', 'មិនអាចភ្ជាប់ទៅកាន់ម៉ាស៊ីនបម្រើបានឡើយ', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = `<i class="fa-solid fa-credit-card"></i> Process Payment`;
        }
    }

    /**
     * Populate and open receipt modal
     */
    function displayReceiptData(r) {
        document.getElementById('rcptSaleNo').textContent = r.sale_number;
        document.getElementById('rcptInvoiceNo').textContent = r.invoice_number;
        document.getElementById('rcptDate').textContent = r.date;
        document.getElementById('rcptCashier').textContent = r.cashier;
        document.getElementById('rcptCustomer').textContent = r.customer_name;
        document.getElementById('rcptPaymentMethod').textContent = r.payment_method;

        const body = document.getElementById('rcptItemsBody');
        let html = '';
        r.items.forEach((item, idx) => {
            html += `
                <tr class="py-1">
                    <td class="py-1 text-slate-500">${idx + 1}</td>
                    <td class="py-1 font-bold text-slate-900">${item.name}</td>
                    <td class="py-1 text-center font-bold">${item.quantity}</td>
                    <td class="py-1 text-right font-mono">$${item.price}</td>
                    <td class="py-1 text-right font-mono font-bold">$${item.total}</td>
                </tr>
            `;
        });
        body.innerHTML = html;

        document.getElementById('rcptSubtotal').textContent = `$${r.subtotal}`;
        document.getElementById('rcptDiscount').textContent = `- $${r.discount_amount}`;
        document.getElementById('rcptTax').textContent = `$${r.tax_amount}`;
        document.getElementById('rcptTotal').textContent = `$${r.total_amount}`;
        document.getElementById('rcptPaid').textContent = `$${r.paid_amount}`;
        document.getElementById('rcptChange').textContent = `$${r.change_amount}`;
        document.getElementById('rcptBarcodeText').textContent = r.barcode;

        // Generate Barcode SVG
        try {
            JsBarcode("#receiptBarcodeSvg", r.barcode, {
                format: "CODE128",
                width: 1.5,
                height: 35,
                displayValue: false
            });
        } catch (e) {
            console.warn(e);
        }
    }

    function openReceiptModal() {
        document.getElementById('thermalReceiptModalBackdrop').classList.remove('hidden');
    }

    function closeReceiptModal() {
        document.getElementById('thermalReceiptModalBackdrop').classList.add('hidden');
    }

    function openReceiptModalForLatest() {
        if (!latestCompletedSaleId) {
            Swal.fire('មិនទាន់មានវិក្កយបត្រ', 'សូមធ្វើការលក់ជាមុនសិន', 'info');
            return;
        }
        printReceiptForSale(latestCompletedSaleId);
    }

    async function printReceiptForSale(saleId) {
        try {
            const res = await fetch(`/pos/receipt/${saleId}`);
            const data = await res.json();
            if (data.success) {
                displayReceiptData(data.receipt);
                openReceiptModal();
            }
        } catch (err) {
            Swal.fire('កំហុស', 'មិនអាចទាញទិន្នន័យវិក្កយបត្របានទេ', 'error');
        }
    }

    function viewSaleDetailsModal(saleId) {
        printReceiptForSale(saleId);
    }

    function openNewCustomerModal() {
        Swal.fire({
            title: 'បន្ថែមអតិថិជនថ្មី (+ New Customer)',
            html: `
                <div class="space-y-3 text-left text-xs">
                    <div>
                        <label class="font-bold text-slate-700">ឈ្មោះអតិថិជន *</label>
                        <input id="swalCustName" class="w-full mt-1 px-3 py-2 border rounded-xl" placeholder="ឧ. Heng Sovann">
                    </div>
                    <div>
                        <label class="font-bold text-slate-700">លេខទូរស័ព្ទ *</label>
                        <input id="swalCustPhone" class="w-full mt-1 px-3 py-2 border rounded-xl" placeholder="ឧ. +855 12 345 678">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'រក្សាទុក',
            confirmButtonColor: '#2563EB',
            preConfirm: () => {
                const name = document.getElementById('swalCustName').value;
                const phone = document.getElementById('swalCustPhone').value;
                if (!name || !phone) {
                    Swal.showValidationMessage('សូមបញ្ចូលឈ្មោះ និងលេខទូរស័ព្ទ');
                }
                return { name, phone };
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const res = await fetch("{{ route('customers.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            name: result.value.name,
                            phone: result.value.phone,
                            customer_type: 'Retail',
                            points: 0,
                            status: 'Active'
                        })
                    });
                    location.reload();
                } catch (e) {
                    Swal.fire('ជោគជ័យ', 'អតិថិជនថ្មីត្រូវបានបង្កើត', 'success');
                }
            }
        });
    }
</script>

</body>
</html>
