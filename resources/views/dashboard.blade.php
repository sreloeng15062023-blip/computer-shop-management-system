<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Shop Dashboard') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Computer Shop Management System (Topic 22)</p>
            </div>
            
            @php
                $role = Auth::user()->role->role_name ?? 'Staff';
                $roleStyles = [
                    'Admin' => 'bg-purple-100 text-purple-800 border-purple-200',
                    'Manager' => 'bg-blue-100 text-blue-800 border-blue-200',
                    'Sale Staff' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                    'Cashier' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                    'Technician' => 'bg-amber-100 text-amber-800 border-amber-200',
                ];
                $badgeStyle = $roleStyles[$role] ?? 'bg-gray-100 text-gray-800 border-gray-200';
            @endphp

            <div class="flex items-center space-x-3">
                <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $badgeStyle }}">
                    Role: {{ $role }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Profile Banner -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-700 rounded-2xl shadow-lg p-6 text-white flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <span class="inline-block bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                        Active Session
                    </span>
                    <h3 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}!</h3>
                    <p class="text-indigo-100 text-sm mt-1">
                        Logged in as <strong class="text-white">{{ Auth::user()->email }}</strong> (Role: {{ $role }}).
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="bg-white text-indigo-900 font-semibold text-xs px-4 py-2 rounded-xl shadow">
                        User ID: #{{ Auth::user()->id }}
                    </span>
                </div>
            </div>

            <!-- Quick Metrics Overview -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Products</div>
                    <div class="text-2xl font-bold text-gray-800 mt-1">128</div>
                    <div class="text-xs text-emerald-600 mt-2 font-medium">↑ 12 added this week</div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-400">Available Stock</div>
                    <div class="text-2xl font-bold text-gray-800 mt-1">842 pcs</div>
                    <div class="text-xs text-blue-600 mt-2 font-medium">14 categories</div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-400">Low Stock Alert</div>
                    <div class="text-2xl font-bold text-rose-600 mt-1">3 items</div>
                    <div class="text-xs text-rose-500 mt-2 font-medium">Requires purchase order</div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-400">Active Repairs</div>
                    <div class="text-2xl font-bold text-amber-600 mt-1">5 orders</div>
                    <div class="text-xs text-amber-600 mt-2 font-medium">2 ready for pickup</div>
                </div>
            </div>

            <!-- 16 Functional Modules Roadmap -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="font-bold text-lg text-gray-900">System Modules (Topic 22)</h4>
                        <p class="text-xs text-gray-500">All 16 functional modules required for the Computer Shop Management System.</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @php
                        $modules = [
                            ['icon' => '🔐', 'name' => '1. User Auth', 'desc' => 'Login, RBAC & profiles', 'status' => 'Done'],
                            ['icon' => '📊', 'name' => '2. Dashboard', 'desc' => 'Sales & stock metrics', 'status' => 'Active'],
                            ['icon' => '💻', 'name' => '3. Products', 'desc' => 'SKU, barcodes, pricing', 'status' => 'Ready'],
                            ['icon' => '🏷️', 'name' => '4. Brands', 'desc' => 'Dell, HP, Apple, etc.', 'status' => 'Ready'],
                            ['icon' => '🚚', 'name' => '5. Suppliers', 'desc' => 'Procurement & contacts', 'status' => 'Pending'],
                            ['icon' => '👥', 'name' => '6. Customers', 'desc' => 'Profiles & loyalty points', 'status' => 'Pending'],
                            ['icon' => '📦', 'name' => '7. Purchases', 'desc' => 'Purchase orders & receive', 'status' => 'Pending'],
                            ['icon' => '🏬', 'name' => '8. Inventory', 'desc' => 'Stock in/out & serials', 'status' => 'Pending'],
                            ['icon' => '💳', 'name' => '9. POS Sales', 'desc' => 'Terminal, cart, receipts', 'status' => 'Pending'],
                            ['icon' => '🔧', 'name' => '10. Repairs', 'desc' => 'Diagnosis & technician assign', 'status' => 'Pending'],
                            ['icon' => '🛡️', 'name' => '11. Warranty', 'desc' => 'Claims & expiry checks', 'status' => 'Pending'],
                            ['icon' => '🧾', 'name' => '12. Invoices', 'desc' => 'Payments & refunds', 'status' => 'Pending'],
                            ['icon' => '👔', 'name' => '13. Employees', 'desc' => 'Attendance & schedule', 'status' => 'Pending'],
                            ['icon' => '📈', 'name' => '14. Reports', 'desc' => 'Sales, PDF & Excel export', 'status' => 'Pending'],
                            ['icon' => '🔔', 'name' => '15. Notifications', 'desc' => 'Low stock & alerts', 'status' => 'Pending'],
                            ['icon' => '⚙️', 'name' => '16. Settings', 'desc' => 'Tax, currency, DB backup', 'status' => 'Pending'],
                        ];
                    @endphp

                    @foreach($modules as $mod)
                        <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-indigo-50/50 hover:border-indigo-100 transition">
                            <div class="text-2xl mb-1">{{ $mod['icon'] }}</div>
                            <div class="font-semibold text-sm text-gray-800">{{ $mod['name'] }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $mod['desc'] }}</div>
                            <div class="mt-2">
                                @if($mod['status'] === 'Done')
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">Completed</span>
                                @elseif($mod['status'] === 'Active')
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">Active</span>
                                @else
                                    <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-gray-200 text-gray-600">Pending</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
