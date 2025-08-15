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
        // Horários mais realistas para trabalho agrícola (6h às 18h)
        $horaInicioInt = $this->faker->numberBetween(6, 16);
        $minutoInicio = $this->faker->randomElement([0, 15, 30, 45]);
        $inicio = sprintf('%02d:%02d', $horaInicioInt, $minutoInicio);
        
        // Duração entre 1 e 8 horas
        $duracaoHoras = $this->faker->numberBetween(1, 8);
        $duracaoMinutos = $this->faker->randomElement([0, 15, 30, 45]);
        
        $inicioSegundos = strtotime($inicio);
        $fimSegundos = $inicioSegundos + ($duracaoHoras * 3600) + ($duracaoMinutos * 60);
        $fim = date('H:i', $fimSegundos);
        
        $totalHoras = round(($fimSegundos - $inicioSegundos) / 3600, 2);
        
        $tarefasAgricolas = [
            'Preparo do solo com arado',
            'Gradagem do terreno',
            'Plantio de soja',
            'Plantio de milho',
            'Aplicação de defensivos',
            'Pulverização de herbicida',
            'Colheita de grãos',
            'Transporte de insumos',
            'Distribuição de calcário',
            'Semeadura direta',
            'Cultivo mecânico',
            'Roçada de pasto',
            'Enleiramento de feno',
            'Enfardamento',
            'Subsolagem profunda',
            'Aplicação de fertilizante',
            'Irrigação por aspersão',
            'Manutenção de cercas',
            'Limpeza de canais',
            'Carregamento de grãos'
        ];
        
        $observacoes = [
            'Trabalho realizado conforme planejado',
            'Condições climáticas favoráveis',
            'Solo em boas condições',
            'Equipamento funcionou perfeitamente',
            'Produtividade acima da média',
            'Necessário ajuste na próxima operação',
            'Área com algumas irregularidades',
            'Consumo de combustível normal',
            null, // Algumas sem observação
            null,
        ];

        return [
            'data' => $this->faker->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
            'hora_inicio' => $inicio,
            'hora_fim' => $fim,
            'total_horas' => $totalHoras,
            'tarefa' => $this->faker->randomElement($tarefasAgricolas),
            'observacao' => $this->faker->randomElement($observacoes),
            'maquina_id' => Maquina::inRandomOrder()->first()?->id ?? Maquina::factory(),
            'operador_id' => Operador::inRandomOrder()->first()?->id ?? Operador::factory(),
        ];
    }
}
