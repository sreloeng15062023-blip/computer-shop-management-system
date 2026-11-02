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
    </style>
</head>
<body class="bg-[#F4F6FA] text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

<div class="flex min-h-screen">

    {{-- ========================================================================= --}}
    {{-- 1. TECHZONE SIDEBAR NAVIGATION                                           --}}
    {{-- ========================================================================= --}}
    {{-- =========================================================================
            [ស្លាយ Code Quality - ចំណុចទី ៥] Reusability (DRY - Don't Repeat Yourself)
            ហៅប្រើ @include('sidebar') មួយកន្លែង យកមកប្រើរួមគ្នាគ្រប់ទំព័រទាំងអស់
        ========================================================================= --}}
        @include('sidebar')

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
                    @if(($unreadNotificationsCount ?? 0) > 0)
                        <span class="absolute top-1.5 right-1.5 min-w-[16px] h-4 px-1 bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center ring-2 ring-white">
                            {{ $unreadNotificationsCount }}
                        </span>
                    @endif
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
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                
                <!-- Card 1: Total Products -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-600/30 shrink-0">
                            <i class="fa-solid fa-box text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Products</div>
                            <div class="text-3xl font-black text-slate-900 leading-tight mt-0.5">{{ number_format($totalProducts) }}</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                            <i class="fa-solid fa-arrow-up text-[10px]"></i> +12% vs last month
                        </span>
                        <span class="text-xs text-slate-400 font-medium">In catalog</span>
                    </div>
                </div>

                <!-- Card 2: Total Customers -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 shrink-0">
                            <i class="fa-solid fa-users text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Customers</div>
                            <div class="text-3xl font-black text-slate-900 leading-tight mt-0.5">{{ number_format($totalCustomers) }}</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                            <i class="fa-solid fa-arrow-up text-[10px]"></i> +8% vs last month
                        </span>
                        <span class="text-xs text-slate-400 font-medium">Active clients</span>
                    </div>
                </div>

                <!-- Card 3: Total Sales (This Month) -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-500 flex items-center justify-center text-white shadow-lg shadow-amber-500/30 shrink-0">
                            <i class="fa-solid fa-cart-shopping text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Sales (This Month)</div>
                            <div class="text-3xl font-black text-slate-900 leading-tight mt-0.5">${{ number_format($totalSalesMonth, 2) }}</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                            <i class="fa-solid fa-arrow-up text-[10px]"></i> +16% vs last month
                        </span>
                        <span class="text-xs text-slate-400 font-medium">Revenue</span>
                    </div>
                </div>

                <!-- Card 4: Total Purchases (This Month) -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-rose-500 flex items-center justify-center text-white shadow-lg shadow-rose-500/30 shrink-0">
                            <i class="fa-solid fa-file-invoice text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Purchases (This Month)</div>
                            <div class="text-3xl font-black text-slate-900 leading-tight mt-0.5">${{ number_format($totalPurchasesMonth, 2) }}</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                            <i class="fa-solid fa-arrow-up text-[10px]"></i> +10% vs last month
                        </span>
                        <span class="text-xs text-slate-400 font-medium">Procurement</span>
                    </div>
                </div>

                <!-- Card 5: Pending Repairs -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-purple-600 flex items-center justify-center text-white shadow-lg shadow-purple-600/30 shrink-0">
                            <i class="fa-solid fa-wrench text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Repairs</div>
                            <div class="text-3xl font-black text-slate-900 leading-tight mt-0.5">{{ $pendingRepairsCount }}</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600">
                            <i class="fa-solid fa-clock text-[10px]"></i> In progress
                        </span>
                        <span class="text-xs text-slate-400 font-medium">Technicians active</span>
                    </div>
                </div>

                <!-- Card 6: Warranty Claims -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-teal-600 flex items-center justify-center text-white shadow-lg shadow-teal-600/30 shrink-0">
                            <i class="fa-solid fa-shield-halved text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Warranty Claims</div>
                            <div class="text-3xl font-black text-slate-900 leading-tight mt-0.5">{{ $warrantyClaimsCount }}</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600">
                            <i class="fa-solid fa-file-shield text-[10px]"></i> Verified
                        </span>
                        <span class="text-xs text-slate-400 font-medium">Under review</span>
                    </div>
                </div>

            </div>

            {{-- ========================================================================= --}}
            {{-- 4. ROW 2: SALES OVERVIEW (FULL WIDTH មួយជួរដេកតែឯងធំទូលាយ)                  --}}
            {{-- ========================================================================= --}}
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="font-extrabold text-base text-slate-900">Sales Overview</h3>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/60 flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> LIVE
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400">Monthly sales performance &amp; timeline comparison</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <!-- Chart Legend -->
                            <div class="flex items-center gap-3 text-xs">
                                <div class="flex items-center gap-1.5 font-semibold text-slate-600">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                    <span>This Month</span>
                                </div>
                                <div class="flex items-center gap-1.5 font-semibold text-slate-400">
                                    <span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
                                    <span>Last Month</span>
                                </div>
                            </div>

                            <select class="text-xs bg-slate-50 border border-slate-200 text-slate-600 rounded-xl px-3 py-1.5 focus:outline-none focus:border-blue-500 font-semibold cursor-pointer">
                                <option selected>This Month</option>
                                <option>Last Month</option>
                                <option>This Year</option>
                            </select>
                        </div>
                    </div>

                    <!-- Chart Canvas Container (Wide & Spacious) -->
                    <div class="mt-5 relative h-72 w-full">
                        <canvas id="salesOverviewChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- ========================================================================= --}}
            {{-- 5. ROW 3: ខាងឆ្វេង៖ INVENTORY STATUS | ខាងស្តាំ៖ QUICK SHORTCUTS           --}}
            {{-- ========================================================================= --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- ខាងឆ្វេង៖ Inventory Status Donut Chart (Col Span 7) -->
                <div class="lg:col-span-7 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-boxes-stacked"></i>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-base text-slate-900">Inventory Status</h3>
                                    <p class="text-xs text-slate-400">Current warehouse &amp; stock breakdown</p>
                                </div>
                            </div>
                            <a href="{{ route('inventory') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700 transition">View Stock &rarr;</a>
                        </div>

                        <!-- Donut Chart & Breakdown -->
                        <div class="mt-6 flex flex-col sm:flex-row items-center justify-around gap-6">
                            <!-- Donut Canvas with Center Text -->
                            <div class="relative w-48 h-48 flex items-center justify-center shrink-0">
                                <canvas id="inventoryStatusChart"></canvas>
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                                    <span class="text-3xl font-black text-slate-800 leading-none">{{ $invTotal }}</span>
                                    <span class="text-xs font-bold text-slate-400 mt-1">Total Products</span>
                                </div>
                            </div>

                            <!-- Legend Breakdown -->
                            <div class="space-y-3.5 w-full sm:w-auto">
                                <div class="flex items-center justify-between sm:justify-start gap-4 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-500"></span>
                                        <span class="text-xs font-bold text-slate-700">In Stock</span>
                                    </div>
                                    <span class="text-xs font-black text-slate-900">{{ $inStock }} <span class="font-normal text-slate-400">({{ $inStockPercent }}%)</span></span>
                                </div>
                                <div class="flex items-center justify-between sm:justify-start gap-4 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3.5 h-3.5 rounded-full bg-amber-400"></span>
                                        <span class="text-xs font-bold text-slate-700">Low Stock</span>
                                    </div>
                                    <span class="text-xs font-black text-slate-900">{{ $lowStock }} <span class="font-normal text-slate-400">({{ $lowStockPercent }}%)</span></span>
                                </div>
                                <div class="flex items-center justify-between sm:justify-start gap-4 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3.5 h-3.5 rounded-full bg-rose-500"></span>
                                        <span class="text-xs font-bold text-slate-700">Out of Stock</span>
                                    </div>
                                    <span class="text-xs font-black text-slate-900">{{ $outOfStock }} <span class="font-normal text-slate-400">({{ $outOfStockPercent }}%)</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ខាងស្តាំ៖ Quick Shortcuts (Col Span 5) -->
                <div class="lg:col-span-5 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-grip"></i>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-base text-slate-900">Quick Shortcuts</h3>
                                <p class="text-xs text-slate-400">Common system operations &amp; quick access</p>
                            </div>
                        </div>

                        <!-- 6 Quick Action Buttons -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-5">
                            
                            <!-- 1. New Sale (POS) -->
                            <a href="{{ route('pos.sales') }}" class="flex flex-col items-center justify-center p-3.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-600/20 transition-all hover:scale-105 group text-center gap-2">
                                <i class="fa-solid fa-cart-shopping text-lg group-hover:scale-110 transition"></i>
                                <span>New Sale (POS)</span>
                            </a>

                            <!-- 2. Add Product -->
                            <a href="{{ route('products.create') }}" class="flex flex-col items-center justify-center p-3.5 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs shadow-md shadow-emerald-500/20 transition-all hover:scale-105 group text-center gap-2">
                                <i class="fa-solid fa-box text-lg group-hover:scale-110 transition"></i>
                                <span>Add Product</span>
                            </a>

                            <!-- 3. New Purchase -->
                            <a href="{{ route('purchases') }}" class="flex flex-col items-center justify-center p-3.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-md shadow-amber-500/20 transition-all hover:scale-105 group text-center gap-2">
                                <i class="fa-solid fa-file-invoice text-lg group-hover:scale-110 transition"></i>
                                <span>New Purchase</span>
                            </a>

                            <!-- 4. Add Customer -->
                            <a href="{{ route('customers') }}" class="flex flex-col items-center justify-center p-3.5 rounded-2xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md shadow-purple-600/20 transition-all hover:scale-105 group text-center gap-2">
                                <i class="fa-solid fa-user-plus text-lg group-hover:scale-110 transition"></i>
                                <span>Add Customer</span>
                            </a>

                            <!-- 5. Create Invoice -->
                            <a href="{{ route('invoices') }}" class="flex flex-col items-center justify-center p-3.5 rounded-2xl bg-teal-500 hover:bg-teal-600 text-white font-bold text-xs shadow-md shadow-teal-500/20 transition-all hover:scale-105 group text-center gap-2">
                                <i class="fa-solid fa-file-invoice-dollar text-lg group-hover:scale-110 transition"></i>
                                <span>Create Invoice</span>
                            </a>

                            <!-- 6. Report -->
                            <a href="{{ route('reports') }}" class="flex flex-col items-center justify-center p-3.5 rounded-2xl bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs shadow-md shadow-rose-500/20 transition-all hover:scale-105 group text-center gap-2">
                                <i class="fa-solid fa-chart-line text-lg group-hover:scale-110 transition"></i>
                                <span>Report</span>
                            </a>

                        </div>
                    </div>
                </div>

            </div>

            {{-- ========================================================================= --}}
            {{-- 6. ROW 4: ខាងឆ្វេង៖ TOP SELLING PRODUCTS | ខាងស្តាំ៖ RECENT ACTIVITIES      --}}
            {{-- ========================================================================= --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- ខាងឆ្វេង៖ Top Selling Products (Col Span 7) -->
                <div class="lg:col-span-7 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-trophy"></i>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-base text-slate-900">Top Selling Products</h3>
                                    <p class="text-xs text-slate-400">Top items ranked by units sold this month</p>
                                </div>
                            </div>
                            <a href="{{ route('products.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition">View All Products &rarr;</a>
                        </div>

                        <!-- Top Selling Table -->
                        <div class="overflow-x-auto mt-3">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="text-slate-400 uppercase text-[10px] font-bold border-b border-slate-100">
                                        <th class="py-3 px-3">#</th>
                                        <th class="py-3 px-3">Product Name</th>
                                        <th class="py-3 px-3 text-center">Sold Qty</th>
                                        <th class="py-3 px-3 text-right">Revenue</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                                    @forelse($topSellingProducts as $item)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-3 px-3 font-bold text-slate-400">
                                            <span class="w-6 h-6 rounded-full inline-flex items-center justify-center {{ $item['rank'] == 1 ? 'bg-amber-100 text-amber-700 font-black' : ($item['rank'] == 2 ? 'bg-slate-200 text-slate-700' : ($item['rank'] == 3 ? 'bg-amber-50 text-amber-800' : 'text-slate-400')) }}">
                                                {{ $item['rank'] }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex items-center gap-3">
                                                @if(!empty($item['thumbnail']))
                                                    <img src="{{ $item['thumbnail'] }}" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');" class="w-8 h-8 rounded-lg object-cover border border-slate-200" alt="{{ $item['name'] }}">
                                                    <div class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200 hidden flex items-center justify-center text-slate-500 text-sm">
                                                        <i class="fa-solid fa-laptop"></i>
                                                    </div>
                                                @else
                                                    <div class="w-8 h-8 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 text-sm">
                                                        <i class="fa-solid fa-laptop"></i>
                                                    </div>
                                                @endif
                                                <span class="font-bold text-slate-800">{{ $item['name'] }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 text-center font-bold text-slate-900">
                                            <span class="px-2.5 py-1 rounded-full bg-slate-100 font-bold text-slate-800">{{ $item['sold_qty'] }} sold</span>
                                        </td>
                                        <td class="py-3 px-3 text-right font-black text-slate-900">${{ number_format($item['revenue'], 2) }}</td>
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
                </div>

                <!-- ខាងស្តាំ៖ Recent Activities Feed (Col Span 5) -->
                <div class="lg:col-span-5 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                                    <i class="fa-solid fa-bolt"></i>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-base text-slate-900">Recent Activities</h3>
                                    <p class="text-xs text-slate-400">Real-time system events</p>
                                </div>
                            </div>
                            <a href="{{ route('invoices') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition">View All</a>
                        </div>

                        <!-- Activity List -->
                        <div class="mt-4 space-y-3">
                            @foreach($activities as $act)
                            <div class="flex items-center justify-between p-2.5 rounded-2xl hover:bg-slate-50 transition cursor-pointer group border border-transparent hover:border-slate-100">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-xl {{ $act['icon_bg'] }} {{ $act['icon_text'] }} flex items-center justify-center shrink-0 shadow-sm">
                                        <i class="{{ $act['icon'] }} text-sm"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-slate-800 truncate group-hover:text-blue-600 transition">{{ $act['title'] }}</div>
                                        <div class="text-[11px] text-slate-400 truncate">{{ $act['subtitle'] }}</div>
                                    </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-xs text-slate-300 group-hover:text-blue-600 group-hover:translate-x-0.5 transition"></i>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            {{-- ========================================================================= --}}
            {{-- 7. ROW 5: RECENT ORDERS (FULL WIDTH មួយជួរដេកតែឯងធំទូលាយដូចរូបទី ៤)          --}}
            {{-- ========================================================================= --}}
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-base text-slate-900">Recent Orders</h3>
                            <p class="text-xs text-slate-400">Latest completed customer sales &amp; transactions</p>
                        </div>
                    </div>
                    <a href="{{ route('invoices') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-700 transition">
                        <span>View all orders</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <!-- Orders Table (Full Width, No Horizontal Cramping) -->
                <div class="overflow-x-auto mt-4">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-slate-400 uppercase text-[10px] font-bold border-b border-slate-100">
                                <th class="py-3 px-4">ORDER ID</th>
                                <th class="py-3 px-4">DATE &amp; TIME</th>
                                <th class="py-3 px-4">CUSTOMER</th>
                                <th class="py-3 px-4 text-right">TOTAL AMOUNT</th>
                                <th class="py-3 px-4 text-center">PAYMENT STATUS</th>
                                <th class="py-3 px-4 text-center">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @forelse($recentOrders as $order)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 font-bold text-blue-600">{{ $order['order_number'] }}</td>
                                <td class="py-3.5 px-4 text-slate-500 text-xs">{{ $order['date'] }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-800">{{ $order['customer'] }}</td>
                                <td class="py-3.5 px-4 text-right font-black text-slate-900">${{ number_format($order['total'], 2) }}</td>
                                <td class="py-3.5 px-4 text-center">
                                    @php
                                        $st = strtolower($order['status'] ?? 'paid');
                                    @endphp
                                    @if($st === 'paid')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold bg-emerald-50 text-emerald-600 rounded-full border border-emerald-200/60">
                                            <i class="fa-solid fa-check text-[10px]"></i> Completed
                                        </span>
                                    @elseif($st === 'pending')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold bg-amber-50 text-amber-600 rounded-full border border-amber-200/60">
                                            <i class="fa-solid fa-clock text-[10px]"></i> Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold bg-rose-50 text-rose-600 rounded-full border border-rose-200/60">
                                            {{ ucfirst($order['status']) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <a href="{{ route('invoices') }}" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-500 hover:text-blue-600 inline-flex items-center justify-center transition" title="View Invoice">
                                        <i class="fa-regular fa-eye text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-slate-400">No recent orders recorded.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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