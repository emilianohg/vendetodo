<h1>Orden</h1>

{{ $orden->getOrdenId() }}

<table>
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orden->getDetalle() as $detalle)
        <tr>
            <td>{{ $detalle->getProducto()->getImagenUrl() }}</td>
            <td>{{ $detalle->getProducto()->getNombre() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>