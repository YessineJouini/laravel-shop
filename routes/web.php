<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;

// Register alias for middleware (optional here if already in kernel)
Route::aliasMiddleware('checkrole', \App\Http\Middleware\CheckRole::class);

// Root redirect
Route::get('/', function () {
    return Auth::check() ? redirect()->route('store.index') : redirect()->route('login');
});

// Admin dashboard
Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', 'checkrole:admin'])->name('admin.dashboard');

// ✅ Admin-only routes
Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});

// Public store routes
Route::get('/store', [StoreController::class, 'index'])->name('store.index');
Route::resource('store', StoreController::class)->only(['index', 'show']);

// Auth routes
Auth::routes(['verify' => true]);

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cart
    Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
    Route::post('/cart/{productId}/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});


