<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    
    }
    public function callback()
    {
      $user=Socialite::driver('google')->user();

     return response()->json([
        'nombre'=> $user->nombre,
        'c'=> $user->email,

     ]);


    }
}
