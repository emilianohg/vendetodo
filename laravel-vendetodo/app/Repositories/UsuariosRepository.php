<?php

namespace App\Repositories;

use App\Domain\Usuario;
use App\Models\User as UsuarioTable;

class UsuariosRepository
{
    public function obtenerPorId(int $usuarioId) {
        $usuarioTable = UsuarioTable::with(['rol', 'direccion', 'metodo_pago'])->find($usuarioId);
        return Usuario::from($usuarioTable->toArray());
    }
}