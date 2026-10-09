<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TipoCambioTest extends TestCase
{
    public function test_it_displays_the_usd_to_mxn_exchange_rate(): void
    {
        Http::fake([
            'ip-api.com/*' => Http::response([
                'status' => 'success',
                'query' => '2806:103e:19:d433:781d:4442:bcad:5f35',
                'country' => 'Mexico',
                'city' => 'Guadalajara',
                'lat' => 20.6381,
                'lon' => -103.348,
            ]),
            'open.er-api.com/v6/latest/USD' => Http::response([
                'result' => 'success',
                'base_code' => 'USD',
                'time_last_update_utc' => 'Fri, 02 Oct 2026 00:00:01 +0000',
                'rates' => ['MXN' => 18.2345],
            ]),
        ]);

        $this->get('/tipo-cambio')
            ->assertOk()
            ->assertSee('Dólar estadounidense a peso mexicano')
            ->assertSee('Guadalajara')
            ->assertSee('1 USD = 18.2345 MXN')
            ->assertSee('Fri, 02 Oct 2026 00:00:01 +0000');
    }

    public function test_it_returns_an_error_when_the_exchange_rate_is_invalid(): void
    {
        Http::fake([
            'ip-api.com/*' => Http::response([
                'status' => 'success',
                'query' => '2806:103e:19:d433:781d:4442:bcad:5f35',
                'country' => 'Mexico',
                'city' => 'Guadalajara',
                'lat' => 20.6381,
                'lon' => -103.348,
            ]),
            'open.er-api.com/v6/latest/USD' => Http::response([
                'result' => 'success',
                'rates' => [],
            ]),
        ]);

        $this->getJson('/tipo-cambio')
            ->assertStatus(502)
            ->assertJson([
                'error' => 'No se pudo obtener una tasa de cambio válida.',
            ]);
    }
}
