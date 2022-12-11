<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vende Todo | Dashboard</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/d62c51cf16.js" crossorigin="anonymous"></script>
</head>
<body>
@yield('style')
<nav class="main-navbar">
    <div class="main-navbar-content">
        <img src="https://media.discordapp.net/attachments/1031018534416941168/1035346439989117049/logo.png?width=472&height=472" class="logo-img">
        @if(auth()->user()->rol_id == 2)
        <a href="{{route('surtidor.home')}}" class="logo">Vende Todo</a>
        @else
        <a href="{{route('productos.index')}}" class="logo">Vende Todo</a>
        @endif
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
    $messageMainClose.addEventListener('click', function (event) {
        $messageMain.remove();
    })
</script>
</body>
</html>