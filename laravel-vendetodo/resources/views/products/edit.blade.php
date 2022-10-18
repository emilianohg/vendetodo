@extends('layouts.app')

@section('style')
  <link rel="stylesheet" href="/css/productos-create.css">
@endsection

@section('content')
  <div class="form-container">
    <h1>Editar producto</h1>
    <hr>
    <form action="{{route('productos.update', [ 'producto' => $producto->getId() ])}}" method="POST" enctype="multipart/form-data">
      @csrf
      {{method_field('PATCH')}}

      <div class="input-container">
        <label class="required" for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="{{ $producto->getNombre() }}">
        @if($errors->has('nombre'))
          <div class="error">{{ $errors->first('nombre') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="5" >{{ $producto->getDescripcion() }}</textarea>
        @if($errors->has('descripcion'))
          <div class="error">{{ $errors->first('descripcion') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" placeholder="Ingresa la marca" value="{{ $producto->getPrecio() }}" step="any">
        @if($errors->has('precio'))
          <div class="error">{{ $errors->first('precio') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="marca_id">Marca:</label>
        <select class="form-select" name="marca_id" id="marca_id" >
        <option value="" disabled selected>-- Selecciona una marca --</option>
        @foreach ($marcas as $marca)
            <option value="{{$marca->getId()}}" @if($producto->getMarcaId() == $marca->getId()) selected @endif>{{$marca->getNombre()}}</option>
        @endforeach
        </select>
        @if($errors->has('marca_id'))
          <div class="error">{{ $errors->first('marca_id') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="largo">Largo:</label>
        <input type="number" name="largo" id="largo" placeholder="Ingresa el largo" value="{{ $producto->getLargo() }}" step="any">
        @if($errors->has('largo'))
          <div class="error">{{ $errors->first('largo') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="ancho">Ancho:</label>
        <input type="number" name="ancho" id="ancho" placeholder="Ingresa el ancho" value="{{ $producto->getAncho() }}" step="any">
        @if($errors->has('ancho'))
          <div class="error">{{ $errors->first('ancho') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="alto">Alto:</label>
        <input type="number" name="alto" id="alto" placeholder="Ingresa el alto" value="{{ $producto->getAlto() }}" step="any">
        @if($errors->has('alto'))
          <div class="error">{{ $errors->first('alto') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label for="imagen_url">Imagen:</label>
        <input type="file" name="imagen" id="imagen_url" accept="image/png, image/jpg">
        @if($errors->has('imagen_url'))
          <div class="error">{{ $errors->first('imagen_url') }}</div>
        @endif

        @if($producto->getImagenUrl() != null)
            <div class="producto-imagen mt-4">
            <img src="{{ $producto->getImagenUrl() }}" alt="{{ $producto->getNombre() }}">
            </div>
        @endif

      </div>
      <div class="mt-4">
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </div>      
    </form>
  </div>
@endsection