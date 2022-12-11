<?php

namespace App\Http\Controllers;

use App\Domain\DominioCarrito;
use App\Domain\DominioVenta;
use App\Domain\PagoNoHabilitadoException;
use App\Domain\ProductoAgotadoException;
use Illuminate\Http\Request;
use App\Domain\DominioUsuarios;

class VentaController extends Controller
{
  private DominioVenta $dominioVenta;

  function __construct()
  {
    $this->dominioVenta = new DominioVenta();
  }

  public function index()
  {
    $usuarioId = auth()->user()->getAuthIdentifier();
    return view('compra.details', $this->dominioVenta->visualizar($usuarioId));
  }

  public function realizarVenta(Request $request)
  {
      $usuarioId = auth()->user()->getAuthIdentifier();
      $metodoPagoId = $request->get('metodo_pago_id');
      $direccionId = $request->get('direccion_id');

      try {
          $pago = $this->dominioVenta->realizarVenta($usuarioId, $metodoPagoId, $direccionId);

          return redirect()->route('pago', ['referencia' => $pago->getReferencia()]);
      } catch (ProductoAgotadoException $e) {
          return redirect()->route('carrito')->with('message-error', $e->getMessage());
      }
  }

  public function confirmarPago(Request $request)
  {
      $referencia = $request->get('referencia');

      try {
          $orden = $this->dominioVenta->confirmar($referencia);
          return view('compra.confirm', ['orden' => $orden]);
      } catch (PagoNoHabilitadoException $e) {
          return redirect()->back()->with('message-error', $e->getMessage());
      }
  }

}
