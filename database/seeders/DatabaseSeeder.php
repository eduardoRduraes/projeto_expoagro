<?php

namespace Database\Seeders;

use App\Models\Maquina;
use App\Models\Operador;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UsoMaquina;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Maquina::factory(10)->create();
        Operador::factory(10)->create();
        UsoMaquina::factory(30)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);


    }
}
