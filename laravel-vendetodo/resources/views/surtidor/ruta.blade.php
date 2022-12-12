@extends('layouts.dashboard')

@section('style')
  <link rel="stylesheet" href="/css/surtidor-orden.css">
@endsection

@section('content')
<div class="container">
    <h1>
        Ruta para la orden {{ $ruta->getOrdenId() }}
    </h1>
    <div class="controls">
        <div class="btn-view">
            <button id="btn-map" class="btn-opt"><i class="fa-solid fa-map"></i></button>
            <button id="btn-table" class="btn-opt"><i class="fa-solid fa-table"></i></button>
        </div>
    </div>
    <div class="main-section" id="ruta-section">
        <canvas width="660" height="900" id="camino" data-path="{{ $ruta->getCamino() }}"></canvas>
        <script>
            const wstep = 30;
            const hstep = 30;
            const h_estante = 6;
            const num_estantes = 30;
            const num_secciones = 20;
            const num_cols = 22;

            $camino = document.getElementById('camino');

            const path = $camino.dataset.path;

            console.log(path);

            const moves = path.split(';').map(x => x.split(',').map(_x => +_x))

            const ctx = $camino.getContext('2d');

            function drawBackground() {
                // lineas verticales
                for (let i = 0; i <= num_cols; i++) {
                    ctx.beginPath();
                    ctx.setLineDash([4, 2])
                    ctx.strokeStyle = '#a1a1a1';
                    ctx.moveTo(i*wstep, 0);
                    ctx.lineTo(i*wstep, num_estantes * hstep);
                    ctx.stroke();
                }
                // lineas horizontales
                for (let i = 0; i <= num_estantes; i++) {
                    ctx.beginPath();
                    ctx.setLineDash([4, 2])
                    ctx.strokeStyle = '#a1a1a1';
                    ctx.moveTo(0, i*hstep);
                    ctx.lineTo(num_cols*wstep, i*hstep);
                    ctx.stroke();
                }
            }

            function drawEstantes() {
                for (let i = 0; i <= num_estantes; i++) {
                    ctx.beginPath();
                    ctx.fillStyle = "#000";
                    ctx.fillRect(wstep, i*hstep, num_secciones*wstep, h_estante);
                    ctx.stroke();
                }
            }

            function drawPoint(num_seccion_actual, num_estante_actual, paso = '') {
                ctx.beginPath();
                ctx.fillStyle = "#001f55";
                ctx.arc(num_seccion_actual * wstep + (wstep/2), num_estante_actual * hstep - (hstep/2) + 2, wstep/2, 0, 2 * Math.PI);
                ctx.fill();

                ctx.beginPath();
                ctx.fillStyle = "#fff";
                ctx.font = "18px serif";
                ctx.fillText(paso, num_seccion_actual * wstep + 12, num_estante_actual * hstep - (hstep/2) + 6);
                ctx.fill();
            }

            function drawSurtidor() {
                pos = moves[0];
                num_seccion_actual = pos[0];
                num_estante_actual = pos[1];

                ctx.beginPath();
                ctx.fillStyle = "#003ba3";
                ctx.arc(num_seccion_actual * wstep + (wstep/2), num_estante_actual * hstep - (hstep/2) + 2, wstep/2, 0, 2 * Math.PI);
                ctx.fill();
            }

            function drawPath() {
                for(let i = 0; i < moves.length; i++) {
                    if (i === (moves.length - 1)) {
                        break;
                    }

                    const num_seccion_actual = moves[i][0];
                    const num_estante_actual = moves[i][1];

                    const num_seccion_siguiente = moves[i + 1][0];
                    const num_estante_siguiente = moves[i + 1][1];

                    ctx.beginPath();
                    ctx.strokeStyle = '#001f55';
                    ctx.setLineDash([]);
                    ctx.lineCap = 'round';
                    ctx.lineWidth = 3;
                    ctx.moveTo(num_seccion_actual * wstep + (wstep/2), num_estante_actual * hstep - (hstep/2) + 2);
                    ctx.lineTo(num_seccion_siguiente * wstep + (wstep/2), num_estante_siguiente * hstep - (hstep/2) + 2);
                    ctx.stroke();
                }
            }

            function drawMarkers() {
                let step = 1;

                for(let i = 0; i < moves.length; i++) {

                    const num_seccion_actual = moves[i][0];
                    const num_estante_actual = moves[i][1];

                    if (num_seccion_actual > 0 && num_seccion_actual <= num_secciones) {
                        console.log(num_seccion_actual, num_estante_actual);
                        drawPoint(num_seccion_actual, num_estante_actual, step);
                        step++;
                    }
                }
            }

            drawBackground();
            drawEstantes();
            drawPath();
            drawMarkers();
            drawSurtidor();

        </script>
    </div>
    <div class="main-section" id="table-section">
        <table>
            <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Lote</th>
                <th>Ubicación</th>
                <th width="60px"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($ruta->getUbicaciones() as $cont => $detalle)
                <tr>
                    <td>
                        <div class="col-img">
                            <img class="col-img" src=
                            "{{ $detalle->getPaqueteLote()->getLote()->getProducto()->getImagenUrl() }}"
                                 alt="{{  $detalle->getPaqueteLote()->getLote()->getProducto()->getNombre() }}">
                        </div>
                    </td>
                    <td>{{ $detalle->getPaqueteLote()->getLote()->getProducto()->getNombre() }}</td>
                    <td>{{ $detalle->getPaqueteLote()->getCantidad() }}</td>
                    <td>{{ $detalle->getPaqueteLote()->getLote()->getLoteId() }}</td>
                    <td>@if ($detalle->getPaqueteLote()->getEstanteId()!=null)
                            <div>
                                <p>Estante: {{ $detalle->getPaqueteLote()->getEstanteId() }}</p>
                            </div>
                            <div>
                                <p>Sección: {{ $detalle->getPaqueteLote()->getSeccionId() }}</p>
                            </div>
                        @else
                            <p> En bodega </p>
                        @endif
                    </td>
                    <td width="60px">
                        @if($detalle->recogido())
                            Recogido
                        @else
                            <form
                                    method="POST"
                                    action="{{ route('surtidor.recogerProducto') }}"
                                    data-lote="{{ $detalle->getPaqueteLote()->getLote()->getLoteId() }}"
                                    onsubmit="return checkForm(this);"
                            >
                                <input type="hidden" name="orden_id" value="{{ $ruta->getOrdenId() }}">
                                <input type="hidden" name="orden" value="{{ $detalle->getOrden() }}">
                                @csrf
                                <button class="btn-action" type="submit" >+</button>
                            </form>
                            <script>
                                function checkForm(form) {
                                    loteId = form.dataset.lote;
                                    const value = prompt('Introduce el numero de lote para confirmar:');

                                    if (value !== loteId) {
                                        alert('El lote ingresado no coincide, asegurate que tomaste el artículo correcto');
                                    }
                                    return value === loteId;
                                }
                            </script>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="controls text-right">
        <form method="POST" action="{{ route('surtidor.terminarSurtido') }}">
            <input type="hidden" name="orden_id" value="{{ $ruta->getOrdenId() }}">
            @csrf
            <button class="btn" type="submit">Terminar</button>
        </form>
    </div>
</div>


<script>
    $btnMap = document.getElementById('btn-map');
    $btnTable = document.getElementById('btn-table');

    $secTable = document.getElementById('table-section');
    $secMap = document.getElementById('ruta-section');

    $btnTable.onclick = showTable;
    $btnMap.onclick = showMap;

    function showTable() {
        $secMap.style.display = 'none';
        $secTable.style.display = 'inherit';
        $btnTable.classList.add('btn-selected');
        $btnMap.classList.remove('btn-selected');
    }

    function showMap() {
        $secTable.style.display = 'none';
        $secMap.style.display = 'inherit';
        $btnMap.classList.add('btn-selected');
        $btnTable.classList.remove('btn-selected');
    }

    showTable();



</script>


@endsection
