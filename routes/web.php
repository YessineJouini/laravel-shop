<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ChatbotController;


// Register alias for middleware?
Route::aliasMiddleware('checkrole', \App\Http\Middleware\CheckRole::class);

// main display
Route::get('/', function () {
    return Auth::check() ? redirect()->route('store.index') : redirect()->route('login');
});

// Admin dashboard (
Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', 'checkrole:admin'])->name('admin.dashboard');

// Admin routes
Route::middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/accept', [OrderController::class, 'accept'])->name('orders.accept');
    Route::post('/orders/{order}/decline', [OrderController::class, 'decline'])->name('orders.decline');
    Route::resource('sales', SalesController::class);
     Route::get('/admin/analytics', [AnalyticsController::class, 'index'])
     ->name('admin.analytics');

Route::post('/orders/bulk-action', [OrderController::class, 'bulkAction'])->name('orders.bulkAction');

});

// Public routes







Route::get('/salesview', [SalesController::class, 'viewSales'])->name('sales.view');
Route::resource('store', StoreController::class)->only(['index', 'show']);
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
 Route::post('/cart/{productId}/add', [CartController::class, 'addToCart'])->name('cart.add');
   Route::post('/cart/item/{itemId}/update', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::delete('/cart/item/{itemId}', [CartController::class, 'removeItem'])->name('cart.removeItem');
 Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
// Auth routes
Auth::routes(['verify' => true]);


// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/orders/{order}',[DashboardController::class, 'showOrder'])->name('dashboard.orders.show');
    Route::resource('reviews', ReviewController::class)->only(['store', 'update', 'destroy']);
    Route::post('/dashboard/address/{address?}', [DashboardController::class, 'saveAddress'])
     ->name('dashboard.address.save');
    Route::delete('/dashboard/address/{address}', [DashboardController::class, 'deleteAddress'])
     ->name('dashboard.address.delete');
     
    Route::get('/wishlist', [WishlistController::class,'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class,'toggle'])
          ->name('wishlist.toggle');
    Route::post('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::post('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
        
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [\App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/chatbot', [ChatbotController::class, 'chatWithBot']);
    
    Route::get('/chatbot', [\App\Http\Controllers\ChatbotController::class, 'index'])->name('chatbot.index');


    
});





    // Cart 
   
    
    Route::get('/cart/checkout', [CartController::class, 'showCheckoutForm'])->name('cart.checkout.form');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    
Route::get('/email/verify', function () {
    return view('auth.verify');
})->name('verification.notice');
// Order Confirmation 
Route::get('/order/confirmation/{order}', [CartController::class, 'showConfirmation'])->name('cart.confirmation');
Route::middleware(['auth'])->group(function () {
   

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/dashboard');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->name('verification.send');
});