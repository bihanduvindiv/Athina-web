<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return file_get_contents(public_path('index.html'));
});

// Authentication routes
Route::post('/api/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/api/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/api/logout', [AuthController::class, 'logout'])->name('api.logout');
Route::get('/api/user', [AuthController::class, 'user'])->name('api.user')->middleware('auth');

// Product routes
use App\Http\Controllers\ProductController;
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/api/products', [ProductController::class, 'api'])->name('api.products');

// Checkout routes
use App\Http\Controllers\CheckoutController;
Route::post('/api/checkout', [CheckoutController::class, 'processCheckout'])->name('api.checkout');
Route::get('/api/orders/{id}', [CheckoutController::class, 'getOrder'])->name('api.order');
Route::get('/api/orders', [CheckoutController::class, 'getAllOrders'])->name('api.orders')->middleware('auth');


