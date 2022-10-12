@extends('layouts.app')

@section('tittle','CRUD')
    
@section('content')

    <form action="{{ route('productos.index') }}">
        <div class="navbar">
            <i class="fa fa-search"></i>
            <input name="busqueda" type="text" value="{{ $busqueda }}">
        </div>
    </form>

    <div class="list-products">
        @foreach($productos as $producto)
            <article class="card">
                @if($producto->imagen_url == null)
                <div class="card-image card-image-not-found"></div>
                @else
                    <div class="card-image">
                        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}">
                    </div>
                @endif
                <div class="card-info">
                    <h1 class="card-title">{{ $producto->nombre }}</h1>
                    <p class="card-price">${{ number_format($producto->precio, 2) }}</p>
                    <p class="card-brand">{{ $producto->marca->nombre }}</p>
                </div>
                <div class="card-actions">
                    <a class="btn-action" href="#"><i class="fa fa-pencil"></i> Editar</a>
                    <a class="btn-action" href="#"><i class="fa fa-trash"></i> Eliminar</a>
                </div>
            </article>
        @endforeach
    </div>
@endsection