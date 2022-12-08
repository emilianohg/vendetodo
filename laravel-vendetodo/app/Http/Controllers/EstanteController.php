<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EstanteController extends Controller
{
    public function orden()
    {
        return view('estantes.orden');
    }

    public function index()
    {
        return view('estantes.index');
    }

    public function dashboard()
    {
        return view('estantes.dashboard');
    }
}
