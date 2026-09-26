<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'cliente_id',
        'metodo_pago_id',
        'fecha',
        'iva',
        'descuento',
        'total',
        'imagen',
        'estado'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class);
    }

    public function productosPedido()
    {
        return $this->hasMany(ProductoPedido::class);
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }
}