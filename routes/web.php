<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');

// User Management
Route::prefix('users')->group(function () {
    Route::get('/', [UsersController::class, 'list'])->name('users');
    Route::get('edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
    Route::post('save/{user}', [UsersController::class, 'save'])->name('users_save');
    Route::get('delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
    Route::get('edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
    Route::post('save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
    Route::post('block/{user}', [UsersController::class, 'savePassword'])->name('users_block'); // Confirm if correct method
    Route::get('addemployee', [UsersController::class, 'showAddEmployeePage'])->name('addemployee.form');
    Route::post('addemployee', [UsersController::class, 'addEmployee'])->name('addemployee');
    Route::post('{user}/add-credit', [UsersController::class, 'addCredit'])->name('users_add_credit');
});

// Profile
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');

// Customers
Route::get('/customers', [UsersController::class, 'listCustomers'])->name('customers');

// Products
Route::prefix('products')->group(function () {
    Route::get('/', [ProductsController::class, 'list'])->name('products_list');
    Route::get('edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
    Route::post('save/{product?}', [ProductsController::class, 'save'])->name('products_save');
    Route::get('delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');
    Route::post('buy/{product}', [ProductsController::class, 'buy'])->name('products_buy');
});

// Orders
Route::get('/orders', [ProductsController::class, 'viewOrders'])->name('orders')->middleware('auth');

// Social Authentication
Route::prefix('auth')->group(function () {
    Route::get('google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('google/callback', [GoogleController::class, 'handleGoogleCallback']);

    Route::get('facebook', [UsersController::class, 'redirectToFacebook'])->name('redirectToFacebook');
    Route::get('facebook/callback', [UsersController::class, 'handleFacebookCallback'])->name('handleFacebookCallback');

    Route::get('github', [UsersController::class, 'redirectToGitHub'])->name('redirectToGitHub');
    Route::get('github/callback', [UsersController::class, 'handleGitHubCallback'])->name('handleGitHubCallback');
    
    Route::get('twitter', [UsersController::class, 'redirectToTwitter'])->name('redirectToTwitter');


});

// Email Verification
Route::get('verify', [UsersController::class, 'verify'])->name('verify');


// Show the verify notice page (after register)
Route::get('/email/verify', function () {
    return view('users.verify-notice'); // لازم تعمل الملف ده
})->middleware('auth')->name('verification.notice');

// Handle verify link click
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/'); // أو أي صفحة بعد التفعيل 
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend the verification link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::get('/banned', function () {
    return view('banned');
})->name('banned');


// Role Editor (Admin only)
Route::get('/roles-editor', [UsersController::class, 'rolesEditor'])->name('roles_editor')->middleware('auth');
Route::post('/roles-editor', [UsersController::class, 'saveRole'])->name('roles_save')->middleware('auth');
Route::delete('/roles/{id}/delete', [App\Http\Controllers\Web\UsersController::class, 'deleteRole'])->name('roles_delete');




