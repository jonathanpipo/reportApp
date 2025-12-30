<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reporte>
 */
class ReporteFactory extends Factory
{
    protected $model = \App\Models\Reporte::class;

    public function definition(): array
    {
        return [
            'categoria_id'   => Categoria::inRandomOrder()->first()->id ?? Categoria::factory(),
            'avaliacao'      => $this->faker->randomElement(['Muito ruim', 'Ruim', 'Regular', 'Bom', 'Muito bom']),
            'latitude' => $this->faker->randomFloat(6, -23.00, -22.82),
            'longitude' => $this->faker->randomFloat(6, -48.52, -48.36),
            'comentario'      => $this->faker->optional()->sentence(),
            'ativo'          => true,
            'data_expiracao' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
        ];
    }
}
