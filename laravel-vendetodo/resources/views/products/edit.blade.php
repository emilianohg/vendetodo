@extends('layouts.app')

@section('style')
  <link rel="stylesheet" href="/css/productos-create.css">
@endsection

@section('content')
  <div class="form-container">
    <h1>Editar producto</h1>
    <hr>
    <form action="{{route('productos.update', ['producto' => $producto->id])}}" method="POST" enctype="multipart/form-data">
      @csrf
      {{method_field('PATCH')}}

      <div class="input-container">
        <label class="required" for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="{{$producto->nombre}}">
        @if($errors->has('nombre'))
          <div class="error">{{ $errors->first('nombre') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="5" >{{$producto->descripcion}}</textarea>
        @if($errors->has('descripcion'))
          <div class="error">{{ $errors->first('descripcion') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" placeholder="Ingresa la marca" value="{{$producto->precio}}">
        @if($errors->has('precio'))
          <div class="error">{{ $errors->first('precio') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="marca_id">Marca:</label>
        <select class="form-select" name="marca_id" id="marca_id" >
        <option value="" disabled selected>-- Selecciona una marca --</option>
        @foreach ($marcas as $marca)
            <option value="{{$marca->id}}" @if($producto->marca_id == $marca->id) selected @endif>{{$marca->nombre}}</option>
        @endforeach
        </select>
        @if($errors->has('marca_id'))
          <div class="error">{{ $errors->first('marca_id') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="largo">Largo:</label>
        <input type="number" name="largo" id="largo" placeholder="Ingresa el largo" value="{{$producto->largo}}">
        @if($errors->has('largo'))
          <div class="error">{{ $errors->first('largo') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="ancho">Ancho:</label>
        <input type="number" name="ancho" id="ancho" placeholder="Ingresa el ancho" value="{{$producto->ancho}}">
        @if($errors->has('ancho'))
          <div class="error">{{ $errors->first('ancho') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="alto">Alto:</label>
        <input type="number" name="alto" id="alto" placeholder="Ingresa el alto" value="{{$producto->alto}}">
        @if($errors->has('alto'))
          <div class="error">{{ $errors->first('alto') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="imagen_url">Imagen:</label>
        <input type="file" name="imagen" id="imagen_url" accept="image/png, image/jpg">
        @if($errors->has('imagen_url'))
          <div class="error">{{ $errors->first('imagen_url') }}</div>
        @endif

        @if($producto->imagen_url == null)
            <div class="card-image card-image-not-found"></div>
        @else
            <div class="card-image">
            <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}">
            </div>
        @endif

      </div>
      <div class="mt-4">
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </div>      
    </form>
  </div>
@endsection