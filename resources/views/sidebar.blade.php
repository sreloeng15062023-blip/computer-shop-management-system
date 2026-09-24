<aside class="w-64 bg-[#0f172a] text-slate-300 min-h-screen flex flex-col justify-between p-4 shadow-lg shrink-0">
    <div>
        <!-- Logo / Brand Title -->
        <div class="flex items-center gap-3 px-3 py-4 mb-4 border-b border-slate-800">
            <div class="bg-blue-600 p-2 rounded-xl text-white flex items-center justify-center">
                <i class="fa-solid fa-desktop text-xl"></i>
            </div>
            <span class="font-bold text-lg tracking-wide text-white leading-tight">COMPUTER<br><span class="text-blue-500 font-extrabold">SHOP</span></span>
        </div>

        <!-- Navigation Links -->
        <nav class="space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-house w-5 text-center"></i> Dashboard
            </a>

            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-box w-5 text-center"></i> Products
            </a>

            <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('categories.*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-tag w-5 text-center"></i> Categories
            </a>

            <a href="{{ route('brands.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('brands.*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-copyright w-5 text-center"></i> Brands
            </a>

            <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('suppliers.*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-truck w-5 text-center"></i> Suppliers
            </a>

            <a href="{{ route('customers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('customers') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-users w-5 text-center"></i> Customers
            </a>

            <a href="{{ route('purchases') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('purchases') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-cart-shopping w-5 text-center"></i> Purchases
            </a>

            <a href="{{ route('inventory') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('inventory') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-warehouse w-5 text-center"></i> Inventory
            </a>

            <a href="{{ route('pos.sales') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('pos.sales') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-cash-register w-5 text-center"></i> POS Sales
            </a>

            <a href="{{ route('repair.service') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('repair.service') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-wrench w-5 text-center"></i> Repair Service
            </a>

            <a href="{{ route('warranty') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('warranty') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-shield-halved w-5 text-center"></i> Warranty
            </a>

            <a href="{{ route('invoices') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('invoices') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Invoices
            </a>

            <a href="{{ route('employees') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('employees') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-user-gear w-5 text-center"></i> Employees
            </a>

            <a href="{{ route('reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('reports') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-chart-line w-5 text-center"></i> Reports
            </a>

            <a href="{{ route('notifications') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('notifications') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-bell w-5 text-center"></i> Notifications
            </a>

            <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('settings') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-gear w-5 text-center"></i> Settings
            </a>
        </nav>
    </div>

    <!-- Quick Actions Bottom Section -->
    <div class="pt-4 border-t border-slate-800 mt-6">
        <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Quick Actions</p>
        <div class="space-y-2">
            <a href="{{ route('pos.sales') }}" class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-blue-400 bg-blue-950/60 border border-blue-900/50 rounded-xl hover:bg-blue-900/50 transition">
                <i class="fa-solid fa-plus"></i> New Sale (POS)
            </a>
            <a href="{{ route('products.create') }}" class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-slate-300 bg-slate-800/80 border border-slate-700/50 rounded-xl hover:bg-slate-800 transition">
                <i class="fa-solid fa-plus"></i> Add Product
            </a>
        </div>
    </div>
</aside>