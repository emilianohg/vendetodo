<?php

use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Route;


Route::get('listaProductos', [ProductosController::class, 'api']);
