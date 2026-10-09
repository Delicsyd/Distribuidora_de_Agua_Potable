<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeolocalizacionTest extends TestCase
{
    private const IP = '2806:103e:19:d433:781d:4442:bcad:5f35';

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.geolocalizacion.ip' => self::IP]);
    }

    private function respuestaUbicacion(): array
    {
        return [
            'status' => 'success',
            'query' => self::IP,
            'country' => 'Mexico',
            'regionName' => 'Jalisco',
            'city' => 'Guadalajara',
            'zip' => '44210',
            'lat' => 20.6381,
            'lon' => -103.348,
            'timezone' => 'America/Mexico_City',
        ];
    }

    public function test_it_displays_the_location_for_the_configured_ipv6(): void
    {
        Http::fake([
            'ip-api.com/*' => Http::response($this->respuestaUbicacion()),
        ]);

        $this->get('/ubicacion')
            ->assertOk()
            ->assertSee(self::IP)
            ->assertSee('Guadalajara')
            ->assertSee('Jalisco')
            ->assertSee('20.6381, -103.348');

        Http::assertSent(fn ($request) => str_contains(
            $request->url(),
            rawurlencode(self::IP)
        ));
    }

    public function test_it_displays_weather_for_the_ip_resolved_coordinates(): void
    {
        $timezone = new \DateTimeZone('America/Mexico_City');
        $hour = (new \DateTimeImmutable('now', $timezone))->format('Y-m-d\TH:00');

        Http::fake([
            'ip-api.com/*' => Http::response($this->respuestaUbicacion()),
            'api.open-meteo.com/*' => Http::response([
                'timezone' => 'America/Mexico_City',
                'hourly' => [
                    'time' => [$hour],
                    'temperature_2m' => [20.5],
                    'relative_humidity_2m' => [80],
                    'precipitation_probability' => [49],
                ],
            ]),
        ]);

        $this->get('/clima')
            ->assertOk()
            ->assertSee('Guadalajara')
            ->assertSee(self::IP)
            ->assertSee('20.5 °C')
            ->assertSee('80 %')
            ->assertSee('49 %');

        Http::assertSent(fn ($request) => str_contains(
            $request->url(),
            'latitude=20.6381'
        ) && str_contains($request->url(), 'longitude=-103.348'));
    }
}
