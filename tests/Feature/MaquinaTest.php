<?php

use App\Models\Maquina;
use App\Models\User;

test('authenticated user can view maquinas index', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('maquinas.index'));
    
    $response->assertStatus(200);
    $response->assertViewIs('maquinas.index');
});

test('guest cannot view maquinas index', function () {
    $response = $this->get(route('maquinas.index'));
    
    $response->assertRedirect(route('login'));
});

test('authenticated user can view create maquina form', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('maquinas.create'));
    
    $response->assertStatus(200);
    $response->assertViewIs('maquinas.create');
});

test('authenticated user can store a new maquina', function () {
    $user = User::factory()->create();
    
    $maquinaData = [
        'nome' => 'Trator John Deere',
        'modelo' => '5075E',
        'numero_serie' => 'JD123456',
        'tipo' => 'trator',
        'ano' => 2020,
        'horas_totais' => 1500.5,
        'status' => Maquina::STATUS_LIVRE,
    ];
    
    $response = $this->actingAs($user)->post(route('maquinas.store'), $maquinaData);
    
    $response->assertRedirect(route('maquinas.index'));
    $this->assertDatabaseHas('maquinas', $maquinaData);
});

test('maquina store validation fails with invalid data', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post(route('maquinas.store'), [
        'nome' => '', // required field empty
        'modelo' => '',
        'numero_serie' => '',
        'tipo' => '',
        'ano' => 'invalid_year',
        'horas_totais' => 'invalid_hours',
    ]);
    
    $response->assertSessionHasErrors(['nome', 'numero_serie', 'tipo', 'ano', 'status', 'horas_totais']);
});

test('authenticated user can view a specific maquina', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    
    $response = $this->actingAs($user)->get(route('maquinas.show', $maquina));
    
    $response->assertStatus(200);
    $response->assertViewIs('maquinas.show');
    $response->assertViewHas('maquina', $maquina);
});

test('authenticated user can view edit maquina form', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    
    $response = $this->actingAs($user)->get(route('maquinas.edit', $maquina));
    
    $response->assertStatus(200);
    $response->assertViewIs('maquinas.edit');
    $response->assertViewHas('maquina', $maquina);
});

test('authenticated user can update a maquina', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    
    $updatedData = [
        'nome' => 'Trator Atualizado',
        'modelo' => 'Modelo Atualizado',
        'numero_serie' => $maquina->numero_serie,
        'tipo' => 'trator',
        'ano' => 2021,
        'horas_totais' => 2000.0,
        'status' => Maquina::STATUS_EM_SERVICO,
    ];
    
    $response = $this->actingAs($user)->put(route('maquinas.update', $maquina), $updatedData);
    
    $response->assertRedirect(route('maquinas.index'));
    $this->assertDatabaseHas('maquinas', array_merge(['id' => $maquina->id], $updatedData));
});

test('authenticated user can delete a maquina', function () {
    $user = User::factory()->create();
    $maquina = Maquina::factory()->create();
    
    $response = $this->actingAs($user)->delete(route('maquinas.destroy', $maquina));
    
    $response->assertRedirect(route('maquinas.index'));
    $this->assertDatabaseMissing('maquinas', ['id' => $maquina->id]);
});

test('guest cannot access any maquina routes', function () {
    $maquina = Maquina::factory()->create();
    
    $routes = [
        ['GET', route('maquinas.create')],
        ['POST', route('maquinas.store')],
        ['GET', route('maquinas.show', $maquina)],
        ['GET', route('maquinas.edit', $maquina)],
        ['PUT', route('maquinas.update', $maquina)],
        ['DELETE', route('maquinas.destroy', $maquina)],
    ];
    
    foreach ($routes as [$method, $url]) {
        $response = $this->call($method, $url);
        $response->assertRedirect(route('login'));
    }
});