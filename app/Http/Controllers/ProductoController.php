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
        'imagen' => ['etiqueta' => 'Imagen', 'tipo' => 'text'],
        'imagen_secundaria' => ['etiqueta' => 'Imagen secundaria', 'tipo' => 'text'],
        'imagen_terciaria' => ['etiqueta' => 'Imagen terciaria', 'tipo' => 'text'],
        'estado' => ['etiqueta' => 'Estado', 'tipo' => 'select'],
    ];

    public function listar() { return $this->ver('listado', ['registros' => $this->registrosDePrueba()]); }
    public function vistaFormulario() { return $this->ver('registro'); }
    public function registrar(Request $request) { return $this->respuestaDemo('REGISTRADO'); }
    public function vistaEdicion(Request $request) { return $this->ver('edicion', ['registro' => $this->registroDePrueba($request->id ?? 1)]); }
    public function actualizar(Request $request) { return $this->respuestaDemo('ACTUALIZADO'); }
    public function vistaMostrar(Request $request) { return $this->ver('mostrar', ['registro' => $this->registroDePrueba($request->id ?? 1)]); }
    public function borrar(Request $request) { return $this->respuestaDemo('BORRADO'); }
}
