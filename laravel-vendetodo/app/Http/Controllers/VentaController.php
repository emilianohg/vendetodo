<?php

namespace App\Http\Controllers;

use App\Domain\DominioCarrito;
use App\Domain\DominioVenta;
use Illuminate\Http\Request;
use App\Domain\DominioUsuarios;

class VentaController extends Controller
{
  private DominioVenta $dominioVenta;

  function __construct()
  {
    $this->dominioCarrito = new DominioCarrito();
    $this->dominioUsuarios = new DominioUsuarios();
    $this->dominioVenta = new DominioVenta();
  }

  public function index()
  {

    $usuarioId = auth()->user()->getAuthIdentifier();
    return view('compra.details', $this->dominioVenta->confirmar($usuarioId));
  }

  public function realizarVenta(Request $request)
  {
      $usuarioId = auth()->user()->getAuthIdentifier();
      $metodoPagoId = $request->get('metodo_pago_id');
      $direccionId = $request->get('direccion_id');
      $this->dominioVenta->realizarVenta($usuarioId, $metodoPagoId, $direccionId);
  }

  public function confirm()
  {
    $carrito = $this->dominioCarrito->obtenerCarrito(auth()->user()->getAuthIdentifier());
    $usuario = $this->dominioUsuarios->consultarPerfil(auth()->user()->getAuthIdentifier());
    return view('compra.confirm', ['carrito' => $carrito], ['usuario' => $usuario]);
  }
}
