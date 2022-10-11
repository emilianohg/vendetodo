<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Models\Producto;
use App\Domain\DominioProductos;

class ProductosController extends Controller
{

 protected $dominio;

  function __construct()
  {
    $this->dominio = new DominioProductos();
  }

  public function index()
  {
    $productos = $this->dominio->Consultar();
    //$productos = Producto::query()->get();
    return response()->json($productos);
  }

  public function show($id)
  {
    $producto = $this->dominio->ConsultarXId($id);
    //$producto = Producto::query()->findOrFail($id);
    return response()->json($producto);
  }

  public function store(StoreProductoRequest $request)
  {
    $producto = $this->dominio->Crear($request);
    //$producto = Producto::query()->create($request->all());
    return response()->json($producto);
  }

  public function destroy($id){
    $this->dominio->Eliminar($id);
  }

}
