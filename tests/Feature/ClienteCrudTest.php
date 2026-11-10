<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Direccion;
use App\Services\CloudinaryImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Mockery\MockInterface;
use Tests\TestCase;

class ClienteCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_registration_hashes_password_and_lists_the_saved_record(): void
    {
        $response = $this->post('/clientes/guardar', $this->datosCliente([
            'estado' => 'inactivo',
        ]));

        $response->assertRedirect('/clientes/listar')
            ->assertSessionHas('status', 'Cliente registrado correctamente.');

        $cliente = Cliente::firstOrFail();
        $this->assertTrue(Hash::check('Secreta123', $cliente->contraseña));
        $this->assertFalse($cliente->estado);

        $this->get('/clientes')
            ->assertOk()
            ->assertSee('María López')
            ->assertSee('maria@example.test')
            ->assertSee('5512345678')
            ->assertSee('Inactivo')
            ->assertDontSee($cliente->contraseña);

        $this->get('/clientes/mostrar?id='.$cliente->id)
            ->assertOk()
            ->assertDontSee('Contraseña')
            ->assertDontSee($cliente->contraseña);

        $this->get('/clientes/editar?id='.$cliente->id)
            ->assertOk()
            ->assertSee('name="contraseña" value=""', false)
            ->assertDontSee('Secreta123');
    }

    public function test_duplicate_email_and_invalid_phone_return_errors_without_flashing_password(): void
    {
        Cliente::create([
            'nombres' => 'María',
            'apellidos' => 'López',
            'correo' => 'maria@example.test',
            'contraseña' => Hash::make('Secreta123'),
            'telefono' => '5512345678',
            'estado' => true,
        ]);

        $this->from('/clientes/crear')
            ->post('/clientes/guardar', $this->datosCliente([
                'telefono' => '12345',
            ]))
            ->assertRedirect('/clientes/crear')
            ->assertSessionHasErrors('telefono')
            ->assertSessionMissing('_old_input.contraseña');

        $this->from('/clientes/crear')
            ->post('/clientes/guardar', $this->datosCliente())
            ->assertRedirect('/clientes/crear')
            ->assertSessionHasErrors('correo')
            ->assertSessionHasInput('nombres', 'María')
            ->assertSessionMissing('_old_input.contraseña');

        $this->assertDatabaseCount('clientes', 1);
    }

    public function test_partial_update_keeps_existing_values_and_photo_when_no_new_photo_is_sent(): void
    {
        $cliente = Cliente::create([
            'nombres' => 'María',
            'apellidos' => 'López',
            'correo' => 'maria@example.test',
            'contraseña' => Hash::make('Secreta123'),
            'telefono' => '5512345678',
            'imagen' => 'https://res.cloudinary.com/example/image/upload/perfil.png',
            'estado' => true,
        ]);

        $this->put('/clientes/actualizar', [
            'id' => $cliente->id,
            'nombres' => 'María Elena',
        ])->assertRedirect('/clientes/listar')
            ->assertSessionHas('status', 'Cliente actualizado correctamente.');

        $cliente->refresh();
        $this->assertSame('María Elena', $cliente->nombres);
        $this->assertSame('López', $cliente->apellidos);
        $this->assertSame('maria@example.test', $cliente->correo);
        $this->assertSame('5512345678', $cliente->telefono);
        $this->assertSame('https://res.cloudinary.com/example/image/upload/perfil.png', $cliente->imagen);
        $this->assertTrue(Hash::check('Secreta123', $cliente->contraseña));
    }

    public function test_profile_photo_is_saved_as_a_cloudinary_url_and_upload_errors_prevent_registration(): void
    {
        $url = 'https://res.cloudinary.com/example/image/upload/perfil.png';
        $this->mock(CloudinaryImageService::class, function (MockInterface $mock) use ($url) {
            $mock->shouldReceive('subir')
                ->once()
                ->with(\Mockery::type(UploadedFile::class), 'distribuidora/clientes')
                ->andReturn($url);
        });

        $imagen = UploadedFile::fake()->createWithContent(
            'perfil.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p6sAAAAASUVORK5CYII=')
        );

        $this->post('/clientes/guardar', $this->datosCliente(['imagen' => $imagen]))
            ->assertRedirect('/clientes/listar');

        $this->assertSame($url, Cliente::firstOrFail()->imagen);
        $this->get('/clientes')->assertSee('src="'.$url.'"', false);

        $this->mock(CloudinaryImageService::class, function (MockInterface $mock) {
            $mock->shouldReceive('subir')
                ->once()
                ->andThrow(new \RuntimeException('Cloudinary is unavailable.'));
        });

        $otraImagen = UploadedFile::fake()->createWithContent(
            'perfil.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p6sAAAAASUVORK5CYII=')
        );

        $this->from('/clientes/crear')
            ->post('/clientes/guardar', $this->datosCliente([
                'correo' => 'otro@example.test',
                'imagen' => $otraImagen,
            ]))
            ->assertRedirect('/clientes/crear')
            ->assertSessionHasErrors('imagen')
            ->assertSessionMissing('_old_input.contraseña');

        $this->assertDatabaseCount('clientes', 1);
    }

    public function test_empty_listing_and_delete_respect_existing_addresses(): void
    {
        $this->get('/clientes')
            ->assertOk()
            ->assertSee('No hay clientes registrados.');

        $cliente = Cliente::create([
            'nombres' => 'María',
            'apellidos' => 'López',
            'correo' => 'maria@example.test',
            'contraseña' => Hash::make('Secreta123'),
            'telefono' => '5512345678',
            'estado' => true,
        ]);
        $cliente->direcciones()->create([
            'calle' => 'Reforma',
            'numero' => '10',
            'colonia' => 'Centro',
            'ciudad' => 'Ciudad de México',
            'codigo_postal' => '06000',
            'estado' => true,
        ]);

        $this->delete('/clientes/borrar', ['id' => $cliente->id])
            ->assertRedirect('/clientes/listar')
            ->assertSessionHas('error');
        $this->assertDatabaseHas('clientes', ['id' => $cliente->id]);

        Direccion::query()->where('cliente_id', $cliente->id)->delete();
        $this->delete('/clientes/borrar', ['id' => $cliente->id])
            ->assertRedirect('/clientes/listar')
            ->assertSessionHas('status', 'Cliente eliminado correctamente.');
        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }

    private function datosCliente(array $overrides = []): array
    {
        return array_merge([
            'nombres' => 'María',
            'apellidos' => 'López',
            'correo' => 'maria@example.test',
            'contraseña' => 'Secreta123',
            'telefono' => '5512345678',
            'estado' => '1',
        ], $overrides);
    }
}
