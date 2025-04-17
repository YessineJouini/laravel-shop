<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;

// main routes
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('store', StoreController::class);



//dash

Route::get('/', function () {
    return view('admin');
})->name('admin.dashboard');  

Route::get('/admin', function () {
    return view('admin');
})->name('admin.dashboard');  

// Store routes
Route::get('/store', [StoreController::class, 'index'])->name('store.index');