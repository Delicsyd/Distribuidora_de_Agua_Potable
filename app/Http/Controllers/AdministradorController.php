<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Illuminate\Http\Request;

class AdministradorController extends DemoCrudController
{
    protected string $modulo = 'administradores';
    protected string $ruta = '/admin';
    protected string $vista = 'administradores';
    protected string $modelo = Administrador::class;
    protected array $campos = [
        'nombres' => ['etiqueta' => 'Nombres', 'tipo' => 'text', 'obligatorio' => true],
        'apellidos' => ['etiqueta' => 'Apellidos', 'tipo' => 'text', 'obligatorio' => true],
        'usuario' => ['etiqueta' => 'Usuario', 'tipo' => 'text', 'obligatorio' => true],
        'correo' => ['etiqueta' => 'Correo electrónico', 'tipo' => 'email', 'obligatorio' => true],
        'contraseña' => ['etiqueta' => 'Contraseña', 'tipo' => 'password', 'obligatorio' => true],
        'telefono' => ['etiqueta' => 'Teléfono', 'tipo' => 'tel', 'obligatorio' => true],
        'rol' => [
            'etiqueta' => 'Rol',
            'tipo' => 'select',
            'obligatorio' => true,
            'opciones' => ['Superadministrador', 'Administrador'],
        ],
        'estado' => ['etiqueta' => 'Estado', 'tipo' => 'select', 'obligatorio' => true],
        'direccion' => ['etiqueta' => 'Dirección', 'tipo' => 'text'],
        'url_imagen' => ['etiqueta' => 'Imagen de perfil', 'tipo' => 'text', 'obligatorio' => true],
    ];

    public function listar()
    {
        return $this->ver('listado', ['registros' => $this->registrosDePrueba()]);
    }

    public function vistaFormulario()
    {
        return $this->ver('registro');
    }

    public function registrar(Request $request)
    {
        return $this->respuestaDemo('REGISTRADO');
    }

    public function vistaEdicion(Request $request)
    {
        return $this->ver('edicion', ['registro' => $this->registroDePrueba($request->id ?? 1)]);
    }

    public function actualizar(Request $request)
    {
        return $this->respuestaDemo('ACTUALIZADO');
    }

    public function vistaMostrar(Request $request)
    {
        return $this->ver('mostrar', ['registro' => $this->registroDePrueba($request->id ?? 1)]);
    }

    public function borrar(Request $request)
    {
        return $this->respuestaDemo('BORRADO');
    }
}
