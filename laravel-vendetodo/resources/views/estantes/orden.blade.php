<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vende Todo</title>
  <link rel="stylesheet" href="/css/estante.css">
  <script src="https://kit.fontawesome.com/fa805f1387.js" crossorigin="anonymous"></script>
  <title>Document</title>
</head>

<body>
    <div class="sidenav">
        <a href="{{ route('estantes.index') }}">
            <i class="fa-solid fa-file-signature"></i>
        </a>
        <a href="{{ route('productos.index') }}">
            <i class="fa-sharp fa-solid fa-shop"></i>
        </a>
    </div>
  <div class="rack-container">
    <h2>Encargado de estante</h2>
    <h3>Hola!, @usuario</h3>
    <div class="rack-details">
      <table class="tg">
        <thead>
          <tr>
            <th class="tg-0pky" colspan="6">Estante 1</th>
          </tr>
        </thead>
        <tbody>



          <tr>
            <td class="tg-0pky" colspan="6">Seccion 1</td>
          </tr>

          <tr>
            <td class="tg-0pky" rowspan="5">
              <img class="img-producto" src="https://www.sams.com.mx/images/product-images/img_small/980023266s.jpg"
                alt="">
            </td>
            <td class="tg-0pky">Nombre</td>
            <td class="tg-0pky">Cantidad</td>
            <td class="tg-0pky" colspan="3">Lotes</td>
          </tr>
          <tr>
            <td class="tg-0lax" rowspan="4">Xbox Series X consola de video juegos de ultima generacion</td>
            <td class="tg-0lax" rowspan="4">50</td>
            <td class="tg-0lax">Cantidad</td>
            <td class="tg-0lax">Num. lotes</td>
            <td class="tg-0lax">Ubicación</td>
          </tr>
          <tr>
            <td class="tg-0lax">15</td>
            <td class="tg-0lax">44444</td>
            <td class="tg-0lax">Sección 1</td>
          </tr>
          <tr>
            <td class="tg-0lax">30</td>
            <td class="tg-0lax">4444</td>
            <td class="tg-0lax">Bodega</td>
          </tr>
          <tr>
            <td class="tg-0lax">15</td>
            <td class="tg-0lax">44444</td>
            <td class="tg-0lax">Bodega</td>
          </tr>
        </tbody>



      </table>
    </div>
  </div>
</body>

</html>

