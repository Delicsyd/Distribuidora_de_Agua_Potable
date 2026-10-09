<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Rol;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function listar()
    {
        //Aqui va el select
        $administradores = Administrador::all();

        return view("/administradores/listado", compact("administradores"));
    }

    public function vistaFormulario()
    {
        //Aqui va el formulario de registro
        $roles = Rol::all();

        return view("/administradores/registro", compact("roles"));
    }

    public function registrar(Request $request)
    {
        $request->validate(
            [
                'usuario' => 'required|string|max:255|unique:administradores,usuario',
                'telefono' => 'required|string|max:255|unique:administradores,telefono',
            ],
            [
                'usuario.unique' => 'Ese nombre de usuario ya está registrado. Elige otro.',
                'telefono.unique' => 'Ese teléfono ya está registrado. Verifica el número o usa otro.',
            ]
        );

        $admin = new Administrador();
        $admin->nombres = $request->nombres;
        $admin->apellidos = $request->apellidos;
        $admin->correo = $request->correo;
        $admin->usuario = $request->usuario;
        $admin->contraseña = $request->contraseña;
        $admin->url_imagen = $request->url_imagen;
        $admin->rol = $request->rol;
        $admin->telefono = $request->telefono;
        $admin->direccion = $request->direccion;
        $admin->estado = $request->estado;

        $admin->save();//Insert table
        return "ADMINISTRADOR REGISTRADO";
    }

    public function vistaEdicion(Request $request)
    {
        //Aqui va el formulario para editar
        $administrador = Administrador::find($request->id);
        $roles = Rol::all();

        return view("/administradores/edicion", compact("administrador", "roles"));
    }

    public function actualizar(Request $request)
    {
        //Aqui va la actualizacion de datos
        $admin = Administrador::find($request->id);

        if (!$admin) {
            return "ADMINISTRADOR NO ENCONTRADO";
        }

        $admin->nombres = $request->nombres;
        $admin->apellidos = $request->apellidos;
        $admin->correo = $request->correo;
        $admin->usuario = $request->usuario;
        $admin->contraseña = $request->contraseña;
        $admin->url_imagen = $request->url_imagen;
        $admin->rol = $request->rol;
        $admin->telefono = $request->telefono;
        $admin->direccion = $request->direccion;
        $admin->estado = $request->estado;

        $admin->save();//Update table
        return "ADMINISTRADOR ACTUALIZADO";
    }

    public function vistaMostrar(Request $request)
    {
        //Aqui va la vista para mostrar
        $administrador = Administrador::find($request->id);

        return view("/administradores/mostrar", compact("administrador"));
    }

    public function borrar(Request $request)
    {
        //Aqui va el delete
        $admin = Administrador::find($request->id);

        if (!$admin) {
            return "ADMINISTRADOR NO ENCONTRADO";
        }

        $admin->delete();//Delete table
        return "ADMINISTRADOR BORRADO";
    }
}
