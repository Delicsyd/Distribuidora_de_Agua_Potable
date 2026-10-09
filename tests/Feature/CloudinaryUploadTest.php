<?php

namespace Tests\Feature;

use App\Services\CloudinaryImageService;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;
use Tests\TestCase;

class CloudinaryUploadTest extends TestCase
{
    public function test_product_and_customer_catalog_pages_open(): void
    {
        $this->get('/productos')->assertOk();
        $this->get('/clientes')->assertOk();
    }

    public function test_product_image_is_sent_to_cloudinary_and_its_url_is_shown(): void
    {
        $url = 'https://res.cloudinary.com/example/image/upload/producto.png';

        $this->mock(CloudinaryImageService::class, function (MockInterface $mock) use ($url) {
            $mock->shouldReceive('subir')
                ->once()
                ->with(\Mockery::type(UploadedFile::class), 'distribuidora/productos')
                ->andReturn($url);
        });

        $imagen = UploadedFile::fake()->createWithContent(
            'producto.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p6sAAAAASUVORK5CYII=')
        );

        $respuesta = $this->from('/productos/crear')->post('/productos/guardar', [
            'nombre' => 'Garrafón de agua',
            'categoria_id' => 1,
            'presentacion_id' => 1,
            'marca_id' => 1,
            'precio' => 100,
            'existencia' => 5,
            'descuento' => 0,
            'estado' => 'activo',
            'imagen' => $imagen,
        ]);

        $respuesta->assertRedirect('/productos/crear')
            ->assertSessionHas('uploadedImages', ['imagen' => $url])
            ->assertSessionHas('status', 'PRODUCTOS REGISTRADO (DEMOSTRACIÓN: NO SE GUARDARON CAMBIOS) Las imágenes sí se cargaron correctamente a Cloudinary.');

        $this->get('/productos/crear')
            ->assertOk()
            ->assertSee('Imágenes guardadas en Cloudinary')
            ->assertSee($url)
            ->assertSee('src="'.$url.'"', false);
    }
}
