<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\BrandController; // បន្ថែមពេលបង្កើត brand management
use App\Http\Controllers\SupplierController; // បន្ថែមពេលធ្វើ supplier management
use App\Http\Controllers\CustomerController; // បន្ថែមពេលធ្វើ customer management
use App\Http\Controllers\CategoryController; // បន្ថែមពេលធ្វើ category management
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
    Route::resource('categories', CategoryController::class);

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

    // 7. Purchases Management (Phase 3: Features #7 Purchase Management)
    Route::resource('purchase-orders', App\Http\Controllers\PurchaseOrderController::class);
    Route::patch('/purchase-orders/{purchase_order}/status', [App\Http\Controllers\PurchaseOrderController::class, 'updateStatus'])->name('purchase-orders.update-status');
    Route::get('/purchases', [App\Http\Controllers\PurchaseOrderController::class, 'index'])->name('purchases'); // Sidebar menu link

    // 8. Inventory Management & Stock Adjustment (Phase 3: Features #8 Inventory Management)
    Route::get('/inventory-transactions', [App\Http\Controllers\InventoryTransactionController::class, 'index'])->name('inventory-transactions.index');
    Route::get('/inventory', [App\Http\Controllers\InventoryTransactionController::class, 'index'])->name('inventory'); // Sidebar menu link
    Route::post('/inventory/adjust', [App\Http\Controllers\InventoryTransactionController::class, 'adjustStock'])->name('inventory.adjust');

    // 9. POS Sales (Phase 4: Sales Management POS)
    Route::get('/pos-sales', [App\Http\Controllers\PosController::class, 'index'])->name('pos.sales');
    Route::get('/sales', [App\Http\Controllers\PosController::class, 'index'])->name('sales.index');
    Route::post('/pos/checkout', [App\Http\Controllers\PosController::class, 'checkout'])->name('pos.checkout');
    Route::get('/pos/receipt/{id}', [App\Http\Controllers\PosController::class, 'receipt'])->name('pos.receipt');

    // 10. Repair Service (Phase 5: Feature #10 Repair Service Management)
    Route::get('/repair-service', [App\Http\Controllers\RepairServiceController::class, 'index'])->name('repair.service');
    Route::get('/repairs', [App\Http\Controllers\RepairServiceController::class, 'index'])->name('repairs.index');
    Route::post('/repairs', [App\Http\Controllers\RepairServiceController::class, 'store'])->name('repairs.store');
    Route::get('/repairs/{id}', [App\Http\Controllers\RepairServiceController::class, 'show'])->name('repairs.show');
    Route::patch('/repairs/{id}/status', [App\Http\Controllers\RepairServiceController::class, 'updateStatus'])->name('repairs.update-status');
    Route::post('/repairs/{id}/parts', [App\Http\Controllers\RepairServiceController::class, 'addPart'])->name('repairs.add-part');
    Route::get('/repairs/{id}/ticket', [App\Http\Controllers\RepairServiceController::class, 'ticket'])->name('repairs.ticket');

    // 11. Warranty (Phase 5: Feature #11 Warranty Management)
    Route::get('/warranty', [App\Http\Controllers\WarrantyController::class, 'index'])->name('warranty');
    Route::get('/warranties', [App\Http\Controllers\WarrantyController::class, 'index'])->name('warranties.index');
    Route::post('/warranties', [App\Http\Controllers\WarrantyController::class, 'store'])->name('warranties.store');
    Route::get('/warranties/lookup', [App\Http\Controllers\WarrantyController::class, 'lookup'])->name('warranties.lookup');
    Route::post('/warranties/claim', [App\Http\Controllers\WarrantyController::class, 'storeClaim'])->name('warranties.claim');

    // 12. Invoices & Payments (Phase 4: Payment & Invoice Management)
    Route::get('/invoices', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoices');
    Route::get('/invoices/{id}', [App\Http\Controllers\InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{id}/print', [App\Http\Controllers\InvoiceController::class, 'print'])->name('invoices.print');

    // 13. Employees
    Route::get('/employees', function () {
        return view('empty');
    })->name('employees');

    // 14. Reports
    Route::get('/reports', function () {
        return view('empty');
    })->name('reports');
    Route::get('/reports-index', function () {
        return view('empty');
    })->name('reports.index');

    // 15. Notifications
    Route::get('/notifications', function () {
        return view('empty');
    })->name('notifications');

    // 16. Settings
    Route::get('/settings', function () {
        return view('empty');
    })->name('settings');
    Route::get('/settings-index', function () {
        return view('empty');
    })->name('settings.index');

    // Role Management Resource
    Route::resource('role', RoleController::class);
});

// Authentication Routes (Breeze / Custom Auth)
require __DIR__.'/auth.php';
