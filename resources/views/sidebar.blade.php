<aside id="sidebarMenu" class="w-64 bg-[#0B132B] text-slate-300 flex-shrink-0 hidden lg:flex flex-col fixed h-screen z-30 shadow-2xl select-none transition-all duration-300">
    <style>
        #sidebarMenu nav::-webkit-scrollbar { display: none !important; width: 0 !important; height: 0 !important; }
        #sidebarMenu nav { -ms-overflow-style: none !important; scrollbar-width: none !important; }
    </style>
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
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
        <!-- 1. Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-house w-5 text-center text-sm"></i>
                <span>Dashboard</span>
            </div>
            @if(request()->routeIs('dashboard'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 2. Products -->
        <a href="{{ route('products.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-box-open w-5 text-center text-sm"></i>
                <span>Products</span>
            </div>
            @if(request()->routeIs('products.*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 3. Categories -->
        <a href="{{ route('categories.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('categories.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-layer-group w-5 text-center text-sm"></i>
                <span>Categories</span>
            </div>
            @if(request()->routeIs('categories.*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 4. Brands -->
        <a href="{{ route('brands.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('brands.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-copyright w-5 text-center text-sm"></i>
                <span>Brands</span>
            </div>
            @if(request()->routeIs('brands.*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 5. Suppliers -->
        <a href="{{ route('suppliers.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('suppliers.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-truck-fast w-5 text-center text-sm"></i>
                <span>Suppliers</span>
            </div>
            @if(request()->routeIs('suppliers.*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 6. Customers -->
        <a href="{{ route('customers.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('customers*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-users w-5 text-center text-sm"></i>
                <span>Customers</span>
            </div>
            @if(request()->routeIs('customers*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 7. Purchases -->
        <a href="{{ route('purchases') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('purchases*') || request()->routeIs('purchase-orders*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-cart-shopping w-5 text-center text-sm"></i>
                <span>Purchases</span>
            </div>
            @if(request()->routeIs('purchases*') || request()->routeIs('purchase-orders*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 8. Inventory -->
        <a href="{{ route('inventory') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('inventory*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-warehouse w-5 text-center text-sm"></i>
                <span>Inventory</span>
            </div>
            @if(request()->routeIs('inventory*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 9. POS / Sales -->
        <a href="{{ route('pos.sales') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('pos.*') || request()->routeIs('sales.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-cash-register w-5 text-center text-sm"></i>
                <span>POS / Sales</span>
            </div>
            @if(request()->routeIs('pos.*') || request()->routeIs('sales.*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 10. Repair Service -->
        <a href="{{ route('repair.service') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('repair.*') || request()->routeIs('repairs.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-wrench w-5 text-center text-sm"></i>
                <span>Repair Service</span>
            </div>
            @if(request()->routeIs('repair.*') || request()->routeIs('repairs.*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 11. Warranty -->
        <a href="{{ route('warranty') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('warrant*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-shield-halved w-5 text-center text-sm"></i>
                <span>Warranty</span>
            </div>
            @if(request()->routeIs('warrant*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 12. Invoices -->
        <a href="{{ route('invoices') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('invoices*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-sm"></i>
                <span>Invoices</span>
            </div>
            @if(request()->routeIs('invoices*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 13. Employees -->
        <a href="{{ route('employees') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('employees*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-user-gear w-5 text-center text-sm"></i>
                <span>Employees</span>
            </div>
            @if(request()->routeIs('employees*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 14. Reports -->
        <a href="{{ route('reports') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('reports*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-chart-pie w-5 text-center text-sm"></i>
                <span>Reports</span>
            </div>
            @if(request()->routeIs('reports*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 15. Notifications -->
        <a href="{{ route('notifications') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('notifications*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-bell w-5 text-center text-sm"></i>
                <span>Notifications</span>
            </div>
            @if(($unreadNotificationsCount ?? 0) > 0)
                <span class="px-2 py-0.5 text-[11px] font-bold bg-rose-500 text-white rounded-full">
                    {{ $unreadNotificationsCount }}
                </span>
            @elseif(request()->routeIs('notifications*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>

        <!-- 16. Settings -->
        <a href="{{ route('settings') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('settings*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30' : 'text-slate-400 hover:bg-slate-800/80 hover:text-white' }}">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-gear w-5 text-center text-sm"></i>
                <span>Settings</span>
            </div>
            @if(request()->routeIs('settings*'))
                <i class="fa-solid fa-chevron-right text-[10px] opacity-70"></i>
            @endif
        </a>
    </nav>

    <!-- Sidebar Clean Logout Footer (No profile card, only Logout button) -->
    <div class="p-3 border-t border-slate-800/80 bg-slate-900/50">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition">
                <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center text-base"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>