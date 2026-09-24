<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Computer Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-100 font-sans">

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
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-house w-5"></i> Dashboard
                    </a>

                    <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition bg-blue-600 text-white">
                        <i class="fa-solid fa-box w-5"></i> Products
                    </a>

                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-tags w-5"></i> Categories
                    </a>

                    <a href="{{ route('brands.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-copyright w-5"></i> Brands
                    </a>

                    <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
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

            <div class="mt-6 space-y-2 border-t border-slate-800 pt-4">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3">Quick Actions</span>
                <a href="{{ route('pos.sales') }}" class="flex items-center gap-2 w-full px-3 py-2 bg-blue-600/20 text-blue-400 rounded-lg text-sm hover:bg-blue-600 hover:text-white transition">
                    <i class="fa-solid fa-plus text-xs"></i> New Sale (POS)
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-y-auto bg-slate-50">

            <!-- Header Section (ដូចរូបភាព) -->
            <header class="p-8 pb-4 flex items-center justify-between">
                <h1 class="text-3xl font-bold text-slate-800">Products</h1>

                <div class="flex items-center gap-3">
                    <button class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-semibold flex items-center gap-2 hover:bg-gray-50 transition shadow-sm">
                        More Actions <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                    </button>

                    <a href="{{ route('products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold flex items-center gap-2 hover:bg-blue-700 transition shadow-sm shadow-blue-200">
                        <i class="fa-solid fa-plus text-xs"></i> New Product
                    </a>
                </div>
            </header>

            <!-- Dashboard Content Container -->
            <div class="px-8 pb-8 flex-1">
                @if(empty($products) || count($products) == 0)
                <!-- Empty State Card (ដូចរូបភាព) -->
                <div class="bg-slate-100/70 border border-slate-200/80 rounded-2xl p-16 flex flex-col items-center justify-center text-center h-[70vh] shadow-inner">

                    <!-- Graphic Icon -->
                    <div class="relative mb-6">
                        <div class="flex items-center justify-center gap-2">
                            <div class="w-16 h-20 bg-emerald-400 rounded-lg shadow-md flex items-center justify-center transform -rotate-6">
                                <i class="fa-solid fa-tag text-white text-xl"></i>
                            </div>
                            <div class="w-16 h-20 bg-blue-500 rounded-lg shadow-md flex items-center justify-center transform rotate-6">
                                <i class="fa-solid fa-box text-white text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Info Text -->
                    <h2 class="text-xl font-bold text-slate-800 mb-2">You don't have any products yet</h2>
                    <p class="text-slate-400 text-sm mb-6 max-w-sm">Create your product in an easy & fast way to display it on your site</p>

                    <!-- Action Link -->
                    <a href="{{ route('products.create') }}" class="text-blue-500 font-semibold text-sm hover:underline flex items-center gap-1.5">
                        <i class="fa-solid fa-plus text-xs"></i> New Product
                    </a>
                </div>
                @else
                <!-- Table បង្ហាញនៅពេលមាន Product -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 border-b text-gray-400 uppercase text-xs">
                            <tr>
                                <th class="p-4">Product</th>
                                <th class="p-4">Price</th>
                                <th class="p-4">Stock</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($products as $product)
                            <tr>
                                <td class="p-4 font-semibold text-gray-800">{{ $product->name ?? 'N/A' }}</td>
                                <td class="p-4">${{ number_format($product->price ?? 0, 2) }}</td>
                                <td class="p-4">{{ $product->qty ?? 0 }}</td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('products.edit', $product->id ?? 1) }}" class="text-blue-600 mr-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

        </main>
    </div>

</body>

</html>