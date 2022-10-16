@extends('layouts.app')

@section('style')
  <link rel="stylesheet" href="/css/productos-create.css">
@endsection

@section('content')
  <div class="form-container">
    <h1>Registrar producto</h1>
    <hr>
    <form action="{{route('productos.store')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="input-container">
        <label class="required" for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="{{ isset($producto->nombre)? $producto->nombre:old('nombre') }}" autofocus>
        @if($errors->has('nombre'))
          <div class="error">{{ $errors->first('nombre') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="5">{{ isset($producto->descripcion)? $producto->descripcion:old('descripcion') }}</textarea>
        @if($errors->has('descripcion'))
          <div class="error">{{ $errors->first('descripcion') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" placeholder="Precio" value="{{ isset($producto->precio)? $producto->precio:old('precio') }}">
        @if($errors->has('precio'))
          <div class="error">{{ $errors->first('precio') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="marca_id">Marca:</label>
        <select class="form-select" name="marca_id" id="marca_id">
          <option value="" disabled selected>-- Selecciona una marca --</option>
          @foreach ($marcas as $marca)
            <option value="{{$marca->id}}">{{$marca->nombre}}</option>
          @endforeach
        </select>
        @if($errors->has('marca_id'))
          <div class="error">{{ $errors->first('marca_id') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="largo">Largo:</label>
        <input type="number" name="largo" id="largo" placeholder="Largo" value="{{ isset($producto->largo)? $producto->largo:old('largo') }}">
        @if($errors->has('largo'))
          <div class="error">{{ $errors->first('largo') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="ancho">Ancho:</label>
        <input type="number" name="ancho" id="ancho" placeholder="Ancho" value="{{ isset($producto->ancho)? $producto->ancho:old('ancho') }}">
        @if($errors->has('ancho'))
          <div class="error">{{ $errors->first('ancho') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="alto">Alto:</label>
        <input type="number" name="alto" id="alto" placeholder="Alto" value="{{ isset($producto->alto)? $producto->alto:old('alto') }}">
        @if($errors->has('alto'))
          <div class="error">{{ $errors->first('alto') }}</div>
        @endif
      </div>
      <div class="input-container">
        <label class="required" for="imagen">Imagen:</label>
        <input type="file" name="imagen" id="imagen" accept="image/png, image/jpg">
        @if($errors->has('imagen'))
          <div class="error">{{ $errors->first('imagen') }}</div>
        @endif
      </div>
      <div class="mt-4">
        <button type="submit" class="btn btn-primary">Agregar</button>
      </div>      
    </form>
  </div>
    

@endsection