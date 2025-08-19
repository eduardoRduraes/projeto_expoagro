# 🔑 Valores dos Secrets para GitHub Actions

## ⚠️ CONFIDENCIAL - Use estes valores exatos no GitHub Secrets

Baseado nas informações do painel KingHost:

### 📡 Configurações FTP

```
FTP_HOST
ftp.projetoerpagricola.kinghost.net

FTP_USERNAME
projetoerpagricola

FTP_PASSWORD
d12198612E!

FTP_SERVER_DIR
/home/projetoerpagricola
```

### 🗄️ Configurações MySQL

```
DB_HOST
mysql.projetoerpagricola.kinghost.net

DB_DATABASE
projetoerpagri

DB_USERNAME
projetoerpagricola

DB_PASSWORD
d12198612E
```

### 🌐 Configurações da Aplicação

```
APP_URL
https://www.projetoerpagricola.kinghost.net

APP_KEY
base64:pLl0ZPdecYYfplfGrqcCyMNUUAhCxwjUCANf1Siq28s=
```

---

## 🚀 Como Configurar no GitHub

1. Vá para: **Settings > Secrets and variables > Actions**
2. Clique em **"New repository secret"** para cada um:

### Secrets Obrigatórios:
- `FTP_HOST` → `ftp.projetoerpagricola.kinghost.net`
- `FTP_USERNAME` → `projetoerpagricola`
- `FTP_PASSWORD` → `d12198612E!`
- `FTP_SERVER_DIR` → `/home/projetoerpagricola`
- `DB_HOST` → `mysql.projetoerpagricola.kinghost.net`
- `DB_DATABASE` → `projetoerpagri`
- `DB_USERNAME` → `projetoerpagricola`
- `DB_PASSWORD` → `d12198612E`
- `APP_URL` → `https://www.projetoerpagricola.kinghost.net`
- `APP_KEY` → `base64:pLl0ZPdecYYfplfGrqcCyMNUUAhCxwjUCANf1Siq28s=`

## ✅ Próximos Passos

1. **Configure todos os secrets acima no GitHub**
2. **Gere o APP_KEY**:
   ```bash
   php artisan key:generate --show
   ```
3. **Teste o deploy** fazendo um push ou executando o workflow manualmente

---

⚠️ **IMPORTANTE**: Mantenha este arquivo seguro e não o compartilhe publicamente!