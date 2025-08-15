<?php

use App\Models\User;

test('authenticated user can view dashboard', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('dashboard'));
    
    $response->assertStatus(200);
    $response->assertViewIs('dashboard');
});

test('guest cannot view dashboard', function () {
    $response = $this->get(route('dashboard'));
    
    $response->assertRedirect(route('login'));
});

test('dashboard displays correct statistics', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('dashboard'));
    
    $response->assertStatus(200);
    $response->assertViewHas('totalMaquinas');
    $response->assertViewHas('totalOperadores');
    $response->assertViewHas('totalUsos');
    $response->assertViewHas('totalManutencoes');
});

test('dashboard shows navigation links', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get(route('dashboard'));
    
    $response->assertStatus(200);
    $response->assertSee('Nova Máquina');
    $response->assertSee('Novo Operador');
    $response->assertSee('Registrar Uso');
    $response->assertSee('Nova Manutenção');
    $response->assertSee('Relatórios');
    $response->assertSee('Ver Máquinas');
});

test('root route redirects to login for guests', function () {
    $response = $this->get('/');
    
    $response->assertStatus(200);
    $response->assertViewIs('auth.login');
});

test('authenticated user accessing root is redirected to dashboard', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/');
    
    $response->assertStatus(200);
    $response->assertViewIs('auth.login');
});