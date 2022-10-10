<?php

use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Route;

Route::resource('productos', ProductosController::class);
