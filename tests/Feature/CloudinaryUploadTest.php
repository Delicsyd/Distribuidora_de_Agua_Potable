<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Presentacion;
use App\Models\Producto;
use App\Services\CloudinaryImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;
use Tests\TestCase;

class CloudinaryUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Categoria::create(['nombre' => 'Agua purificada', 'estado' => true]);
        Presentacion::create(['nombre' => 'Garrafón de 20 litros', 'estado' => true]);
        Marca::create(['nombre' => 'Manantial', 'estado' => true]);
    }

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
        $categoria = Categoria::firstOrFail();
        $presentacion = Presentacion::firstOrFail();
        $marca = Marca::firstOrFail();

        $respuesta = $this->from('/productos/crear')->post('/productos/guardar', [
            'nombre' => 'Garrafón de agua',
            'categoria_id' => $categoria->id,
            'presentacion_id' => $presentacion->id,
            'marca_id' => $marca->id,
            'precio' => 100,
            'existencia' => 5,
            'descuento' => 0,
            'estado' => '1',
            'imagen' => $imagen,
        ]);

        $respuesta->assertRedirect('/productos/listar')
            ->assertSessionHas('status', 'Producto registrado correctamente.');

        $producto = Producto::firstOrFail();
        $this->assertSame($url, $producto->imagen);

        $this->get('/productos')
            ->assertOk()
            ->assertSee('Agua purificada')
            ->assertSee('Garrafón de 20 litros')
            ->assertSee('Manantial')
            ->assertSee('src="'.$url.'"', false);
    }
}
