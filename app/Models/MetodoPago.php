<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodos_pago';

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'estado'
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}