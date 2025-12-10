<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyWebController;
use App\Http\Controllers\PropertyUserController; // <-- added for user side

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
| USER PROPERTY VIEW + BOOKING ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/properties', [PropertyUserController::class, 'index']);            // user list
Route::get('/properties/{id}', [PropertyUserController::class, 'show']);        // user details
Route::post('/properties/{id}/book', [PropertyUserController::class, 'book'])->middleware('auth'); // booking
