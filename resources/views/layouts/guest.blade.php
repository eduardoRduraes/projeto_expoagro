<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ExpoAgro') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center agro-login-bg">
            <!-- Logo e Título -->
            <div class="text-center mb-8">
                <div class="agro-logo mb-4">
                    <i class="fas fa-seedling"></i>
                </div>
                <h1 class="agro-title">Gestor de Implementos</h1>
                <p class="agro-subtitle">Sistema de Gestão Agrícola</p>
            </div>
            
            <!-- Card de Login -->
            <div class="w-full sm:max-w-md px-8 py-8 agro-login-card">
                {{ $slot }}
            </div>
            
            <!-- Rodapé -->
            <div class="text-center mt-8 agro-footer">
                <p><i class="fas fa-leaf me-2"></i>Cultivando o futuro da agricultura</p>
            </div>
        </div>
    </body>
</html>
