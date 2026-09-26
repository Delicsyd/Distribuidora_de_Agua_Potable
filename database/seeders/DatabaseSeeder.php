<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ([
            ['nombre' => 'Administrador', 'estado' => true],
            ['nombre' => 'Operador', 'estado' => true],
        ] as $rol) {
            Rol::updateOrCreate(
                ['nombre' => $rol['nombre']],
                ['estado' => $rol['estado']]
            );
        }
    }
}
