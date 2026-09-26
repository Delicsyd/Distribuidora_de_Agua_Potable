<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repartidor extends Model
{
    protected $table = 'repartidores';

    protected $fillable = [
        'nombres',
        'apellidos',
        'telefono',
        'licencia',
        'imagen',
        'estado'
    ];

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }
}