<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function mostrarLogin()
     {return view("login");
     }
     public function login(Request $request)
     {
          $credenciales= $request->validate([
           'usuario'=> 'required',
           'contraseña'=> 'required'
           ]);

           if (Auth::guard('admin')->attempt([
            'usuario' => $credenciales['usuario'],
            'password' => $credenciales['contraseña'],
            'estado' => '1'
           
           ])) {
              $request->session()->regenerate();

              return redirect()->intended('/dashboard');
           }

           return back()->withErrors([
           'usuario' =>'El usuario, contraseña o estado no son correctos.'
           ])->onlyInput('usuario');
           }
           public function logout(Request $request)
           {
            Auth::guard('admin')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login');

    
           }


     }








