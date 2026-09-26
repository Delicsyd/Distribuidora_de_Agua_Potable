<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();

            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('presentacion_id')
                ->constrained('presentaciones')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('marca_id')
                ->constrained('marcas')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->decimal('precio', 10, 2);
            $table->integer('existencia')->default(0);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->string('imagen')->nullable();
            $table->string('imagen_secundaria')->nullable();
            $table->string('imagen_terciaria')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
