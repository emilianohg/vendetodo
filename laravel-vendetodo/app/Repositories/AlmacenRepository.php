<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Domain\Lote;
use App\Domain\PaqueteLote;
use App\Domain\Seccion;
use App\Domain\Estante;
use App\Domain\Producto;
use App\Models\AlmacenTable;

class AlmacenRepository
{

  /**
   * @return Estante[]
   */
  public function obtenerEstantes()
  {
    $lotes = AlmacenTable::select([
      'lotes.lote_id as lote_id',
      'lotes.producto_id as producto_id',
      'lotes.fecha as fecha',
      'lotes.proveeddor_id as proveedor_id',
      'bodega.cantidad as cantidadBodega',
      DB::raw('COALESCE(control_almacen.cantidad, 0) as cantidadAlmacen'),
      'control_almacen.estante_id as estante',
      'control_almacen.seccion_id as seccion',
    ])
      ->with('producto')
      ->join('bodega', 'lote_id', '=', 'bodega.lote_id')
      ->join('lotes', 'lote_id', '=', 'lotes.lote_id')
      ->join('control_almacen', 'lote_id', '=', 'control_almacen.lote_id')
      ->get();

    $lotesObj = Lote::fromArray($lotes->toArray());

    //createPaquetesLotes
    $paqueteLotes = collect($lotesObj)->map(function ($lote) {
      return new PaqueteLote($lote->getLoteId(), $lote, $lote->getCantidadAlmacen(), $lote->getEstante(), $lote->getSeccion());
    });

    $totalEstantes = config('almacen.numero_estantes');
    $totalSecciones = config('almacen.numero_secciones');

    $estantes = [];

    for ($numEstante = 1; $numEstante <= $totalEstantes; $numEstante++) {
      $secciones = [];
      for ($numSeccion = 1; $numSeccion <= $totalSecciones; $numSeccion++) {
        $paquetesLotes = $paqueteLotes->filter(function ($paqueteLote) use ($numEstante, $numSeccion) {
          return $paqueteLote->getEstanteId() == $numEstante && $paqueteLote->getSeccionId() == $numSeccion;
        });

        $producto = $paquetesLotes->first() ? $paquetesLotes->first()->getLote()->getProducto() : null;

        $secciones[] = new Seccion($numSeccion, $numEstante, $producto, $totalSecciones);
      }
      $estantes[] = new Estante($numEstante, $secciones, $totalEstantes);
    }
  }
}
