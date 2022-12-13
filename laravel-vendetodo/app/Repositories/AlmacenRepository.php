<?php

namespace App\Repositories;

use App\Domain\DetalleReporteOrdenEstante;
use App\Domain\EncargadoEstante;
use App\Domain\ReporteOrdenEstante;
use App\Models\EncargadoEstanteTable;
use App\Models\Lote as LoteDB;
use App\Models\Lote as LoteTable;
use Illuminate\Support\Facades\DB;
use App\Domain\Lote;
use App\Domain\PaqueteLote;
use App\Domain\Seccion;
use App\Domain\Estante;
use App\Domain\Producto;
use App\Models\AlmacenTable;
use SebastianBergmann\CodeCoverage\Driver\Selector;

class AlmacenRepository
{
  public function obtenerEstanteIdPorSurtidorId(int $surtidorId): ?int
  {
    $surtidor = DB::table('surtidores')
      ->where('surtidor_id', '=', $surtidorId)
      ->first();

    if ($surtidor == null) {
      return null;
    }

    return $surtidor->estante_id;
  }

  public function obtenerEncargado(int $encargadoId): EncargadoEstante
  {
    $encargado = EncargadoEstanteTable::query()
      ->where('usuario_id', '=', $encargadoId)
      ->with(['usuario', 'usuario.rol'])
      ->first();

    return EncargadoEstante::from($encargado->toArray());
  }

  /**
   * @return EncargadoEstante[]
   */
  public function obtenerEncargados(): array
  {
    $encargados = EncargadoEstanteTable::query()->with(['usuario'])->get();
    return EncargadoEstante::fromArray($encargados->toArray());
  }

  public function bloquearEstante(int $estante_id)
  {
    DB::table('control_almacen')
      ->where('estante_id', '=', $estante_id)
      ->update(['status' => 'ordenando']);

    DB::table('reportes_orden_estantes')
      ->where('estante_id', '=', $estante_id)
      ->update(['comenzado' => 1]);
  }

  public function desbloquearEstante(int $estante_id)
  {
    DB::table('control_almacen')
      ->where('estante_id', '=',  $estante_id)
      ->update(['status' => 'libre']);
  }

  public function guardarCambios(int $estante_id)
  {

    DB::transaction(function () use ($estante_id) {

      $detalles = DB::table('detalles_reportes_orden_estantes')
        ->where('estante_id', '=', $estante_id)
        ->orderBy('seccion_id')
        ->get();

      foreach ($detalles as $detalle) {
        //pasar de bodega a almacen
        if ($detalle->esta_en_almacen == 0) {
          DB::table('bodega')
            ->where('lote_id', '=', $detalle->lote_id)
            ->decrement('cantidad', $detalle->cantidad);

          DB::table('bodega')
            ->where('lote_id', '=', $detalle->lote_id)
            ->decrement('cantidad_disponible', $detalle->cantidad);
        }
      }

      $lotes = DB::table('control_almacen')->select([
        'lote_id',
        'cantidad',
        'cantidad_disponible',
        'seccion_id',
      ])->where('estante_id', '=', $estante_id)
        ->get();

      foreach ($lotes as $lote) {
        $permaneceEnAlmacen = $detalles->contains(function ($detalle) use ($lote) {
          return $detalle->lote_id == $lote->lote_id;
        });

        //pasar de almacen a bodega
        if (!$permaneceEnAlmacen) {
          DB::table('bodega')
            ->where('lote_id', '=', $lote->lote_id)
            ->increment('cantidad', $lote->cantidad);

          DB::table('bodega')
            ->where('lote_id', '=', $lote->lote_id)
            ->increment('cantidad_disponible', $lote->cantidad_disponible);
        }
      }

      DB::table('control_almacen')->where('estante_id', '=', $estante_id)->delete();

      $detallesPorLote = collect($detalles)->groupBy('lote_id');
      foreach ($detallesPorLote as $detalles) {

        $detalle = $detalles->first();
        $cantidad = $detalles->sum('cantidad');

        DB::table('control_almacen')
          ->insert([
            'estante_id' => $detalle->estante_id,
            'seccion_id' => $detalle->seccion_id,
            'lote_id' =>  $detalle->lote_id,
            'cantidad' => $cantidad,
            'cantidad_disponible' => $cantidad,
            'status' => 'libre',
          ]);

        $__lote = DB::table('lotes')->where('lote_id', '=', $detalle->lote_id)->first();

        DB::table('almacen')
          ->where('estante_id', '=', $detalle->estante_id)
          ->where('seccion_id', '=', $detalle->seccion_id)
          ->update([
            'producto_id' => $__lote->producto_id,
          ]);
      }


      DB::table('detalles_reportes_orden_estantes')->where('estante_id', '=', $estante_id)->delete();
      DB::table('reportes_orden_estantes')->where('estante_id', '=', $estante_id)->delete();
    });
  }

  public function descartarReporteOrdenEstante(int $estante_id)
  {
    DB::table('detalles_reportes_orden_estantes')->where('estante_id', '=', $estante_id)->delete();
    DB::table('reportes_orden_estantes')->where('estante_id', '=', $estante_id)->delete();
    $this->desbloquearEstante($estante_id);
  }

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
      DB::raw('COALESCE(bodega.cantidad, 0) as cantidadBodega'),
      DB::raw('COALESCE(control_almacen.cantidad, 0) as cantidadAlmacen'),
    ])
      ->with(['producto', 'producto.marca'])
      ->join('control_almacen', function ($join) {
        $join->on('control_almacen.estante_id', '=', 'almacen.estante_id')
          ->on('control_almacen.seccion_id', '=', 'almacen.seccion_id');
      })
      ->leftJoin('bodega', 'bodega.lote_id', '=', 'control_almacen.lote_id')
      ->join('lotes', 'lotes.lote_id', '=', 'control_almacen.lote_id')
      ->orderBy('almacen.estante_id')
      ->orderBy('almacen.seccion_id')
      ->get();

    $seccionesList = AlmacenTable::query()->with(['producto', 'producto.marca'])->orderBy('estante_id')->get();


    $lotesObj = Lote::fromArray($lotes->toArray());

    //createPaquetesLotes
    $paquetesLotesAlmacen = collect($lotesObj)->map(function ($lote) {
      return new PaqueteLote(
        $lote->getLoteId(),
        $lote,
        $lote->getCantidadAlmacen(),
        $lote->getEstanteId(),
        $lote->getSeccionId()
      );
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
