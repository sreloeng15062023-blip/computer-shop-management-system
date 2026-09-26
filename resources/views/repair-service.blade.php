<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Repair Service Management | TECHZONE Computer Shop</title>

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
    <!-- JsBarcode -->
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
            #printableTicketModal, #printableTicketModal * { visibility: visible !important; }
            #printableTicketModal {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                display: block !important;
                background: #ffffff !important;
                padding: 10mm !important;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-[#F4F6F9] text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

<div class="flex min-h-screen">

    {{-- ========================================================================= --}}
    {{-- 1. TECHZONE SIDEBAR NAVIGATION (Feature #10 Highlighted)                 --}}
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

            <!-- Active: Repair Service Management with Sub-menu matching Mockup 1 -->
            <div class="space-y-1 pt-0.5">
                <a href="{{ route('repair.service') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30 transition">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-screwdriver-wrench w-4 text-center"></i> Repair Service Management
                    </span>
                    <i class="fa-solid fa-chevron-down text-[11px] opacity-80"></i>
                </a>

                <div class="pl-7 pr-2 py-1 space-y-1">
                    <a href="javascript:void(0)" onclick="scrollToNewRequest()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-regular fa-file-lines text-[10px] text-blue-400"></i> Repair Requests
                    </a>
                    <a href="javascript:void(0)" onclick="openDiagnosisModalForFeatured()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-stethoscope text-[10px] text-emerald-400"></i> Diagnosis
                    </a>
                    <a href="javascript:void(0)" onclick="scrollToStatusUpdate()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-user-gear text-[10px] text-amber-400"></i> Assign Technician
                    </a>
                    <a href="javascript:void(0)" onclick="scrollToTable()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-blue-400 bg-slate-800/60 transition">
                        <i class="fa-solid fa-list-check text-[10px]"></i> Repair Status
                    </a>
                    <a href="javascript:void(0)" onclick="openSparePartsModal()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-microchip text-[10px] text-indigo-400"></i> Spare Parts
                    </a>
                    <a href="javascript:void(0)" onclick="scrollToTable()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-clock-rotate-left text-[10px] text-purple-400"></i> Service History
                    </a>
                </div>
            </div>

            <a href="{{ route('warranty') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
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
    {{-- 2. MAIN REPAIR SERVICE WORKSPACE                                          --}}
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
                    <input type="text" id="topNavSearch" placeholder="Search repair ID, customer name, device, serial number..."
                           onkeyup="if(event.key==='Enter') applyFilters()"
                           class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:border-blue-500 focus:outline-none text-xs transition text-slate-700">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button class="relative w-9 h-9 rounded-xl bg-slate-50 hover:bg-slate-100 flex items-center justify-center text-slate-500 transition border border-slate-200">
                    <i class="fa-solid fa-bell text-sm"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center shadow">3</span>
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

            {{-- 2.1 Header Row matching Mockup 1 --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shadow-md shadow-blue-500/20">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 leading-tight">Repair Service Management</h2>
                        <p class="text-xs text-slate-400 font-medium">Manage repair requests, diagnosis, technicians, and service status</p>
                    </div>
                </div>

                <button type="button" onclick="scrollToNewRequest()" class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-xs shadow-sm transition">
                    <i class="fa-solid fa-plus text-xs"></i> New Repair Request
                </button>
            </div>

            {{-- 2.2 FIVE STAT CARDS matching Mockup 1 --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-3.5">
                
                <!-- Card 1: Total Repair Orders -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">Total Repair Orders</p>
                        <h3 class="text-xl font-extrabold text-slate-900">{{ number_format($totalOrders) }}</h3>
                        <p class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> + 12% <span class="text-slate-400 font-normal">(This month)</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-box-archive"></i>
                    </div>
                </div>

                <!-- Card 2: In Progress -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">In Progress</p>
                        <h3 class="text-xl font-extrabold text-amber-600">{{ number_format($inProgressCount) }}</h3>
                        <p class="text-[10px] font-bold text-amber-500 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> + 5%
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>

                <!-- Card 3: Completed -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">Completed</p>
                        <h3 class="text-xl font-extrabold text-emerald-600">{{ number_format($completedCount) }}</h3>
                        <p class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> + 20%
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>

                <!-- Card 4: Waiting for Parts -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">Waiting for Parts</p>
                        <h3 class="text-xl font-extrabold text-rose-600">{{ number_format($waitingPartsCount) }}</h3>
                        <p class="text-[10px] font-bold text-rose-500 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> + 33%
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>

                <!-- Card 5: Cancelled -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">Cancelled</p>
                        <h3 class="text-xl font-extrabold text-purple-600">{{ number_format($cancelledCount) }}</h3>
                        <p class="text-[10px] font-bold text-purple-500 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-down"></i> - 50%
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-ban"></i>
                    </div>
                </div>

            </div>

            {{-- 2.3 FILTER BAR matching Mockup 1 --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-3.5 shadow-sm flex flex-col xl:flex-row items-stretch xl:items-center justify-between gap-3 text-xs" id="tableFilterSection">
                <div class="flex items-center gap-3">
                    <span class="font-extrabold text-slate-900 text-sm">Repair Orders</span>
                </div>

                <div class="flex flex-wrap items-center gap-2.5 flex-1 xl:justify-end">
                    <div class="relative flex-1 sm:max-w-xs">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" id="filterSearch" value="{{ request('search') }}"
                               placeholder="Search repair ID, customer, device..."
                               onkeyup="if(event.key==='Enter') applyFilters()"
                               class="w-full pl-8 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:outline-none transition">
                    </div>

                    <!-- Status Filter -->
                    <select id="filterStatus" onchange="applyFilters()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none">
                        <option value="all">All Status</option>
                        <option value="Received" {{ request('status') == 'Received' ? 'selected' : '' }}>Received</option>
                        <option value="Diagnosing" {{ request('status') == 'Diagnosing' ? 'selected' : '' }}>Diagnosing</option>
                        <option value="Waiting for Parts" {{ request('status') == 'Waiting for Parts' ? 'selected' : '' }}>Waiting for Parts</option>
                        <option value="Repairing" {{ request('status') == 'Repairing' ? 'selected' : '' }}>Repairing</option>
                        <option value="Testing" {{ request('status') == 'Testing' ? 'selected' : '' }}>Testing</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>

                    <!-- Technician Filter -->
                    <select id="filterTechnician" onchange="applyFilters()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none">
                        <option value="all">All Technicians</option>
                        @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}" {{ request('technician_id') == $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }}
                            </option>
                        @endforeach
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

            {{-- 2.4 MAIN SPLIT: TABLE + RIGHT SIDEBAR (Donut & Quick Actions) --}}
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-5">

                {{-- LEFT/CENTER: REPAIR ORDERS TABLE (8 cols) --}}
                <div class="xl:col-span-8 space-y-4">
                    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm space-y-3">
                        <div class="overflow-x-auto scrollbar-thin">
                            <table class="w-full text-left text-xs text-slate-600">
                                <thead class="bg-slate-50 text-slate-500 font-semibold border-y border-slate-200">
                                    <tr>
                                        <th class="py-3 px-3 w-8"><input type="checkbox" class="rounded text-blue-600"></th>
                                        <th class="py-3 px-3">#</th>
                                        <th class="py-3 px-3">Repair ID</th>
                                        <th class="py-3 px-3">Customer</th>
                                        <th class="py-3 px-3">Device</th>
                                        <th class="py-3 px-3">Issue</th>
                                        <th class="py-3 px-3">Status</th>
                                        <th class="py-3 px-3">Technician</th>
                                        <th class="py-3 px-3">Created Date</th>
                                        <th class="py-3 px-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium">
                                    @forelse($repairs as $idx => $r)
                                        <tr class="hover:bg-slate-50/80 transition cursor-pointer" onclick="selectRepairForPreview({{ $r->id }})">
                                            <td class="py-3 px-3" onclick="event.stopPropagation()"><input type="checkbox" class="rounded text-blue-600"></td>
                                            <td class="py-3 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                            <td class="py-3 px-3 font-mono font-bold text-blue-600">
                                                {{ $r->repair_code }}
                                            </td>
                                            <td class="py-3 px-3 font-semibold text-slate-800">{{ $r->customer->name ?? 'Walk-in' }}</td>
                                            <td class="py-3 px-3 text-slate-700 truncate max-w-[130px]" title="{{ $r->model }}">{{ $r->model }}</td>
                                            <td class="py-3 px-3 text-slate-500 truncate max-w-[130px]" title="{{ $r->issue_description }}">{{ $r->issue_description }}</td>
                                            
                                            <!-- Status Badges matching Mockup 1 -->
                                            <td class="py-3 px-3">
                                                @if($r->status === 'Diagnosing')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-sky-50 text-sky-600 border border-sky-200">
                                                        Diagnosing
                                                    </span>
                                                @elseif($r->status === 'Waiting for Parts')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                                        Waiting for Parts
                                                    </span>
                                                @elseif($r->status === 'Repairing')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-200">
                                                        Repairing
                                                    </span>
                                                @elseif($r->status === 'Testing')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-200">
                                                        Testing
                                                    </span>
                                                @elseif($r->status === 'Received')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                                        Received
                                                    </span>
                                                @elseif($r->status === 'Completed')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                        Completed
                                                    </span>
                                                @elseif($r->status === 'Cancelled')
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                                        Cancelled
                                                    </span>
                                                @else
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                                        {{ $r->status }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="py-3 px-3 text-slate-600">{{ $r->technician->name ?? 'Unassigned' }}</td>
                                            <td class="py-3 px-3 font-mono text-slate-500">{{ $r->created_at->format('Y-m-d H:i') }}</td>
                                            
                                            <!-- Action Buttons -->
                                            <td class="py-3 px-3 text-right space-x-1.5 whitespace-nowrap" onclick="event.stopPropagation()">
                                                <button type="button" onclick="printRepairTicket({{ $r->id }})" title="Print Repair Ticket Slip" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                                    <i class="fa-solid fa-print"></i>
                                                </button>
                                                <button type="button" onclick="selectRepairForPreview({{ $r->id }})" title="View / Edit" class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition">
                                                    <i class="fa-regular fa-eye"></i>
                                                </button>
                                                <button type="button" onclick="quickChangeStatusPrompt({{ $r->id }}, '{{ $r->status }}')" title="Change Status" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg transition">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="py-8 text-center text-slate-400">មិនមានកំណត់ត្រាជួសជុលត្រូវនឹងលក្ខខណ្ឌស្វែងរកឡើយ</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Footer -->
                        <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                            <div>
                                Showing {{ $repairs->firstItem() ?? 0 }} to {{ $repairs->lastItem() ?? 0 }} of {{ $repairs->total() }} entries
                            </div>
                            <div>
                                {{ $repairs->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT SIDEBAR: DONUT CHART + QUICK ACTIONS + RECENT MINI LIST (4 cols) --}}
                <div class="xl:col-span-4 space-y-4">
                    
                    <!-- 1. Repair Status Donut Chart matching Mockup 1 -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4">
                        <h3 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-chart-pie text-blue-600"></i> Repair Status
                        </h3>

                        <div class="relative w-44 h-44 mx-auto flex items-center justify-center">
                            <canvas id="repairStatusDonutChart"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-xs font-extrabold text-slate-900 font-mono">{{ $totalOrders }}</span>
                                <span class="text-[10px] text-slate-400">Total Orders</span>
                            </div>
                        </div>

                        <!-- Status Breakdown Legend List matching Mockup 1 percentages -->
                        <div class="space-y-1.5 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-sky-400"></span> Diagnosing</span>
                                <span class="font-mono text-slate-700 font-medium">18 (37.5%)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span> Waiting for Parts</span>
                                <span class="font-mono text-slate-700 font-medium">4 (8.3%)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> Repairing</span>
                                <span class="font-mono text-slate-700 font-medium">11 (22.9%)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span> Testing</span>
                                <span class="font-mono text-slate-700 font-medium">3 (6.3%)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Completed</span>
                                <span class="font-mono text-slate-700 font-medium">10 (20.8%)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Cancelled</span>
                                <span class="font-mono text-slate-700 font-medium">2 (4.2%)</span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Quick Actions matching Mockup 1 -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3">
                        <h3 class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-bolt text-blue-600"></i> Quick Actions
                        </h3>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <button type="button" onclick="scrollToNewRequest()" class="flex items-center gap-2 p-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700 font-semibold shadow-sm transition">
                                <i class="fa-solid fa-plus text-xs"></i> New Request
                            </button>
                            <button type="button" onclick="scanSerialPrompt()" class="flex items-center gap-2 p-2.5 rounded-xl bg-purple-600 text-white hover:bg-purple-700 font-semibold shadow-sm transition">
                                <i class="fa-solid fa-barcode text-xs"></i> Scan Serial
                            </button>
                            <a href="{{ route('warranty') }}" class="flex items-center gap-2 p-2.5 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 font-semibold shadow-sm transition">
                                <i class="fa-solid fa-shield-halved text-xs"></i> Check Warranty
                            </a>
                            <button type="button" onclick="scrollToTable()" class="flex items-center gap-2 p-2.5 rounded-xl bg-amber-500 text-white hover:bg-amber-600 font-semibold shadow-sm transition">
                                <i class="fa-solid fa-clock-rotate-left text-xs"></i> Service History
                            </button>
                        </div>
                    </div>

                    <!-- 3. Recent Repair Orders mini list matching Mockup 1 -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-bold text-slate-800">Recent Repair Orders</h3>
                            <a href="javascript:void(0)" onclick="scrollToTable()" class="text-[11px] text-blue-600 hover:underline">View All</a>
                        </div>
                        <div class="divide-y divide-slate-100 text-xs">
                            @foreach($repairs->take(5) as $mini)
                                <div class="py-2 flex items-center justify-between cursor-pointer hover:bg-slate-50 transition" onclick="selectRepairForPreview({{ $mini->id }})">
                                    <div class="space-y-0.5">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-blue-600 font-mono text-[11px]">{{ $mini->repair_code }}</span>
                                            <span class="text-slate-800 font-semibold text-[11px]">{{ $mini->brand }}</span>
                                        </div>
                                        <p class="text-[10px] text-slate-400 truncate max-w-[150px]">{{ $mini->model }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-slate-100 text-slate-700">
                                            {{ $mini->status }}
                                        </span>
                                        <p class="text-[9px] text-slate-400 font-mono mt-0.5">{{ $mini->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>

            {{-- 2.5 THREE BOTTOM PANELS matching Mockup 1 --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 pt-2">

                {{-- PANEL 1: Create Repair Request (4 cols) --}}
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4" id="createRequestSection">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-wrench text-blue-600"></i> Create Repair Request
                    </h3>

                    <form action="{{ route('repairs.store') }}" method="POST" class="space-y-3 text-xs">
                        @csrf
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <label class="font-bold text-slate-700">Customer *</label>
                                <button type="button" onclick="openNewCustomerModal()" class="text-blue-600 text-[11px] hover:underline font-semibold">+ New</button>
                            </div>
                            <select name="customer_id" id="repCustomerSelect" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                                <option value="">Search customer...</option>
                                @foreach($customers as $c)
                                    <option value="{{ $c->id }}" {{ $c->name == 'Sok Dara' ? 'selected' : '' }}>
                                        {{ $c->name }} ({{ $c->phone }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Device Type</label>
                            <select name="device_type" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                                <option value="Laptop">Laptop</option>
                                <option value="Desktop">Desktop PC</option>
                                <option value="Monitor">Monitor</option>
                                <option value="Smartphone">Smartphone</option>
                                <option value="Printer">Printer</option>
                                <option value="Component">Component / Graphic Card</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Brand</label>
                            <select name="brand" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                                <option value="ASUS">ASUS</option>
                                <option value="Dell">Dell</option>
                                <option value="MSI">MSI</option>
                                <option value="Logitech">Logitech</option>
                                <option value="Apple">Apple</option>
                                <option value="HP">HP</option>
                                <option value="Canon">Canon</option>
                                <option value="Samsung">Samsung</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Model</label>
                            <input type="text" name="model" placeholder="Enter model (e.g. ASUS TUF Gaming Laptop)" required
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        </div>

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Serial Number</label>
                            <input type="text" name="serial_number" placeholder="Enter device serial number"
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none font-mono">
                        </div>

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Issue Description</label>
                            <textarea name="issue_description" rows="2" placeholder="Describe the problem in detail..." required
                                      class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none"></textarea>
                        </div>

                        <div class="pt-2 flex items-center gap-2">
                            <button type="button" onclick="Swal.fire('Upload Images', 'រូបភាពឧបករណ៍ត្រូវបានជ្រើសរើស', 'info')" class="flex-1 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl font-semibold flex items-center justify-center gap-1.5 transition">
                                <i class="fa-regular fa-image"></i> Upload Images
                            </button>
                            <button type="submit" class="flex-1 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-sm flex items-center justify-center gap-1.5 transition">
                                <i class="fa-solid fa-plus"></i> Create Request
                            </button>
                        </div>
                    </form>
                </div>

                {{-- PANEL 2: Repair Details Card (4 cols) --}}
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4" id="repairDetailsSection">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-blue-600"></i> Repair Details
                        </h3>
                        <button type="button" onclick="scrollToTable()" class="text-xs text-blue-600 hover:underline font-semibold flex items-center gap-1">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to List
                        </button>
                    </div>

                    <!-- Device summary banner matching Mockup 1 -->
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center gap-3">
                        <img id="detailDeviceImg" src="https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=120&h=120&q=80"
                             alt="Device" class="w-12 h-12 rounded-lg object-cover bg-white border border-slate-100 flex-shrink-0">
                        <div class="min-w-0 flex-1">
                            <h4 class="text-xs font-extrabold text-slate-900 truncate" id="detailModelText">{{ $featuredRepair->model ?? 'ASUS TUF Gaming Laptop' }}</h4>
                            <p class="text-[10px] text-slate-400 font-mono">SKU: ASUS-TUF-001 &bull; Serial: <span id="detailSerialText">{{ $featuredRepair->serial_number ?? 'SN123456789' }}</span></p>
                        </div>
                    </div>

                    <!-- Customer row -->
                    <div class="flex items-center justify-between text-xs py-1 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-bold">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-[11px]" id="detailCustomerText">{{ $featuredRepair->customer->name ?? 'Sok Dara' }}</p>
                                <p class="text-[10px] text-slate-400" id="detailPhoneText">{{ $featuredRepair->customer->phone ?? '+855 12 345 678' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-slate-400">Repair ID: <span class="font-bold text-blue-600 font-mono" id="detailRepairCodeText">{{ $featuredRepair->repair_code ?? 'RE-2025-0098' }}</span></p>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-sky-50 text-sky-600 border border-sky-200" id="detailStatusBadge">
                                {{ $featuredRepair->status ?? 'Diagnosing' }}
                            </span>
                        </div>
                    </div>

                    <!-- Tabs: Repair Info / Spare Parts / History / Notes -->
                    <div class="flex items-center gap-2 border-b border-slate-100 text-[11px] font-semibold">
                        <button type="button" class="pb-1.5 border-b-2 border-blue-600 text-blue-600">Repair Info</button>
                        <button type="button" onclick="openSparePartsModal()" class="pb-1.5 text-slate-400 hover:text-slate-600">Spare Parts ({{ $featuredRepair ? $featuredRepair->parts->count() : 1 }})</button>
                        <button type="button" onclick="Swal.fire('History', 'ប្រវត្តិប្រតិបត្តិការជួសជុល', 'info')" class="pb-1.5 text-slate-400 hover:text-slate-600">History</button>
                        <button type="button" onclick="Swal.fire('Notes', 'កំណត់ត្រាផ្ទៃក្នុងរបស់ជាង', 'info')" class="pb-1.5 text-slate-400 hover:text-slate-600">Notes</button>
                    </div>

                    <!-- Issue & Diagnosis matching Mockup 1 -->
                    <div class="space-y-2 text-xs">
                        <div>
                            <span class="text-slate-400 text-[10px] block">Issue Description</span>
                            <p class="font-medium text-slate-800 bg-slate-50 p-2 rounded-lg border border-slate-100" id="detailIssueText">
                                {{ $featuredRepair->issue_description ?? 'Laptop is overheating when playing games.' }}
                            </p>
                        </div>

                        <div>
                            <span class="text-slate-400 text-[10px] block">Diagnosis</span>
                            <p class="font-medium text-slate-800 bg-slate-50 p-2 rounded-lg border border-slate-100" id="detailDiagnosisText">
                                {{ $featuredRepair->diagnosis ?? 'Checking the cooling system and thermal paste.' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-2 pt-1">
                            <div>
                                <span class="text-slate-400 text-[10px]">Estimated Cost</span>
                                <p class="font-extrabold text-blue-600 font-mono text-sm" id="detailCostText">
                                    ${{ number_format($featuredRepair->estimated_cost ?? 65, 2) }}
                                </p>
                            </div>
                            <div>
                                <span class="text-slate-400 text-[10px]">Estimated Completion</span>
                                <p class="font-mono text-slate-700 text-xs font-semibold" id="detailCompletionText">
                                    {{ $featuredRepair && $featuredRepair->estimated_completion ? $featuredRepair->estimated_completion->format('Y-m-d') : '2025-09-12' }}
                                </p>
                            </div>
                        </div>

                        <div class="pt-2 flex items-center gap-2">
                            <button type="button" onclick="openSparePartsModal()" class="flex-1 py-2 bg-indigo-50 border border-indigo-200 text-indigo-700 rounded-xl text-xs font-semibold hover:bg-indigo-100 transition flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-microchip"></i> Add Spare Part
                            </button>
                            <button type="button" onclick="printRepairTicketCurrent()" class="flex-1 py-2 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-print"></i> Ticket Slip
                            </button>
                        </div>
                    </div>
                </div>

                {{-- PANEL 3: Update Repair Status (4 cols) --}}
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4" id="statusUpdateSection">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-timeline text-blue-600"></i> Update Repair Status
                    </h3>

                    <!-- Status Stepper Timeline matching Mockup 1 -->
                    <div class="relative pl-6 space-y-3.5 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200 text-xs">
                        
                        <!-- Step 1: Received -->
                        <div class="relative flex items-start gap-2.5">
                            <div class="absolute -left-6 w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] ring-4 ring-white">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Received</p>
                                <p class="text-[10px] text-slate-400">Device received and logged into system</p>
                            </div>
                        </div>

                        <!-- Step 2: Diagnosing -->
                        <div class="relative flex items-start gap-2.5">
                            <div class="absolute -left-6 w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] ring-4 ring-white">
                                <i class="fa-solid fa-stethoscope"></i>
                            </div>
                            <div>
                                <p class="font-bold text-blue-600">Diagnosing</p>
                                <p class="text-[10px] text-slate-400">Technician is checking the issue</p>
                            </div>
                        </div>

                        <!-- Step 3: Waiting for Parts -->
                        <div class="relative flex items-start gap-2.5 opacity-60">
                            <div class="absolute -left-6 w-5 h-5 rounded-full bg-slate-300 text-slate-600 flex items-center justify-center text-[10px] ring-4 ring-white">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-700">Waiting for Parts</p>
                                <p class="text-[10px] text-slate-400">Parts not available yet</p>
                            </div>
                        </div>

                        <!-- Step 4: Repairing -->
                        <div class="relative flex items-start gap-2.5 opacity-60">
                            <div class="absolute -left-6 w-5 h-5 rounded-full bg-slate-300 text-slate-600 flex items-center justify-center text-[10px] ring-4 ring-white">
                                <i class="fa-solid fa-screwdriver"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-700">Repairing</p>
                                <p class="text-[10px] text-slate-400">In progress</p>
                            </div>
                        </div>

                        <!-- Step 5: Testing -->
                        <div class="relative flex items-start gap-2.5 opacity-60">
                            <div class="absolute -left-6 w-5 h-5 rounded-full bg-slate-300 text-slate-600 flex items-center justify-center text-[10px] ring-4 ring-white">
                                <i class="fa-solid fa-vial"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-700">Testing</p>
                                <p class="text-[10px] text-slate-400">Pending</p>
                            </div>
                        </div>

                        <!-- Step 6: Completed -->
                        <div class="relative flex items-start gap-2.5 opacity-60">
                            <div class="absolute -left-6 w-5 h-5 rounded-full bg-slate-300 text-slate-600 flex items-center justify-center text-[10px] ring-4 ring-white">
                                <i class="fa-solid fa-flag-checkered"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-700">Completed</p>
                                <p class="text-[10px] text-slate-400">Pending pickup</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Selection and Submission Form -->
                    <form id="updateStatusForm" onsubmit="submitStatusUpdate(event)" class="space-y-3 pt-2 text-xs border-t border-slate-100">
                        <input type="hidden" id="statusUpdateRepairId" value="{{ $featuredRepair->id ?? 1 }}">
                        
                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Set New Status</label>
                            <select id="newStatusSelect" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                                <option value="Received">Received</option>
                                <option value="Diagnosing" selected>Diagnosing</option>
                                <option value="Waiting for Parts">Waiting for Parts</option>
                                <option value="Repairing">Repairing</option>
                                <option value="Testing">Testing</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Assign Technician</label>
                            <select id="assignTechSelect" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                                @foreach($technicians as $tech)
                                    <option value="{{ $tech->id }}" {{ $tech->name == 'Chan Vutha' ? 'selected' : '' }}>
                                        {{ $tech->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-arrow-rotate-right"></i> Update Status
                        </button>
                    </form>
                </div>

            </div>

        </main>
    </div>

</div>

{{-- ========================================================================= --}}
{{-- 3. MODAL: ADD SPARE PART & DIAGNOSIS (Step 5.2)                           --}}
{{-- ========================================================================= --}}
<div id="sparePartModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 no-print">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-5 relative border border-slate-200 text-xs">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <h4 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-microchip text-blue-600"></i> Add Spare Part (កាត់ស្តុកគ្រឿងបន្លាស់)
            </h4>
            <button onclick="closeSparePartsModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <form onsubmit="submitAddSparePart(event)" class="space-y-3 pt-3">
            <div>
                <label class="font-bold text-slate-700 block mb-1">ជ្រើសរើសគ្រឿងបន្លាស់ (From Products Stock)</label>
                <select id="modalPartSelect" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                    @foreach($spareParts as $sp)
                        <option value="{{ $sp->id }}" data-price="{{ $sp->selling_price }}" data-stock="{{ $sp->stock_quantity }}">
                            {{ $sp->name }} &bull; ${{ number_format($sp->selling_price, 2) }} (ស្តុកនៅសល់: {{ $sp->stock_quantity }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-bold text-slate-700 block mb-1">ចំនួន (Quantity)</label>
                <input type="number" id="modalPartQty" value="1" min="1" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
            </div>

            <p class="text-[11px] text-slate-400 italic">
                * ចំណាំ៖ ការបន្ថែមគ្រឿងបន្លាស់នឹងកាត់ស្តុកចេញពី Products និងកត់ត្រាចូល Inventory Transactions (Stock Out) ស្វ័យប្រវត្តិ។
            </p>

            <div class="pt-2 flex items-center justify-end gap-2">
                <button type="button" onclick="closeSparePartsModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 font-semibold hover:bg-slate-50">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-sm">
                    Confirm &amp; Deduct Stock
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 4. MODAL: REPAIR TICKET SLIP (Step 5.3)                                   --}}
{{-- ========================================================================= --}}
<div id="repairTicketModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 overflow-y-auto no-print">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-5 relative border border-slate-200">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-3">
            <h4 class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <i class="fa-solid fa-receipt text-blue-600"></i> Repair Ticket Slip Preview (ប័ណ្ណទទួលជួសជុល)
            </h4>
            <button onclick="closeRepairTicketModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <div id="printableTicketModal" class="receipt-font text-[11px] text-black bg-white p-3 border border-dashed border-slate-300 rounded-lg">
            <div class="text-center pb-2 border-b border-black">
                <h2 class="text-sm font-bold tracking-widest uppercase">TECHZONE REPAIR CENTER</h2>
                <p class="text-[9.5px]">Computer Shop Management System</p>
                <p class="text-[9px]">Tel: +855 12 345 678 &bull; Phnom Penh</p>
                <h3 class="text-xs font-bold mt-1 uppercase">REPAIR TICKET SLIP</h3>
            </div>

            <div class="py-2 border-b border-black space-y-0.5 text-[10px]">
                <div class="flex justify-between">
                    <span>Ticket Code:</span>
                    <span class="font-bold" id="ticketCodeDisplay">RE-2025-0098</span>
                </div>
                <div class="flex justify-between">
                    <span>Customer:</span>
                    <span class="font-bold" id="ticketCustDisplay">Sok Dara</span>
                </div>
                <div class="flex justify-between">
                    <span>Phone:</span>
                    <span id="ticketPhoneDisplay">+855 12 345 678</span>
                </div>
                <div class="flex justify-between">
                    <span>Device:</span>
                    <span class="font-bold" id="ticketDeviceDisplay">ASUS TUF Gaming Laptop</span>
                </div>
                <div class="flex justify-between">
                    <span>Serial No:</span>
                    <span id="ticketSerialDisplay">SN123456789</span>
                </div>
                <div class="flex justify-between">
                    <span>Technician:</span>
                    <span id="ticketTechDisplay">Chan Vutha</span>
                </div>
                <div class="flex justify-between">
                    <span>Est. Ready:</span>
                    <span class="font-bold" id="ticketEstReadyDisplay">2025-09-12</span>
                </div>
            </div>

            <div class="py-2 border-b border-black text-[10px]">
                <span class="font-bold">Issue Reported:</span>
                <p class="italic text-[9.5px] mt-0.5" id="ticketIssueDisplay">Overheating and thermal throttling</p>
            </div>

            <div class="pt-2 flex justify-between font-bold text-xs">
                <span>Est. Cost:</span>
                <span id="ticketCostDisplay">$65.00</span>
            </div>

            <div class="text-center pt-3 mt-2 border-t border-dotted border-slate-400">
                <p class="text-[9px] font-bold">Please present this slip upon claiming your device.</p>
                <div class="flex justify-center mt-2">
                    <svg id="ticketBarcodeSvg" class="max-w-full h-9"></svg>
                </div>
                <p class="text-[8px] font-mono tracking-wider text-slate-500 mt-0.5" id="ticketBarcodeText">RE-2025-0098</p>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-end gap-2">
            <button type="button" onclick="closeRepairTicketModal()" class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600">Close</button>
            <button type="button" onclick="window.print()" class="px-4 py-1.5 rounded-xl bg-blue-600 text-xs font-semibold text-white flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-print"></i> Print Ticket
            </button>
        </div>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 5. JAVASCRIPT STATE ENGINE FOR REPAIRS                                    --}}
{{-- ========================================================================= --}}
<script>
    let currentSelectedRepairId = {{ $featuredRepair->id ?? 1 }};

    document.addEventListener('DOMContentLoaded', () => {
        initRepairStatusChart();
    });

    function initRepairStatusChart() {
        const ctx = document.getElementById('repairStatusDonutChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Diagnosing', 'Waiting for Parts', 'Repairing', 'Testing', 'Completed', 'Cancelled'],
                datasets: [{
                    data: [18, 4, 11, 3, 10, 2],
                    backgroundColor: [
                        '#38BDF8', // Sky for Diagnosing
                        '#FBBF24', // Amber for Waiting
                        '#2563EB', // Blue for Repairing
                        '#4F46E5', // Indigo for Testing
                        '#10B981', // Emerald for Completed
                        '#F43F5E'  // Rose for Cancelled
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
                    legend: { display: false }
                }
            }
        });
    }

    async function selectRepairForPreview(repairId) {
        currentSelectedRepairId = repairId;
        document.getElementById('statusUpdateRepairId').value = repairId;

        try {
            const res = await fetch(`/repairs/${repairId}`);
            const data = await res.json();
            if (data.success) {
                const r = data.repair;
                document.getElementById('detailModelText').textContent = r.model;
                document.getElementById('detailSerialText').textContent = r.serial_number || 'N/A';
                document.getElementById('detailCustomerText').textContent = r.customer ? r.customer.name : 'Walk-in';
                document.getElementById('detailPhoneText').textContent = r.customer ? r.customer.phone : 'N/A';
                document.getElementById('detailRepairCodeText').textContent = r.repair_code;
                document.getElementById('detailStatusBadge').textContent = r.status;
                document.getElementById('detailIssueText').textContent = r.issue_description;
                document.getElementById('detailDiagnosisText').textContent = r.diagnosis || 'Pending inspection by technician';
                document.getElementById('detailCostText').textContent = `$${parseFloat(r.total_cost || r.estimated_cost || 0).toFixed(2)}`;
                document.getElementById('detailCompletionText').textContent = r.estimated_completion || 'TBD';

                document.getElementById('newStatusSelect').value = r.status;
                if (r.technician_id) {
                    document.getElementById('assignTechSelect').value = r.technician_id;
                }

                document.getElementById('repairDetailsSection').scrollIntoView({ behavior: 'smooth' });
            }
        } catch (e) {
            console.error(e);
        }
    }

    async function submitStatusUpdate(event) {
        event.preventDefault();
        const repairId = document.getElementById('statusUpdateRepairId').value;
        const status = document.getElementById('newStatusSelect').value;
        const techId = document.getElementById('assignTechSelect').value;

        try {
            const res = await fetch(`/repairs/${repairId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: status,
                    technician_id: techId
                })
            });

            const data = await res.json();
            if (data.success) {
                Swal.fire('ជោគជ័យ!', 'ស្ថានភាពត្រូវបានកែប្រែរួចរាល់', 'success')
                    .then(() => location.reload());
            } else {
                Swal.fire('បរាជ័យ', data.message || 'មិនអាចកែប្រែស្ថានភាពបានទេ', 'error');
            }
        } catch (e) {
            Swal.fire('កំហុស', 'មិនអាចភ្ជាប់ម៉ាស៊ីនបម្រើបានទេ', 'error');
        }
    }

    function openSparePartsModal() {
        document.getElementById('sparePartModalBackdrop').classList.remove('hidden');
    }

    function closeSparePartsModal() {
        document.getElementById('sparePartModalBackdrop').classList.add('hidden');
    }

    async function submitAddSparePart(e) {
        e.preventDefault();
        const prodId = document.getElementById('modalPartSelect').value;
        const qty = document.getElementById('modalPartQty').value;

        try {
            const res = await fetch(`/repairs/${currentSelectedRepairId}/parts`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: prodId,
                    quantity: qty
                })
            });

            const data = await res.json();
            if (data.success) {
                closeSparePartsModal();
                Swal.fire('ជោគជ័យ!', data.message, 'success')
                    .then(() => selectRepairForPreview(currentSelectedRepairId));
            } else {
                Swal.fire('បរាជ័យ', data.message, 'error');
            }
        } catch (e) {
            Swal.fire('កំហុស', 'មិនអាចកាត់ស្តុកគ្រឿងបន្លាស់បានឡើយ', 'error');
        }
    }

    async function printRepairTicket(repairId) {
        try {
            const res = await fetch(`/repairs/${repairId}`);
            const data = await res.json();
            if (data.success) {
                const r = data.repair;
                document.getElementById('ticketCodeDisplay').textContent = r.repair_code;
                document.getElementById('ticketCustDisplay').textContent = r.customer ? r.customer.name : 'Walk-in';
                document.getElementById('ticketPhoneDisplay').textContent = r.customer ? r.customer.phone : 'N/A';
                document.getElementById('ticketDeviceDisplay').textContent = r.model;
                document.getElementById('ticketSerialDisplay').textContent = r.serial_number || 'N/A';
                document.getElementById('ticketTechDisplay').textContent = r.technician ? r.technician.name : 'Staff';
                document.getElementById('ticketEstReadyDisplay').textContent = r.estimated_completion || 'In 3 days';
                document.getElementById('ticketIssueDisplay').textContent = r.issue_description;
                document.getElementById('ticketCostDisplay').textContent = `$${parseFloat(r.total_cost || r.estimated_cost || 0).toFixed(2)}`;
                document.getElementById('ticketBarcodeText').textContent = r.repair_code;

                try {
                    JsBarcode("#ticketBarcodeSvg", r.repair_code, {
                        format: "CODE128",
                        width: 1.5,
                        height: 35,
                        displayValue: false
                    });
                } catch (e) {}

                document.getElementById('repairTicketModalBackdrop').classList.remove('hidden');
            }
        } catch (e) {
            Swal.fire('កំហុស', 'មិនអាចទាញទិន្នន័យប័ណ្ណជួសជុលបានឡើយ', 'error');
        }
    }

    function printRepairTicketCurrent() {
        printRepairTicket(currentSelectedRepairId);
    }

    function closeRepairTicketModal() {
        document.getElementById('repairTicketModalBackdrop').classList.add('hidden');
    }

    function openDiagnosisModalForFeatured() {
        Swal.fire({
            title: 'បញ្ចូលការវិនិច្ឆ័យ (Diagnosis)',
            input: 'textarea',
            inputPlaceholder: 'បញ្ចូលលទ្ធផលត្រួតពិនិត្យ និងមូលហេតុខូច...',
            showCancelButton: true,
            confirmButtonText: 'រក្សាទុក',
            confirmButtonColor: '#2563EB'
        }).then(async (result) => {
            if (result.isConfirmed && result.value) {
                await fetch(`/repairs/${currentSelectedRepairId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: 'Diagnosing',
                        diagnosis: result.value
                    })
                });
                Swal.fire('ជោគជ័យ', 'ការវិនិច្ឆ័យត្រូវបានកត់ត្រា', 'success')
                    .then(() => location.reload());
            }
        });
    }

    function scanSerialPrompt() {
        Swal.fire({
            title: 'ស្កេន Serial Number',
            input: 'text',
            inputPlaceholder: 'ស្កេន ឬបញ្ចូល Serial Number...',
            showCancelButton: true,
            confirmButtonText: 'ស្វែងរក',
            confirmButtonColor: '#2563EB'
        }).then(res => {
            if (res.isConfirmed && res.value) {
                document.getElementById('filterSearch').value = res.value;
                applyFilters();
            }
        });
    }

    function applyFilters() {
        const search = document.getElementById('filterSearch').value || document.getElementById('topNavSearch').value;
        const status = document.getElementById('filterStatus').value;
        const tech = document.getElementById('filterTechnician').value;
        const dateFrom = document.getElementById('filterDateFrom').value;
        const dateTo = document.getElementById('filterDateTo').value;

        const p = new URLSearchParams();
        if (search) p.append('search', search);
        if (status && status !== 'all') p.append('status', status);
        if (tech && tech !== 'all') p.append('technician_id', tech);
        if (dateFrom) p.append('date_from', dateFrom);
        if (dateTo) p.append('date_to', dateTo);

        window.location.href = "{{ route('repair.service') }}?" + p.toString();
    }

    function scrollToNewRequest() {
        document.getElementById('createRequestSection').scrollIntoView({ behavior: 'smooth' });
    }

    function scrollToTable() {
        document.getElementById('tableFilterSection').scrollIntoView({ behavior: 'smooth' });
    }

    function scrollToStatusUpdate() {
        document.getElementById('statusUpdateSection').scrollIntoView({ behavior: 'smooth' });
    }

    function openNewCustomerModal() {
        Swal.fire({
            title: '+ New Customer',
            html: `
                <div class="space-y-2 text-left text-xs">
                    <div>
                        <label class="font-bold">ឈ្មោះអតិថិជន *</label>
                        <input id="swalName" class="w-full mt-1 p-2 border rounded-xl" placeholder="ឧ. Heng Sovann">
                    </div>
                    <div>
                        <label class="font-bold">លេខទូរស័ព្ទ *</label>
                        <input id="swalPhone" class="w-full mt-1 p-2 border rounded-xl" placeholder="ឧ. +855 12 345 678">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'បង្កើត',
            confirmButtonColor: '#2563EB',
            preConfirm: () => {
                const name = document.getElementById('swalName').value;
                const phone = document.getElementById('swalPhone').value;
                if (!name) Swal.showValidationMessage('សូមបញ្ចូលឈ្មោះអតិថិជន');
                return { name, phone };
            }
        }).then(async res => {
            if (res.isConfirmed) {
                try {
                    await fetch("{{ route('customers.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            name: res.value.name,
                            phone: res.value.phone || 'N/A',
                            customer_type: 'Retail',
                            points: 0,
                            status: 'Active'
                        })
                    });
                    location.reload();
                } catch (e) {}
            }
        });
    }
</script>

</body>
</html>
