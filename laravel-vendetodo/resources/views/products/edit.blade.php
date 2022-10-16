@extends('layouts.app')
    
@section('content')
  <div class="form-container">
    <h2>Editar Producto </h2>
    <form action="{{route('productos.update', ['producto' => $producto->id])}}" method="POST" enctype="multipart/form-data">
@csrf
      {{method_field('PATCH')}}
      {{$errors}}
      <div class="input-container">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Ingresa el nombre" value="{{$producto->nombre}}">
      </div>
      <div class="input-container">
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" id="descripcion" placeholder="Ingresa la descripción" value="{{$producto->descripcion}}">
      </div>
      <div class="input-container">
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" placeholder="Ingresa la marca" value="{{$producto->precio}}">
      </div>
      <div class="input-container">
        <label for="marca_id">Marca:</label>
        <select class="form-select" name="marca_id" id="marca_id" >
        @foreach ($marcas as $marca)
            <option value="{{$marca->id}}" @if($producto->marca_id == $marca->id) selected @endif>{{$marca->nombre}}</option>
        @endforeach
        </select>
      </div>
      <div class="input-container">
        <label for="largo">Largo:</label>
        <input type="number" name="largo" id="largo" placeholder="Ingresa el largo" value="{{$producto->largo}}">
      </div>
      <div class="input-container">
        <label for="ancho">Ancho:</label>
        <input type="number" name="ancho" id="ancho" placeholder="Ingresa el ancho" value="{{$producto->ancho}}">
      </div>
      <div class="input-container">
        <label for="alto">Alto:</label>
        <input type="number" name="alto" id="alto" placeholder="Ingresa el alto" value="{{$producto->alto}}">
      </div>
      <div class="input-container">
        <label for="imagen_url">Imagen:</label>
        <input type="file" name="imagen" id="imagen_url" accept="image/png, image/jpg">

        @if($producto->imagen_url == null)
            <div class="card-image card-image-not-found"></div>
        @else
            <div class="card-image">
            <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}">
            </div>
        @endif

      </div>
      <div class="input-container">
        <button type="submit"  >Actualizar</button>
      </div>      
    </form>
  </div>
@endsection