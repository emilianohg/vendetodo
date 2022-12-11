<?php

namespace App\Repositories;

use App\Domain\Usuario;
use App\Models\User as UsuarioTable;

class UsuariosRepository
{
    public function obtenerPorId(int $usuarioId) {
        $usuarioTable = UsuarioTable::with([
            'rol',
            'direccion',
            'direcciones',
            'metodo_pago',
        ])->find($usuarioId);
        return Usuario::from($usuarioTable->toArray());
    }

    public function actualizarDireccion(int $usuarioId, int $direccionId) {
        UsuarioTable::query()
            ->where('usuario_id', '=', $usuarioId)
            ->update([
               'direccion_id' => $direccionId,
            ]);
    }
}