<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

    public function listar()
    {
        return $this->ver('listado', [
            'registros' => Cliente::query()->orderBy('id')->get(),
        ]);
    }

    public function vistaFormulario()
    {
        return $this->ver('registro');
    }

    public function registrar(Request $request)
    {
        $datos = $this->validar($request, [
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'email', 'max:255', Rule::unique('clientes', 'correo')],
            'contraseña' => ['required', 'string', 'min:8', 'max:255'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'estado' => ['nullable', 'in:0,1,activo,inactivo'],
        ], [
            'nombres.required' => 'El nombre del cliente es obligatorio.',
            'apellidos.required' => 'Los apellidos del cliente son obligatorios.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Escribe un correo electrónico válido.',
            'correo.unique' => 'Ya existe un cliente registrado con ese correo electrónico.',
            'contraseña.required' => 'La contraseña es obligatoria.',
            'contraseña.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono debe contener exactamente 10 dígitos.',
            'estado.in' => 'Selecciona un estado válido.',
        ]);

        $datos['contraseña'] = Hash::make($datos['contraseña']);
        $datos['estado'] = $this->normalizarEstado($datos['estado'] ?? null);
        $datos = array_merge($datos, $this->subirImagenes($request, ['imagen']));

        Cliente::create($datos);

        return redirect()->route('clientes.listar')
            ->with('status', 'Cliente registrado correctamente.');
    }

    public function vistaEdicion(Request $request)
    {
        $registro = Cliente::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:clientes,id'],
        ])['id']);

        return $this->ver('edicion', ['registro' => $registro]);
    }

    public function actualizar(Request $request)
    {
        $cliente = Cliente::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:clientes,id'],
        ])['id']);

        $datos = $this->validar($request, [
            'nombres' => ['sometimes', 'required', 'string', 'max:255'],
            'apellidos' => ['sometimes', 'required', 'string', 'max:255'],
            'correo' => ['sometimes', 'required', 'email', 'max:255', Rule::unique('clientes', 'correo')->ignore($cliente->id)],
            'contraseña' => ['sometimes', 'nullable', 'string', 'min:8', 'max:255'],
            'telefono' => ['sometimes', 'required', 'string', 'regex:/^[0-9]{10}$/'],
            'estado' => ['sometimes', 'required', 'in:0,1,activo,inactivo'],
        ], [
            'correo.email' => 'Escribe un correo electrónico válido.',
            'correo.unique' => 'Ya existe un cliente registrado con ese correo electrónico.',
            'contraseña.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'telefono.regex' => 'El teléfono debe contener exactamente 10 dígitos.',
            'estado.in' => 'Selecciona un estado válido.',
        ]);

        if (empty($datos['contraseña'])) {
            unset($datos['contraseña']);
        } else {
            $datos['contraseña'] = Hash::make($datos['contraseña']);
        }

        if (array_key_exists('estado', $datos)) {
            $datos['estado'] = $this->normalizarEstado($datos['estado']);
        }
        $cliente->update($this->actualizarImagenes($request, $datos, ['imagen']));

        return redirect()->route('clientes.listar')
            ->with('status', 'Cliente actualizado correctamente.');
    }

    public function vistaMostrar(Request $request)
    {
        $registro = Cliente::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:clientes,id'],
        ])['id']);

        return $this->ver('mostrar', ['registro' => $registro]);
    }

    public function borrar(Request $request)
    {
        $cliente = Cliente::findOrFail($this->validar($request, [
            'id' => ['required', 'integer', 'exists:clientes,id'],
        ])['id']);

        if ($cliente->direcciones()->exists() || $cliente->pedidos()->exists()) {
            return redirect()->route('clientes.listar')
                ->with('error', 'No se puede eliminar el cliente porque tiene direcciones o pedidos relacionados.');
        }

        $cliente->delete();

        return redirect()->route('clientes.listar')
            ->with('status', 'Cliente eliminado correctamente.');
    }
}
