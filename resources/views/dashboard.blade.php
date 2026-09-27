<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | TECHZONE Computer Shop Management System</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB',
                        primaryHover: '#1D4ED8',
                        techdark: '#0B132B',
                        sidebardark: '#0F172A',
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', 'Kantumruy Pro', sans-serif; }
        .scrollbar-thin::-webkit-scrollbar { width: 5px; height: 5px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #f1f5f9; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 9999px; }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }
    </style>
</head>
<body class="bg-[#F4F6FA] text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

<div class="flex min-h-screen">

    {{-- ========================================================================= --}}
    {{-- 1. TECHZONE SIDEBAR NAVIGATION (Matching Mockup 2)                       --}}
    {{-- ========================================================================= --}}
    <aside id="sidebarMenu" class="w-64 bg-[#0B132B] text-slate-300 flex-shrink-0 hidden lg:flex flex-col fixed h-screen z-30 shadow-2xl transition-all duration-300 select-none">
        
        <!-- Brand Header -->
        <div class="px-5 py-5 border-b border-slate-800/80 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                <i class="fa-solid fa-cube text-xl"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-lg text-white tracking-wider leading-none">TECHZONE</h1>
                <p class="text-[10px] text-blue-400 font-medium tracking-tight mt-1">Computer Shop Management</p>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto scrollbar-thin">
            
            <!-- Dashboard (Active) -->
            <a href="{{ route('dashboard') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-md {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-house w-5 text-center text-sm"></i>
                    <span>Dashboard</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            </a>

            <!-- Product Management -->
            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-box-open w-5 text-center text-sm"></i>
                <span>Product Management</span>
            </a>

            <!-- Purchase Management -->
            <a href="{{ route('purchases') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('purchases*') || request()->routeIs('purchase-orders*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-cart-shopping w-5 text-center text-sm"></i>
                <span>Purchase Management</span>
            </a>

            <!-- Inventory Management -->
            <a href="{{ route('inventory') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('inventory*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-warehouse w-5 text-center text-sm"></i>
                <span>Inventory Management</span>
            </a>

            <!-- Sales Management (POS) -->
            <a href="{{ route('pos.sales') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('pos.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-cash-register w-5 text-center text-sm"></i>
                <span>Sales Management (POS)</span>
            </a>

            <!-- Repair Service Management -->
            <a href="{{ route('repair.service') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('repair.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-wrench w-5 text-center text-sm"></i>
                <span>Repair Service Management</span>
            </a>

            <!-- Warranty Management -->
            <a href="{{ route('warranty') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('warranty*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-shield-halved w-5 text-center text-sm"></i>
                <span>Warranty Management</span>
            </a>

            <!-- Payment & Invoice -->
            <a href="{{ route('invoices') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('invoices*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-sm"></i>
                <span>Payment & Invoice</span>
            </a>

            <!-- Employee Management -->
            <a href="{{ route('employees') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('employees*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-user-gear w-5 text-center text-sm"></i>
                <span>Employee Management</span>
            </a>

            <!-- Customer Management -->
            <a href="{{ route('customers') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('customers*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-users w-5 text-center text-sm"></i>
                <span>Customer Management</span>
            </a>

            <!-- Report Management -->
            <a href="{{ route('reports') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('reports*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center text-sm"></i>
                <span>Report Management</span>
            </a>

            <!-- Notification -->
            <a href="{{ route('notifications') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('notifications*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-bell w-5 text-center text-sm"></i>
                    <span>Notification</span>
                </div>
                <span class="px-2 py-0.5 text-[11px] font-bold bg-rose-500 text-white rounded-full">3</span>
            </a>

            <!-- Settings -->
            <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('settings*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
                <i class="fa-solid fa-gear w-5 text-center text-sm"></i>
                <span>Settings</span>
            </a>
        </nav>

        <!-- Sidebar User Footer -->
        <div class="p-3 border-t border-slate-800/80 bg-slate-900/50">
            <div class="flex items-center justify-between p-2 rounded-xl bg-slate-800/40">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold text-xs ring-2 ring-blue-500/20">
                        {{ strtoupper(substr(Auth::user()->name ?? 'SD', 0, 2)) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Sok Dara' }}</div>
                        <div class="text-[10px] text-slate-400 truncate">{{ Auth::user()->role->role_name ?? 'Administrator' }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" title="Logout" class="text-slate-400 hover:text-rose-400 text-sm p-1 transition">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ========================================================================= --}}
    {{-- 2. MAIN CONTENT AREA                                                     --}}
    {{-- ========================================================================= --}}
    <main class="flex-1 lg:ml-64 flex flex-col min-w-0 min-h-screen">
        
        <!-- Top Navigation Bar -->
        <header class="bg-white border-b border-slate-200/80 px-6 py-3.5 flex items-center justify-between sticky top-0 z-20 shadow-sm backdrop-blur-md bg-white/95">
            <!-- Left: Mobile Menu Toggle & Global Search -->
            <div class="flex items-center gap-4 flex-1 max-w-xl">
                <button onclick="document.getElementById('sidebarMenu').classList.toggle('hidden')" class="lg:hidden text-slate-600 hover:text-blue-600 p-2 rounded-lg hover:bg-slate-100 transition">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="relative w-full">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" placeholder="Search product, customer, invoice, or anything..." class="w-full pl-10 pr-4 py-2 bg-slate-100/80 border border-transparent rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition placeholder-slate-400 text-slate-700">
                </div>
            </div>

            <!-- Right: Actions, Notifications, User & Clock -->
            <div class="flex items-center gap-3 sm:gap-4 pl-4">
                <!-- Notification Bell -->
                <a href="{{ route('notifications') }}" class="relative p-2.5 text-slate-500 hover:text-blue-600 rounded-xl hover:bg-slate-100 transition" title="Notifications">
                    <i class="fa-regular fa-bell text-base"></i>
                    <span class="absolute top-1.5 right-1.5 w-4 h-4 bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center ring-2 ring-white">3</span>
                </a>

                <!-- Fullscreen Toggle -->
                <button onclick="toggleFullscreen()" class="p-2.5 text-slate-500 hover:text-blue-600 rounded-xl hover:bg-slate-100 transition hidden sm:inline-flex" title="Toggle Fullscreen">
                    <i class="fa-solid fa-expand text-base"></i>
                </button>

                <!-- User Profile -->
                <div class="flex items-center gap-3 pl-3 sm:pl-4 border-l border-slate-200">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md ring-2 ring-blue-500/20">
                        {{ strtoupper(substr(Auth::user()->name ?? 'SD', 0, 2)) }}
                    </div>
                    <div class="hidden md:block text-left">
                        <div class="text-xs font-bold text-slate-800 leading-tight">{{ Auth::user()->name ?? 'Sok Dara' }}</div>
                        <div class="text-[11px] font-semibold text-blue-600 leading-tight">{{ Auth::user()->role->role_name ?? 'Administrator' }}</div>
                    </div>
                </div>

                <!-- Live Date & Clock -->
                <div class="hidden xl:flex flex-col text-right pl-3 border-l border-slate-200">
                    <span id="liveDate" class="text-[11px] font-semibold text-slate-500 leading-tight">Thu, Sep 27, 2026</span>
                    <span id="liveClock" class="text-xs font-extrabold text-slate-800 leading-tight">10:32 AM</span>
                </div>
            </div>
        </header>

        <!-- Dashboard Body Container -->
        <div class="p-5 lg:p-7 space-y-6">

            <!-- Page Title Section (Matching Mockup 2) -->
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shadow-sm">
                    <i class="fa-solid fa-house text-lg"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard</h2>
                    <p class="text-xs font-medium text-slate-500">Welcome back, <span class="font-semibold text-slate-700">{{ Auth::user()->name ?? 'Sok Dara' }}</span>! Here's what's happening at your shop today.</p>
                </div>
            </div>

            {{-- ========================================================================= --}}
            {{-- 3. ROW 1: 6 STAT CARDS GRID (Matching Mockup 2)                          --}}
            {{-- ========================================================================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                
                <!-- Card 1: Total Products -->
                <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-600/30">
                            <i class="fa-solid fa-box text-lg"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Products</div>
                            <div class="text-2xl font-black text-slate-900 leading-tight">{{ number_format($totalProducts) }}</div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                        <i class="fa-solid fa-arrow-up text-[10px]"></i>
                        <span>12%</span>
                        <span class="text-[11px] font-normal text-slate-400">(vs. last month)</span>
                    </div>
                </div>

                <!-- Card 2: Total Customers -->
                <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-500 flex items-center justify-center text-white shadow-md shadow-emerald-500/30">
                            <i class="fa-solid fa-users text-lg"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Customers</div>
                            <div class="text-2xl font-black text-slate-900 leading-tight">{{ number_format($totalCustomers) }}</div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                        <i class="fa-solid fa-arrow-up text-[10px]"></i>
                        <span>8%</span>
                        <span class="text-[11px] font-normal text-slate-400">(vs. last month)</span>
                    </div>
                </div>

                <!-- Card 3: Total Sales (This Month) -->
                <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-amber-500 flex items-center justify-center text-white shadow-md shadow-amber-500/30">
                            <i class="fa-solid fa-cart-shopping text-lg"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Sales (This Month)</div>
                            <div class="text-xl font-black text-slate-900 leading-tight">${{ number_format($totalSalesMonth, 2) }}</div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                        <i class="fa-solid fa-arrow-up text-[10px]"></i>
                        <span>16%</span>
                        <span class="text-[11px] font-normal text-slate-400">(vs. last month)</span>
                    </div>
                </div>

                <!-- Card 4: Total Purchases (This Month) -->
                <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-rose-500 flex items-center justify-center text-white shadow-md shadow-rose-500/30">
                            <i class="fa-solid fa-file-invoice text-lg"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Purchases (This Month)</div>
                            <div class="text-xl font-black text-slate-900 leading-tight">${{ number_format($totalPurchasesMonth, 2) }}</div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-emerald-600">
                        <i class="fa-solid fa-arrow-up text-[10px]"></i>
                        <span>10%</span>
                        <span class="text-[11px] font-normal text-slate-400">(vs. last month)</span>
                    </div>
                </div>

                <!-- Card 5: Pending Repairs -->
                <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-purple-600 flex items-center justify-center text-white shadow-md shadow-purple-600/30">
                            <i class="fa-solid fa-wrench text-lg"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pending Repairs</div>
                            <div class="text-2xl font-black text-slate-900 leading-tight">{{ $pendingRepairsCount }}</div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-rose-500">
                        <i class="fa-solid fa-arrow-down text-[10px]"></i>
                        <span>30%</span>
                        <span class="text-[11px] font-normal text-slate-400">(vs. last month)</span>
                    </div>
                </div>

                <!-- Card 6: Warranty Claims -->
                <div class="bg-white p-4.5 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-teal-600 flex items-center justify-center text-white shadow-md shadow-teal-600/30">
                            <i class="fa-solid fa-shield-halved text-lg"></i>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Warranty Claims</div>
                            <div class="text-2xl font-black text-slate-900 leading-tight">{{ $warrantyClaimsCount }}</div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center gap-1.5 text-xs font-semibold text-rose-500">
                        <i class="fa-solid fa-arrow-down text-[10px]"></i>
                        <span>20%</span>
                        <span class="text-[11px] font-normal text-slate-400">(vs. last month)</span>
                    </div>
                </div>

            </div>

            {{-- ========================================================================= --}}
            {{-- 4. ROW 2: MIDDLE SECTION (Sales Line Chart + Donut + Recent Activities)   --}}
            {{-- ========================================================================= --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Left: Sales Overview Line Chart (Col Span 5) -->
                <div class="lg:col-span-5 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <i class="fa-solid fa-chart-line text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-sm text-slate-900">Sales Overview</h3>
                                    <p class="text-[11px] text-slate-400">Monthly sales and comparison</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <select class="text-xs bg-slate-50 border border-slate-200 text-slate-600 rounded-lg px-2.5 py-1 focus:outline-none focus:border-blue-500 font-semibold cursor-pointer">
                                    <option selected>This Month</option>
                                    <option>Last Month</option>
                                    <option>This Year</option>
                                </select>
                            </div>
                        </div>

                        <!-- Chart Legend -->
                        <div class="flex items-center justify-end gap-4 mt-3 text-xs">
                            <div class="flex items-center gap-1.5 font-semibold text-slate-600">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                <span>This Month</span>
                            </div>
                            <div class="flex items-center gap-1.5 font-semibold text-slate-400">
                                <span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
                                <span>Last Month</span>
                            </div>
                        </div>

                        <!-- Chart Canvas Container -->
                        <div class="mt-4 relative h-64 w-full">
                            <canvas id="salesOverviewChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Center: Inventory Status Donut Chart (Col Span 4) -->
                <div class="lg:col-span-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                                <i class="fa-solid fa-boxes-stacked text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-sm text-slate-900">Inventory Status</h3>
                                <p class="text-[11px] text-slate-400">Current stock status</p>
                            </div>
                        </div>

                        <!-- Donut Chart & Breakdown -->
                        <div class="mt-5 flex flex-col sm:flex-row items-center justify-around gap-6">
                            <!-- Donut Canvas with Center Text -->
                            <div class="relative w-44 h-44 flex items-center justify-center">
                                <canvas id="inventoryStatusChart"></canvas>
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                    <span class="text-2xl font-black text-slate-800 leading-none">{{ $invTotal }}</span>
                                    <span class="text-[11px] font-bold text-slate-400 mt-1">Total Products</span>
                                </div>
                            </div>

                            <!-- Legend Breakdown -->
                            <div class="space-y-3 w-full sm:w-auto">
                                <div class="flex items-center justify-between sm:justify-start gap-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                        <span class="text-xs font-semibold text-slate-700">In Stock</span>
                                    </div>
                                    <span class="text-xs font-bold text-slate-900">{{ $inStock }} <span class="font-normal text-slate-400">({{ $inStockPercent }}%)</span></span>
                                </div>
                                <div class="flex items-center justify-between sm:justify-start gap-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                                        <span class="text-xs font-semibold text-slate-700">Low Stock</span>
                                    </div>
                                    <span class="text-xs font-bold text-slate-900">{{ $lowStock }} <span class="font-normal text-slate-400">({{ $lowStockPercent }}%)</span></span>
                                </div>
                                <div class="flex items-center justify-between sm:justify-start gap-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                                        <span class="text-xs font-semibold text-slate-700">Out of Stock</span>
                                    </div>
                                    <span class="text-xs font-bold text-slate-900">{{ $outOfStock }} <span class="font-normal text-slate-400">({{ $outOfStockPercent }}%)</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Recent Activities Feed (Col Span 3) -->
                <div class="lg:col-span-3 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-bolt text-blue-600 text-sm"></i>
                                <h3 class="font-extrabold text-sm text-slate-900">Recent Activities</h3>
                            </div>
                            <a href="{{ route('invoices') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition">View All</a>
                        </div>

                        <!-- Activity List -->
                        <div class="mt-4 space-y-3.5">
                            @foreach($activities as $act)
                            <div class="flex items-center justify-between p-2 rounded-xl hover:bg-slate-50 transition cursor-pointer group">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl {{ $act['icon_bg'] }} {{ $act['icon_text'] }} flex items-center justify-center shrink-0 shadow-sm">
                                        <i class="{{ $act['icon'] }} text-xs"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-slate-800 truncate group-hover:text-blue-600 transition">{{ $act['title'] }}</div>
                                        <div class="text-[11px] text-slate-400 truncate">{{ $act['subtitle'] }}</div>
                                    </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 group-hover:text-blue-600 group-hover:translate-x-0.5 transition"></i>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            {{-- ========================================================================= --}}
            {{-- 5. ROW 3: BOTTOM SECTION (Top Selling + Recent Orders + Quick Shortcuts)  --}}
            {{-- ========================================================================= --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Left: Top Selling Products (Col Span 5) -->
                <div class="lg:col-span-5 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-trophy text-amber-500 text-sm"></i>
                                <div>
                                    <h3 class="font-extrabold text-sm text-slate-900">Top Selling Products</h3>
                                    <p class="text-[11px] text-slate-400">This Month</p>
                                </div>
                            </div>
                        </div>

                        <!-- Top Selling Table -->
                        <div class="overflow-x-auto mt-2">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="text-slate-400 uppercase text-[10px] font-bold border-b border-slate-100">
                                        <th class="py-2.5 px-2">#</th>
                                        <th class="py-2.5 px-2">Product Name</th>
                                        <th class="py-2.5 px-2 text-center">Sold Qty</th>
                                        <th class="py-2.5 px-2 text-right">Revenue</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                                    @forelse($topSellingProducts as $item)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-2.5 px-2 font-bold text-slate-400">{{ $item['rank'] }}</td>
                                        <td class="py-2.5 px-2">
                                            <div class="flex items-center gap-2.5">
                                                @if(!empty($item['thumbnail']) && file_exists(public_path($item['thumbnail'])))
                                                    <img src="{{ asset($item['thumbnail']) }}" class="w-7 h-7 rounded-lg object-cover border border-slate-200" alt="{{ $item['name'] }}">
                                                @else
                                                    <div class="w-7 h-7 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 text-xs">
                                                        <i class="fa-solid fa-laptop"></i>
                                                    </div>
                                                @endif
                                                <span class="font-bold text-slate-800 truncate max-w-[150px] sm:max-w-[180px]">{{ $item['name'] }}</span>
                                            </div>
                                        </td>
                                        <td class="py-2.5 px-2 text-center font-bold text-slate-900">{{ $item['sold_qty'] }}</td>
                                        <td class="py-2.5 px-2 text-right font-black text-slate-900">${{ number_format($item['revenue'], 2) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-center text-slate-400">No sales data recorded yet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Footer Link -->
                    <div class="mt-4 pt-3 border-t border-slate-100">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-700 transition">
                            <span>View All Products</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Center: Recent Orders (Col Span 4) -->
                <div class="lg:col-span-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-bag-shopping text-blue-600 text-sm"></i>
                                <h3 class="font-extrabold text-sm text-slate-900">Recent Orders</h3>
                            </div>
                            <a href="{{ route('invoices') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition">View All</a>
                        </div>

                        <!-- Orders Table -->
                        <div class="overflow-x-auto mt-2">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="text-slate-400 uppercase text-[10px] font-bold border-b border-slate-100">
                                        <th class="py-2.5 px-2">#</th>
                                        <th class="py-2.5 px-2">Date</th>
                                        <th class="py-2.5 px-2">Customer</th>
                                        <th class="py-2.5 px-2 text-right">Total</th>
                                        <th class="py-2.5 px-2 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                                    @foreach($recentOrders as $order)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-2.5 px-2 font-bold text-blue-600 truncate max-w-[90px]">{{ $order['order_number'] }}</td>
                                        <td class="py-2.5 px-2 text-slate-400 text-[11px]">{{ $order['date'] }}</td>
                                        <td class="py-2.5 px-2 font-bold text-slate-800 truncate max-w-[90px]">{{ $order['customer'] }}</td>
                                        <td class="py-2.5 px-2 text-right font-black text-slate-900">${{ number_format($order['total'], 2) }}</td>
                                        <td class="py-2.5 px-2 text-center">
                                            @php
                                                $st = strtolower($order['status'] ?? 'paid');
                                            @endphp
                                            @if($st === 'paid')
                                                <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-100 text-emerald-700 rounded-full">Paid</span>
                                            @elseif($st === 'pending')
                                                <span class="px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-700 rounded-full">Pending</span>
                                            @else
                                                <span class="px-2 py-0.5 text-[10px] font-bold bg-rose-100 text-rose-700 rounded-full">{{ ucfirst($order['status']) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Quick Shortcuts (Col Span 3) -->
                <div class="lg:col-span-3 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 pb-3 border-b border-slate-100">
                            <i class="fa-solid fa-grip text-slate-700 text-sm"></i>
                            <h3 class="font-extrabold text-sm text-slate-900">Quick Shortcuts</h3>
                        </div>

                        <!-- 6 Quick Action Buttons (2 cols x 3 rows matching Mockup 2) -->
                        <div class="grid grid-cols-2 gap-3 mt-4">
                            
                            <!-- 1. New Sale (POS) -->
                            <a href="{{ route('pos.sales') }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/20 transition-all hover:scale-105 group text-center gap-1.5">
                                <i class="fa-solid fa-cart-shopping text-base group-hover:animate-bounce"></i>
                                <span>New Sale (POS)</span>
                            </a>

                            <!-- 2. Add Product -->
                            <a href="{{ route('products.create') }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs shadow-md shadow-emerald-500/20 transition-all hover:scale-105 group text-center gap-1.5">
                                <i class="fa-solid fa-box text-base group-hover:animate-bounce"></i>
                                <span>Add Product</span>
                            </a>

                            <!-- 3. New Purchase -->
                            <a href="{{ route('purchases') }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-md shadow-amber-500/20 transition-all hover:scale-105 group text-center gap-1.5">
                                <i class="fa-solid fa-file-invoice text-base group-hover:animate-bounce"></i>
                                <span>New Purchase</span>
                            </a>

                            <!-- 4. Add Customer -->
                            <a href="{{ route('customers') }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md shadow-purple-600/20 transition-all hover:scale-105 group text-center gap-1.5">
                                <i class="fa-solid fa-user-plus text-base group-hover:animate-bounce"></i>
                                <span>Add Customer</span>
                            </a>

                            <!-- 5. Create Invoice -->
                            <a href="{{ route('invoices') }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-teal-500 hover:bg-teal-600 text-white font-bold text-xs shadow-md shadow-teal-500/20 transition-all hover:scale-105 group text-center gap-1.5">
                                <i class="fa-solid fa-file-invoice-dollar text-base group-hover:animate-bounce"></i>
                                <span>Create Invoice</span>
                            </a>

                            <!-- 6. Report -->
                            <a href="{{ route('reports') }}" class="flex flex-col items-center justify-center p-3 rounded-xl bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs shadow-md shadow-rose-500/20 transition-all hover:scale-105 group text-center gap-1.5">
                                <i class="fa-solid fa-chart-line text-base group-hover:animate-bounce"></i>
                                <span>Report</span>
                            </a>

                        </div>
                    </div>
                </div>

            </div>

            {{-- ========================================================================= --}}
            {{-- 6. ROW 4: TECHZONE PROMO BANNER (Matching Mockup 2 Bottom)                --}}
            {{-- ========================================================================= --}}
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#030c1d] via-[#091b38] to-[#030c1d] border border-blue-900/40 p-5 sm:p-6 shadow-xl flex flex-col md:flex-row items-center justify-between gap-5 text-white">
                
                <!-- Left: Tech Visual / Graphic -->
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-blue-400 text-2xl shadow-inner shrink-0">
                        <i class="fa-solid fa-laptop-code"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-black text-xl tracking-wider text-white">TECHZONE</span>
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-blue-600/40 text-blue-300 rounded-md border border-blue-400/30">Official</span>
                        </div>
                        <p class="text-xs text-slate-300 font-medium mt-0.5">Computer Shop Management System</p>
                    </div>
                </div>

                <!-- Center: Tagline -->
                <div class="hidden xl:flex items-center gap-3 text-xs font-semibold text-slate-400">
                    <span class="text-slate-300">Quality Products</span>
                    <span>•</span>
                    <span class="text-slate-300">Best Service</span>
                    <span>•</span>
                    <span class="text-slate-300">Your Trusted Partner</span>
                </div>

                <!-- Right: Action Button -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('products.index') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-xs shadow-lg shadow-blue-600/40 flex items-center gap-2 transition-all hover:scale-105">
                        <span>Go to Store</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- Subtle Decorative Background Glow -->
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-10 -top-10 w-48 h-48 bg-cyan-600/10 rounded-full blur-3xl pointer-events-none"></div>
            </div>

        </div>

    </main>

</div>

{{-- ========================================================================= --}}
{{-- 7. CHART.JS & REALTIME SCRIPTS                                            --}}
{{-- ========================================================================= --}}
<script>
    // -------------------------------------------------------------------------
    // 1. Sales Overview Line Chart
    // -------------------------------------------------------------------------
    const salesCtx = document.getElementById('salesOverviewChart').getContext('2d');
    
    // Gradient fill for This Month
    const thisMonthGradient = salesCtx.createLinearGradient(0, 0, 0, 240);
    thisMonthGradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
    thisMonthGradient.addColorStop(1, 'rgba(37, 99, 235, 0.00)');

    const salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'This Month',
                    data: @json($thisMonthSalesData),
                    borderColor: '#2563EB',
                    backgroundColor: thisMonthGradient,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#2563EB',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
                {
                    label: 'Last Month',
                    data: @json($lastMonthSalesData),
                    borderColor: '#94A3B8',
                    borderWidth: 1.5,
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#94A3B8',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 1.5,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Handled in custom HTML legend
                },
                tooltip: {
                    backgroundColor: '#0F172A',
                    titleColor: '#FFFFFF',
                    bodyColor: '#E2E8F0',
                    padding: 10,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': $' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#94A3B8',
                        font: { size: 10, weight: '500' }
                    }
                },
                y: {
                    grid: {
                        color: '#F1F5F9',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#94A3B8',
                        font: { size: 10, weight: '500' },
                        callback: function(value) {
                            return '$' + (value >= 1000 ? (value / 1000) + 'k' : value);
                        }
                    }
                }
            }
        }
    });

    // -------------------------------------------------------------------------
    // 2. Inventory Status Donut Chart
    // -------------------------------------------------------------------------
    const invCtx = document.getElementById('inventoryStatusChart').getContext('2d');
    const inventoryChart = new Chart(invCtx, {
        type: 'doughnut',
        data: {
            labels: ['In Stock', 'Low Stock', 'Out of Stock'],
            datasets: [{
                data: [{{ $inStock }}, {{ $lowStock }}, {{ $outOfStock }}],
                backgroundColor: [
                    '#10B981', // In Stock (Green)
                    '#F59E0B', // Low Stock (Amber)
                    '#EF4444'  // Out of Stock (Red)
                ],
                borderWidth: 3,
                borderColor: '#FFFFFF',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0F172A',
                    callbacks: {
                        label: function(context) {
                            const val = context.parsed;
                            return ' ' + context.label + ': ' + val + ' items';
                        }
                    }
                }
            }
        }
    });

    // -------------------------------------------------------------------------
    // 3. Live Clock & Fullscreen Toggle
    // -------------------------------------------------------------------------
    function updateLiveClock() {
        const now = new Date();
        const optionsDate = { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' };
        const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: true };

        const dateEl = document.getElementById('liveDate');
        const clockEl = document.getElementById('liveClock');

        if (dateEl) dateEl.innerText = now.toLocaleDateString('en-US', optionsDate);
        if (clockEl) clockEl.innerText = now.toLocaleTimeString('en-US', optionsTime);
    }
    setInterval(updateLiveClock, 1000);
    updateLiveClock();

    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                console.log(err.message);
            });
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }
</script>

</body>
</html>