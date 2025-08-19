# Deploy no KingHost via GitHub Actions

Este guia explica como configurar o deploy automático do projeto Laravel no KingHost usando GitHub Actions.

## Pré-requisitos

- Conta no KingHost com hospedagem ativa
- Repositório no GitHub
- Acesso FTP ao seu painel KingHost

## 1. Configuração no KingHost

### 1.1 Preparar o Ambiente

1. Acesse o painel do KingHost
2. Vá em **Hospedagem** > **Gerenciar**
3. Certifique-se que o PHP está na versão 8.2 ou superior
4. Ative as extensões necessárias:
   - mbstring
   - xml
   - ctype
   - iconv
   - intl
   - pdo_mysql
   - zip
   - unzip

### 1.2 Configurar Banco de Dados

1. No painel KingHost, vá em **Banco de Dados** > **MySQL**
2. Crie um novo banco de dados
3. Anote as informações:
   - Nome do banco
   - Usuário
   - Senha
   - Host (geralmente localhost)

### 1.3 Obter Dados FTP

1. No painel KingHost, vá em **FTP** > **Contas FTP**
2. Anote as informações:
   - Servidor FTP
   - Usuário FTP
   - Senha FTP
   - Diretório (geralmente `/public_html/` ou `/www/`)

## 2. Configuração no GitHub

### 2.1 Secrets do Repositório

1. Vá ao seu repositório no GitHub
2. Clique em **Settings** > **Secrets and variables** > **Actions**
3. Adicione os seguintes secrets:

```
FTP_HOST=seu-dominio.kinghost.net
FTP_USERNAME=seu-usuario-ftp
FTP_PASSWORD=sua-senha-ftp
FTP_SERVER_DIR=/public_html/
```

### 2.2 Variáveis de Ambiente para Produção

Crie também estes secrets para as variáveis de ambiente:

```
APP_NAME=ProjetoExpoAgro
APP_ENV=production
APP_KEY=base64:SUA_CHAVE_AQUI
APP_DEBUG=false
APP_URL=https://seu-dominio.com.br

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario_db
DB_PASSWORD=sua_senha_db

MAIL_MAILER=smtp
MAIL_HOST=smtp.kinghost.net
MAIL_PORT=587
MAIL_USERNAME=seu-email@seu-dominio.com.br
MAIL_PASSWORD=sua-senha-email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@seu-dominio.com.br
MAIL_FROM_NAME="${APP_NAME}"
```

## 3. Configuração do Projeto

### 3.1 Arquivo .env para Produção

Crie um arquivo `.env.production` na raiz do projeto:

```env
APP_NAME="Projeto ExpoAgro"
APP_ENV=production
APP_KEY=base64:SUA_CHAVE_AQUI
APP_DEBUG=false
APP_URL=https://seu-dominio.com.br

APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_FAKER_LOCALE=pt_BR

LOG_CHANNEL=single
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario_db
DB_PASSWORD=sua_senha_db

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.kinghost.net
MAIL_PORT=587
MAIL_USERNAME=seu-email@seu-dominio.com.br
MAIL_PASSWORD=sua-senha-email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@seu-dominio.com.br
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

### 3.2 Gerar APP_KEY

Para gerar uma nova APP_KEY:

```bash
php artisan key:generate --show
```

## 4. Estrutura de Diretórios no KingHost

No seu FTP, organize os arquivos assim:

```
/public_html/
├── public/          # Conteúdo da pasta public do Laravel
│   ├── index.php
│   ├── .htaccess
│   └── build/       # Assets compilados
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env             # Arquivo de produção
└── artisan
```

## 5. Arquivo .htaccess

Crie/edite o arquivo `.htaccess` na pasta `public_html`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

E na pasta `public_html/public/.htaccess`:

```apache
<IfModule mod_negotiation.c>
    Options -MultiViews -Indexes
</IfModule>

<IfModule mod_rewrite.c>
    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## 6. Comandos Pós-Deploy

Após o primeiro deploy, execute via SSH ou painel do KingHost:

```bash
# Gerar chave da aplicação (se necessário)
php artisan key:generate

# Executar migrações
php artisan migrate --force

# Limpar e otimizar cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Criar link simbólico para storage (se necessário)
php artisan storage:link
```

## 7. Permissões de Diretório

Certifique-se que os seguintes diretórios tenham permissão de escrita (755 ou 775):

- `storage/`
- `storage/logs/`
- `storage/framework/`
- `storage/framework/cache/`
- `storage/framework/sessions/`
- `storage/framework/views/`
- `bootstrap/cache/`

## 8. Testando o Deploy

1. Faça um commit e push para a branch `main`
2. Vá em **Actions** no GitHub para acompanhar o deploy
3. Acesse seu domínio para verificar se está funcionando

## 9. Troubleshooting

### Erro 500
- Verifique as permissões dos diretórios
- Confira se o arquivo `.env` está correto
- Verifique os logs em `storage/logs/laravel.log`

### Assets não carregam
- Verifique se o `npm run build` foi executado
- Confirme se a pasta `public/build` foi enviada
- Verifique a configuração do `APP_URL`

### Banco de dados
- Confirme as credenciais do banco
- Execute as migrações: `php artisan migrate --force`
- Verifique se o banco foi criado no painel KingHost

## 10. Monitoramento

- Configure logs de erro
- Monitore o espaço em disco
- Acompanhe os logs de acesso
- Configure backup automático do banco de dados

---

**Importante**: Sempre teste em um ambiente de staging antes de fazer deploy em produção.

**Suporte**: Em caso de problemas, consulte a documentação do KingHost ou entre em contato com o suporte técnico.