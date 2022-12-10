<?php

namespace App\Repositories;

use App\Domain\Pago;
use App\Models\PagoTable;

class PagosRepository
{
    public function cancelarPagosPendientes(int $usuarioId): void
    {
        PagoTable::query()
            ->where('usuario_id', '=', $usuarioId)
            ->where('status', '=', Pago::PENDIENTE)
            ->update([
                'status' => Pago::CANCELADO,
            ]);
    }

    public function registrar(int $usuarioId, int $metodoPagoId, float $importe, string $referencia): Pago
    {
        $this->cancelarPagosPendientes($usuarioId);
        $pago = PagoTable::query()->create([
            'metodo_pago_id' => $metodoPagoId,
            'referencia' => $referencia,
            'usuario_id' => $usuarioId,
            'status' => Pago::PENDIENTE,
            'importe' => $importe,
            'fecha_solicitud' => now(),
            'fecha_pago' => null,
        ]);
        return Pago::from($pago->toArray());
    }

    public function buscarPorReferencia(string $referencia): Pago
    {
        $pago = PagoTable::query()->where('referencia', '=', $referencia)->first();
        return Pago::from($pago->toArray());
    }

    public function confirmar(string $referencia): Pago
    {
        $pago = PagoTable::query()
            ->where('referencia', '=', $referencia)
            ->first();

        $pago->status = Pago::PAGADO;

        $pago->save();

        return Pago::from($pago->toArray());
    }
}