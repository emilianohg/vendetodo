<?php

namespace App\Services;

use App\Domain\PaqueteLote;
use App\Domain\Ruta;
use App\Domain\UbicacionProducto;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class RutasService
{
    private Client $http;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => 'http://fastapi:8001/',
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }


    /**
     * @param int $ordenId
     * @param int $estanteId
     * @param array $paquetesLote
     * @return Ruta
     */
    public function generar(int $ordenId, int $estanteId, array $paquetesLote): Ruta
    {
        $ubicaciones = collect($paquetesLote)
            ->filter(fn ($paquete) => $paquete->getSeccionId() != null && $paquete->getEstanteId() != null)
            ->map(fn ($paquete) => [
                'x' => $paquete->getSeccionId(),
                'y' => $paquete->getEstanteId(),
            ])
            ->values()
            ->toArray();

        $ordenUbicacion = 0;
        $ubicacionesReporte = [];
        $camino = '';

        if (count($ubicaciones) > 0) {
            $totalEstantes = config('almacen.numero_estantes');
            $totalSecciones = config('almacen.numero_secciones');

            $data = [
                'total_secciones' => $totalSecciones,
                'total_estantes' => $totalEstantes,
                'orden_id' => $ordenId,
                'inicio' => ['x' => 0, 'y' => $estanteId],
                'ubicaciones' => $ubicaciones,
            ];

            try {
                $response = $this->http->post(
                    'rutas',
                    [
                        RequestOptions::JSON => $data,
                    ],
                );
            } catch (GuzzleException $e) {
                \Log::error($e->getMessage());
            }

            $data = json_decode($response->getBody()->getContents());

            $camino = collect($data->ruta)
                ->map(fn ($coord) => $coord[0] . ',' . $coord[1])
                ->join(';');

            $coordenadasEnAlmacen = collect($data->ruta)
                ->filter(fn ($coord) => $coord[0] != 0 && $coord[1] != 0)
                ->all();

            foreach ($coordenadasEnAlmacen as $coord) {
                $paquetesLoteUbicacion = collect($paquetesLote)
                    ->filter(fn ($paquete) => $paquete->getEstanteId() == $coord[1] && $paquete->getSeccionId() == $coord[0])
                    ->toArray();

                foreach ($paquetesLoteUbicacion as $paquete) {
                    $ubicacionesReporte[] = new UbicacionProducto($paquete, $ordenUbicacion);
                    $ordenUbicacion++;
                }
            }
        }

        $ubicacionesPaquetesBodega = collect($paquetesLote)
            ->filter(fn ($paquete) => $paquete->getSeccionId() == null && $paquete->getEstanteId() == null)
            ->toArray();

        foreach ($ubicacionesPaquetesBodega as $ubicacionPaqueteBodega) {
            $ubicacionesReporte[] = new UbicacionProducto($ubicacionPaqueteBodega, $ordenUbicacion);
            $ordenUbicacion++;
        }

        return new Ruta($ordenId, now(), $ubicacionesReporte, $camino);
    }

}