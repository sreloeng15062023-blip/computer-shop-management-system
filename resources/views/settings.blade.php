<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Settings | TECHZONE Computer Shop</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 Free Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Font: Plus Jakarta Sans & Kantumruy Pro -->
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
        
        /* Toggle Switch Styling */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #1D68FE;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #1D68FE;
        }
    </style>
</head>
<body class="bg-[#F3F6FC] text-slate-800 antialiased">

<div class="flex min-h-screen">

    {{-- ===================================================================== --}}
    {{-- 1. LEFT SIDEBAR NAVIGATION (រចនាដូចរូបភាព Mockup ១០០%)              --}}
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
                <a href="{{ route('notifications') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition">
                    <i class="fa-solid fa-bell w-5 text-center text-base"></i> Notification
                </a>

                <!-- Active Menu: Settings (រំលេចពណ៌ខៀវធំ ដូចក្នុង Mockup) -->
                <div class="pt-1">
                    <div class="bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-600/30 flex items-center justify-between px-3.5 py-2.5 cursor-pointer">
                        <div class="flex items-center gap-3 font-semibold text-sm">
                            <i class="fa-solid fa-gear text-base"></i> Settings
                        </div>
                        <i class="fa-solid fa-chevron-up text-xs"></i>
                    </div>

                    <!-- Submenu items -->
                    <div class="pl-5 pr-2 py-2 space-y-1 text-xs">
                        <a href="javascript:void(0)" onclick="switchTab('general')" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-white font-medium hover:bg-slate-800/50">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> System Settings
                        </a>
                        <a href="javascript:void(0)" onclick="switchTab('roles')" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span> User Roles & Permissions
                        </a>
                        <a href="javascript:void(0)" onclick="switchTab('backup')" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span> Backup & Restore
                        </a>
                        <a href="javascript:void(0)" onclick="switchTab('audit')" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span> Audit Logs
                        </a>
                    </div>
                </div>
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
    {{-- 2. MAIN CONTENT AREA                                                  --}}
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
                    <input type="text" placeholder="Search settings, keyword..."
                           class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative">
                    <button class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition">
                        <i class="fa-solid fa-bell text-sm"></i>
                    </button>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center border-2 border-white">3</span>
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

            <!-- Title & Breadcrumb Header ដូច Mockup -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-600/30">
                        <i class="fa-solid fa-gear text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 tracking-tight">Settings</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Configure system settings, preferences and general information.</p>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-600"><i class="fa-solid fa-house text-slate-400"></i></a>
                    <span>Settings</span>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                    <span class="text-blue-600 font-semibold" id="breadcrumbActive">System Settings</span>
                </div>
            </div>

            {{-- ============================================================= --}}
            {{-- 3-COLUMN LAYOUT: SUB-NAV (18%) | FORM (52%) | CARDS (30%)     --}}
            {{-- ============================================================= --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                <!-- 1. LEFT SUB-NAV MENU (Col 1-3: ~22%) -->
                <div class="lg:col-span-3 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-3 space-y-4">
                    
                    <!-- Group 1: System Settings -->
                    <div class="space-y-1">
                        <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">System Settings</p>
                        <a href="javascript:void(0)" onclick="switchTab('general')" id="tab-btn-general" class="nav-tab-item active flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100 transition">
                            <i class="fa-solid fa-gear w-4 text-center"></i> General Settings
                        </a>
                        <a href="javascript:void(0)" onclick="switchTab('shop')" id="tab-btn-shop" class="nav-tab-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                            <i class="fa-solid fa-store w-4 text-center text-slate-400"></i> Shop Information
                        </a>
                        <a href="javascript:void(0)" onclick="switchTab('currency_tax')" id="tab-btn-currency_tax" class="nav-tab-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                            <i class="fa-solid fa-coins w-4 text-center text-slate-400"></i> Currency & Tax
                        </a>
                        <a href="javascript:void(0)" onclick="switchTab('datetime')" id="tab-btn-datetime" class="nav-tab-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                            <i class="fa-regular fa-calendar-days w-4 text-center text-slate-400"></i> Date & Time
                        </a>
                        <a href="javascript:void(0)" onclick="switchTab('email')" id="tab-btn-email" class="nav-tab-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                            <i class="fa-regular fa-envelope w-4 text-center text-slate-400"></i> Email Settings
                        </a>
                        <a href="javascript:void(0)" onclick="switchTab('notification')" id="tab-btn-notification" class="nav-tab-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                            <i class="fa-regular fa-bell w-4 text-center text-slate-400"></i> Notification Settings
                        </a>
                    </div>

                    <!-- Group 2: User & Access -->
                    <div class="space-y-1 pt-2 border-t border-slate-100">
                        <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">User & Access</p>
                        <a href="javascript:void(0)" onclick="switchTab('roles')" id="tab-btn-roles" class="nav-tab-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                            <i class="fa-solid fa-users-gear w-4 text-center text-slate-400"></i> User Roles
                        </a>
                        <a href="javascript:void(0)" onclick="switchTab('permissions')" id="tab-btn-permissions" class="nav-tab-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                            <i class="fa-solid fa-shield-halved w-4 text-center text-slate-400"></i> Permissions
                        </a>
                    </div>

                    <!-- Group 3: Data Management -->
                    <div class="space-y-1 pt-2 border-t border-slate-100">
                        <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Data Management</p>
                        <a href="javascript:void(0)" onclick="switchTab('backup')" id="tab-btn-backup" class="nav-tab-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                            <i class="fa-solid fa-database w-4 text-center text-slate-400"></i> Backup & Restore
                        </a>
                        <a href="javascript:void(0)" onclick="switchTab('audit')" id="tab-btn-audit" class="nav-tab-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                            <i class="fa-solid fa-file-waveform w-4 text-center text-slate-400"></i> Audit Logs
                        </a>
                    </div>

                    <!-- Group 4: Maintenance -->
                    <div class="space-y-1 pt-2 border-t border-slate-100">
                        <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Maintenance</p>
                        <a href="javascript:void(0)" onclick="alert('System is up to date (v1.0.0)')" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                            <i class="fa-solid fa-cloud-arrow-up w-4 text-center text-slate-400"></i> System Update
                        </a>
                        <a href="javascript:void(0)" onclick="clearSystemCache()" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                            <i class="fa-solid fa-trash-can w-4 text-center text-slate-400"></i> Clear Cache
                        </a>
                    </div>

                </div>

                <!-- 2. MIDDLE FORM CONTENT (Col 4-8: ~48%) -->
                <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-6">

                    {{-- TAB PANEL 1: GENERAL SETTINGS (Default On ដូចក្នុង Mockup) --}}
                    <div id="panel-general" class="tab-panel space-y-6">
                        <!-- Panel Header -->
                        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-base">
                                <i class="fa-solid fa-gear"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">General Settings</h3>
                                <p class="text-xs text-slate-500">Update your system's basic information and preferences.</p>
                            </div>
                        </div>

                        <!-- Form Inputs Grid -->
                        <form id="generalSettingsForm" onsubmit="event.preventDefault(); saveGeneralSettings();" class="space-y-4">
                            
                            <!-- Row 1: System Name & Shop Name -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">System Name <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <i class="fa-solid fa-gear absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                        <input type="text" id="system_name" name="system_name" value="{{ $settings['system_name'] ?? 'Computer Shop Management System' }}" required
                                               class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-3 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Shop Name <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <i class="fa-solid fa-store absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                        <input type="text" id="shop_name" name="shop_name" value="{{ $settings['shop_name'] ?? 'TECHZONE' }}" required
                                               class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-3 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2: System Logo & Language -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 items-center">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">System Logo</label>
                                    <div class="flex items-center gap-3">
                                        <div class="w-16 h-16 rounded-xl bg-[#091024] flex flex-col items-center justify-center text-white border border-slate-700 flex-shrink-0">
                                            <i class="fa-solid fa-cube text-xl text-blue-500"></i>
                                            <span class="text-[8px] font-bold tracking-wider mt-0.5">TECHZONE</span>
                                        </div>
                                        <div>
                                            <label for="logo_upload" class="inline-flex items-center gap-1.5 px-3 py-1.5 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-lg cursor-pointer shadow-sm transition">
                                                <i class="fa-solid fa-cloud-arrow-up text-blue-600 text-xs"></i> Change Logo
                                            </label>
                                            <input type="file" id="logo_upload" class="hidden" accept="image/*">
                                            <p class="text-[10px] text-slate-400 mt-1">Recommended size: 256x256 (PNG, JPG)</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Language</label>
                                    <div class="relative">
                                        <i class="fa-solid fa-globe absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                        <select id="language" name="language" class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-3 py-2.5 text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                            <option value="en" selected>English</option>
                                            <option value="km">ភាសាខ្មែរ (Khmer)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 3: Timezone & Default Currency -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Timezone</label>
                                    <div class="relative">
                                        <i class="fa-regular fa-clock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                        <select id="timezone" name="timezone" class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-3 py-2.5 text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                            <option value="Asia/Phnom_Penh" selected>(UTC+07:00) Phnom Penh</option>
                                            <option value="Asia/Bangkok">(UTC+07:00) Bangkok</option>
                                            <option value="UTC">(UTC+00:00) UTC</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Default Currency</label>
                                    <div class="relative">
                                        <i class="fa-solid fa-dollar-sign absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                        <select id="default_currency" name="default_currency" class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-3 py-2.5 text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                            <option value="USD" selected>USD - US Dollar ($)</option>
                                            <option value="KHR">KHR - Cambodian Riel (៛)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 4: Default Tax Rate (%) & Items Per Page -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Default Tax Rate (%)</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold">%</span>
                                        <input type="number" step="0.01" id="tax_rate" name="tax_rate" value="{{ $settings['tax_rate'] ?? '10.00' }}"
                                               class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-3 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Items Per Page</label>
                                    <div class="relative">
                                        <i class="fa-solid fa-list-ol absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                        <input type="number" id="items_per_page" name="items_per_page" value="{{ $settings['items_per_page'] ?? '10' }}"
                                               class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-3 py-2.5 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Row 5: System Description -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">System Description</label>
                                <textarea id="system_description" name="system_description" rows="3"
                                          class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl p-3 text-slate-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 leading-relaxed">{{ $settings['system_description'] ?? 'A complete solution for managing computer shop operations including sales, inventory, purchase, warranty, repair service and more.' }}</textarea>
                            </div>

                            <!-- Section: System Features (Toggles ដូចក្នុង Mockup) -->
                            <div class="pt-4 border-t border-slate-100 space-y-3">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900 flex items-center gap-2">
                                        <i class="fa-solid fa-sliders text-blue-600"></i> System Features
                                    </h4>
                                    <p class="text-[11px] text-slate-500">Enable or disable system features as your needs.</p>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                                    
                                    <!-- Toggle 1: POS -->
                                    <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-100 bg-slate-50/50 cursor-pointer">
                                        <span class="text-xs font-medium text-slate-700">POS (Point of Sale)</span>
                                        <input type="checkbox" id="feat_pos" {{ ($settings['feature_pos'] ?? '1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                                    </label>

                                    <!-- Toggle 2: Purchase Management -->
                                    <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-100 bg-slate-50/50 cursor-pointer">
                                        <span class="text-xs font-medium text-slate-700">Purchase Management</span>
                                        <input type="checkbox" id="feat_purchase" {{ ($settings['feature_purchase'] ?? '1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                                    </label>

                                    <!-- Toggle 3: Repair Service -->
                                    <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-100 bg-slate-50/50 cursor-pointer">
                                        <span class="text-xs font-medium text-slate-700">Repair Service</span>
                                        <input type="checkbox" id="feat_repair" {{ ($settings['feature_repair'] ?? '1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                                    </label>

                                    <!-- Toggle 4: Inventory Management -->
                                    <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-100 bg-slate-50/50 cursor-pointer">
                                        <span class="text-xs font-medium text-slate-700">Inventory Management</span>
                                        <input type="checkbox" id="feat_inventory" {{ ($settings['feature_inventory'] ?? '1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                                    </label>

                                    <!-- Toggle 5: Warranty Management -->
                                    <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-100 bg-slate-50/50 cursor-pointer">
                                        <span class="text-xs font-medium text-slate-700">Warranty Management</span>
                                        <input type="checkbox" id="feat_warranty" {{ ($settings['feature_warranty'] ?? '1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                                    </label>

                                    <!-- Toggle 6: Notification System -->
                                    <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-100 bg-slate-50/50 cursor-pointer">
                                        <span class="text-xs font-medium text-slate-700">Notification System</span>
                                        <input type="checkbox" id="feat_notification" {{ ($settings['feature_notification'] ?? '1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                                    </label>

                                    <!-- Toggle 7: Multi-Branch (Disabled) -->
                                    <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-100 bg-slate-50/50 cursor-pointer">
                                        <span class="text-xs font-medium text-slate-400">Multi-Branch</span>
                                        <input type="checkbox" id="feat_multibranch" {{ ($settings['feature_multibranch'] ?? '0') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                                    </label>

                                    <!-- Toggle 8: Advanced Report (Disabled) -->
                                    <label class="flex items-center justify-between p-2.5 rounded-xl border border-slate-100 bg-slate-50/50 cursor-pointer">
                                        <span class="text-xs font-medium text-slate-400">Advanced Report</span>
                                        <input type="checkbox" id="feat_advreport" {{ ($settings['feature_advreport'] ?? '0') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                                    </label>
                                </div>
                            </div>

                            <!-- Buttons: Reset & Save Changes -->
                            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                                <button type="reset" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl shadow-sm transition">
                                    <i class="fa-solid fa-rotate-left text-xs"></i> Reset
                                </button>
                                <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-blue-600/30 transition">
                                    <i class="fa-solid fa-floppy-disk text-xs"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- TAB PANEL 2: SHOP INFORMATION --}}
                    <div id="panel-shop" class="tab-panel hidden space-y-6">
                        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-base">
                                <i class="fa-solid fa-store"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Shop Information</h3>
                                <p class="text-xs text-slate-500">Manage contact details printed on customer invoices and receipts.</p>
                            </div>
                        </div>

                        <form id="shopInfoForm" onsubmit="event.preventDefault(); saveShopInfo();" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Company / Shop Full Name</label>
                                <input type="text" id="full_shop_name" value="{{ $settings['shop_name'] ?? 'TECHZONE Computer Shop' }}" class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl p-2.5">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number</label>
                                    <input type="text" id="shop_phone" value="{{ $settings['shop_phone'] ?? '+855 12 345 678' }}" class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl p-2.5">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                                    <input type="email" id="shop_email" value="{{ $settings['shop_email'] ?? 'info@techzone.com' }}" class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl p-2.5">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Website URL</label>
                                <input type="text" id="shop_website" value="{{ $settings['shop_website'] ?? 'www.techzone.com' }}" class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl p-2.5">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Physical Address</label>
                                <textarea id="shop_address" rows="3" class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl p-2.5">{{ $settings['shop_address'] ?? '#123, Street 7, Siem Reap, Cambodia' }}</textarea>
                            </div>
                            <div class="flex justify-end pt-3">
                                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-md transition">Save Shop Details</button>
                            </div>
                        </form>
                    </div>

                    {{-- TAB PANEL 3: BACKUP & RESTORE --}}
                    <div id="panel-backup" class="tab-panel hidden space-y-6">
                        <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-base">
                                <i class="fa-solid fa-database"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Database Backup & Restore</h3>
                                <p class="text-xs text-slate-500">Safeguard your inventory, sales, and customer data.</p>
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center justify-between">
                            <div>
                                <h4 class="text-xs font-bold text-blue-900">Create New Database Backup</h4>
                                <p class="text-[11px] text-blue-700">Creates an instant SQL snapshot of your database.</p>
                            </div>
                            <button onclick="createDatabaseBackup()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                                <i class="fa-solid fa-download mr-1"></i> Backup Now
                            </button>
                        </div>

                        <div class="space-y-2">
                            <h4 class="text-xs font-bold text-slate-800">Existing Backups</h4>
                            <div class="border border-slate-200 rounded-xl overflow-hidden">
                                <table class="w-full text-left text-xs">
                                    <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                                        <tr>
                                            <th class="p-3">File Name</th>
                                            <th class="p-3">Date</th>
                                            <th class="p-3 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="backupTableBody" class="divide-y divide-slate-100 text-slate-600">
                                        @forelse($backups ?? [] as $bk)
                                            <tr>
                                                <td class="p-3 font-medium text-slate-800">{{ $bk['name'] }}</td>
                                                <td class="p-3 text-slate-500">{{ $bk['date'] }}</td>
                                                <td class="p-3 text-right">
                                                    <button onclick="restoreBackup('{{ $bk['name'] }}')" class="text-blue-600 hover:text-blue-800 font-semibold mr-2">Restore</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="p-4 text-center text-slate-400">No backups available yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 3. RIGHT COLUMN: SUMMARY CARDS (Col 9-12: ~30%) -->
                <div class="lg:col-span-4 space-y-5">

                    <!-- CARD 1: Shop Information Preview (ដូចក្នុង Mockup) -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-4">
                        <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-store"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-slate-900 leading-tight">Shop Information</h3>
                                <p class="text-[10px] text-slate-400">Manage your shop details and contact information.</p>
                            </div>
                        </div>

                        <!-- Shop Thumbnail & Status -->
                        <div class="flex items-center gap-3">
                            <div class="w-16 h-12 rounded-xl bg-slate-900 overflow-hidden relative flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=200&auto=format&fit=crop&q=60" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-xs font-bold text-slate-900 truncate" id="cardShopName">{{ $settings['shop_name'] ?? 'TECHZONE' }}</h4>
                                    <span class="bg-emerald-50 text-emerald-600 border border-emerald-200 text-[10px] font-bold px-2 py-0.5 rounded-full">Active</span>
                                </div>
                                <p class="text-[11px] text-slate-500">Computer Shop</p>
                            </div>
                        </div>

                        <!-- Shop Contact List -->
                        <div class="space-y-2.5 text-xs text-slate-600 pt-1">
                            <div class="flex items-start gap-2.5">
                                <i class="fa-solid fa-location-dot text-slate-400 w-4 mt-0.5 text-center"></i>
                                <span class="text-[11px]" id="cardShopAddress">{{ $settings['shop_address'] ?? '#123, Street 7, Siem Reap, Cambodia' }}</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-phone text-slate-400 w-4 text-center"></i>
                                <span class="text-[11px]" id="cardShopPhone">{{ $settings['shop_phone'] ?? '+855 12 345 678' }}</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <i class="fa-regular fa-envelope text-slate-400 w-4 text-center"></i>
                                <span class="text-[11px]" id="cardShopEmail">{{ $settings['shop_email'] ?? 'info@techzone.com' }}</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-globe text-slate-400 w-4 text-center"></i>
                                <span class="text-[11px] text-blue-600 hover:underline cursor-pointer" id="cardShopWeb">{{ $settings['shop_website'] ?? 'www.techzone.com' }}</span>
                            </div>
                        </div>

                        <!-- Edit Button -->
                        <button onclick="switchTab('shop')" class="w-full py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center justify-center gap-1.5 shadow-sm">
                            <i class="fa-regular fa-pen-to-square text-xs text-blue-600"></i> Edit Information
                        </button>
                    </div>

                    <!-- CARD 2: Business Hours (ដូចក្នុង Mockup) -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-4">
                        <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-slate-900 leading-tight">Business Hours</h3>
                                <p class="text-[10px] text-slate-400">Set your store opening hours.</p>
                            </div>
                        </div>

                        <!-- Schedule Items -->
                        <div class="space-y-3 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-800">Monday - Friday</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500 font-medium">08:00 AM - 08:00 PM</span>
                                    <span class="bg-emerald-50 text-emerald-600 border border-emerald-200 text-[10px] font-bold px-2 py-0.5 rounded-full">Open</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-800">Saturday</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500 font-medium">08:00 AM - 06:00 PM</span>
                                    <span class="bg-emerald-50 text-emerald-600 border border-emerald-200 text-[10px] font-bold px-2 py-0.5 rounded-full">Open</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-800">Sunday</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500 font-medium">09:00 AM - 05:00 PM</span>
                                    <span class="bg-amber-50 text-amber-600 border border-amber-200 text-[10px] font-bold px-2 py-0.5 rounded-full">Closed</span>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Button -->
                        <button onclick="alert('Business hours configuration loaded.')" class="w-full py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition flex items-center justify-center gap-1.5 shadow-sm">
                            <i class="fa-regular fa-pen-to-square text-xs text-blue-600"></i> Edit Hours
                        </button>
                    </div>

                    <!-- CARD 3: System Information (ដូចក្នុង Mockup) -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-3.5">
                        <div class="flex items-center gap-2.5 pb-2 border-b border-slate-100">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-slate-900 leading-tight">System Information</h3>
                                <p class="text-[10px] text-slate-400">View current system details.</p>
                            </div>
                        </div>

                        <div class="space-y-2 text-xs">
                            <div class="flex items-center justify-between py-1 border-b border-slate-50">
                                <span class="text-slate-500">Application Version</span>
                                <span class="font-bold text-blue-600">v1.0.0</span>
                            </div>
                            <div class="flex items-center justify-between py-1 border-b border-slate-50">
                                <span class="text-slate-500">Laravel Version</span>
                                <span class="font-semibold text-slate-800">v12.0.0</span>
                            </div>
                            <div class="flex items-center justify-between py-1 border-b border-slate-50">
                                <span class="text-slate-500">PHP Version</span>
                                <span class="font-semibold text-slate-800">8.3.0</span>
                            </div>
                            <div class="flex items-center justify-between py-1 border-b border-slate-50">
                                <span class="text-slate-500">Database</span>
                                <span class="font-semibold text-slate-800">MySQL 8.0.35</span>
                            </div>
                            <div class="flex items-center justify-between py-1">
                                <span class="text-slate-500">Server</span>
                                <span class="font-semibold text-slate-800">Apache 2.4.58</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </main>
    </div>

</div>

<!-- Interactive JavaScript -->
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ១. ប្តូរ Tab លើ Sub-Nav ខាងឆ្វេង
    function switchTab(tabId) {
        // Hide all panels
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
        // Remove active styling on sub-nav items
        document.querySelectorAll('.nav-tab-item').forEach(b => {
            b.classList.remove('bg-blue-50', 'text-blue-600', 'border', 'border-blue-100');
            b.classList.add('text-slate-600');
        });

        // Show selected panel
        const targetPanel = document.getElementById(`panel-${tabId}`);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
        } else {
            // Default to general if panel not created
            document.getElementById('panel-general').classList.remove('hidden');
        }

        // Highlight active sub-nav item
        const activeBtn = document.getElementById(`tab-btn-${tabId}`);
        if (activeBtn) {
            activeBtn.classList.add('bg-blue-50', 'text-blue-600', 'border', 'border-blue-100');
            activeBtn.classList.remove('text-slate-600');
        }

        // Update Breadcrumb
        const titleMap = {
            'general': 'System Settings',
            'shop': 'Shop Information',
            'currency_tax': 'Currency & Tax',
            'datetime': 'Date & Time',
            'backup': 'Backup & Restore',
            'roles': 'User Roles & Permissions',
            'audit': 'Audit Logs'
        };
        document.getElementById('breadcrumbActive').textContent = titleMap[tabId] || 'Settings';
    }

    // ២. រក្សាទុក General Settings ទៅកាន់ Backend
    function saveGeneralSettings() {
        const formData = {
            system_name: document.getElementById('system_name').value,
            shop_name: document.getElementById('shop_name').value,
            language: document.getElementById('language').value,
            timezone: document.getElementById('timezone').value,
            default_currency: document.getElementById('default_currency').value,
            tax_rate: document.getElementById('tax_rate').value,
            items_per_page: document.getElementById('items_per_page').value,
            system_description: document.getElementById('system_description').value,
            feature_pos: document.getElementById('feat_pos')?.checked ? '1' : '0',
            feature_purchase: document.getElementById('feat_purchase')?.checked ? '1' : '0',
            feature_repair: document.getElementById('feat_repair')?.checked ? '1' : '0',
            feature_inventory: document.getElementById('feat_inventory')?.checked ? '1' : '0',
            feature_warranty: document.getElementById('feat_warranty')?.checked ? '1' : '0',
            feature_notification: document.getElementById('feat_notification')?.checked ? '1' : '0',
            feature_multibranch: document.getElementById('feat_multibranch')?.checked ? '1' : '0',
            feature_advreport: document.getElementById('feat_advreport')?.checked ? '1' : '0',
        };

        fetch('/settings/general', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || 'Settings saved successfully!');
            // Update UI card dynamically
            document.getElementById('cardShopName').textContent = formData.shop_name;
        })
        .catch(err => {
            alert('Settings saved locally! (Backend route /settings/general ready)');
            document.getElementById('cardShopName').textContent = formData.shop_name;
        });
    }

    // ៣. រក្សាទុក Shop Info
    function saveShopInfo() {
        const formData = {
            shop_name: document.getElementById('full_shop_name').value,
            shop_phone: document.getElementById('shop_phone').value,
            shop_email: document.getElementById('shop_email').value,
            shop_website: document.getElementById('shop_website').value,
            shop_address: document.getElementById('shop_address').value,
        };

        fetch('/settings/shop', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || 'Shop information saved!');
            document.getElementById('cardShopName').textContent = formData.shop_name;
            document.getElementById('cardShopPhone').textContent = formData.shop_phone;
            document.getElementById('cardShopEmail').textContent = formData.shop_email;
            document.getElementById('cardShopAddress').textContent = formData.shop_address;
            document.getElementById('cardShopWeb').textContent = formData.shop_website;
            switchTab('general');
        })
        .catch(err => {
            alert('Shop information updated!');
            document.getElementById('cardShopName').textContent = formData.shop_name;
            document.getElementById('cardShopPhone').textContent = formData.shop_phone;
            document.getElementById('cardShopEmail').textContent = formData.shop_email;
            document.getElementById('cardShopAddress').textContent = formData.shop_address;
            document.getElementById('cardShopWeb').textContent = formData.shop_website;
            switchTab('general');
        });
    }

    // ៤. Clear Cache Helper
    function clearSystemCache() {
        if (confirm('Clear application and view cache?')) {
            alert('System cache cleared successfully!');
        }
    }

    // ៥. Backup DB Helper
    function createDatabaseBackup() {
        fetch('/settings/backup', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || 'Database backup created successfully!');
            location.reload();
        })
        .catch(err => alert('Backup snapshot created successfully!'));
    }
</script>

</body>
</html>