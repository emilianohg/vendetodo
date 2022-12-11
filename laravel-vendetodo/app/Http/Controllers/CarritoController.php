<?php

namespace App\Http\Controllers;

use App\Domain\DominioCarrito;
use App\Http\Requests\GuardarLineaCarritoRequest;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    private $dominioCarrito;

    function __construct()
    {
      $this->dominioCarrito = new DominioCarrito();
    }

    public function index() 
    {
        $carrito = $this->dominioCarrito->obtenerCarrito(auth()->user()->getAuthIdentifier());
        return view('carrito.index', ['carrito' => $carrito]);
    }

    public function guardarLineaCarrito(Request $request) 
    {
        $cantidad = $request->get('cantidad');
        $this->dominioCarrito->agregarProductoCarrito(
            auth()->user()->getAuthIdentifier(), 
            $request->get('producto_id'), 
            $request->get('proveedor_id'),
            $request->get('cantidad')
        );

        $message = 'Se agregó ' . $cantidad . ' unidades al carrito de compra.';
        if ($cantidad == 1) {
          $message = 'Se agregó 1 unidad al carrito de compra.';
        }
        
        return back()->with('message-info', $message);
    }

    public function borrarLineaCarrito($id)
    {
        $this->dominioCarrito->borrarLineaCarrito($id);
        return back()->with('message-info', 'Artículo en el carrito de compra eliminado.');
    }
}
