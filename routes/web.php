<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PropertyWebController;
use App\Http\Controllers\PropertyUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login'); 
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Guest Routes (Login/Register)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password-send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password-verify', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Tenants/Owners)
|--------------------------------------------------------------------------
*/
// MOVED OUTSIDE OF ADMIN GROUP
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Logic
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role == 'admin') return redirect('/admin/users');
        if ($user->role == 'owner') return redirect('/owner/dashboard');
        return redirect('/user/dashboard');
    });

    // Specific Dashboards
    Route::get('/user/dashboard', function () {
        return view('dashboard.user'); // Make sure resources/views/dashboard/user.blade.php exists!
    })->name('user.dashboard');

    Route::get('/owner/dashboard', function () {
        return view('dashboard.owner');
    })->name('owner.dashboard');

    // Properties
    Route::get('/properties', [PropertyUserController::class, 'index'])->name('properties.index');
    Route::get('/properties/{id}', [PropertyUserController::class, 'show'])->name('properties.show');
    Route::post('/properties/{id}/book', [PropertyUserController::class, 'book'])->name('properties.book');

    // My Bookings
    Route::get('/my-bookings', [PropertyUserController::class, 'myBookings'])->name('my-bookings');
    Route::delete('/bookings/{id}', [PropertyUserController::class, 'cancelBooking'])->name('bookings.cancel');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

/*
|--------------------------------------------------------------------------
| Owner Property Management
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/owner/properties', [PropertyWebController::class, 'index']);          
    Route::get('/owner/properties/create', [PropertyWebController::class, 'create']); 
    Route::post('/owner/properties', [PropertyWebController::class, 'store']);        
    Route::get('/owner/properties/{id}/edit', [PropertyWebController::class, 'edit']); 
    Route::post('/owner/properties/{id}/update', [PropertyWebController::class, 'update']); 
    Route::get('/owner/properties/{id}/delete', [PropertyWebController::class, 'destroy']); 
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Strictly Admin Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    // 1. ADD THIS MISSING ROUTE (Fixes the 500 Crash)
    Route::get('/mark-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    })->name('markAsRead');

    // 2. Dashboard Redirection
    Route::get('/admin/dashboard', function () {
        return redirect('/admin/users'); 
    });

    // 3. User Management Routes
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::post('/admin/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('admin.users.suspend');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/{user}/profile', [AdminUserController::class, 'showProfile'])->name('admin.users.profile');
});