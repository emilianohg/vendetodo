<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vende Todo</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                @if(auth()->user()->rol_id == 2)
                <a class="btn-user" href="{{route('surtidor.home')}}">
                @elseif(auth()->user()->rol_id == 4)
                <a class="btn-user" href="{{route('encargado-estante.home')}}">
                @endif
                <i class="fa-solid fa-gauge-high"></i>
                Dashboard
                </a>
              </div>
              <div class="btn-user-panel">
                  <a href="{{ route('perfil') }}" class="btn-user">
                      <i class="fa fa-user"></i>
                      <span class="nowrap user-name-login">{{ auth()->user()->nombre }}</span>
                  </a>
              </div>
            @endif
            <div class="btn-shoppingcart">
                <a href="{{ route('carrito') }}">
              <i class="btn-shoppingcart-icon">🛒</i>
                </a>
            </div>
          </div>
        </nav>
    <main class="main-container">
        @if(session()->has('message-error'))
        <div id="message-main" class="message message-error">
            <p>{{ session()->get('message-error') }}</p>
            <span id="message-main-close" class="message-close">×</span>
        </div>
        @endif
        @if(session()->has('message-info'))
            <div id="message-main" class="message message-info">
                <p>{{ session()->get('message-info') }}</p>
                <span id="message-main-close" class="message-close">×</span>
            </div>
        @endif
          @yield('content')
    </main>

      <script>
          $messageMain = document.getElementById('message-main');
          $messageMainClose = document.getElementById('message-main-close');
          if ($messageMainClose != null) {
              $messageMainClose.addEventListener('click', function (event) {
                  $messageMain.remove();
              })
          }
      </script>
    
  </body>
</html>
