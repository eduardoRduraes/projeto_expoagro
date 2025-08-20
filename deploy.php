<?php

echo "🚀 Iniciando deploy do Projeto ExpoAgro...\n";
echo "📅 Data/Hora: " . date('Y-m-d H:i:s') . "\n";

// Configurar banco SQLite
$dbPath = '/app/database/banco.sqlite';
$dbDir = dirname($dbPath);

echo "📍 Caminho do banco: {$dbPath}\n";
echo "📁 Diretório do banco: {$dbDir}\n";

// Criar diretório do banco
if (!is_dir($dbDir)) {
    mkdir($dbDir, 0755, true);
    echo "📁 Diretório criado: {$dbDir}\n";
} else {
    echo "📁 Diretório já existe: {$dbDir}\n";
}

// Criar arquivo do banco
if (!file_exists($dbPath)) {
    touch($dbPath);
    echo "✅ Arquivo do banco criado: {$dbPath}\n";
} else {
    echo "🗄️ Arquivo do banco já existe\n";
}

// CRIAR ARQUIVO .ENV
echo "\n=== CRIANDO ARQUIVO .ENV ===\n";
$envContent = <<<ENV
APP_NAME="Projeto ExpoAgro"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://projetoexpoagro.up.railway.app

APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_FAKER_LOCALE=pt_BR

LOG_CHANNEL=single
LOG_LEVEL=error

DB_CONNECTION=sqlite
DB_DATABASE={$dbPath}

SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_STORE=file
QUEUE_CONNECTION=sync

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
ENV;

file_put_contents('/app/.env', $envContent);
echo "✅ Arquivo .env criado\n";

// Definir variáveis de ambiente
$_ENV['DB_CONNECTION'] = 'sqlite';
$_ENV['DB_DATABASE'] = $dbPath;
putenv("DB_CONNECTION=sqlite");
putenv("DB_DATABASE={$dbPath}");

echo "🔧 Variável DB_DATABASE definida: " . getenv('DB_DATABASE') . "\n";

// Comandos Laravel
$commands = [
    'php artisan key:generate --force' => 'Gerando chave da aplicação',
    'php artisan config:clear' => 'Limpando cache de configuração',
    'php artisan migrate --force' => 'Executando migrações',
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
    }
}

echo "🎉 Deploy concluído com sucesso!\n";
echo "🌐 Iniciando servidor na porta " . ($_ENV['PORT'] ?? '8080') . "...\n";

// Iniciar servidor
$port = $_ENV['PORT'] ?? 8080;
passthru("php artisan serve --host=0.0.0.0 --port={$port}");