<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


// Home
Route::get('/', [ProductsController::class, 'list'])->name('home');

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

Route::get('/products', [ProductsController::class, 'list'])->name('products_list');
Route::get('/products/{product}/purchase', [ProductsController::class, 'purchaseDetails'])->name('products_purchase_details');
Route::post('/products/{product}/buy', [ProductsController::class, 'buy'])->name('products_buy');
Route::post('/products/{product}/refund', [ProductsController::class, 'refund'])->name('products_refund');
Route::get('/my-orders', [ProductsController::class, 'viewOrders'])->name('products_orders');
Route::get('/products/{product}/edit', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('/products/{product?}/save', [ProductsController::class, 'save'])->name('products_save');
Route::delete('/products/{product}/delete', [ProductsController::class, 'delete'])->name('products_delete');
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
});

// Email Verification
Route::get('verify', [UsersController::class, 'verify'])->name('verify');
