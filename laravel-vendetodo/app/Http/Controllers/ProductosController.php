<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Domain\DominioProductos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{

  private $dominio;

  function __construct()
  {
    $this->dominio = new DominioProductos();
  }

  public function index(Request $request)
  {
    $busqueda = $request->get('busqueda');
    $productos = $this->dominio->consultar($busqueda);
    return view('products.index', compact('productos', 'busqueda'));
  }

  public function show($id)
  {
    $producto = $this->dominio->consultarPorId($id);
    return response()->json($producto);
  }

  public function store(StoreProductoRequest $request)
  {
    $producto = request()->except('_token');
    $this->dominio->crear($producto);
    return redirect()->route('products.index');
  }

  public function destroy($id)
  {
    $this->dominio->eliminar($id);
  }

  public function create()
  {
    $marcas = $this->dominio->getMarcas();
    return view('products.create', ['marcas' => $marcas]);
    //return response()->json($marcas);
  }
}
