# 🚨 CONFIGURAÇÃO URGENTE - GitHub Secrets

## ❌ Erro Atual: "Input required and not supplied: server"

**CAUSA**: Os secrets do GitHub não estão configurados.

## ✅ SOLUÇÃO RÁPIDA

### 1. Acesse as Configurações do GitHub
1. Vá para o seu repositório no GitHub
2. Clique em **Settings** (Configurações)
3. No menu lateral, clique em **Secrets and variables** > **Actions**

### 2. Adicione os Secrets Obrigatórios

Clique em **"New repository secret"** para cada um:

#### 🔑 FTP_HOST
- **Name**: `FTP_HOST`
- **Secret**: `ftp.seudominio.com.br` (ou o servidor FTP do KingHost)

#### 🔑 FTP_USERNAME
- **Name**: `FTP_USERNAME`
- **Secret**: Seu usuário FTP do KingHost

#### 🔑 FTP_PASSWORD
- **Name**: `FTP_PASSWORD`
- **Secret**: Sua senha FTP do KingHost

#### 🔑 FTP_SERVER_DIR
- **Name**: `FTP_SERVER_DIR`
- **Secret**: `/public_html` (ou o diretório do seu site)

#### 🔑 APP_KEY
- **Name**: `APP_KEY`
- **Secret**: Execute `php artisan key:generate --show` e copie o resultado

#### 🔑 APP_URL
- **Name**: `APP_URL`
- **Secret**: `https://seudominio.com.br`

### 3. Teste o Deploy

Após configurar os secrets:
1. Faça um novo commit/push
2. Ou vá em **Actions** > **Deploy to KingHost** > **Run workflow**

---

## 📋 Checklist de Verificação

- [ ] FTP_HOST configurado
- [ ] FTP_USERNAME configurado
- [ ] FTP_PASSWORD configurado
- [ ] FTP_SERVER_DIR configurado
- [ ] APP_KEY configurado
- [ ] APP_URL configurado

**✅ Todos configurados? O erro será resolvido!**

---

## 🆘 Precisa de Ajuda?

1. **Não sabe as credenciais FTP?**
   - Acesse o painel do KingHost
   - Vá em "Hospedagem" > "FTP"

2. **Erro persiste?**
   - Verifique se todos os secrets foram salvos
   - Confirme se os nomes estão exatos (maiúsculas/minúsculas)

3. **Como gerar APP_KEY?**
   ```bash
   php artisan key:generate --show
   ```

Após configurar, o deploy funcionará automaticamente! 🚀