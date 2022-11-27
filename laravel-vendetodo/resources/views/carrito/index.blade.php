@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="/css/carrito.css">
@endsection

@section('content')
<div class="servicios">
	<div class="font-bold" style=" font-size: 30px">Mi carrito</div>
	<div class="tabla-carrito">

		<div class="layout-inline row cabezera font-bold">
			<div class="col-img"></div>
			<div class="col-producto">Producto</div>
			<div class="col-cant">Cantidad</div>
			<div class="col-num">Precio</div>
			<div class="col-num">Subtotal</div>
			<div class="col-del">
            </div>
		</div>




		<div class="layout-inline row linea-compra">
			<div class="col-img">
                <img src="https://m.media-amazon.com/images/I/81IaHmQG2xL._AC_AA180_.jpg" class="frameImg">
            </div>

			<div class="col-producto">TONER XEROX NEGRO PARA PHASER 6020/6022 Y WC 6025/6027</div>

			<div class="col-cant layout-inline">
				<button type="button" class="btn-qty">
                    <i class="fa-sharp fa-solid fa-circle-minus"></i>
                </button>
           		 <input type="numeric" class="cant" value="0" />
          		<button type="button" class="btn-qty">
                    <i class="fa-sharp fa-solid fa-circle-plus"></i>
                  </button>
			</div>

			<div class="col-num">$9874.12</div>

			<div class="col-num">$9874.12</div>

			<div class="col-del">
                <i class="fa-sharp fa-solid fa-trash-can"></i>
            </div>

		</div>




	</div>

    <div class="footer-carrito layout-inline">
		<div class="font-total font-bold">Total:</div>
		<div class="font-total" > $200000000000000000000000.53</div>
	</div>

	<div class="footer-carrito layout-inline" >
	  <button type="button" class="btn" style="background: #abebc6 ">Pagar</button>
	  <button type="button" class="btn">Seguir comprando</button>
	</div>

</div>
@endsection
