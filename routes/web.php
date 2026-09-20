<?php

use App\Http\Controllers\RoleController;
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
    Route::get('/products', function () {
        return view('products');
    })->name('products.index');

    Route::get('/products/create', function () {
        return view('empty');
    })->name('products.create');

    // 3. Categories Management
    Route::get('/categories', function () {
        return view('empty');
    })->name('categories.index');

    Route::get('/categories/create', function () {
        return view('empty');
    })->name('categories.create');

    // 4. Brands Management
    Route::get('/brands', function () {
        return view('empty');
    })->name('brands.index');

    Route::get('/brands/create', function () {
        return view('empty');
    })->name('brands.create');

    // 5. Suppliers
    Route::get('/suppliers', function () {
        return view('empty');
    })->name('suppliers');

    // 6. Customers
    Route::get('/customers', function () {
        return view('empty');
    })->name('customers');

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
