<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'contraseña' => 'required|string',
        ]);

        $guard = Auth::guard('admin');

        $credenciales = [
            'usuario' => $request->usuario,
            'password' => $request->contraseña,
        ];

        if (!$guard->validate($credenciales)) {
            return response()->json([
                'message' => 'Usuario o contraseña incorrectos.'
            ], 401);
        }

        $administrador = Administrador::where(
            'usuario',
            $request->usuario
        )->first();

        $token = $administrador->createToken(
            'token-administrador'
        )->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso.',
            'administrador' => $administrador,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente.'
        ], 200);
    }

    public function me(Request $request)
    {
        return response()->json([
            'administrador' => $request->user()
        ], 200);
    }
}
