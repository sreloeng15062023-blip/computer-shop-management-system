<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employee Management | TECHZONE Computer Shop</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    </style>
</head>
<body class="bg-[#F4F6F9] text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

@php
    $isAdminOrManager = Auth::user() && in_array(strtolower(trim(Auth::user()->role->role_name ?? '')), ['admin', 'manager', 'leader']);
@endphp

<div class="flex min-h-screen">

    {{-- ========================================================================= --}}
    {{-- 1. TECHZONE SIDEBAR NAVIGATION (Feature #13 Highlighted)                 --}}
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

            <a href="{{ route('repair.service') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-screwdriver-wrench w-4 text-center"></i> Repair Service Management
            </a>

            <a href="{{ route('warranty') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-shield-halved w-4 text-center"></i> Warranty Management
            </a>

            <a href="{{ route('invoices') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800/60 hover:text-white transition text-slate-400">
                <i class="fa-solid fa-file-invoice-dollar w-4 text-center"></i> Payment &amp; Invoice
            </a>

            <!-- Active: Employee Management (Feature #13 with Sub-menu matching Mockup) -->
            <div class="space-y-1 pt-0.5">
                <a href="{{ route('employees') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30 transition">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-user-group w-4 text-center"></i> Employee Management
                    </span>
                    <i class="fa-solid fa-chevron-down text-[11px] opacity-80"></i>
                </a>

                <div class="pl-7 pr-2 py-1 space-y-1">
                    <a href="{{ route('employees') }}" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-blue-400 bg-slate-800/60 transition">
                        <i class="fa-solid fa-users text-[10px]"></i> Employee List
                    </a>
                    <a href="javascript:void(0)" onclick="openAttendanceModal()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-regular fa-calendar-check text-[10px] text-emerald-400"></i> Attendance
                    </a>
                    <a href="javascript:void(0)" onclick="openShiftScheduleModal()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-regular fa-clock text-[10px] text-amber-400"></i> Work Schedule
                    </a>
                    <a href="javascript:void(0)" onclick="openSalaryModal()" class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <i class="fa-solid fa-hand-holding-dollar text-[10px] text-purple-400"></i> Salary Management
                    </a>
                </div>
            </div>

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
                        <p class="text-[10px] text-slate-400">Administrator</p>
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
    {{-- 2. MAIN EMPLOYEE MANAGEMENT WORKSPACE                                     --}}
    {{-- ========================================================================= --}}
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">

        <!-- Top App Bar with Breadcrumbs matching Mockup -->
        <header class="bg-white border-b border-slate-200/90 px-6 py-2.5 flex items-center justify-between sticky top-0 z-20 shadow-sm no-print">
            <div class="flex items-center gap-4">
                <button class="lg:hidden text-slate-500 hover:text-slate-700">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="relative w-72 md:w-96">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" id="topNavSearch" placeholder="Search employee name, position, phone, email..."
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
                        <p class="text-[10px] text-slate-400 font-medium">Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 p-5 lg:p-6 space-y-5">

            <!-- Breadcrumb Navigation matching Mockup -->
            <div class="flex items-center justify-between text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-600 flex items-center gap-1.5"><i class="fa-solid fa-house text-[11px]"></i> Dashboard</a>
                    <span>&rsaquo;</span>
                    <a href="{{ route('employees') }}" class="hover:text-blue-600">Employee Management</a>
                    <span>&rsaquo;</span>
                    <span class="text-slate-800 font-semibold">Employee List</span>
                </div>
            </div>

            {{-- 2.1 Header Row matching Mockup --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shadow-md shadow-blue-500/20">
                    <i class="fa-solid fa-user-group"></i>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-900 leading-tight">Employee Management</h2>
                    <p class="text-xs text-slate-400 font-medium">Manage employee information, attendance, work schedule and salary</p>
                </div>
            </div>

            {{-- 2.2 FIVE STAT CARDS matching Mockup --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-3.5">
                
                <!-- Card 1: Total Employees -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">Total Employees</p>
                        <h3 class="text-xl font-extrabold text-slate-900">{{ number_format($totalEmployees) }}</h3>
                        <p class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> + 2 <span class="text-slate-400 font-normal">(this month)</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>

                <!-- Card 2: Active Employees -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">Active Employees</p>
                        <h3 class="text-xl font-extrabold text-emerald-600">{{ number_format($activeEmployees) }}</h3>
                        <p class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> 83.3%
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>

                <!-- Card 3: On Leave -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">On Leave</p>
                        <h3 class="text-xl font-extrabold text-amber-500">{{ number_format($onLeaveEmployees) }}</h3>
                        <p class="text-[10px] font-bold text-amber-500 flex items-center gap-1">
                            8.3%
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                </div>

                <!-- Card 4: Inactive Employees -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">Inactive Employees</p>
                        <h3 class="text-xl font-extrabold text-rose-600">{{ number_format($inactiveEmployees) }}</h3>
                        <p class="text-[10px] font-bold text-rose-500 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-down"></i> 8.3%
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                </div>

                <!-- Card 5: Total Monthly Salary (Protected by Role: Admin/Manager) -->
                <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">Total Monthly Salary</p>
                        @if($isAdminOrManager)
                            <h3 class="text-xl font-extrabold text-purple-600 font-mono">${{ number_format($totalMonthlySalary, 2) }}</h3>
                        @else
                            <h3 class="text-xl font-extrabold text-slate-400 font-mono">&bull;&bull;&bull;&bull;&bull;&bull;</h3>
                        @endif
                        <p class="text-[10px] text-slate-400 font-medium">Payroll Active</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                </div>

            </div>

            {{-- 2.3 FILTER BAR matching Mockup --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-3.5 shadow-sm flex flex-col xl:flex-row items-stretch xl:items-center justify-between gap-3 text-xs" id="tableFilterSection">
                <div class="flex items-center gap-3">
                    <span class="font-extrabold text-slate-900 text-sm">Employee List</span>
                </div>

                <div class="flex flex-wrap items-center gap-2.5 flex-1 xl:justify-end">
                    <div class="relative flex-1 sm:max-w-xs">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" id="filterSearch" value="{{ request('search') }}"
                               placeholder="Search employee name, position, phone, email..."
                               onkeyup="if(event.key==='Enter') applyFilters()"
                               class="w-full pl-8 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-blue-500 focus:outline-none transition">
                    </div>

                    <!-- Roles Filter -->
                    <select id="filterRole" onchange="applyFilters()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none">
                        <option value="all">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->role_name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Status Filter -->
                    <select id="filterStatus" onchange="applyFilters()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none">
                        <option value="all">All Status</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="On Leave" {{ request('status') == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    <!-- Export button -->
                    <button type="button" onclick="Swal.fire('Exporting', 'Employee directory exported to Excel/CSV successfully', 'success')" class="px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl font-semibold flex items-center gap-1.5 transition">
                        <i class="fa-solid fa-file-export text-slate-500"></i> Export
                    </button>

                    <!-- Add Employee Button -->
                    <button type="button" onclick="scrollToAddEmployee()" class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition">
                        <i class="fa-solid fa-plus text-xs"></i> Add Employee
                    </button>
                </div>
            </div>

            {{-- 2.4 EMPLOYEE DIRECTORY TABLE matching Mockup --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm space-y-3">
                <div class="overflow-x-auto scrollbar-thin">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-500 font-semibold border-y border-slate-200">
                            <tr>
                                <th class="py-3 px-3 w-8"><input type="checkbox" class="rounded text-blue-600"></th>
                                <th class="py-3 px-3">#</th>
                                <th class="py-3 px-3">Photo</th>
                                <th class="py-3 px-3">Employee ID</th>
                                <th class="py-3 px-3">Full Name</th>
                                <th class="py-3 px-3">Position</th>
                                <th class="py-3 px-3">Role</th>
                                <th class="py-3 px-3">Phone</th>
                                <th class="py-3 px-3">Email</th>
                                <th class="py-3 px-3">Hire Date</th>
                                <th class="py-3 px-3">Status</th>
                                <th class="py-3 px-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($employees as $idx => $emp)
                                <tr class="hover:bg-slate-50/80 transition cursor-pointer" onclick="selectEmployeePreview({{ $emp->id }})">
                                    <td class="py-3 px-3" onclick="event.stopPropagation()"><input type="checkbox" class="rounded text-blue-600"></td>
                                    <td class="py-3 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                    
                                    <!-- Photo Avatar -->
                                    <td class="py-3 px-3">
                                        <img src="{{ $emp->avatar ?: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&h=80&q=80' }}"
                                             alt="{{ $emp->full_name }}" class="w-8 h-8 rounded-full object-cover ring-1 ring-slate-200">
                                    </td>

                                    <td class="py-3 px-3 font-mono font-bold text-blue-600">{{ $emp->employee_id }}</td>
                                    <td class="py-3 px-3 font-bold text-slate-900">{{ $emp->full_name }}</td>
                                    <td class="py-3 px-3 text-slate-700">{{ $emp->position }}</td>
                                    
                                    <!-- Role Badge -->
                                    <td class="py-3 px-3">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $emp->role->role_name ?? 'Staff' }}
                                        </span>
                                    </td>

                                    <td class="py-3 px-3 font-mono text-slate-600">{{ $emp->phone }}</td>
                                    <td class="py-3 px-3 text-slate-500">{{ $emp->email }}</td>
                                    <td class="py-3 px-3 font-mono text-slate-500">{{ $emp->hire_date->format('Y-m-d') }}</td>

                                    <!-- Status Badges matching Mockup -->
                                    <td class="py-3 px-3">
                                        @if($emp->status === 'Active')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                Active
                                            </span>
                                        @elseif($emp->status === 'On Leave')
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                                On Leave
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Action Buttons (View, Edit, Delete) -->
                                    <td class="py-3 px-3 text-right space-x-1.5 whitespace-nowrap" onclick="event.stopPropagation()">
                                        <button type="button" onclick="selectEmployeePreview({{ $emp->id }})" title="View Details" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                        <button type="button" onclick="populateEditForm({{ $emp->id }})" title="Edit Employee" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg transition">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" onclick="triggerAttendanceRecord({{ $emp->id }}, '{{ addslashes($emp->full_name) }}')" title="Record Attendance (Check In/Out)" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition">
                                            <i class="fa-regular fa-calendar-check"></i>
                                        </button>
                                        @if($isAdminOrManager)
                                            <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="inline-block" onsubmit="return confirm('តើអ្នកប្រាកដជាចង់ប្តូរបុគ្គលិកនេះទៅជា Inactive មែនទេ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Deactivate" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="py-8 text-center text-slate-400">មិនមានទិន្នន័យបុគ្គលិកត្រូវនឹងលក្ខខណ្ឌស្វែងរកឡើយ</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                    <div>
                        Showing {{ $employees->firstItem() ?? 0 }} to {{ $employees->lastItem() ?? 0 }} of {{ $employees->total() }} entries
                    </div>
                    <div>
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>

            {{-- 2.5 THREE BOTTOM PANELS matching Mockup --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 pt-2">

                {{-- PANEL 1: Add New Employee (4 cols) --}}
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4" id="addEmployeeSection">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-user-plus text-blue-600"></i> Add New Employee
                        </h3>
                        <button type="button" onclick="document.getElementById('addEmpForm').reset()" class="text-xs text-slate-400 hover:text-slate-600">
                            Reset
                        </button>
                    </div>

                    <form id="addEmpForm" action="{{ route('employees.store') }}" method="POST" class="space-y-3 text-xs">
                        @csrf
                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Full Name *</label>
                            <input type="text" name="full_name" placeholder="Enter full name" required
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">Last Name</label>
                                <input type="text" name="last_name" placeholder="Last name" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                            </div>
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">First Name</label>
                                <input type="text" name="first_name" placeholder="First name" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none font-mono">
                            </div>
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">Gender *</label>
                                <select name="gender" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Phone Number *</label>
                            <input type="text" name="phone" placeholder="Enter phone number" required
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        </div>

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Email Address *</label>
                            <input type="email" name="email" placeholder="Enter email address" required
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">Position *</label>
                                <input type="text" name="position" placeholder="e.g. Sales Staff" required
                                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                            </div>
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">System Role</label>
                                <select name="role_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                                    @foreach($roles as $r)
                                        <option value="{{ $r->id }}">{{ $r->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if($isAdminOrManager)
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="font-bold text-slate-700 block mb-1">Monthly Salary ($)</label>
                                    <input type="number" name="salary" step="0.01" value="800.00" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none font-mono">
                                </div>
                                <div>
                                    <label class="font-bold text-slate-700 block mb-1">Hire Date</label>
                                    <input type="date" name="hire_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none font-mono">
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="salary" value="500">
                            <input type="hidden" name="hire_date" value="{{ date('Y-m-d') }}">
                        @endif

                        <input type="hidden" name="status" value="Active">

                        <div class="pt-2 flex items-center justify-end gap-2">
                            <button type="button" onclick="document.getElementById('addEmpForm').reset()" class="px-4 py-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 transition">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition">
                                Save Employee
                            </button>
                        </div>
                    </form>
                </div>

                {{-- PANEL 2: Employee Details (Profile Card matching Mockup) (4 cols) --}}
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4" id="employeeDetailsSection">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-regular fa-id-card text-blue-600"></i> Employee Details
                        </h3>
                        <button type="button" onclick="scrollToTable()" class="text-xs text-blue-600 hover:underline">
                            Back
                        </button>
                    </div>

                    <!-- Profile Banner matching Mockup -->
                    <div class="text-center py-2 space-y-1">
                        <img id="dtAvatar" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&h=120&q=80"
                             alt="Avatar" class="w-16 h-16 rounded-full object-cover mx-auto ring-4 ring-blue-500/20 shadow-sm">
                        <h4 class="font-extrabold text-slate-900 text-sm flex items-center justify-center gap-2">
                            <span id="dtFullName">{{ $featuredEmployee->full_name ?? 'Sok Dara' }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200" id="dtStatus">Active</span>
                        </h4>
                        <p class="text-xs text-slate-400 font-medium" id="dtPositionCode">Store Manager | EMP-001</p>
                    </div>

                    <!-- Navigation Tabs matching Mockup: Personal Info / Work Information / Salary / Attendance -->
                    <div class="flex items-center justify-around border-b border-slate-100 text-[11px] font-semibold text-slate-400">
                        <button type="button" class="pb-1.5 border-b-2 border-blue-600 text-blue-600">Personal Info</button>
                        <button type="button" onclick="Swal.fire('Work Info', 'កាលវិភាគវេនការងារ និងប្រវត្តិការងារ', 'info')" class="pb-1.5 hover:text-slate-600">Work Info</button>
                        <button type="button" onclick="openSalaryModal()" class="pb-1.5 hover:text-slate-600">Salary</button>
                        <button type="button" onclick="openAttendanceModal()" class="pb-1.5 hover:text-slate-600">Attendance</button>
                    </div>

                    <!-- Personal Information Attributes Table matching Mockup -->
                    <div class="space-y-2 text-xs text-slate-600">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Full Name:</span>
                            <span class="font-bold text-slate-800" id="dtAttrFullName">{{ $featuredEmployee->full_name ?? 'Sok Dara' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Date of Birth:</span>
                            <span class="font-mono text-slate-700" id="dtAttrDOB">1998-05-12</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Gender:</span>
                            <span class="text-slate-700" id="dtAttrGender">Male</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Phone:</span>
                            <span class="font-mono font-bold text-slate-800" id="dtAttrPhone">012 345 678</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Email:</span>
                            <span class="text-slate-700" id="dtAttrEmail">dara@example.com</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Address:</span>
                            <span class="text-slate-700 text-right truncate max-w-[170px]" id="dtAttrAddress">Svay Dangkum, Siem Reap, Cambodia</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Hire Date:</span>
                            <span class="font-mono text-slate-700" id="dtAttrHire">2024-01-15</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Role:</span>
                            <span class="font-bold text-blue-600" id="dtAttrRole">Manager</span>
                        </div>
                        @if($isAdminOrManager)
                            <div class="flex justify-between pt-1 border-t border-slate-100 font-bold">
                                <span class="text-slate-400">Salary:</span>
                                <span class="font-mono text-purple-600" id="dtAttrSalary">${{ number_format($featuredEmployee->salary ?? 1500, 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- PANEL 3: Edit Employee matching Mockup (4 cols) --}}
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4" id="editEmployeeSection">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-regular fa-pen-to-square text-amber-500"></i> Edit Employee
                        </h3>
                        <span class="text-[11px] text-slate-400 font-mono" id="editEmpIdLabel">EMP-001</span>
                    </div>

                    <form id="editEmpForm" onsubmit="submitEditEmployee(event)" class="space-y-3 text-xs">
                        <input type="hidden" id="editEmpIdHidden" value="{{ $featuredEmployee->id ?? 1 }}">

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Full Name *</label>
                            <input type="text" id="editFullName" value="{{ $featuredEmployee->full_name ?? 'Sok Dara' }}" required
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">Last Name</label>
                                <input type="text" id="editLastName" value="Sok" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                            </div>
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">First Name</label>
                                <input type="text" id="editFirstName" value="Dara" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">Date of Birth</label>
                                <input type="date" id="editDOB" value="1998-05-12" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none font-mono">
                            </div>
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">Gender</label>
                                <select id="editGender" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                                    <option value="Male" selected>Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Phone Number *</label>
                            <input type="text" id="editPhone" value="012 345 678" required
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        </div>

                        <div>
                            <label class="font-bold text-slate-700 block mb-1">Email *</label>
                            <input type="email" id="editEmail" value="dara@example.com" required
                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">Position *</label>
                                <input type="text" id="editPosition" value="Store Manager" required
                                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                            </div>
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">Status</label>
                                <select id="editStatus" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none">
                                    <option value="Active" selected>Active</option>
                                    <option value="On Leave">On Leave</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        @if($isAdminOrManager)
                            <div>
                                <label class="font-bold text-slate-700 block mb-1">Monthly Salary ($)</label>
                                <input type="number" id="editSalary" step="0.01" value="1500.00" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none font-mono">
                            </div>
                        @else
                            <input type="hidden" id="editSalary" value="1500.00">
                        @endif

                        <div class="pt-2 flex items-center justify-end gap-2">
                            <button type="button" onclick="scrollToTable()" class="px-4 py-2 border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 transition">
                                Cancel
                            </button>
                            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition">
                                Update Employee
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </main>
    </div>

</div>

{{-- ========================================================================= --}}
{{-- 3. MODAL: ATTENDANCE TRACKER (Step 6.2)                                   --}}
{{-- ========================================================================= --}}
<div id="attendanceModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 no-print">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-5 relative border border-slate-200 text-xs">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <h4 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-regular fa-calendar-check text-emerald-600"></i> Today's Attendance Log ({{ date('Y-m-d') }})
            </h4>
            <button onclick="closeAttendanceModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <div class="py-3 divide-y divide-slate-100 max-h-72 overflow-y-auto scrollbar-thin">
            @forelse($todayAttendances as $att)
                <div class="py-2.5 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ $att->employee->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                        <div>
                            <p class="font-bold text-slate-800">{{ $att->employee->full_name }}</p>
                            <p class="text-[10px] text-slate-400">{{ $att->employee->position }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                            {{ $att->status }}
                        </span>
                        <p class="text-[10px] font-mono text-slate-500 mt-0.5">In: {{ $att->check_in }} &bull; Out: {{ $att->check_out ?? 'Active' }}</p>
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-slate-400">មិនទាន់មានទិន្នន័យវត្តមានថ្ងៃនេះនៅឡើយទេ</div>
            @endforelse
        </div>

        <div class="pt-3 border-t border-slate-100 flex justify-end">
            <button type="button" onclick="closeAttendanceModal()" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-semibold">
                Close
            </button>
        </div>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 4. MODAL: SHIFT SCHEDULE CALENDAR (Step 6.2)                              --}}
{{-- ========================================================================= --}}
<div id="shiftScheduleModalBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 no-print">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-5 relative border border-slate-200 text-xs">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <h4 class="font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-regular fa-clock text-amber-500"></i> Work Schedule &amp; Shift Calendar
            </h4>
            <button onclick="closeShiftScheduleModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <div class="py-3 space-y-2 text-xs">
            <div class="p-3 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-between">
                <div>
                    <span class="font-bold text-blue-900">Morning Shift (វេនព្រឹក)</span>
                    <p class="text-[11px] text-blue-700">08:00 AM - 12:00 PM &bull; Mon - Sat</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-white text-blue-700 border border-blue-200">Cashier, Sales</span>
            </div>

            <div class="p-3 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-between">
                <div>
                    <span class="font-bold text-amber-900">Afternoon Shift (វេនរសៀល)</span>
                    <p class="text-[11px] text-amber-700">01:00 PM - 05:00 PM &bull; Mon - Sat</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-white text-amber-700 border border-amber-200">Sales, Technicians</span>
            </div>

            <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-between">
                <div>
                    <span class="font-bold text-emerald-900">Full Day Shift (ពេញម៉ោង)</span>
                    <p class="text-[11px] text-emerald-700">08:00 AM - 05:00 PM (1 hr break) &bull; Mon - Sat</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-white text-emerald-700 border border-emerald-200">Managers, Storekeeper</span>
            </div>
        </div>

        <div class="pt-3 border-t border-slate-100 flex justify-end">
            <button type="button" onclick="closeShiftScheduleModal()" class="px-4 py-2 bg-blue-600 text-white rounded-xl font-semibold">
                Close
            </button>
        </div>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 5. JAVASCRIPT STATE ENGINE FOR EMPLOYEES                                  --}}
{{-- ========================================================================= --}}
<script>
    async function selectEmployeePreview(empId) {
        try {
            const res = await fetch(`/employees/${empId}`);
            const data = await res.json();
            if (data.success) {
                const emp = data.employee;
                document.getElementById('dtAvatar').src = emp.avatar || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&h=120&q=80';
                document.getElementById('dtFullName').textContent = emp.full_name;
                document.getElementById('dtPositionCode').textContent = `${emp.position} | ${emp.employee_id}`;
                document.getElementById('dtStatus').textContent = emp.status;

                document.getElementById('dtAttrFullName').textContent = emp.full_name;
                document.getElementById('dtAttrDOB').textContent = emp.date_of_birth || 'N/A';
                document.getElementById('dtAttrGender').textContent = emp.gender;
                document.getElementById('dtAttrPhone').textContent = emp.phone;
                document.getElementById('dtAttrEmail').textContent = emp.email;
                document.getElementById('dtAttrAddress').textContent = emp.address || 'Phnom Penh';
                document.getElementById('dtAttrHire').textContent = emp.hire_date;
                document.getElementById('dtAttrRole').textContent = emp.role ? emp.role.role_name : 'Staff';
                
                const salaryEl = document.getElementById('dtAttrSalary');
                if (salaryEl) {
                    salaryEl.textContent = `$${parseFloat(emp.salary).toFixed(2)}`;
                }

                // Also populate Edit form
                populateEditFormWithData(emp);

                document.getElementById('employeeDetailsSection').scrollIntoView({ behavior: 'smooth' });
            }
        } catch (e) {
            console.error(e);
        }
    }

    async function populateEditForm(empId) {
        try {
            const res = await fetch(`/employees/${empId}`);
            const data = await res.json();
            if (data.success) {
                populateEditFormWithData(data.employee);
                document.getElementById('editEmployeeSection').scrollIntoView({ behavior: 'smooth' });
            }
        } catch (e) {}
    }

    function populateEditFormWithData(emp) {
        document.getElementById('editEmpIdHidden').value = emp.id;
        document.getElementById('editEmpIdLabel').textContent = emp.employee_id;
        document.getElementById('editFullName').value = emp.full_name;
        document.getElementById('editFirstName').value = emp.first_name || '';
        document.getElementById('editLastName').value = emp.last_name || '';
        document.getElementById('editDOB').value = emp.date_of_birth || '';
        document.getElementById('editGender').value = emp.gender || 'Male';
        document.getElementById('editPhone').value = emp.phone;
        document.getElementById('editEmail').value = emp.email;
        document.getElementById('editPosition').value = emp.position;
        document.getElementById('editStatus').value = emp.status;
        const salInput = document.getElementById('editSalary');
        if (salInput) salInput.value = emp.salary;
    }

    async function submitEditEmployee(e) {
        e.preventDefault();
        const id = document.getElementById('editEmpIdHidden').value;
        const payload = {
            full_name: document.getElementById('editFullName').value,
            first_name: document.getElementById('editFirstName').value,
            last_name: document.getElementById('editLastName').value,
            date_of_birth: document.getElementById('editDOB').value || null,
            gender: document.getElementById('editGender').value,
            phone: document.getElementById('editPhone').value,
            email: document.getElementById('editEmail').value,
            position: document.getElementById('editPosition').value,
            status: document.getElementById('editStatus').value,
            salary: document.getElementById('editSalary')?.value || 500,
        };

        try {
            const res = await fetch(`/employees/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            if (data.success) {
                Swal.fire('ជោគជ័យ!', data.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('បរាជ័យ', data.message || 'មិនអាចកែប្រែបានទេ', 'error');
            }
        } catch (err) {
            Swal.fire('កំហុស', 'មិនអាចភ្ជាប់ម៉ាស៊ីនបម្រើបានទេ', 'error');
        }
    }

    async function triggerAttendanceRecord(empId, empName) {
        Swal.fire({
            title: `កត់ត្រាវត្តមានសម្រាប់ ${empName}`,
            text: 'តើអ្នកចង់កត់ត្រា Check In ឬ Check Out សម្រាប់ថ្ងៃនេះមែនទេ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'កត់ត្រាភ្លាមៗ',
            confirmButtonColor: '#10B981',
            cancelButtonText: 'បោះបង់',
        }).then(async res => {
            if (res.isConfirmed) {
                try {
                    const response = await fetch(`/employees/${empId}/attendance`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    });
                    const d = await response.json();
                    if (d.success) {
                        Swal.fire('ជោគជ័យ!', d.message, 'success').then(() => location.reload());
                    }
                } catch (e) {
                    Swal.fire('កំហុស', 'មិនអាចកត់ត្រាវត្តមានបានឡើយ', 'error');
                }
            }
        });
    }

    function openAttendanceModal() {
        document.getElementById('attendanceModalBackdrop').classList.remove('hidden');
    }

    function closeAttendanceModal() {
        document.getElementById('attendanceModalBackdrop').classList.add('hidden');
    }

    function openShiftScheduleModal() {
        document.getElementById('shiftScheduleModalBackdrop').classList.remove('hidden');
    }

    function closeShiftScheduleModal() {
        document.getElementById('shiftScheduleModalBackdrop').classList.add('hidden');
    }

    function openSalaryModal() {
        @if($isAdminOrManager)
            Swal.fire({
                title: 'ការគ្រប់គ្រងប្រាក់ខែ (Salary Management)',
                html: `
                    <div class="text-left text-xs space-y-2">
                        <p>ប្រាក់បៀវត្សរ៍សរុបប្រចាំខែ៖ <b class="text-purple-600 font-mono text-sm">${{ number_format($totalMonthlySalary, 2) }}</b></p>
                        <p class="text-slate-500">បុគ្គលិកសកម្មទាំងអស់៖ <b>{{ $activeEmployees }} នាក់</b></p>
                        <p class="text-slate-400">ប្រព័ន្ធ Payroll ដំណើរការធម្មតា។</p>
                    </div>
                `,
                icon: 'info'
            });
        @else
            Swal.fire('ការអនុញ្ញាតត្រូវបានបដិសេធ', 'មានតែ Admin ឬ Manager ទើបអាចមើលព័ត៌មានប្រាក់ខែបាន។', 'warning');
        @endif
    }

    function scrollToAddEmployee() {
        document.getElementById('addEmployeeSection').scrollIntoView({ behavior: 'smooth' });
    }

    function scrollToTable() {
        document.getElementById('tableFilterSection').scrollIntoView({ behavior: 'smooth' });
    }

    function applyFilters() {
        const search = document.getElementById('filterSearch').value || document.getElementById('topNavSearch').value;
        const role = document.getElementById('filterRole').value;
        const status = document.getElementById('filterStatus').value;

        const p = new URLSearchParams();
        if (search) p.append('search', search);
        if (role && role !== 'all') p.append('role_id', role);
        if (status && status !== 'all') p.append('status', status);

        window.location.href = "{{ route('employees') }}?" + p.toString();
    }
</script>

</body>
</html>
