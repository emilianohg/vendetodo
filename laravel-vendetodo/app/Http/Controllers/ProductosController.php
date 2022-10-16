<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Domain\DominioProductos;
use Illuminate\Http\Request;
use Illuminate\Http\File;

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

  public function store(StoreProductoRequest $request)
  {
    $producto = $request->except(['_token', 'imagen']);
    $imagen = $request->file('imagen');

    if ($imagen != null) {
        $imagen = new File($imagen);
    }

    $this->dominio->crear($producto, $imagen);
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
  }

  public function edit($id)
  {
    $producto = $this->dominio->consultarPorId($id);
    $marcas = $this->dominio->getMarcas();
    return view('products.edit', ['producto' => $producto, 'marcas' => $marcas]);
  }

  public function update(StoreProductoRequest $request, $nombre)
  { 
    /*
    $producto = $request->except(['_token', 'imagen']);
    $imagen = $request->file('imagen');
    return response()->json($producto);
    */
    return redirect()->route('products.index');
    
    /*
    if ($imagen != null) {
        $imagen = new File($imagen);
    }

    $this->dominio->actualizar($producto, $imagen);
    return redirect()->route('products.index');
    */
  }

}
