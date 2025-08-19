# 🚀 Guia Completo de Deploy no Railway

## 📋 Pré-requisitos

1. **Conta no Railway**: [railway.app](https://railway.app)
2. **Repositório no GitHub** conectado
3. **Banco de dados MySQL** (Railway fornece gratuitamente)

## 🔧 Configuração Passo a Passo

### 1. Criar Projeto no Railway

1. Acesse [railway.app](https://railway.app)
2. Clique em **"New Project"**
3. Selecione **"Deploy from GitHub repo"**
4. Escolha o repositório `projeto_expoagro`
5. Railway detectará automaticamente que é um projeto PHP/Laravel

### 2. Adicionar Banco de dados MySQL

1. No dashboard do projeto, clique em **"+ New"**
2. Selecione **"Database"** → **"Add MySQL"**
3. Railway criará automaticamente um banco MySQL
4. Anote as credenciais que aparecerão na aba **"Connect"**

### 3. Configurar Variáveis de Ambiente

Na aba **"Variables"** do seu serviço, adicione:

#### 🔑 Variáveis Obrigatórias

```env
# Aplicação
APP_NAME="Projeto ExpoAgro"
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

# Banco de Dados (Railway MySQL)
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

# Email (opcional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@gmail.com
MAIL_FROM_NAME="Projeto ExpoAgro"
```

#### 🔐 Secrets do GitHub Actions

No GitHub, vá em **Settings** → **Secrets and variables** → **Actions** e adicione:

```
RAILWAY_TOKEN=seu_token_railway
RAILWAY_SERVICE_ID=seu_service_id
```

**Como obter esses valores:**

1. **RAILWAY_TOKEN**:
   - Vá em [railway.app/account/tokens](https://railway.app/account/tokens)
   - Clique em **"Create Token"**
   - Copie o token gerado

2. **RAILWAY_SERVICE_ID**:
   - No dashboard do projeto, clique no serviço
   - Na URL, copie o ID após `/service/`
   - Exemplo: `https://railway.app/project/abc123/service/def456` → `def456`

### 4. Configurar Domínio (Opcional)

1. Na aba **"Settings"** do serviço
2. Seção **"Domains"**
3. Clique em **"Generate Domain"** ou adicione domínio customizado

## 🚀 Deploy Automático

Após configurar tudo:

1. **Push para main** → Deploy automático via GitHub Actions
2. **Railway detecta mudanças** → Build e deploy
3. **Migrations executam** automaticamente
4. **Site fica online** em poucos minutos

## 📊 Monitoramento

### Logs em Tempo Real
```bash
# Instalar Railway CLI
npm install -g @railway/cli

# Login
railway login

# Ver logs
railway logs
```

### Dashboard Railway
- **Métricas**: CPU, RAM, Requests
- **Logs**: Erros e informações
- **Deployments**: Histórico de deploys

## ✅ Vantagens do Railway

✅ **Deploy automático** via GitHub  
✅ **Banco de dados incluído** (MySQL gratuito)  
✅ **SSL automático** (HTTPS)  
✅ **Domínio gratuito** (.up.railway.app)  
✅ **Logs em tempo real**  
✅ **Rollback fácil**  
✅ **Escalabilidade automática**  
✅ **Zero configuração** de servidor  

## 🆚 Railway vs KingHost

| Recurso | Railway | KingHost |
|---------|---------|----------|
| Deploy | Automático | Manual/FTP |
| SSL | Automático | Manual |
| Banco | Incluído | Separado |
| Logs | Tempo real | Limitado |
| Escalabilidade | Automática | Manual |
| Preço | Gratuito* | Pago |

*Railway: $5/mês após uso gratuito

## 🔧 Troubleshooting

### Erro de Migração
```bash
# No Railway CLI
railway run php artisan migrate:fresh --seed
```

### Erro de Permissões
```bash
# Adicionar ao nixpacks.toml
[phases.build]
cmds = [
    'chmod -R 755 storage bootstrap/cache'
]
```

### Erro de Build
- Verificar logs no dashboard Railway
- Conferir variáveis de ambiente
- Validar composer.json e package.json

---

**🎉 Pronto! Seu projeto Laravel estará rodando no Railway com deploy automático!**