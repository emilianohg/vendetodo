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
              <a href="{{route('products.index')}}" class="logo">
                  <i class="fa fa-shopping-cart"></i><span class="logo-text">VENDETODO</span>
              </a>
              <span class="btn-user">
                  <i class="fa fa-user"></i> <span class="user-name">Administrador</span>
              </span>
          </div>
    </nav>
    <main>
        @yield('content')
    </main>
  </body>
</html>