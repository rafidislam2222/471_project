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
})->name('logout');


// 1. Show the Register Page
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

// 2. Handle the Registration Logic
Route::post('/register', [AuthController::class, 'register']);


/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login & Register
    // Login & Register
    // 1. Add ->name('register') to the GET route so the "Create Account" link works
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    
    // 2. The POST route handles the form submit (URL is the same, so it's fine)
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Forgot Password Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password-send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password-verify', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/dashboard', function () {
    return redirect('/admin/users'); 
})->middleware(['auth', 'admin']);

Route::get('/owner/dashboard', function () {
    return view('dashboard.owner');
})->middleware(['auth']);

Route::get('/user/dashboard', function () {
    return view('dashboard.user');
})->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| OWNER PROPERTY MANAGEMENT
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
| USER PROPERTY VIEW + BOOKING ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/properties', [PropertyUserController::class, 'index']);            
Route::get('/properties/{id}', [PropertyUserController::class, 'show']);        
Route::post('/properties/{id}/book', [PropertyUserController::class, 'book'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::post('/admin/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('admin.users.suspend');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/users/{user}/profile', [AdminUserController::class, 'showProfile'])->name('admin.users.profile');

    // Notifications
    Route::get('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read');

    Route::get('/mark-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('markAsRead');



    Route::middleware(['auth'])->group(function () {
        // Dashboard
        Route::get('/dashboard', function () { return view('dashboard.user'); });
    
        // Properties
        Route::get('/properties', [PropertyUserController::class, 'index'])->name('properties.index');
        Route::get('/properties/{id}', [PropertyUserController::class, 'show'])->name('properties.show');
        Route::post('/properties/{id}/book', [PropertyUserController::class, 'book'])->name('properties.book');
    
        // My Bookings & Cancellation
        Route::get('/my-bookings', [PropertyUserController::class, 'myBookings'])->name('my-bookings');
        Route::delete('/bookings/{id}', [PropertyUserController::class, 'cancelBooking'])->name('bookings.cancel');
    
        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    });



});
