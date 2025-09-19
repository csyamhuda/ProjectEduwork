<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Cukup kembalikan string-nya secara langsung
    return 'Ini route utama';
});

Route::get('/products', function () {
    // Lakukan hal yang sama untuk route products
    return 'Ini adalah route products';
});
    // Lakukan hal yang sama untuk route cart
Route::get('/cart', function () {
    return 'Ini adalah route cart';
});
    // Lakukan hal yang sama untuk route checkout
Route::get('/checkout', function () {
    return 'Ini adalah route checkout';
});