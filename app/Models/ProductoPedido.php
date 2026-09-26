<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoPedido extends Model
{
    protected $table = 'productos_pedido';

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio',
        'descuento',
        'imagen',
        'estado'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}