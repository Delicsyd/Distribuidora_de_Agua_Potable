<?php

namespace App\Http\Controllers;

use App\Services\GeolocalizacionService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use UnexpectedValueException;

class TipoCambioController extends Controller
{
    public function mostrar(
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

        try {
            $respuesta = Http::timeout(10)->get(
                'https://open.er-api.com/v6/latest/USD'
            );
        } catch (ConnectionException $exception) {
            report($exception);

            return response()->json([
                'error' => 'No fue posible conectarse a la API del tipo de cambio.',
            ], 502);
        }

        $datos = $respuesta->json();
        $tasa = $datos['rates']['MXN'] ?? null;
        $actualizado = $datos['time_last_update_utc'] ?? null;

        if (
            $respuesta->failed()
            || ($datos['result'] ?? null) !== 'success'
            || ! is_numeric($tasa)
            || ! is_string($actualizado)
        ) {
            return response()->json([
                'error' => 'No se pudo obtener una tasa de cambio válida.',
            ], 502);
        }

        return view('tipo-cambio.mostrar', [
            'ubicacion' => $ubicacion,
            'ip' => $ip,
            'tasa' => (float) $tasa,
            'actualizado' => $actualizado,
        ]);
    }
}
