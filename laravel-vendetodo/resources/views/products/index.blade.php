@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="/css/productos-index.css">
    <script src="js/index.js"></script>
@endsection

@section('content')
    <div class="divider">
        <!--Patron NEWS-->
        <div class="news-pattern">
        <div class="news-pattern-content">
            <img class="news-pattern-img" >
        </div>
        </div>
        <hr>
        <div class="tittle-products-container">
        <h1 class="list-products-tittle">Catalogo de Productos</h1>
        </div>
        
        <div class="list-products">
            @foreach($productos->getData() as $producto)
                <a href="{{route('productos.show', [ 'producto' => $producto->getId() ])}}">
                    <article class="card">
                        @if($producto->getImagenUrl() == null)
                        <div class="card-image card-image-not-found"></div>
                        @else
                            <div class="card-image">
                                <img src="{{ $producto->getImagenUrl() }}" alt="{{ $producto->getNombre() }}">
                            </div>
                        @endif
                        <div class="card-info">
                            <h1 class="card-title" title="{{ $producto->getNombre() }}">{{ $producto->getNombre() }}</h1>
                            <p class="card-price">${{ number_format($producto->getPrecio(), 2) }}</p>
                            <p class="card-brand">{{ $producto->getMarca()->getNombre() }}</p>
                        </div>
                    </article>
                </a>
            @endforeach
        </div>
        <div class="pagination">
            <div class="container-page-numbers">
                @if ($productos->getPrevPageUrl() != null)
                    <a href="{{ route('productos.index', ['page' => $productos->getCurrentPage() - 1, 'busqueda' => $busqueda ]) }}" class="page-actions mr-4">Anterior</a>
                @endif
                @foreach(range($productos->getLeftBound(), $productos->getRightBound()) as $numberPage)
                    <a class="page-number
                    @if($productos->getCurrentPage() == $numberPage) page-number-selected @endif"
                    href="{{ route('productos.index', ['page' => $numberPage, 'busqueda' => $busqueda ]) }}"
                    >
                        {{ $numberPage }}
                    </a>
                @endforeach
                @if ($productos->getNextPageUrl() != null)
                    <a href="{{ route('productos.index', ['page' => $productos->getCurrentPage() + 1, 'busqueda' => $busqueda ]) }}" class="page-actions  ml-4">Siguiente</a>
                @endif
            </div>
        </div>
    </div>
@endsection
