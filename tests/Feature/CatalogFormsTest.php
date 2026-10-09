<?php

namespace Tests\Feature;

use Tests\TestCase;

class CatalogFormsTest extends TestCase
{
    public function test_product_form_uses_multipart_uploads_and_water_catalog_options(): void
    {
        $this->get('/productos/crear')
            ->assertOk()
            ->assertSee('method="POST"', false)
            ->assertSee('enctype="multipart/form-data"', false)
            ->assertSee('accept="image/*"', false)
            ->assertSee('Agua purificada')
            ->assertSee('Garrafón de 20 litros')
            ->assertSee('Manantial');
    }

    public function test_client_form_can_select_a_profile_image(): void
    {
        $this->get('/clientes/crear')
            ->assertOk()
            ->assertSee('method="POST"', false)
            ->assertSee('enctype="multipart/form-data"', false)
            ->assertSee('name="imagen"', false)
            ->assertSee('accept="image/*"', false);
    }

    public function test_order_form_has_domain_specific_choices_instead_of_sample_options(): void
    {
        $this->get('/pedidos/crear')
            ->assertOk()
            ->assertSee('María López')
            ->assertSee('Efectivo al recibir')
            ->assertSee('En preparación')
            ->assertDontSee('Opción de ejemplo 1')
            ->assertDontSee('Opción de prueba');
    }

    public function test_delivery_form_has_real_delivery_related_choices(): void
    {
        $this->get('/entregas/crear')
            ->assertOk()
            ->assertSee('Pedido #1001')
            ->assertSee('Juan Pérez')
            ->assertSee('Casa - Zona Centro')
            ->assertSee('En camino');
    }

    public function test_product_edit_form_supports_image_files_and_selected_catalog_values(): void
    {
        $this->get('/productos/editar?id=1')
            ->assertOk()
            ->assertSee('enctype="multipart/form-data"', false)
            ->assertSee('name="imagen_secundaria"', false)
            ->assertSee('accept="image/*"', false)
            ->assertSee('value="1" selected', false);
    }
}
