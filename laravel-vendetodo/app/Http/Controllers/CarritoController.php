<?php

namespace App\Http\Controllers;

use App\Domain\DominioCarrito;
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
        return view('carrito.index');
    }

    public function guardarLineaCarrito(Request $request) 
    {
        //si el usuario está loguado lo guarda en BS y si no en LocalStorage
        //$this->dominioCarrito->agregarProductoCarrito(auth()->user()->getAuthIdentifier(), );
    }
}
