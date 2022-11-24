@extends('layouts.app')

@section('style')
    <style>

    </style>
@endsection

@section('content')
<div class="container">
    Hola, {{ auth()->user()->nombre }}
    <form action="{{ route('login.logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</div>
@endsection