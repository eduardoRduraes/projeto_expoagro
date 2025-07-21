<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Maquina;
use App\Models\Manutencao;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manutencao>
 */
class ManutencaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Manutencao::class;

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
            'maquina_id' => Maquina::factory(),
            'descricao' => $this->faker->sentence(),
            'tipo' => $this->faker->randomElement([
                Manutencao::TIPO_PREVENTIVA,
                Manutencao::TIPO_CORRETIVA,
            ]),
            'custo' => $this->faker->randomFloat(3, 100, 5000),
        ];
    }
}
