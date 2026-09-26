<?php

namespace App\Http\Controllers;

use App\Models\Repartidor;
use Illuminate\Http\Request;

class RepartidorController extends DemoCrudController
{
    protected string $modulo = 'repartidores';
    protected string $ruta = '/repartidores';
    protected string $vista = 'repartidores';
    protected string $modelo = Repartidor::class;
    protected array $campos = [
        'nombres' => ['etiqueta' => 'Nombres', 'tipo' => 'text', 'obligatorio' => true],
        'apellidos' => ['etiqueta' => 'Apellidos', 'tipo' => 'text', 'obligatorio' => true],
        'telefono' => ['etiqueta' => 'Teléfono', 'tipo' => 'tel', 'obligatorio' => true],
        'licencia' => ['etiqueta' => 'Licencia', 'tipo' => 'text', 'obligatorio' => true],
        'imagen' => ['etiqueta' => 'Imagen', 'tipo' => 'text'],
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
