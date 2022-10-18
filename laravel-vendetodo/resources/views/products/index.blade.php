@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="/css/productos-index.css">
@endsection

@section('content')

    <div class="controls-products">
        <form class="navbar" action="{{ route('productos.index') }}">
            <i class="fa fa-search"></i>
            <input name="busqueda" type="text" value="{{ $busqueda }}">
        </form>

        <a class="btn" href="{{route('productos.create')}}">
            <i class="fa fa-add"></i> Añadir
        </a>
    </div>

    <div class="list-products">
        @foreach($productos->getData() as $producto)
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
                <div class="card-actions">
                    <a class="btn-action btn-action-primary" href="{{route('productos.edit', [ 'producto' => $producto->getId() ])}}"><i class="fa fa-pencil"></i></a>
                    <form action="{{route('productos.destroy', $producto->getId())}}"  method="POST" >
                        @csrf
                        {{ method_field('DELETE') }}
                        <input class="btn-action btn-action-danger" type="submit" onclick="return confirm('¿Quieres borrar?')" value="🗑️">
                    </form>
                </div>
            </article>
        @endforeach
    </div>
    <div class="pagination">
        <div class="container-page-numbers">
            @if ($productos->getPrevPageUrl() != null)
                <a href="{{ route('productos.index', ['page' => $productos->getCurrentPage() - 1, 'busqueda' => $busqueda ]) }}" class="page-actions">Anterior</a>
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
                <a href="{{ route('productos.index', ['page' => $productos->getCurrentPage() + 1, 'busqueda' => $busqueda ]) }}" class="page-actions">Siguiente</a>
            @endif
        </div>
    </div>
@endsection
