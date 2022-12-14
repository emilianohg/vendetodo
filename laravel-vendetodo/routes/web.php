<?php

use App\Http\Controllers\EncargadoEstanteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SurtidorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\VentaController;

Route::resource('productos', ProductosController::class);
Route::get('/', [ProductosController::class, 'index'])->name('products.index');
Route::get('tienda', [ProductosController::class, 'indexTienda'])->name('tienda.index');

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::post('logout', [LoginController::class, 'logout'])->name('login.logout');

Route::middleware('auth')->group(function () {
  Route::get('perfil', [PerfilController::class, 'index'])->name('perfil');

  Route::get('carrito', [CarritoController::class, 'index'])->name('carrito');
  Route::post('carrito', [CarritoController::class, 'guardarLineaCarrito'])->name('carrito.guardarLinea');
  Route::delete('carrito/{id}', [CarritoController::class, 'borrarLineaCarrito'])->name('carrito.borrarLinea');

  Route::get('ventas', [VentaController::class, 'index'])->name('ventas.index');
  Route::post('ventas', [VentaController::class, 'realizarVenta'])->name('ventas.realizar');

  Route::post('pago/confirmar', [VentaController::class, 'confirmarPago'])->name('ventas.confirmarPago');
  Route::get('pago/{referencia}', [PagoController::class, 'show'])->name('pago');

  Route::get('ventas', [VentaController::class, 'index'])->name('ventas.index');
  Route::get('ventas/confirm', [VentaController::class, 'confirm'])->name('ventas.confirm');


    Route::middleware('rol:surtidor')->group(function () {
      Route::get('surtidor', [SurtidorController::class, 'home'])->name('surtidor.home');
      Route::post('surtidor/orden', [SurtidorController::class, 'aceptarOrden'])->name('surtidor.aceptarOrden');
      Route::get('surtidor/orden/{id}', [SurtidorController::class, 'orden'])->name('surtidor.orden');
      Route::post('surtidor/orden/recoger-producto', [SurtidorController::class, 'recogerProducto'])->name('surtidor.recogerProducto');
      Route::post('surtidor/orden/terminar', [SurtidorController::class, 'terminarSurtido'])->name('surtidor.terminarSurtido');
      Route::get('surtidor/orden/{id}/ruta', [SurtidorController::class, 'verRuta'])->name('surtidor.verRuta');
  });

  Route::middleware('rol:encargado_estante')->group(function () {
      Route::get('encargado-estante', [EncargadoEstanteController::class, 'home'])->name('encargado-estante.home');
      Route::get('acomodo/estante', [EncargadoEstanteController::class, 'obtenerOrdenProductos'])->name('encargado.obtenerOrden');
      Route::post('acomodo/estante', [EncargadoEstanteController::class, 'generarOrdenProductos'])->name('encargado.generarOrden');
      Route::post('acomodo/estante/iniciar', [EncargadoEstanteController::class, 'comenzarOrdenamiento'])->name('encargado.comenzar');
      Route::post('acomodo/estante/terminar', [EncargadoEstanteController::class, 'terminarOrdenamiento'])->name('encargado.terminar');
      Route::post('acomodo/estante/cancelar', [EncargadoEstanteController::class, 'cancelarOrdenamiento'])->name('encargado.cancelar');
  });
});

