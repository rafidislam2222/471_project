<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PropertyWebController;
use App\Http\Controllers\PropertyUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Services\GmailService;

/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
*/

// Redirect homepage to login
Route::get('/', function () {
    return redirect('/login'); 
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login & Register
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Forgot Password Routes
    // 1. Show the "Enter Email" form
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    // 2. Handle the "Send OTP/Link" button click
    Route::post('/forgot-password-send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    // 3. Show the "Enter OTP & New Password" form
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    // 4. Handle the final "Change Password" button click
    Route::post('/reset-password-verify', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/dashboard', function () {
    return redirect('/admin/users'); // Redirects admin to user management
})->middleware(['auth', 'admin']);

Route::get('/owner/dashboard', function () {
    return view('dashboard.owner');
})->middleware(['auth']);

Route::get('/user/dashboard', function () {
    return view('dashboard.user');
})->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| OWNER PROPERTY MANAGEMENT (WEB UI)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/owner/properties', [PropertyWebController::class, 'index']);          // list
    Route::get('/owner/properties/create', [PropertyWebController::class, 'create']); // form add
    Route::post('/owner/properties', [PropertyWebController::class, 'store']);        // save new

    Route::get('/owner/properties/{id}/edit', [PropertyWebController::class, 'edit']); // form edit
    Route::post('/owner/properties/{id}/update', [PropertyWebController::class, 'update']); // update
    Route::get('/owner/properties/{id}/delete', [PropertyWebController::class, 'destroy']); // delete
});

/*
|--------------------------------------------------------------------------
| USER PROPERTY VIEW + BOOKING ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/properties', [PropertyUserController::class, 'index']);            // user list
Route::get('/properties/{id}', [PropertyUserController::class, 'show']);        // user details
Route::post('/properties/{id}/book', [PropertyUserController::class, 'book'])->middleware('auth'); // booking

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Middleware: Auth + Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    // View all users
    Route::get('/admin/users', [AdminUserController::class, 'index'])
        ->name('admin.users.index');

    // Update a user's role
    Route::patch('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])
        ->name('admin.users.updateRole');

    // Suspend / unsuspend a user
    Route::post('/admin/users/{user}/suspend', [AdminUserController::class, 'suspend'])
        ->name('admin.users.suspend');

    // Delete a user permanently
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])
        ->name('admin.users.destroy');
        
    // View a user's profile    
    Route::get('/admin/users/{user}/profile', [AdminUserController::class, 'showProfile'])
        ->name('admin.users.profile');


    // Mark notifications as read
    Route::get('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read');

    Route::get('/mark-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('markAsRead');
});

/*
|--------------------------------------------------------------------------
| GMAIL API ROUTES (Optional / Legacy)
|--------------------------------------------------------------------------
*/
Route::get('/gmail/login', function (GmailService $gmail) {
    return redirect($gmail->getLoginUrl());
});
Route::get('/gmail/callback', function (Request $request, GmailService $gmail) {
    $gmail->saveToken($request->code);
    return "Connected successfully! You can now send emails.";
});