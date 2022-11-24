<?php

namespace App\Http\Controllers;

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
            // TODO: Mensaje de error en login
            return ;
        }

        // TODO: Retornar pagina dependiendo el rol
        return redirect(route('productos.index'));
    }

    public function logout() {
        Auth::logout();
        return redirect(route('productos.index'));
    }
}
