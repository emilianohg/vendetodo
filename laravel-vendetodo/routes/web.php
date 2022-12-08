<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SurtidorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CarritoController;

Route::resource('productos',ProductosController::class);
Route::get('/', [ProductosController::class,'index'])->name('products.index');
Route::get('tienda', [ProductosController::class,'indexTienda'])->name('tienda.index');

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::post('logout', [LoginController::class, 'logout'])->name('login.logout');

Route::get('perfil', [PerfilController::class, 'index'])->name('perfil')->middleware('auth');

Route::get('carrito', [CarritoController::class, 'index'])->name('carrito');
Route::post('carrito', [CarritoController::class, 'guardarLineaCarrito'])->name('carrito.guardarLinea');
Route::delete('carrito/{id}', [CarritoController::class, 'borrarLineaCarrito'])->name('carrito.borrarLinea');

Route::get('surtidor', [SurtidorController::class, 'home'])->name('surtidor.home');
Route::post('surtidor/orden', [SurtidorController::class, 'aceptarOrden'])->name('surtidor.aceptarOrden');
Route::get('surtidor/orden/{id}', [SurtidorController::class, 'orden'])->name('surtidor.orden');