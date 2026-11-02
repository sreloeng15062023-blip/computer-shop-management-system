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
    {{-- 1. TECHZONE SIDEBAR NAVIGATION                                           --}}
    {{-- ========================================================================= --}}
    @include('sidebar')

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

            {{-- 2.1 Header Row --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shadow-md shadow-blue-500/20">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 leading-tight">Repair Service Management</h2>
                        <p class="text-xs text-slate-400 font-medium">Manage repair requests, diagnosis, technicians, and service status</p>
                    </div>
                </div>

                <!-- + New Repair Request Button (Opens Popup Modal) -->
                <button type="button" onclick="openAddModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-blue-600/20 hover:shadow-lg transition active:scale-95">
                    <i class="fa-solid fa-plus text-xs"></i> New Repair Request
                </button>
            </div>

            {{-- 2.2 FIVE STAT CARDS --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-3.5">
                <!-- Card 1: Total Repair Orders -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Orders</span>
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900 font-mono">{{ $totalOrders }}</h3>
                        <p class="text-[10px] text-emerald-600 font-semibold mt-0.5 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up text-[9px]"></i> +12% (This month)
                        </p>
                    </div>
                </div>

                <!-- Card 2: In Progress -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">In Progress</span>
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900 font-mono">{{ $inProgressCount }}</h3>
                        <p class="text-[10px] text-amber-600 font-semibold mt-0.5 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up text-[9px]"></i> +5%
                        </p>
                    </div>
                </div>

                <!-- Card 3: Completed -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Completed</span>
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900 font-mono">{{ $completedCount }}</h3>
                        <p class="text-[10px] text-emerald-600 font-semibold mt-0.5 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up text-[9px]"></i> +20%
                        </p>
                    </div>
                </div>

                <!-- Card 4: Waiting for Parts -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Waiting for Parts</span>
                        <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900 font-mono">{{ $waitingPartsCount }}</h3>
                        <p class="text-[10px] text-rose-500 font-semibold mt-0.5 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-up text-[9px]"></i> +33%
                        </p>
                    </div>
                </div>

                <!-- Card 5: Cancelled -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Cancelled</span>
                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-ban"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900 font-mono">{{ $cancelledCount }}</h3>
                        <p class="text-[10px] text-slate-400 font-semibold mt-0.5 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-down text-[9px]"></i> -50%
                        </p>
                    </div>
                </div>
            </div>

            {{-- ================================================================= --}}
            {{-- 2.3 REPAIR STATUS & QUICK ACTIONS (IN ONE HORIZONTAL ROW)         --}}
            {{-- ================================================================= --}}
            @php
                $rawDiag = $statusCounts['Diagnosing'] ?? 0;
                $rawWait = $statusCounts['Waiting for Parts'] ?? 0;
                $rawRep  = $statusCounts['Repairing'] ?? 0;
                $rawTest = $statusCounts['Testing'] ?? 0;
                $rawComp = $statusCounts['Completed'] ?? 0;
                $rawCanc = $statusCounts['Cancelled'] ?? 0;
                $sumRaw  = $rawDiag + $rawWait + $rawRep + $rawTest + $rawComp + $rawCanc;

                $dispDiag = $sumRaw > 0 ? $rawDiag : 18;
                $dispWait = $sumRaw > 0 ? $rawWait : 4;
                $dispRep  = $sumRaw > 0 ? $rawRep : 11;
                $dispTest = $sumRaw > 0 ? $rawTest : 3;
                $dispComp = $sumRaw > 0 ? $rawComp : 10;
                $dispCanc = $sumRaw > 0 ? $rawCanc : 2;
                $totalDisp = max(1, $dispDiag + $dispWait + $dispRep + $dispTest + $dispComp + $dispCanc);
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

                <!-- 1. Repair Status Card (Donut Chart & Breakdown) -->
                <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <h3 class="text-xs font-bold text-slate-800 flex items-center gap-1.5 uppercase tracking-wider">
                            <i class="fa-solid fa-chart-pie text-blue-600"></i> Repair Status Overview
                        </h3>
                        <span class="text-[11px] text-slate-400 font-medium">Real-time status breakdown</span>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-6 pt-3">
                        <!-- Donut Chart -->
                        <div class="relative w-40 h-40 flex-shrink-0 flex items-center justify-center">
                            <canvas id="repairStatusDonutChart"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                <span class="text-base font-extrabold text-slate-900 font-mono">{{ $totalOrders }}</span>
                                <span class="text-[9px] uppercase tracking-wider text-slate-400 font-bold">Total Orders</span>
                            </div>
                        </div>

                        <!-- Status Breakdown Legend List -->
                        <div class="grid grid-cols-2 gap-x-6 gap-y-2.5 flex-1 w-full text-xs">
                            <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50/70 border border-slate-100">
                                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-sky-400"></span> Diagnosing</span>
                                <span class="font-mono text-slate-700 font-bold">{{ $dispDiag }} ({{ round(($dispDiag / $totalDisp) * 100, 1) }}%)</span>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50/70 border border-slate-100">
                                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span> Waiting for Parts</span>
                                <span class="font-mono text-slate-700 font-bold">{{ $dispWait }} ({{ round(($dispWait / $totalDisp) * 100, 1) }}%)</span>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50/70 border border-slate-100">
                                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> Repairing</span>
                                <span class="font-mono text-slate-700 font-bold">{{ $dispRep }} ({{ round(($dispRep / $totalDisp) * 100, 1) }}%)</span>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50/70 border border-slate-100">
                                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span> Testing</span>
                                <span class="font-mono text-slate-700 font-bold">{{ $dispTest }} ({{ round(($dispTest / $totalDisp) * 100, 1) }}%)</span>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50/70 border border-slate-100">
                                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Completed</span>
                                <span class="font-mono text-slate-700 font-bold">{{ $dispComp }} ({{ round(($dispComp / $totalDisp) * 100, 1) }}%)</span>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50/70 border border-slate-100">
                                <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span> Cancelled</span>
                                <span class="font-mono text-slate-700 font-bold">{{ $dispCanc }} ({{ round(($dispCanc / $totalDisp) * 100, 1) }}%)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Quick Actions Card -->
                <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <h3 class="text-xs font-bold text-slate-800 flex items-center gap-1.5 uppercase tracking-wider">
                            <i class="fa-solid fa-bolt text-amber-500"></i> Quick Actions
                        </h3>
                        <span class="text-[11px] text-slate-400 font-medium">Fast shortcuts</span>
                    </div>

                    <div class="grid grid-cols-2 gap-2.5 text-xs">
                        <button type="button" onclick="openAddModal()" class="flex items-center gap-2.5 p-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-sm shadow-blue-500/20 transition active:scale-95">
                            <i class="fa-solid fa-plus text-xs"></i> New Request
                        </button>
                        <button type="button" onclick="scanSerialPrompt()" class="flex items-center gap-2.5 p-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold shadow-sm shadow-purple-500/20 transition active:scale-95">
                            <i class="fa-solid fa-barcode text-xs"></i> Scan Serial
                        </button>
                        <a href="{{ route('warranty') }}" class="flex items-center gap-2.5 p-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow-sm shadow-emerald-500/20 transition active:scale-95">
                            <i class="fa-solid fa-shield-halved text-xs"></i> Check Warranty
                        </a>
                        <button type="button" onclick="scrollToTable()" class="flex items-center gap-2.5 p-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold shadow-sm shadow-amber-500/20 transition active:scale-95">
                            <i class="fa-solid fa-clock-rotate-left text-xs"></i> Orders List
                        </button>
                    </div>

                    <!-- Mini Recent Orders snippet -->
                    <div class="pt-2 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] font-bold text-slate-700 uppercase tracking-wider">Recent Orders</span>
                            <a href="javascript:void(0)" onclick="scrollToTable()" class="text-[11px] text-blue-600 hover:underline">View All &rarr;</a>
                        </div>
                        <div class="space-y-1.5">
                            @foreach($repairs->take(2) as $mini)
                                <div class="p-2 rounded-xl bg-slate-50 hover:bg-slate-100/80 transition flex items-center justify-between cursor-pointer text-xs" onclick="openViewModal({{ $mini->id }})">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-bold">
                                            <i class="fa-solid fa-wrench"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold text-blue-600 font-mono text-[11px]">{{ $mini->repair_code }}</span>
                                            <span class="text-slate-700 font-semibold ml-1.5 text-[11px]">{{ $mini->model }}</span>
                                        </div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-white border border-slate-200 text-slate-600">
                                        {{ $mini->status }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            {{-- ================================================================= --}}
            {{-- 2.4 FULL-WIDTH REPAIR ORDERS TABLE (LIKE BRAND MANAGEMENT PAGE)    --}}
            {{-- ================================================================= --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden" id="tableSection">

                <!-- Filter Header Bar -->
                <div class="p-4 border-b border-slate-200/80 bg-slate-50/50 flex flex-col xl:flex-row items-stretch xl:items-center justify-between gap-3 text-xs" id="tableFilterSection">
                    <div class="flex items-center gap-3">
                        <span class="font-extrabold text-slate-900 text-sm">Repair Orders</span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-200">
                            {{ $repairs->total() }} total
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5 flex-1 xl:justify-end">
                        <div class="relative flex-1 sm:max-w-xs">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" id="filterSearch" value="{{ request('search') }}"
                                   placeholder="Search repair ID, customer, device..."
                                   onkeyup="if(event.key==='Enter') applyFilters()"
                                   class="w-full pl-8 pr-3 py-2 bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-none transition">
                        </div>

                        <!-- Status Filter -->
                        <select id="filterStatus" onchange="applyFilters()" class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 focus:outline-none">
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
                        <select id="filterTechnician" onchange="applyFilters()" class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 focus:outline-none">
                            <option value="all">All Technicians</option>
                            @foreach($technicians as $tech)
                                <option value="{{ $tech->id }}" {{ request('technician_id') == $tech->id ? 'selected' : '' }}>
                                    {{ $tech->name }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Date range -->
                        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-slate-600 font-mono text-[11px]">
                            <input type="date" id="filterDateFrom" value="{{ request('date_from', '2025-08-01') }}" onchange="applyFilters()" class="bg-transparent focus:outline-none">
                            <span class="text-slate-400">&rarr;</span>
                            <input type="date" id="filterDateTo" value="{{ request('date_to', date('Y-m-d')) }}" onchange="applyFilters()" class="bg-transparent focus:outline-none">
                        </div>

                        <button type="button" onclick="applyFilters()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition">
                            Filter
                        </button>
                        <a href="{{ route('repair.service') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition flex items-center gap-1">
                            <i class="fa-solid fa-rotate-left"></i> Reset
                        </a>
                    </div>
                </div>

                <!-- Full-Width Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs text-slate-600">
                        <thead>
                            <tr class="bg-slate-50/75 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-4 w-10 text-center"><input type="checkbox" class="rounded text-blue-600"></th>
                                <th class="py-3.5 px-4 w-12 text-center">#</th>
                                <th class="py-3.5 px-4">Repair ID</th>
                                <th class="py-3.5 px-4">Customer</th>
                                <th class="py-3.5 px-4">Device</th>
                                <th class="py-3.5 px-4">Issue Description</th>
                                <th class="py-3.5 px-4 text-center">Status</th>
                                <th class="py-3.5 px-4">Technician</th>
                                <th class="py-3.5 px-4">Created Date</th>
                                <th class="py-3.5 px-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($repairs as $idx => $r)
                                <tr class="hover:bg-slate-50/80 transition cursor-pointer" onclick="openViewModal({{ $r->id }})">
                                    <td class="py-3.5 px-4 text-center" onclick="event.stopPropagation()">
                                        <input type="checkbox" class="rounded text-blue-600">
                                    </td>
                                    <td class="py-3.5 px-4 text-center text-slate-400 font-mono">
                                        {{ $repairs->firstItem() ? ($repairs->firstItem() + $idx) : ($idx + 1) }}
                                    </td>
                                    <td class="py-3.5 px-4 font-mono font-bold text-blue-600">
                                        {{ $r->repair_code }}
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-800">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-[10px] font-bold shrink-0">
                                                <i class="fa-regular fa-user"></i>
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800">{{ $r->customer->name ?? 'Walk-in' }}</div>
                                                <div class="text-[10px] text-slate-400 font-normal">{{ $r->customer->phone ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-700">
                                        <div class="font-bold text-slate-900 truncate max-w-[150px]" title="{{ $r->model }}">{{ $r->model }}</div>
                                        <div class="text-[10px] text-slate-400 font-mono">SN: {{ $r->serial_number ?: 'N/A' }}</div>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-500">
                                        <p class="truncate max-w-[200px]" title="{{ $r->issue_description }}">{{ $r->issue_description }}</p>
                                    </td>
                                    
                                    <!-- Status Badges -->
                                    <td class="py-3.5 px-4 text-center">
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

                                    <td class="py-3.5 px-4 text-slate-600">
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-5 h-5 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-[9px] font-bold">
                                                {{ substr($r->technician->name ?? 'U', 0, 1) }}
                                            </div>
                                            <span>{{ $r->technician->name ?? 'Unassigned' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-slate-500">
                                        {{ $r->created_at->format('Y-m-d H:i') }}
                                    </td>
                                    
                                    <!-- Action Buttons matching Brand page -->
                                    <td class="py-3.5 px-4 text-center" onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- View Details Button -->
                                            <button type="button" onclick="openViewModal({{ $r->id }})" class="w-8 h-8 rounded-lg bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center transition shadow-2xs" title="View Repair Details">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </button>

                                            <!-- Edit/Update Status Button -->
                                            <button type="button" onclick="openEditStatusModal({{ $r->id }})" class="w-8 h-8 rounded-lg bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition shadow-2xs" title="Update Repair Status">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </button>

                                            <!-- Print Ticket Slip Button -->
                                            <button type="button" onclick="printRepairTicket({{ $r->id }})" class="w-8 h-8 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white flex items-center justify-center transition shadow-2xs" title="Print 80mm Ticket Slip">
                                                <i class="fa-solid fa-print text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="py-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-solid fa-inbox text-3xl mb-2 text-slate-300"></i>
                                            <p class="font-medium">មិនមានកំណត់ត្រាជួសជុលត្រូវនឹងលក្ខខណ្ឌស្វែងរកឡើយ</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="p-4 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 bg-slate-50/30">
                    <div>
                        Showing {{ $repairs->firstItem() ?? 0 }} to {{ $repairs->lastItem() ?? 0 }} of {{ $repairs->total() }} entries
                    </div>
                    <div>
                        {{ $repairs->links() }}
                    </div>
                </div>

            </div>

        </main>
    </div>

</div>

{{-- ========================================================================= --}}
{{-- 3. POPUP MODAL: CREATE REPAIR REQUEST (FORM MODAL LIKE BRAND ADD)          --}}
{{-- ========================================================================= --}}
<div id="addModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                    <i class="fa-solid fa-wrench"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 leading-tight">Create Repair Request</h3>
                    <p class="text-xs text-slate-500">Record device issues, customer info and assign technician</p>
                </div>
            </div>
            <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Form Body -->
        <form action="{{ route('repairs.store') }}" method="POST" class="p-6 space-y-4 overflow-y-auto flex-1 text-xs">
            @csrf

            <!-- Customer & Technician Select -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px]">Customer <span class="text-rose-500">*</span></label>
                        <button type="button" onclick="openNewCustomerModal()" class="text-blue-600 text-[11px] hover:underline font-semibold">+ New Customer</button>
                    </div>
                    <select name="customer_id" id="repCustomerSelect" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        <option value="">Select customer...</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">
                                {{ $c->name }} ({{ $c->phone }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Assign Technician</label>
                    <select name="technician_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}">
                                {{ $tech->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Device Type & Brand -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Device Type <span class="text-rose-500">*</span></label>
                    <select name="device_type" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        <option value="Laptop">Laptop</option>
                        <option value="Desktop">Desktop PC</option>
                        <option value="Monitor">Monitor</option>
                        <option value="Smartphone">Smartphone</option>
                        <option value="Printer">Printer</option>
                        <option value="Component">Component / Graphic Card</option>
                        <option value="Other">Other Device</option>
                    </select>
                </div>

                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Brand <span class="text-rose-500">*</span></label>
                    <select name="brand" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
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
            </div>

            <!-- Model & Serial Number -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Model Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="model" placeholder="e.g. ASUS TUF Gaming Laptop A15" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Serial Number</label>
                    <input type="text" name="serial_number" placeholder="e.g. SN-880921001"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition font-mono">
                </div>
            </div>

            <!-- Issue Description -->
            <div>
                <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Issue Description <span class="text-rose-500">*</span></label>
                <textarea name="issue_description" rows="3" placeholder="Describe the device defects or user reported issues in detail..." required
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition"></textarea>
            </div>

            <!-- Estimated Cost -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Estimated Cost ($)</label>
                    <input type="number" step="0.01" name="estimated_cost" value="50.00"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition font-mono">
                </div>
                <div class="flex items-end">
                    <button type="button" onclick="Swal.fire('Upload Device Images', 'រូបភាពឧបករណ៍ត្រូវបានជ្រើសរើសដោយជោគជ័យ', 'info')" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold flex items-center justify-center gap-2 transition">
                        <i class="fa-regular fa-image"></i> Attach Images
                    </button>
                </div>
            </div>

            <!-- Action Buttons Footer -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md shadow-blue-600/20 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-plus text-xs"></i> Create Request
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 4. POPUP MODAL: VIEW REPAIR DETAILS (READ DETAILS LIKE BRAND VIEW)         --}}
{{-- ========================================================================= --}}
<div id="viewModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl w-full max-w-xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 leading-tight">Repair Details</h3>
                    <p class="text-xs text-slate-500 font-mono" id="view_repair_code">RE-2026-0001</p>
                </div>
            </div>
            <button type="button" onclick="closeViewModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-4 overflow-y-auto flex-1 text-xs">
            <!-- Device Banner Card -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shrink-0 shadow-sm">
                        <i class="fa-solid fa-laptop"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-900" id="view_model">ASUS TUF Gaming Laptop</h4>
                        <p class="text-[11px] text-slate-400 font-mono mt-0.5">
                            <span id="view_brand" class="font-semibold text-slate-600">ASUS</span> &bull; 
                            Serial: <span id="view_serial" class="font-bold text-slate-700">SN123456789</span>
                        </p>
                    </div>
                </div>
                <div id="view_status_badge">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-600 border border-sky-200">Diagnosing</span>
                </div>
            </div>

            <!-- Customer & Technician Info -->
            <div class="grid grid-cols-2 gap-4 p-3.5 rounded-xl bg-slate-50/50 border border-slate-100">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Customer</span>
                    <p class="font-bold text-slate-800 text-xs mt-0.5" id="view_customer_name">Sok Dara</p>
                    <p class="text-[10px] text-slate-400 font-mono" id="view_customer_phone">+855 12 345 678</p>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Assigned Technician</span>
                    <p class="font-bold text-slate-800 text-xs mt-0.5" id="view_technician">Chan Vutha</p>
                    <p class="text-[10px] text-slate-400" id="view_created_at">Created on 2026-11-01</p>
                </div>
            </div>

            <!-- Issue Description -->
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Issue Description</span>
                <p class="font-medium text-slate-800 bg-slate-50 p-3 rounded-xl border border-slate-200/70" id="view_issue">
                    Device overheating and noisy cooling fan.
                </p>
            </div>

            <!-- Technician Diagnosis -->
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Technician Diagnosis</span>
                <p class="font-medium text-slate-800 bg-slate-50 p-3 rounded-xl border border-slate-200/70" id="view_diagnosis">
                    Pending technician inspection.
                </p>
            </div>

            <!-- Financials & Dates -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-1">
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Est. Cost</span>
                    <span class="font-extrabold text-blue-600 font-mono text-sm" id="view_cost">$50.00</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Est. Ready</span>
                    <span class="font-bold text-slate-700 font-mono text-xs" id="view_completion">2026-11-04</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 col-span-2 sm:col-span-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Device Type</span>
                    <span class="font-bold text-slate-700 text-xs" id="view_device_type">Laptop</span>
                </div>
            </div>

            <!-- Quick Action Buttons in View Modal -->
            <div class="pt-2 flex items-center gap-2">
                <button type="button" onclick="openSparePartsModal()" class="flex-1 py-2 bg-indigo-50 border border-indigo-200 text-indigo-700 rounded-xl font-semibold hover:bg-indigo-100 transition flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-microchip"></i> Add Spare Part
                </button>
                <button type="button" onclick="printRepairTicketCurrent()" class="flex-1 py-2 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-print"></i> Print Slip
                </button>
                <button type="button" onclick="switchToEditStatusModal()" class="flex-1 py-2 bg-sky-500 text-white rounded-xl font-semibold hover:bg-sky-600 transition flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-pen-to-square"></i> Update Status
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-3 border-t border-slate-200 bg-slate-50/50 flex justify-end">
            <button type="button" onclick="closeViewModal()" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition text-xs">
                Back to List
            </button>
        </div>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 5. POPUP MODAL: UPDATE REPAIR STATUS (EDIT STATUS LIKE BRAND EDIT)         --}}
{{-- ========================================================================= --}}
<div id="editStatusModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl w-full max-w-xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-sky-500 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                    <i class="fa-solid fa-timeline"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 leading-tight">Update Repair Status</h3>
                    <p class="text-xs text-slate-500 font-mono" id="edit_repair_code">RE-2026-0001</p>
                </div>
            </div>
            <button type="button" onclick="closeEditStatusModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Form -->
        <form id="updateStatusModalForm" onsubmit="submitStatusUpdate(event)" class="p-6 space-y-4 overflow-y-auto flex-1 text-xs">
            <input type="hidden" id="statusUpdateRepairId" value="">

            <!-- Status Stepper visual indicator -->
            <div class="relative pl-6 space-y-3 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200 text-xs">
                <div class="relative flex items-start gap-2.5">
                    <div class="absolute -left-6 w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center text-[10px] ring-4 ring-white">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800">Received &bull; Logged into system</p>
                    </div>
                </div>
                <div class="relative flex items-start gap-2.5">
                    <div class="absolute -left-6 w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] ring-4 ring-white">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>
                    <div>
                        <p class="font-bold text-blue-600">Diagnosing &bull; Inspection & Troubleshooting</p>
                    </div>
                </div>
                <div class="relative flex items-start gap-2.5">
                    <div class="absolute -left-6 w-5 h-5 rounded-full bg-slate-300 text-slate-600 flex items-center justify-center text-[10px] ring-4 ring-white">
                        <i class="fa-solid fa-flag-checkered"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-600">Repairing &bull; Testing &bull; Completed</p>
                    </div>
                </div>
            </div>

            <!-- Select New Status -->
            <div class="pt-2 border-t border-slate-100">
                <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Set New Status <span class="text-rose-500">*</span></label>
                <select id="modalNewStatusSelect" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    <option value="Received">Received (ទើបទទួល)</option>
                    <option value="Diagnosing">Diagnosing (កំពុងត្រួតពិនិត្យ)</option>
                    <option value="Waiting for Parts">Waiting for Parts (រង់ចាំគ្រឿងបន្លាស់)</option>
                    <option value="Repairing">Repairing (កំពុងជួសជុល)</option>
                    <option value="Testing">Testing (កំពុងតេស្តសាកល្បង)</option>
                    <option value="Completed">Completed (ជួសជុលរួចរាល់)</option>
                    <option value="Cancelled">Cancelled (បានបោះបង់)</option>
                </select>
            </div>

            <!-- Assign Technician -->
            <div>
                <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Assign Technician</label>
                <select id="modalAssignTechSelect" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    @foreach($technicians as $tech)
                        <option value="{{ $tech->id }}">
                            {{ $tech->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Diagnosis & Inspection Notes -->
            <div>
                <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Diagnosis Notes</label>
                <textarea id="modalDiagnosisNotes" rows="3" placeholder="Enter inspection result or technical notes..."
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition"></textarea>
            </div>

            <!-- Action Buttons Footer -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="button" onclick="closeEditStatusModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md shadow-blue-600/20 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-rotate-right text-xs"></i> Update Status
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 6. MODAL: ADD SPARE PART & DIAGNOSIS                                      --}}
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
{{-- 7. MODAL: REPAIR TICKET SLIP (80mm RECEIPT)                               --}}
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
{{-- 8. JAVASCRIPT STATE ENGINE FOR REPAIRS                                    --}}
{{-- ========================================================================= --}}
<script>
    let currentSelectedRepairId = {{ $featuredRepair->id ?? 1 }};

    document.addEventListener('DOMContentLoaded', () => {
        initRepairStatusChart();
    });

    // Donut Chart Initialization
    function initRepairStatusChart() {
        const ctx = document.getElementById('repairStatusDonutChart').getContext('2d');
        const rawChartData = [
            {{ $statusCounts['Diagnosing'] ?? 0 }},
            {{ $statusCounts['Waiting for Parts'] ?? 0 }},
            {{ $statusCounts['Repairing'] ?? 0 }},
            {{ $statusCounts['Testing'] ?? 0 }},
            {{ $statusCounts['Completed'] ?? 0 }},
            {{ $statusCounts['Cancelled'] ?? 0 }}
        ];
        const sumData = rawChartData.reduce((a, b) => a + b, 0);
        const finalData = sumData > 0 ? rawChartData : [18, 4, 11, 3, 10, 2];

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Diagnosing', 'Waiting for Parts', 'Repairing', 'Testing', 'Completed', 'Cancelled'],
                datasets: [{
                    data: finalData,
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

    // ==========================================
    // 1. CREATE MODAL
    // ==========================================
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }

    // ==========================================
    // 2. VIEW DETAILS MODAL
    // ==========================================
    async function openViewModal(repairId) {
        currentSelectedRepairId = repairId;

        try {
            const res = await fetch(`/repairs/${repairId}`);
            const data = await res.json();
            if (data.success) {
                const r = data.repair;
                document.getElementById('view_repair_code').textContent = r.repair_code;
                document.getElementById('view_model').textContent = r.model;
                document.getElementById('view_brand').textContent = r.brand || 'General';
                document.getElementById('view_serial').textContent = r.serial_number || 'N/A';
                document.getElementById('view_customer_name').textContent = r.customer ? r.customer.name : 'Walk-in';
                document.getElementById('view_customer_phone').textContent = r.customer ? (r.customer.phone || 'N/A') : 'N/A';
                document.getElementById('view_technician').textContent = r.technician ? r.technician.name : 'Unassigned';
                document.getElementById('view_created_at').textContent = r.created_at ? ('Created on ' + r.created_at.substring(0, 10)) : '—';
                document.getElementById('view_issue').textContent = r.issue_description;
                document.getElementById('view_diagnosis').textContent = r.diagnosis || 'Pending technician inspection.';
                document.getElementById('view_cost').textContent = `$${parseFloat(r.total_cost || r.estimated_cost || 0).toFixed(2)}`;
                document.getElementById('view_completion').textContent = r.estimated_completion ? r.estimated_completion.substring(0, 10) : 'TBD';
                document.getElementById('view_device_type').textContent = r.device_type || 'Device';

                // Status Badge
                const badgeBox = document.getElementById('view_status_badge');
                let badgeClass = 'bg-slate-100 text-slate-700 border-slate-200';
                if (r.status === 'Diagnosing') badgeClass = 'bg-sky-50 text-sky-600 border-sky-200';
                else if (r.status === 'Waiting for Parts') badgeClass = 'bg-amber-50 text-amber-600 border-amber-200';
                else if (r.status === 'Repairing') badgeClass = 'bg-blue-50 text-blue-600 border-blue-200';
                else if (r.status === 'Testing') badgeClass = 'bg-indigo-50 text-indigo-600 border-indigo-200';
                else if (r.status === 'Completed') badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                else if (r.status === 'Cancelled') badgeClass = 'bg-rose-50 text-rose-600 border-rose-200';

                badgeBox.innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-bold border ${badgeClass}">${r.status}</span>`;

                document.getElementById('viewModal').classList.remove('hidden');
            }
        } catch (e) {
            console.error(e);
            Swal.fire('កំហុស', 'មិនអាចទាញទិន្នន័យបានឡើយ', 'error');
        }
    }

    function closeViewModal() {
        document.getElementById('viewModal').classList.add('hidden');
    }

    function switchToEditStatusModal() {
        closeViewModal();
        openEditStatusModal(currentSelectedRepairId);
    }

    // ==========================================
    // 3. EDIT/UPDATE STATUS MODAL
    // ==========================================
    async function openEditStatusModal(repairId) {
        currentSelectedRepairId = repairId;
        document.getElementById('statusUpdateRepairId').value = repairId;

        try {
            const res = await fetch(`/repairs/${repairId}`);
            const data = await res.json();
            if (data.success) {
                const r = data.repair;
                document.getElementById('edit_repair_code').textContent = `${r.repair_code} • ${r.model}`;
                document.getElementById('modalNewStatusSelect').value = r.status;
                if (r.technician_id) {
                    document.getElementById('modalAssignTechSelect').value = r.technician_id;
                }
                document.getElementById('modalDiagnosisNotes').value = r.diagnosis || '';

                document.getElementById('editStatusModal').classList.remove('hidden');
            }
        } catch (e) {
            console.error(e);
            Swal.fire('កំហុស', 'មិនអាចទាញទិន្នន័យបានឡើយ', 'error');
        }
    }

    function closeEditStatusModal() {
        document.getElementById('editStatusModal').classList.add('hidden');
    }

    // ==========================================
    // 4. SUBMIT STATUS UPDATE
    // ==========================================
    async function submitStatusUpdate(event) {
        event.preventDefault();
        const repairId = document.getElementById('statusUpdateRepairId').value;
        const status = document.getElementById('modalNewStatusSelect').value;
        const techId = document.getElementById('modalAssignTechSelect').value;
        const diagnosis = document.getElementById('modalDiagnosisNotes').value;

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
                    technician_id: techId,
                    diagnosis: diagnosis
                })
            });

            const data = await res.json();
            if (data.success) {
                closeEditStatusModal();
                Swal.fire({
                    icon: 'success',
                    title: 'ជោគជ័យ!',
                    text: 'ស្ថានភាពត្រូវបានកែប្រែរួចរាល់',
                    confirmButtonColor: '#2563EB'
                }).then(() => location.reload());
            } else {
                Swal.fire('បរាជ័យ', data.message || 'មិនអាចកែប្រែស្ថានភាពបានទេ', 'error');
            }
        } catch (e) {
            Swal.fire('កំហុស', 'មិនអាចភ្ជាប់ម៉ាស៊ីនបម្រើបានទេ', 'error');
        }
    }

    // ==========================================
    // 5. SPARE PARTS & TICKET SLIP
    // ==========================================
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
                    .then(() => openViewModal(currentSelectedRepairId));
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
                document.getElementById('ticketPhoneDisplay').textContent = r.customer ? (r.customer.phone || 'N/A') : 'N/A';
                document.getElementById('ticketDeviceDisplay').textContent = r.model;
                document.getElementById('ticketSerialDisplay').textContent = r.serial_number || 'N/A';
                document.getElementById('ticketTechDisplay').textContent = r.technician ? r.technician.name : 'Staff';
                document.getElementById('ticketEstReadyDisplay').textContent = r.estimated_completion ? r.estimated_completion.substring(0, 10) : 'In 3 days';
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

    // ==========================================
    // 6. UTILITIES & FILTERS
    // ==========================================
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

    function scrollToTable() {
        document.getElementById('tableSection').scrollIntoView({ behavior: 'smooth' });
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
                    const response = await fetch("{{ route('customers.store') }}", {
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
