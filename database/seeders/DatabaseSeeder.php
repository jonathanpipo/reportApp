<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Reporte;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Cria todas as categorias
        Categoria::factory()->count(5)->create();

        // Cria 500 reportes vinculando a categorias existentes
        Reporte::factory()->count(500)->create();
    }
}
