<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;


Route::get('/', [ProductosController::class,'index'])->name('products.index');

Route::get('login', [LoginController::class, 'index'])->name('login.index');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::post('logout', [LoginController::class, 'logout'])->name('login.logout');
Route::get('perfil', [PerfilController::class, 'index'])->name('perfil');

Route::resource('productos',ProductosController::class);
Route::get('tienda', [ProductosController::class,'indexTienda'])->name('tienda.index');
