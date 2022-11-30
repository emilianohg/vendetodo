@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="/css/productos-individual.css">
@endsection

@section('content')
    <div class="divider-individual">
        <div class="servicios card">
            @if($producto->getImagenUrl() == null)
                <div class="card-image card-image-not-found"></div>
            @else
                <div class="imagen">
                    <img src="{{ $producto->getImagenUrl() }}" alt="{{ $producto->getNombre() }}">
                </div>
            @endif
            <div>
                <div class="product-info">
                    <h1 class="titulo" title="{{ $producto->getNombre() }}">{{ $producto->getNombre() }}</h1>
                    @if($producto->getDescripcion() == null)
                        <p class="description">Sin descripción</p>
                    @else
                        <p class="">{{ $producto->getDescripcion() }}</p>
                    @endif
                    <hr>
                    <p class="price-product">${{ number_format($producto->getPrecio(), 2) }}</p>
                    <div class="product-info-container">
                        <label>Marca:</label>
                        <p class="info">{{ $producto->getMarca()->getNombre() }}</p>
                        <label class="info">Alto:</label>
                        <p class="info">{{ $producto->getAlto() }} cm</p>
                        <label class="info">Ancho:</label>
                        <p class="info">{{ $producto->getAncho() }} cm</p>
                        <label class="info">Largo:</label>
                        <p class="info">{{ $producto->getLargo() }} cm</p>
                    </div>
                </div>
                <div>
                    @if(count($resumen) > 0)
                    <form action="{{route('carrito.guardarLinea')}}" method="POST">
                    @csrf
                        <label class="info">Proveedor:</label>
                        <select id="select-proveedor" name = "proveedor_id" class="form-select">
                            @foreach ($resumen as $res)
                                <option
                                    class="brand-combobox"
                                    data-cantidad="{{ $res->getCantidadDisponible() }}"
                                    value="{{ $res->getProveedorId() }}"
                                >{{ $res->getProveedorNombre() }}</option>
                            @endforeach
                        </select>
                        <p>Disponible: <span id="cantidad-disponible">{{ $resumen[0]->getCantidadDisponible() }}</span></p>

                        <label class="info">Cantidad:</label>
                        <select name="cantidad" class="form-select">
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <input type="hidden" name="producto_id" value="{{$producto->getId()}}">
                        <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                    </form>
 
                    <script>
                        $selectProveedor = document.getElementById('select-proveedor');
                        $cantidadDisponibleParagraph = document.getElementById('cantidad-disponible');

                        $selectProveedor.onchange = function (event) {
                            const optionSelected = document.querySelector('#select-proveedor option[value="'+ event.target.value +'"]');
                            $cantidadDisponibleParagraph.innerText = optionSelected.dataset.cantidad;
                        }
                    </script>
                    @else
                        <p>Producto no disponible actualmente</p>
                    @endif
                </div>
            </div>
        </div>            
    </div>
@endsection