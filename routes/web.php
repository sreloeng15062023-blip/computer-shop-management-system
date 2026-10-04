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

    // 1. Dashboard (Phase 7: Feature #2 Dashboard)
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

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

    // 13. Employees (Phase 6: Feature #13 Employee Management & HRM)
    Route::get('/employees', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employees');
    Route::post('/employees', [App\Http\Controllers\EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{id}', [App\Http\Controllers\EmployeeController::class, 'show'])->name('employees.show');
    Route::put('/employees/{id}', [App\Http\Controllers\EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{id}', [App\Http\Controllers\EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::post('/employees/{id}/attendance', [App\Http\Controllers\EmployeeController::class, 'recordAttendance'])->name('employees.attendance');

    // 14. Reports (Phase 7: Feature #14 Report Management)
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports');
    Route::get('/reports/data', [\App\Http\Controllers\ReportController::class, 'getReportData'])->name('reports.data');
    Route::get('/reports/export', [\App\Http\Controllers\ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/print', [\App\Http\Controllers\ReportController::class, 'printReport'])->name('reports.print');
    Route::get('/reports-index', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

   
       // =========================================================================
    // 15. NOTIFICATION SYSTEM ROUTES (គ្រប់គ្រងប្រព័ន្ធដំណឹងទាំងអស់)
    // =========================================================================
    Route::controller(\App\Http\Controllers\NotificationController::class)->group(function () {
        
        // 1. បើកមើលទំព័រ Notification ធំ (List, Filter, Tabs, Stat Cards)
        Route::get('/notifications', 'index')->name('notifications');

        // 2. ទាញព័ត៌មានលម្អិតនៃសារមួយមកបង្ហាញក្នុងផ្ទាំង Side Panel ខាងស្តាំតាម AJAX
        Route::get('/notifications/{id}/details', 'show')->name('notifications.show');

        // 3. ចុចកំណត់សារមួយថាបានអានរួច (Mark as Read)
        Route::post('/notifications/{id}/read', 'markAsRead')->name('notifications.read');

        // 4. ចុចប៊ូតុងធំ "Mark All as Read" ដើម្បីកំណត់ថាសារទាំងអស់អានរួច
        Route::post('/notifications/mark-all-read', 'markAllAsRead')->name('notifications.markAllRead');

        // 5. ដំណើរការលើសារដែលបានធីក Checkbox ច្រើន (Bulk Action: Delete ឬ Mark Read)
        Route::post('/notifications/bulk-action', 'bulkAction')->name('notifications.bulkAction');

        // 6. លុបសារមួយចោលចេញពីប្រព័ន្ធ
        Route::delete('/notifications/{id}', 'destroy')->name('notifications.destroy');
    });



    // =========================================================================
    // 16. SETTINGS MANAGEMENT ROUTES (គ្រប់គ្រង Settings តាម Controller)
    // =========================================================================
    Route::controller(\App\Http\Controllers\SettingController::class)->group(function () {
        Route::get('/settings', 'index')->name('settings');
        Route::get('/settings-index', 'index')->name('settings.index');
        // Ajax Routes សម្រាប់ Save ទិន្នន័យ
        Route::post('/settings/general', 'updateGeneral')->name('settings.general');
        Route::post('/settings/shop', 'updateShop')->name('settings.shop');
        Route::post('/settings/backup', 'createBackup')->name('settings.backup');
    });


    // Role Management Resource
    Route::resource('role', RoleController::class);
});

// Authentication Routes (Breeze / Custom Auth)
require __DIR__.'/auth.php';
