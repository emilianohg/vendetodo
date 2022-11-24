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

        // TODO: Retornar pagina dependiendo el rol
        return redirect(route('productos.index'));
    }

    public function logout() {
        Auth::logout();
        return redirect(route('productos.index'));
    }
}
