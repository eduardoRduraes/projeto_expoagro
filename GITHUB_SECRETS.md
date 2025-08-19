# Configuração dos GitHub Secrets

Este arquivo lista todos os secrets que devem ser configurados no GitHub para o deploy automático funcionar.

## Como Configurar

1. Vá ao seu repositório no GitHub
2. Clique em **Settings** > **Secrets and variables** > **Actions**
3. Clique em **New repository secret**
4. Adicione cada secret listado abaixo

## Secrets Obrigatórios

### Configurações FTP do KingHost

```
FTP_HOST
Valor: seu-dominio.kinghost.net
Descrição: Servidor FTP do KingHost
```

```
FTP_USERNAME
Valor: seu-usuario-ftp
Descrição: Usuário FTP fornecido pelo KingHost
```

```
FTP_PASSWORD
Valor: sua-senha-ftp
Descrição: Senha FTP fornecida pelo KingHost
```

```
FTP_SERVER_DIR
Valor: /public_html/
Descrição: Diretório raiz no servidor (pode ser /www/ dependendo da configuração)
```

### Configurações da Aplicação

```
APP_KEY
Valor: base64:SUA_CHAVE_GERADA_AQUI
Descrição: Chave de criptografia do Laravel (gere com: php artisan key:generate --show)
```

```
APP_URL
Valor: https://seu-dominio.com.br
Descrição: URL completa do seu site
```

### Configurações do Banco de Dados

```
DB_HOST
Valor: localhost
Descrição: Host do banco MySQL (geralmente localhost no KingHost)
```

```
DB_DATABASE
Valor: nome_do_seu_banco
Descrição: Nome do banco de dados criado no painel KingHost
```

```
DB_USERNAME
Valor: usuario_do_banco
Descrição: Usuário do banco de dados
```

```
DB_PASSWORD
Valor: senha_do_banco
Descrição: Senha do banco de dados
```

### Configurações de Email

```
MAIL_USERNAME
Valor: seu-email@seu-dominio.com.br
Descrição: Email configurado no seu domínio
```

```
MAIL_PASSWORD
Valor: senha-do-email
Descrição: Senha do email
```

```
MAIL_FROM_ADDRESS
Valor: seu-email@seu-dominio.com.br
Descrição: Email que aparecerá como remetente
```

## Como Obter as Informações

### Dados FTP
1. Acesse o painel do KingHost
2. Vá em **FTP** > **Contas FTP**
3. Anote servidor, usuário e senha

### Dados do Banco
1. No painel KingHost, vá em **Banco de Dados** > **MySQL**
2. Crie um banco se ainda não tiver
3. Anote nome, usuário e senha

### Chave da Aplicação
```bash
# Execute no seu projeto local
php artisan key:generate --show
```

### Email
1. Configure um email no seu domínio pelo painel KingHost
2. Use as configurações SMTP do KingHost:
   - Host: smtp.kinghost.net
   - Porta: 587
   - Criptografia: TLS

## Verificação

Após configurar todos os secrets, sua lista deve ter:

- ✅ FTP_HOST
- ✅ FTP_USERNAME  
- ✅ FTP_PASSWORD
- ✅ FTP_SERVER_DIR
- ✅ APP_KEY
- ✅ APP_URL
- ✅ DB_HOST
- ✅ DB_DATABASE
- ✅ DB_USERNAME
- ✅ DB_PASSWORD
- ✅ MAIL_USERNAME
- ✅ MAIL_PASSWORD
- ✅ MAIL_FROM_ADDRESS

## Testando

Após configurar todos os secrets:

1. Faça um commit e push para a branch `main`
2. Vá em **Actions** no GitHub
3. Acompanhe o processo de deploy
4. Verifique se o site está funcionando

## Troubleshooting

### Deploy falha na etapa FTP
- Verifique se FTP_HOST, FTP_USERNAME e FTP_PASSWORD estão corretos
- Confirme se FTP_SERVER_DIR existe no servidor

### Site não carrega após deploy
- Verifique se APP_URL está correto
- Confirme se o arquivo .htaccess foi criado
- Verifique permissões das pastas storage/ e bootstrap/cache/

### Erro de banco de dados
- Confirme credenciais do banco (DB_*)
- Execute migrações manualmente se necessário
- Verifique se o banco foi criado no painel KingHost

---

**Importante**: Nunca compartilhe estes valores publicamente. Os secrets do GitHub são seguros e criptografados.