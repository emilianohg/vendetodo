<?php

namespace App\Repositories;

use App\Domain\PreasignacionOrden;
use App\Models\OrdenesPreasignadasTable;
use Illuminate\Support\Facades\DB;

class OrdenesPreasignadasRepository
{
    public function obtener(int $surtidorId): ?PreasignacionOrden
    {
        $preasignacionOrden = OrdenesPreasignadasTable::query()
            ->where('surtidor_id', '=', $surtidorId)
            ->where('status', '=', 'pendiente')
            ->first();

        if ($preasignacionOrden == null) {
            return null;
        }

        return PreasignacionOrden::from($preasignacionOrden->toArray());
    }

    public function validarAsignacion(int $ordenId, int $surtidorId): bool
    {
        return DB::table('ordenes_preasignadas')
            ->where('orden_id', '=', $ordenId)
            ->where('surtidor_id', '=', $surtidorId)
            ->where('status', '=', 'pendiente')
            ->exists();
    }

    public function registrar(int $ordenId, int $surtidorId)
    {
        DB::transaction(function () use ($ordenId, $surtidorId) {
            $lastOrdenPreasignadas = DB::table('ordenes_preasignadas')
                ->select([
                    'orden_id',
                    'surtidor_id',
                    DB::raw('COALESCE(MAX(intento), 0) as intento'),
                ])
                ->groupBy([
                    'orden_id',
                    'surtidor_id',
                ])
                ->where('orden_id', '=', $ordenId)
                ->where('surtidor_id', '=', $surtidorId)
                ->first();

            $intento = 1;

            if ($lastOrdenPreasignadas != null) {
                $intento = $lastOrdenPreasignadas->intento + 1;
            }

            DB::table('surtidores')
                ->where('surtidor_id', '=', $surtidorId)
                ->update([
                    'status' => 'ocupado',
                ]);

            DB::table('ordenes_preasignadas')->insert([
                'orden_id' => $ordenId,
                'surtidor_id' => $surtidorId,
                'intento' => $intento,
                'fecha' => now(),
                'status' => 'pendiente',
            ]);
        });

    }

}