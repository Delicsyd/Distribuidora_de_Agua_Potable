<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Administrador extends Authenticatable
{
    use Notifiable;

protected $table = "administradores";

protected $fillable = [
     'nombres',
        'apellidos',
        'correo',
        'usuario',
        'contraseña',
        'url_imagen',
        'rol',
        'telefono',
        'direccion',
        'estado'
 ];

    protected $hidden = [
        'contraseña'
    ];

    public function getAuthPassword()
    {
        return $this->contraseña;
    }
}