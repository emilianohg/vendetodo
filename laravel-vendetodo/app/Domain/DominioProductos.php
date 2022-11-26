<?php

namespace App\Domain;

use App\Domain\Common\Pagination;
use App\Models\Producto as ProductoBaseDatos;
use App\Models\Marca as MarcaBaseDatos;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Nonstandard\Uuid;
use Symfony\Component\HttpFoundation\File\File;


class DominioProductos
{

  public function consultar($busqueda)
  {
    $productosQuery = ProductoBaseDatos::with(['marca'])->orderByDesc('created_at');

    if ($busqueda != null) {
      $productosQuery->where('nombre', 'LIKE', '%' . $busqueda . '%');
    }

    $productos = $productosQuery->paginate(24);

    return Pagination::fromPaginator($productos, Producto::class);
  }

  public function consultarPorId($id)
  {
    $producto = ProductoBaseDatos::with(['marca'])->findOrFail($id);
    return Producto::from($producto->toArray());
  }

  public function crear($datos, ?File $imagen = null)
  {
    if ($imagen != null) {
      $datos['imagen_url'] = $this->publicarImagen($imagen);
    }

      ProductoBaseDatos::query()->create($datos);
  }

  public function eliminar($id)
  {
    $producto = ProductoBaseDatos::query()->findOrFail($id);
    $producto->delete();
  }

  
  public function getMarcas()
  {
    $marcas = MarcaBaseDatos::query()->orderBy('nombre')->get();
    return Marca::fromArray($marcas->toArray());

  }

  public function actualizar($id, $datos, ?File $imagen = null)
  {
      if ($imagen != null) {
        $datos['imagen_url'] = $this->publicarImagen($imagen);
      }

      ProductoBaseDatos::where('producto_id', '=', $id)->update($datos);
  }

  private function publicarImagen(?File $imagen)
  {
    $imagen_url = null;
    if ($imagen != null) {
      $carpeta = 'public/productos';

      $extension = '.jpg';
      if ($imagen->getMimeType() == 'image/png') {
          $extension = '.png';
      }

      $nombreArchivo = Uuid::uuid4() . $extension;

      Storage::putFileAs($carpeta, $imagen, $nombreArchivo);
      $imagen_url = Storage::url('productos/' . $nombreArchivo);

  }
  return $imagen_url;
  }
}
