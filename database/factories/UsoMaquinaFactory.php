<?php

namespace Database\Factories;

use App\Models\Maquina;
use App\Models\Operador;
use App\Models\UsoMaquina;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UsoMaquina>
 */
class UsoMaquinaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = UsoMaquina::class;

    /**
     * Configure Faker to use Portuguese locale.
     */
    public function withFaker(): Faker
    {
        return \Faker\Factory::create('pt_BR');
    }
    public function definition(): array
    {
        $inicio = $this->faker->time('H:i');
        $fim = date('H:i', strtotime($inicio) + rand(1, 5) * 3600);

        $inicioSegundos = strtotime($inicio);
        $fimSegundos = strtotime($fim);
        $totalHoras = round(($fimSegundos - $inicioSegundos) / 3600, 3);

        return [
            'data' => $this->faker->date(),
            'hora_inicio' => $inicio,
            'hora_fim' => $fim,
            'total_horas' => $totalHoras,
            'tarefa' => $this->faker->sentence(),
            'observacao' => $this->faker->optional()->paragraph(),
            'maquina_id' => Maquina::inRandomOrder()->first()?->id ?? Maquina::factory(),
            'operador_id' => Operador::inRandomOrder()->first()?->id ?? Operador::factory(),
        ];
    }
}
