@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="/css/carrito.css">
@endsection

@section('content')
<div class="servicios">
	<div class="font-bold" style=" font-size: 30px">Mi carrito</div>
	<div class="tabla-carrito">

		@if($carrito->getLineasCarrito() != null)
				<div class="layout-inline row cabezera font-bold">
					<div class="col-img"></div>
					<div class="col-producto">Producto</div>
					<div class="col-proveedor">Proveedor</div>
					<div class="col-cant">Cantidad</div>
					<div class="col-num">Precio</div>
					<div class="col-num">Subtotal</div>
					<div class="col-del">
					</div>
				</div>


			@foreach($carrito->getLineasCarrito() as $lineaCarrito)
				<div class="layout-inline row linea-compra">
					@if($lineaCarrito->getProducto()->getImagenUrl() == null)
						<div class="card-image card-image-not-found"></div>
					@else
						<div class="col-img">
							<img src="{{ $lineaCarrito->getProducto()->getImagenUrl() }}" alt="{{ $lineaCarrito->getProducto()->getNombre() }}" class="frameImg">
						</div>
					@endif

					<div class="col-producto">{{$lineaCarrito->getProducto()->getNombre()}}</div>

					<div class="col-proveedor">{{$lineaCarrito->getProveedor()->getNombre()}}</div>

					<div class="col-cant layout-inline">
						<button type="submit" class="btn-qty">
							<i class="fa-sharp fa-solid fa-circle-minus"></i>
						</button>
						<input type="numeric" class="cant" value="{{$lineaCarrito->getCantidad()}}" />
						<button type="submit" class="btn-qty">
							<i class="fa-sharp fa-solid fa-circle-plus"></i>
						</button>
					</div>

					<div class="col-num">{{number_format($lineaCarrito->getProducto()->getPrecio(),2)}}</div>

					<div class="col-num">{{number_format($lineaCarrito->getSubtotal(),2)}}</div>

					<form action="{{route('carrito.borrarLinea', [ 'id' => $lineaCarrito->getId() ])}}"  method="POST">
					@csrf
					{{method_field('DELETE')}}
						<div class="col-del">
							<button type="submit" class="fa-sharp fa-solid fa-trash-can"></button>
						</div>
					</form>

				</div>
			@endforeach
	</div>

		<div class="footer-carrito layout-inline">
			<div class="font-total font-bold">Total:</div>
			<div class="font-total" >{{number_format($carrito->getTotal(),2)}}</div>
		</div>

		<div class="footer-carrito layout-inline" >
            <a href="{{route('products.index')}}">
                <button type="submit" class="btn">Seguir comprando</button>
            </a>
			<form action="{{ route('compra.index') }}">
				<button type="submit" class="btn" style="background: #abebc6 ">Pagar</button>
			</Form>
		</div>

	</div>
	@else
		<p style="padding: 25px">Tu carrito está vacío.<a href="{{ route('products.index') }}" class="keep-buying"> Continua comprando</a></p>
	@endif


</div>
@endsection
