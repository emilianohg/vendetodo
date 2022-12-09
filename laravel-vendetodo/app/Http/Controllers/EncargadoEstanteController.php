<?php

namespace App\Http\Controllers;

use App\Domain\DominioEstante;
use Illuminate\Http\Request;

class EncargadoEstanteController extends Controller
{
    private DominioEstante $dominioEstante;

    public function __construct()
    {
        $this->dominioEstante = new DominioEstante();
    }

    public function home()
    {
        $usuarioId = auth()->user()->getAuthIdentifier();
        $estante = $this->dominioEstante->obtenerEstantePorEncargadoId($usuarioId);
        return view('estantes.index', ['estante' => $estante]);
    }

    public function obtenerOrdenProductos($id)
    {
        $reporte = $this->dominioEstante->obtenerOrdenProductos($id);
        return view('estantes.reporte', ['reporte' => $reporte]);
    }
}
