<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PropertyWebController;
use App\Http\Controllers\PropertyUserController; 
use App\Http\Controllers\ForgotPasswordController;
/*
|--------------------------------------------------------------------------
| Homepage Route (Fixes the 404 on load)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/login'); // Redirects homepage to login
});
/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/dashboard', function () {
    return redirect('/admin/users');
});

Route::get('/owner/dashboard', function () {
    return view('dashboard.owner');
});

Route::get('/user/dashboard', function () {
    return view('dashboard.user');
});

/*
|--------------------------------------------------------------------------
| OWNER PROPERTY MANAGEMENT (WEB UI)
|--------------------------------------------------------------------------
*/

Route::get('/owner/properties', [PropertyWebController::class, 'index']);          // list
Route::get('/owner/properties/create', [PropertyWebController::class, 'create']); // form add
Route::post('/owner/properties', [PropertyWebController::class, 'store']);        // save new

Route::get('/owner/properties/{id}/edit', [PropertyWebController::class, 'edit']); // form edit
Route::post('/owner/properties/{id}/update', [PropertyWebController::class, 'update']); // update

Route::get('/owner/properties/{id}/delete', [PropertyWebController::class, 'destroy']); // delete

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
| ADMIN USER MANAGEMENT (ONLY ADMIN)
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


    // Mark all notifications as read
    Route::get('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read')->middleware('auth');

    Route::get('/mark-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('markAsRead')->middleware('auth');


    // 1. Show the "Enter Email" form
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    
    // 2. Handle the "Send OTP" button click
    Route::post('/forgot-password-send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    
    // 3. Show the "Enter OTP & New Password" form
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    
    // 4. Handle the final "Change Password" button click
    Route::post('/reset-password-verify', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
    

});
