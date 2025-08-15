<?php

use App\Models\Maquina;
use App\Models\Manutencao;
use App\Models\User;

test('authenticated user can view manutencoes index', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('manutencoes.index'));
    
    $response->assertStatus(200);
    $response->assertViewIs('manutencoes.index');
});

test('guest cannot view manutencoes index', function () {
    $response = $this->get(route('manutencoes.index'));
    
    $response->assertRedirect(route('login'));
});

test('authenticated user can view create manutencao form', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('manutencoes.create'));
    
    $response->assertStatus(200);
    $response->assertViewIs('manutencoes.create');
});

test('authenticated user can store a new manutencao', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    
    $manutencaoData = [
        'descricao' => 'Troca de óleo e filtros',
        'tipo' => Manutencao::TIPO_PREVENTIVA,
        'status' => Manutencao::STATUS_MANUTENCAO,
        'custo' => 250.50,
        'data_manutencao' => '2024-01-15',
        'responsavel' => 'João Mecânico',
        'maquina_id' => $maquina->id,
    ];
    
    $response = $this->actingAs($user)->post(route('manutencoes.store'), $manutencaoData);
    
    $response->assertRedirect(route('manutencoes.index'));
    $this->assertDatabaseHas('manutencoes', [
        'descricao' => 'Troca de óleo e filtros',
        'tipo' => Manutencao::TIPO_PREVENTIVA,
        'status' => Manutencao::STATUS_MANUTENCAO,
        'custo' => 250.50,
        'responsavel' => 'João Mecânico',
        'maquina_id' => $maquina->id,
    ]);
});

test('manutencao store validation fails with invalid data', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post(route('manutencoes.store'), [
        'descricao' => '', // required field empty
        'tipo' => 'invalid_type',
        'status' => 'invalid_status',
        'custo' => 'invalid_cost',
        'data_manutencao' => 'invalid_date',
        'responsavel' => '',
        'maquina_id' => 999, // non-existent ID
    ]);
    
    $response->assertSessionHasErrors(['descricao', 'tipo', 'custo', 'data_manutencao', 'responsavel', 'maquina_id']);
});

test('authenticated user can view a specific manutencao', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    $manutencao = Manutencao::factory()->create([
        'maquina_id' => $maquina->id,
    ]);
    
    $response = $this->actingAs($user)->get(route('manutencoes.show', $manutencao));
    
    $response->assertStatus(200);
    $response->assertViewIs('manutencoes.show');
    $response->assertViewHas('manutencao', $manutencao);
});

test('authenticated user can view edit manutencao form', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    $manutencao = Manutencao::factory()->create([
        'maquina_id' => $maquina->id,
    ]);
    
    $response = $this->actingAs($user)->get(route('manutencoes.edit', $manutencao));
    
    $response->assertStatus(200);
    $response->assertViewIs('manutencoes.edit');
    $response->assertViewHas('manutencao', $manutencao);
});

test('authenticated user can update a manutencao', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    $manutencao = Manutencao::factory()->create([
        'maquina_id' => $maquina->id,
    ]);
    
    $updatedData = [
        'descricao' => 'Manutenção atualizada',
        'tipo' => Manutencao::TIPO_CORRETIVA,
        'status' => Manutencao::STATUS_LIVRE,
        'custo' => 350.75,
        'data_manutencao' => '2024-01-16',
        'responsavel' => 'Novo responsável',
        'maquina_id' => $maquina->id,
    ];
    
    $response = $this->actingAs($user)->put(route('manutencoes.update', $manutencao), $updatedData);
    
    $response->assertRedirect(route('manutencoes.index'));
    
    $manutencao->refresh();
    expect($manutencao->descricao)->toBe('Manutenção atualizada');
    expect($manutencao->responsavel)->toBe('Novo responsável');
});

test('authenticated user can delete a manutencao', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    $manutencao = Manutencao::factory()->create([
        'maquina_id' => $maquina->id,
    ]);
    
    $response = $this->actingAs($user)->delete(route('manutencoes.destroy', $manutencao));
    
    $response->assertRedirect(route('manutencoes.index'));
    
    $this->assertDatabaseMissing('manutencoes', [
        'id' => $manutencao->id
    ]);
});

test('guest cannot access any manutencao routes', function () {
    $maquina = Maquina::factory()->create();
    $manutencao = Manutencao::factory()->create([
        'maquina_id' => $maquina->id,
    ]);
    
    $routes = [
        ['GET', route('manutencoes.create')],
        ['POST', route('manutencoes.store')],
        ['GET', route('manutencoes.show', $manutencao)],
        ['GET', route('manutencoes.edit', $manutencao)],
        ['PUT', route('manutencoes.update', $manutencao)],
        ['DELETE', route('manutencoes.destroy', $manutencao)],
    ];
    
    foreach ($routes as [$method, $url]) {
        $response = $this->call($method, $url);
        $response->assertRedirect(route('login'));
    }
});