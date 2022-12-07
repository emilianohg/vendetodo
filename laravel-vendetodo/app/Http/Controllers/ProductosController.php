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

  public function show($id)
  {
    $datos = $this->dominio->obtenerDetalleProducto($id);
    return view('products.individual', $datos);
  }

  public function indexTienda(Request $request)
  {
    $busqueda = $request->get('busqueda');
    $productos = $this->dominio->consultar($busqueda);
    return view('crud.productos', ['productos' => $productos, 'busqueda' => $busqueda]);
  }

  public function store(StoreProductoRequest $request)
  {
    $datos = $request->except(['_token', 'imagen']);
    $imagen = $request->file('imagen');

    if ($imagen != null) {
      $imagen = new File($imagen);
    }

    $this->dominio->crear($datos, $imagen);
    return redirect()->route('tienda.index');
  }

  public function destroy($id)
  {
    $this->dominio->eliminar($id);
    return redirect()->route('tienda.index');
  }

  public function create()
  {
    $marcas = $this->dominio->getMarcas();
    return view('crud.create', ['marcas' => $marcas]);
  }

  public function edit($id)
  {
    $producto = $this->dominio->consultarPorId($id);
    $marcas = $this->dominio->getMarcas();
    return view('crud.edit', ['producto' => $producto, 'marcas' => $marcas]);
  }

  public function update(StoreProductoRequest $request, $id)
  {

    $datos = $request->except(['_token', 'imagen', '_method']);
    $imagen = $request->file('imagen');

    if ($imagen != null) {
      $imagen = new File($imagen);
    }

    $this->dominio->actualizar($id, $datos, $imagen);
    return redirect()->route('tienda.index');
  }

  public function api()
  {
    $productosAJson = $this->dominio->postApi();
    return response()->json($productosAJson);
  }
}
