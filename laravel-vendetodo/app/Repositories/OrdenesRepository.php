<?php

namespace App\Repositories;

use App\Domain\Orden;
use App\Models\OrdenTable;

class OrdenesRepository
{

    /**
     * @param int|null $limit
     * @return Orden[]
     */
    public function getOrdenesPendientes(?int $limit = null): array {
        $ordenesQuery = OrdenTable::query()
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
            ->where('status', 'pendiente')
            ->whereNull('surtidor_id')
            ->orderBy('fecha_creacion');

        if ($limit != null) {
            $ordenesQuery->limit($limit);
        }

        $ordenes = $ordenesQuery->get();

        return Orden::fromArray($ordenes->toArray());
    }
}