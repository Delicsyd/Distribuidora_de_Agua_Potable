<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria_id',
        'presentacion_id',
        'marca_id',
        'precio',
        'existencia',
        'descuento',
        'imagen',
        'imagen_secundaria',
        'imagen_terciaria',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'existencia' => 'integer',
            'descuento' => 'decimal:2',
            'estado' => 'boolean',
        ];
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function presentacion()
    {
        return $this->belongsTo(Presentacion::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function productosPedido()
    {
        return $this->hasMany(ProductoPedido::class);
    }
}
