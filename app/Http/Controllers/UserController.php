<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends DemoCrudController
{
    protected string $modulo = 'usuarios';
    protected string $ruta = '/usuarios';
    protected string $vista = 'usuarios';
    protected string $modelo = User::class;
    protected array $campos = [
        'name' => ['etiqueta' => 'Nombre', 'tipo' => 'text', 'obligatorio' => true],
        'email' => ['etiqueta' => 'Correo electrónico', 'tipo' => 'email', 'obligatorio' => true],
        'password' => ['etiqueta' => 'Contraseña', 'tipo' => 'password', 'obligatorio' => true],
    ];

    public function listar() { return $this->ver('listado', ['registros' => $this->registrosDePrueba()]); }
    public function vistaFormulario() { return $this->ver('registro'); }
    public function registrar(Request $request) { return $this->respuestaDemo('REGISTRADO'); }
    public function vistaEdicion(Request $request) { return $this->ver('edicion', ['registro' => $this->registroDePrueba($request->id ?? 1)]); }
    public function actualizar(Request $request) { return $this->respuestaDemo('ACTUALIZADO'); }
    public function vistaMostrar(Request $request) { return $this->ver('mostrar', ['registro' => $this->registroDePrueba($request->id ?? 1)]); }
    public function borrar(Request $request) { return $this->respuestaDemo('BORRADO'); }
}
