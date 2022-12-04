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
        //si el usuario está loguado lo guarda en BD y si no en LocalStorage
        $this->dominioCarrito->agregarProductoCarrito(
            auth()->user()->getAuthIdentifier(), 
            $request->get('producto_id'), 
            $request->get('proveedor_id'),
            $request->get('cantidad')
        );
        
        return back();
    }

    public function borrarLineaCarrito($id)
    {
        $this->dominioCarrito->borrarLineaCarrito($id);
        return back();
    }
}
