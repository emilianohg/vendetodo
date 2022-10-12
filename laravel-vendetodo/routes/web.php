<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;


Route::get('/', [ProductosController::class,'index'])->name('products.index');
Route::resource('productos',ProductosController::class);
