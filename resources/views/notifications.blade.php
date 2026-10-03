<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notification System | TECHZONE Computer Shop</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Kantumruy+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1D68FE',
                        primaryHover: '#1557E0',
                        techdark: '#0B132B',
                        sidebarBg: '#091024',
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', 'Kantumruy Pro', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-[#F3F6FC] text-slate-800 antialiased">

<div class="flex min-h-screen">

    {{-- ===================================================================== --}}
    {{-- SIDEBAR NAVIGATION (រចនាដូចក្នុងរូបភាព UI Mockup)                  --}}
    {{-- ===================================================================== --}}
    <aside class="w-64 bg-[#091024] text-slate-300 flex-shrink-0 hidden lg:flex flex-col justify-between fixed h-screen z-30 shadow-2xl">
        <div class="flex flex-col h-full overflow-y-auto custom-scrollbar">
            
            <!-- Brand Logo Header -->
            <div class="px-6 py-5 border-b border-slate-800/80 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-600/30">
                    <i class="fa-solid fa-cube text-xl"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-lg text-white tracking-wider leading-none">TECHZONE</h1>
                    <p class="text-[10px] text-slate-400 font-medium tracking-tight mt-1">Computer Shop Management System</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-house w-5 text-center text-base"></i> Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-shapes w-5 text-center text-base"></i> Product Management
                </a>
                <a href="{{ route('purchases') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-cart-shopping w-5 text-center text-base"></i> Purchase Management
                </a>
                <a href="{{ route('inventory') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-boxes-stacked w-5 text-center text-base"></i> Inventory Management
                </a>
                <a href="{{ route('pos.sales') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-cash-register w-5 text-center text-base"></i> Sales Management (POS)
                </a>
                <a href="{{ route('repair.service') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-wrench w-5 text-center text-base"></i> Repair Service Management
                </a>
                <a href="{{ route('warranty') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-shield-halved w-5 text-center text-base"></i> Warranty Management
                </a>
                <a href="{{ route('invoices') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-base"></i> Payment & Invoice
                </a>
                <a href="{{ route('employees') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-user-group w-5 text-center text-base"></i> Employee Management
                </a>
                <a href="{{ route('customers') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-users w-5 text-center text-base"></i> Customer Management
                </a>
                <a href="{{ route('reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-chart-pie w-5 text-center text-base"></i> Report Management
                </a>

                <!-- Active Menu: Notification System (រំលេចពណ៌ខៀវ និង Dropdown ដូច Mockup) -->
                <div class="pt-1">
                    <div class="bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-600/30 flex items-center justify-between px-3.5 py-2.5 cursor-pointer">
                        <div class="flex items-center gap-3 font-semibold text-sm">
                            <i class="fa-solid fa-bell text-base"></i> Notification
                        </div>
                        <i class="fa-solid fa-chevron-up text-xs"></i>
                    </div>

                    <!-- Submenu items -->
                    <div class="pl-5 pr-2 py-2 space-y-1 text-xs">
                        <a href="{{ route('notifications', ['tab' => 'all']) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-white font-medium hover:bg-slate-800/50">
                            <span class="flex items-center gap-2.5"><i class="fa-regular fa-bell"></i> All Notifications</span>
                        </a>
                        <a href="{{ route('notifications', ['tab' => 'messages']) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50">
                            <span class="flex items-center gap-2.5"><i class="fa-regular fa-envelope"></i> New Messages</span>
                            <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $messagesCount ?? 5 }}</span>
                        </a>
                        <a href="{{ route('notifications', ['tab' => 'system_alerts']) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50">
                            <span class="flex items-center gap-2.5"><i class="fa-solid fa-triangle-exclamation"></i> System Alerts</span>
                            <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $systemAlertCount ?? 2 }}</span>
                        </a>
                        <a href="{{ route('settings') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50">
                            <span class="flex items-center gap-2.5"><i class="fa-solid fa-gear"></i> Settings</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-gear w-5 text-center text-base"></i> Settings
                </a>
            </nav>

            <!-- User Footer Profile -->
            <div class="mt-auto p-4 border-t border-slate-800/80 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Sok+Dara&background=0284c7&color=fff" class="w-9 h-9 rounded-full object-cover border border-slate-700">
                    <div>
                        <h4 class="text-xs font-semibold text-white leading-tight">Sok Dara</h4>
                        <p class="text-[10px] text-slate-400">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-red-400 transition" title="Logout">
                        <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ===================================================================== --}}
    {{-- MAIN CONTENT AREA                                                     --}}
    {{-- ===================================================================== --}}
    <div class="flex-1 lg:pl-64 flex flex-col min-w-0">

        <!-- Top Header Navbar -->
        <header class="h-16 bg-white border-b border-slate-200/80 px-6 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div class="flex items-center gap-4 flex-1 max-w-xl">
                <button class="lg:hidden text-slate-600 hover:text-slate-900">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="relative w-full">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" placeholder="Search notifications, user, product, or anything..."
                           class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative">
                    <button class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition">
                        <i class="fa-solid fa-bell text-sm"></i>
                    </button>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center border-2 border-white">5</span>
                </div>
                <button class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition">
                    <i class="fa-solid fa-expand text-sm"></i>
                </button>
                <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                    <img src="https://ui-avatars.com/api/?name=Sok+Dara&background=0284c7&color=fff" class="w-9 h-9 rounded-full object-cover">
                    <div class="hidden sm:block text-left">
                        <div class="text-xs font-bold text-slate-800 leading-tight">Sok Dara</div>
                        <div class="text-[10px] text-slate-400">Administrator</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="p-6 space-y-6">

            <!-- Banner Header ដូច Mockup -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-600/30">
                        <i class="fa-solid fa-bell text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 tracking-tight">Notification System</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Stay updated with the latest activities, alerts and important information.</p>
                    </div>
                </div>

                <div class="flex items-center gap-2.5">
                    <form action="{{ route('notifications.markAllRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                            <i class="fa-solid fa-check-double text-xs"></i> Mark All as Read
                        </button>
                    </form>
                    <a href="{{ route('settings') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl shadow-sm transition">
                        <i class="fa-solid fa-gear text-xs text-slate-400"></i> Settings
                    </a>
                </div>
            </div>

            <!-- Tabs Navigation -->
            @php $currentTab = request('tab', 'all'); @endphp
            <div class="flex items-center gap-6 border-b border-slate-200 text-xs font-semibold">
                <a href="{{ route('notifications', array_merge(request()->query(), ['tab' => 'all'])) }}"
                   class="pb-3 border-b-2 flex items-center gap-1.5 transition {{ $currentTab === 'all' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                    All <span class="bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded-full text-[10px]">({{ $totalCount }})</span>
                </a>
                <a href="{{ route('notifications', array_merge(request()->query(), ['tab' => 'messages'])) }}"
                   class="pb-3 border-b-2 flex items-center gap-1.5 transition {{ $currentTab === 'messages' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                    Messages <span class="text-slate-400 text-[10px]">({{ $messagesCount }})</span>
                </a>
                <a href="{{ route('notifications', array_merge(request()->query(), ['tab' => 'system_alerts'])) }}"
                   class="pb-3 border-b-2 flex items-center gap-1.5 transition {{ $currentTab === 'system_alerts' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                    System Alerts <span class="text-slate-400 text-[10px]">({{ $systemAlertCount }})</span>
                </a>
                <a href="{{ route('notifications', array_merge(request()->query(), ['tab' => 'reminders'])) }}"
                   class="pb-3 border-b-2 flex items-center gap-1.5 transition {{ $currentTab === 'reminders' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                    Reminders <span class="text-slate-400 text-[10px]">({{ $reminderCount }})</span>
                </a>
                <a href="{{ route('notifications', array_merge(request()->query(), ['tab' => 'others'])) }}"
                   class="pb-3 border-b-2 flex items-center gap-1.5 transition {{ $currentTab === 'others' ? 'border-blue-600 text-blue-600 font-bold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                    Others <span class="text-slate-400 text-[10px]">({{ $othersCount }})</span>
                </a>
            </div>

            {{-- ============================================================= --}}
            {{-- 2-COLUMN LAYOUT: LEFT (List & Filters) | RIGHT (Side Panel)   --}}
            {{-- ============================================================= --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                <!-- LEFT COLUMN: Filters, Notification Items & Pagination (8/12) -->
                <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 space-y-4">

                    <!-- Filter Bar ដូចរូប Mockup -->
                    <form method="GET" action="{{ route('notifications') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-2.5">
                        <input type="hidden" name="tab" value="{{ $currentTab }}">

                        <!-- Search Input -->
                        <div class="sm:col-span-5 relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Search notification by title, content, or user..."
                                   class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-3 py-2 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>

                        <!-- Dropdown Type -->
                        <div class="sm:col-span-2">
                            <select name="type" onchange="this.form.submit()"
                                    class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl px-2.5 py-2 text-slate-600 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                <option value="all">All Types</option>
                                <option value="Low Stock Alert" {{ request('type') == 'Low Stock Alert' ? 'selected' : '' }}>Low Stock Alert</option>
                                <option value="Warranty Expiry Reminder" {{ request('type') == 'Warranty Expiry Reminder' ? 'selected' : '' }}>Warranty Expiry</option>
                                <option value="Repair Completion" {{ request('type') == 'Repair Completion' ? 'selected' : '' }}>Repair Completion</option>
                                <option value="Promotion Notification" {{ request('type') == 'Promotion Notification' ? 'selected' : '' }}>Promotion</option>
                                <option value="Purchase Order Reminder" {{ request('type') == 'Purchase Order Reminder' ? 'selected' : '' }}>Purchase Order</option>
                            </select>
                        </div>

                        <!-- Dropdown Status -->
                        <div class="sm:col-span-2">
                            <select name="status" onchange="this.form.submit()"
                                    class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl px-2.5 py-2 text-slate-600 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                <option value="all">All Status</option>
                                <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div class="sm:col-span-3 relative flex items-center">
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full bg-slate-50 border border-slate-200 text-[11px] rounded-xl px-2 py-2 text-slate-600">
                            <span class="px-1 text-slate-400 text-xs">→</span>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-200 text-[11px] rounded-xl px-2 py-2 text-slate-600">
                        </div>
                    </form>

                    <!-- Bulk Actions Toolbar (លេចឡើងពេល User ធីក Checkbox) -->
                    <div id="bulkActionBar" class="hidden items-center justify-between bg-blue-50 border border-blue-200 rounded-xl px-4 py-2 text-xs">
                        <span class="text-blue-800 font-semibold"><span id="selectedCount">0</span> notifications selected</span>
                        <div class="flex items-center gap-2">
                            <button onclick="handleBulkAction('mark_read')" class="px-3 py-1 bg-white border border-blue-300 text-blue-700 rounded-lg hover:bg-blue-100 font-medium">Mark Read</button>
                            <button onclick="handleBulkAction('delete')" class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">Delete</button>
                        </div>
                    </div>

                    <!-- Notification List (Loop) -->
                    <div class="space-y-2">
                        @forelse($notifications as $item)
                            @php
                                // រៀបចំពណ៌ Badge Pill និង Icon Background ឱ្យដូច Mockup
                                $badgeColor = 'bg-blue-50 text-blue-600 border-blue-200';
                                $badgeLabel = 'Message';

                                if ($item->category === 'system_alerts') {
                                    $badgeColor = 'bg-rose-50 text-rose-600 border-rose-200';
                                    $badgeLabel = 'System Alert';
                                } elseif ($item->category === 'reminders') {
                                    $badgeColor = 'bg-amber-50 text-amber-600 border-amber-200';
                                    $badgeLabel = 'Reminder';
                                } elseif ($item->category === 'others') {
                                    $badgeColor = 'bg-slate-100 text-slate-600 border-slate-200';
                                    $badgeLabel = 'Others';
                                }

                                // Icon styling
                                $iconBg = 'bg-blue-500 text-white';
                                if ($item->icon_color === 'emerald') $iconBg = 'bg-emerald-500 text-white';
                                if ($item->icon_color === 'amber')   $iconBg = 'bg-amber-500 text-white';
                                if ($item->icon_color === 'rose')    $iconBg = 'bg-rose-500 text-white';
                                if ($item->icon_color === 'indigo')  $iconBg = 'bg-indigo-500 text-white';
                                if ($item->icon_color === 'cyan')    $iconBg = 'bg-cyan-500 text-white';
                                if ($item->icon_color === 'purple')  $iconBg = 'bg-purple-500 text-white';
                            @endphp

                            <div class="notification-row group flex items-center justify-between p-3 rounded-xl border transition cursor-pointer select-none {{ $item->is_read ? 'bg-white border-slate-200/80 hover:border-blue-300' : 'bg-blue-50/40 border-blue-200 hover:bg-blue-50/70' }}"
                                 id="notif-row-{{ $item->id }}"
                                 onclick="selectNotification({{ $item->id }})">
                                
                                <div class="flex items-center gap-3.5 min-w-0 pr-3">
                                    <!-- Checkbox -->
                                    <input type="checkbox" value="{{ $item->id }}" class="item-checkbox rounded border-slate-300 text-blue-600 focus:ring-0 w-4 h-4 cursor-pointer" onclick="event.stopPropagation(); updateBulkCount();">

                                    <!-- Rounded Icon -->
                                    <div class="w-10 h-10 rounded-full {{ $iconBg }} flex items-center justify-center flex-shrink-0 shadow-sm">
                                        <i class="fa-solid {{ $item->icon }} text-sm"></i>
                                    </div>

                                    <!-- Title & Summary -->
                                    <div class="min-w-0">
                                        <h4 class="text-xs font-bold text-slate-800 truncate group-hover:text-blue-600 transition flex items-center gap-2">
                                            {{ $item->title }}
                                            @if(!$item->is_read)
                                                <span class="w-2 h-2 rounded-full bg-blue-600 inline-block"></span>
                                            @endif
                                        </h4>
                                        <p class="text-[11px] text-slate-500 truncate mt-0.5">{{ Str::limit($item->message, 80) }}</p>
                                    </div>
                                </div>

                                <!-- Right side info (Timestamp, Badge, Actions) -->
                                <div class="flex items-center gap-3 flex-shrink-0">
                                    <span class="text-[11px] text-slate-400 font-medium">{{ $item->created_at->format('Y-m-d h:i A') }}</span>
                                    <span class="text-[10px] font-semibold px-2.5 py-0.5 rounded-full border {{ $badgeColor }}">
                                        {{ $badgeLabel }}
                                    </span>
                                    
                                    <!-- Action Menu -->
                                    <div class="relative" onclick="event.stopPropagation();">
                                        <button onclick="toggleDropdown({{ $item->id }})" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 flex items-center justify-center">
                                            <i class="fa-solid fa-ellipsis-vertical text-xs"></i>
                                        </button>
                                        <div id="dropdown-{{ $item->id }}" class="hidden absolute right-0 mt-1 w-32 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-30 text-xs">
                                            <a href="javascript:void(0)" onclick="markSingleRead({{ $item->id }})" class="block px-3 py-1.5 text-slate-600 hover:bg-slate-50">
                                                <i class="fa-solid fa-check mr-1.5 text-blue-600"></i> Mark Read
                                            </a>
                                            <a href="javascript:void(0)" onclick="deleteNotification({{ $item->id }})" class="block px-3 py-1.5 text-red-600 hover:bg-red-50">
                                                <i class="fa-solid fa-trash mr-1.5"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 text-slate-400">
                                <i class="fa-regular fa-bell-slash text-3xl mb-2"></i>
                                <p class="text-xs">No notifications found.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Footer ដូចរូបភាព -->
                    <div class="pt-4 border-t border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
                        <div>
                            Showing {{ $notifications->firstItem() ?? 0 }} to {{ $notifications->lastItem() ?? 0 }} of {{ $notifications->total() }} notifications
                        </div>
                        <div>
                            {{ $notifications->links() }}
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Side Panels (Details, Statistics, Quick Actions, Promo Banner) (4/12) -->
                <div class="lg:col-span-4 space-y-5">

                    <!-- CARD 1: Notification Details (បង្ហាញទិន្នន័យនៃសារដែលបាន Click) -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-2 text-xs font-bold text-slate-800">
                                <i class="fa-regular fa-bell text-blue-600"></i> Notification Details
                            </div>
                            <button class="text-slate-400 hover:text-slate-600 text-xs">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        @if($firstNotification)
                            <div id="detailPanel" class="space-y-3.5">
                                <div class="flex items-start gap-3">
                                    <div id="detailIcon" class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-blue-500/20">
                                        <i class="fa-solid {{ $firstNotification->icon }} text-lg"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h3 id="detailTitle" class="text-sm font-bold text-slate-900 leading-snug">{{ $firstNotification->title }}</h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span id="detailBadge" class="bg-blue-50 text-blue-600 border border-blue-200 text-[10px] font-semibold px-2 py-0.5 rounded-full">
                                                {{ ucfirst($firstNotification->category) }}
                                            </span>
                                            <span id="detailTime" class="text-[10px] text-slate-400">
                                                <i class="fa-regular fa-clock mr-1"></i>{{ $firstNotification->created_at->format('Y-m-d h:i A') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-slate-50 rounded-xl p-3 text-xs space-y-1 border border-slate-100">
                                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">From: <span class="text-slate-700 font-bold">System</span></p>
                                    <p id="detailMessage" class="text-slate-600 whitespace-pre-line leading-relaxed pt-1">{{ $firstNotification->message }}</p>
                                </div>

                                <div id="detailActionWrapper">
                                    @if($firstNotification->action_url)
                                        <a id="detailActionBtn" href="{{ $firstNotification->action_url }}" class="flex items-center justify-center gap-2 w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-blue-600/20 transition">
                                            <span>{{ $firstNotification->action_label ?? 'View Details' }}</span>
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8 text-slate-400 text-xs">Select a notification to view details.</div>
                        @endif
                    </div>

                    <!-- CARD 2: Notification Statistics (2x2 Grid ដូចរូប Mockup) -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-3.5">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-800 pb-2 border-b border-slate-100">
                            <i class="fa-solid fa-chart-simple text-blue-600"></i> Notification Statistics
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <!-- Box 1: Total -->
                            <div class="p-3 rounded-xl bg-blue-50/60 border border-blue-100 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-semibold text-slate-600">Total Notifications</span>
                                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center text-[10px]">
                                        <i class="fa-solid fa-bell"></i>
                                    </div>
                                </div>
                                <div class="text-lg font-extrabold text-slate-900">{{ $totalCount }}</div>
                                <div class="text-[10px] text-emerald-600 font-semibold flex items-center gap-1">
                                    <i class="fa-solid fa-arrow-up"></i> 12% <span class="text-slate-400 font-normal">(vs. last month)</span>
                                </div>
                            </div>

                            <!-- Box 2: Unread -->
                            <div class="p-3 rounded-xl bg-emerald-50/60 border border-emerald-100 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-semibold text-slate-600">Unread</span>
                                    <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-[10px]">
                                        <i class="fa-solid fa-bell-slash"></i>
                                    </div>
                                </div>
                                <div class="text-lg font-extrabold text-slate-900">{{ $unreadCount }}</div>
                                <div class="text-[10px] text-rose-500 font-semibold flex items-center gap-1">
                                    <i class="fa-solid fa-arrow-down"></i> 30% <span class="text-slate-400 font-normal">(vs. last month)</span>
                                </div>
                            </div>

                            <!-- Box 3: System Alerts -->
                            <div class="p-3 rounded-xl bg-rose-50/60 border border-rose-100 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-semibold text-slate-600">System Alerts</span>
                                    <div class="w-6 h-6 rounded-lg bg-rose-600 text-white flex items-center justify-center text-[10px]">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                </div>
                                <div class="text-lg font-extrabold text-slate-900">{{ $systemAlertCount }}</div>
                                <div class="text-[10px] text-emerald-600 font-semibold flex items-center gap-1">
                                    <i class="fa-solid fa-arrow-up"></i> 20% <span class="text-slate-400 font-normal">(vs. last month)</span>
                                </div>
                            </div>

                            <!-- Box 4: Reminders -->
                            <div class="p-3 rounded-xl bg-amber-50/60 border border-amber-100 space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-semibold text-slate-600">Reminders</span>
                                    <div class="w-6 h-6 rounded-lg bg-amber-500 text-white flex items-center justify-center text-[10px]">
                                        <i class="fa-solid fa-clock"></i>
                                    </div>
                                </div>
                                <div class="text-lg font-extrabold text-slate-900">{{ $reminderCount }}</div>
                                <div class="text-[10px] text-emerald-600 font-semibold flex items-center gap-1">
                                    <i class="fa-solid fa-arrow-up"></i> 14% <span class="text-slate-400 font-normal">(vs. last month)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 3: Quick Actions ដូចរូប Mockup -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-3">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-800 pb-2 border-b border-slate-100">
                            <i class="fa-regular fa-comment-dots text-blue-600"></i> Quick Actions
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-[11px]">
                            <form action="{{ route('notifications.markAllRead') }}" method="POST" class="col-span-1">
                                @csrf
                                <button type="submit" class="w-full flex flex-col items-center justify-center p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition text-center gap-1 font-semibold text-slate-700">
                                    <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <span>Mark All as Read</span>
                                </button>
                            </form>

                            <a href="{{ route('settings') }}" class="flex flex-col items-center justify-center p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition text-center gap-1 font-semibold text-slate-700">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-gear"></i>
                                </div>
                                <span>Notification Settings</span>
                            </a>

                            <a href="{{ route('notifications', ['tab' => 'all']) }}" class="flex flex-col items-center justify-center p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition text-center gap-1 font-semibold text-slate-700">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-list-ul"></i>
                                </div>
                                <span>View All</span>
                            </a>
                        </div>
                    </div>

                    <!-- CARD 4: Real-time Update Banner ដូចរូប Mockup -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200/80 rounded-2xl p-4 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0 shadow-md shadow-blue-500/20">
                                <i class="fa-solid fa-bell text-sm"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 leading-tight">Never miss an important update!</h4>
                                <p class="text-[11px] text-slate-500 mt-0.5">Enable real-time notifications for a better experience.</p>
                            </div>
                        </div>
                        <a href="javascript:void(0)" onclick="alert('Real-time notifications are enabled!')" class="text-blue-600 hover:text-blue-800 text-sm pl-2">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                </div>

            </div>

        </main>
    </div>

</div>

{{-- ========================================================================= --}}
{{-- JAVASCRIPT: INTERACTIVE UX, AJAX & BACKEND CONNECTION                     --}}
{{-- ========================================================================= --}}
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ១. Function ចុចលើជួរសារ ដើម្បីទាញព័ត៌មានលម្អិតមកបង្ហាញលើ Card ខាងស្តាំតាម AJAX
    function selectNotification(id) {
        fetch(`/notifications/${id}/details`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(res => {
            if (res.success) {
                const data = res.data;
                // ផ្លាស់ប្តូរទិន្នន័យលើ DOM ភ្លាមៗដោយមិនបាច់ Reload ទំព័រ
                document.getElementById('detailTitle').textContent = data.title;
                document.getElementById('detailMessage').textContent = data.message;
                document.getElementById('detailTime').innerHTML = `<i class="fa-regular fa-clock mr-1"></i>${data.created_at}`;
                document.getElementById('detailBadge').textContent = data.category.replace('_', ' ').toUpperCase();
                
                // អាប់ដេតរូបតំណាង Icon
                const iconEl = document.getElementById('detailIcon');
                iconEl.innerHTML = `<i class="fa-solid ${data.icon} text-lg"></i>`;

                // អាប់ដេតប៊ូតុង Action
                const actionWrap = document.getElementById('detailActionWrapper');
                if (data.action_url) {
                    actionWrap.innerHTML = `
                        <a href="${data.action_url}" class="flex items-center justify-center gap-2 w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-blue-600/20 transition">
                            <span>${data.action_label || 'View Details'}</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    `;
                } else {
                    actionWrap.innerHTML = '';
                }

                // ដោះពន្លឺខៀវចេញពីជួរសារ (Marked as read UI)
                const row = document.getElementById(`notif-row-${id}`);
                if (row) {
                    row.classList.remove('bg-blue-50/40', 'border-blue-200');
                    row.classList.add('bg-white', 'border-slate-200/80');
                    const unreadDot = row.querySelector('.bg-blue-600.rounded-full');
                    if (unreadDot) unreadDot.remove();
                }
            }
        })
        .catch(err => console.error('Error loading notification details:', err));
    }

    // ២. Function កំណត់សារមួយថាអានរួចតាម Action Dropdown
    function markSingleRead(id) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    // ៣. Function លុបសារមួយ
    function deleteNotification(id) {
        if (!confirm('Are you sure you want to delete this notification?')) return;

        fetch(`/notifications/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById(`notif-row-${id}`);
                if (row) row.remove();
            }
        });
    }

    // ៤. គ្រប់គ្រង Checkbox ច្រើន (Bulk Action Toolbar)
    function updateBulkCount() {
        const checked = document.querySelectorAll('.item-checkbox:checked');
        const bar = document.getElementById('bulkActionBar');
        const countSpan = document.getElementById('selectedCount');
        
        if (checked.length > 0) {
            bar.classList.remove('hidden');
            bar.classList.add('flex');
            countSpan.textContent = checked.length;
        } else {
            bar.classList.add('hidden');
            bar.classList.remove('flex');
        }
    }

    // ៥. ដំណើរការ Bulk Action (Mark read ឬ Delete ច្រើន)
    function handleBulkAction(action) {
        const checked = document.querySelectorAll('.item-checkbox:checked');
        const ids = Array.from(checked).map(cb => cb.value);

        if (ids.length === 0) return;

        fetch('/notifications/bulk-action', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ids: ids, action: action })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    // ៦. បិទបើក Dropdown បីគ្រាប់ (Three dots menu)
    function toggleDropdown(id) {
        const el = document.getElementById(`dropdown-${id}`);
        document.querySelectorAll('[id^="dropdown-"]').forEach(d => {
            if (d !== el) d.classList.add('hidden');
        });
        el.classList.toggle('hidden');
    }

    // បិទ Dropdown ពេល Click នៅកន្លែងផ្សេង
    window.addEventListener('click', () => {
        document.querySelectorAll('[id^="dropdown-"]').forEach(d => d.classList.add('hidden'));
    });
</script>

</body>
</html>
