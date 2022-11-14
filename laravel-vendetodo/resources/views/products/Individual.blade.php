@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="/css/productos-individual.css">
@endsection

@section('content')

    <div class="servicios card">
         @if($producto->getImagenUrl() == null)
            <div class="card-image card-image-not-found"></div>
        @else
            <div class="imagen">
                <img src="{{ $producto->getImagenUrl() }}" alt="{{ $producto->getNombre() }}">
            </div>
        @endif
        <div class="product-info">
                <h1 class="titulo" title="{{ $producto->getNombre() }}">{{ $producto->getNombre() }}</h1>
                @if($producto->getDescripcion() == null)
                    <p class="">Sin descripción</p>
                @else
                    <p class="">{{ $producto->getDescripcion() }}</p>
                @endif
                <p>${{ number_format($producto->getPrecio(), 2) }}</p>
                <label>Marca:</label>
                <p>{{ $producto->getMarca()->getNombre() }}</p>
                <label>Alto:</label>
                <p>{{ $producto->getAlto() }}</p>
                <label>Ancho:</label>
                <p>{{ $producto->getAncho() }}</p>
                <label>Largo:</label>
                <p>{{ $producto->getLargo() }}</p>
                <label>Proveedor:</label>
                <select class="form-select">
                <option value="" disabled selected>-- Sin seleccionar --</option>
                @foreach ($marcas as $marca)
                    <option value="{{$marca->getId()}}">{{$marca->getNombre()}}</option>
                @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Agregar al carrito</button>
            </div>
    </div>
@endsection