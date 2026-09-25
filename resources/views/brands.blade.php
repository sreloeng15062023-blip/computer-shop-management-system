<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Management - TECHZONE</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

    <div class="flex h-screen overflow-hidden">

        <!-- ========================================================================= -->
        <!-- 1. SIDEBAR (TECHZONE Theme) & DYNAMIC ROUTING NAVIGATION                  -->
        <!-- ========================================================================= -->
        <!--
            ចំណុចភ្ជាប់ Backend:
            - `route('name')`: បង្កើត URL ស្វ័យប្រវត្តិតាមឈ្មោះ Route ក្នុង `routes/web.php`
            - `request()->routeIs('...')`: ពិនិត្យមើល Route បច្ចុប្បន្ន ដើម្បីបន្ថែម Active Style លើ Menu
        -->
        <aside class="w-64 bg-[#0f172a] text-slate-300 flex flex-col justify-between shrink-0 shadow-xl overflow-y-auto">
            <div>
                <!-- Logo -->
                <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-800/80">
                    <div class="bg-blue-600 w-10 h-10 rounded-xl text-white flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <i class="fa-solid fa-desktop text-lg"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-lg text-white tracking-wider leading-none">TECHZONE</div>
                        <div class="text-[10px] text-slate-400 mt-1">Computer Shop Management</div>
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

                    <!-- Active Brand Management (Route ទៅកាន់ BrandController@index) -->
                    <a href="{{ route('brands.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition bg-blue-600 text-white font-semibold shadow-md shadow-blue-600/30">
                        <i class="fa-solid fa-tags w-5 text-center"></i> Brand Management
                    </a>

                    <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
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
                    </a>

                    <a href="{{ route('settings') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition text-slate-400 hover:bg-slate-800 hover:text-white">
                        <i class="fa-solid fa-gear w-5 text-center"></i> Settings
                    </a>
                </nav>
            </div>
        </aside>

        <!-- ========================================================================= -->
        <!-- 2. MAIN CONTENT AREA                                                      -->
        <!-- ========================================================================= -->
        <main class="flex-1 flex flex-col overflow-y-auto bg-slate-50">

            <!-- Top Header Navbar (បង្ហាញ Auth User ពី Laravel Authentication) -->
            <header class="bg-white border-b border-slate-200 px-8 py-3.5 flex items-center justify-between sticky top-0 z-20 shadow-xs">
                <!-- Global Quick Search (Frontend Search Input) -->
                <div class="w-80 relative">
                    <input type="text" placeholder="Search..." class="w-full pl-10 pr-4 py-2 bg-slate-100/80 border border-transparent rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-sm"></i>
                </div>

                <!-- Top Icons & User Profile -->
                <!--
                    ចំណុចភ្ជាប់ Backend:
                    - `Auth::user()->name`: ទាញយកឈ្មោះអ្នកប្រើប្រាស់ដែលបាន Login ចូលប្រព័ន្ធ
                    - `Auth::user()->role->role_name`: ទាញយក Role តាមរយៈ Relationship ក្នុង Eloquent User Model
                -->
                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-xl transition">
                        <i class="fa-solid fa-bell text-lg"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
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
            <div class="p-8 max-w-7xl mx-auto w-full space-y-6">

                <!-- ========================================================================= -->
                <!-- FLASH MESSAGES & VALIDATION ALERTS                                        -->
                <!-- ========================================================================= -->
                {{--
                    ចំណុចភ្ជាប់ Backend:
                    1. `session('success')`: ចាប់យក Flash Message ជោគជ័យ ដែល Controller បញ្ជូនមកតាមរយៈ `->with('success', '...')`
                    2. `session('error')`: ចាប់យក Flash Message បរាជ័យ ដែល Controller បញ្ជូនមកតាមរយៈ `->with('error', '...')`
                    3. `$errors->any()`: ចាប់យក Error Messages ពេលដែល Form Validation ក្នុង `StoreBrandRequest` ឬ `UpdateBrandRequest` មិនត្រឹមត្រូវ
                --}}
                
                {{-- Success Flash Alert --}}
                @if (session('success'))
                    <div class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-xs">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif

                {{-- Error Flash Alert --}}
                @if (session('error'))
                    <div class="flex items-center justify-between p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-xs">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 text-sm"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif

                {{-- Validation Errors Alert --}}
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

                <!-- Brand Management Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-600/20">
                            <i class="fa-solid fa-tags text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Brand Management</h1>
                            <p class="text-sm text-slate-500">Manage your product brands</p>
                        </div>
                    </div>

                    <!-- + Add Brand Button (បើក Modal បង្កើត Brand ថ្មី - CREATE) -->
                    <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/20 hover:shadow-lg transition active:scale-95">
                        <i class="fa-solid fa-plus text-xs"></i> Add Brand
                    </button>
                </div>

                <!-- ========================================================================= -->
                <!-- FILTER & SEARCH FORM (ភ្ជាប់ទៅកាន់ BrandController@index - GET REQUEST)  -->
                <!-- ========================================================================= -->
                {{--
                    ចំណុចភ្ជាប់ Backend:
                    - `action="{{ route('brands.index') }}"`: ផ្ញើ GET Request ទៅកាន់ `BrandController@index`
                    - `name="search"`: តំណាងឱ្យ Query Parameter `search` សម្រាប់ស្វែងរក ($request->filled('search'))
                    - `value="{{ request('search') }}"`: រក្សាទុកពាក្យដែលបានស្វែងរកចុងក្រោយនៅលើ Input
                    - `name="status"`: តំណាងឱ្យ Query Parameter `status` សម្រាប់ Filter ($request->filled('status'))
                    - `request('status') === 'Active' ? 'selected' : ''`: រក្សាទុកជម្រើស Status ដែលបានជ្រើសរើស
                    - `<a href="{{ route('brands.index') }}">: ប៊ូតុង Reset សម្រាប់សម្អាត Filter ត្រឡប់ទៅមើលទិន្នន័យដើម
                --}}
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
                    <form method="GET" action="{{ route('brands.index') }}" class="flex flex-col md:flex-row items-center gap-4">
                        <!-- Search Box (ស្វែងរកឈ្មោះ Brand ឬ ប្រទេស) -->
                        <div class="flex-1 w-full relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search brand name..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
                        </div>

                        <!-- Status Filter (ចម្រោះតាម Active / Inactive) -->
                        <div class="w-full md:w-48">
                            <select name="status" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                                <option value="">All Status</option>
                                <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Reset Button -->
                        <a href="{{ route('brands.index') }}" class="w-full md:w-auto px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-medium flex items-center justify-center gap-2 transition">
                            <i class="fa-solid fa-rotate-left text-xs"></i> Reset
                        </a>
                    </form>
                </div>

                <!-- ========================================================================= -->
                <!-- BRANDS DATA TABLE (READ / RETRIEVE DATA ពី Database តាម Controller)      -->
                <!-- ========================================================================= -->
                {{--
                    ចំណុចភ្ជាប់ Backend:
                    - `$brands`: Pagination Object ដែលបាន Pass ចេញពី `BrandController@index` តាមរយៈ `view('brands', compact('brands'))`
                    - `@forelse ($brands as $index => $brand)`: Loop ទាញទិន្នន័យ Brand នីមួយៗមកបង្ហាញ (បើគ្មានទិន្នន័យ ចូលទៅ `@empty`)
                    - `$brands->firstItem() + $index`: គណនាលេខរៀងតាមលំដាប់ទំព័រ Pagination
                    - `$brand->brand_name`, `$brand->country`, `$brand->description`, `$brand->status`: ទាញទិន្នន័យពី Database columns
                    - `$brand->created_at->format('Y-m-d H:i')`: បង្ហាញកាលបរិច្ឆេទបង្កើត (Carbon format)
                    - `json_encode($brand)`: បម្លែង Model Data ទៅជា JSON string ដើម្បីបញ្ជូនទៅ JavaScript Modal Functions (View & Edit)
                --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/75 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    <th class="py-4 px-6 text-center w-16">#</th>
                                    <th class="py-4 px-6">Brand Name</th>
                                    <th class="py-4 px-6">Country</th>
                                    <th class="py-4 px-6">Description</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                    <th class="py-4 px-6">Created At</th>
                                    <th class="py-4 px-6 text-center w-36">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @forelse ($brands as $index => $brand)
                                    <tr class="hover:bg-slate-50/60 transition group">
                                        <!-- Row Number (គណនាលេខរៀង Pagination) -->
                                        <td class="py-4 px-6 text-center font-medium text-slate-400">
                                            {{ $brands->firstItem() + $index }}
                                        </td>

                                        <!-- Brand Name with Icon/Initial -->
                                        <td class="py-4 px-6 font-bold text-slate-900">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 font-extrabold flex items-center justify-center text-xs shadow-2xs">
                                                    {{ strtoupper(substr($brand->brand_name, 0, 2)) }}
                                                </div>
                                                <span>{{ $brand->brand_name }}</span>
                                            </div>
                                        </td>

                                        <!-- Country Column -->
                                        <td class="py-4 px-6 text-slate-600 font-medium">
                                            {{ $brand->country ?? '—' }}
                                        </td>

                                        <!-- Description Column -->
                                        <td class="py-4 px-6 text-slate-500 max-w-xs truncate" title="{{ $brand->description }}">
                                            {{ $brand->description ?? 'No description provided' }}
                                        </td>

                                        <!-- Status Badge Column -->
                                        <td class="py-4 px-6 text-center">
                                            @if ($brand->status === 'Active')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/60">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Created At Column -->
                                        <td class="py-4 px-6 text-slate-500 text-xs font-medium">
                                            {{ $brand->created_at ? $brand->created_at->format('Y-m-d H:i') : '—' }}
                                        </td>

                                        <!-- ========================================================= -->
                                        <!-- ACTION BUTTONS (VIEW, EDIT, DELETE)                       -->
                                        <!-- ========================================================= -->
                                        {{--
                                            1. View Button: បញ្ជូន Object `$brand` ជា JSON ទៅឱ្យ `openViewModal(brand)`
                                            2. Edit Button: បញ្ជូន Object `$brand` ជា JSON ទៅឱ្យ `openEditModal(brand)` ដើម្បីបំពេញទិន្នន័យលើ Form កែប្រែ
                                            3. Delete Button: បញ្ជូន `$brand->id` និង `$brand->brand_name` ទៅឱ្យ `openDeleteModal(id, name)` ដើម្បីកំណត់ Delete Form Action URL
                                        --}}
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <!-- View Button (READ Single Brand) -->
                                                <button onclick="openViewModal({{ json_encode($brand) }})" class="w-8 h-8 rounded-lg bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center transition shadow-2xs" title="View Details">
                                                    <i class="fa-solid fa-eye text-xs"></i>
                                                </button>

                                                <!-- Edit Button (UPDATE Single Brand) -->
                                                <button onclick="openEditModal({{ json_encode($brand) }})" class="w-8 h-8 rounded-lg bg-sky-500 hover:bg-sky-600 text-white flex items-center justify-center transition shadow-2xs" title="Edit Brand">
                                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                </button>

                                                <!-- Delete Button (DELETE Single Brand) -->
                                                <button onclick="openDeleteModal('{{ $brand->id }}', '{{ addslashes($brand->brand_name) }}')" class="w-8 h-8 rounded-lg bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center transition shadow-2xs" title="Delete Brand">
                                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- បង្ហាញនៅពេលគ្មានទិន្នន័យ Brand ក្នុង Database ឬ ស្វែងរកមិនឃើញ --}}
                                    <tr>
                                        <td colspan="7" class="py-12 text-center text-slate-400">
                                            <i class="fa-solid fa-tags text-4xl mb-3 block text-slate-300"></i>
                                            <p class="font-medium">រកមិនឃើញទិន្នន័យ Brand ឡើយ។</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- ========================================================================= -->
                    <!-- PAGINATION FOOTER (ភ្ជាប់ទៅកាន់ Laravel Paginator)                         -->
                    <!-- ========================================================================= -->
                    {{--
                        ចំណុចភ្ជាប់ Backend:
                        - `$brands->firstItem()`: លេខរៀងទិន្នន័យដំបូងក្នុងទំព័រនេះ
                        - `$brands->lastItem()`: លេខរៀងទិន្នន័យចុងក្រោយក្នុងទំព័រនេះ
                        - `$brands->total()`: ចំនួនទិន្នន័យសរុបទាំងអស់ក្នុង Table Brands
                        - `{{ $brands->links() }}`: បង្កើតប៊ូតុង Previous / Next និងលេខទំព័រដោយស្វ័យប្រវត្តិ ព្រមទាំងរក្សា query strings
                    --}}
                    <div class="px-6 py-4 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-slate-500">
                            Showing <span class="font-semibold text-slate-700">{{ $brands->firstItem() ?? 0 }}</span> to <span class="font-semibold text-slate-700">{{ $brands->lastItem() ?? 0 }}</span> of <span class="font-semibold text-slate-700">{{ $brands->total() }}</span> entries
                        </div>
                        <div>
                            {{ $brands->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- ========================================================================= -->
    <!-- 3. ADD BRAND MODAL & FORM (CREATE - POST REQUEST ទៅ BrandController@store)-->
    <!-- ========================================================================= -->
    {{--
        ចំណុចភ្ជាប់ Backend:
        - `action="{{ route('brands.store') }}"`: ផ្ញើ POST Request ទៅកាន់ Route `brands.store` -> `BrandController@store`
        - `@csrf`: Laravel CSRF Token ការពារសុវត្ថិភាពពីការក្លែងបន្លំ Request (ខ្វះវានឹង Error 419 Page Expired)
        - `name="brand_name"`: ផ្គូផ្គងជាមួយ Field `brand_name` ក្នុង Validation Rule នៃ `StoreBrandRequest` & Database Column
        - `name="country"`: ផ្គូផ្គងជាមួយ Field `country` ក្នុង Database Column
        - `name="description"`: ផ្គូផ្គងជាមួយ Field `description` ក្នុង Database Column
        - `name="status"`: ផ្គូផ្គងជាមួយ Field `status` (Active / Inactive) ក្នុង Database Column
    --}}
    <div id="addModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 leading-tight">Add New Brand</h3>
                        <p class="text-xs text-slate-500">Create a new brand for your products</p>
                    </div>
                </div>
                <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <!-- Form បញ្ចូលទិន្នន័យ (CREATE) -->
            <form method="POST" action="{{ route('brands.store') }}" class="p-6 space-y-4">
                @csrf
                <!-- Brand Name Input -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Brand Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="brand_name" required placeholder="Enter brand name" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>

                <!-- Country Input -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Country</label>
                    <input type="text" name="country" placeholder="Enter country (e.g. Taiwan, USA)" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>

                <!-- Description Input -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Description</label>
                    <textarea name="description" rows="3" placeholder="Enter description (optional)" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition"></textarea>
                </div>

                <!-- Status Select Input -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/20 transition">Save Brand</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 4. EDIT BRAND MODAL & FORM (UPDATE - PUT REQUEST ទៅ BrandController@update)-->
    <!-- ========================================================================= -->
    {{--
        ចំណុចភ្ជាប់ Backend:
        - `id="editForm"`: នឹងត្រូវបានកំណត់ Action URL តាមរយៈ JavaScript: `document.getElementById('editForm').action = '/brands/' + brand.id`
        - `@csrf`: Laravel CSRF Protection Token
        - `@method('PUT')`: Laravel Method Spoofing (ព្រោះ HTML Form មិន Support Method PUT ដោយផ្ទាល់)
        - Form នេះនឹងផ្ញើទៅកាន់ Route `brands.update` (`PUT /brands/{brand}`) -> `BrandController@update`
        - `id="edit_brand_name"`, `id="edit_country"`, `id="edit_description"`, `id="edit_status"`: ទទួលទិន្នន័យពី JavaScript ដើម្បីបង្ហាញលើ Form ពេលចុច Edit
    --}}
    <div id="editModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-xl shadow-2xl border border-slate-200 overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-sky-500 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 leading-tight">Edit Brand</h3>
                        <p class="text-xs text-slate-500">Update brand information</p>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <!-- Form កែប្រែទិន្នន័យ (UPDATE) -->
            <form id="editForm" method="POST" action="" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                
                <!-- Edit Brand Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Brand Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit_brand_name" name="brand_name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>

                <!-- Edit Country -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Country</label>
                    <input type="text" id="edit_country" name="country" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                </div>

                <!-- Edit Description -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Description</label>
                    <textarea id="edit_description" name="description" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition"></textarea>
                </div>

                <!-- Edit Status -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status</label>
                    <select id="edit_status" name="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:bg-white transition">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/20 transition">Update Brand</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 5. VIEW BRAND DETAILS MODAL (READ SINGLE BRAND DETAILS)                   -->
    <!-- ========================================================================= -->
    {{--
        ចំណុចភ្ជាប់ Backend:
        - មិនចាំបាច់ Reload ទំព័រថ្មីទេ ដោយសារទិន្នន័យ Brand ត្រូវបាន Pass ជា JSON ពី Table មកកាន់ `openViewModal(brand)`
        - JavaScript នឹងបំពេញទិន្នន័យចូលក្នុង Elements: `view_avatar`, `view_brand_name`, `view_country`, `view_description`, `view_created_at`, `view_status_badge`
    --}}
    <div id="viewModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-xl shadow-2xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center text-sm shadow-sm">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <h3 class="font-bold text-slate-900">Brand Details</h3>
                </div>
                <button onclick="closeViewModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>

            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-200/60">
                    <div class="flex items-center gap-3">
                        <div id="view_avatar" class="w-12 h-12 rounded-xl bg-blue-600 text-white font-extrabold text-lg flex items-center justify-center shadow-sm">
                            B
                        </div>
                        <div>
                            <div id="view_brand_name" class="font-bold text-lg text-slate-900">ASUS</div>
                            <div id="view_country" class="text-xs text-slate-500">Taiwan</div>
                        </div>
                    </div>
                    <div id="view_status_badge">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                    </div>
                </div>

                <div class="space-y-2 text-sm">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Description</span>
                        <p id="view_description" class="text-slate-700 bg-slate-50/50 p-3 rounded-xl border border-slate-100 mt-1">No description provided.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Created At</span>
                            <span id="view_created_at" class="text-slate-700 font-medium">—</span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Created By</span>
                            <span class="text-slate-700 font-medium">Administrator</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-200 flex justify-end">
                    <button onclick="closeViewModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition">Back to List</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 6. DELETE CONFIRMATION MODAL & FORM (DELETE - DELETE REQUEST ទៅ Controller)-->
    <!-- ========================================================================= -->
    {{--
        ចំណុចភ្ជាប់ Backend:
        - `id="deleteForm"`: នឹងត្រូវបានកំណត់ Action URL តាមរយៈ JavaScript: `document.getElementById('deleteForm').action = '/brands/' + id`
        - `@csrf`: Laravel CSRF Protection Token
        - `@method('DELETE')`: Laravel Method Spoofing ដើម្បីឱ្យ Laravel Router ស្គាល់ថាជា DELETE Request
        - Form នេះនឹងផ្ញើទៅកាន់ Route `brands.destroy` (`DELETE /brands/{brand}`) -> `BrandController@destroy`
    --}}
    <div id="deleteModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl border border-slate-200 overflow-hidden text-center p-6">
            <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Delete Brand</h3>
            <p class="text-sm text-slate-500 mt-1">
                Are you sure you want to delete this brand?<br>
                "<span id="del_brand_name" class="font-bold text-slate-800"></span>"<br>
                <span class="text-xs text-rose-500 font-medium">This action cannot be undone.</span>
            </p>

            <!-- Form លុបទិន្នន័យ (DELETE) -->
            <form id="deleteForm" method="POST" action="" class="mt-6 flex items-center justify-center gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-rose-600/20 transition">Delete</button>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 7. JAVASCRIPT CONTROLLERS (គ្រប់គ្រង Modal Data & Form Actions)           -->
    <!-- ========================================================================= -->
    <script>
        // ==========================================
        // 1. CREATE: បើក/បិទ Modal បន្ថែម Brand ថ្មី
        // ==========================================
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }
        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        // ==========================================
        // 2. UPDATE: បើក Edit Modal & បំពេញទិន្នន័យ Brand
        // ==========================================
        // មុខងារនេះទទួល JSON Object របស់ Brand ពី Table រួចកំណត់ Form Action ទៅ `/brands/{id}` និងដាក់តម្លៃទៅកាន់ Input នីមួយៗ
        function openEditModal(brand) {
            // កំណត់ URL ផ្ញើទៅកាន់ BrandController@update (PUT /brands/{id})
            document.getElementById('editForm').action = '/brands/' + brand.id;
            
            // បំពេញតម្លៃចាស់ៗចូលទៅក្នុង Input Fields
            document.getElementById('edit_brand_name').value = brand.brand_name || '';
            document.getElementById('edit_country').value = brand.country || '';
            document.getElementById('edit_description').value = brand.description || '';
            document.getElementById('edit_status').value = brand.status || 'Active';
            
            // បង្ហាញ Edit Modal
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // ==========================================
        // 3. READ/VIEW: បើក View Modal & បង្ហាញព័ត៌មានលម្អិត
        // ==========================================
        // មុខងារនេះទទួល JSON Object របស់ Brand រួច Render លើ View Modal ដោយមិនបាច់ Reload ទំព័រ
        function openViewModal(brand) {
            document.getElementById('view_brand_name').textContent = brand.brand_name;
            document.getElementById('view_country').textContent = brand.country || 'No country specified';
            document.getElementById('view_description').textContent = brand.description || 'No description provided.';
            document.getElementById('view_avatar').textContent = (brand.brand_name || 'B').substring(0, 2).toUpperCase();
            document.getElementById('view_created_at').textContent = brand.created_at ? new Date(brand.created_at).toLocaleString() : '—';
            
            // បង្ហាញ Status Badge តាមស្ថានភាពជាក់ស្តែង
            const badge = document.getElementById('view_status_badge');
            if (brand.status === 'Active') {
                badge.innerHTML = '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>';
            } else {
                badge.innerHTML = '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">Inactive</span>';
            }
            document.getElementById('viewModal').classList.remove('hidden');
        }
        function closeViewModal() {
            document.getElementById('viewModal').classList.add('hidden');
        }

        // ==========================================
        // 4. DELETE: បើក Delete Confirmation Modal
        // ==========================================
        // មុខងារនេះកំណត់ Form Action ទៅកាន់ Route `DELETE /brands/{id}` ទៅ `BrandController@destroy`
        function openDeleteModal(id, name) {
            // កំណត់ Action URL សម្រាប់ Form លុប
            document.getElementById('deleteForm').action = '/brands/' + id;
            // បង្ហាញឈ្មោះ Brand ដែលត្រូវលុបលើ Confirmation Message
            document.getElementById('del_brand_name').textContent = name;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</body>

</html>
