<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    protected $model = \App\Models\Categoria::class;

    public function definition(): array
    {
        return [
            'descricao' => $this->faker->unique()->randomElement([
                'Asfalto danificado',
                'Sinalização deficiente',
                'Direção perigosa',
                'Congestionamento recorrente',
                'Drenagem de água'
            ]),
        ];
    }
}
