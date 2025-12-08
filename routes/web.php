<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyWebController;
use App\Http\Controllers\AdminUserController;

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
    return view('dashboard.admin');
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
        

});
