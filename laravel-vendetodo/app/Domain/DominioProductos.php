<?php

namespace App\Domain;

use App\Http\Requests\StoreProductoRequest;
use App\Models\Producto;

class DominioProductos
{


  public function consultar()
  {
    $productos = Producto::query()->get();
    return $productos;
  }

  public function consultarPorId($id)
  {
    $producto = Producto::query()->findOrFail($id);
    return $producto;
  }

  public function crear(StoreProductoRequest $request)
  {
    $producto = Producto::query()->create($request->all());
    return $producto;
  }
  public function eliminar($id)
  {
    $producto = Producto::query()->findOrFail($id);
    $producto->delete();
  }

}
