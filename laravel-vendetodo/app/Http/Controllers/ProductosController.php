<?php

namespace App\Http\Controllers;

use App\Domain\Producto;
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
    return view('products.index', ['productos' => $productos, 'busqueda' => $busqueda]);
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
    return redirect()->route('products.index');
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

  public function update(StoreProductoRequest $request, $id)
  {

    $producto = $request->except(['_token', 'imagen', '_method']);
    $imagen = $request->file('imagen');

    if ($imagen != null) {
      $imagen = new File($imagen);
    }

    $this->dominio->actualizar($id, $producto, $imagen);
    return redirect()->route('products.index');
  }
}
