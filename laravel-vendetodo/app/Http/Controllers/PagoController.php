<?php

namespace App\Http\Controllers;

use App\Domain\DominioPago;
use App\Domain\MetodoPago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    private DominioPago $dominioPago;

    public function __construct()
    {
        $this->dominioPago = new DominioPago();
    }

    public function show($referencia) {
        $pago = $this->dominioPago->consultar($referencia);

        if ($pago->getMetodoPagoId() == MetodoPago::PAYPAL) {
            return view('pagos.paypal', ['pago' => $pago]);
        }

        return view('pagos.tarjetas', ['pago' => $pago]);
    }

    public function confirmar(Request $request)
    {
        $referencia = $request->get('referencia');
        $pago = $this->dominioPago->confirmar($referencia);
        //
        return redirect()->route('compra.confirm');
    }
}
