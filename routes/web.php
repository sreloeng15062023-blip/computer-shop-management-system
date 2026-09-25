<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\BrandController; // បន្ថែមពេលបង្កើត brand management
use App\Http\Controllers\SupplierController; // បន្ថែមពេលធ្វើ supplier management
use App\Http\Controllers\CustomerController; // បន្ថែមពេលធ្វើ customer management
use App\Http\Controllers\ProductController; // បន្ថែមពេលធ្វើ product management
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes (Computer Shop Management System - Topic 22)
|--------------------------------------------------------------------------
|
| Handles all frontend navigation, Blade views, and web authentication.
|
*/

// Redirect root to dashboard (will prompt login if unauthenticated)
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Social Login Fallback (placeholder for UI buttons)
Route::get('/auth/{provider}', function ($provider) {
    return redirect()->route('dashboard');
})->name('social.login');

// =========================================================================
// Protected Web Application Routes (Requires Authentication)
// =========================================================================
Route::middleware(['auth'])->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. Products Management
    Route::resource('products', ProductController::class);
    // 3. Categories Management
    Route::get('/categories', function () {
        return view('empty');
    })->name('categories.index');

    Route::get('/categories/create', function () {
        return view('empty');
    })->name('categories.create');

    // 4. Brands Management
    
    // ការប្រើ Route::resource('brands', ...) តែមួយបន្ទាត់ គឺ Laravel បង្កើត Routes ទាំង ៧ ដោយស្វ័យប្រវត្តិ៖
    // GET /brands ➡️ brands.index (មើលបញ្ជី)
    // GET /brands/create ➡️ brands.create (ទម្រង់បង្កើត)
    // POST /brands ➡️ brands.store (កន្លែង Submit Form បង្កើត)
    // GET /brands/{brand} ➡️ brands.show (មើលលម្អិត)
    // GET /brands/{brand}/edit ➡️ brands.edit (ទម្រង់កែប្រែ)
    // PUT/PATCH /brands/{brand} ➡️ brands.update (កន្លែង Submit Form កែប្រែ)
    // DELETE /brands/{brand} ➡️ brands.destroy (កន្លែងលុប)
   Route::resource('brands', BrandController::class); // បន្ថែមពេលបង្កើតbrand management

    // 5. Suppliers
    Route::resource('suppliers', SupplierController::class);
    Route::get('/supplier-list', [SupplierController::class, 'index'])->name('suppliers'); // Alias fallback

    // 6. Customers (Customer Management)
    Route::resource('customers', CustomerController::class);
    Route::get('/customer-list', [CustomerController::class, 'index'])->name('customers'); // Alias fallback

    // 7. Purchases
    Route::get('/purchases', function () {
        return view('empty');
    })->name('purchases');

    // 8. Inventory
    Route::get('/inventory', function () {
        return view('empty');
    })->name('inventory');

    // 9. POS Sales
    Route::get('/pos-sales', function () {
        return view('empty');
    })->name('pos.sales');

    // 10. Repair Service
    Route::get('/repair-service', function () {
        return view('empty');
    })->name('repair.service');

    // 11. Warranty
    Route::get('/warranty', function () {
        return view('empty');
    })->name('warranty');

    // 12. Invoices & Payments
    Route::get('/invoices', function () {
        return view('empty');
    })->name('invoices');

    // 13. Employees
    Route::get('/employees', function () {
        return view('empty');
    })->name('employees');

    // 14. Reports
    Route::get('/reports', function () {
        return view('empty');
    })->name('reports');

    // 15. Notifications
    Route::get('/notifications', function () {
        return view('empty');
    })->name('notifications');

    // 16. Settings
    Route::get('/settings', function () {
        return view('empty');
    })->name('settings');

    // Role Management Resource
    Route::resource('role', RoleController::class);
});

// Authentication Routes (Breeze / Custom Auth)
require __DIR__.'/auth.php';
