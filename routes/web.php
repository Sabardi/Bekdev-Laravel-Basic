<?php

// namespace App\Http\Controllers;

use  App\Http\Controllers\ProductController;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

//route resource for products
Route::resource('/products', ProductController::class);
// Route::get('/product', [ProductController::class, 'index']);
