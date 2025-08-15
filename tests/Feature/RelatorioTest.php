<?php

use App\Models\User;

test('authenticated user can view relatorios index', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('relatorios.index'));
    
    $response->assertStatus(200);
    $response->assertViewIs('relatorios.index');
});

test('guest cannot view relatorios index', function () {
    $response = $this->get(route('relatorios.index'));
    
    $response->assertRedirect(route('login'));
});

test('authenticated user can view uso maquinas report', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('relatorios.uso-maquinas'));
    
    $response->assertStatus(200);
    $response->assertViewIs('relatorios.uso-maquinas');
});

test('authenticated user can view uso maquinas report with filters', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('relatorios.uso-maquinas'), [
        'data_inicio' => '2024-01-01',
        'data_fim' => '2024-01-31',
        'maquina_id' => 1,
    ]);
    
    $response->assertStatus(200);
    $response->assertViewIs('relatorios.uso-maquinas');
});

test('guest cannot view uso maquinas report', function () {
    $response = $this->get(route('relatorios.uso-maquinas'));
    
    $response->assertRedirect(route('login'));
});

test('authenticated user can view custos manutencao report', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('relatorios.custos-manutencao'));
    
    $response->assertStatus(200);
    $response->assertViewIs('relatorios.custos-manutencao');
});

test('authenticated user can view custos manutencao report with filters', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('relatorios.custos-manutencao'), [
        'data_inicio' => '2024-01-01',
        'data_fim' => '2024-01-31',
        'maquina_id' => 1,
        'tipo' => 'preventiva',
    ]);
    
    $response->assertStatus(200);
    $response->assertViewIs('relatorios.custos-manutencao');
});

test('guest cannot view custos manutencao report', function () {
    $response = $this->get(route('relatorios.custos-manutencao'));
    
    $response->assertRedirect(route('login'));
});

test('authenticated user can view produtividade report', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('relatorios.produtividade'));
    
    $response->assertStatus(200);
    $response->assertViewIs('relatorios.produtividade');
});

test('authenticated user can view produtividade report with filters', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('relatorios.produtividade'), [
        'data_inicio' => '2024-01-01',
        'data_fim' => '2024-01-31',
        'operador_id' => 1,
        'maquina_id' => 1,
    ]);
    
    $response->assertStatus(200);
    $response->assertViewIs('relatorios.produtividade');
});

test('guest cannot view produtividade report', function () {
    $response = $this->get(route('relatorios.produtividade'));
    
    $response->assertRedirect(route('login'));
});

test('guest cannot access any relatorio routes', function () {
    $routes = [
        ['GET', route('relatorios.index')],
        ['GET', route('relatorios.uso-maquinas')],
        ['GET', route('relatorios.custos-manutencao')],
        ['GET', route('relatorios.produtividade')],
    ];
    
    foreach ($routes as [$method, $url]) {
        $response = $this->call($method, $url);
        $response->assertRedirect(route('login'));
    }
});