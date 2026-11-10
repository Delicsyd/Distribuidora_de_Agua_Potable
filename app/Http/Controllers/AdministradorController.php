<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdministradorController extends DemoCrudController
{
    protected string $modulo = 'administradores';

    public function listar()
    {
        $administradores = Administrador::with('rol')->orderBy('id')->get();

        return view('administradores.listado', compact('administradores'));
    }

    public function vistaFormulario()
    {
        $roles = Rol::query()->orderBy('nombre')->get();

        return view('administradores.registro', compact('roles'));
    }

    public function registrar(Request $request)
    {
        $datos = $this->validar($request, [
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'email', 'max:255'],
            'usuario' => ['required', 'string', 'max:255', 'unique:administradores,usuario'],
            'contraseña' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'telefono' => ['required', 'string', 'max:255', 'unique:administradores,telefono'],
            'rol_id' => ['required', 'integer', 'exists:roles,id'],
            'estado' => ['required', 'in:0,1'],
            'direccion' => ['nullable', 'string', 'max:255'],
        ], $this->mensajesValidacion());

        $datos['contraseña'] = Hash::make($datos['contraseña']);
        $datos['estado'] = (string) $datos['estado'];
        $datos['url_imagen'] = $this->subirImagenes($request, ['url_imagen'])['url_imagen'] ?? '';

        Administrador::create($datos);

        return redirect()->route('admin.listar')
            ->with('status', 'Administrador registrado correctamente.');
    }

    public function vistaEdicion(Request $request)
    {
        $administrador = Administrador::with('rol')->findOrFail($this->idValidado($request));
        $roles = Rol::query()->orderBy('nombre')->get();

        return view('administradores.edicion', compact('administrador', 'roles'));
    }

    public function actualizar(Request $request)
    {
        $administrador = Administrador::findOrFail($this->idValidado($request));
        $datos = $this->validar($request, [
            'nombres' => ['sometimes', 'required', 'string', 'max:255'],
            'apellidos' => ['sometimes', 'required', 'string', 'max:255'],
            'correo' => ['sometimes', 'required', 'email', 'max:255'],
            'usuario' => ['sometimes', 'required', 'string', 'max:255', 'unique:administradores,usuario,'.$administrador->id],
            'contraseña' => ['sometimes', 'nullable', 'string', 'min:8', 'max:255', 'confirmed'],
            'telefono' => ['sometimes', 'required', 'string', 'max:255', 'unique:administradores,telefono,'.$administrador->id],
            'rol_id' => ['sometimes', 'required', 'integer', 'exists:roles,id'],
            'estado' => ['sometimes', 'required', 'in:0,1'],
            'direccion' => ['sometimes', 'nullable', 'string', 'max:255'],
        ], $this->mensajesValidacion());

        if (empty($datos['contraseña'] ?? null)) {
            unset($datos['contraseña']);
        } else {
            $datos['contraseña'] = Hash::make($datos['contraseña']);
        }

        $imagen = $this->subirImagenes($request, ['url_imagen']);
        if (isset($imagen['url_imagen'])) {
            $datos['url_imagen'] = $imagen['url_imagen'];
        }

        $administrador->update($datos);

        return redirect()->route('admin.listar')
            ->with('status', 'Administrador actualizado correctamente.');
    }

    public function vistaMostrar(Request $request)
    {
        $administrador = Administrador::with('rol')->findOrFail($this->idValidado($request));

        return view('administradores.mostrar', compact('administrador'));
    }

    public function borrar(Request $request)
    {
        $administrador = Administrador::findOrFail($this->idValidado($request));

        if (Auth::guard('admin')->id() == $administrador->id) {
            return redirect()->route('admin.listar')
                ->with('error', 'No puedes eliminar la cuenta de administrador con la que has iniciado sesión.');
        }

        if ((string) $administrador->estado === '1' && Administrador::query()->where('estado', '1')->count() <= 1) {
            return redirect()->route('admin.listar')
                ->with('error', 'No se puede eliminar el último administrador activo.');
        }

        $administrador->delete();

        return redirect()->route('admin.listar')
            ->with('status', 'Administrador eliminado correctamente.');
    }

    private function idValidado(Request $request): int
    {
        return $this->validar($request, [
            'id' => ['required', 'integer', 'exists:administradores,id'],
        ])['id'];
    }

    private function mensajesValidacion(): array
    {
        return [
            'nombres.required' => 'Los nombres del administrador son obligatorios.',
            'apellidos.required' => 'Los apellidos del administrador son obligatorios.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Escribe un correo electrónico válido.',
            'usuario.unique' => 'Ese nombre de usuario ya está registrado.',
            'contraseña.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'contraseña.confirmed' => 'La confirmación de contraseña no coincide.',
            'telefono.unique' => 'Ese teléfono ya está registrado.',
            'rol_id.required' => 'Selecciona un rol.',
            'rol_id.exists' => 'El rol seleccionado ya no existe.',
            'estado.in' => 'Selecciona un estado válido.',
        ];
    }
}
