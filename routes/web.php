<?php

use App\Http\Controllers\DasboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.login');
});

// Route::get('/login', function () {
//     return view('pages.auth.login');
// });



Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DasboardController::class, 'index']);
    Route::resource('products', ProductController::class);
    Route::get('product-detail/{id?}', [ProductController::class, 'detail']);
    Route::resource('transactions', TransactionController::class);
});


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



require __DIR__ . '/auth.php';
