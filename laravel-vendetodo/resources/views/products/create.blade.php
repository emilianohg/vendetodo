@extends('layouts.app')

@section('tittle','Añadir Producto')

@section('content')
  <div class="form-container">
    <h2>Añadir Productos</h2>
    <form action="{{route('productos.store')}}" method="POST" enctype="multipart/form-data">
@csrf
      <div class="input-container">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Ingresa el nombre">
      </div>
      <div class="input-container">
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" id="descripcion" placeholder="Ingresa la descripción">
      </div>
      <div class="input-container">
        <label for="precio">Precio:</label>
        <input type="number" name="precio" id="precio" placeholder="Ingresa la marca">
      </div>
      <div class="input-container">
        <label for="marca_id">Marca:</label>
        <select class="form-select" name="marca_id" id="marca_id">
        @foreach ($marcas as $marca)
            <option value="{{$marca->id}}">{{$marca->nombre}}</option>
        @endforeach
        </select>
      </div>
      <div class="input-container">
        <label for="largo">Largo:</label>
        <input type="number" name="largo" id="largo" placeholder="Ingresa el largo">
      </div>
      <div class="input-container">
        <label for="ancho">Ancho:</label>
        <input type="number" name="ancho" id="ancho" placeholder="Ingresa el ancho">
      </div>
      <div class="input-container">
        <label for="alto">Alto:</label>
        <input type="number" name="alto" id="alto" placeholder="Ingresa el alto">
      </div>
      <div class="input-container">
        <label for="imagen_url">Imagen:</label>
        <input type="file" name="imagen_url" id="imagen_url">
      </div>
      <div class="input-container">
        <button type="submit"  >Agregar</button>
      </div>      
    </form>
  </div>
    

@endsection