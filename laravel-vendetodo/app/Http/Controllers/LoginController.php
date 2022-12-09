<?php

namespace App\Http\Controllers;

use App\Domain\Rol;
use App\Http\Requests\StoreLoginRequest;
use Illuminate\Support\Facades\Auth;

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

        $route = match (auth()->user()->rol_id) {
            Rol::SURTIDOR => 'surtidor.home',
            Rol::ENCARGADO_ESTANTE => 'encargado-estante.home',
            Rol::CLIENTE => 'products.index',
            Rol::ADMINISTRADOR => 'surtidor.index',
            default => 'products.index',
        };

        return redirect()->route($route);
    }

    public function logout() {
        Auth::logout();
        return redirect(route('products.index'));
    }
}
