<?php

namespace Database\Factories;

use App\Models\Maquina;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maquina>
 */
class MaquinaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Maquina::class;
    public function definition(): array
    {
        return [
            'nome' => $this->faker->word . ' ' . $this->faker->colorName,
            'modelo' => $this->faker->bothify('Modelo-##??'),
            'numero_serie' => $this->faker->unique()->bothify('#########'),
            'tipo' => $this->faker->randomElement(['emplemento','caminhao','carro','trator']),
            'ano' => $this->faker->year,
            'status' => $this->faker->randomElement(['livre', 'manutencao','em_servico','inativo']),
        ];
    }
}
