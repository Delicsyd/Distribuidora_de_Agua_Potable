<?php

namespace Tests\Feature;

use App\Models\Administrador;
use App\Models\Rol;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdministradorCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_registration_hashes_password_and_uses_the_role_relation(): void
    {
        $rol = Rol::create(['nombre' => 'Gerente', 'estado' => true]);

        $this->post('/admin/guardar', $this->datosAdministrador([
            'rol_id' => $rol->id,
        ]))->assertRedirect('/admin/listar')
            ->assertSessionHas('status', 'Administrador registrado correctamente.');

        $administrador = Administrador::with('rol')->firstOrFail();
        $this->assertTrue(Hash::check('Secreta123', $administrador->contraseña));
        $this->assertSame($rol->id, $administrador->rol_id);
        $this->assertSame($rol->nombre, $administrador->rol->nombre);
        $this->assertSame('', $administrador->url_imagen);

        $this->get('/admin/listar')
            ->assertOk()
            ->assertSee('Gerente')
            ->assertSee('admin@empresa.test')
            ->assertDontSee($administrador->contraseña);
        $this->get('/admin/editar/'.$administrador->id)->assertOk();
        $this->get('/admin/mostrar/'.$administrador->id)->assertOk();
    }

    public function test_administrator_password_errors_are_not_flashed_and_last_active_admin_is_protected(): void
    {
        $rol = Rol::create(['nombre' => 'Gerente', 'estado' => true]);

        $this->from('/admin/crear')
            ->post('/admin/guardar', $this->datosAdministrador([
                'rol_id' => $rol->id,
                'contraseña_confirmation' => 'No coincide',
            ]))
            ->assertRedirect('/admin/crear')
            ->assertSessionHasErrors('contraseña')
            ->assertSessionMissing('_old_input.contraseña')
            ->assertSessionMissing('_old_input.contraseña_confirmation');

        $administrador = Administrador::create(array_merge(
            $this->datosAdministrador(['rol_id' => $rol->id]),
            ['contraseña' => Hash::make('Secreta123'), 'url_imagen' => '']
        ));

        $this->delete('/admin/borrar/'.$administrador->id)
            ->assertRedirect('/admin/listar')
            ->assertSessionHas('error');
        $this->assertDatabaseHas('administradores', ['id' => $administrador->id]);

        $otroAdministrador = Administrador::create(array_merge(
            $this->datosAdministrador([
                'usuario' => 'otroadmin',
                'telefono' => '5555555556',
                'rol_id' => $rol->id,
            ]),
            ['contraseña' => Hash::make('Secreta123'), 'url_imagen' => '']
        ));
        Auth::guard('admin')->login($administrador);

        $this->delete('/admin/borrar/'.$administrador->id)
            ->assertRedirect('/admin/listar')
            ->assertSessionHas('error');
        $this->assertDatabaseHas('administradores', ['id' => $administrador->id]);
        $this->assertDatabaseHas('administradores', ['id' => $otroAdministrador->id]);
    }

    private function datosAdministrador(array $overrides = []): array
    {
        return array_merge([
            'nombres' => 'Ana',
            'apellidos' => 'García',
            'correo' => 'admin@empresa.test',
            'usuario' => 'anaadmin',
            'contraseña' => 'Secreta123',
            'contraseña_confirmation' => 'Secreta123',
            'telefono' => '5555555555',
            'rol_id' => 1,
            'estado' => '1',
            'direccion' => 'Centro',
        ], $overrides);
    }
}
