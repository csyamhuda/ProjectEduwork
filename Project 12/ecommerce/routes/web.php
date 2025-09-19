<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/cart', [HomeController::class,'cart'])->name('cart.index');

Route::get('/products', function () {

    return 'Ini adalah route products';
});

Route::get('/checkout', function () {
    return 'Ini adalah route checkout';
});

Route::resource('products-resource', ProductController::class);