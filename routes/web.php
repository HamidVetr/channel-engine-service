<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/set-stock/{productId}', [ProductController::class, 'setStock'])->name('products.stock-set');
