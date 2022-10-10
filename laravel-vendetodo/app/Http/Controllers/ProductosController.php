<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Models\Producto;

class ProductosController extends Controller
{
  public function index()
  {
    $productos = Producto::query()->get();
    return response()->json($productos);
  }

  public function show($id)
  {
    $producto = Producto::query()->findOrFail($id);
    return response()->json($producto);
  }

  public function store(StoreProductoRequest $request)
  {
    $producto = Producto::query()->create($request->all());
    return response()->json($producto);
  }
}
