<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Purchase Orders | TECHZONE</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .scrollbar-thin::-webkit-scrollbar { width: 6px; height: 6px; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 9999px; }

    @media print {
        body * { visibility: hidden; }
        #poSlipPrintArea, #poSlipPrintArea * { visibility: visible; }
        #poSlipPrintArea { position: absolute; top: 0; left: 0; width: 100%; padding: 20px; }
        .no-print { display: none !important; }
    }
</style>
</head>
<body class="bg-slate-50 text-slate-800">

<div class="flex min-h-screen">

    {{-- ==================== SIDEBAR ==================== --}}
    <aside class="w-64 bg-[#0f172a] text-slate-300 flex-shrink-0 hidden lg:flex flex-col fixed h-screen z-30 no-print">
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
            <a href="{{ route('purchase-orders.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30">
                <i class="fa-solid fa-cart-shopping w-5 text-center"></i> Purchases
            </a>
            <a href="{{ route('inventory-transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/5 hover:text-white transition">
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

        <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-3 flex items-center justify-between sticky top-0 z-20 no-print">
            <div>
                <p class="text-xs text-slate-400 font-medium">
                    <a href="{{ route('purchase-orders.index') }}" class="hover:text-blue-600">Purchases</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-1.5"></i>
                    <span class="text-slate-600 font-semibold">Purchase Orders</span>
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

        <main class="p-4 sm:p-6 space-y-6 no-print">

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
                        <i class="fa-solid fa-cart-shopping text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-slate-800">Purchase Management</h1>
                        <p class="text-sm text-slate-500">Create and track purchase orders from suppliers</p>
                    </div>
                </div>
                <button onclick="openCreatePoModal()"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-4 py-2.5 rounded-lg shadow-md shadow-blue-600/30 transition">
                    <i class="fa-solid fa-plus"></i> Create Purchase Order
                </button>
            </div>

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-shopping-cart"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Total Orders</p>
                        <p class="text-2xl font-extrabold text-slate-800">{{ $totalOrders ?? 0 }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Pending Delivery</p>
                        <p class="text-2xl font-extrabold text-slate-800">{{ $pendingOrders ?? 0 }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Stock Received</p>
                        <p class="text-2xl font-extrabold text-slate-800">{{ $receivedOrders ?? 0 }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Total Purchase Spend</p>
                        <p class="text-2xl font-extrabold text-slate-800">${{ number_format($totalSpend ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- TOOLBAR & FILTERS --}}
            <form method="GET" action="{{ route('purchase-orders.index') }}" class="bg-white rounded-xl border border-slate-200 p-4 flex flex-col lg:flex-row items-stretch lg:items-center gap-3 shadow-sm">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search PO Number, Notes, Supplier..."
                           class="w-full pl-9 pr-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:bg-white focus:outline-none text-sm">
                </div>

                <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm text-slate-600">
                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Received" {{ request('status') == 'Received' ? 'selected' : '' }}>Received</option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <select name="supplier_id" onchange="this.form.submit()" class="px-4 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm text-slate-600">
                    <option value="">All Suppliers</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                    @endforeach
                </select>

                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                        <i class="fa-solid fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ route('purchase-orders.index') }}" class="px-4 py-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-sm font-semibold text-slate-600 transition inline-flex items-center gap-2">
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
                                <th class="px-4 py-3">PO Number</th>
                                <th class="px-4 py-3">Supplier</th>
                                <th class="px-4 py-3">Order Date</th>
                                <th class="px-4 py-3">Items</th>
                                <th class="px-4 py-3">Total Amount</th>
                                <th class="px-4 py-3">PO Status</th>
                                <th class="px-4 py-3">Payment</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($purchaseOrders as $po)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 font-mono">
                                            {{ $po->po_number }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="font-semibold text-slate-800">{{ $po->supplier->name ?? '—' }}</p>
                                        <p class="text-xs text-slate-400">by {{ $po->user->name ?? 'System' }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">{{ \Carbon\Carbon::parse($po->order_date)->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $po->details->count() }} item(s)</td>
                                    <td class="px-4 py-3 font-semibold text-slate-800">${{ number_format($po->total_amount, 2) }}</td>
                                    <td class="px-4 py-3">
                                        @if($po->status == 'Pending')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                                <i class="fa-solid fa-clock mr-1 text-[10px]"></i> Pending
                                            </span>
                                        @elseif($po->status == 'Received')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                                <i class="fa-solid fa-check mr-1 text-[10px]"></i> Received
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">
                                                <i class="fa-solid fa-xmark mr-1 text-[10px]"></i> Cancelled
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @php $pay = $po->payment_status ?? 'Unpaid'; @endphp
                                        @if($pay == 'Paid')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Paid</span>
                                        @elseif($pay == 'Partial')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Partial</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">Unpaid</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($po->status == 'Pending')
                                                <button title="Receive Stock"
                                                        onclick="receiveStock('{{ $po->id }}', '{{ $po->po_number }}')"
                                                        class="w-8 h-8 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center transition">
                                                    <i class="fa-solid fa-truck-ramp-box text-xs"></i>
                                                </button>
                                            @endif
                                            <button title="View / Print Slip" onclick='openSlipModal(@json($po->load("details.product")))' class="w-8 h-8 rounded-lg bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center transition">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </button>
                                            @if($po->status != 'Received')
                                                <form action="{{ route('purchase-orders.destroy', $po->id) }}" method="POST" class="inline delete-po-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" title="Delete" onclick="confirmDeletePo(this)" class="w-8 h-8 rounded-lg bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center transition">
                                                        <i class="fa-solid fa-trash text-xs"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button title="Cannot delete received orders" disabled class="w-8 h-8 rounded-lg bg-slate-200 text-slate-400 flex items-center justify-center cursor-not-allowed">
                                                    <i class="fa-solid fa-lock text-xs"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3 text-slate-400">
                                            <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-2xl">
                                                <i class="fa-solid fa-box-open"></i>
                                            </div>
                                            <p class="font-semibold text-slate-500">No purchase orders found</p>
                                            <p class="text-sm">Create a new purchase order to restock your inventory.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($purchaseOrders->count() > 0)
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-4 py-4 border-t border-slate-100">
                        <p class="text-sm text-slate-500">
                            Showing {{ $purchaseOrders->firstItem() }} to {{ $purchaseOrders->lastItem() }} of {{ $purchaseOrders->total() }} entries
                        </p>
                        <div class="text-sm">
                            {{ $purchaseOrders->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

{{-- ==================== CREATE PURCHASE ORDER MODAL ==================== --}}
<div id="createPoModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 no-print">
    <div class="bg-white rounded-2xl w-full max-w-4xl shadow-2xl max-h-[92vh] overflow-y-auto scrollbar-thin">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 sticky top-0 bg-white z-10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-blue-600 text-white flex items-center justify-center"><i class="fa-solid fa-cart-plus"></i></div>
                <h3 class="font-bold text-lg text-slate-800">Create Purchase Order</h3>
            </div>
            <button onclick="closeCreatePoModal()" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="createPoForm" method="POST" action="{{ route('purchase-orders.store') }}" class="p-6 space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-1.5">Supplier <span class="text-rose-500">*</span></label>
                    <select name="supplier_id" required class="w-full px-3.5 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm">
                        <option value="">Select a supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-1.5">Status</label>
                    <select name="status" class="w-full px-3.5 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm">
                        <option value="Pending">Pending</option>
                        <option value="Received">Received</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-1.5">Order Date <span class="text-rose-500">*</span></label>
                    <input type="date" name="order_date" required value="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-600 mb-1.5">Expected Delivery Date</label>
                    <input type="date" name="expected_delivery_date" class="w-full px-3.5 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1.5">Notes</label>
                <textarea name="notes" rows="2" placeholder="Optional notes for this purchase order..." class="w-full px-3.5 py-2.5 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm resize-none"></textarea>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-bold text-slate-700">Order Items</label>
                    <button type="button" onclick="addItemRow()" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700">
                        <i class="fa-solid fa-plus"></i> Add Another Product
                    </button>
                </div>
                <div class="overflow-x-auto rounded-lg border border-slate-200">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-3 py-2 min-w-[220px]">Product</th>
                                <th class="px-3 py-2 w-28">Current Stock</th>
                                <th class="px-3 py-2 w-24">Order Qty</th>
                                <th class="px-3 py-2 w-32">Unit Cost ($)</th>
                                <th class="px-3 py-2 w-32">Subtotal ($)</th>
                                <th class="px-3 py-2 w-12"></th>
                            </tr>
                        </thead>
                        <tbody id="itemRowsBody" class="divide-y divide-slate-100"></tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end">
                <div class="bg-slate-50 border border-slate-200 rounded-lg px-6 py-3 flex items-center gap-4">
                    <span class="text-sm font-semibold text-slate-500">Order Grand Total:</span>
                    <span id="grandTotalDisplay" class="text-xl font-extrabold text-blue-600">$0.00</span>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2 border-t border-slate-100 sticky bottom-0 bg-white pb-1">
                <button type="button" onclick="closeCreatePoModal()" class="px-5 py-2.5 rounded-lg border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-md shadow-blue-600/30 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Save Purchase Order
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== PO SLIP / VIEW MODAL ==================== --}}
<div id="poSlipModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 no-print">
    <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl max-h-[92vh] overflow-y-auto scrollbar-thin">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 no-print">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-blue-600 text-white flex items-center justify-center"><i class="fa-solid fa-file-invoice"></i></div>
                <h3 class="font-bold text-lg text-slate-800">Purchase Order Slip</h3>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="window.print()" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                    <i class="fa-solid fa-print mr-1"></i> Print Slip
                </button>
                <button onclick="document.getElementById('poSlipModal').classList.add('hidden')" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>

        <div id="poSlipPrintArea" class="p-8">
            <div class="flex items-start justify-between border-b border-slate-200 pb-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center text-white">
                        <i class="fa-solid fa-cube text-lg"></i>
                    </div>
                    <div>
                        <p class="font-extrabold text-lg text-slate-800">TECHZONE Computer Shop</p>
                        <p class="text-xs text-slate-400">Phnom Penh, Cambodia &middot; +855 12 345 678</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-400 uppercase font-semibold">Purchase Order</p>
                    <p id="slip_po_number" class="font-mono font-bold text-slate-800"></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold mb-1">Supplier</p>
                    <p id="slip_supplier" class="font-semibold text-slate-700"></p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-400 uppercase font-semibold mb-1">Order Date</p>
                    <p id="slip_date" class="font-semibold text-slate-700"></p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold mb-1">Status</p>
                    <p id="slip_status" class="font-semibold text-slate-700"></p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-400 uppercase font-semibold mb-1">Prepared By</p>
                    <p id="slip_user" class="font-semibold text-slate-700"></p>
                </div>
            </div>

            <table class="w-full text-sm text-left mb-6">
                <thead class="border-y border-slate-200 text-slate-500 text-xs uppercase font-semibold">
                    <tr>
                        <th class="py-2">Product</th>
                        <th class="py-2 text-center">Qty</th>
                        <th class="py-2 text-right">Unit Cost</th>
                        <th class="py-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody id="slip_items_body" class="divide-y divide-slate-100 text-slate-700"></tbody>
            </table>

            <div class="flex justify-end">
                <div class="w-64 space-y-1 text-sm">
                    <div class="flex justify-between font-bold text-base border-t border-slate-200 pt-2">
                        <span>Grand Total</span>
                        <span id="slip_total" class="text-blue-600"></span>
                    </div>
                </div>
            </div>

            <div id="slip_notes_wrapper" class="mt-6 text-sm text-slate-500">
                <p class="text-xs text-slate-400 uppercase font-semibold mb-1">Notes</p>
                <p id="slip_notes"></p>
            </div>

            <p class="text-center text-xs text-slate-400 mt-8">This is a system-generated purchase order slip. Thank you.</p>
        </div>
    </div>
</div>

{{-- ==================== JAVASCRIPT ==================== --}}
<script>
    const productsCatalog = @json($products);
    let itemRowIndex = 0;

    function productOptionsHtml(selectedId = '') {
        let html = '<option value="">Select product</option>';
        productsCatalog.forEach(function (p) {
            const sel = String(p.id) === String(selectedId) ? 'selected' : '';
            html += `<option value="${p.id}" data-stock="${p.stock_quantity}" data-cost="${p.cost_price}" ${sel}>${p.name} (${p.sku})</option>`;
        });
        return html;
    }

    function addItemRow() {
        const tbody = document.getElementById('itemRowsBody');
        const idx = itemRowIndex++;
        const row = document.createElement('tr');
        row.dataset.rowId = idx;
        row.innerHTML = `
            <td class="px-3 py-2">
                <select name="items[${idx}][product_id]" required onchange="onProductSelect(this)" class="w-full px-2.5 py-2 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm">
                    ${productOptionsHtml()}
                </select>
            </td>
            <td class="px-3 py-2 text-center text-slate-500 current-stock-cell">—</td>
            <td class="px-3 py-2">
                <input type="number" name="items[${idx}][quantity]" min="1" value="1" required oninput="calculateRow(${idx})" class="w-full px-2.5 py-2 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm qty-input">
            </td>
            <td class="px-3 py-2">
                <input type="number" name="items[${idx}][unit_cost]" min="0" step="0.01" value="0.00" required oninput="calculateRow(${idx})" class="w-full px-2.5 py-2 rounded-lg bg-slate-50 border border-slate-200 focus:border-blue-400 focus:outline-none text-sm cost-input">
            </td>
            <td class="px-3 py-2 font-semibold text-slate-700 subtotal-cell">$0.00</td>
            <td class="px-3 py-2 text-center">
                <button type="button" onclick="removeItemRow(this)" class="w-7 h-7 rounded-lg bg-rose-100 text-rose-600 hover:bg-rose-200 flex items-center justify-center transition">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    }

    function onProductSelect(select) {
        const row = select.closest('tr');
        const opt = select.options[select.selectedIndex];
        const stock = opt.dataset.stock ?? 0;
        const cost = opt.dataset.cost ?? 0;
        row.querySelector('.current-stock-cell').textContent = opt.value ? stock + ' units' : '—';
        row.querySelector('.cost-input').value = opt.value ? parseFloat(cost).toFixed(2) : '0.00';
        calculateRow(row.dataset.rowId);
    }

    function calculateRow(idx) {
        const row = document.querySelector(`tr[data-row-id="${idx}"]`);
        if (!row) return;
        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const cost = parseFloat(row.querySelector('.cost-input').value) || 0;
        const subtotal = qty * cost;
        row.querySelector('.subtotal-cell').textContent = '$' + subtotal.toFixed(2);
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        document.querySelectorAll('#itemRowsBody tr').forEach(function (row) {
            const qty = parseFloat(row.querySelector('.qty-input')?.value) || 0;
            const cost = parseFloat(row.querySelector('.cost-input')?.value) || 0;
            total += qty * cost;
        });
        document.getElementById('grandTotalDisplay').textContent = '$' + total.toFixed(2);
    }

    function removeItemRow(btn) {
        const tbody = document.getElementById('itemRowsBody');
        if (tbody.children.length <= 1) {
            Swal.fire({ icon: 'warning', title: 'At least one item required', timer: 1500, showConfirmButton: false });
            return;
        }
        btn.closest('tr').remove();
        calculateGrandTotal();
    }

    function openCreatePoModal() {
        document.getElementById('itemRowsBody').innerHTML = '';
        itemRowIndex = 0;
        addItemRow();
        document.getElementById('grandTotalDisplay').textContent = '$0.00';
        document.getElementById('createPoModal').classList.remove('hidden');
    }

    function closeCreatePoModal() {
        document.getElementById('createPoModal').classList.add('hidden');
    }

    // ---------- Receive Stock (AJAX) ----------
    function receiveStock(id, poNumber) {
        Swal.fire({
            title: 'Receive Stock?',
            html: `Are you sure you want to receive stock for PO #<b>${poNumber}</b>? This will immediately increment stock quantities for all products in this order and record Inventory Transactions.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Receive Stock',
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#94a3b8'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/purchase-orders/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: 'Received' })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Request failed');
                    return res.json().catch(() => ({}));
                })
                .then(() => {
                    Swal.fire({ icon: 'success', title: 'Stock Received!', text: 'Inventory has been updated successfully.', timer: 1800, showConfirmButton: false })
                        .then(() => location.reload());
                })
                .catch(() => {
                    Swal.fire({ icon: 'error', title: 'Something went wrong', text: 'Unable to update purchase order status.' });
                });
            }
        });
    }

    // ---------- Delete PO ----------
    function confirmDeletePo(btn) {
        const form = btn.closest('form');
        Swal.fire({
            title: 'Delete Purchase Order?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    }

    // ---------- View / Print Slip ----------
    function openSlipModal(po) {
        document.getElementById('slip_po_number').textContent = po.po_number;
        document.getElementById('slip_supplier').textContent = po.supplier ? po.supplier.name : '—';
        document.getElementById('slip_date').textContent = po.order_date;
        document.getElementById('slip_status').textContent = po.status;
        document.getElementById('slip_user').textContent = po.user ? po.user.name : 'System';
        document.getElementById('slip_notes').textContent = po.notes ? po.notes : 'No additional notes.';

        let rows = '';
        let total = 0;
        (po.details || []).forEach(function (d) {
            const productName = d.product ? d.product.name : ('Product #' + d.product_id);
            const subtotal = parseFloat(d.quantity) * parseFloat(d.unit_cost);
            total += subtotal;
            rows += `<tr>
                <td class="py-2">${productName}</td>
                <td class="py-2 text-center">${d.quantity}</td>
                <td class="py-2 text-right">$${parseFloat(d.unit_cost).toFixed(2)}</td>
                <td class="py-2 text-right">$${subtotal.toFixed(2)}</td>
            </tr>`;
        });
        document.getElementById('slip_items_body').innerHTML = rows || '<tr><td colspan="4" class="py-4 text-center text-slate-400">No items recorded.</td></tr>';
        document.getElementById('slip_total').textContent = '$' + (po.total_amount ? parseFloat(po.total_amount).toFixed(2) : total.toFixed(2));

        document.getElementById('poSlipModal').classList.remove('hidden');
    }

    document.querySelectorAll('[id$="Modal"]').forEach(function (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) modal.classList.add('hidden');
        });
    });
</script>

</body>
</html>
