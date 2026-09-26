<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Inventory Transactions | TECHZONE</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .scrollbar-thin::-webkit-scrollbar { width: 6px; height: 6px; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 9999px; }
    .adj-radio:checked + label { border-color: #2563eb; background-color: #eff6ff; box-shadow: 0 0 0 1px #2563eb inset; }
</style>
</head>
<body class="bg-slate-50 text-slate-800">

<div class="flex min-h-screen">

    {{-- ==================== SIDEBAR ==================== --}}
    <aside class="w-64 bg-[#0f172a] text-slate-300 flex-shrink-0 hidden lg:flex flex-col fixed h-screen z-30">
        <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center shadow-lg shadow-blue-600/30">
                <i class="fa-solid fa-cube text-white text-lg"></i>
            </div>
            <div>
                <p class="text-white font-extrabold text-lg leading-tight tracking-wide">TECHZONE</p>
                <p class="text-[10px] text-slate-400 leading-none">Computer Shop Management System</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto scrollbar-thin px-3 py-4 space-y-1 text-sm">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-gauge w-5 text-center"></i> Dashboard
            </a>
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-box w-5 text-center"></i> Products
            </a>
            <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-layer-group w-5 text-center"></i> Categories
            </a>
            <a href="{{ route('brands.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-tags w-5 text-center"></i> Brands
            </a>
            <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-truck-field w-5 text-center"></i> Suppliers
            </a>
            <a href="{{ route('customers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-address-book w-5 text-center"></i> Customers
            </a>
            <a href="{{ route('purchase-orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-cart-shopping w-5 text-center"></i> Purchases
            </a>
            <a href="{{ route('inventory-transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30">
                <i class="fa-solid fa-warehouse w-5 text-center"></i> Inventory
            </a>
            <a href="{{ route('sales.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-cash-register w-5 text-center"></i> Sales (POS)
            </a>
            <a href="{{ route('repairs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-screwdriver-wrench w-5 text-center"></i> Repair Service
            </a>
            <a href="{{ route('warranties.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-shield-halved w-5 text-center"></i> Warranty
            </a>
            <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-chart-line w-5 text-center"></i> Reports
            </a>
            <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
                <i class="fa-solid fa-gear w-5 text-center"></i> Settings
            </a>
        </nav>

        <div class="px-4 py-4 border-t border-white/10 text-xs text-slate-500">
            &copy; {{ date('Y') }} TechZone POS
        </div>
    </aside>

    {{-- ==================== MAIN CONTENT ==================== --}}
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">

        <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-3 flex items-center justify-between sticky top-0 z-20">
            <div>
                <p class="text-xs text-slate-400 font-medium">
                    <a href="{{ route('inventory-transactions.index') }}" class="hover:text-blue-600">Inventory</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-1.5"></i>
                    <span class="text-slate-600 font-semibold">Transaction Logs & Adjustments</span>
                </p>
            </div>
            <div class="flex items-center gap-4 sm:gap-6 ml-auto">
                <button class="relative w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 transition">
                    <i class="fa-regular fa-bell text-slate-600"></i>
                    <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-rose-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">3</span>
                </button>
                <div class="flex items-center gap-3 border-l border-slate-200 pl-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=2563eb&color=fff&bold=true" class="w-9 h-9 rounded-full object-cover" alt="avatar">
                    <div class="hidden sm:block leading-tight">
                        <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-400">{{ Auth::user()->role ?? 'Administrator' }}</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-4 sm:p-6 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif
            @if(isset($errors) && $errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg text-sm">
                    <p class="font-semibold flex items-center gap-2 mb-1"><i class="fa-solid fa-circle-exclamation"></i> Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- TOP HEADER --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-600/30">
                        <i class="fa-solid fa-warehouse text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-slate-800">Inventory Management</h1>
                        <p class="text-sm text-slate-500">Transaction logs, stock movement and manual adjustments</p>
                    </div>
                </div>
                <button onclick="openAdjustmentModal()"
                        class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-sm px-4 py-2.5 rounded-lg shadow-md shadow-amber-500/30 transition">
                    <i class="fa-solid fa-sliders"></i> Adjust Stock
                </button>
            </div>

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Total Logs</p>
                        <p class="text-2xl font-extrabold text-slate-800">{{ $totalTransactions ?? 0 }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-arrow-down"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Total Stock In</p>
                        <p class="text-2xl font-extrabold text-emerald-600">+{{ number_format($totalStockIn ?? 0) }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-arrow-up"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Total Stock Out</p>
                        <p class="text-2xl font-extrabold text-rose-600">-{{ number_format($totalStockOut ?? 0) }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-sliders"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Stock Adjustments</p>
                        <p class="text-2xl font-extrabold text-slate-800">{{ $totalAdjustments ?? 0 }}</p>
                    </div>
                </div>
            </div>

            {{-- TOOLBAR & FILTERS --}}
            <form method="GET" action="{{ route('inventory-transactions.index') }}" class="bg-white rounded-xl border border-slate-200 p-4 flex flex-col lg:flex-row items-stretch lg:items-center gap-3 shadow-sm flex-wrap">
                <div class="relative flex-1 min-w-[200px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search product, SKU, or reason..."
                           class="w-full pl-9 pr-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:bg-white focus:outline-none text-sm">
                </div>

                <select name="type" onchange="this.form.submit()" class="px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm text-slate-600">
                    <option value="" {{ request('type') == '' ? 'selected' : '' }}>All Types</option>
                    <option value="Stock In" {{ request('type') == 'Stock In' ? 'selected' : '' }}>Stock In</option>
                    <option value="Stock Out" {{ request('type') == 'Stock Out' ? 'selected' : '' }}>Stock Out</option>
                    <option value="Adjustment" {{ request('type') == 'Adjustment' ? 'selected' : '' }}>Adjustment</option>
                    <option value="Sale" {{ request('type') == 'Sale' ? 'selected' : '' }}>Sale</option>
                    <option value="Return" {{ request('type') == 'Return' ? 'selected' : '' }}>Return</option>
                </select>

                <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm text-slate-600">
                <span class="text-slate-400 text-sm hidden sm:block">to</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm text-slate-600">

                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                        <i class="fa-solid fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ route('inventory-transactions.index') }}" class="px-4 py-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-sm font-semibold text-slate-600 transition inline-flex items-center gap-2">
                        <i class="fa-solid fa-rotate-right"></i> Reset
                    </a>
                </div>
            </form>

            {{-- DATA TABLE --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto scrollbar-thin">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3">Date & Time</th>
                                <th class="px-4 py-3">Product</th>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">Qty Change</th>
                                <th class="px-4 py-3">Before &rarr; After</th>
                                <th class="px-4 py-3">Reference / PO #</th>
                                <th class="px-4 py-3">Logged By</th>
                                <th class="px-4 py-3">Reason / Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($transactions as $tx)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-4 py-3 text-slate-600 whitespace-nowrap">{{ $tx->created_at->format('d M Y, h:i A') }}</td>
                                    <td class="px-4 py-3">
                                        <p class="font-semibold text-slate-800">{{ $tx->product->name ?? 'Unknown Product' }}</p>
                                        <p class="text-xs text-slate-400">
                                            SKU: {{ $tx->product->sku ?? '—' }}
                                            @if($tx->product?->category || $tx->product?->brand)
                                                &middot; {{ $tx->product->brand->name ?? '' }} {{ $tx->product->category->name ?? '' }}
                                            @endif
                                        </p>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php $type = $tx->type ?? $tx->transaction_type ?? 'Adjustment'; @endphp
                                        @if($type == 'Stock In')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Stock In</span>
                                        @elseif($type == 'Stock Out')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">Stock Out</span>
                                        @elseif($type == 'Adjustment')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Adjustment</span>
                                        @elseif($type == 'Sale')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Sale</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">Return</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-bold {{ $tx->quantity_change >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $tx->quantity_change >= 0 ? '+' : '' }}{{ $tx->quantity_change }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 whitespace-nowrap">
                                        {{ $tx->stock_before }} &rarr; <span class="font-semibold text-slate-800">{{ $tx->stock_after }}</span> units
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">
                                        @if($tx->reference_type === 'PurchaseOrder')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-mono font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                                {{ $tx->purchaseOrder->po_number ?? ('PO #' . $tx->reference_id) }}
                                            </span>
                                        @elseif($tx->reference_type)
                                            <span class="text-xs font-medium text-slate-600">{{ $tx->reference_type }}</span>
                                        @else
                                            <span class="text-xs text-slate-400">{{ $tx->reference ?? 'Manual Adjustment' }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-1.5 text-slate-700">
                                            <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-[10px] font-bold">
                                                {{ strtoupper(substr($tx->user->name ?? 'S', 0, 1)) }}
                                            </span>
                                            {{ $tx->user->name ?? 'System' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-500 max-w-[200px] truncate" title="{{ $tx->reason ?? $tx->notes }}">
                                        {{ $tx->reason ?? $tx->notes ?? '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3 text-slate-400">
                                            <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-2xl">
                                                <i class="fa-solid fa-clipboard-list"></i>
                                            </div>
                                            <p class="font-semibold text-slate-500">No inventory transactions found</p>
                                            <p class="text-sm">Stock movements will appear here once recorded.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($transactions->count() > 0)
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-4 py-4 border-t border-slate-100">
                        <p class="text-sm text-slate-500">
                            Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} entries
                        </p>
                        <div class="text-sm">
                            {{ $transactions->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

{{-- ==================== STOCK ADJUSTMENT MODAL ==================== --}}
<div id="stockAdjustmentModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl max-h-[92vh] overflow-y-auto scrollbar-thin">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-500 text-white flex items-center justify-center"><i class="fa-solid fa-sliders"></i></div>
                <h3 class="font-bold text-lg text-slate-800">Adjust Stock</h3>
            </div>
            <button onclick="document.getElementById('stockAdjustmentModal').classList.add('hidden')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="stockAdjustmentForm" method="POST" action="{{ route('inventory.adjust') }}" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1.5">Product <span class="text-rose-500">*</span></label>
                <select id="adj_product_id" name="product_id" required onchange="onAdjProductChange()" class="w-full px-3.5 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm">
                    <option value="">Select a product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-stock="{{ $product->stock_quantity }}">
                            {{ $product->name }} ({{ $product->sku }}) &mdash; Stock: {{ $product->stock_quantity }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-2">Adjustment Type <span class="text-rose-500">*</span></label>
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <input type="radio" id="adj_type_add" name="adjustment_type" value="add" class="hidden adj-radio" checked onchange="updatePreview()">
                        <label for="adj_type_add" class="cursor-pointer flex flex-col items-center gap-1.5 border-2 border-slate-200 rounded-xl px-3 py-3 text-center hover:border-emerald-300 transition">
                            <i class="fa-solid fa-circle-plus text-emerald-500 text-lg"></i>
                            <span class="text-xs font-semibold text-slate-600">Add<br>(Surplus / Found)</span>
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="adj_type_subtract" name="adjustment_type" value="subtract" class="hidden adj-radio" onchange="updatePreview()">
                        <label for="adj_type_subtract" class="cursor-pointer flex flex-col items-center gap-1.5 border-2 border-slate-200 rounded-xl px-3 py-3 text-center hover:border-rose-300 transition">
                            <i class="fa-solid fa-circle-minus text-rose-500 text-lg"></i>
                            <span class="text-xs font-semibold text-slate-600">Subtract<br>(Damaged / Lost)</span>
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="adj_type_set" name="adjustment_type" value="set" class="hidden adj-radio" onchange="updatePreview()">
                        <label for="adj_type_set" class="cursor-pointer flex flex-col items-center gap-1.5 border-2 border-slate-200 rounded-xl px-3 py-3 text-center hover:border-blue-300 transition">
                            <i class="fa-solid fa-arrows-rotate text-blue-500 text-lg"></i>
                            <span class="text-xs font-semibold text-slate-600">Set<br>(Physical Recount)</span>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1.5">Quantity <span class="text-rose-500">*</span></label>
                <input type="number" id="adj_quantity" name="quantity" min="0" value="0" required oninput="updatePreview()" class="w-full px-3.5 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1.5">Reason / Audit Notes <span class="text-rose-500">*</span></label>
                <textarea name="reason" rows="3" required placeholder="e.g. Damaged item, physical inventory recount, PO restock..." class="w-full px-3.5 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm resize-none"></textarea>
            </div>

            <div id="adj_preview_box" class="rounded-xl border border-slate-200 bg-slate-50 p-4 space-y-2">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500">Current Stock</span>
                    <span id="preview_current" class="font-semibold text-slate-700">—</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500">Adjustment</span>
                    <span id="preview_adjustment" class="font-semibold text-slate-700">—</span>
                </div>
                <div class="flex items-center justify-between text-base border-t border-slate-200 pt-2">
                    <span class="font-semibold text-slate-700">New Stock After Adjustment</span>
                    <span id="preview_new_stock" class="font-extrabold text-slate-800">—</span>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('stockAdjustmentModal').classList.add('hidden')" class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white font-semibold text-sm shadow-md shadow-amber-500/30 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Apply Adjustment
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== JAVASCRIPT ==================== --}}
<script>
    function openAdjustmentModal() {
        document.getElementById('stockAdjustmentForm').reset();
        document.getElementById('adj_type_add').checked = true;
        resetPreview();
        document.getElementById('stockAdjustmentModal').classList.remove('hidden');
    }

    function resetPreview() {
        document.getElementById('preview_current').textContent = '—';
        document.getElementById('preview_adjustment').textContent = '—';
        const newStockEl = document.getElementById('preview_new_stock');
        newStockEl.textContent = '—';
        newStockEl.classList.remove('text-rose-600');
        newStockEl.classList.add('text-slate-800');
    }

    function onAdjProductChange() {
        updatePreview();
    }

    function getCurrentStock() {
        const select = document.getElementById('adj_product_id');
        const opt = select.options[select.selectedIndex];
        return opt && opt.value ? parseInt(opt.dataset.stock, 10) : null;
    }

    function updatePreview() {
        const current = getCurrentStock();
        const qty = parseInt(document.getElementById('adj_quantity').value, 10) || 0;
        const type = document.querySelector('input[name="adjustment_type"]:checked')?.value ?? 'add';

        if (current === null) {
            resetPreview();
            return;
        }

        let newStock = current;
        let adjustmentLabel = '';

        if (type === 'add') {
            newStock = current + qty;
            adjustmentLabel = '+' + qty;
        } else if (type === 'subtract') {
            newStock = current - qty;
            adjustmentLabel = '-' + qty;
        } else if (type === 'set') {
            newStock = qty;
            adjustmentLabel = 'Set to ' + qty;
        }

        document.getElementById('preview_current').textContent = current + ' units';
        document.getElementById('preview_adjustment').textContent = adjustmentLabel;

        const newStockEl = document.getElementById('preview_new_stock');
        newStockEl.textContent = newStock + ' units';

        if (newStock < 0) {
            newStockEl.classList.remove('text-slate-800');
            newStockEl.classList.add('text-rose-600');
        } else {
            newStockEl.classList.remove('text-rose-600');
            newStockEl.classList.add('text-slate-800');
        }
    }

    document.querySelectorAll('[id$="Modal"]').forEach(function (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) modal.classList.add('hidden');
        });
    });
</script>

</body>
</html>
