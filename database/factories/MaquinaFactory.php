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
        
        $nomes = [
            'emplemento' => [
                'Arado Reversível', 'Grade Aradora', 'Plantadeira', 'Pulverizador',
                'Colheitadeira', 'Cultivador', 'Subsolador', 'Roçadeira',
                'Distribuidor de Calcário', 'Semeadora', 'Enleirador', 'Enfardadeira'
            ],
            'caminhao' => [
                'Caminhão Basculante', 'Caminhão Graneleiro', 'Caminhão Tanque',
                'Caminhão Boiadeiro', 'Caminhão Prancha', 'Caminhão Baú'
            ],
            'carro' => [
                'Pickup', 'Utilitário', 'Carro de Apoio', 'Veículo de Supervisão'
            ],
            'trator' => [
                'Trator Agrícola', 'Microtrator', 'Trator de Esteira',
                'Trator Compacto', 'Trator de Pneus', 'Trator Fruticultura'
            ]
        ];
        
        $marcas = [
            'emplemento' => ['John Deere', 'Massey Ferguson', 'New Holland', 'Case IH', 'Valtra', 'Stara'],
            'caminhao' => ['Mercedes-Benz', 'Volvo', 'Scania', 'Iveco', 'Ford', 'Volkswagen'],
            'carro' => ['Toyota', 'Ford', 'Chevrolet', 'Volkswagen', 'Fiat', 'Nissan'],
            'trator' => ['John Deere', 'Massey Ferguson', 'New Holland', 'Case IH', 'Valtra', 'Fendt']
        ];
        
        $nome = $this->faker->randomElement($nomes[$tipo]);
        $marca = $this->faker->randomElement($marcas[$tipo]);
        $modelo = $marca . ' ' . $this->faker->bothify('##??');
        
        return [
            'nome' => $nome,
            'modelo' => $modelo,
            'numero_serie' => $this->faker->unique()->bothify('??########'),
            'tipo' => $tipo,
            'ano' => $this->faker->numberBetween(2010, 2024),
            'horas_totais' => $this->faker->randomFloat(1, 0, 5000),
            'status' => $this->faker->randomElement([
                Maquina::STATUS_LIVRE,
                Maquina::STATUS_LIVRE, // Mais chances de estar livre
                Maquina::STATUS_LIVRE,
                Maquina::STATUS_MANUTENCAO,
                Maquina::STATUS_EM_SERVICO,
                Maquina::STATUS_INATIVO,
            ]),
        ];
    }
}
