<?php

namespace App\Domain;

use App\Http\Requests\StoreProductoRequest;
use App\Models\Producto;
use App\Models\Marca;


class DominioProductos
{


  public function consultar($busqueda)
  {
    $productosQuery = Producto::with(['marca']);

    if ($busqueda != null) {
      $productosQuery->where('nombre', 'LIKE', '%' . $busqueda . '%');
    }

    $productos = $productosQuery->paginate(24);

    return $productos;
  }

  public function consultarPorId($id)
  {
    $producto = Producto::with(['marca'])->findOrFail($id);
    return $producto;
  }

  public function crear($producto)
  {
    Producto::insert($producto);
  }
  public function eliminar($id)
  {
    $producto = Producto::query()->findOrFail($id);
    $producto->delete();
  }
  public function getMarcas()
  {
    $marcas = Marca::query()->orderBy('nombre')->get();
    return $marcas;
  }
}