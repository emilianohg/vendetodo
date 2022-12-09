<?php

namespace App\Services;

use App\Domain\PaqueteLote;
use GuzzleHttp\Client;
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
     * @param PaqueteLote[] $paqueteLote
     */
    public function generar(int $ordenId, int $estanteId, array $paquetesLote)
    {
        $ubicaciones = collect($paquetesLote)
            ->filter(fn ($paquete) => $paquete->getSeccionId() != null && $paquete->getEstanteId() != null)
            ->map(fn ($paquete) => [
                'x' => $paquete->getSeccionId(),
                'y' => $paquete->getEstanteId(),
            ])
            ->toArray();

        \Log::info($ubicaciones);

        $totalEstantes = config('almacen.numero_estantes');
        $totalSecciones = config('almacen.numero_secciones');

        $response = $this->http->post(
            'rutas',
            [
                RequestOptions::JSON => [
                    'total_secciones' => $totalSecciones,
                    'total_estantes' => $totalEstantes,
                    'orden_id' => $ordenId,
                    'inicio' => ['x' => 0, 'y' => $estanteId],
                    'ubicaciones' => $ubicaciones,
                ]
            ],
        );

        $data = json_decode($response->getBody()->getContents());

        $camino = collect($data->ruta)
            ->map(fn ($coord) => $coord[0] . ',' . $coord[1])
            ->join(';');

        collect($data->ruta)
            ->filter(fn ($coord) => $coord[0] != 0 && $coord[1] != 0)
            ->map(function ($ruta) {

            })
            ->all();

        \Log::info($camino);
    }
}