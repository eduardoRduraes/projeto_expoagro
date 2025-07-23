<?php

namespace Database\Factories;

use App\Models\Maquina;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

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

    /**
     * Configure Faker to use Portuguese locale.
     */
    public function withFaker(): Faker
    {
        return \Faker\Factory::create('pt_BR');
    }

    public function definition(): array
    {
        $tipo = $this->faker->randomElement(['emplemento', 'caminhao', 'carro', 'trator']);
        $nomeBase = [
            'emplemento' => 'Emplemento',
            'caminhao' => 'Caminhão',
            'carro' => 'Carro',
            'trator' => 'Trator',
        ];

        return [
            'nome' => $nomeBase[$tipo] . ' ' . $this->faker->word(),
            'modelo' => $this->faker->bothify('Modelo-##??'),
            'numero_serie' => $this->faker->unique()->bothify('#########'),
            'tipo' => $tipo,
            'ano' => $this->faker->year,
            'horas_totais' => $this->faker->randomFloat(3, 0, 1000),
            'status' => $this->faker->randomElement([
                Maquina::STATUS_LIVRE,
                Maquina::STATUS_MANUTENCAO,
                Maquina::STATUS_EM_SERVICO,
                Maquina::STATUS_INATIVO,
            ]),
        ];
    }
}
