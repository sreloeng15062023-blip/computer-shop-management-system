@php
$segment = request()->segment(1) ?? 'dashboard';

$titleMap = [
'products' => 'Products',
'categories' => 'Categories',
'brands' => 'Brands',
'suppliers' => 'Suppliers',
'customers' => 'Customers',
'purchases' => 'Purchases',
'inventory' => 'Inventory',
'pos-sales' => 'POS Sales',
'repair-service' => 'Repair Service',
'warranty' => 'Warranty',
'invoices' => 'Invoices',
'employees' => 'Employees',
'reports' => 'Reports',
'notifications' => 'Notifications',
'settings' => 'Settings',
];

$singularMap = [
'products' => 'product',
'categories' => 'category',
'brands' => 'brand',
'suppliers' => 'supplier',
'customers' => 'customer',
'purchases' => 'purchase',
'inventory' => 'inventory item',
'pos-sales' => 'POS sale',
'repair-service' => 'repair ticket',
'warranty' => 'warranty record',
'invoices' => 'invoice',
'employees' => 'employee',
'reports' => 'report',
'notifications' => 'notification',
'settings' => 'setting',
];

$pageTitle = $titleMap[$segment] ?? ucfirst($segment);
$singularName = $singularMap[$segment] ?? $pageTitle;
$createRoute = Route::has($segment . '.create') ? route($segment . '.create') : '#';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }} - Computer Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#f8fafc] text-slate-800 font-sans flex min-h-screen">

    <!-- Include Standard Sidebar -->
    @include('sidebar')

    <!-- Main Content Area -->
    <main class="flex-1 p-8 overflow-y-auto">
        <!-- Top Bar Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $pageTitle }}</h1>

            <div class="flex items-center gap-3">
                <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition shadow-sm">
                    More Actions <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>

                <a href="{{ $createRoute }}" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm">
                    <i class="fa-solid fa-plus text-xs"></i> New {{ ucfirst($singularName) }}
                </a>
            </div>
        </div>

        <!-- Main Empty State Display -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-16 text-center flex flex-col items-center justify-center min-h-[580px] shadow-sm">

            <!-- Graphic Illustration Icons -->
            <div class="relative w-32 h-24 mb-6 flex items-center justify-center">
                <div class="absolute -left-1 transform -rotate-12 bg-[#2dd4bf] w-14 h-16 rounded-xl shadow-md flex items-center justify-center border-2 border-white">
                    <i class="fa-solid fa-tag text-white text-xl"></i>
                </div>
                <div class="absolute right-1 transform rotate-12 bg-[#3b82f6] w-14 h-16 rounded-xl shadow-md flex items-center justify-center border-2 border-white">
                    <i class="fa-solid fa-box-archive text-white text-xl"></i>
                </div>
            </div>

            <!-- Title & Subtitle -->
            <h2 class="text-xl font-bold text-slate-900 mb-1">
                You don't have any {{ strtolower($pageTitle) }} yet
            </h2>
            <p class="text-slate-400 text-sm max-w-sm mb-6 leading-relaxed">
                Create your {{ $singularName }} in an easy & fast way to display it on your site
            </p>

            <a href="{{ $createRoute }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 transition">
                <i class="fa-solid fa-plus text-xs"></i> New {{ ucfirst($singularName) }}
            </a>

        </div>
    </main>

</body>

</html>