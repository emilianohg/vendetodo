<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vende Todo</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/d62c51cf16.js" crossorigin="anonymous"></script>
  </head>
  <body>
      @yield('style')
      <nav class="main-navbar">
          <div class="main-navbar-content">
              <img src="https://media.discordapp.net/attachments/1031018534416941168/1035346439989117049/logo.png?width=472&height=472" class="logo-img">
              <a href="{{route('products.index')}}" class="logo">Vende Todo</a>
          </div>
          <div class="controls-products">
            <form class="navbar" action="{{ route('products.index') }}">
                <i class="fa fa-search"></i>
                <input name="busqueda" type="text" value="{{ $busqueda ?? '' }}" placeholder="Buscar productos...">
            </form>
          </div>
          <div class="right-side-navbar-content">
            @if(auth()->user() == null)
            <div class="btn-user-panel">
                <a href="{{ route('login') }}" class="btn-user">
                  <span class="user-name-login">Iniciar Sesión</span>
                </a>
            </div>
            @else
              <div class="btn-user-panel">
                  <a href="{{ route('perfil') }}" class="btn-user">
                      <i class="fa fa-user"></i>
                      <span class="user-name-login">Hola, {{ auth()->user()->nombre }}</span>
                  </a>
              </div>
            @endif
            <div href="#" class="btn-shoppingcart">
              <i class="btn-shoppingcart-icon">🛒</i>
            </div>
          </div>
        </nav>
    <main class="main-container">
          @yield('content')
    </main>
  </body>
</html>