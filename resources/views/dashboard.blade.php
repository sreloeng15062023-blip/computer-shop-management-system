<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Computer Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between p-4 overflow-y-auto">
            <div>
                <!-- Logo -->
                <div class="flex items-center gap-3 px-3 py-4 border-b border-slate-800 mb-4">
                    <i class="fa-solid fa-desktop text-blue-500 text-2xl"></i>
                    <span class="font-bold text-lg tracking-wide">COMPUTER SHOP</span>
                </div>

                <!-- Navigation Menu -->
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-house w-5"></i> Dashboard
                    </a>

                    <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-box w-5"></i> Products
                    </a>

                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('categories.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-tags w-5"></i> Categories
                    </a>

                    <a href="{{ route('brands.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('brands.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-copyright w-5"></i> Brands
                    </a>

                    <a href="{{ route('suppliers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-truck-field w-5"></i> Suppliers
                    </a>

                    <a href="{{ route('customers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-users w-5"></i> Customers
                    </a>

                    <a href="{{ route('purchases') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-cart-shopping w-5"></i> Purchases
                    </a>

                    <a href="{{ route('inventory') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-warehouse w-5"></i> Inventory
                    </a>

                    <a href="{{ route('pos.sales') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-cash-register w-5"></i> POS Sales
                    </a>

                    <a href="{{ route('repair.service') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-wrench w-5"></i> Repair Service
                    </a>

                    <a href="{{ route('warranty') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-shield-halved w-5"></i> Warranty
                    </a>

                    <a href="{{ route('invoices') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-file-invoice-dollar w-5"></i> Invoices
                    </a>

                    <a href="{{ route('employees') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-user-gear w-5"></i> Employees
                    </a>

                    <a href="{{ route('reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-chart-line w-5"></i> Reports
                    </a>

                    <a href="{{ route('notifications') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-bell w-5"></i> Notifications
                    </a>

                    <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-gear w-5"></i> Settings
                    </a>
                </nav>
            </div>

            <!-- Quick Actions Buttons -->
            <div class="mt-6 space-y-2 border-t border-slate-800 pt-4">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3">Quick Actions</span>
                <a href="{{ route('pos.sales') }}" class="flex items-center gap-2 w-full px-3 py-2 bg-blue-600/20 text-blue-400 rounded-lg text-sm hover:bg-blue-600 hover:text-white transition">
                    <i class="fa-solid fa-plus text-xs"></i> New Sale (POS)
                </a>
                <a href="{{ route('products.create') }}" class="flex items-center gap-2 w-full px-3 py-2 bg-slate-800 text-slate-300 rounded-lg text-sm hover:bg-slate-700 hover:text-white transition">
                    <i class="fa-solid fa-plus text-xs"></i> Add Product
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-y-auto">

            <!-- Top Header -->
            <header class="bg-white border-b px-8 py-4 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <button class="text-gray-500 hover:text-gray-700"><i class="fa-solid fa-bars text-lg"></i></button>
                    <h1 class="text-xl font-bold text-gray-800">Dashboard</h1>
                </div>

                <!-- Search Input -->
                <div class="w-1/3 relative">
                    <input type="text" placeholder="Search everything..." class="w-full pl-10 pr-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-sm"></i>
                </div>

                <!-- Top Icons & User Profile -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('notifications') }}" class="relative text-gray-500 hover:text-blue-600 p-2">
                        <i class="fa-solid fa-bell"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </a>
                    <a href="{{ route('notifications') }}" class="text-gray-500 hover:text-blue-600 p-2">
                        <i class="fa-solid fa-comment-dots"></i>
                    </a>
                    @auth
                    <div class="flex items-center gap-3 pl-4 border-l">
                        <div class="w-9 h-9 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center text-sm shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-800 leading-tight">{{ Auth::user()->name }}</div>
                            <div class="text-[11px] font-semibold text-indigo-600 leading-tight">
                                Role: {{ Auth::user()->role->role_name ?? 'Staff' }}
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs text-red-500 hover:underline">Logout</button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>
            </header>

            <!-- Dashboard Body -->
            <div class="p-8 space-y-6">

                <!-- Stat Cards Grid -->
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-white p-5 rounded-xl shadow-sm border flex items-center gap-4">
                        <div class="p-3 bg-blue-100 text-blue-600 rounded-lg"><i class="fa-solid fa-box text-xl"></i></div>
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase">Total Products</div>
                            <div class="text-2xl font-bold text-gray-800">12,580</div>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border flex items-center gap-4">
                        <div class="p-3 bg-emerald-100 text-emerald-600 rounded-lg"><i class="fa-solid fa-cubes text-xl"></i></div>
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase">Available Stock</div>
                            <div class="text-2xl font-bold text-gray-800">8,920</div>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border flex items-center gap-4">
                        <div class="p-3 bg-amber-100 text-amber-600 rounded-lg"><i class="fa-solid fa-triangle-exclamation text-xl"></i></div>
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase">Low Stock Alert</div>
                            <div class="text-2xl font-bold text-gray-800">37</div>
                        </div>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow-sm border flex items-center gap-4">
                        <div class="p-3 bg-indigo-100 text-indigo-600 rounded-lg"><i class="fa-solid fa-cart-shopping text-xl"></i></div>
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase">Today's Sales</div>
                            <div class="text-2xl font-bold text-gray-800">$8,950</div>
                        </div>
                    </div>
                </div>

                <!-- Section Grid (Best Selling & Low Stock) -->
                <div class="grid grid-cols-3 gap-6">

                    <!-- Best Selling Products Table -->
                    <div class="col-span-2 bg-white rounded-xl shadow-sm border p-5">
                        <h2 class="font-bold text-gray-800 mb-4">Best Selling Products</h2>
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b">
                                <tr>
                                    <th class="p-3">#</th>
                                    <th class="p-3">Product</th>
                                    <th class="p-3">SKU</th>
                                    <th class="p-3">Sold (Qty)</th>
                                    <th class="p-3">Revenue</th>
                                    <th class="p-3">Stock</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <tr>
                                    <td class="p-3">1</td>
                                    <td class="p-3 font-semibold text-gray-800">ASUS RTX 4070 12GB</td>
                                    <td class="p-3 text-gray-400">GPU001</td>
                                    <td class="p-3">158</td>
                                    <td class="p-3">$94,000</td>
                                    <td class="p-3 text-emerald-600 font-bold">32</td>
                                </tr>
                                <tr>
                                    <td class="p-3">2</td>
                                    <td class="p-3 font-semibold text-gray-800">Samsung SSD 1TB</td>
                                    <td class="p-3 text-gray-400">SSD100</td>
                                    <td class="p-3">146</td>
                                    <td class="p-3">$21,000</td>
                                    <td class="p-3 text-emerald-600 font-bold">85</td>
                                </tr>
                                <tr>
                                    <td class="p-3">3</td>
                                    <td class="p-3 font-semibold text-gray-800">Intel Core i7-13700K</td>
                                    <td class="p-3 text-gray-400">CPU700</td>
                                    <td class="p-3">120</td>
                                    <td class="p-3">$42,000</td>
                                    <td class="p-3 text-amber-500 font-bold">28</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- View All Link (ចុចបាន) -->
                        <div class="mt-4 text-center border-t pt-3">
                            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition">
                                View All Products →
                            </a>
                        </div>
                    </div>

                    <!-- Low Stock Alert Box -->
                    <div class="bg-white rounded-xl shadow-sm border p-5">
                        <h2 class="font-bold text-gray-800 mb-4">Low Stock Alert</h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-2 bg-red-50 rounded-lg border border-red-100">
                                <div>
                                    <div class="font-semibold text-sm text-gray-800">MSI GeForce RTX 4060</div>
                                    <div class="text-xs text-red-600">Current: 2 | Min: 10</div>
                                </div>
                                <a href="{{ route('products.index') }}" class="p-2 text-red-600 hover:bg-red-100 rounded-lg"><i class="fa-solid fa-cart-plus"></i></a>
                            </div>
                            <div class="flex items-center justify-between p-2 bg-amber-50 rounded-lg border border-amber-100">
                                <div>
                                    <div class="font-semibold text-sm text-gray-800">Corsair DDR5 16GB RAM</div>
                                    <div class="text-xs text-amber-600">Current: 5 | Min: 20</div>
                                </div>
                                <a href="{{ route('products.index') }}" class="p-2 text-amber-600 hover:bg-amber-100 rounded-lg"><i class="fa-solid fa-cart-plus"></i></a>
                            </div>
                        </div>
                        <div class="mt-4 text-center border-t pt-3">
                            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-blue-600 hover:underline">
                                View All Low Stock Items →
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Recent Sales Transactions -->
                <div class="bg-white rounded-xl shadow-sm border p-5">
                    <h2 class="font-bold text-gray-800 mb-4">Recent Sales Transactions</h2>
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b">
                            <tr>
                                <th class="p-3">Invoice</th>
                                <th class="p-3">Date & Time</th>
                                <th class="p-3">Customer</th>
                                <th class="p-3">Total</th>
                                <th class="p-3">Status</th>
                                <th class="p-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr>
                                <td class="p-3 font-semibold text-blue-600">INV-123</td>
                                <td class="p-3 text-gray-500">May 15, 2026 10:30 PM</td>
                                <td class="p-3">Khouet Sony</td>
                                <td class="p-3 font-bold text-gray-800">$950.00</td>
                                <td class="p-3"><span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">Paid</span></td>
                                <td class="p-3 text-center space-x-2">
                                    <a href="{{ route('invoices') }}" class="text-gray-600 hover:text-blue-600"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('invoices') }}" class="text-gray-600 hover:text-blue-600"><i class="fa-solid fa-print"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- View All Sales Link (ចុចបាន) -->
                    <div class="mt-4 text-center border-t pt-3">
                        <a href="{{ route('invoices') }}" class="text-sm font-semibold text-blue-600 hover:underline">
                            View All Sales →
                        </a>
                    </div>
                </div>

            </div>

        </main>
    </div>

</body>

</html>