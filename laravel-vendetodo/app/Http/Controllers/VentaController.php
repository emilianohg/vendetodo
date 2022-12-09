<?php

namespace App\Http\Controllers;

use App\Domain\DominioCarrito;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\DominioUsuarios;

class VentaController extends Controller
{
  private $dominioCarrito;
  private DominioUsuarios $dominioUsuarios;

  function __construct()
  {
    $this->dominioCarrito = new DominioCarrito();
    $this->dominioUsuarios = new DominioUsuarios();
  }

  public function index()
  {
    $carrito = $this->dominioCarrito->obtenerCarrito(auth()->user()->getAuthIdentifier());
    $usuarioId = auth()->user()->getAuthIdentifier();
    $usuario = $this->dominioUsuarios->consultarPerfil($usuarioId);
    return view('compra.details', ['carrito' => $carrito], ['usuario' => $usuario]);
  }
}