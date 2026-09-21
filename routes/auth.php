<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Authentication Routes (សម្រាប់អ្នកមិនទាន់បាន Login)
|--------------------------------------------------------------------------
| These routes can only be accessed by unauthenticated guests.
| Routes ទាំងអស់ក្នុង Group នេះអាចប្រើប្រាស់បានតែអ្នកដែលមិនទាន់ Login ចូលប្រព័ន្ធប៉ុណ្ណោះ។
*/
Route::middleware('guest')->group(function () {

    // =========================================================================
    // 1. REGISTRATION ROUTES (ផ្លូវទាក់ទងនឹងការចុះឈ្មោះគណនីថ្មី)
    // =========================================================================

    /**
     * Show Registration Form (បង្ហាញទម្រង់បែបបទចុះឈ្មោះ)
     * - Method:     GET
     * - URL:        /register
     * - Route Name: register
     * - Controller: RegisteredUserController@create
     * - Purpose (English): Returns the Blade view containing the user registration form.
     * - Purpose (Khmer):   បង្ហាញផ្ទាំងចុះឈ្មោះសម្រាប់អ្នកប្រើប្រាស់ថ្មីបង្កើតគណនី។
     */
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    /**
     * Handle User Registration (ដំណើរការចុះឈ្មោះគណនីថ្មី)
     * - Method:     POST
     * - URL:        /register
     * - Controller: RegisteredUserController@store
     * - Purpose (English): Validates incoming input (name, email, password), creates a new user record
     *                      in the database, automatically logs in the new user, and redirects to dashboard.
     * - Purpose (Khmer):   ទទួលទិន្នន័យពី Form, ពិនិត្យភាពត្រឹមត្រូវ (Validation), បង្កើត User ថ្មីក្នុង Database,
     *                      ធ្វើការ Login ចូលដោយស្វ័យប្រវត្តិ និងបញ្ជូន (Redirect) ទៅកាន់ Dashboard។
     */
    Route::post('register', [RegisteredUserController::class, 'store']);


    // =========================================================================
    // 2. LOGIN ROUTES (ផ្លូវទាក់ទងនឹងការចូលប្រើប្រាស់ប្រព័ន្ធ)
    // =========================================================================

    /**
     * Show Login Form (បង្ហាញទម្រង់បែបបទ Login)
     * - Method:     GET
     * - URL:        /login
     * - Route Name: login
     * - Controller: AuthenticatedSessionController@create
     * - Purpose (English): Displays the login screen (resources/views/auth/login.blade.php)
     *                      where users enter their email and password.
     * - Purpose (Khmer):   បង្ហាញផ្ទាំង Login សម្រាប់ឱ្យអ្នកប្រើប្រាស់វាយបញ្ចូល Email និង Password។
     */
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    /**
     * Handle Login Submission (ដំណើរការផ្ទៀងផ្ទាត់ការ Login)
     * - Method:     POST
     * - URL:        /login
     * - Controller: AuthenticatedSessionController@store
     * - Purpose (English): Authenticates credentials against the users table, generates an authenticated session,
     *                      regenerates the session ID to prevent session fixation, and redirects to dashboard.
     * - Purpose (Khmer):   ទទួល Email/Password ពី Form, ផ្ទៀងផ្ទាត់ជាមួយ Database, បង្កើត Session ថ្មីការពារ Security,
     *                      និងបញ្ជូនអ្នកប្រើប្រាស់ទៅកាន់ Dashboard។
     */
    Route::post('login', [AuthenticatedSessionController::class, 'store']);


    // =========================================================================
    // 3. PASSWORD RESET ROUTES (ផ្លូវទាក់ទងនឹងការផ្លាស់ប្តូរ Password ពេលភ្លេច)
    // =========================================================================

    /**
     * Show Forgot Password Form (បង្ហាញផ្ទាំងស្នើសុំផ្លាស់ប្តូរ Password)
     * - Method:     GET
     * - URL:        /forgot-password
     * - Route Name: password.request
     * - Controller: PasswordResetLinkController@create
     * - Purpose (English): Displays the form where users can submit their email address to request a reset link.
     * - Purpose (Khmer):   បង្ហាញទម្រង់បែបបទសម្រាប់អ្នកប្រើប្រាស់បញ្ចូល Email ដើម្បីស្នើសុំតំណភ្ជាប់ Reset Password។
     */
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    /**
     * Send Password Reset Link Email (ផ្ញើតំណភ្ជាប់ Reset Password ទៅកាន់ Email)
     * - Method:     POST
     * - URL:        /forgot-password
     * - Route Name: password.email
     * - Controller: PasswordResetLinkController@store
     * - Purpose (English): Validates the email address, generates a unique secure reset token, saves it
     *                      in the password_resets table, and emails the reset link to the user.
     * - Purpose (Khmer):   ពិនិត្យ Email, បង្កើត Reset Token ពិសេសរក្សាទុកក្នុងតារាង password_resets
     *                      និងផ្ញើតំណភ្ជាប់ (Link) ទៅកាន់ប្រអប់សំបុត្រ Email របស់អ្នកប្រើ។
     */
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    /**
     * Show Reset Password Form with Token (បង្ហាញផ្ទាំងសម្រាប់វាយបញ្ចូល Password ថ្មី)
     * - Method:     GET
     * - URL:        /reset-password/{token}
     * - Route Name: password.reset
     * - Controller: NewPasswordController@create
     * - Purpose (English): Displays the password reset form with the security token passed as a URL parameter.
     * - Purpose (Khmer):   បង្ហាញផ្ទាំងសម្រាប់វាយបញ្ចូល Password ថ្មី នៅពេលអ្នកប្រើចុចលើ Link ពី Email
     *                      ដោយមានភ្ជាប់ជាមួយ Security Token។
     */
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    /**
     * Update Password in Database (ធ្វើបច្ចុប្បន្នភាព Password ថ្មីក្នុង Database)
     * - Method:     POST
     * - URL:        /reset-password
     * - Route Name: password.update
     * - Controller: NewPasswordController@store
     * - Purpose (English): Validates the reset token and new password, updates the hashed password in the users table,
     *                      and redirects the user to the login screen with a success message.
     * - Purpose (Khmer):   ផ្ទៀងផ្ទាត់ Token និង Password ថ្មី, ធ្វើការ Hash Password និង Save ចូល Database,
     *                      រួចបញ្ជូនទៅទំព័រ Login វិញជាមួយសារជោគជ័យ។
     */
    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (សម្រាប់អ្នកដែលបាន Login រួចហើយ)
|--------------------------------------------------------------------------
| These routes require the user to be logged in with an active session.
| Routes ទាំងអស់ក្នុង Group នេះតម្រូវឱ្យអ្នកប្រើប្រាស់មាន Session និងបាន Login រួចជាស្រេច។
*/
Route::middleware('auth')->group(function () {

    // =========================================================================
    // 4. EMAIL VERIFICATION ROUTES (ផ្លូវទាក់ទងនឹងការផ្ទៀងផ្ទាត់ Email)
    // =========================================================================

    /**
     * Show Email Verification Notice (បង្ហាញផ្ទាំងជូនដំណឹងឱ្យផ្ទៀងផ្ទាត់ Email)
     * - Method:     GET
     * - URL:        /verify-email
     * - Route Name: verification.notice
     * - Controller: EmailVerificationPromptController@__invoke
     * - Purpose (English): Informs the user that an email verification link was sent and they need to verify their email.
     * - Purpose (Khmer):   បង្ហាញទំព័រជូនដំណឹងឱ្យ User ចូលទៅផ្ទៀងផ្ទាត់ Email របស់ពួកគេ មុនពេលបន្តប្រើប្រាស់មុខងារផ្សេងៗ។
     */
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    /**
     * Verify Email Address via Signed URL (ផ្ទៀងផ្ទាត់ Email តាមរយៈ URL មានហត្ថលេខាឌីជីថល)
     * - Method:     GET
     * - URL:        /verify-email/{id}/{hash}
     * - Route Name: verification.verify
     * - Controller: VerifyEmailController@__invoke
     * - Purpose (English): Validates the signed URL clicked from the user's email, marks the user's email
     *                      as verified (sets email_verified_at timestamp), and redirects to dashboard.
     * - Purpose (Khmer):   ផ្ទៀងផ្ទាត់ Signed Link ដែល User បានចុចពី Email, កត់ត្រាកាលបរិច្ឆេទ (email_verified_at)
     *                      ក្នុង Database ថាបានផ្ទៀងផ្ទាត់ជោគជ័យ រួចបញ្ជូនទៅ Dashboard។
     */
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    /**
     * Resend Verification Email (ផ្ញើតំណភ្ជាប់ផ្ទៀងផ្ទាត់ Email ម្តងទៀត)
     * - Method:     POST
     * - URL:        /email/verification-notification
     * - Route Name: verification.send
     * - Controller: EmailVerificationNotificationController@store
     * - Purpose (English): Sends a new verification email notification to the authenticated user if they didn't receive the first one.
     * - Purpose (Khmer):   ផ្ញើតំណភ្ជាប់ផ្ទៀងផ្ទាត់ Email សារជាថ្មីទៅកាន់ User ប្រសិនបើមិនទាន់បានទទួលលើកដំបូង។
     */
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');


    // =========================================================================
    // 5. CONFIRM PASSWORD ROUTES (ផ្លូវទាក់ទងនឹងការបញ្ជាក់ Password ឡើងវិញ)
    // =========================================================================

    /**
     * Show Password Confirmation Screen (បង្ហាញផ្ទាំងឱ្យបញ្ជាក់ Password ឡើងវិញ)
     * - Method:     GET
     * - URL:        /confirm-password
     * - Route Name: password.confirm
     * - Controller: ConfirmablePasswordController@show
     * - Purpose (English): Displays a password prompt before accessing sensitive areas (like changing security settings).
     * - Purpose (Khmer):   បង្ហាញផ្ទាំងទាមទារឱ្យវាយបញ្ចូល Password ម្តងទៀត មុនពេលអនុញ្ញាតឱ្យចូលទៅកាន់ផ្នែកសំខាន់ៗនៃប្រព័ន្ធ។
     */
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    /**
     * Confirm Password Submission (ដំណើរការផ្ទៀងផ្ទាត់ការបញ្ជាក់ Password)
     * - Method:     POST
     * - URL:        /confirm-password
     * - Controller: ConfirmablePasswordController@store
     * - Purpose (English): Verifies the provided password against the current user's password, records confirmation
     *                      timestamp in session, and allows proceeding to the requested sensitive page.
     * - Purpose (Khmer):   ផ្ទៀងផ្ទាត់ Password ថាត្រឹមត្រូវឬអត់, កត់ត្រាពេលវេលាបញ្ជាក់ក្នុង Session និងអនុញ្ញាតឱ្យបន្តដំណើរការ។
     */
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);


    // =========================================================================
    // 6. LOGOUT ROUTE (ផ្លូវទាក់ទងនឹងការចាកចេញពីប្រព័ន្ធ)
    // =========================================================================

    /**
     * Logout User (ចាកចេញពីប្រព័ន្ធ / Logout)
     * - Method:     GET | POST (គាំទ្រទាំងការចុច Link ផ្ទាល់ និងការផ្ញើ Form POST)
     * - URL:        /logout
     * - Route Name: logout
     * - Controller: AuthenticatedSessionController@destroy
     * - Purpose (English): Logs out the user from the current session guard, invalidates the user's session,
     *                      regenerates the CSRF token to prevent token hijacking, and redirects back to the login page.
     * - Purpose (Khmer):   ចាកចេញពីប្រព័ន្ធ (Logout), លុបចោល Session បច្ចុប្បន្ន, បង្កើត CSRF Token ថ្មីឡើងវិញ
     *                      ដើម្បីការពារសុវត្ថិភាព និងបញ្ជូនអ្នកប្រើប្រាស់ត្រឡប់ទៅកាន់ទំព័រ Login វិញ។
     */
    Route::match(['get', 'post'], 'logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
