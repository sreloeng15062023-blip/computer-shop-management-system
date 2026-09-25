<?php
use App\Http\Controllers\SupplierController;// បន្ថែមពេលធ្វើsupplier management

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/

// =========================================================================
// 1. Module: User Authentication (Topic 22 - Section 1)
// =========================================================================
Route::prefix('auth')->group(function () {
    // Public endpoint: Authenticate user & issue Bearer Token
    Route::post('/login', [AuthController::class, 'login']);

    // Protected endpoints: Accessible only with valid Sanctum Bearer Token
    Route::middleware('auth:sanctum')->group(function () {
        // Fetch profile and role of currently logged-in user
        Route::get('/user', [AuthController::class, 'user']);
        Route::get('/me', [AuthController::class, 'user']); // Alias

        // Revoke active token and log out
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// =========================================================================
// 2. Role Management API (RBAC)
// =========================================================================
// Standard REST API endpoints: GET, POST, PUT, DELETE for /api/roles
Route::apiResource('roles', RoleController::class);


use App\Http\Controllers\BrandController; // បន្ថែមពេលបង្កើតbrand ដើម្បីយកទៅតេស្ដលើPostman

// 3. Brand Management API   // បន្ថែមពេលបង្កើតbrand ដើម្បីយកទៅតេស្ដលើPostman
Route::apiResource('brands', BrandController::class);// បន្ថែមពេលបង្កើតbrand ដើម្បីយកទៅតេស្ដលើPostman



// 4. Supplier Management API // បន្ថែមពេលធ្វើsupplier management
Route::apiResource('suppliers', SupplierController::class)->names('api.suppliers');

use App\Http\Controllers\CustomerController; // បន្ថែមពេលធ្វើ customer management

// 5. Customer Management API // បន្ថែមពេលធ្វើ Customer Management ដើម្បីយកទៅតេស្ដលើ Postman
Route::apiResource('customers', CustomerController::class)->names('api.customers');




