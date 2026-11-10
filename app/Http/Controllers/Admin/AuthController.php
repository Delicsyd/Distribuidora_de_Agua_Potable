<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function autenticar(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'contraseña' => 'required|string',
        ]);

        $respuesta = Http::acceptJson()->post(
            config('services.api_admin.url') . '/login',
            [
                'usuario' => $request->usuario,
                'contraseña' => $request->contraseña,
            ]
        );

        if ($respuesta->failed()) {
            return back()->withErrors([
                'usuario' => 'Credenciales incorrectas o error de conexión con la API.',
            ]);
        }

        $token = $respuesta->json('token');

        if (!$token) {
            return back()->withErrors([
                'usuario' => 'La API no devolvió un token válido.',
            ]);
        }

        session(['api_admin_token' => $token]);

        return redirect()->route('admin.inicio');
    }

    public function logout()
    {
        Http::acceptJson()
            ->withToken(session('api_admin_token'))
            ->post(config('services.api_admin.url') . '/logout');

        session()->forget('api_admin_token');

        return redirect()->route('admin.login');
    }
}