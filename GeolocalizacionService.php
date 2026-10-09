<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use UnexpectedValueException;

class GeolocalizacionService
{
    public function obtenerUbicacion(string $ip): array
    {
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            throw new UnexpectedValueException('La dirección IP no es válida.');
        }

        $respuesta = Http::acceptJson()
            ->timeout(10)
            ->get('http://ip-api.com/json/'.rawurlencode($ip), [
                'fields' => 'status,message,query,country,regionName,city,zip,lat,lon,timezone',
            ]);

        $ubicacion = $respuesta->json();

        if (
            $respuesta->failed()
            || ! is_array($ubicacion)
            || ($ubicacion['status'] ?? null) !== 'success'
            || ! is_numeric($ubicacion['lat'] ?? null)
            || ! is_numeric($ubicacion['lon'] ?? null)
        ) {
            throw new UnexpectedValueException(
                is_array($ubicacion) && is_string($ubicacion['message'] ?? null)
                    ? $ubicacion['message']
                    : 'La API no devolvió una ubicación válida.'
            );
        }

        return $ubicacion;
    }
}
