<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Presentacion;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_and_product_records_are_saved_updated_and_related_by_real_ids(): void
    {
        $categoria = Categoria::create(['nombre' => 'Agua purificada', 'estado' => true]);
        $marca = Marca::create(['nombre' => 'Manantial', 'estado' => true]);
        $presentacion = Presentacion::create(['nombre' => 'Garrafón 20 L', 'estado' => true]);

        $this->post('/categorias/guardar', [
            'nombre' => 'Accesorios',
            'estado' => 'inactivo',
        ])->assertRedirect('/categorias/listar')
            ->assertSessionHas('status', 'Categoría registrada correctamente.');

        $categoriaNueva = Categoria::where('nombre', 'Accesorios')->firstOrFail();
        $this->assertFalse($categoriaNueva->estado);

        $this->put('/categorias/actualizar', [
            'id' => $categoriaNueva->id,
            'nombre' => 'Accesorios para agua',
        ])->assertRedirect('/categorias/listar');

        $this->assertFalse($categoriaNueva->fresh()->estado);

        $this->post('/productos/guardar', [
            'nombre' => 'Garrafón retornable',
            'categoria_id' => $categoria->id,
            'presentacion_id' => $presentacion->id,
            'marca_id' => $marca->id,
            'precio' => '125.50',
            'existencia' => 7,
            'descuento' => 0,
            'estado' => '1',
            'imagen' => null,
        ])->assertRedirect('/productos/listar')
            ->assertSessionHas('status', 'Producto registrado correctamente.');

        $producto = Producto::firstOrFail();
        $this->assertSame($categoria->id, $producto->categoria_id);
        $this->assertSame($presentacion->id, $producto->presentacion_id);
        $this->assertSame($marca->id, $producto->marca_id);

        $this->get('/productos')
            ->assertOk()
            ->assertSee('Agua purificada')
            ->assertSee('Garrafón 20 L')
            ->assertSee('Manantial')
            ->assertSee('Garrafón retornable');

        $this->put('/productos/actualizar', [
            'id' => $producto->id,
            'precio' => '140.00',
        ])->assertRedirect('/productos/listar')
            ->assertSessionHas('status', 'Producto actualizado correctamente.');

        $producto->refresh();
        $this->assertSame('140.00', $producto->precio);
        $this->assertSame($categoria->id, $producto->categoria_id);
        $this->assertSame(7, $producto->existencia);
        $this->assertTrue($producto->estado);

        $this->delete('/categorias/borrar', ['id' => $categoria->id])
            ->assertRedirect('/categorias/listar')
            ->assertSessionHas('error');
        $this->assertDatabaseHas('categorias', ['id' => $categoria->id]);

        $this->delete('/productos/borrar', ['id' => $producto->id])
            ->assertRedirect('/productos/listar')
            ->assertSessionHas('status', 'Producto eliminado correctamente.');

        $this->delete('/categorias/borrar', ['id' => $categoria->id])
            ->assertRedirect('/categorias/listar')
            ->assertSessionHas('status', 'Categoría eliminada correctamente.');
    }

    public function test_brand_and_presentation_crud_uses_the_database_and_blocks_related_deletions(): void
    {
        $categoria = Categoria::create(['nombre' => 'Categoría', 'estado' => true]);
        $marca = Marca::create(['nombre' => 'Marca', 'estado' => true]);
        $presentacion = Presentacion::create(['nombre' => 'Presentación', 'estado' => true]);

        $this->post('/marcas/guardar', ['nombre' => 'Marca alterna', 'estado' => '0'])
            ->assertRedirect('/marcas/listar');
        $marcaNueva = Marca::where('nombre', 'Marca alterna')->firstOrFail();
        $this->put('/marcas/actualizar', ['id' => $marcaNueva->id, 'nombre' => 'Marca secundaria'])
            ->assertRedirect('/marcas/listar');
        $this->assertFalse($marcaNueva->fresh()->estado);

        $this->post('/presentaciones/guardar', ['nombre' => 'Presentación alterna', 'estado' => '1'])
            ->assertRedirect('/presentaciones/listar');
        $presentacionNueva = Presentacion::where('nombre', 'Presentación alterna')->firstOrFail();
        $this->put('/presentaciones/actualizar', [
            'id' => $presentacionNueva->id,
            'nombre' => 'Presentación secundaria',
        ])->assertRedirect('/presentaciones/listar');
        $this->assertTrue($presentacionNueva->fresh()->estado);

        $this->get('/marcas/editar?id='.$marca->id)->assertOk()->assertSee('Marca');
        $this->get('/presentaciones/mostrar?id='.$presentacion->id)->assertOk()->assertSee('Presentación');

        $producto = Producto::create([
            'nombre' => 'Producto relacionado',
            'categoria_id' => $categoria->id,
            'marca_id' => $marca->id,
            'presentacion_id' => $presentacion->id,
            'precio' => 10,
            'estado' => true,
        ]);

        $this->delete('/marcas/borrar', ['id' => $marca->id])
            ->assertRedirect('/marcas/listar')
            ->assertSessionHas('error');
        $this->delete('/presentaciones/borrar', ['id' => $presentacion->id])
            ->assertRedirect('/presentaciones/listar')
            ->assertSessionHas('error');

        $this->delete('/productos/borrar', ['id' => $producto->id])
            ->assertRedirect('/productos/listar');

        $this->delete('/marcas/borrar', ['id' => $marca->id])
            ->assertSessionHas('status', 'Marca eliminada correctamente.');
        $this->delete('/presentaciones/borrar', ['id' => $presentacion->id])
            ->assertSessionHas('status', 'Presentación eliminada correctamente.');
    }
}
