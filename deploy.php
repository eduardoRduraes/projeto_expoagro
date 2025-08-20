<?php

echo "🚀 Iniciando deploy do Projeto ExpoAgro...\n";

// Configurar diretório do banco - usar variável de ambiente ou caminho absoluto
$dbPath = $_ENV['DB_DATABASE'] ?? '/app/database/banco.sqlite';
$dbDir = dirname($dbPath);

echo "📍 Caminho do banco: {$dbPath}\n";
echo "📁 Diretório do banco: {$dbDir}\n";

// Criar diretório do banco se não existir
if (!is_dir($dbDir)) {
    if (mkdir($dbDir, 0755, true)) {
        echo "✅ Diretório criado: {$dbDir}\n";
    } else {
        echo "❌ Erro ao criar diretório: {$dbDir}\n";
        exit(1);
    }
} else {
    echo "📁 Diretório já existe: {$dbDir}\n";
}

// Criar arquivo do banco se não existir
if (!file_exists($dbPath)) {
    if (touch($dbPath)) {
        echo "✅ Arquivo do banco criado: {$dbPath}\n";
    } else {
        echo "❌ Erro ao criar arquivo do banco: {$dbPath}\n";
        exit(1);
    }
} else {
    echo "🗄️ Arquivo do banco já existe: {$dbPath}\n";
}

// Definir a variável de ambiente para os comandos Artisan
$_ENV['DB_DATABASE'] = $dbPath;
putenv("DB_DATABASE={$dbPath}");

echo "🔧 Variável DB_DATABASE definida: " . getenv('DB_DATABASE') . "\n";

// Comandos Laravel
$commands = [
    'php artisan key:generate --force' => 'Gerando chave da aplicação',
    'php artisan config:clear' => 'Limpando cache de configuração',
    'php artisan migrate --force' => 'Executando migrações',
    'php artisan db:seed --force' => 'Executando seeders',
    'php artisan route:cache' => 'Criando cache de rotas',
    'php artisan view:cache' => 'Criando cache de views',
    'php artisan config:cache' => 'Criando cache de configuração'
];

foreach ($commands as $command => $description) {
    echo "⚡ {$description}...\n";
    $output = [];
    $returnCode = 0;
    exec($command . ' 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "✅ {$description} - Sucesso\n";
    } else {
        echo "⚠️ {$description} - Aviso (código: {$returnCode})\n";
        if (!empty($output)) {
            echo "   Saída: " . implode("\n   ", $output) . "\n";
        }
        // Continuar mesmo com avisos
    }
}

echo "🎉 Deploy concluído com sucesso!\n";
echo "🌐 Iniciando servidor na porta " . ($_ENV['PORT'] ?? '8000') . "...\n";

// Iniciar servidor
$port = $_ENV['PORT'] ?? 8000;
passthru("php artisan serve --host=0.0.0.0 --port={$port}");