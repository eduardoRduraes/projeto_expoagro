#!/bin/bash

echo "=== PREPARANDO DEPLOY PARA RAILWAY ==="

# Copiar arquivo de configuração
cp .env.railway .env

# Gerar chave
php artisan key:generate --force

# Criar banco SQLite
touch database/database.sqlite

# Executar migrações
php artisan migrate --force

# Executar seeders
php artisan db:seed --force

# Criar cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== PROJETO PREPARADO PARA RAILWAY ==="
echo "Agora faça:"
echo "1. git add ."
echo "2. git commit -m 'Deploy para Railway'"
echo "3. git push origin main"