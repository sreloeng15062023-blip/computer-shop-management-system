<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Management - TECHZONE</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom Scrollbar for elegant UI */
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

                    <!-- Active Supplier Management -->
                    <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30">
                        <i class="fa-solid fa-truck-fast w-5 text-center"></i> Supplier Management
                    </a>

                    <a href="{{ route('customers') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
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
                <form method="GET" action="{{ route('suppliers.index') }}" class="w-80 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search suppliers..." class="w-full pl-10 pr-4 py-2 bg-slate-100/80 border border-transparent rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
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

                <!-- Supplier Management Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-600/20">
                            <i class="fa-solid fa-truck-fast text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Supplier Management</h1>
                            <p class="text-sm text-slate-500">Manage your suppliers and their information</p>
                        </div>
                    </div>

                    <!-- + Add Supplier Button -->
                    <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/20 hover:shadow-lg transition active:scale-95">
                        <i class="fa-solid fa-plus text-xs"></i> Add Supplier
                    </button>
                </div>

                <!-- ========================================== -->
                <!-- 4 METRIC STATS CARDS                       -->
                <!-- ========================================== -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Card 1: Total Suppliers -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold shrink-0">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Suppliers</div>
                            <div class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $totalSuppliers ?? 0 }}</div>
                        </div>
                    </div>

                    <!-- Card 2: Active Suppliers -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold shrink-0">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Active Suppliers</div>
                            <div class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $activeSuppliers ?? 0 }}</div>
                        </div>
                    </div>

                    <!-- Card 3: Inactive Suppliers -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl font-bold shrink-0">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Inactive Suppliers</div>
                            <div class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $inactiveSuppliers ?? 0 }}</div>
                        </div>
                    </div>

                    <!-- Card 4: Total Purchases (This Month) -->
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold shrink-0">
                            <i class="fa-solid fa-cart-flatbed"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Purchases (This Month)</div>
                            <div class="text-2xl font-extrabold text-slate-800 mt-0.5">$ 12,450.00</div>
                        </div>
                    </div>
                </div>

                <!-- Filter & Search Card -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
                    <form method="GET" action="{{ route('suppliers.index') }}" class="flex flex-col md:flex-row items-center gap-3">
                        <!-- Search Box -->
                        <div class="flex-1 w-full relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, contact person, phone, or email..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
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
                        <a href="{{ route('suppliers.index') }}" class="w-full md:w-auto px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-medium flex items-center justify-center gap-2 transition shrink-0">
                            <i class="fa-solid fa-rotate-left text-xs"></i> Reset
                        </a>
                    </form>
                </div>

                <!-- Suppliers Data Table Card -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[900px]">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                    <th class="py-4 px-4 text-center w-10"><input type="checkbox" class="rounded text-blue-600 focus:ring-0"></th>
                                    <th class="py-4 px-3 text-center w-12">#</th>
                                    <th class="py-4 px-4 whitespace-nowrap">Supplier Name</th>
                                    <th class="py-4 px-4 whitespace-nowrap">Contact Person</th>
                                    <th class="py-4 px-4 whitespace-nowrap">Phone</th>
                                    <th class="py-4 px-4 whitespace-nowrap">Email</th>
                                    <th class="py-4 px-4">Address</th>
                                    <th class="py-4 px-4 text-center whitespace-nowrap">Status</th>
                                    <th class="py-4 px-4 whitespace-nowrap">Created At</th>
                                    <th class="py-4 px-4 text-center w-36 whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @forelse ($suppliers as $index => $supplier)
                                    <tr class="hover:bg-slate-50/70 transition group">
                                        <!-- Checkbox -->
                                        <td class="py-3.5 px-4 text-center">
                                            <input type="checkbox" class="rounded text-blue-600 focus:ring-0">
                                        </td>

                                        <!-- Row Number -->
                                        <td class="py-3.5 px-3 text-center font-medium text-slate-400">
                                            {{ $suppliers->firstItem() + $index }}
                                        </td>

                                        <!-- Supplier Name with Avatar Initial -->
                                        <td class="py-3.5 px-4 font-bold text-slate-900 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 text-blue-600 font-extrabold flex items-center justify-center text-xs shrink-0">
                                                    {{ strtoupper(substr($supplier->name, 0, 2)) }}
                                                </div>
                                                <span class="hover:text-blue-600 transition">{{ $supplier->name }}</span>
                                            </div>
                                        </td>

                                        <!-- Contact Person -->
                                        <td class="py-3.5 px-4 text-slate-600 font-medium whitespace-nowrap">
                                            {{ $supplier->contact_name ?? '—' }}
                                        </td>

                                        <!-- Phone -->
                                        <td class="py-3.5 px-4 text-slate-700 font-medium whitespace-nowrap">
                                            {{ $supplier->phone }}
                                        </td>

                                        <!-- Email -->
                                        <td class="py-3.5 px-4 text-slate-500 text-xs whitespace-nowrap">
                                            {{ $supplier->email ?? '—' }}
                                        </td>

                                        <!-- Address -->
                                        <td class="py-3.5 px-4 text-slate-500 text-xs max-w-[200px] truncate" title="{{ $supplier->address }}">
                                            {{ $supplier->address ?? '—' }}
                                        </td>

                                        <!-- Status Badge -->
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            @if ($supplier->status === 'Active')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/60">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Created At -->
                                        <td class="py-3.5 px-4 text-slate-500 text-xs font-medium whitespace-nowrap">
                                            {{ $supplier->created_at ? $supplier->created_at->format('Y-m-d') : '—' }}
                                        </td>

                                        <!-- Actions (Edit, View, Delete) -->
                                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <!-- Edit Button (Sky blue) -->
                                                <button onclick="openEditModal({{ json_encode($supplier) }})" class="w-8 h-8 rounded-lg bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition shadow-2xs" title="Edit Supplier">
                                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                </button>

                                                <!-- View Button (Blue) -->
                                                <button onclick="openViewModal({{ json_encode($supplier) }})" class="w-8 h-8 rounded-lg bg-blue-600 hover:bg-blue-700 text-white flex items-center justify-center transition shadow-2xs" title="View Details">
                                                    <i class="fa-solid fa-eye text-xs"></i>
                                                </button>

                                                <!-- Delete Button (Rose red) -->
                                                <button onclick="openDeleteModal('{{ $supplier->id }}', '{{ addslashes($supplier->name) }}')" class="w-8 h-8 rounded-lg bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center transition shadow-2xs" title="Delete Supplier">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="py-12 text-center text-slate-400">
                                            <i class="fa-solid fa-truck-fast text-4xl mb-3 block text-slate-300"></i>
                                            <p class="font-medium">រកមិនឃើញទិន្នន័យ Supplier ឡើយ។</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Footer -->
                    <div class="px-6 py-4 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-slate-500">
                            Showing <span class="font-semibold text-slate-700">{{ $suppliers->firstItem() ?? 0 }}</span> to <span class="font-semibold text-slate-700">{{ $suppliers->lastItem() ?? 0 }}</span> of <span class="font-semibold text-slate-700">{{ $suppliers->total() }}</span> suppliers
                        </div>
                        <div>
                            {{ $suppliers->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- ========================================== -->
    <!-- 3. ADD SUPPLIER MODAL (2 Columns)          -->
    <!-- ========================================== -->
    <div id="addModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 leading-tight">Add New Supplier</h3>
                        <p class="text-xs text-slate-500">Create a new supplier in the system</p>
                    </div>
                </div>
                <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('suppliers.store') }}" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Supplier Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Enter supplier name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Contact Person</label>
                        <input type="text" name="contact_name" placeholder="Enter contact person" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number <span class="text-rose-500">*</span></label>
                        <input type="text" name="phone" required placeholder="Enter phone number" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email</label>
                        <input type="email" name="email" placeholder="Enter email address" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Address</label>
                    <textarea name="address" rows="3" placeholder="Enter full address" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/20 transition">Save Supplier</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 4. EDIT SUPPLIER MODAL                     -->
    <!-- ========================================== -->
    <div id="editModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-sky-500 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 leading-tight">Edit Supplier</h3>
                        <p class="text-xs text-slate-500">Update supplier information</p>
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
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Supplier Name <span class="text-rose-500">*</span></label>
                        <input type="text" id="edit_name" name="name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Contact Person</label>
                        <input type="text" id="edit_contact_name" name="contact_name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number <span class="text-rose-500">*</span></label>
                        <input type="text" id="edit_phone" name="phone" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email</label>
                        <input type="email" id="edit_email" name="email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Address</label>
                    <textarea id="edit_address" name="address" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status</label>
                    <select id="edit_status" name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/20 transition">Update Supplier</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- 5. VIEW SUPPLIER DETAILS MODAL             -->
    <!-- ========================================== -->
    <div id="viewModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h3 class="font-bold text-slate-900">Supplier Details</h3>
                </div>
                <button onclick="closeViewModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <div class="p-6 space-y-5">
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-200/60">
                    <div class="flex items-center gap-3">
                        <div id="view_avatar" class="w-12 h-12 rounded-xl bg-blue-600 text-white font-extrabold text-lg flex items-center justify-center shadow-sm">
                            S
                        </div>
                        <div>
                            <div id="view_name" class="font-bold text-lg text-slate-900">ASUS Official Supplier</div>
                            <div id="view_contact_name" class="text-xs text-slate-500">Contact: Sok Dara</div>
                        </div>
                    </div>
                    <div id="view_status_badge">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Phone Number</span>
                        <span id="view_phone" class="text-slate-700 font-semibold">+855 12 345 678</span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Email Address</span>
                        <span id="view_email" class="text-slate-700 font-medium">dara@asus.com</span>
                    </div>
                    <div class="col-span-2 pt-2 border-t border-slate-200/60">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Address</span>
                        <span id="view_address" class="text-slate-700 font-medium">Phnom Penh, Cambodia</span>
                    </div>
                </div>

                <!-- Purchase History Preview -->
                <div>
                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Purchase History</h4>
                    <div class="rounded-xl border border-slate-200 overflow-hidden text-xs">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 text-slate-500 font-semibold border-b">
                                <tr>
                                    <th class="py-2.5 px-3 text-center">#</th>
                                    <th class="py-2.5 px-3">Date</th>
                                    <th class="py-2.5 px-3">PO Number</th>
                                    <th class="py-2.5 px-3">Total Amount</th>
                                    <th class="py-2.5 px-3 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-600">
                                <tr>
                                    <td class="py-2 px-3 text-center">1</td>
                                    <td class="py-2 px-3">2025-06-15</td>
                                    <td class="py-2 px-3 font-medium text-slate-800">PO-2025-001</td>
                                    <td class="py-2 px-3 font-semibold">$ 2,500.00</td>
                                    <td class="py-2 px-3 text-center"><span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">Completed</span></td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-3 text-center">2</td>
                                    <td class="py-2 px-3">2025-07-10</td>
                                    <td class="py-2 px-3 font-medium text-slate-800">PO-2025-002</td>
                                    <td class="py-2 px-3 font-semibold">$ 1,800.00</td>
                                    <td class="py-2 px-3 text-center"><span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">Completed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pt-2 flex justify-end">
                    <button onclick="closeViewModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition">Back to List</button>
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
            <h3 class="text-lg font-bold text-slate-900">Delete Supplier</h3>
            <p class="text-sm text-slate-500 mt-1">
                Are you sure you want to delete this supplier?<br>
                "<span id="del_name" class="font-bold text-slate-800"></span>"<br>
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
    <!-- 7. MODAL JAVASCRIPT CONTROLLERS            -->
    <!-- ========================================== -->
    <script>
        // --- Add Modal ---
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }
        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        // --- Edit Modal ---
        function openEditModal(supplier) {
            document.getElementById('editForm').action = '/suppliers/' + supplier.id;
            document.getElementById('edit_name').value = supplier.name || '';
            document.getElementById('edit_contact_name').value = supplier.contact_name || '';
            document.getElementById('edit_phone').value = supplier.phone || '';
            document.getElementById('edit_email').value = supplier.email || '';
            document.getElementById('edit_address').value = supplier.address || '';
            document.getElementById('edit_status').value = supplier.status || 'Active';
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // --- View Modal ---
        function openViewModal(supplier) {
            document.getElementById('view_name').textContent = supplier.name;
            document.getElementById('view_contact_name').textContent = 'Contact: ' + (supplier.contact_name || '—');
            document.getElementById('view_phone').textContent = supplier.phone;
            document.getElementById('view_email').textContent = supplier.email || '—';
            document.getElementById('view_address').textContent = supplier.address || '—';
            document.getElementById('view_avatar').textContent = (supplier.name || 'S').substring(0, 2).toUpperCase();
            
            const badge = document.getElementById('view_status_badge');
            if (supplier.status === 'Active') {
                badge.innerHTML = '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>';
            } else {
                badge.innerHTML = '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">Inactive</span>';
            }
            document.getElementById('viewModal').classList.remove('hidden');
        }
        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        // --- Delete Modal ---
        function openDeleteModal(id, name) {
            document.getElementById('deleteForm').action = '/suppliers/' + id;
            document.getElementById('del_name').textContent = name;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</body>

</html>
