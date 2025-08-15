<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Manutencao;
use App\Models\Maquina;
use App\Models\Operador;
use App\Models\UsoMaquina;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar usuários administrativos
        $this->createUsers();
        
        // Criar dados principais
        $maquinas = $this->createMaquinas();
        $operadores = $this->createOperadores();
        
        // Criar registros de uso e manutenções
        $this->createUsoMaquinas($maquinas, $operadores);
        $this->createManutencoes($maquinas);
        
        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('👤 Admin user: admin@gestor.com / password');
        $this->command->info('👤 Test user: user@gestor.com / password');
    }
    
    private function createUsers(): void
    {
        $this->command->info('Creating users...');
        
        // Usuário administrador
        User::factory()->create([
            'name' => 'Administrador do Sistema',
            'email' => 'admin@gestor.com',
            'password' => Hash::make('password'),
        ]);
        
        // Usuário de teste
        User::factory()->create([
            'name' => 'Usuário de Teste',
            'email' => 'user@gestor.com',
            'password' => Hash::make('password'),
        ]);
        
        // Usuários adicionais
        User::factory(3)->create();
    }
    
    private function createMaquinas(): \Illuminate\Database\Eloquent\Collection
    {
        $this->command->info('Creating machines...');
        
        // Criar máquinas específicas por tipo
        $tratores = Maquina::factory(5)->create(['tipo' => 'trator']);
        $implementos = Maquina::factory(8)->create(['tipo' => 'emplemento']);
        $caminhoes = Maquina::factory(3)->create(['tipo' => 'caminhao']);
        $carros = Maquina::factory(2)->create(['tipo' => 'carro']);
        
        return $tratores->merge($implementos)->merge($caminhoes)->merge($carros);
    }
    
    private function createOperadores(): \Illuminate\Support\Collection
    {
        $this->command->info('Creating operators...');
        
        // Criar operadores com diferentes categorias de CNH
        $operadores = collect();
        
        // Operadores categoria D (caminhão)
        $operadores = $operadores->merge(
            Operador::factory(3)->create(['categoria_cnh' => 'D'])
        );
        
        // Operadores categoria C (caminhão pequeno)
        $operadores = $operadores->merge(
            Operador::factory(2)->create(['categoria_cnh' => 'C'])
        );
        
        // Operadores categoria B (carro)
        $operadores = $operadores->merge(
            Operador::factory(4)->create(['categoria_cnh' => 'B'])
        );
        
        // Operadores categoria AB (moto + carro)
        $operadores = $operadores->merge(
            Operador::factory(2)->create(['categoria_cnh' => 'AB'])
        );
        
        return $operadores;
    }
    
    private function createUsoMaquinas($maquinas, $operadores): void
    {
        $this->command->info('Creating machine usage records...');
        
        // Criar registros de uso dos últimos 30 dias
        for ($i = 0; $i < 25; $i++) {
            $maquina = $maquinas->random();
            $operador = $operadores->random();
            
            $uso = UsoMaquina::factory()->create([
                'maquina_id' => $maquina->id,
                'operador_id' => $operador->id,
                'data' => now()->subDays(rand(0, 30))->format('Y-m-d'),
            ]);
            
            // Atualizar horas totais da máquina
            $maquina->increment('horas_totais', $uso->total_horas);
        }
        
        // Definir algumas máquinas como em serviço
        $maquinas->random(5)->each(function ($maquina) {
            $maquina->update(['status' => Maquina::STATUS_EM_SERVICO]);
        });
        
        // Definir alguns operadores como em serviço
        $operadores->random(3)->each(function ($operador) {
            $operador->update(['status' => Operador::STATUS_EM_SERVICO]);
        });
    }
    
    private function createManutencoes($maquinas): void
    {
        $this->command->info('Creating maintenance records...');
        
        // Criar manutenções preventivas
        for ($i = 0; $i < 8; $i++) {
            Manutencao::factory()->create([
                'maquina_id' => $maquinas->random()->id,
                'tipo' => Manutencao::TIPO_PREVENTIVA,
                'data_manutencao' => now()->subDays(rand(1, 60))->format('Y-m-d'),
                'responsavel' => 'Equipe de Manutenção Preventiva',
            ]);
        }
        
        // Criar manutenções corretivas
        for ($i = 0; $i < 6; $i++) {
            Manutencao::factory()->create([
                'maquina_id' => $maquinas->random()->id,
                'tipo' => Manutencao::TIPO_CORRETIVA,
                'data_manutencao' => now()->subDays(rand(1, 30))->format('Y-m-d'),
                'responsavel' => 'Oficina Especializada',
            ]);
        }
        
        // Colocar algumas máquinas em manutenção
        $maquinas->random(4)->each(function ($maquina) {
            Manutencao::factory()->create([
                'maquina_id' => $maquina->id,
                'tipo' => Manutencao::TIPO_CORRETIVA,
                'status' => Manutencao::STATUS_MANUTENCAO,
                'data_manutencao' => now()->format('Y-m-d'),
                'responsavel' => 'Manutenção Interna',
            ]);
            
            $maquina->update(['status' => Maquina::STATUS_MANUTENCAO]);
        });
    }
}
