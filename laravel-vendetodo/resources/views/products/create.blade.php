@extends('layouts.app')

@section('tittle','Editar Productos')

@section('content')
<div class="w-full max-w-xs mx-auto">
  <form action="{{route('products.update',$product->id)}}" method="POST"
   class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" >
    @csrf
    @method('put')
    <h2 class="text-2xl text-center py-4 mb-4 font-bold font-mono">
      Editar Productos {{$product->name}}
    </h2>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nombre del producto:</label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Nombre del producto" name="name" value="{{$product->name}}">
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="brand">Marca del producto:</label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="brand" type="text" placeholder="Marca del producto" name="brand" value="{{$product->brand}}">
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Descripción del producto:</label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" type="text" placeholder="Descripción del producto" name="description" value="{{$product->description}}">
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Precio del producto:</label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price"  placeholder="Precio del producto" name="price" value="{{$product->price}}">
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="size">Tamaño del producto:</label>
      <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="size" placeholder="Tamaño del producto" name="size" value="{{$product->size}}">
    </div>
    <div class="flex justify-center">
      <button class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Editar datos</button>
    </div>
  </form>
</div>
@endsection