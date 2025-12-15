<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PropertyWebController;
use App\Http\Controllers\PropertyUserController; 
use App\Services\GmailService;
////////////////////////////////// General Routes ////////////////////////////
Route::get('/', function () {
    return redirect('/login'); // Redirects homepage to login
});
/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

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



//////////////////////////////////Admin Routes////////////////////////////

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


    //////////////// Mark all notifications as read/////////////////
    Route::get('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read')->middleware('auth');

    Route::get('/mark-as-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('markAsRead')->middleware('auth');
});

Route::get('/gmail/login', function (GmailService $gmail) {
    return redirect($gmail->getLoginUrl());
});
Route::get('/gmail/callback', function (Request $request, GmailService $gmail) {
    $gmail->saveToken($request->code);
    return "Connected successfully! You can now send emails.";
});

//user notification route
Route::get('/notifications/mark-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->name('notifications.read')->middleware('auth');
                     ////////////manual test//////
Route::get('/test-gmail-api', function (App\Services\GmailService $gmail) {
    $gmail->connect();
    try {
        $gmail->sendEmail(
            'gm.abir.1415@gmail.com', 
            'API Success Test',
            'This email was sent via Google API from your Laravel App!'
        );
        return "SUCCESS: Email sent!";
    } catch (\Exception $e) {
        return "FAILED: " . $e->getMessage();
    }
});