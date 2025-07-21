<?php

namespace Database\Seeders;

use App\Models\Manutencao;
use App\Models\Maquina;
use App\Models\Operador;
use App\Models\UsoMaquina;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $maquinas = Maquina::factory(10)->create();
        $operadores = Operador::factory(4)->create();

        // vincula manutencoes a maquinas existentes e atualiza status
        foreach ($maquinas->random(3) as $maquina) {
            Manutencao::factory()->create(['maquina_id' => $maquina->id]);
            $maquina->update(['status' => Maquina::STATUS_MANUTENCAO]);
        }

        // registros de uso ligando maquinas e operadores
        for ($i = 0; $i < 5; $i++) {
            $uso = UsoMaquina::factory()->create([
                'maquina_id' => $maquinas->random()->id,
                'operador_id' => $operadores->random()->id,
            ]);

            $uso->maquina->increment('horas_totais', $uso->total_horas);
            $uso->maquina->update(['status' => Maquina::STATUS_EM_SERVICO]);
            $uso->operador->update(['status' => Operador::STATUS_EM_SERVICO]);
        }
    }
}
