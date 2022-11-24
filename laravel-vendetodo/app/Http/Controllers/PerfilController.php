<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginRequest;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function index() {
        return view('auth.perfil');
    }

}
