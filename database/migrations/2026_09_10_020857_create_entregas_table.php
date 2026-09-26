<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pedido_id')
                ->constrained('pedidos')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('repartidor_id')
                ->constrained('repartidores')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('direccion_id')
                ->constrained('direcciones')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->date('fecha');
            $table->time('hora')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};
