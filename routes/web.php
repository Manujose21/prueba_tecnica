<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/api/products', [ProductController::class, 'index']);
Route::post('/api/products', [ProductController::class, 'store']);
Route::post('/api/orders', [OrderController::class, 'store']);
Route::get('/api/orders/{order}', [OrderController::class, 'productsOrder']);


Route::get('/products', [ProductController::class, 'indexView']);
