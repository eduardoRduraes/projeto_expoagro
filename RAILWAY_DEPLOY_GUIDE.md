# 🚀 Guia Completo: Deploy Laravel no Railway com Nixpacks

## 📋 Pré-requisitos

✅ **Conta no GitHub** com repositório do projeto  
✅ **Conta no Railway** ([railway.app](https://railway.app))  
✅ **Projeto Laravel** funcionando localmente  

## 🔧 Passo 1: Preparar o Projeto

### 1.1 Verificar Arquivos Essenciais

Certifique-se que seu projeto tem:

```bash
✅ composer.json
✅ package.json  
✅ .env.example
✅ nixpacks.toml (já criado!)
```

### 1.2 Configurar .env.example

Atualize seu `.env.example` com as variáveis necessárias:

```env
APP_NAME="Projeto ExpoAgro"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://seu-projeto.up.railway.app

# Localização
APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_FAKER_LOCALE=pt_BR

# Logs
LOG_CHANNEL=stderr
LOG_LEVEL=error

# Banco de Dados Railway
DB_CONNECTION=mysql
DB_HOST=${MYSQL_HOST}
DB_PORT=${MYSQL_PORT}
DB_DATABASE=${MYSQL_DATABASE}
DB_USERNAME=${MYSQL_USER}
DB_PASSWORD=${MYSQL_PASSWORD}

# Sessão e Cache
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Email (opcional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

## 🚀 Passo 2: Configurar Railway

### 2.1 Criar Projeto no Railway

1. **Acesse** [railway.app](https://railway.app)
2. **Faça login** com GitHub
3. **Clique** em **"New Project"**
4. **Selecione** **"Deploy from GitHub repo"**
5. **Escolha** o repositório `projeto_expoagro`
6. **Aguarde** - Railway detectará automaticamente que é Laravel!

### 2.2 Adicionar Banco MySQL

1. **No dashboard** do projeto, clique **"+ New"**
2. **Selecione** **"Database"** → **"Add MySQL"**
3. **Aguarde** a criação (1-2 minutos)
4. **Anote** - As credenciais aparecerão automaticamente

### 2.3 Configurar Variáveis de Ambiente

**No serviço principal** (não no MySQL), vá na aba **"Variables"**:

#### 🔑 Variáveis Obrigatórias

```env
# Aplicação
APP_NAME=Projeto ExpoAgro
APP_ENV=production
APP_KEY=base64:pLl0ZPdecYYfplfGrqcCyMNUUAhCxwjUCANf1Siq28s=
APP_DEBUG=false
APP_URL=https://seu-projeto.up.railway.app

# Localização
APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_FAKER_LOCALE=pt_BR

# Logs
LOG_CHANNEL=stderr
LOG_LEVEL=error

# Banco (Railway MySQL - Use as variáveis automáticas)
DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

# Sessão e Cache
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_DRIVER=database
QUEUE_CONNECTION=database
```

#### 📧 Email (Opcional)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@gmail.com
MAIL_FROM_NAME=Projeto ExpoAgro
```

### 2.4 Gerar APP_KEY

**Opção 1: Localmente**
```bash
php artisan key:generate --show
# Copie o resultado para APP_KEY no Railway
```

**Opção 2: Online**
```
base64:pLl0ZPdecYYfplfGrqcCyMNUUAhCxwjUCANf1Siq28s=
# Use esta chave temporária (gere uma nova depois)
```

## 🌐 Passo 3: Configurar Domínio

### 3.1 Domínio Automático

1. **Na aba "Settings"** do serviço
2. **Seção "Domains"**
3. **Clique "Generate Domain"**
4. **Copie** a URL gerada (ex: `projeto-expoagro-production.up.railway.app`)
5. **Atualize** `APP_URL` nas variáveis

### 3.2 Domínio Customizado (Opcional)

1. **Clique "Custom Domain"**
2. **Digite** seu domínio (ex: `meusite.com`)
3. **Configure** DNS conforme instruções

## 🚀 Passo 4: Deploy!

### 4.1 Primeiro Deploy

1. **Commit** suas mudanças:
```bash
git add .
git commit -m "Configure Railway deployment with Nixpacks"
git push origin main
```

2. **Railway detecta** automaticamente
3. **Build inicia** (2-5 minutos)
4. **Deploy completo!** 🎉

### 4.2 Verificar Deploy

**Logs em tempo real:**
1. **Dashboard Railway** → **"Deployments"**
2. **Clique** no deploy ativo
3. **Veja** logs de build e runtime

**Testar aplicação:**
1. **Acesse** a URL do seu projeto
2. **Verifique** se carrega corretamente
3. **Teste** login/cadastro

## 📊 Passo 5: Monitoramento

### 5.1 Railway Dashboard

- **📈 Métricas**: CPU, RAM, Requests
- **📋 Logs**: Erros e informações
- **🚀 Deployments**: Histórico completo
- **💾 Database**: Conexões e queries

### 5.2 Railway CLI (Opcional)

```bash
# Instalar
npm install -g @railway/cli

# Login
railway login

# Ver logs em tempo real
railway logs

# Executar comandos
railway run php artisan migrate
```

## 🔧 Troubleshooting

### ❌ Erro: "Application key not set"

**Solução:**
```bash
# Gere nova chave
php artisan key:generate --show
# Adicione em APP_KEY no Railway
```

### ❌ Erro: "Database connection failed"

**Verificar:**
1. ✅ MySQL service está rodando
2. ✅ Variáveis `DB_*` estão corretas
3. ✅ Usar `${{MYSQL_HOST}}` (com chaves duplas)

### ❌ Erro: "Permission denied"

**Solução:** Já configurado no `nixpacks.toml`:
```toml
[phases.build]
cmds = [
    'chmod -R 755 storage bootstrap/cache'
]
```

### ❌ Build muito lento

**Otimizações no `nixpacks.toml`:**
- ✅ `--no-dev` no composer
- ✅ `--only=production` no npm
- ✅ Cache de configurações

## ✅ Vantagens do Nixpacks

🚀 **Deploy em 2-5 minutos**  
🔧 **Zero configuração manual**  
📦 **Build otimizado automaticamente**  
🔄 **Auto-deploy no push**  
💾 **Banco incluído gratuitamente**  
🔒 **SSL automático**  
📊 **Monitoramento integrado**  
🔙 **Rollback com 1 clique**  

## 🎯 Próximos Passos

1. ✅ **Teste** todas as funcionalidades
2. ✅ **Configure** email se necessário
3. ✅ **Monitore** logs por alguns dias
4. ✅ **Documente** credenciais importantes
5. ✅ **Configure** backups automáticos

---

## 🆘 Suporte

**Problemas?**
- 📖 [Documentação Railway](https://docs.railway.app)
- 💬 [Discord Railway](https://railway.app/discord)
- 🐛 [GitHub Issues](https://github.com/railwayapp/railway/issues)

**🎉 Parabéns! Seu Laravel está rodando no Railway com Nixpacks!**