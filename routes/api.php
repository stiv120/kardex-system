<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\Product\Infrastructure\Controllers\ProductController;
use Src\KardexMovement\Infrastructure\Controllers\KardexMovementController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/** Products routes */
Route::apiResource('products', ProductController::class);
/** Kardex movements routes */
Route::apiResource('kardex-movements', KardexMovementController::class);

