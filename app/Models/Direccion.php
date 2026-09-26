<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direcciones';

    protected $fillable = [
        'cliente_id',
        'calle',
        'numero',
        'colonia',
        'ciudad',
        'codigo_postal',
        'referencia',
        'imagen',
        'estado'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }
}