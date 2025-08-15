<?php

use App\Models\Maquina;
use App\Models\Operador;
use App\Models\UsoMaquina;
use App\Models\User;

test('authenticated user can view usomaquinas index', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('usomaquinas.index'));
    
    $response->assertStatus(200);
    $response->assertViewIs('usomaquinas.index');
});

test('guest cannot view usomaquinas index', function () {
    $response = $this->get(route('usomaquinas.index'));
    
    $response->assertRedirect(route('login'));
});

test('authenticated user can view create usomaquina form', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('usomaquinas.create'));
    
    $response->assertStatus(200);
    $response->assertViewIs('usomaquinas.create');
});

test('authenticated user can store a new usomaquina', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    $operador = Operador::factory()->create();
    
    $usoMaquinaData = [
        'data' => '2024-01-15',
        'hora_inicio' => '08:00',
        'hora_fim' => '12:00',
        'tarefa' => 'Aração do campo',
        'observacao' => 'Trabalho realizado sem problemas',
        'maquina_id' => $maquina->id,
        'operador_id' => $operador->id,
    ];
    
    $response = $this->actingAs($user)->post(route('usomaquinas.store'), $usoMaquinaData);
    
    $response->assertRedirect(route('usomaquinas.index'));
    $this->assertDatabaseHas('usos_maquinas', [
        'maquina_id' => $usoMaquinaData['maquina_id'],
        'operador_id' => $usoMaquinaData['operador_id'],
        'tarefa' => $usoMaquinaData['tarefa'],
    ]);
});

test('usomaquina store validation fails with invalid data', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post(route('usomaquinas.store'), [
        'data' => '', // required field empty
        'hora_inicio' => 'invalid_time',
        'hora_fim' => 'invalid_time',
        'total_horas' => 'invalid_hours',
        'tarefa' => '',
        'maquina_id' => 999, // non-existent ID
        'operador_id' => 999, // non-existent ID
    ]);
    
    $response->assertSessionHasErrors(['data', 'hora_inicio', 'hora_fim', 'maquina_id', 'operador_id']);
});

test('authenticated user can view a specific usomaquina', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    $operador = Operador::factory()->create();
    $usoMaquina = UsoMaquina::factory()->create([
        'maquina_id' => $maquina->id,
        'operador_id' => $operador->id,
    ]);
    
    $response = $this->actingAs($user)->get(route('usomaquinas.show', $usoMaquina));
    
    $response->assertStatus(200);
    $response->assertViewIs('usomaquinas.show');
    $response->assertViewHas('usomaquina', $usoMaquina);
});

test('authenticated user can view edit usomaquina form', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    $operador = Operador::factory()->create();
    $usoMaquina = UsoMaquina::factory()->create([
        'maquina_id' => $maquina->id,
        'operador_id' => $operador->id,
    ]);
    
    $response = $this->actingAs($user)->get(route('usomaquinas.edit', $usoMaquina));
    
    $response->assertStatus(200);
    $response->assertViewIs('usomaquinas.edit');
    $response->assertViewHas('usomaquina', $usoMaquina);
});

test('authenticated user can update a usomaquina', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    $operador = Operador::factory()->create();
    $usoMaquina = UsoMaquina::factory()->create([
        'maquina_id' => $maquina->id,
        'operador_id' => $operador->id,
    ]);
    
    $updatedData = [
        'data' => '2024-01-16',
        'hora_inicio' => '09:00',
        'hora_fim' => '13:00',
        'total_horas' => 4.0,
        'tarefa' => 'Plantio atualizado',
        'observacao' => 'Observação atualizada',
        'maquina_id' => $maquina->id,
        'operador_id' => $operador->id,
    ];
    
    $response = $this->actingAs($user)->put(route('usomaquinas.update', $usoMaquina), $updatedData);
    
    $response->assertRedirect(route('usomaquinas.index'));
    
    $usoMaquina->refresh();
    expect($usoMaquina->tarefa)->toBe('Plantio atualizado');
    expect($usoMaquina->observacao)->toBe('Observação atualizada');
});

test('authenticated user can delete a usomaquina', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    $operador = Operador::factory()->create();
    $usoMaquina = UsoMaquina::factory()->create([
        'maquina_id' => $maquina->id,
        'operador_id' => $operador->id,
    ]);
    
    $response = $this->actingAs($user)->delete(route('usomaquinas.destroy', $usoMaquina));
    
    $response->assertRedirect(route('usomaquinas.index'));
    $this->assertDatabaseMissing('usos_maquinas', ['id' => $usoMaquina->id]);
});

test('guest cannot access any usomaquina routes', function () {
    $maquina = Maquina::factory()->create();
    $operador = Operador::factory()->create();
    $usoMaquina = UsoMaquina::factory()->create([
        'maquina_id' => $maquina->id,
        'operador_id' => $operador->id,
    ]);
    
    $routes = [
        ['GET', route('usomaquinas.create')],
        ['POST', route('usomaquinas.store')],
        ['GET', route('usomaquinas.show', $usoMaquina)],
        ['GET', route('usomaquinas.edit', $usoMaquina)],
        ['PUT', route('usomaquinas.update', $usoMaquina)],
        ['DELETE', route('usomaquinas.destroy', $usoMaquina)],
    ];
    
    foreach ($routes as [$method, $url]) {
        $response = $this->call($method, $url);
        $response->assertRedirect(route('login'));
    }
});