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
              <img src="css/images/logo.png" class="logo-img">
              <a href="{{route('products.index')}}" class="logo">Vende Todo</a>
          </div>
          <div class="right-side-navbar-content">
            <div class="btn-user-panel">
                <a href="#" class="btn-user">
                  </i><span class="user-name-login">Iniciar Sesión</span>
                </a>
            </div>
            <div href="#" class="btn-shoppingcart">
              <i class="btn-shoppingcart-icon">🛒</i>
            </div>
          </div>
          </div>
        </nav>
    <main>
        <div class="divider">
          @yield('content')
        </div>
    </main>
  </body>
</html>