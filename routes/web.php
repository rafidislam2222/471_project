<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
// Import all your Controllers
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

// LOGOUT (Must be named 'logout' for your Blade files to work)
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Guest Routes (Login & Register)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

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
Route::middleware(['auth'])->group(function () {
    
    // Redirect logic for "/dashboard"
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role == 'admin') return redirect('/admin/users');
        if ($user->role == 'owner') return redirect('/owner/dashboard');
        return redirect('/user/dashboard');
    });

    // View Dashboards
    Route::get('/user/dashboard', function () {
        return view('dashboard.user'); 
    })->name('user.dashboard');

    Route::get('/owner/dashboard', function () {
        return view('dashboard.owner');
    })->name('owner.dashboard');

    // Notifications View
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    
    // Properties (Viewing & Booking)
    Route::get('/properties', [PropertyUserController::class, 'index'])->name('properties.index');
    Route::get('/properties/{id}', [PropertyUserController::class, 'show'])->name('properties.show');
    Route::post('/properties/{id}/book', [PropertyUserController::class, 'book'])->name('properties.book');

    // My Bookings
    Route::get('/my-bookings', [PropertyUserController::class, 'myBookings'])->name('my-bookings');
    Route::delete('/bookings/{id}', [PropertyUserController::class, 'cancelBooking'])->name('bookings.cancel');
});

/*
|--------------------------------------------------------------------------
| OWNER Routes (Property Management)
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
| ADMIN Routes (Strictly Admin Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    // *** THIS IS THE CRITICAL FIX FOR THE 500 ERROR ***
    // Your index.blade.php calls route('markAsRead'), so this MUST exist here.
    Route::get('/mark-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    })->name('markAsRead');

    // Admin Dashboard Redirect
    Route::get('/admin/dashboard', function () {
        return redirect('/admin/users'); 
    });

    // User Management
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::post('/admin/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('admin.users.suspend');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/{user}/profile', [AdminUserController::class, 'showProfile'])->name('admin.users.profile');
});
Route::get('/emergency-db-fix', function () {
    // 1. Run the migration forcefully
    Artisan::call('migrate:fresh --seed --force');
    
    // 2. Clear caches to be safe
    Artisan::call('optimize:clear');
    
    return "DATABASE FIXED! Tables created and seeded successfully.";
});