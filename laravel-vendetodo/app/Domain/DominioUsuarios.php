<?php

namespace App\Domain;

use App\Repositories\UsuariosRepository;

class DominioUsuarios
{
    private UsuariosRepository $usuariosRepository;

    public function __construct()
    {
        $this->usuariosRepository = new UsuariosRepository();
    }

    public function consultarPerfil(int $usuarioId): Usuario
    {
        return $this->usuariosRepository->obtenerPorId($usuarioId);
    }
}