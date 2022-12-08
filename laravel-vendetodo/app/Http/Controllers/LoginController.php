<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function store(StoreLoginRequest $request) {
        $credentials = $request->all(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return redirect()->back()->with([
                'message' => 'Correo electrónico o contraseña incorrectos.',
            ]);
        }
        //surtidor
        if (auth()->user()->rol_id == 2){
            return view('surtidos.index');
        }
        //encargado de estante
        if (auth()->user()->rol_id == 4){
            return redirect()->route('encargado-estante.home');
        }
        //cliente
        if (auth()->user()->rol_id == 5){
            return redirect()->route('products.index');
        }
         //administrador
         if (auth()->user()->rol_id == 1){
            return redirect()->route('tienda.index');
        }       

    }

    public function logout() {
        Auth::logout();
        return redirect(route('products.index'));
    }
}
