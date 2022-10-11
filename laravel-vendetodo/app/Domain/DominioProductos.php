<?php

namespace App\Domain;

use App\Http\Requests\StoreProductoRequest;
use App\Models\Producto;

class DominioProductos{


    public function Consultar()
    {
      $productos = Producto::query()->get();
      return $productos;
      //return response()->json($productos);
    }
  
    public function ConsultarXId($id)
    {
      $producto = Producto::query()->findOrFail($id);
      return $producto;
      //return response()->json($producto);
    }
  
    public function Crear(StoreProductoRequest $request)
    {
      $producto = Producto::query()->create($request->all());
      return $producto;
      //return response()->json($producto);
    }

}