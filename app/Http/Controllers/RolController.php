<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends DemoCrudController
{
    protected string $modulo = 'roles';
    protected string $ruta = '/roles';
    protected string $vista = 'roles';
    protected string $modelo = Rol::class;
    protected array $campos = [
        'nombre' => ['etiqueta' => 'Nombre', 'tipo' => 'text'],
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
