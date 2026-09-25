<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management - TECHZONE</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased selection:bg-blue-500 selection:text-white">

    <div class="flex h-screen overflow-hidden">

        <!-- ========================================== -->
        <!-- 1. SIDEBAR (TECHZONE Theme)                -->
        <!-- ========================================== -->
        <aside class="w-64 bg-[#0f172a] text-slate-300 flex flex-col justify-between shrink-0 shadow-2xl overflow-y-auto z-30">
            <div>
                <!-- Logo -->
                <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-800/80">
                    <div class="bg-blue-600 w-10 h-10 rounded-xl text-white flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <i class="fa-solid fa-desktop text-lg"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-lg text-white tracking-wider leading-none">TECHZONE</div>
                        <div class="text-[10px] text-slate-400 mt-1 font-medium">Computer Shop Management</div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="p-4 space-y-1.5 text-sm font-medium">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-house w-5 text-center"></i> Dashboard
                    </a>

                    <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-boxes-stacked w-5 text-center"></i> Product Management
                    </a>

                    <a href="{{ route('brands.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brands.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-tags w-5 text-center"></i> Brand Management
                    </a>

                    <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('suppliers.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-truck-fast w-5 text-center"></i> Supplier Management
                    </a>

                    <!-- Active Customer Management -->
                    <a href="{{ route('customers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30">
                        <i class="fa-solid fa-users w-5 text-center"></i> Customer Management
                    </a>

                    <a href="{{ route('purchases') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-cart-shopping w-5 text-center"></i> Purchase Management
                    </a>

                    <a href="{{ route('pos.sales') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-cash-register w-5 text-center"></i> Sales Management (POS)
                    </a>

                    <a href="{{ route('inventory') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-warehouse w-5 text-center"></i> Inventory Management
                    </a>

                    <a href="{{ route('repair.service') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-wrench w-5 text-center"></i> Repair Service Management
                    </a>

                    <a href="{{ route('warranty') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-shield-halved w-5 text-center"></i> Warranty Management
                    </a>

                    <a href="{{ route('invoices') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Payment & Invoice
                    </a>

                    <a href="{{ route('employees') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-user-gear w-5 text-center"></i> Employee Management
                    </a>

                    <a href="{{ route('reports') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-chart-line w-5 text-center"></i> Report Management
                    </a>

                    <a href="{{ route('notifications') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-bell w-5 text-center"></i> Notification
                        <span class="ml-auto bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">3</span>
                    </a>

                    <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-gear w-5 text-center"></i> Settings
                    </a>
                </nav>
            </div>
        </aside>

        <!-- ========================================== -->
        <!-- 2. MAIN CONTENT AREA                       -->
        <!-- ========================================== -->
        <main class="flex-1 flex flex-col overflow-y-auto bg-slate-50 min-w-0">

            <!-- Top Header Navbar -->
            <header class="bg-white border-b border-slate-200 px-8 py-3.5 flex items-center justify-between sticky top-0 z-20 shadow-xs">
                <!-- Top Navbar Search Input -->
                <form method="GET" action="{{ route('customers.index') }}" class="w-80 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search customers..." class="w-full pl-10 pr-4 py-2 bg-slate-100/80 border border-transparent rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-sm"></i>
                </form>

                <!-- Top Icons & User Profile -->
                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-xl transition">
                        <i class="fa-solid fa-bell text-lg"></i>
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    </button>

                    <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                        <div class="w-9 h-9 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-sm shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'Admin', 0, 2)) }}
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-slate-800 leading-tight">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div class="text-[11px] font-medium text-slate-400 leading-tight">
                                {{ Auth::user()->role->role_name ?? 'Administrator' }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content Body -->
            <div class="p-8 w-full space-y-6">

                <!-- Alert Messages (Success / Error) -->
                @if (session('success'))
                    <div class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-xs">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-xs">
                        <div class="flex items-center gap-2 mb-2 font-semibold text-sm">
                            <i class="fa-solid fa-circle-exclamation text-rose-600"></i> មានបញ្ហាក្នុងការបញ្ចូលទិន្នន័យ៖
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Customer Management Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-600/20">
                            <i class="fa-solid fa-users text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Customer Management</h1>
                            <p class="text-sm text-slate-500">Manage retail & wholesale customer accounts and reward points</p>
                        </div>
                    </div>

                    <!-- + Add Customer Button -->
                    <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/20 hover:shadow-lg transition active:scale-95">
                        <i class="fa-solid fa-plus text-xs"></i> Add Customer
                    </button>
                </div>

                <!-- ========================================== -->
                <!-- 4 METRIC STATS CARDS                       -->
                <!-- ========================================== -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Card 1: Total Customers -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold shrink-0">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Customers</div>
                            <div class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $totalCustomers ?? 0 }}</div>
                        </div>
                    </div>

                    <!-- Card 2: Active Customers -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold shrink-0">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Active Customers</div>
                            <div class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $activeCustomers ?? 0 }}</div>
                        </div>
                    </div>

                    <!-- Card 3: Wholesale Customers -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold shrink-0">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Wholesale Customers</div>
                            <div class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $wholesaleCustomers ?? 0 }}</div>
                        </div>
                    </div>

                    <!-- Card 4: Total Reward Points -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold shrink-0">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Reward Points</div>
                            <div class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ number_format($totalRewardPoints ?? 0) }} <span class="text-xs font-bold text-slate-400">pts</span></div>
                        </div>
                    </div>
                </div>

                <!-- Filter & Search Card -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
                    <form method="GET" action="{{ route('customers.index') }}" class="flex flex-col md:flex-row items-center gap-3">
                        <!-- Search Box -->
                        <div class="flex-1 w-full relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, phone, email, or address..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                        </div>

                        <!-- Customer Type Filter -->
                        <div class="w-full md:w-44">
                            <select name="customer_type" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                                <option value="">All Types</option>
                                <option value="Retail" {{ request('customer_type') === 'Retail' ? 'selected' : '' }}>Retail</option>
                                <option value="Wholesale" {{ request('customer_type') === 'Wholesale' ? 'selected' : '' }}>Wholesale</option>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="w-full md:w-44">
                            <select name="status" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                                <option value="">All Status</option>
                                <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Reset Button -->
                        <a href="{{ route('customers.index') }}" class="w-full md:w-auto px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-medium flex items-center justify-center gap-2 transition shrink-0">
                            <i class="fa-solid fa-rotate-left text-xs"></i> Reset
                        </a>
                    </form>
                </div>

                <!-- Customers Data Table Card -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[900px]">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                    <th class="py-4 px-4 text-center w-10"><input type="checkbox" class="rounded text-blue-600 focus:ring-0"></th>
                                    <th class="py-4 px-3 text-center w-12">#</th>
                                    <th class="py-4 px-4 whitespace-nowrap">Customer Name</th>
                                    <th class="py-4 px-4 whitespace-nowrap">Phone</th>
                                    <th class="py-4 px-4 whitespace-nowrap">Email</th>
                                    <th class="py-4 px-4">Address</th>
                                    <th class="py-4 px-4 text-center whitespace-nowrap">Type</th>
                                    <th class="py-4 px-4 text-center whitespace-nowrap">Points</th>
                                    <th class="py-4 px-4 text-center whitespace-nowrap">Status</th>
                                    <th class="py-4 px-4 text-center w-36 whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @forelse ($customers as $index => $customer)
                                    <tr class="hover:bg-slate-50/70 transition group">
                                        <!-- Checkbox -->
                                        <td class="py-3.5 px-4 text-center">
                                            <input type="checkbox" class="rounded text-blue-600 focus:ring-0">
                                        </td>

                                        <!-- Row Number -->
                                        <td class="py-3.5 px-3 text-center font-medium text-slate-400">
                                            {{ $customers->firstItem() + $index }}
                                        </td>

                                        <!-- Customer Name with Avatar Initial -->
                                        <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 text-blue-600 font-extrabold flex items-center justify-center text-xs shrink-0">
                                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <span class="hover:text-blue-600 transition">{{ $customer->name }}</span>
                                                    <span class="block text-[11px] font-normal text-slate-400">ID: C{{ str_pad($customer->id, 3, '0', STR_PAD_LEFT) }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Phone -->
                                        <td class="py-3.5 px-4 text-slate-700 font-medium whitespace-nowrap">
                                            {{ $customer->phone }}
                                        </td>

                                        <!-- Email -->
                                        <td class="py-3.5 px-4 text-slate-500 text-xs whitespace-nowrap">
                                            {{ $customer->email ?? '—' }}
                                        </td>

                                        <!-- Address -->
                                        <td class="py-3.5 px-4 text-slate-500 text-xs max-w-[200px] truncate" title="{{ $customer->address }}">
                                            {{ $customer->address ?? '—' }}
                                        </td>

                                        <!-- Type Badge -->
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            @if ($customer->customer_type === 'Wholesale')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200/60">
                                                    <i class="fa-solid fa-briefcase text-[10px]"></i> Wholesale
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/60">
                                                    <i class="fa-solid fa-user text-[10px]"></i> Retail
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Reward Points -->
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                                <i class="fa-solid fa-star text-amber-500 text-[10px]"></i> {{ number_format($customer->points ?? 0) }}
                                            </span>
                                        </td>

                                        <!-- Status Badge -->
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            @if ($customer->status === 'Active')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/60">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions (Edit, View, Delete) -->
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <!-- Edit Button (Sky blue) -->
                                                <button onclick="openEditModal({{ json_encode($customer) }})" class="w-8 h-8 rounded-lg bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition shadow-2xs" title="Edit Customer">
                                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                </button>

                                                <!-- View Button (Blue) -->
                                                <button onclick="openViewModal({{ json_encode($customer) }})" class="w-8 h-8 rounded-lg bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center transition shadow-2xs" title="View Details">
                                                    <i class="fa-solid fa-eye text-xs"></i>
                                                </button>

                                                <!-- Delete Button (Rose red) -->
                                                <button onclick="openDeleteModal('{{ $customer->id }}', '{{ addslashes($customer->name) }}')" class="w-8 h-8 rounded-lg bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center transition shadow-2xs" title="Delete Customer">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="py-12 text-center text-slate-400">
                                            <i class="fa-solid fa-users text-4xl mb-3 block text-slate-300"></i>
                                            <p class="font-medium">រកមិនឃើញទិន្នន័យ Customer ឡើយ។</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Footer -->
                    <div class="px-6 py-4 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-slate-500">
                            Showing <span class="font-semibold text-slate-700">{{ $customers->firstItem() ?? 0 }}</span> to <span class="font-semibold text-slate-700">{{ $customers->lastItem() ?? 0 }}</span> of <span class="font-semibold text-slate-700">{{ $customers->total() }}</span> customers
                        </div>
                        <div>
                            {{ $customers->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- ========================================== -->
    <!-- 3. ADD CUSTOMER MODAL (2 Columns)          -->
    <!-- ========================================== -->
    <div id="addModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 leading-tight">Add New Customer</h3>
                        <p class="text-xs text-slate-500">Register a new retail or wholesale customer</p>
                    </div>
                </div>
                <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('customers.store') }}" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Enter customer name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number <span class="text-rose-500">*</span></label>
                        <input type="text" name="phone" required placeholder="Enter phone number" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address</label>
                        <input type="email" name="email" placeholder="Enter email address" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Reward Points</label>
                        <input type="number" name="points" value="0" min="0" placeholder="Initial points" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Customer Type</label>
                        <select name="customer_type" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                            <option value="Retail">Retail</option>
                            <option value="Wholesale">Wholesale</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status</label>
                        <select name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Address</label>
                    <textarea name="address" rows="3" placeholder="Enter customer address" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/20 transition">Save Customer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 4. EDIT CUSTOMER MODAL                     -->
    <!-- ========================================== -->
    <div id="editModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-sky-500 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 leading-tight">Edit Customer</h3>
                        <p class="text-xs text-slate-500">Update customer profile & information</p>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <!-- Form -->
            <form id="editForm" method="POST" action="" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                        <input type="text" id="edit_name" name="name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number <span class="text-rose-500">*</span></label>
                        <input type="text" id="edit_phone" name="phone" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address</label>
                        <input type="email" id="edit_email" name="email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Reward Points</label>
                        <input type="number" id="edit_points" name="points" min="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Customer Type</label>
                        <select id="edit_customer_type" name="customer_type" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                            <option value="Retail">Retail</option>
                            <option value="Wholesale">Wholesale</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status</label>
                        <select id="edit_status" name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Address</label>
                    <textarea id="edit_address" name="address" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/20 transition">Update Customer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 5. VIEW CUSTOMER DETAILS MODAL             -->
    <!-- ========================================== -->
    <div id="viewModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                        <i class="fa-solid fa-address-card"></i>
                    </div>
                    <h3 class="font-bold text-slate-900">Customer Details</h3>
                </div>
                <button onclick="closeViewModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-200/60">
                    <div class="flex items-center gap-3">
                        <div id="view_avatar" class="w-12 h-12 rounded-xl bg-blue-600 text-white font-extrabold text-lg flex items-center justify-center shadow-sm">
                            C
                        </div>
                        <div>
                            <div id="view_name" class="font-bold text-lg text-slate-900">Customer Name</div>
                            <div id="view_phone" class="text-xs text-slate-500">012 345 678</div>
                        </div>
                    </div>
                    <div id="view_status_badge">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Customer Type</span>
                        <span id="view_type_badge" class="text-sm font-semibold text-slate-700 mt-1 block">Retail</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Reward Points</span>
                        <span id="view_points" class="text-sm font-bold text-amber-600 mt-1 block">0 pts</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Email</span>
                        <span id="view_email" class="text-xs font-medium text-slate-700 mt-1 block truncate">—</span>
                    </div>
                </div>

                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Address</span>
                    <p id="view_address" class="text-slate-700 bg-slate-50/50 p-3 rounded-xl border border-slate-100 text-sm">—</p>
                </div>

                <!-- Purchase History Preview Table -->
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2">Purchase & Order History (Preview)</span>
                    <div class="overflow-x-auto border border-slate-200 rounded-xl">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200">
                                <tr>
                                    <th class="py-2.5 px-3">Invoice #</th>
                                    <th class="py-2.5 px-3">Date</th>
                                    <th class="py-2.5 px-3 text-right">Total ($)</th>
                                    <th class="py-2.5 px-3 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr>
                                    <td class="py-2.5 px-3 font-semibold text-blue-600">INV-2026-001</td>
                                    <td class="py-2.5 px-3 text-slate-500">2026-09-20</td>
                                    <td class="py-2.5 px-3 text-right font-bold text-slate-800">$ 450.00</td>
                                    <td class="py-2.5 px-3 text-center"><span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">Paid</span></td>
                                </tr>
                                <tr>
                                    <td class="py-2.5 px-3 font-semibold text-blue-600">INV-2026-002</td>
                                    <td class="py-2.5 px-3 text-slate-500">2026-09-22</td>
                                    <td class="py-2.5 px-3 text-right font-bold text-slate-800">$ 1,200.00</td>
                                    <td class="py-2.5 px-3 text-center"><span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">Paid</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end">
                    <button onclick="closeViewModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 6. DELETE CONFIRMATION MODAL               -->
    <!-- ========================================== -->
    <div id="deleteModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl border border-slate-200 overflow-hidden text-center p-6">
            <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Delete Customer</h3>
            <p class="text-sm text-slate-500 mt-1">
                Are you sure you want to delete this customer?<br>
                "<span id="del_customer_name" class="font-bold text-slate-800"></span>"<br>
                <span class="text-xs text-rose-500 font-medium">This action cannot be undone.</span>
            </p>

            <form id="deleteForm" method="POST" action="" class="mt-6 flex items-center justify-center gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-rose-600/20 transition">Delete</button>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 7. JAVASCRIPT CONTROLLERS                  -->
    <!-- ========================================== -->
    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }
        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openEditModal(customer) {
            document.getElementById('editForm').action = '/customers/' + customer.id;
            document.getElementById('edit_name').value = customer.name || '';
            document.getElementById('edit_phone').value = customer.phone || '';
            document.getElementById('edit_email').value = customer.email || '';
            document.getElementById('edit_points').value = customer.points || 0;
            document.getElementById('edit_customer_type').value = customer.customer_type || 'Retail';
            document.getElementById('edit_status').value = customer.status || 'Active';
            document.getElementById('edit_address').value = customer.address || '';
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openViewModal(customer) {
            const initial = (customer.name || 'C').substring(0, 2).toUpperCase();
            document.getElementById('view_avatar').innerText = initial;
            document.getElementById('view_name').innerText = customer.name || '—';
            document.getElementById('view_phone').innerText = customer.phone || '—';
            document.getElementById('view_email').innerText = customer.email || '—';
            document.getElementById('view_points').innerText = (customer.points ? customer.points.toLocaleString() : '0') + ' pts';
            document.getElementById('view_address').innerText = customer.address || '—';

            const typeBadge = document.getElementById('view_type_badge');
            if (customer.customer_type === 'Wholesale') {
                typeBadge.innerHTML = '<span class="inline-flex items-center gap-1 text-purple-700 font-bold"><i class="fa-solid fa-briefcase text-xs"></i> Wholesale</span>';
            } else {
                typeBadge.innerHTML = '<span class="inline-flex items-center gap-1 text-blue-700 font-bold"><i class="fa-solid fa-user text-xs"></i> Retail</span>';
            }

            const statusBadge = document.getElementById('view_status_badge');
            if (customer.status === 'Active') {
                statusBadge.innerHTML = '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>';
            } else {
                statusBadge.innerHTML = '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">Inactive</span>';
            }

            document.getElementById('viewModal').classList.remove('hidden');
        }
        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        function openDeleteModal(id, name) {
            document.getElementById('deleteForm').action = '/customers/' + id;
            document.getElementById('del_customer_name').innerText = name;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close on background click
        window.onclick = function(event) {
            const addModal = document.getElementById('addModal');
            const editModal = document.getElementById('editModal');
            const viewModal = document.getElementById('viewModal');
            const deleteModal = document.getElementById('deleteModal');

            if (event.target === addModal) closeAddModal();
            if (event.target === editModal) closeEditModal();
            if (event.target === viewModal) closeViewModal();
            if (event.target === deleteModal) closeDeleteModal();
        }
    </script>
</body>
</html>
