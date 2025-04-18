<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Auth;
// main routes
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('store', StoreController::class);
Route::aliasMiddleware('checkrole', \App\Http\Middleware\CheckRole::class);
// Root route
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('store.index');
    }
    return redirect()->route('login');
});

//dash

Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', 'checkrole:admin'])
  ->name('admin.dashboard');

// Store routes
Route::get('/store', [StoreController::class, 'index'])->name('store.index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['verify' => true]);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
