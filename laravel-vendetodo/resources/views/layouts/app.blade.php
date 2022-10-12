<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('tittle') - Vende Todo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/d62c51cf16.js" crossorigin="anonymous"></script>
  </head>
  <body>
      <nav class="h-16 flex justify-end py-4 px-16">
      <a href="{{route('products.crud')}}" class="border border-blue-500 rounded px-4 pt-1 h-10 bg-white text-blue-500 font-semibold mx-2">Vende Todo</a>
      <a href="{{route('productos.create')}}" class="border border-blue-500 rounded px-4 pt-1 h-10 bg-white text-blue-500 font-semibold mx-2">Añadir</a>
    </nav>
    <main>@yield('content')</main>
  </body>
</html>