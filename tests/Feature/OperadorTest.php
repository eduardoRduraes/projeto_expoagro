<?php

use App\Models\Operador;
use App\Models\User;

test('authenticated user can view operadores index', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('operadores.index'));
    
    $response->assertStatus(200);
    $response->assertViewIs('operadores.index');
});

test('guest cannot view operadores index', function () {
    $response = $this->get(route('operadores.index'));
    
    $response->assertRedirect(route('login'));
});

test('authenticated user can view create operador form', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('operadores.create'));
    
    $response->assertStatus(200);
    $response->assertViewIs('operadores.create');
});

test('authenticated user can store a new operador', function () {
    $user = User::factory()->create();
    
    $operadorData = [
        'nome' => 'João Silva',
        'cpf' => '111.444.777-35',
        'telefone' => '(11) 99999-9999',
        'categoria_cnh' => 'D',
        'status' => Operador::STATUS_LIVRE,
    ];
    
    $response = $this->actingAs($user)->post(route('operadores.store'), $operadorData);
    
    $response->assertRedirect(route('operadores.index'));
    $this->assertDatabaseHas('operadores', $operadorData);
});

test('operador store validation fails with invalid data', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->post(route('operadores.store'), [
        'nome' => '', // required field empty
        'cpf' => 'invalid_cpf',
        'telefone' => '',
        'categoria_cnh' => '',
    ]);
    
    $response->assertSessionHasErrors(['nome', 'cpf', 'status', 'categoria_cnh']);
});

test('authenticated user can view a specific operador', function () {
    $user = User::factory()->create();
    $operador = Operador::factory()->create();
    
    $response = $this->actingAs($user)->get(route('operadores.show', $operador));
    
    $response->assertStatus(200);
    $response->assertViewIs('operadores.show');
    $response->assertViewHas('operador', $operador);
});

test('authenticated user can view edit operador form', function () {
    $user = User::factory()->create();
    $operador = Operador::factory()->create();
    
    $response = $this->actingAs($user)->get(route('operadores.edit', $operador));
    
    $response->assertStatus(200);
    $response->assertViewIs('operadores.edit');
    $response->assertViewHas('operador', $operador);
});

test('authenticated user can update an operador', function () {
    $user = User::factory()->create();
    $operador = Operador::factory()->create();
    
    $updatedData = [
        'nome' => 'João Silva Atualizado',
        'cpf' => $operador->cpf,
        'telefone' => '(11) 88888-8888',
        'categoria_cnh' => 'C',
        'status' => Operador::STATUS_EM_SERVICO,
    ];
    
    $response = $this->actingAs($user)->put(route('operadores.update', $operador), $updatedData);
    
    $response->assertRedirect(route('operadores.index'));
    $this->assertDatabaseHas('operadores', array_merge(['id' => $operador->id], $updatedData));
});

test('authenticated user can delete an operador', function () {
    $user = User::factory()->create();
    $operador = Operador::factory()->create();
    
    $response = $this->actingAs($user)->delete(route('operadores.destroy', $operador));
    
    $response->assertRedirect(route('operadores.index'));
    $this->assertDatabaseMissing('operadores', ['id' => $operador->id]);
});

test('guest cannot access any operador routes', function () {
    $operador = Operador::factory()->create();
    
    $routes = [
        ['GET', route('operadores.create')],
        ['POST', route('operadores.store')],
        ['GET', route('operadores.show', $operador)],
        ['GET', route('operadores.edit', $operador)],
        ['PUT', route('operadores.update', $operador)],
        ['DELETE', route('operadores.destroy', $operador)],
    ];
    
    foreach ($routes as [$method, $url]) {
        $response = $this->call($method, $url);
        $response->assertRedirect(route('login'));
    }
});