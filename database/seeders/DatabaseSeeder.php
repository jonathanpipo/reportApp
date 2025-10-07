<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Reporte;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
 public function run(): void
    {
        $categorias = ['Asfalto danificado', 'Sinalização deficiente', 'Direção perigosa', 'Congestionamento recorrente', 'Drenagem de água'];
        $avaliacoes = ['Muito ruim', 'Ruim', 'Regular', 'Bom', 'Muito bom'];

        for ($i = 0; $i < 500; $i++) {
            Reporte::create([
                'categoria'                => $categorias[array_rand($categorias)],
                'avaliacaoInfraestrutura'  => $avaliacoes[array_rand($avaliacoes)],
                'latitude'                 => $this->randomLatitude(),
                'longitude'                => $this->randomLongitude(),
                'precisao'                 => null,
                'descricao'                => null,
                'ativo'                    => true,
                // define uma data de expiração entre 15 e 60 dias no futuro
                'data_expiracao'           => null,
            ]);
        }
    }

    private function randomLatitude(): float
    {
        // faixa aproximada de Botucatu (latitude)
        return -22.94 + (mt_rand(-500, 500) / 10000);
    }

    private function randomLongitude(): float
    {
        // faixa aproximada de Botucatu (longitude)
        return -48.44 + (mt_rand(-500, 500) / 10000);
    }
}
