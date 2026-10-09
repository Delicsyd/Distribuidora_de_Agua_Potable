<?php

namespace App\Http\Controllers;

use App\Services\GeolocalizacionService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use UnexpectedValueException;

class ClimaController extends Controller
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
            $respuestaClima = Http::timeout(10)->get(
                'https://api.open-meteo.com/v1/forecast',
                [
                    'latitude' => $ubicacion['lat'],
                    'longitude' => $ubicacion['lon'],
                    'hourly' => 'temperature_2m,relative_humidity_2m,precipitation_probability',
                    'forecast_days' => 1,
                    'timezone' => 'auto',
                ]
            );
        } catch (ConnectionException $exception) {
            report($exception);

            return response()->json([
                'error' => 'No fue posible conectarse a la API del clima.',
            ], 502);
        }

        $pronostico = $respuestaClima->json();
        $datosPorHora = $pronostico['hourly'] ?? null;
        $horas = $datosPorHora['time'] ?? null;
        $zonaHoraria = $pronostico['timezone'] ?? null;

        if (
            $respuestaClima->failed()
            || ! is_array($datosPorHora)
            || ! is_array($horas)
            || ! is_string($zonaHoraria)
        ) {
            return response()->json([
                'error' => 'No se pudo obtener un pronóstico válido.',
            ], 502);
        }

        try {
            $horaLocalActual = (new \DateTimeImmutable(
                'now',
                new \DateTimeZone($zonaHoraria)
            ))->format('Y-m-d\TH:00');
        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'error' => 'La API devolvió una zona horaria inválida.',
            ], 502);
        }

        $indice = array_search($horaLocalActual, $horas, true);

        if ($indice === false) {
            return response()->json([
                'error' => 'No se encontró el pronóstico para la hora actual.',
            ], 502);
        }

        $temperatura = $datosPorHora['temperature_2m'][$indice] ?? null;
        $humedad = $datosPorHora['relative_humidity_2m'][$indice] ?? null;
        $probabilidadLluvia =
            $datosPorHora['precipitation_probability'][$indice] ?? null;

        if (
            ! is_numeric($temperatura)
            || ! is_numeric($humedad)
            || ! is_numeric($probabilidadLluvia)
        ) {
            return response()->json([
                'error' => 'La API no devolvió todos los datos meteorológicos.',
            ], 502);
        }

        return view('geolocalizacion.clima', [
            'ubicacion' => $ubicacion,
            'ip' => $ip,
            'hora' => $horaLocalActual,
            'temperatura' => $temperatura,
            'humedad' => $humedad,
            'probabilidadLluvia' => $probabilidadLluvia,
        ]);
    }
}
