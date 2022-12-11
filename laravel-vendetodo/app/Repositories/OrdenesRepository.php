<?php

namespace App\Repositories;

use App\Domain\DetalleOrden;
use App\Domain\LineaCarrito;
use App\Domain\Orden;
use App\Domain\Pago;
use App\Domain\ResumenOrdenSurtidor;
use App\Domain\Usuario;
use App\Models\DetalleOrdenTable;
use App\Models\OrdenTable;
use Illuminate\Support\Facades\DB;

class OrdenesRepository
{
    public function crear(Usuario $usuario, Pago $pago): Orden
    {
        $orden = OrdenTable::query()->create([
            'usuario_id' => $usuario->getUsuarioId(),
            'status' => Orden::PENDIENTE,
            'pago_id' => $pago->getPagoId(),
            'fecha_creacion' => now(),
            'direccion_envio_id' => $usuario->getDireccion()->getDireccionId(),
        ]);

        return $this->buscarPorId($orden->orden_id);
    }

    public function agregarDetalle(int $ordenId, LineaCarrito $lineaCarrito): DetalleOrden
    {
        DetalleOrdenTable::query()->create([
            'orden_id' => $ordenId,
            'producto_id' => $lineaCarrito->getProductoId(),
            'proveedor_id' => $lineaCarrito->getProveedorId(),
            'cantidad' => $lineaCarrito->getCantidad(),
            'precio' => $lineaCarrito->getProducto()->getPrecio(),
        ]);

        return new DetalleOrden(
            orden_id: $ordenId,
            producto_id: $lineaCarrito->getProductoId(),
            proveedor_id: $lineaCarrito->getProveedorId(),
            cantidad: $lineaCarrito->getCantidad(),
            precio: $lineaCarrito->getProducto()->getPrecio(),
            producto: $lineaCarrito->getProducto(),
        );
    }

    public function buscarPorId(int $ordenId): Orden
    {
        $ordenRecord = OrdenTable::query()
            ->select([
                'ordenes.*',
            ])
            ->with([
                'detalle',
                'detalle.producto',
                'direccion',
                'cliente',
                'cliente.rol',
                'surtidor',
                'surtidor.rol',
                'pago',
            ])
            ->where('orden_id', '=', $ordenId)
            ->first();

        return Orden::from($ordenRecord->toArray());
    }

    public function buscarOrdenActivaSurtidor(int $surtidorId): ?Orden
    {
        $ordenes = $this->buscarPorSurtidorId($surtidorId, Orden::EN_PROCESO);

        if (count($ordenes) == 0) {
            return null;
        }

        return $ordenes[0];
    }

    /**
     * @param int $surtidorId
     * @param string|null $status
     * @return Orden[]
     */
    public function buscarPorSurtidorId(int $surtidorId, ?string $status = null): array
    {
        $ordenQuery = OrdenTable::query()
            ->select([
                'ordenes.*',
            ])
            ->with([
                'detalle',
                'detalle.producto',
                'direccion',
                'cliente',
                'cliente.rol',
                'surtidor',
                'surtidor.rol',
                'pago',
            ])
            ->where('surtidor_id', '=', $surtidorId);

        if ($status != null) {
            $ordenQuery->where('status', '=', $status);
        }

        $ordenes = $ordenQuery->get();

        return Orden::fromArray($ordenes->toArray());
    }

    /**
     * Una orden pendiente es una orden que no se ha asignado a un surtidor
     *
     * El atributo surtidor_id es null
     * y no cuenta con ordenes preasignadas pendientes
     *
     * @param int|null $limit
     * @return Orden[]
     */
    public function getOrdenesPendientes(?int $limit = null): array {
        $ordenesQuery = OrdenTable::query()
            ->select([
                'ordenes.*',
            ])
            ->with([
                'detalle',
                'detalle.producto',
                'direccion',
                'cliente',
                'cliente.rol',
                'surtidor',
                'surtidor.rol',
                'pago',
            ])
            ->leftJoin('ordenes_preasignadas', function ($join) {
                $join->on('ordenes_preasignadas.orden_id', '=', 'ordenes.orden_id')
                    ->where('ordenes_preasignadas.status', '=', 'pendiente');
            })
            ->where('ordenes.status', 'pendiente')
            ->whereNull('ordenes.surtidor_id')
            ->whereNull('ordenes_preasignadas.orden_id')
            ->orderBy('fecha_creacion');

        if ($limit != null) {
            $ordenesQuery->limit($limit);
        }

        $ordenes = $ordenesQuery->get();

        return Orden::fromArray($ordenes->toArray());
    }

    /**
     * Un surtidor disponible es aquel que no tiene ordenes asignadas y
     * no esta surtiendo una orden actualmente. La lista retornada va de
     * menor cantidad de trabajo a mayor
     *
     * @param string $fechaInicial
     * @param string $fechaFinal
     * @return ResumenOrdenSurtidor[]
     */
    public function getSurtidoresDisponibles(
        string $fechaInicial,
        string $fechaFinal,
    ) : array
    {
        $resumenQuery = DB::table('surtidores')->select([
            DB::raw("COALESCE(COUNT(ordenes.orden_id), 0) as cantidad_ordenes"),
            'surtidores.surtidor_id',
        ])
        ->leftJoin('ordenes', function ($join) use ($fechaInicial, $fechaFinal) {
            $join->on('ordenes.surtidor_id', '=', 'surtidores.surtidor_id')
                ->whereIn('ordenes.status', ['surtida', 'finalizada'])
                ->whereBetween('ordenes.fecha_creacion', [$fechaInicial, $fechaFinal]);
        })
        ->where('surtidores.status', '=', 'libre')
        ->groupBy('surtidores.surtidor_id')
        ->orderByRaw('COALESCE(COUNT(ordenes.orden_id), 0) asc');

        $resumen = $resumenQuery->get();

        return ResumenOrdenSurtidor::fromArray($resumen->toArray());
    }

    public function asignarSurtidor(int $ordenId, int $surtidorId): void
    {
        DB::transaction(function () use ($ordenId, $surtidorId) {
            OrdenTable::query()
                ->where('orden_id', '=', $ordenId)
                ->update([
                    'surtidor_id' => $surtidorId,
                    'status' => Orden::EN_PROCESO,
                ]);

            DB::table('ordenes_preasignadas')
                ->where('orden_id', '=', $ordenId)
                ->where('surtidor_id', '=', $surtidorId)
                ->where('status', '=', 'pendiente')
                ->update([
                    'status' => 'aceptada',
                ]);

            DB::table('surtidores')
                ->where('surtidor_id', '=', $surtidorId)
                ->update([
                    'status' => 'libre'
                ]);
        });
    }

    public function actualizarStatus(int $ordenId, string $status)
    {
        OrdenTable::query()
            ->where('orden_id', '=', $ordenId)
            ->update([
                'status' => $status,
            ]);
    }

    public function surtir(int $ordenId) {
        $detalles = DB::table('detalle_orden')->where('orden_id', '=', $ordenId)->get();
        foreach ($detalles as $detalle) {
            DB::table('proveedores_productos')
                ->where('producto_id', '=', $detalle->producto_id)
                ->where('proveedor_id', '=', $detalle->proveedor_id)
                ->decrement('cantidad', $detalle->cantidad);
        }
        $this->actualizarStatus($ordenId, Orden::SURTIDA);
    }
}