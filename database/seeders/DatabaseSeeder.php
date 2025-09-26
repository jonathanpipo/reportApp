<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Reporte;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run(): void
    {
        $categorias = ['infraestrutura', 'sinalização', 'situação'];
        $subcategorias = ['alta', 'media', 'baixa'];

        for ($i = 0; $i < 100; $i++) {
            Reporte::create([
                'categoria'    => $categorias[array_rand($categorias)],
                'subcategoria' => $subcategorias[array_rand($subcategorias)],
                'latitude'     => $this->randomLatitude(),
                'longitude'    => $this->randomLongitude(),
                'precisao'     => null,
                'descricao'    => null,
            ]);
        }
    }

    private function randomLatitude()
    {
        // faixa aproximada de Botucatu (latitude)
        return -22.94 + (mt_rand(-500, 500) / 10000);
    }

    private function randomLongitude()
    {
        // faixa aproximada de Botucatu (longitude)
        return -48.44 + (mt_rand(-500, 500) / 10000);
    }
}
