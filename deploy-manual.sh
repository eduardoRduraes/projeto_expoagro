#!/bin/bash

# Script de Deploy Manual para KingHost
# Execute este script caso o GitHub Actions não funcione

echo "=== Deploy Manual para KingHost ==="
echo "Iniciando processo de deploy..."

# Verificar se estamos na branch main
CURRENT_BRANCH=$(git branch --show-current)
if [ "$CURRENT_BRANCH" != "main" ]; then
    echo "❌ Erro: Você deve estar na branch main para fazer deploy"
    echo "Branch atual: $CURRENT_BRANCH"
    exit 1
fi

# Verificar se há mudanças não commitadas
if [ -n "$(git status --porcelain)" ]; then
    echo "❌ Erro: Há mudanças não commitadas. Faça commit antes do deploy."
    git status --short
    exit 1
fi

echo "✅ Verificações iniciais OK"

# Instalar dependências do Composer
echo "📦 Instalando dependências do Composer..."
composer install --optimize-autoloader --no-dev --no-interaction
if [ $? -ne 0 ]; then
    echo "❌ Erro ao instalar dependências do Composer"
    exit 1
fi

# Instalar dependências do NPM
echo "📦 Instalando dependências do NPM..."
npm ci
if [ $? -ne 0 ]; then
    echo "❌ Erro ao instalar dependências do NPM"
    exit 1
fi

# Compilar assets
echo "🔨 Compilando assets..."
npm run build
if [ $? -ne 0 ]; then
    echo "❌ Erro ao compilar assets"
    exit 1
fi

# Criar diretório de deploy
echo "📁 Preparando arquivos para deploy..."
rm -rf deploy/
mkdir -p deploy

# Copiar arquivos necessários
rsync -av \
    --exclude='node_modules' \
    --exclude='.git' \
    --exclude='tests' \
    --exclude='.env*' \
    --exclude='storage/logs/*' \
    --exclude='deploy' \
    --exclude='*.sh' \
    . deploy/

# Copiar arquivo .env de produção
if [ -f ".env.production" ]; then
    cp .env.production deploy/.env
    echo "✅ Arquivo .env de produção copiado"
else
    echo "⚠️  Aviso: Arquivo .env.production não encontrado"
    echo "   Você precisará criar o arquivo .env manualmente no servidor"
fi

# Criar arquivo .htaccess para o diretório raiz
cat > deploy/.htaccess << 'EOF'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
EOF

# Criar arquivo de informações do deploy
cat > deploy/DEPLOY_INFO.txt << EOF
Deploy realizado em: $(date)
Commit: $(git rev-parse HEAD)
Branch: $(git branch --show-current)
Usuário: $(git config user.name)
EOF

echo "✅ Arquivos preparados em ./deploy/"

# Criar arquivo ZIP para upload
echo "📦 Criando arquivo ZIP..."
cd deploy
zip -r ../projeto-expoagro-deploy.zip . -x "*.DS_Store" "*Thumbs.db"
cd ..

echo ""
echo "🎉 Deploy preparado com sucesso!"
echo ""
echo "Próximos passos:"
echo "1. Faça upload do arquivo 'projeto-expoagro-deploy.zip' para seu FTP"
echo "2. Extraia o arquivo no diretório raiz da hospedagem"
echo "3. Configure o arquivo .env com suas credenciais"
echo "4. Execute os comandos de otimização no servidor:"
echo "   php artisan migrate --force"
echo "   php artisan config:cache"
echo "   php artisan route:cache"
echo "   php artisan view:cache"
echo "   php artisan optimize"
echo ""
echo "📁 Arquivos disponíveis:"
echo "   - ./deploy/ (diretório com todos os arquivos)"
echo "   - ./projeto-expoagro-deploy.zip (arquivo compactado)"
echo ""
echo "📖 Consulte DEPLOY_KINGHOST.md para instruções detalhadas"

# Limpar dependências de desenvolvimento
echo "🧹 Restaurando dependências de desenvolvimento..."
composer install

echo "✅ Deploy manual concluído!"