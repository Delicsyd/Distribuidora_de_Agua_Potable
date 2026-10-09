<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends DemoCrudController
{
    protected string $modulo = 'productos';
    protected string $ruta = '/productos';
    protected string $vista = 'Productos';
    protected string $modelo = Producto::class;
    protected array $campos = [
        'nombre' => ['etiqueta' => 'Nombre', 'tipo' => 'text', 'obligatorio' => true],
        'descripcion' => ['etiqueta' => 'Descripción', 'tipo' => 'textarea'],
        'categoria_id' => ['etiqueta' => 'Categoría', 'tipo' => 'select', 'obligatorio' => true],
        'presentacion_id' => ['etiqueta' => 'Presentación', 'tipo' => 'select', 'obligatorio' => true],
        'marca_id' => ['etiqueta' => 'Marca', 'tipo' => 'select', 'obligatorio' => true],
        'precio' => ['etiqueta' => 'Precio', 'tipo' => 'number', 'obligatorio' => true],
        'existencia' => ['etiqueta' => 'Existencia', 'tipo' => 'number'],
        'descuento' => ['etiqueta' => 'Descuento', 'tipo' => 'number'],
        'imagen' => ['etiqueta' => 'Fotografía principal', 'tipo' => 'image'],
        'imagen_secundaria' => ['etiqueta' => 'Fotografía secundaria', 'tipo' => 'image'],
        'imagen_terciaria' => ['etiqueta' => 'Fotografía adicional', 'tipo' => 'image'],
        'estado' => ['etiqueta' => 'Estado', 'tipo' => 'select'],
    ];

    public function listar() { return $this->ver('listado', ['registros' => $this->registrosDePrueba()]); }
    public function vistaFormulario() { return $this->ver('registro'); }
    public function registrar(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|integer',
            'presentacion_id' => 'required|integer',
            'marca_id' => 'required|integer',
            'precio' => 'required|numeric|min:0',
            'existencia' => 'nullable|integer|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'estado' => 'nullable|string',
        ]);

        return $this->respuestaConImagenes(
            'REGISTRADO',
            $this->subirImagenes($request, ['imagen', 'imagen_secundaria', 'imagen_terciaria'])
        );
    }
    public function vistaEdicion(Request $request) { return $this->ver('edicion', ['registro' => $this->registroDePrueba($request->id ?? 1)]); }
    public function actualizar(Request $request) {
        return $this->respuestaConImagenes(
            'ACTUALIZADO',
            $this->subirImagenes($request, ['imagen', 'imagen_secundaria', 'imagen_terciaria'])
        );
    }
    public function vistaMostrar(Request $request) { return $this->ver('mostrar', ['registro' => $this->registroDePrueba($request->id ?? 1)]); }
    public function borrar(Request $request) { return $this->respuestaDemo('BORRADO'); }
}
