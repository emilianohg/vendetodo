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

    public function generarOrdenProductos()
    {
        $usuarioId = auth()->user()->getAuthIdentifier();
        $this->dominioEstante->generarOrdenProductos($usuarioId);
        return redirect()->route('encargado.obtenerOrden');
    }

    public function obtenerOrdenProductos() {
        $usuarioId = auth()->user()->getAuthIdentifier();
        $reporte = $this->dominioEstante->obtenerOrdenProductos($usuarioId);
        return view('estantes.reporte', ['reporte' => $reporte]);
    }

    public function comenzarOrdenamiento()
    {
        $usuarioId = auth()->user()->getAuthIdentifier();
        $this->dominioEstante->comenzarOrdenamiento($usuarioId);
        return redirect()->route('encargado.obtenerOrden');
    }

    public function terminarOrdenamiento()
    {
        $usuarioId = auth()->user()->getAuthIdentifier();
        $this->dominioEstante->terminarOrdenamiento($usuarioId);
        return redirect()->route('encargado-estante.home');
    }

    public function cancelarOrdenamiento()
    {
        $usuarioId = auth()->user()->getAuthIdentifier();
        $this->dominioEstante->cancelarOrdenamiento($usuarioId);
        return redirect()->route('encargado-estante.home');
    }

    public function descartarReporteOrden($id)
    {
        $this->dominioEstante->cancelarOrdenamiento($id);
        return redirect()->route('encargado-estante.home');
    }
}
