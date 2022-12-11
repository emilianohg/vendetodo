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
                    <form action="{{route('carrito.guardarLinea')}}" method="POST" onsubmit="return checkForm(this);">
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
                        <br>
                        <div>
                            <label for="cantidad" class="info">Cantidad:</label>
                            <div class="inc-dec">
                                <button id="btn-dec" class="btn-control-number">-</button>
                                <input type="number" id="cantidad" name="cantidad" value="1" pattern="[0-9]+" required>
                                <button id="btn-inc" class="btn-control-number">+</button>
                            </div>
                        </div>

                        <input type="hidden" name="producto_id" value="{{$producto->getId()}}">
                        <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                    </form>
 
                    <script>
                        function checkForm() {
                            $cantidadDisponibleParagraph = document.getElementById('cantidad-disponible');
                            const cantidadMaxima = +$cantidadDisponibleParagraph.innerText;

                            $inputCantidad = document.getElementById('cantidad');
                            const cantidad = +$inputCantidad.value;

                            if (cantidad > cantidadMaxima) {
                                alert('La cantidad seleccionada supera la cantidad disponible');
                            }

                            return cantidad <= cantidadMaxima;
                        }

                        $selectProveedor = document.getElementById('select-proveedor');
                        $cantidadDisponibleParagraph = document.getElementById('cantidad-disponible');

                        $selectProveedor.onchange = function (event) {
                            const optionSelected = document.querySelector('#select-proveedor option[value="'+ event.target.value +'"]');
                            $cantidadDisponibleParagraph.innerText = optionSelected.dataset.cantidad;
                        }

                        $btnDec = document.getElementById('btn-dec');
                        $btnInc = document.getElementById('btn-inc');

                        document.querySelector("#cantidad").addEventListener("keypress", function (evt) {
                            if (evt.which !== 8 && evt.which !== 0 && evt.which < 48 || evt.which > 57) {
                                evt.preventDefault();
                            }
                        });

                        function cantidadIncDec(event) {
                            event.preventDefault();
                            $inputCantidad = document.getElementById('cantidad');
                            let value = +$inputCantidad.value;
                            if (isNaN(value)) {
                                $inputCantidad.value = 1;
                                return;
                            }

                            const btnActivated = event.target.id;


                            if (btnActivated === 'btn-dec') {
                                value = value - 1;
                            } else {
                                value = value + 1;
                            }

                            if (value <= 0) {
                                value = 1;
                            }

                            $inputCantidad.value = value;
                        }

                        $btnDec.onclick = cantidadIncDec;
                        $btnInc.onclick = cantidadIncDec;

                        items=document.getElementById("select-proveedor").options;
                        cantidadDisponible=document.getElementById("cantidad-disponible");
                        opciones = [];
                        for(let i=0; i<items.length; i++){
                            opciones[i]=items[i].dataset.cantidad;
                            opciones.sort(function(a, b){return b - a});
                        }
                        for(let i = 0; i<items.length; i++){
                            if(items[i].dataset.cantidad == opciones[0]){
                                items[i].selected=true;
                            }
                            cantidadDisponible.innerText=opciones[0];
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