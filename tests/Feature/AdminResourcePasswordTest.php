<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdminResourcePasswordTest extends TestCase
{
    public function test_administrator_forms_require_confirmation_only_during_registration_and_never_show_saved_password(): void
    {
        Http::fake(function (ClientRequest $request) {
            if (str_ends_with($request->url(), '/roles')) {
                return Http::response(['data' => []]);
            }

            return Http::response(['data' => [
                'id' => 7,
                'contraseña' => '$2y$12$stored-hash',
                'nombres' => 'Ana',
            ]]);
        });

        $createResponse = $this->withSession(['api_admin_token' => 'test-token'])
            ->get('/admin/administradores/crear')
            ->assertOk();
        $createHtml = $createResponse->getContent();
        $this->assertMatchesRegularExpression(
            '/<input(?=[^>]*name="contraseña")(?=[^>]*\srequired(?:\s|>))[^>]*>/',
            $createHtml
        );
        $this->assertMatchesRegularExpression(
            '/<input(?=[^>]*name="contraseña_confirmation")(?=[^>]*\srequired(?:\s|>))[^>]*>/',
            $createHtml
        );

        $editResponse = $this->withSession(['api_admin_token' => 'test-token'])
            ->get('/admin/administradores/7/editar')
            ->assertOk()
            ->assertSee('Nueva contraseña')
            ->assertSee('Deje este campo vacío para conservar la contraseña actual.')
            ->assertDontSee('$2y$12$stored-hash');
        $editHtml = $editResponse->getContent();
        $this->assertDoesNotMatchRegularExpression(
            '/<input(?=[^>]*name="contraseña")(?=[^>]*\srequired(?:\s|>))[^>]*>/',
            $editHtml
        );
        $this->assertDoesNotMatchRegularExpression(
            '/<input(?=[^>]*name="contraseña_confirmation")(?=[^>]*\srequired(?:\s|>))[^>]*>/',
            $editHtml
        );
    }

    public function test_administrator_update_forwards_confirmation_but_omits_an_empty_password(): void
    {
        Http::fake([
            '*' => Http::response(['data' => []], 200),
        ]);

        $this->withSession(['api_admin_token' => 'test-token'])
            ->put('/admin/administradores/7', [
                'nombres' => 'Ana actualizada',
                'contraseña' => '',
                'contraseña_confirmation' => '',
            ])
            ->assertRedirect(route('admin.administradores.index'));

        Http::assertSent(function (ClientRequest $request): bool {
            $data = $request->data();

            return $request->method() === 'PUT'
                && str_ends_with($request->url(), '/administradores/7')
                && !array_key_exists('contraseña', $data)
                && array_key_exists('contraseña_confirmation', $data);
        });
    }

    public function test_administrator_form_validation_does_not_flash_password_values(): void
    {
        Http::fake([
            '*' => Http::response([
                'message' => 'Los datos enviados no son válidos.',
                'errors' => ['contraseña' => ['La confirmación no coincide.']],
            ], 422),
        ]);

        $this->from('/admin/administradores/crear')
            ->withSession(['api_admin_token' => 'test-token'])
            ->post('/admin/administradores', [
                'contraseña' => 'Secreta123',
                'contraseña_confirmation' => 'NoCoincide123',
            ])
            ->assertRedirect('/admin/administradores/crear')
            ->assertSessionHasErrors('contraseña')
            ->assertSessionMissing('_old_input.contraseña')
            ->assertSessionMissing('_old_input.contraseña_confirmation');
    }
}
