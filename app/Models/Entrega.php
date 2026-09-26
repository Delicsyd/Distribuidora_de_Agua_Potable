<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $table = 'entregas';

    protected $fillable = [
        'pedido_id',
        'repartidor_id',
        'direccion_id',
        'fecha',
        'hora',
        'imagen',
        'estado'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function repartidor()
    {
        return $this->belongsTo(Repartidor::class);
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }
}