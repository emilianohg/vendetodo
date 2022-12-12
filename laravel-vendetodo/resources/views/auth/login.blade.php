@extends('layouts.auth')

@section('style')
    <link rel="stylesheet" href="/css/login.css">
@endsection

@section('content')
<div class="login-content">
    <form action="{{route('login.store')}}" method="POST" class="form-login">
        @csrf
        <h1 class="login-tittle">Iniciar Sesión</h1>
        <div class="email-container">
            <label for="login-input-email" class="login-label-email">Correo electrónico:</label>
            <input type="email" name="email" class="login-input-email" required>
            @if($errors->has('email'))
                <div class="error">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="password-container">
            <label class="login-label-password" for="login-input-password">Contraseña:</label>
            <input class="login-input-password" type="password" name="password" id="password" required>
            @if($errors->has('password'))
                <div class="error">{{ $errors->first('password') }}</div>
            @endif
        </div>
        @if(session()->has('message'))
            <div class="messageerror">
                <span class="error">{{ session()->get('message') }}</span>
            </div>
        @endif
        <div class="button-container">
            <button type="submit" name="login" class="btn-login">Iniciar Sesión</button>
        </div>
    </form>
</div>
@endsection