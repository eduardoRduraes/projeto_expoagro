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
        $tipo = $this->faker->randomElement([
            Manutencao::TIPO_PREVENTIVA,
            Manutencao::TIPO_CORRETIVA,
        ]);
        
        $descricoesPreventivas = [
            'Troca de óleo do motor e filtros',
            'Revisão geral do sistema hidráulico',
            'Lubrificação de pontos de graxa',
            'Verificação e ajuste de correias',
            'Inspeção do sistema de freios',
            'Limpeza do radiador e sistema de arrefecimento',
            'Verificação da pressão dos pneus',
            'Inspeção de mangueiras e conexões',
            'Calibragem de equipamentos',
            'Verificação do sistema elétrico'
        ];
        
        $descricoesCorretivas = [
            'Reparo no sistema de transmissão',
            'Substituição de peças do motor',
            'Conserto do sistema hidráulico',
            'Reparo na embreagem',
            'Substituição de pneus danificados',
            'Conserto do sistema de direção',
            'Reparo no alternador',
            'Substituição de mangueiras rompidas',
            'Conserto da bomba de combustível',
            'Reparo no sistema de freios',
            'Substituição de rolamentos',
            'Conserto do radiador'
        ];
        
        $responsaveis = [
            'Oficina Mecânica Silva',
            'Manutenção Interna',
            'Concessionária Autorizada',
            'Mecânico João Santos',
            'Equipe de Manutenção',
            'Oficina Especializada',
            'Técnico Especialista'
        ];
        
        $descricao = $tipo === Manutencao::TIPO_PREVENTIVA 
            ? $this->faker->randomElement($descricoesPreventivas)
            : $this->faker->randomElement($descricoesCorretivas);
            
        $custoBase = $tipo === Manutencao::TIPO_PREVENTIVA 
            ? $this->faker->randomFloat(2, 150, 800)  // Preventiva mais barata
            : $this->faker->randomFloat(2, 300, 3000); // Corretiva mais cara

        return [
            'maquina_id' => Maquina::factory(),
            'descricao' => $descricao,
            'tipo' => $tipo,
            'status' => $this->faker->randomElement([
                Manutencao::STATUS_LIVRE,
                Manutencao::STATUS_LIVRE, // Mais chances de estar concluída
                Manutencao::STATUS_LIVRE,
                Manutencao::STATUS_MANUTENCAO,
            ]),
            'custo' => $custoBase,
            'data_manutencao' => $this->faker->dateTimeBetween('-90 days', 'now')->format('Y-m-d'),
            'responsavel' => $this->faker->randomElement($responsaveis),
        ];
    }
}
