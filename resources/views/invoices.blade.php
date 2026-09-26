<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payment & Invoice Management | TECHZONE Computer Shop</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js for Payment Summary Donut Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- JsBarcode for 80mm Print -->
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

        @media print {
            body * { visibility: hidden !important; }
            #printableInvoiceArea, #printableInvoiceArea * { visibility: visible !important; }
            #printableInvoiceArea {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                background: #ffffff !important;
                display: block !important;
                padding: 10mm !important;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-[#F4F6F9] text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

<div class="flex min-h-screen">

    {{-- ========================================================================= --}}
    {{-- 1. TECHZONE SIDEBAR NAVIGATION (Feature #12 Highlighted)                 --}}
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

            <a href="{{ route('repairs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-screwdriver-wrench w-4 text-center"></i> Repair Service Management
            </a>

            <a href="{{ route('warranties.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-shield-halved w-4 text-center"></i> Warranty Management
            </a>

            <!-- Active: Payment & Invoice Management -->
            <a href="{{ route('invoices') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30 transition">
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
    {{-- 2. MAIN INVOICES & PAYMENTS WORKSPACE                                     --}}
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
                    <input type="text" id="topNavSearch" placeholder="Search invoices, customer name, invoice number..."
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

            {{-- 2.1 Page Header matching Mockup 1 --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shadow-md shadow-blue-500/20">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900 leading-tight">Payment &amp; Invoice Management</h2>
                    <p class="text-xs text-slate-400 font-medium">Manage invoices, payments, refunds and transaction history</p>
                </div>
            </div>

            {{-- 2.2 FOUR STAT CARDS matching Mockup 1 --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                
                <!-- Card 1: Total Invoices -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-slate-400">Total Invoices</p>
                        <h3 class="text-xl font-extrabold text-slate-900">{{ number_format($totalInvoicesCount) }}</h3>
                        <p class="text-[11px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> + 12% <span class="text-slate-400 font-normal">(This month)</span>
                        </p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-sm">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                </div>

                <!-- Card 2: Total Sales Amount -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-slate-400">Total Sales Amount</p>
                        <h3 class="text-xl font-extrabold text-slate-900 font-mono">${{ number_format($totalSalesAmount, 2) }}</h3>
                        <p class="text-[11px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> + 18% <span class="text-slate-400 font-normal">(This month)</span>
                        </p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shadow-sm">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                </div>

                <!-- Card 3: Total Payments -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-slate-400">Total Payments</p>
                        <h3 class="text-xl font-extrabold text-slate-900 font-mono">${{ number_format($totalPaymentsReceived, 2) }}</h3>
                        <p class="text-[11px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> + 16% <span class="text-slate-400 font-normal">(This month)</span>
                        </p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg shadow-sm">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>

                <!-- Card 4: Outstanding Balance -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold text-slate-400">Outstanding Balance</p>
                        <h3 class="text-xl font-extrabold text-rose-600 font-mono">${{ number_format($outstandingBalance, 2) }}</h3>
                        <p class="text-[11px] font-bold text-rose-500 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-down"></i> - 8% <span class="text-slate-400 font-normal">(This month)</span>
                        </p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg shadow-sm">
                        <i class="fa-solid fa-scale-unbalanced"></i>
                    </div>
                </div>

            </div>

            {{-- 2.3 FILTER BAR matching Mockup 1 --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-3.5 shadow-sm flex flex-col xl:flex-row items-stretch xl:items-center justify-between gap-3 text-xs">
                
                <!-- Search input -->
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" id="filterSearch" value="{{ request('search') }}"
                           placeholder="Search invoice number, customer name, or product..."
                           onkeyup="if(event.key==='Enter') applyFilters()"
                           class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:outline-none transition">
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <!-- Payment Methods Filter -->
                    <select id="filterPaymentMethod" onchange="applyFilters()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none">
                        <option value="all" {{ request('payment_method') == 'all' ? 'selected' : '' }}>All Payment Methods</option>
                        <option value="Cash" {{ request('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Card" {{ request('payment_method') == 'Card' ? 'selected' : '' }}>Card</option>
                        <option value="ABA" {{ request('payment_method') == 'ABA' ? 'selected' : '' }}>ABA Bank</option>
                        <option value="Wing" {{ request('payment_method') == 'Wing' ? 'selected' : '' }}>Wing Bank</option>
                        <option value="Other" {{ request('payment_method') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>

                    <!-- Status Filter -->
                    <select id="filterStatus" onchange="applyFilters()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="Refunded" {{ request('status') == 'Refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>

                    <!-- Date range selector -->
                    <div class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-600 font-mono">
                        <i class="fa-regular fa-calendar text-slate-400"></i>
                        <input type="date" id="filterDateFrom" value="{{ request('date_from', '2025-09-01') }}" onchange="applyFilters()" class="bg-transparent focus:outline-none text-[11px]">
                        <span class="text-slate-400">&rarr;</span>
                        <input type="date" id="filterDateTo" value="{{ request('date_to', date('Y-m-d')) }}" onchange="applyFilters()" class="bg-transparent focus:outline-none text-[11px]">
                    </div>

                    <!-- Create Invoice Button -->
                    <button type="button" onclick="scrollToCreateInvoice()" class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition">
                        <i class="fa-solid fa-plus text-xs"></i> Create Invoice
                    </button>
                </div>

            </div>

            {{-- 2.4 TABS ROW matching Mockup 1 --}}
            <div class="flex items-center gap-2 border-b border-slate-200 text-xs font-semibold">
                <button type="button" class="flex items-center gap-2 px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 bg-white rounded-t-xl transition">
                    <i class="fa-regular fa-file-lines"></i> Invoices
                </button>
                <button type="button" onclick="Swal.fire('Payments Tab', 'បង្ហាញតារាងប្រវត្តិទូទាត់ទាំងអស់', 'info')" class="flex items-center gap-2 px-4 py-2.5 text-slate-500 hover:text-slate-800 transition">
                    <i class="fa-regular fa-credit-card"></i> Payments
                </button>
                <button type="button" onclick="Swal.fire('Refunds Tab', 'មុខងារបង្វិលសងប្រាក់អតិថិជន', 'info')" class="flex items-center gap-2 px-4 py-2.5 text-slate-500 hover:text-slate-800 transition">
                    <i class="fa-solid fa-rotate-left"></i> Refunds
                </button>
                <button type="button" onclick="Swal.fire('Payment History', 'កំណត់ត្រាប្រតិបត្តិការហិរញ្ញវត្ថុ', 'info')" class="flex items-center gap-2 px-4 py-2.5 text-slate-500 hover:text-slate-800 transition">
                    <i class="fa-solid fa-clock-rotate-left"></i> Payment History
                </button>
                <button type="button" onclick="Swal.fire('Outstanding Balance', 'បញ្ជីវិក្កយបត្រដែលមិនទាន់ទូទាត់រួច', 'info')" class="flex items-center gap-2 px-4 py-2.5 text-slate-500 hover:text-slate-800 transition">
                    <i class="fa-solid fa-scale-unbalanced"></i> Outstanding Balance
                </button>
            </div>

            {{-- 2.5 MAIN SPLIT LAYOUT (Invoices Table + Right Sidebar) --}}
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-5">

                {{-- LEFT/CENTER: INVOICES TABLE + CREATE NEW INVOICE (8 cols) --}}
                <div class="xl:col-span-8 space-y-5">
                    
                    <!-- Invoices Table Card -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm space-y-3">
                        <div class="overflow-x-auto scrollbar-thin">
                            <table class="w-full text-left text-xs text-slate-600">
                                <thead class="bg-slate-50 text-slate-500 font-semibold border-y border-slate-200">
                                    <tr>
                                        <th class="py-3 px-3 w-8"><input type="checkbox" class="rounded text-blue-600"></th>
                                        <th class="py-3 px-3">#</th>
                                        <th class="py-3 px-3">Invoice No.</th>
                                        <th class="py-3 px-3">Customer</th>
                                        <th class="py-3 px-3">Date</th>
                                        <th class="py-3 px-3">Total Amount</th>
                                        <th class="py-3 px-3">Payment Method</th>
                                        <th class="py-3 px-3">Status</th>
                                        <th class="py-3 px-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium">
                                    @forelse($invoices as $idx => $inv)
                                        <tr class="hover:bg-slate-50/80 transition">
                                            <td class="py-3 px-3"><input type="checkbox" class="rounded text-blue-600"></td>
                                            <td class="py-3 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                            <td class="py-3 px-3 font-mono font-bold text-blue-600">
                                                <a href="javascript:void(0)" onclick="previewInvoice({{ $inv->id }})" class="hover:underline">
                                                    {{ $inv->invoice_number }}
                                                </a>
                                            </td>
                                            <td class="py-3 px-3 text-slate-800 font-semibold">{{ $inv->customer->name ?? 'Walk-in Customer' }}</td>
                                            <td class="py-3 px-3 font-mono text-slate-500">{{ $inv->invoice_date->format('Y-m-d H:i') }}</td>
                                            <td class="py-3 px-3 font-mono font-bold text-slate-900">${{ number_format($inv->total_amount, 2) }}</td>
                                            
                                            <!-- Payment Method Badge matching Mockup -->
                                            <td class="py-3 px-3">
                                                @if($inv->payment_method === 'Cash')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                        Cash
                                                    </span>
                                                @elseif($inv->payment_method === 'Card')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-200">
                                                        Card
                                                    </span>
                                                @elseif($inv->payment_method === 'ABA')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-200">
                                                        ABA
                                                    </span>
                                                @elseif($inv->payment_method === 'Wing')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-lime-50 text-lime-700 border border-lime-200">
                                                        Wing
                                                    </span>
                                                @else
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                                        {{ $inv->payment_method }}
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Status Badge matching Mockup -->
                                            <td class="py-3 px-3">
                                                @if($inv->status === 'Paid')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                        Paid
                                                    </span>
                                                @elseif($inv->status === 'Pending')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                                        Pending
                                                    </span>
                                                @elseif($inv->status === 'Cancelled')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                                        Cancelled
                                                    </span>
                                                @else
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                                        {{ $inv->status }}
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Actions (Eye, Print, More) -->
                                            <td class="py-3 px-3 text-right space-x-1.5 whitespace-nowrap">
                                                <button type="button" onclick="previewInvoice({{ $inv->id }})" title="View Details" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                                <button type="button" onclick="printInvoiceDirect({{ $inv->id }})" title="Print Invoice" class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition">
                                                    <i class="fa-solid fa-print"></i>
                                                </button>
                                                <button type="button" onclick="Swal.fire('Action Options', 'Option menu for invoice {{ $inv->invoice_number }}', 'info')" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg transition">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="py-8 text-center text-slate-400">មិនមានវិក្កយបត្រត្រូវនឹងលក្ខខណ្ឌស្វែងរកឡើយ</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Footer matching Mockup -->
                        <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                            <div>
                                Showing {{ $invoices->firstItem() ?? 0 }} to {{ $invoices->lastItem() ?? 0 }} of {{ $invoices->total() }} invoices
                            </div>
                            <div>
                                {{ $invoices->links() }}
                            </div>
                        </div>
                    </div>

                    {{-- BOTTOM PANEL: "Create New Invoice" matching Mockup 1 --}}
                    <div id="createNewInvoicePanel" class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-file-circle-plus text-blue-600"></i> Create New Invoice
                            </h3>
                            <button type="button" onclick="resetNewInvoiceForm()" class="text-xs text-slate-400 hover:text-slate-600 transition">
                                Reset
                            </button>
                        </div>

                        <!-- Customer Selection Card matching Mockup -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="relative flex-1">
                                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                        <select id="invCustomerSelect" onchange="onInvCustomerSelect(this)" class="w-full pl-8 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none">
                                            <option value="">Search customer...</option>
                                            @foreach($customers as $c)
                                                <option value="{{ $c->id }}" data-name="{{ $c->name }}" data-phone="{{ $c->phone }}" data-points="{{ $c->points }}" {{ $c->name == 'Sok Dara' ? 'selected' : '' }}>
                                                    {{ $c->name }} ({{ $c->phone }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" onclick="openNewCustomerModal()" class="px-3 py-2 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition whitespace-nowrap">
                                        + New Customer
                                    </button>
                                </div>

                                <!-- Selected Customer Preview Card matching Mockup -->
                                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                            <i class="fa-regular fa-user"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-xs font-bold text-slate-800" id="invCardCustName">Sok Dara</h4>
                                            <p class="text-[10px] text-slate-400 font-mono" id="invCardCustCode">C001 &bull; +855 12 345 678</p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="document.getElementById('invCustomerSelect').focus()" class="text-xs font-semibold text-blue-600 hover:underline">
                                        Change
                                    </button>
                                </div>
                            </div>

                            <!-- Right: Sale Items Header & Add Product button -->
                            <div class="flex items-end justify-between pb-1">
                                <span class="text-xs font-bold text-slate-700">Sale Items</span>
                                <button type="button" onclick="promptAddProductToInvoice()" class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition">
                                    <i class="fa-solid fa-plus text-[10px]"></i> Add Product
                                </button>
                            </div>
                        </div>

                        <!-- Sale Items Table matching Mockup 1 -->
                        <div class="overflow-x-auto scrollbar-thin">
                            <table class="w-full text-left text-xs text-slate-600">
                                <thead class="bg-slate-50 text-slate-500 font-semibold border-y border-slate-200">
                                    <tr>
                                        <th class="py-2.5 px-3">#</th>
                                        <th class="py-2.5 px-3">Product</th>
                                        <th class="py-2.5 px-3 text-center">Qty</th>
                                        <th class="py-2.5 px-3 text-right">Price</th>
                                        <th class="py-2.5 px-3 text-right">Total</th>
                                        <th class="py-2.5 px-3 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="invItemsTableBody" class="divide-y divide-slate-100 font-medium">
                                    <!-- Populated dynamically via JS to match Mockup 1 items: ASUS TUF Gaming Laptop ($750) & Logitech Mouse ($25) -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Pricing Summary & Process Payment Button matching Mockup -->
                        <div class="pt-3 border-t border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="text-xs space-y-1 text-slate-500 w-full md:w-60">
                                <div class="flex justify-between">
                                    <span>Subtotal:</span>
                                    <span class="font-bold text-slate-800 font-mono" id="invSubtotalText">$775.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Discount:</span>
                                    <span class="font-bold text-rose-500 font-mono" id="invDiscountText">- $0.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Tax (10%):</span>
                                    <span class="font-bold text-slate-800 font-mono" id="invTaxText">$77.50</span>
                                </div>
                                <div class="flex justify-between text-sm font-bold text-slate-900 pt-1 border-t border-slate-100">
                                    <span>Total:</span>
                                    <span class="text-base text-blue-600 font-mono" id="invTotalText">$852.50</span>
                                </div>
                            </div>

                            <button type="button" onclick="submitInvoiceCheckout()" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-md shadow-blue-500/20 flex items-center justify-center gap-2 transition">
                                <i class="fa-solid fa-credit-card"></i> Process Payment
                            </button>
                        </div>

                    </div>

                </div>

                {{-- RIGHT SIDEBAR: RECENT INVOICE + PAYMENT DONUT + PAYMENT METHODS (4 cols) --}}
                <div class="xl:col-span-4 space-y-5">
                    
                    <!-- 1. Recent Invoice Card matching Mockup 1 -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <i class="fa-solid fa-receipt text-blue-600"></i> Recent Invoice
                            </h3>
                            <a href="javascript:void(0)" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="text-xs text-blue-600 hover:underline font-semibold">
                                View All
                            </a>
                        </div>

                        <!-- Invoice Preview Body -->
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-3" id="recentInvoiceCardContainer">
                            <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-200">
                                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-sm font-bold">
                                    <i class="fa-solid fa-cube"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs font-extrabold text-slate-800">TECHZONE</h4>
                                    <p class="text-[10px] text-slate-400">Computer Shop Management System</p>
                                </div>
                            </div>

                            <div class="text-[11px] space-y-1 text-slate-600">
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Invoice No:</span>
                                    <span class="font-bold text-blue-600 font-mono" id="rcInvoiceNo">{{ $recentInvoice->invoice_number ?? 'INV-2025-0098' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Date:</span>
                                    <span class="font-mono text-slate-700" id="rcInvoiceDate">{{ $recentInvoice ? $recentInvoice->invoice_date->format('Y-m-d h:i A') : '2025-09-10 10:32 AM' }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-400">Customer:</span>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-800" id="rcInvoiceCustomer">{{ $recentInvoice->customer->name ?? 'Sok Dara' }}</span>
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200" id="rcInvoiceStatus">Paid</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Items table -->
                            <div class="pt-2 border-t border-slate-200">
                                <table class="w-full text-[10.5px]">
                                    <thead class="text-slate-400 text-left border-b border-slate-200">
                                        <tr>
                                            <th class="pb-1">#</th>
                                            <th class="pb-1">Product</th>
                                            <th class="pb-1 text-center">Qty</th>
                                            <th class="pb-1 text-right">Price</th>
                                            <th class="pb-1 text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rcInvoiceItemsBody" class="divide-y divide-slate-100 font-medium">
                                        @if($recentInvoice && $recentInvoice->sale && $recentInvoice->sale->details->count() > 0)
                                            @foreach($recentInvoice->sale->details as $dIdx => $d)
                                                <tr>
                                                    <td class="py-1 text-slate-400">{{ $dIdx + 1 }}</td>
                                                    <td class="py-1 text-slate-800 font-semibold truncate max-w-[100px]">{{ $d->product->name }}</td>
                                                    <td class="py-1 text-center font-bold">{{ $d->quantity }}</td>
                                                    <td class="py-1 text-right font-mono">${{ number_format($d->unit_price, 2) }}</td>
                                                    <td class="py-1 text-right font-mono font-bold">${{ number_format($d->subtotal, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="py-1 text-slate-400">1</td>
                                                <td class="py-1 text-slate-800 font-semibold truncate max-w-[100px]">ASUS TUF Gaming Laptop</td>
                                                <td class="py-1 text-center font-bold">1</td>
                                                <td class="py-1 text-right font-mono">$750.00</td>
                                                <td class="py-1 text-right font-mono font-bold">$750.00</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Totals -->
                            <div class="pt-2 border-t border-slate-200 text-[11px] space-y-1 text-slate-600">
                                <div class="flex justify-between">
                                    <span>Subtotal:</span>
                                    <span class="font-mono text-slate-800" id="rcSubtotal">${{ number_format($recentInvoice->subtotal ?? 750, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Discount:</span>
                                    <span class="font-mono text-rose-500" id="rcDiscount">- ${{ number_format($recentInvoice->discount_amount ?? 0, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Tax (10%):</span>
                                    <span class="font-mono text-slate-800" id="rcTax">${{ number_format($recentInvoice->tax_amount ?? 75, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-xs font-extrabold text-slate-900 pt-1 border-t border-slate-200">
                                    <span>Total:</span>
                                    <span class="text-blue-600 font-mono text-sm" id="rcTotal">${{ number_format($recentInvoice->total_amount ?? 825, 2) }}</span>
                                </div>
                            </div>

                            <div class="pt-2 flex items-center gap-2">
                                <button type="button" onclick="printInvoiceDirect({{ $recentInvoice->id ?? 1 }})" class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-sm transition">
                                    Print Invoice
                                </button>
                                <button type="button" onclick="previewInvoice({{ $recentInvoice->id ?? 1 }})" class="flex-1 py-2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Payment Summary Donut Chart matching Mockup 1 -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4">
                        <h3 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-chart-pie text-blue-600"></i> Payment Summary
                        </h3>

                        <!-- Donut Canvas Container -->
                        <div class="relative w-44 h-44 mx-auto flex items-center justify-center">
                            <canvas id="paymentSummaryDonutChart"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-xs font-extrabold text-slate-900 font-mono" id="donutTotalPaidDisplay">${{ number_format($totalPaymentsReceived, 0) }}</span>
                                <span class="text-[10px] text-slate-400">Total Paid</span>
                            </div>
                        </div>

                        <!-- Method Legend List matching Mockup 1 -->
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Cash
                                </span>
                                <span class="font-mono text-slate-700 font-medium">38% ($4,550)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> Card
                                </span>
                                <span class="font-mono text-slate-700 font-medium">28% ($3,350)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span> ABA
                                </span>
                                <span class="font-mono text-slate-700 font-medium">18% ($2,150)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Wing
                                </span>
                                <span class="font-mono text-slate-700 font-medium">10% ($1,200)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span> Other
                                </span>
                                <span class="font-mono text-slate-700 font-medium">6% ($730)</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Payment Methods Selector Box matching Mockup 1 -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3">
                        <h3 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-credit-card text-blue-600"></i> Payment Methods
                        </h3>

                        <div class="space-y-2 text-xs">
                            <label class="flex items-center justify-between p-2 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                <span class="flex items-center gap-2.5 text-slate-700 font-medium">
                                    <i class="fa-solid fa-money-bill-wave text-emerald-600 w-4"></i> Cash
                                </span>
                                <input type="radio" name="sidebarPaymentMethod" value="Cash" checked class="text-blue-600">
                            </label>

                            <label class="flex items-center justify-between p-2 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                <span class="flex items-center gap-2.5 text-slate-700 font-medium">
                                    <i class="fa-regular fa-credit-card text-blue-600 w-4"></i> Credit/Debit Card
                                </span>
                                <input type="radio" name="sidebarPaymentMethod" value="Card" class="text-blue-600">
                            </label>

                            <label class="flex items-center justify-between p-2 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                <span class="flex items-center gap-2.5 text-slate-700 font-medium">
                                    <span class="font-bold text-[11px] text-sky-700 w-4 text-center">ABA</span> ABA Bank
                                </span>
                                <input type="radio" name="sidebarPaymentMethod" value="ABA" class="text-blue-600">
                            </label>

                            <label class="flex items-center justify-between p-2 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                <span class="flex items-center gap-2.5 text-slate-700 font-medium">
                                    <span class="font-bold text-[11px] text-lime-600 w-4 text-center">W</span> Wing
                                </span>
                                <input type="radio" name="sidebarPaymentMethod" value="Wing" class="text-blue-600">
                            </label>

                            <label class="flex items-center justify-between p-2 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                <span class="flex items-center gap-2.5 text-slate-700 font-medium">
                                    <i class="fa-solid fa-qrcode text-indigo-600 w-4"></i> QR Payment
                                </span>
                                <input type="radio" name="sidebarPaymentMethod" value="QR" class="text-blue-600">
                            </label>

                            <label class="flex items-center justify-between p-2 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                                <span class="flex items-center gap-2.5 text-slate-700 font-medium">
                                    <i class="fa-solid fa-ellipsis text-slate-500 w-4"></i> Other
                                </span>
                                <input type="radio" name="sidebarPaymentMethod" value="Other" class="text-blue-600">
                            </label>
                        </div>
                    </div>

                </div>

            </div>

        </main>
    </div>

</div>

{{-- ========================================================================= --}}
{{-- 3. INVOICE DETAIL & PRINT MODAL                                           --}}
{{-- ========================================================================= --}}
<div id="invoiceDetailModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 overflow-y-auto no-print">
    <div class="bg-white rounded-2xl shadow-2xl max-w-xl w-full p-6 relative border border-slate-200">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-file-invoice text-blue-600"></i> Invoice Details
            </h4>
            <button onclick="closeInvoiceModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <div id="printableInvoiceArea" class="py-4 space-y-4 text-xs">
            <!-- Header -->
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-lg">
                        <i class="fa-solid fa-cube"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900">TECHZONE</h3>
                        <p class="text-[10.5px] text-slate-500">Computer Shop Management System</p>
                    </div>
                </div>
                <div class="text-right">
                    <h4 class="text-sm font-extrabold text-blue-600 font-mono" id="modalInvNumber">INV-2025-0098</h4>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200" id="modalInvStatus">Paid</span>
                </div>
            </div>

            <!-- Customer & Date Info -->
            <div class="grid grid-cols-2 gap-4 p-3 rounded-xl bg-slate-50 border border-slate-100">
                <div>
                    <span class="text-slate-400 text-[10px]">BILLED TO:</span>
                    <p class="font-bold text-slate-800 text-xs" id="modalInvCustomer">Sok Dara</p>
                    <p class="text-slate-500 text-[10.5px]" id="modalInvPhone">+855 12 345 678</p>
                </div>
                <div class="text-right">
                    <span class="text-slate-400 text-[10px]">DATE & PAYMENT:</span>
                    <p class="font-mono text-slate-700 text-xs" id="modalInvDate">2025-09-10 10:32 AM</p>
                    <p class="font-semibold text-slate-700 text-[10.5px]">Method: <span class="text-blue-600" id="modalInvMethod">Cash</span></p>
                </div>
            </div>

            <!-- Items Table -->
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 text-slate-600 border-b border-slate-200">
                    <tr>
                        <th class="py-2 px-2.5">#</th>
                        <th class="py-2 px-2.5">Product Description</th>
                        <th class="py-2 px-2.5 text-center">Qty</th>
                        <th class="py-2 px-2.5 text-right">Unit Price</th>
                        <th class="py-2 px-2.5 text-right">Total</th>
                    </tr>
                </thead>
                <tbody id="modalInvItemsBody" class="divide-y divide-slate-100">
                    <!-- Populated via JS -->
                </tbody>
            </table>

            <!-- Calculation Box -->
            <div class="pt-3 border-t border-slate-200 flex justify-end">
                <div class="w-56 space-y-1 text-slate-600">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span class="font-mono text-slate-800 font-bold" id="modalInvSubtotal">$0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Discount:</span>
                        <span class="font-mono text-rose-500 font-bold" id="modalInvDiscount">- $0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tax (10%):</span>
                        <span class="font-mono text-slate-800 font-bold" id="modalInvTax">$0.00</span>
                    </div>
                    <div class="flex justify-between text-sm font-extrabold text-slate-900 pt-1.5 border-t border-slate-200">
                        <span>Total Amount:</span>
                        <span class="text-blue-600 font-mono" id="modalInvTotal">$0.00</span>
                    </div>
                    <div class="flex justify-between text-[11px] text-emerald-600 font-semibold pt-1">
                        <span>Paid:</span>
                        <span class="font-mono" id="modalInvPaid">$0.00</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
            <button type="button" onclick="closeInvoiceModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                Close
            </button>
            <button type="button" onclick="window.print()" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-xs font-semibold text-white shadow-sm flex items-center gap-1.5 transition">
                <i class="fa-solid fa-print"></i> Print Invoice
            </button>
        </div>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 4. INVOICES & PAYMENTS JAVASCRIPT STATE ENGINE                             --}}
{{-- ========================================================================= --}}
<script>
    // State for Create New Invoice Panel matching Mockup 1 items
    let invoiceBuilderItems = [
        { product_id: 1, name: 'ASUS TUF Gaming Laptop', sku: 'ASUS-TUF-001', price: 750.00, quantity: 1 },
        { product_id: 3, name: 'Logitech Mouse', sku: 'LOGI-MOU-003', price: 25.00, quantity: 1 }
    ];

    document.addEventListener('DOMContentLoaded', () => {
        renderInvoiceBuilderItems();
        initPaymentDonutChart();
    });

    /**
     * Render items in bottom "Create New Invoice" table
     */
    function renderInvoiceBuilderItems() {
        const tbody = document.getElementById('invItemsTableBody');
        let html = '';
        let subtotal = 0;

        invoiceBuilderItems.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;

            html += `
                <tr class="hover:bg-slate-50 transition">
                    <td class="py-2.5 px-3 text-slate-400 font-mono">${index + 1}</td>
                    <td class="py-2.5 px-3 font-semibold text-slate-800">${item.name}</td>
                    
                    <!-- Stepper [- 1 +] matching Mockup 1 -->
                    <td class="py-2.5 px-3 text-center">
                        <div class="inline-flex items-center border border-slate-200 rounded-lg bg-slate-50 overflow-hidden">
                            <button type="button" onclick="changeBuilderQty(${index}, -1)" class="w-6 h-6 flex items-center justify-center text-slate-600 hover:bg-slate-200 text-xs font-bold">
                                &minus;
                            </button>
                            <span class="w-7 text-center font-bold font-mono text-xs text-slate-800">${item.quantity}</span>
                            <button type="button" onclick="changeBuilderQty(${index}, 1)" class="w-6 h-6 flex items-center justify-center text-slate-600 hover:bg-slate-200 text-xs font-bold">
                                &plus;
                            </button>
                        </div>
                    </td>

                    <td class="py-2.5 px-3 text-right font-mono text-slate-700">$${item.price.toFixed(2)}</td>
                    <td class="py-2.5 px-3 text-right font-mono font-bold text-slate-900">$${itemTotal.toFixed(2)}</td>
                    <td class="py-2.5 px-3 text-center">
                        <button type="button" onclick="removeBuilderItem(${index})" class="text-rose-500 hover:text-rose-700 p-1">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;

        const tax = subtotal * 0.10;
        const total = subtotal + tax;

        document.getElementById('invSubtotalText').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('invTaxText').textContent = `$${tax.toFixed(2)}`;
        document.getElementById('invTotalText').textContent = `$${total.toFixed(2)}`;
    }

    function changeBuilderQty(index, delta) {
        if (!invoiceBuilderItems[index]) return;
        const newQty = invoiceBuilderItems[index].quantity + delta;
        if (newQty <= 0) {
            removeBuilderItem(index);
            return;
        }
        invoiceBuilderItems[index].quantity = newQty;
        renderInvoiceBuilderItems();
    }

    function removeBuilderItem(index) {
        invoiceBuilderItems.splice(index, 1);
        renderInvoiceBuilderItems();
    }

    function promptAddProductToInvoice() {
        const availableProducts = @json($products);
        let optionsHtml = '';
        availableProducts.forEach(p => {
            optionsHtml += `<option value="${p.id}" data-name="${p.name}" data-price="${p.selling_price}">${p.name} ($${p.selling_price})</option>`;
        });

        Swal.fire({
            title: 'បន្ថែមទំនិញចូលវិក្កយបត្រ',
            html: `
                <div class="text-left text-xs space-y-2">
                    <label class="font-bold text-slate-700">ជ្រើសរើសផលិតផល</label>
                    <select id="swalAddProdSelect" class="w-full px-3 py-2 border rounded-xl">${optionsHtml}</select>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'បន្ថែម',
            confirmButtonColor: '#2563EB',
            preConfirm: () => {
                const sel = document.getElementById('swalAddProdSelect');
                const opt = sel.options[sel.selectedIndex];
                return {
                    id: parseInt(sel.value),
                    name: opt.getAttribute('data-name'),
                    price: parseFloat(opt.getAttribute('data-price'))
                };
            }
        }).then((res) => {
            if (res.isConfirmed && res.value) {
                const existing = invoiceBuilderItems.find(i => i.product_id === res.value.id);
                if (existing) {
                    existing.quantity += 1;
                } else {
                    invoiceBuilderItems.push({
                        product_id: res.value.id,
                        name: res.value.name,
                        sku: 'SKU-' + res.value.id,
                        price: res.value.price,
                        quantity: 1
                    });
                }
                renderInvoiceBuilderItems();
            }
        });
    }

    function onInvCustomerSelect(select) {
        const opt = select.options[select.selectedIndex];
        if (!opt || !select.value) {
            document.getElementById('invCardCustName').textContent = 'Walk-in Customer';
            document.getElementById('invCardCustCode').textContent = 'C000 &bull; N/A';
            return;
        }
        document.getElementById('invCardCustName').textContent = opt.getAttribute('data-name');
        document.getElementById('invCardCustCode').textContent = 'C00' + select.value + ' &bull; ' + opt.getAttribute('data-phone');
    }

    function resetNewInvoiceForm() {
        invoiceBuilderItems = [];
        renderInvoiceBuilderItems();
    }

    function scrollToCreateInvoice() {
        document.getElementById('createNewInvoicePanel').scrollIntoView({ behavior: 'smooth' });
    }

    /**
     * Submit invoice checkout from bottom panel
     */
    async function submitInvoiceCheckout() {
        if (invoiceBuilderItems.length === 0) {
            Swal.fire('ទទេ', 'សូមបន្ថែមទំនិញចូលវិក្កយបត្រ', 'warning');
            return;
        }

        const customerId = document.getElementById('invCustomerSelect').value || null;
        const selectedMethod = document.querySelector('input[name="sidebarPaymentMethod"]:checked')?.value || 'Cash';

        const payload = {
            customer_id: customerId,
            payment_method: selectedMethod,
            discount_percentage: 0,
            tax_percentage: 10,
            items: invoiceBuilderItems.map(i => ({
                product_id: i.product_id,
                quantity: i.quantity,
                unit_price: i.price
            }))
        };

        try {
            const res = await fetch("{{ route('pos.checkout') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json();
            if (data.success) {
                Swal.fire('ជោគជ័យ!', `វិក្កយបត្រ ${data.receipt.invoice_number} ត្រូវបានបង្កើត`, 'success')
                    .then(() => location.reload());
            } else {
                Swal.fire('បរាជ័យ', data.message || 'មិនអាចបង្កើតវិក្កយបត្របានទេ', 'error');
            }
        } catch (e) {
            Swal.fire('កំហុស', 'មិនអាចតភ្ជាប់ប្រព័ន្ធបានទេ', 'error');
        }
    }

    /**
     * Preview Invoice Details in Modal
     */
    async function previewInvoice(invoiceId) {
        try {
            const res = await fetch(`/invoices/${invoiceId}`);
            const data = await res.json();
            if (data.success) {
                const inv = data.invoice;
                document.getElementById('modalInvNumber').textContent = inv.invoice_number;
                document.getElementById('modalInvStatus').textContent = inv.status;
                document.getElementById('modalInvCustomer').textContent = inv.customer ? inv.customer.name : 'Walk-in Customer';
                document.getElementById('modalInvPhone').textContent = inv.customer ? inv.customer.phone : 'N/A';
                document.getElementById('modalInvDate').textContent = new Date(inv.invoice_date).toLocaleString();
                document.getElementById('modalInvMethod').textContent = inv.payment_method;

                let itemsHtml = '';
                if (inv.sale && inv.sale.details) {
                    inv.sale.details.forEach((d, idx) => {
                        itemsHtml += `
                            <tr>
                                <td class="py-2 px-2.5 text-slate-400">${idx + 1}</td>
                                <td class="py-2 px-2.5 font-bold text-slate-800">${d.product ? d.product.name : 'Product'}</td>
                                <td class="py-2 px-2.5 text-center font-bold">${d.quantity}</td>
                                <td class="py-2 px-2.5 text-right font-mono">$${parseFloat(d.unit_price).toFixed(2)}</td>
                                <td class="py-2 px-2.5 text-right font-mono font-bold">$${parseFloat(d.subtotal).toFixed(2)}</td>
                            </tr>
                        `;
                    });
                }
                document.getElementById('modalInvItemsBody').innerHTML = itemsHtml;

                document.getElementById('modalInvSubtotal').textContent = `$${parseFloat(inv.subtotal).toFixed(2)}`;
                document.getElementById('modalInvDiscount').textContent = `- $${parseFloat(inv.discount_amount).toFixed(2)}`;
                document.getElementById('modalInvTax').textContent = `$${parseFloat(inv.tax_amount).toFixed(2)}`;
                document.getElementById('modalInvTotal').textContent = `$${parseFloat(inv.total_amount).toFixed(2)}`;
                document.getElementById('modalInvPaid').textContent = `$${parseFloat(inv.paid_amount).toFixed(2)}`;

                document.getElementById('invoiceDetailModalBackdrop').classList.remove('hidden');
            }
        } catch (e) {
            Swal.fire('កំហុស', 'មិនអាចទាញទិន្នន័យវិក្កយបត្របានឡើយ', 'error');
        }
    }

    function closeInvoiceModal() {
        document.getElementById('invoiceDetailModalBackdrop').classList.add('hidden');
    }

    function printInvoiceDirect(invoiceId) {
        previewInvoice(invoiceId).then(() => {
            setTimeout(() => {
                window.print();
            }, 300);
        });
    }

    /**
     * Filter inputs trigger
     */
    function applyFilters() {
        const search = document.getElementById('filterSearch').value || document.getElementById('topNavSearch').value;
        const method = document.getElementById('filterPaymentMethod').value;
        const status = document.getElementById('filterStatus').value;
        const dateFrom = document.getElementById('filterDateFrom').value;
        const dateTo = document.getElementById('filterDateTo').value;

        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (method && method !== 'all') params.append('payment_method', method);
        if (status && status !== 'all') params.append('status', status);
        if (dateFrom) params.append('date_from', dateFrom);
        if (dateTo) params.append('date_to', dateTo);

        window.location.href = "{{ route('invoices') }}?" + params.toString();
    }

    /**
     * Initialize Payment Summary Donut Chart matching Mockup 1
     */
    function initPaymentDonutChart() {
        const ctx = document.getElementById('paymentSummaryDonutChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Cash', 'Card', 'ABA', 'Wing', 'Other'],
                datasets: [{
                    data: [38, 28, 18, 10, 6],
                    backgroundColor: [
                        '#10B981', // Emerald for Cash
                        '#2563EB', // Blue for Card
                        '#4F46E5', // Indigo for ABA
                        '#F59E0B', // Amber for Wing
                        '#94A3B8'  // Gray for Other
                    ],
                    borderWidth: 2,
                    borderColor: '#FFFFFF',
                    cutout: '72%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ` ${context.label}: ${context.raw}%`;
                            }
                        }
                    }
                }
            }
        });
    }
</script>

</body>
</html>
