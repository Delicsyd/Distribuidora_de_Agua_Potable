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
        'imagen' => ['etiqueta' => 'Fotografía de perfil', 'tipo' => 'image'],
        'estado' => ['etiqueta' => 'Estado', 'tipo' => 'select'],
    ];

    public function listar() { return $this->ver('listado', ['registros' => $this->registrosDePrueba()]); }
    public function vistaFormulario() { return $this->ver('registro'); }
    public function registrar(Request $request) {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'contraseña' => 'required|string|min:8',
            'telefono' => 'required|string|max:20',
            'estado' => 'nullable|string',
        ]);

        return $this->respuestaConImagenes(
            'REGISTRADO',
            $this->subirImagenes($request, ['imagen'])
        );
    }
    public function vistaEdicion(Request $request) { return $this->ver('edicion', ['registro' => $this->registroDePrueba($request->id ?? 1)]); }
    public function actualizar(Request $request) {
        return $this->respuestaConImagenes(
            'ACTUALIZADO',
            $this->subirImagenes($request, ['imagen'])
        );
    }
    public function vistaMostrar(Request $request) { return $this->ver('mostrar', ['registro' => $this->registroDePrueba($request->id ?? 1)]); }
    public function borrar(Request $request) { return $this->respuestaDemo('BORRADO'); }
}
