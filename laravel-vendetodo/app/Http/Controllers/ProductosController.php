<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Domain\DominioProductos;

class ProductosController extends Controller
{

  private $dominio;

  function __construct()
  {
    $this->dominio = new DominioProductos();
  }

  public function index()
  {
    $productos = $this->dominio->consultar();
    return view('products.index');
  }

  public function show($id)
  {
    $producto = $this->dominio->consultarPorId($id);
    return response()->json($producto);
  }

  public function store(StoreProductoRequest $request)
  {
    $producto = $this->dominio->crear($request);
    return response()->json($producto);
  }

  public function destroy($id){
    $this->dominio->eliminar($id);
  }

  public function create()
  {
    return view('products.create');
  }
}
