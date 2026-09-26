<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Warehouse & Inventory Depot Management | TECHZONE</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .modal-backdrop {
            background-color: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(4px);
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="flex min-h-screen">

        <!-- ================= SIDEBAR ================= -->
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between shrink-0 hidden md:flex border-r border-slate-800">
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

                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('categories.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-layer-group w-5 text-center"></i> Category Management
                    </a>

                    <a href="{{ route('brands.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('brands.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-tags w-5 text-center"></i> Brand Management
                    </a>

                    <!-- Active Warehouse Management -->
                    <a href="{{ route('warehouses.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30">
                        <i class="fa-solid fa-warehouse w-5 text-center"></i> Warehouse Management
                    </a>

                    <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('suppliers.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-truck-fast w-5 text-center"></i> Supplier Management
                    </a>

                    <a href="{{ route('customers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('customers.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-users w-5 text-center"></i> Customer Management
                    </a>

                    <a href="{{ route('purchases') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-cart-shopping w-5 text-center"></i> Purchase Orders
                    </a>

                    <a href="{{ route('pos.sales') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-cash-register w-5 text-center"></i> Sales (POS)
                    </a>
                </nav>
            </div>

            <!-- User Info / Logout -->
            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-slate-800/60 mb-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-500 text-white font-bold flex items-center justify-center text-xs">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="text-xs font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin User' }}</div>
                        <div class="text-[10px] text-slate-400 truncate">Store Manager</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-xs font-medium text-rose-400 hover:bg-rose-500/10 rounded-lg transition">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- ================= MAIN CONTENT AREA ================= -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Header Topbar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-30 shadow-xs">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-slate-600 hover:text-slate-900" onclick="toggleMobileSidebar()">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900 leading-tight">Warehouse & Depot Management</h1>
                        <p class="text-xs text-slate-500">Feature #8: Multi-location warehouses, serial inventory & capacity control</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button onclick="openAddModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl flex items-center gap-2 shadow-sm shadow-blue-600/30 transition">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Add Warehouse</span>
                    </button>
                </div>
            </header>

            <div class="p-6 space-y-6 max-w-7xl w-full mx-auto">
                <!-- Notifications Flash -->
                @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-xs">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
                @endif

                @if (session('error'))
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl flex items-center gap-3 shadow-xs">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <span class="text-sm font-semibold">{{ session('error') }}</span>
                </div>
                @endif

                @if ($errors->any())
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl space-y-1 shadow-xs">
                    <div class="flex items-center gap-2 font-bold text-sm">
                        <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> មានកំហុសក្នុងការបញ្ចូលទិន្នន័យ (Validation Errors):
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-700 pl-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- ================= STAT CARDS ================= -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Warehouses</span>
                            <div class="text-2xl font-black text-slate-800 mt-1">{{ $totalWarehouses }}</div>
                            <span class="text-[11px] text-slate-400">Storage locations</span>
                        </div>
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                            <i class="fa-solid fa-warehouse"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Active Facilities</span>
                            <div class="text-2xl font-black text-emerald-600 mt-1">{{ $activeWarehouses }}</div>
                            <span class="text-[11px] text-emerald-600 font-medium">Ready for stock-in</span>
                        </div>
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Inactive Facilities</span>
                            <div class="text-2xl font-black text-amber-600 mt-1">{{ $inactiveWarehouses }}</div>
                            <span class="text-[11px] text-slate-400">Under maintenance</span>
                        </div>
                        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-xl">
                            <i class="fa-solid fa-pause"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Tracked Serials</span>
                            <div class="text-2xl font-black text-indigo-600 mt-1">{{ $totalStoredSerials }}</div>
                            <span class="text-[11px] text-indigo-500 font-medium">Serials assigned</span>
                        </div>
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-xl">
                            <i class="fa-solid fa-barcode"></i>
                        </div>
                    </div>
                </div>

                <!-- ================= SEARCH & FILTER BAR ================= -->
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row gap-3 items-center justify-between">
                    <form method="GET" action="{{ route('warehouses.index') }}" class="flex flex-col md:flex-row items-center gap-3 w-full">
                        <div class="relative w-full md:w-96">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, code, location or manager..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        </div>

                        <div class="w-full md:w-48">
                            <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                <option value="">All Statuses</option>
                                <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2 w-full md:w-auto">
                            <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold flex items-center justify-center gap-2 transition w-full md:w-auto">
                                <i class="fa-solid fa-filter text-xs"></i> Filter
                            </button>

                            @if(request('search') || request('status'))
                            <a href="{{ route('warehouses.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-medium flex items-center justify-center gap-2 transition shrink-0">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- ================= DATA TABLE ================= -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50/80 text-slate-500 uppercase text-[11px] font-bold tracking-wider border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4">#</th>
                                    <th class="px-6 py-4">Code</th>
                                    <th class="px-6 py-4">Warehouse Name</th>
                                    <th class="px-6 py-4">Location & Address</th>
                                    <th class="px-6 py-4">Manager / Contact</th>
                                    <th class="px-6 py-4 text-center">Stored Items</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($warehouses as $index => $warehouse)
                                <tr class="hover:bg-slate-50/60 transition group">
                                    <td class="px-6 py-4 text-slate-400 text-xs">
                                        {{ $warehouses->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 font-mono font-bold text-xs text-blue-600">
                                        {{ $warehouse->code }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-900">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-building text-slate-400 text-xs"></i>
                                            <span>{{ $warehouse->name }}</span>
                                        </div>
                                        @if($warehouse->description)
                                        <div class="text-[11px] text-slate-400 font-normal mt-0.5 line-clamp-1">{{ $warehouse->description }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 text-xs">
                                        <div class="flex items-center gap-1.5 text-slate-700">
                                            <i class="fa-solid fa-location-dot text-slate-400 text-xs"></i>
                                            <span>{{ $warehouse->location }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-xs">
                                        <div class="font-medium text-slate-800">{{ $warehouse->manager_name ?? '—' }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $warehouse->phone ?? '—' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full font-bold text-xs">
                                            <i class="fa-solid fa-barcode text-[10px]"></i>
                                            <span>{{ $warehouse->serials_count ?? 0 }}</span>
                                            <span class="text-[10px] text-blue-400 font-normal">/ {{ $warehouse->capacity }}</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($warehouse->status === 'Active')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <!-- View Button -->
                                            <button type="button" onclick='openViewModal(@json($warehouse))' title="View Details" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </button>

                                            <!-- Edit Button -->
                                            <button type="button" onclick='openEditModal(@json($warehouse))' title="Edit Warehouse" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-800 hover:text-white flex items-center justify-center transition">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <button type="button" onclick="confirmDelete({{ $warehouse->id }}, '{{ addslashes($warehouse->name) }}', {{ $warehouse->serials_count ?? 0 }})" title="Delete Warehouse" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-12 text-slate-400">
                                        <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-3">
                                            <i class="fa-solid fa-warehouse"></i>
                                        </div>
                                        <div class="text-base font-bold text-slate-700">No Warehouses Found</div>
                                        <div class="text-xs text-slate-400 mt-1">Start by adding your first storage facility or repair depot.</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($warehouses->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $warehouses->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- ================= ADD WAREHOUSE MODAL ================= -->
    <div id="addModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div class="modal-backdrop fixed inset-0" onclick="closeAddModal()"></div>
        <div class="bg-white rounded-3xl max-w-lg w-full z-10 overflow-hidden shadow-2xl relative">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-warehouse"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-base text-slate-900">Add New Warehouse</h3>
                        <p class="text-xs text-slate-400">Create storage location or service depot</p>
                    </div>
                </div>
                <button type="button" onclick="closeAddModal()" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('warehouses.store') }}" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Warehouse Code <span class="text-rose-500">*</span></label>
                        <input type="text" name="code" value="{{ old('code') }}" required placeholder="e.g. WH-PP01" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Status <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Warehouse Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Main Central Warehouse Phnom Penh" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Location / Address <span class="text-rose-500">*</span></label>
                    <input type="text" name="location" value="{{ old('location') }}" required placeholder="e.g. St. 2004, Sen Sok, Phnom Penh" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Manager Name</label>
                        <input type="text" name="manager_name" value="{{ old('manager_name') }}" placeholder="e.g. Sokha Rith" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Contact Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. 023 889 900" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Max Storage Capacity (Units)</label>
                    <input type="number" min="1" name="capacity" value="1000" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Description / Notes</label>
                    <textarea name="description" rows="2" placeholder="Storage facility specifications..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">{{ old('description') }}</textarea>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-blue-600/30 transition">Save Warehouse</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= EDIT WAREHOUSE MODAL ================= -->
    <div id="editModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div class="modal-backdrop fixed inset-0" onclick="closeEditModal()"></div>
        <div class="bg-white rounded-3xl max-w-lg w-full z-10 overflow-hidden shadow-2xl relative">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-base">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-base text-slate-900">Edit Warehouse</h3>
                        <p class="text-xs text-slate-400">Update warehouse information</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditModal()" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="editForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Warehouse Code <span class="text-rose-500">*</span></label>
                        <input type="text" id="edit_code" name="code" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Status <span class="text-rose-500">*</span></label>
                        <select id="edit_status" name="status" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Warehouse Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit_name" name="name" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Location / Address <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit_location" name="location" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Manager Name</label>
                        <input type="text" id="edit_manager_name" name="manager_name" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Contact Phone</label>
                        <input type="text" id="edit_phone" name="phone" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Max Storage Capacity (Units)</label>
                    <input type="number" min="1" id="edit_capacity" name="capacity" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Description / Notes</label>
                    <textarea id="edit_description" name="description" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"></textarea>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-md shadow-blue-600/30 transition">Update Warehouse</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= VIEW DETAILS MODAL ================= -->
    <div id="viewModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div class="modal-backdrop fixed inset-0" onclick="closeViewModal()"></div>
        <div class="bg-white rounded-3xl max-w-md w-full z-10 overflow-hidden shadow-2xl relative p-6 space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-warehouse"></i>
                    </div>
                    <div>
                        <div id="view_name" class="font-extrabold text-base text-slate-900 leading-tight">—</div>
                        <div id="view_code" class="text-xs font-mono font-bold text-blue-600 mt-0.5">—</div>
                    </div>
                </div>
                <button type="button" onclick="closeViewModal()" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div class="space-y-3 text-xs">
                <div class="p-3 bg-slate-50 rounded-xl">
                    <div class="font-bold uppercase tracking-wider text-slate-400 text-[10px]">Location Address</div>
                    <div id="view_location" class="font-medium text-slate-800 text-sm mt-1">—</div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <div class="font-bold uppercase tracking-wider text-slate-400 text-[10px]">Manager</div>
                        <div id="view_manager" class="font-semibold text-slate-800 text-sm mt-0.5">—</div>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <div class="font-bold uppercase tracking-wider text-slate-400 text-[10px]">Phone Contact</div>
                        <div id="view_phone" class="font-semibold text-slate-800 text-sm mt-0.5">—</div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <div class="font-bold uppercase tracking-wider text-slate-400 text-[10px]">Capacity</div>
                        <div id="view_capacity" class="font-semibold text-slate-800 text-sm mt-0.5">— Units</div>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <div class="font-bold uppercase tracking-wider text-slate-400 text-[10px]">Status</div>
                        <div id="view_status_badge" class="mt-1">—</div>
                    </div>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl">
                    <div class="font-bold uppercase tracking-wider text-slate-400 text-[10px]">Description & Notes</div>
                    <div id="view_description" class="text-slate-600 text-xs mt-1 leading-relaxed">—</div>
                </div>
            </div>

            <button type="button" onclick="closeViewModal()" class="w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">
                Close Window
            </button>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="deleteForm" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <!-- ================= JAVASCRIPT ================= -->
    <script>
        // Modal Controls
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }
        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openEditModal(warehouse) {
            document.getElementById('editForm').action = '/warehouses/' + warehouse.id;
            document.getElementById('edit_code').value = warehouse.code;
            document.getElementById('edit_name').value = warehouse.name;
            document.getElementById('edit_location').value = warehouse.location;
            document.getElementById('edit_phone').value = warehouse.phone || '';
            document.getElementById('edit_manager_name').value = warehouse.manager_name || '';
            document.getElementById('edit_capacity').value = warehouse.capacity || 1000;
            document.getElementById('edit_status').value = warehouse.status;
            document.getElementById('edit_description').value = warehouse.description || '';
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openViewModal(warehouse) {
            document.getElementById('view_code').textContent = warehouse.code;
            document.getElementById('view_name').textContent = warehouse.name;
            document.getElementById('view_location').textContent = warehouse.location;
            document.getElementById('view_manager').textContent = warehouse.manager_name || 'N/A';
            document.getElementById('view_phone').textContent = warehouse.phone || 'N/A';
            document.getElementById('view_capacity').textContent = (warehouse.capacity || 1000) + ' Units';
            document.getElementById('view_description').textContent = warehouse.description || 'No additional description provided.';
            
            const badge = document.getElementById('view_status_badge');
            if (warehouse.status === 'Active') {
                badge.innerHTML = '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active</span>';
            } else {
                badge.innerHTML = '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Inactive</span>';
            }

            document.getElementById('viewModal').classList.remove('hidden');
        }
        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        // SweetAlert2 Delete Confirmation
        function confirmDelete(id, name, serialCount) {
            if (serialCount > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'មិនអាចលុបបានទេ (Action Blocked)',
                    text: `ឃ្លាំង "${name}" កំពុងផ្ទុកទំនិញ/សេរៀលចំនួន ${serialCount} គ្រឿង។ សូមផ្ទេរទំនិញចេញសិនមុននឹងលុប!`,
                    confirmButtonText: 'យល់ព្រម (OK)',
                    confirmButtonColor: '#2563eb'
                });
                return;
            }

            Swal.fire({
                title: 'តើអ្នកប្រាកដទេ?',
                text: `តើអ្នកពិតជាចង់លុបឃ្លាំង "${name}" នេះមែនឬទេ? សកម្មភាពនេះមិនអាចត្រឡប់វិញបានឡើយ!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'បាទ/ចាស លុបចេញ (Delete)',
                cancelButtonText: 'បោះបង់ (Cancel)'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = '/warehouses/' + id;
                    form.submit();
                }
            });
        }
    </script>
</body>

</html>
