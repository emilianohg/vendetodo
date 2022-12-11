<?php

namespace App\Http\Middleware;

use App\Domain\DominioUsuarios;
use App\Domain\Rol;
use Closure;
use Illuminate\Http\Request;

class RolMiddleware
{
    private DominioUsuarios $dominioUsuarios;

    public function __construct()
    {
        $this->dominioUsuarios = new DominioUsuarios();
    }

    public function handle(Request $request, Closure $next, string $rol)
    {
        $rolId = match ($rol) {
            'administrador' => Rol::ADMINISTRADOR,
            'surtidor' => Rol::SURTIDOR,
            'encargado_estante' => Rol::ENCARGADO_ESTANTE,
            'encargado_almacen' => Rol::ENCARGADO_ALMACEN,
            'cliente' => Rol::CLIENTE,
        };

        $usuarioId = auth()->user()->getAuthIdentifier();

        $usuario = $this->dominioUsuarios->consultarPerfil($usuarioId);

        if ($usuario->getRolId() == $rolId) {
            return $next($request);
        }

        return back()->with('message-error', 'No cuentas con el rol correcto para entrar a este sitio');
    }
}
