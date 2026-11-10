<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Administrador extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'administradores';

    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'usuario',
        'contraseña',
        'url_imagen',
        'rol_id',
        'telefono',
        'direccion',
        'estado'
    ];

    protected $hidden = [
        'contraseña',
    ];

    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }
}
