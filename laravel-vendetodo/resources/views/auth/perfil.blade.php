@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="/css/perfil.css">
@endsection

@section('content')
<div class="container">
    <div class="profile-container">
      <div class="img-user-container">
        <img class="user-img" src="https://www.pngall.com/wp-content/uploads/5/User-Profile-PNG-High-Quality-Image.png" alt="">
      </div>
      <div class="info-user-container">
        <div class="user-name">
          <h2 class="tittle">Nombre de usuario:</h2>
          <p>{{ auth()->user()->nombre }}</p>
        </div>
        <div class="user-email">
          <h2 class="tittle">Correo:</h2>
          <p>{{ auth()->user()->email }}</p>
        </div>
        <div class="btn-container">
              <form action="{{ route('login.logout') }}" method="POST">
              @csrf
                <button class="btn-user-logout" type="submit">Cerrar sesión</button>
              </form>
        </div>
    </div>
  </div>
@endsection