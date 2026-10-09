<?php

namespace App\Http\Controllers;

use App\Services\GeolocalizacionService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use UnexpectedValueException;

class GeolocalizacionController extends Controller
{
    public function obtenerUbicacion(
        Request $request,
        GeolocalizacionService $geolocalizacion
    ) {
        $ip = config('services.geolocalizacion.ip') ?: $request->ip();

        try {
            $ubicacion = $geolocalizacion->obtenerUbicacion($ip);
        } catch (ConnectionException $exception) {
            report($exception);

            return response()->json([
                'error' => 'No fue posible conectarse a la API de ubicación.',
            ], 502);
        } catch (UnexpectedValueException $exception) {
            report($exception);

            return response()->json([
                'error' => 'No se pudo obtener una ubicación válida.',
            ], 502);
        }

        return view('geolocalizacion.ipubicacion', compact('ubicacion'));
    }
}
