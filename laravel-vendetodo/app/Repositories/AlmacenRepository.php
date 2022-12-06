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
      'almacen.estante_id',
      'almacen.seccion_id',
      'almacen.producto_id',
      'lotes.lote_id',
      'lotes.fecha',
      'lotes.proveedor_id',
      'lotes.cantidad',
      'bodega.cantidad as cantidadBodega',
      DB::raw('COALESCE(control_almacen.cantidad, 0) as cantidadAlmacen'),
    ])
      ->with('producto')
      ->leftJoin('control_almacen', function ($join) {
        $join->on('control_almacen.estante_id', '=', 'almacen.estante_id')
          ->on('control_almacen.seccion_id', '=', 'almacen.seccion_id');
      })
      ->leftJoin('bodega', 'bodega.lote_id', '=', 'control_almacen.lote_id')
      ->leftJoin('lotes', 'lotes.lote_id', '=', 'control_almacen.lote_id')
      ->whereNotNull('lotes.lote_id')
      ->orderBy('almacen.estante_id')
      ->orderBy('almacen.seccion_id')
      ->get();

    $seccionesList = AlmacenTable::query()->with(['producto', 'producto.marca'])->get();


    $lotesObj = Lote::fromArray($lotes->toArray());

    //createPaquetesLotes
    $paquetesLotesAlmacen = collect($lotesObj)->map(function ($lote) {
      return new PaqueteLote($lote->getLoteId(), $lote, $lote->getCantidadAlmacen(), $lote->getEstanteId(), $lote->getSeccionId());
    });

    $totalEstantes = config('almacen.numero_estantes');
    $totalSecciones = config('almacen.numero_secciones');

    $estantes = [];

    for ($numEstante = 1; $numEstante <= $totalEstantes; $numEstante++) {
      $secciones = [];
      for ($numSeccion = 1; $numSeccion <= $totalSecciones; $numSeccion++) {
        $paquetesLotes = $paquetesLotesAlmacen->filter(function ($paqueteLote) use ($numEstante, $numSeccion) {
          return $paqueteLote->getEstanteId() == $numEstante && $paqueteLote->getSeccionId() == $numSeccion;
        });

        $seccionActual = $seccionesList->where('estante_id', $numEstante)->where('seccion_id', $numSeccion)->first();

        $producto = null;

        if ($seccionActual->producto != null) {
          $producto = Producto::from($seccionActual->producto->toArray());
        }

        $secciones[] = new Seccion($numSeccion, $numEstante, $producto, $paquetesLotes->all());
      }

      $estantes[] = new Estante($numEstante, $secciones);
    }
    return $estantes;
  }
}
