<?php

namespace Database\Factories;

use App\Models\Operador;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Operador>
 */
class OperadorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Operador::class;

    /**
     * Configure Faker to use Portuguese locale.
     */
    public function withFaker(): Faker
    {
        return \Faker\Factory::create('pt_BR');
    }

    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'cpf' => $this->faker->unique()->numerify('###########'),
            'telefone' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement([
                Operador::STATUS_LIVRE,
                Operador::STATUS_EM_SERVICO,
            ]),
            'categoria_cnh' => $this->faker->randomElement(['A','B','AB','C','D','E']),
        ];
    }
}
