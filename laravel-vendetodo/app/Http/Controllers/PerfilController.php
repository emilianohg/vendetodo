<?php

namespace App\Http\Controllers;

use App\Domain\DominioUsuarios;

class PerfilController extends Controller
{
    private DominioUsuarios $dominioUsuarios;

    public function __construct()
    {
        $this->dominioUsuarios = new DominioUsuarios();
    }

    public function index() {
        $usuarioId = auth()->user()->getAuthIdentifier();
        $usuario = $this->dominioUsuarios->consultarPerfil($usuarioId);
        return view('auth.perfil', ['usuario' => $usuario]);
    }

}
