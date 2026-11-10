<?php

namespace Tests\Feature;

use App\Models\Administrador;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        RateLimiter::for('api', fn () => Limit::perMinute(200));
    }

    public function test_all_project_resources_support_json_crud_with_database_records(): void
    {
        $ids = [];

        $ids['roles'] = $this->createAndUpdate('roles', [
            'nombre' => 'API rol',
            'estado' => true,
        ], 'nombre', 'API rol actualizado');

        $ids['administradores'] = $this->createAndUpdate('administradores', [
            'nombres' => 'API administrador',
            'apellidos' => 'Prueba',
            'correo' => 'api-admin@example.test',
            'usuario' => 'api-admin',
            'contraseña' => 'Secreta123',
            'contraseña_confirmation' => 'Secreta123',
            'url_imagen' => 'https://example.test/admin.png',
            'rol_id' => $ids['roles'],
            'telefono' => '5512345678',
            'direccion' => 'Calle de prueba',
            'estado' => 'activo',
        ], 'nombres', 'API administrador actualizado');

        $ids['categorias'] = $this->createAndUpdate('categorias', [
            'nombre' => 'API categoría',
            'estado' => true,
        ], 'nombre', 'API categoría actualizada');

        $ids['presentaciones'] = $this->createAndUpdate('presentaciones', [
            'nombre' => 'API presentación',
            'descripcion' => 'Tamaño de prueba',
            'estado' => true,
        ], 'nombre', 'API presentación actualizada');

        $ids['marcas'] = $this->createAndUpdate('marcas', [
            'nombre' => 'API marca',
            'estado' => true,
        ], 'nombre', 'API marca actualizada');

        $ids['productos'] = $this->createAndUpdate('productos', [
            'nombre' => 'API producto',
            'categoria_id' => $ids['categorias'],
            'presentacion_id' => $ids['presentaciones'],
            'marca_id' => $ids['marcas'],
            'precio' => 100,
            'existencia' => 5,
            'descuento' => 0,
            'estado' => true,
        ], 'precio', '125.00');

        $ids['clientes'] = $this->createAndUpdate('clientes', [
            'nombres' => 'API cliente',
            'apellidos' => 'Prueba',
            'correo' => 'api-cliente@example.test',
            'contraseña' => 'Secreta123',
            'telefono' => '5523456789',
            'estado' => true,
        ], 'nombres', 'API cliente actualizado');

        $ids['direcciones'] = $this->createAndUpdate('direcciones', [
            'cliente_id' => $ids['clientes'],
            'calle' => 'Calle uno',
            'numero' => '10',
            'colonia' => 'Centro',
            'ciudad' => 'Ciudad de México',
            'codigo_postal' => '06000',
            'estado' => true,
        ], 'calle', 'Calle dos');

        $ids['metodos-pago'] = $this->createAndUpdate('metodos-pago', [
            'nombre' => 'API pago',
            'descripcion' => 'Pago de prueba',
            'estado' => true,
        ], 'nombre', 'API pago actualizado');

        $ids['pedidos'] = $this->createAndUpdate('pedidos', [
            'cliente_id' => $ids['clientes'],
            'metodo_pago_id' => $ids['metodos-pago'],
            'fecha' => '2026-10-29',
            'iva' => 0,
            'descuento' => 0,
            'total' => 125,
            'estado' => true,
        ], 'total', '150.00');

        $ids['productos-pedido'] = $this->createAndUpdate('productos-pedido', [
            'pedido_id' => $ids['pedidos'],
            'producto_id' => $ids['productos'],
            'cantidad' => 1,
            'precio' => 125,
            'descuento' => 0,
            'estado' => true,
        ], 'cantidad', 2);

        $ids['repartidores'] = $this->createAndUpdate('repartidores', [
            'nombres' => 'API repartidor',
            'apellidos' => 'Prueba',
            'telefono' => '5534567890',
            'licencia' => 'API-LICENCIA-1',
            'estado' => true,
        ], 'nombres', 'API repartidor actualizado');

        $ids['proveedores'] = $this->createAndUpdate('proveedores', [
            'nombre' => 'API proveedor',
            'contacto' => 'Contacto de prueba',
            'correo' => 'api-proveedor@example.test',
            'telefono' => '5545678901',
            'direccion' => 'Calle de prueba',
            'estado' => true,
        ], 'nombre', 'API proveedor actualizado');

        $ids['entregas'] = $this->createAndUpdate('entregas', [
            'pedido_id' => $ids['pedidos'],
            'repartidor_id' => $ids['repartidores'],
            'direccion_id' => $ids['direcciones'],
            'fecha' => '2026-10-29',
            'hora' => '10:30:00',
            'estado' => true,
        ], 'hora', '11:30:00');

        $ids['usuarios'] = $this->createAndUpdate('usuarios', [
            'name' => 'API usuario',
            'email' => 'api-user@example.test',
            'password' => 'Secreta123',
        ], 'name', 'API usuario actualizado');

        $this->assertDatabaseHas('administradores', [
            'id' => $ids['administradores'],
        ]);
        $this->assertTrue(Hash::check(
            'Secreta123',
            Administrador::findOrFail($ids['administradores'])->contraseña
        ));
        $this->assertTrue(Hash::check(
            'Secreta123',
            User::findOrFail($ids['usuarios'])->password
        ));

        foreach ([
            'entregas',
            'productos-pedido',
            'pedidos',
            'direcciones',
            'clientes',
            'proveedores',
            'metodos-pago',
            'productos',
            'categorias',
            'presentaciones',
            'marcas',
            'repartidores',
            'administradores',
            'roles',
            'usuarios',
        ] as $resource) {
            $this->deleteJson("/api/{$resource}/{$ids[$resource]}")
                ->assertOk()
                ->assertJsonPath('message', 'Registro eliminado correctamente.');
        }
    }

    public function test_invalid_input_and_unknown_ids_return_json_errors(): void
    {
        $this->postJson('/api/categorias', ['nombre' => ''])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('nombre');

        $this->getJson('/api/categorias/999999')
            ->assertNotFound()
            ->assertJsonPath('message', 'Registro no encontrado.');
    }

    public function test_administrator_registration_requires_matching_password_confirmation(): void
    {
        $rol = Rol::create(['nombre' => 'Administrador', 'estado' => true]);
        $actor = $this->crearAdministrador('actor', 'actor@example.test', '5511111111', $rol->id);
        Sanctum::actingAs($actor, ['*'], 'admin_api');

        $this->postJson('/api/administradores', [
            'nombres' => 'Nuevo',
            'apellidos' => 'Administrador',
            'correo' => 'nuevo@example.test',
            'usuario' => 'nuevo-admin',
            'contraseña' => 'Secreta123',
            'contraseña_confirmation' => 'Secreta123',
            'url_imagen' => 'https://example.test/admin.png',
            'rol_id' => $rol->id,
            'telefono' => '5522222222',
            'direccion' => '',
            'estado' => 'activo',
        ])->assertCreated()
            ->assertJsonMissingPath('data.contraseña')
            ->assertJsonMissingPath('data.contraseña_confirmation');

        $nuevo = Administrador::where('usuario', 'nuevo-admin')->firstOrFail();
        $this->assertTrue(Hash::check('Secreta123', $nuevo->contraseña));

        $this->postJson('/api/administradores', [
            'nombres' => 'Otro',
            'apellidos' => 'Administrador',
            'correo' => 'otro@example.test',
            'usuario' => 'otro-admin',
            'contraseña' => 'Secreta123',
            'contraseña_confirmation' => 'NoCoincide123',
            'url_imagen' => 'https://example.test/admin.png',
            'rol_id' => $rol->id,
            'telefono' => '5533333333',
            'direccion' => '',
            'estado' => 'activo',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('contraseña');

        $this->assertDatabaseMissing('administradores', ['usuario' => 'otro-admin']);
    }

    public function test_administrator_update_keeps_or_changes_password_only_after_confirmation(): void
    {
        $rol = Rol::create(['nombre' => 'Administrador', 'estado' => true]);
        $actor = $this->crearAdministrador('actor', 'actor@example.test', '5511111111', $rol->id);
        $objetivo = $this->crearAdministrador('objetivo', 'objetivo@example.test', '5522222222', $rol->id);
        Sanctum::actingAs($actor, ['*'], 'admin_api');

        $this->putJson("/api/administradores/{$objetivo->id}", [
            'nombres' => 'Objetivo actualizado',
        ])->assertOk();

        $objetivo->refresh();
        $this->assertSame('Objetivo actualizado', $objetivo->nombres);
        $this->assertTrue(Hash::check('Secreta123', $objetivo->contraseña));
        $this->postJson('/api/login', [
            'usuario' => 'objetivo',
            'contraseña' => 'Secreta123',
        ])->assertOk();

        $this->putJson("/api/administradores/{$objetivo->id}", [
            'contraseña' => 'NuevaSecreta123',
            'contraseña_confirmation' => 'NoCoincide123',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('contraseña');

        $this->assertTrue(Hash::check('Secreta123', $objetivo->fresh()->contraseña));

        $this->putJson("/api/administradores/{$objetivo->id}", [
            'contraseña' => 'NuevaSecreta123',
            'contraseña_confirmation' => 'NuevaSecreta123',
        ])->assertOk()
            ->assertJsonMissingPath('data.contraseña')
            ->assertJsonMissingPath('data.contraseña_confirmation');

        $this->assertTrue(Hash::check('NuevaSecreta123', $objetivo->fresh()->contraseña));
        $this->postJson('/api/login', [
            'usuario' => 'objetivo',
            'contraseña' => 'Secreta123',
        ])->assertUnauthorized();
        $this->postJson('/api/login', [
            'usuario' => 'objetivo',
            'contraseña' => 'NuevaSecreta123',
        ])->assertOk();
    }

    private function crearAdministrador(
        string $usuario,
        string $correo,
        string $telefono,
        int $rolId
    ): Administrador {
        return Administrador::create([
            'nombres' => 'Prueba',
            'apellidos' => 'Administrador',
            'correo' => $correo,
            'usuario' => $usuario,
            'contraseña' => Hash::make('Secreta123'),
            'url_imagen' => '',
            'rol_id' => $rolId,
            'telefono' => $telefono,
            'direccion' => '',
            'estado' => 'activo',
        ]);
    }

    private function createAndUpdate(
        string $resource,
        array $payload,
        string $field,
        string|int|float $updatedValue
    ): int {
        $created = $this->postJson("/api/{$resource}", $payload)
            ->assertCreated()
            ->assertJsonStructure(['data' => ['id']])
            ->json('data');

        $id = $created['id'];

        $this->getJson("/api/{$resource}")
            ->assertOk()
            ->assertJsonFragment(['id' => $id]);

        $this->getJson("/api/{$resource}/{$id}")
            ->assertOk()
            ->assertJsonPath('data.id', $id);

        $updated = $this->putJson("/api/{$resource}/{$id}", [$field => $updatedValue])
            ->assertOk()
            ->json("data.{$field}");

        if (is_numeric($updatedValue) && is_numeric($updated)) {
            $this->assertEquals((float) $updatedValue, (float) $updated);
        } else {
            $this->assertSame($updatedValue, $updated);
        }

        return $id;
    }
}
