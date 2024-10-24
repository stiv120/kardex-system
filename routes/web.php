<?php

use Illuminate\Support\Facades\Route;
use Src\Product\Infrastructure\Controllers\ProductController;
use Src\KardexMovement\Infrastructure\Controllers\KardexMovementController;

Route::get('/', function () {
    return view('welcome');
});

// /** Products routes */
// Route::resource('products', ProductController::class);
// /** Kardex movements routes */
// Route::resource('kardex-movements', KardexMovementController::class);
