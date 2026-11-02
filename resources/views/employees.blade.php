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
    {{-- 1. TECHZONE SIDEBAR NAVIGATION                                           --}}
    {{-- ========================================================================= --}}
    @include('sidebar')

    {{-- ========================================================================= --}}
    {{-- 2. MAIN EMPLOYEE MANAGEMENT WORKSPACE                                     --}}
    {{-- ========================================================================= --}}
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">

        <!-- Top App Bar with Search -->
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

            <!-- Breadcrumb Navigation -->
            <div class="flex items-center justify-between text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-600 flex items-center gap-1.5"><i class="fa-solid fa-house text-[11px]"></i> Dashboard</a>
                    <span>&rsaquo;</span>
                    <a href="{{ route('employees') }}" class="hover:text-blue-600">Employee Management</a>
                    <span>&rsaquo;</span>
                    <span class="text-slate-800 font-semibold">Employee List</span>
                </div>
            </div>

            {{-- 2.1 Header Row with + Add Employee Button --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl shadow-md shadow-blue-500/20">
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 leading-tight">Employee Management</h2>
                        <p class="text-xs text-slate-400 font-medium">Manage employee information, attendance, work schedule and salary</p>
                    </div>
                </div>

                <!-- + Add Employee Button (Opens Popup Modal) -->
                <button type="button" onclick="openAddModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-blue-600/20 hover:shadow-lg transition active:scale-95">
                    <i class="fa-solid fa-plus text-xs"></i> Add Employee
                </button>
            </div>

            {{-- 2.2 FIVE STAT CARDS --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-3.5">
                
                <!-- Card 1: Total Employees -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">Total Employees</p>
                        <h3 class="text-xl font-extrabold text-slate-900 font-mono">{{ number_format($totalEmployees) }}</h3>
                        <p class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> + 2 <span class="text-slate-400 font-normal">(this month)</span>
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>

                <!-- Card 2: Active Employees -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">Active Employees</p>
                        <h3 class="text-xl font-extrabold text-emerald-600 font-mono">{{ number_format($activeEmployees) }}</h3>
                        <p class="text-[10px] font-bold text-emerald-600 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-up"></i> 83.3%
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>

                <!-- Card 3: On Leave -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">On Leave</p>
                        <h3 class="text-xl font-extrabold text-amber-500 font-mono">{{ number_format($onLeaveEmployees) }}</h3>
                        <p class="text-[10px] font-bold text-amber-500 flex items-center gap-1">
                            8.3%
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-user-clock"></i>
                    </div>
                </div>

                <!-- Card 4: Inactive Employees -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[11px] font-semibold text-slate-400">Inactive Employees</p>
                        <h3 class="text-xl font-extrabold text-rose-600 font-mono">{{ number_format($inactiveEmployees) }}</h3>
                        <p class="text-[10px] font-bold text-rose-500 flex items-center gap-1">
                            <i class="fa-solid fa-arrow-trend-down"></i> 8.3%
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-base shadow-sm">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                </div>

                <!-- Card 5: Total Monthly Salary -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs flex items-center justify-between">
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

            {{-- ================================================================= --}}
            {{-- 2.3 FULL-WIDTH EMPLOYEE DIRECTORY TABLE                           --}}
            {{-- ================================================================= --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden" id="tableSection">

                <!-- Filter Header Bar -->
                <div class="p-4 border-b border-slate-200/80 bg-slate-50/50 flex flex-col xl:flex-row items-stretch xl:items-center justify-between gap-3 text-xs" id="tableFilterSection">
                    <div class="flex items-center gap-3">
                        <span class="font-extrabold text-slate-900 text-sm">Employee List</span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-200">
                            {{ $employees->total() }} total
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5 flex-1 xl:justify-end">
                        <div class="relative flex-1 sm:max-w-xs">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" id="filterSearch" value="{{ request('search') }}"
                                   placeholder="Search employee name, position, phone, email..."
                                   onkeyup="if(event.key==='Enter') applyFilters()"
                                   class="w-full pl-8 pr-3 py-2 bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:outline-none transition">
                        </div>

                        <!-- Roles Filter -->
                        <select id="filterRole" onchange="applyFilters()" class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 focus:outline-none">
                            <option value="all">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->role_name }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Status Filter -->
                        <select id="filterStatus" onchange="applyFilters()" class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 focus:outline-none">
                            <option value="all">All Status</option>
                            <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="On Leave" {{ request('status') == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                            <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        <!-- Export button -->
                        <button type="button" onclick="Swal.fire('Exporting', 'Employee directory exported to Excel/CSV successfully', 'success')" class="px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl font-semibold flex items-center gap-1.5 transition shadow-2xs">
                            <i class="fa-solid fa-file-export text-slate-500"></i> Export
                        </button>

                        <!-- + Add Employee Button -->
                        <button type="button" onclick="openAddModal()" class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition active:scale-95">
                            <i class="fa-solid fa-plus text-xs"></i> + Add Employee
                        </button>
                    </div>
                </div>

                <!-- Full Width Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs text-slate-600">
                        <thead>
                            <tr class="bg-slate-50/75 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-4 w-10 text-center"><input type="checkbox" class="rounded text-blue-600"></th>
                                <th class="py-3.5 px-4 w-12 text-center">#</th>
                                <th class="py-3.5 px-4">Photo</th>
                                <th class="py-3.5 px-4">Employee ID</th>
                                <th class="py-3.5 px-4">Full Name</th>
                                <th class="py-3.5 px-4">Position</th>
                                <th class="py-3.5 px-4">Role</th>
                                <th class="py-3.5 px-4">Phone</th>
                                <th class="py-3.5 px-4">Email</th>
                                <th class="py-3.5 px-4">Hire Date</th>
                                <th class="py-3.5 px-4 text-center">Status</th>
                                <th class="py-3.5 px-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($employees as $idx => $emp)
                                <tr class="hover:bg-slate-50/80 transition cursor-pointer" onclick="openViewModal({{ $emp->id }})">
                                    <td class="py-3.5 px-4 text-center" onclick="event.stopPropagation()">
                                        <input type="checkbox" class="rounded text-blue-600">
                                    </td>
                                    <td class="py-3.5 px-4 text-center text-slate-400 font-mono">
                                        {{ $employees->firstItem() ? ($employees->firstItem() + $idx) : ($idx + 1) }}
                                    </td>
                                    
                                    <!-- Photo Avatar -->
                                    <td class="py-3.5 px-4">
                                        <img src="{{ $emp->avatar ?: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&h=80&q=80' }}"
                                             alt="{{ $emp->full_name }}" class="w-8 h-8 rounded-full object-cover ring-1 ring-slate-200 shadow-2xs">
                                    </td>

                                    <td class="py-3.5 px-4 font-mono font-bold text-blue-600">{{ $emp->employee_id }}</td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">{{ $emp->full_name }}</td>
                                    <td class="py-3.5 px-4 text-slate-700">{{ $emp->position }}</td>
                                    
                                    <!-- Role Badge -->
                                    <td class="py-3.5 px-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ $emp->role->role_name ?? 'Staff' }}
                                        </span>
                                    </td>

                                    <td class="py-3.5 px-4 font-mono text-slate-600">{{ $emp->phone }}</td>
                                    <td class="py-3.5 px-4 text-slate-500">{{ $emp->email }}</td>
                                    <td class="py-3.5 px-4 font-mono text-slate-500">{{ $emp->hire_date->format('Y-m-d') }}</td>

                                    <!-- Status Badge -->
                                    <td class="py-3.5 px-4 text-center">
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

                                    <!-- Action Buttons matching Brand / Repair Service style -->
                                    <td class="py-3.5 px-4 text-center" onclick="event.stopPropagation()">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- View Details Button -->
                                            <button type="button" onclick="openViewModal({{ $emp->id }})" class="w-8 h-8 rounded-lg bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center transition shadow-2xs" title="View Details">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </button>

                                            <!-- Edit Employee Button -->
                                            <button type="button" onclick="openEditModal({{ $emp->id }})" class="w-8 h-8 rounded-lg bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition shadow-2xs" title="Edit Employee">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </button>

                                            <!-- Record Attendance Button -->
                                            <button type="button" onclick="triggerAttendanceRecord({{ $emp->id }}, '{{ addslashes($emp->full_name) }}')" class="w-8 h-8 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center transition shadow-2xs" title="Record Attendance (Check In/Out)">
                                                <i class="fa-regular fa-calendar-check text-xs"></i>
                                            </button>

                                            @if($isAdminOrManager)
                                                <!-- Deactivate / Delete Button -->
                                                <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="inline-block" onsubmit="return confirm('តើអ្នកប្រាកដជាចង់ប្តូរបុគ្គលិកនេះទៅជា Inactive មែនទេ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-8 h-8 rounded-lg bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center transition shadow-2xs" title="Deactivate Employee">
                                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="py-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-solid fa-users-slash text-3xl mb-2 text-slate-300"></i>
                                            <p class="font-medium">មិនមានទិន្នន័យបុគ្គលិកត្រូវនឹងលក្ខខណ្ឌស្វែងរកឡើយ</p>
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
                        Showing {{ $employees->firstItem() ?? 0 }} to {{ $employees->lastItem() ?? 0 }} of {{ $employees->total() }} entries
                    </div>
                    <div>
                        {{ $employees->links() }}
                    </div>
                </div>

            </div>

        </main>
    </div>

</div>

{{-- ========================================================================= --}}
{{-- 3. POPUP MODAL: ADD NEW EMPLOYEE (FORM MODAL LIKE BRAND ADD)               --}}
{{-- ========================================================================= --}}
<div id="addModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 leading-tight">Add New Employee</h3>
                    <p class="text-xs text-slate-500">Register employee personal information, role and employment terms</p>
                </div>
            </div>
            <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Form Body -->
        <form id="addEmpForm" action="{{ route('employees.store') }}" method="POST" class="p-6 space-y-4 overflow-y-auto flex-1 text-xs">
            @csrf

            <!-- Full Name & Position -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="full_name" placeholder="Enter full name" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Position <span class="text-rose-500">*</span></label>
                    <input type="text" name="position" placeholder="e.g. Sales Staff, Cashier, Technician" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
            </div>

            <!-- First & Last Name -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Last Name</label>
                    <input type="text" name="last_name" placeholder="Last name"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">First Name</label>
                    <input type="text" name="first_name" placeholder="First name"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Date of Birth & Gender -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Date of Birth</label>
                    <input type="date" name="date_of_birth"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition font-mono">
                </div>
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Gender <span class="text-rose-500">*</span></label>
                    <select name="gender" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <!-- Phone & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Phone Number <span class="text-rose-500">*</span></label>
                    <input type="text" name="phone" placeholder="e.g. 012 345 678" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition font-mono">
                </div>
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Email Address <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" placeholder="e.g. employee@techzone.com" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Role & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">System Role</label>
                    <select name="role_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        @foreach($roles as $r)
                            <option value="{{ $r->id }}">{{ $r->role_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Status <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        <option value="Active">Active</option>
                        <option value="On Leave">On Leave</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <!-- Address -->
            <div>
                <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Address</label>
                <input type="text" name="address" placeholder="Enter current address or province"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
            </div>

            <!-- Salary & Hire Date (Admin / Manager) -->
            @if($isAdminOrManager)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Monthly Salary ($)</label>
                        <input type="number" name="salary" step="0.01" value="500.00" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition font-mono">
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Hire Date <span class="text-rose-500">*</span></label>
                        <input type="date" name="hire_date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition font-mono">
                    </div>
                </div>
            @else
                <input type="hidden" name="salary" value="500.00">
                <input type="hidden" name="hire_date" value="{{ date('Y-m-d') }}">
            @endif

            <!-- Action Buttons Footer -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md shadow-blue-600/20 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-user-plus text-xs"></i> Save Employee
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 4. POPUP MODAL: VIEW EMPLOYEE DETAILS (READ DETAILS LIKE BRAND VIEW)       --}}
{{-- ========================================================================= --}}
<div id="viewModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl w-full max-w-xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                    <i class="fa-regular fa-id-card"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 leading-tight">Employee Details</h3>
                    <p class="text-xs text-slate-500 font-mono" id="view_emp_id_code">EMP-001</p>
                </div>
            </div>
            <button type="button" onclick="closeViewModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-4 overflow-y-auto flex-1 text-xs">
            <!-- Profile Banner -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between">
                <div class="flex items-center gap-3.5">
                    <img id="view_avatar" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&h=120&q=80"
                         alt="Avatar" class="w-14 h-14 rounded-full object-cover ring-2 ring-blue-500/20 shadow-sm">
                    <div>
                        <h4 class="font-bold text-sm text-slate-900" id="view_fullname">Sreyloeng Yoeup</h4>
                        <p class="text-xs text-slate-400 font-medium mt-0.5" id="view_position_code">Store Manager | EMP-001</p>
                    </div>
                </div>
                <div id="view_status_badge">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">Active</span>
                </div>
            </div>

            <!-- Navigation Tabs: Personal Info / Work Info / Salary / Attendance -->
            <div class="flex items-center justify-around border-b border-slate-100 text-[11px] font-semibold text-slate-400">
                <button type="button" class="pb-1.5 border-b-2 border-blue-600 text-blue-600">Personal Info</button>
                <button type="button" onclick="openShiftScheduleModal()" class="pb-1.5 hover:text-slate-600">Work Info</button>
                <button type="button" onclick="openSalaryModal()" class="pb-1.5 hover:text-slate-600">Salary</button>
                <button type="button" onclick="openAttendanceModal()" class="pb-1.5 hover:text-slate-600">Attendance</button>
            </div>

            <!-- Personal Information Attributes Table -->
            <div class="space-y-2 text-xs text-slate-600 p-3.5 rounded-xl bg-slate-50/50 border border-slate-100">
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-400 font-medium">Full Name:</span>
                    <span class="font-bold text-slate-800" id="view_attr_fullname">Sok Dara</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-400 font-medium">Date of Birth:</span>
                    <span class="font-mono text-slate-700" id="view_attr_dob">1998-05-12</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-400 font-medium">Gender:</span>
                    <span class="text-slate-700" id="view_attr_gender">Male</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-400 font-medium">Phone Number:</span>
                    <span class="font-mono font-bold text-slate-800" id="view_attr_phone">012 345 678</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-400 font-medium">Email Address:</span>
                    <span class="text-slate-700" id="view_attr_email">dara@example.com</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-400 font-medium">Address:</span>
                    <span class="text-slate-700 text-right truncate max-w-[200px]" id="view_attr_address">Phnom Penh, Cambodia</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-400 font-medium">Hire Date:</span>
                    <span class="font-mono text-slate-700" id="view_attr_hire">2024-01-15</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-100">
                    <span class="text-slate-400 font-medium">System Role:</span>
                    <span class="font-bold text-blue-600" id="view_attr_role">Manager</span>
                </div>
                @if($isAdminOrManager)
                    <div class="flex justify-between pt-1.5 font-bold">
                        <span class="text-slate-400">Monthly Salary:</span>
                        <span class="font-mono text-purple-600 text-sm" id="view_attr_salary">$500.00</span>
                    </div>
                @endif
            </div>

            <!-- Action buttons inside View Modal -->
            <div class="pt-2 flex items-center gap-2">
                <button type="button" onclick="triggerAttendanceRecordFromView()" class="flex-1 py-2 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-semibold hover:bg-emerald-100 transition flex items-center justify-center gap-1.5">
                    <i class="fa-regular fa-calendar-check"></i> Record Attendance
                </button>
                <button type="button" onclick="switchToEditModal()" class="flex-1 py-2 bg-sky-500 text-white rounded-xl font-semibold hover:bg-sky-600 transition flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Employee
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
{{-- 5. POPUP MODAL: EDIT EMPLOYEE (FORM MODAL LIKE BRAND EDIT)                 --}}
{{-- ========================================================================= --}}
<div id="editModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-sky-500 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 leading-tight">Edit Employee</h3>
                    <p class="text-xs text-slate-500 font-mono" id="edit_emp_id_code">EMP-001</p>
                </div>
            </div>
            <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Form Body -->
        <form id="editEmpForm" onsubmit="submitEditEmployee(event)" class="p-6 space-y-4 overflow-y-auto flex-1 text-xs">
            <input type="hidden" id="editEmpIdHidden" value="">

            <!-- Full Name & Position -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="editFullName" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Position <span class="text-rose-500">*</span></label>
                    <input type="text" id="editPosition" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
            </div>

            <!-- First & Last Name -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Last Name</label>
                    <input type="text" id="editLastName"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">First Name</label>
                    <input type="text" id="editFirstName"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Date of Birth & Gender -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Date of Birth</label>
                    <input type="date" id="editDOB"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition font-mono">
                </div>
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Gender</label>
                    <select id="editGender" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <!-- Phone & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Phone Number <span class="text-rose-500">*</span></label>
                    <input type="text" id="editPhone" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition font-mono">
                </div>
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Email Address <span class="text-rose-500">*</span></label>
                    <input type="email" id="editEmail" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Role & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">System Role</label>
                    <select id="editRoleId" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        @foreach($roles as $r)
                            <option value="{{ $r->id }}">{{ $r->role_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Status <span class="text-rose-500">*</span></label>
                    <select id="editStatus" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        <option value="Active">Active</option>
                        <option value="On Leave">On Leave</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Terminated">Terminated</option>
                    </select>
                </div>
            </div>

            <!-- Address -->
            <div>
                <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Address</label>
                <input type="text" id="editAddress" placeholder="Current address"
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition">
            </div>

            <!-- Monthly Salary -->
            @if($isAdminOrManager)
                <div>
                    <label class="font-bold text-slate-700 uppercase tracking-wider text-[11px] block mb-1.5">Monthly Salary ($)</label>
                    <input type="number" id="editSalary" step="0.01" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 focus:bg-white transition font-mono">
                </div>
            @else
                <input type="hidden" id="editSalary" value="500">
            @endif

            <!-- Action Buttons Footer -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl transition">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md shadow-blue-600/20 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-check text-xs"></i> Update Employee
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- 6. MODAL: ATTENDANCE TRACKER                                              --}}
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
{{-- 7. MODAL: SHIFT SCHEDULE CALENDAR                                         --}}
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
{{-- 8. JAVASCRIPT STATE ENGINE FOR EMPLOYEES                                  --}}
{{-- ========================================================================= --}}
<script>
    let currentSelectedEmpId = null;

    // ==========================================
    // 1. ADD MODAL
    // ==========================================
    function openAddModal() {
        document.getElementById('addEmpForm').reset();
        document.getElementById('addModal').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }

    // ==========================================
    // 2. VIEW DETAILS MODAL
    // ==========================================
    async function openViewModal(empId) {
        currentSelectedEmpId = empId;

        try {
            const res = await fetch(`/employees/${empId}`);
            const data = await res.json();
            if (data.success) {
                const emp = data.employee;
                document.getElementById('view_emp_id_code').textContent = emp.employee_id;
                document.getElementById('view_avatar').src = emp.avatar || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&h=120&q=80';
                document.getElementById('view_fullname').textContent = emp.full_name;
                document.getElementById('view_position_code').textContent = `${emp.position} | ${emp.employee_id}`;

                // Status Badge
                const statusBadgeBox = document.getElementById('view_status_badge');
                let badgeClass = 'bg-slate-100 text-slate-700 border-slate-200';
                if (emp.status === 'Active') badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-200';
                else if (emp.status === 'On Leave') badgeClass = 'bg-amber-50 text-amber-600 border-amber-200';
                else if (emp.status === 'Inactive') badgeClass = 'bg-rose-50 text-rose-600 border-rose-200';
                statusBadgeBox.innerHTML = `<span class="px-3 py-1 rounded-full text-xs font-bold border ${badgeClass}">${emp.status}</span>`;

                document.getElementById('view_attr_fullname').textContent = emp.full_name;
                document.getElementById('view_attr_dob').textContent = emp.date_of_birth || 'N/A';
                document.getElementById('view_attr_gender').textContent = emp.gender || 'N/A';
                document.getElementById('view_attr_phone').textContent = emp.phone;
                document.getElementById('view_attr_email').textContent = emp.email;
                document.getElementById('view_attr_address').textContent = emp.address || 'Phnom Penh, Cambodia';
                document.getElementById('view_attr_hire').textContent = emp.hire_date ? emp.hire_date.substring(0, 10) : 'N/A';
                document.getElementById('view_attr_role').textContent = emp.role ? emp.role.role_name : 'Staff';

                const salEl = document.getElementById('view_attr_salary');
                if (salEl) {
                    salEl.textContent = `$${parseFloat(emp.salary || 0).toFixed(2)}`;
                }

                document.getElementById('viewModal').classList.remove('hidden');
            }
        } catch (e) {
            console.error(e);
            Swal.fire('កំហុស', 'មិនអាចទាញទិន្នន័យបុគ្គលិកបានឡើយ', 'error');
        }
    }

    function closeViewModal() {
        document.getElementById('viewModal').classList.add('hidden');
    }

    function switchToEditModal() {
        closeViewModal();
        openEditModal(currentSelectedEmpId);
    }

    function triggerAttendanceRecordFromView() {
        const empName = document.getElementById('view_fullname').textContent;
        triggerAttendanceRecord(currentSelectedEmpId, empName);
    }

    // ==========================================
    // 3. EDIT MODAL
    // ==========================================
    async function openEditModal(empId) {
        currentSelectedEmpId = empId;

        try {
            const res = await fetch(`/employees/${empId}`);
            const data = await res.json();
            if (data.success) {
                const emp = data.employee;
                document.getElementById('editEmpIdHidden').value = emp.id;
                document.getElementById('edit_emp_id_code').textContent = `${emp.employee_id} • ${emp.full_name}`;
                document.getElementById('editFullName').value = emp.full_name;
                document.getElementById('editFirstName').value = emp.first_name || '';
                document.getElementById('editLastName').value = emp.last_name || '';
                document.getElementById('editDOB').value = emp.date_of_birth ? emp.date_of_birth.substring(0, 10) : '';
                document.getElementById('editGender').value = emp.gender || 'Male';
                document.getElementById('editPhone').value = emp.phone;
                document.getElementById('editEmail').value = emp.email;
                document.getElementById('editPosition').value = emp.position;
                document.getElementById('editStatus').value = emp.status || 'Active';
                document.getElementById('editAddress').value = emp.address || '';
                if (emp.role_id) {
                    document.getElementById('editRoleId').value = emp.role_id;
                }
                const salInput = document.getElementById('editSalary');
                if (salInput) salInput.value = emp.salary || 500;

                document.getElementById('editModal').classList.remove('hidden');
            }
        } catch (e) {
            console.error(e);
            Swal.fire('កំហុស', 'មិនអាចទាញទិន្នន័យបុគ្គលិកបានឡើយ', 'error');
        }
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // ==========================================
    // 4. SUBMIT EDIT EMPLOYEE (AJAX PUT)
    // ==========================================
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
            role_id: document.getElementById('editRoleId').value,
            status: document.getElementById('editStatus').value,
            address: document.getElementById('editAddress').value,
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
                closeEditModal();
                Swal.fire({
                    icon: 'success',
                    title: 'ជោគជ័យ!',
                    text: data.message,
                    confirmButtonColor: '#2563EB'
                }).then(() => location.reload());
            } else {
                Swal.fire('បរាជ័យ', data.message || 'មិនអាចកែប្រែបានទេ', 'error');
            }
        } catch (err) {
            Swal.fire('កំហុស', 'មិនអាចភ្ជាប់ម៉ាស៊ីនបម្រើបានទេ', 'error');
        }
    }

    // ==========================================
    // 5. ATTENDANCE & SHIFT MODALS
    // ==========================================
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
