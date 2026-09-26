<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends DemoCrudController
{
    protected string $modulo = 'clientes';
    protected string $ruta = '/clientes';
    protected string $vista = 'clientes';
    protected string $modelo = Cliente::class;
    protected array $campos = [
        'nombres' => ['etiqueta' => 'Nombres', 'tipo' => 'text', 'obligatorio' => true],
        'apellidos' => ['etiqueta' => 'Apellidos', 'tipo' => 'text', 'obligatorio' => true],
        'correo' => ['etiqueta' => 'Correo electrónico', 'tipo' => 'email', 'obligatorio' => true],
        'contraseña' => ['etiqueta' => 'Contraseña', 'tipo' => 'password', 'obligatorio' => true],
        'telefono' => ['etiqueta' => 'Teléfono', 'tipo' => 'tel', 'obligatorio' => true],
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
