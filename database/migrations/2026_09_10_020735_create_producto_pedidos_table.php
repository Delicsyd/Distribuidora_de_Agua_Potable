<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos_pedido', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pedido_id')
                ->constrained('pedidos')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('producto_id')
                ->constrained('productos')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->integer('cantidad');
            $table->decimal('precio', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->string('imagen')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos_pedido');
    }
};