<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolController extends DemoCrudController
{
    protected string $modulo = 'roles';

    protected string $ruta = '/roles';

    protected string $vista = 'roles';

    protected string $modelo = Rol::class;

    protected array $campos = [
        'nombre' => ['etiqueta' => 'Nombre', 'tipo' => 'text', 'obligatorio' => true],
        'imagen' => ['etiqueta' => 'Icono del rol', 'tipo' => 'image'],
        'estado' => ['etiqueta' => 'Estado', 'tipo' => 'select'],
    ];

    public function listar()
    {
        return $this->ver('listado', [
            'registros' => Rol::query()->orderBy('id')->get(),
        ]);
    }

    public function vistaFormulario()
    {
        return $this->ver('registro');
    }

    public function registrar(Request $request)
    {
        $datos = $this->validar($request, [
            'nombre' => ['required', 'string', 'max:255', Rule::unique('roles', 'nombre')],
            'estado' => ['nullable', 'in:0,1,activo,inactivo'],
        ], [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'Ya existe un rol con ese nombre.',
            'estado.in' => 'Selecciona un estado válido.',
        ]);

        $datos['estado'] = $this->normalizarEstado($datos['estado'] ?? null);
        Rol::create(array_merge($datos, $this->subirImagenes($request, ['imagen'])));

        return redirect()->route('roles.listar')
            ->with('status', 'Rol registrado correctamente.');
    }

    public function vistaEdicion(Request $request)
    {
        $id = $this->validar($request, [
            'id' => ['required', 'integer', 'exists:roles,id'],
        ])['id'];

        return $this->ver('edicion', ['registro' => Rol::findOrFail($id)]);
    }

    public function actualizar(Request $request)
    {
        $id = $this->validar($request, [
            'id' => ['required', 'integer', 'exists:roles,id'],
        ])['id'];
        $rol = Rol::findOrFail($id);
        $datos = $this->validar($request, [
            'nombre' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('roles', 'nombre')->ignore($rol->id)],
            'estado' => ['sometimes', 'required', 'in:0,1,activo,inactivo'],
        ], [
            'nombre.required' => 'El nombre del rol es obligatorio.',
            'nombre.unique' => 'Ya existe un rol con ese nombre.',
            'estado.in' => 'Selecciona un estado válido.',
        ]);

        if (array_key_exists('estado', $datos)) {
            $datos['estado'] = $this->normalizarEstado($datos['estado']);
        }

        $rol->update($this->actualizarImagenes($request, $datos, ['imagen']));

        return redirect()->route('roles.listar')
            ->with('status', 'Rol actualizado correctamente.');
    }

    public function vistaMostrar(Request $request)
    {
        $id = $this->validar($request, [
            'id' => ['required', 'integer', 'exists:roles,id'],
        ])['id'];

        return $this->ver('mostrar', ['registro' => Rol::findOrFail($id)]);
    }

    public function borrar(Request $request)
    {
        $id = $this->validar($request, [
            'id' => ['required', 'integer', 'exists:roles,id'],
        ])['id'];
        $rol = Rol::findOrFail($id);

        if ($rol->administradores()->exists()) {
            return redirect()->route('roles.listar')
                ->with('error', 'No se puede eliminar el rol porque está asignado a administradores.');
        }

        $rol->delete();

        return redirect()->route('roles.listar')
            ->with('status', 'Rol eliminado correctamente.');
    }
}
