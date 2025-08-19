# 🌾 Projeto ExpoAgro

Sistema de gerenciamento para controle de máquinas agrícolas, operadores e manutenções.

## 🚀 Deploy Automático

[![Deploy to Railway](https://railway.app/button.svg)](https://railway.app/new/template)

Este projeto está configurado para deploy automático no **Railway** via GitHub Actions.

## 📋 Sobre o Sistema

Sistema web desenvolvido em Laravel para gerenciamento completo de implementos agrícolas, operadores, manutenções e relatórios de produtividade.

## 📋 Funcionalidades

### 🔐 Autenticação
- Sistema de login e registro de usuários
- Controle de acesso às funcionalidades
- Perfil de usuário editável

### 🚜 Gestão de Máquinas
- Cadastro completo de implementos agrícolas
- Controle de status (livre, em uso, em manutenção)
- Histórico de uso e manutenções
- Informações técnicas detalhadas

### 👨‍🌾 Gestão de Operadores
- Cadastro de operadores com validação de CPF
- Controle de habilitações e especialidades
- Histórico de operações

### 🔧 Controle de Manutenções
- Registro de manutenções preventivas e corretivas
- Controle de custos e responsáveis
- Histórico completo por máquina
- Status de manutenções pendentes

### 📊 Uso de Máquinas
- Registro de uso diário das máquinas
- Controle de horas trabalhadas
- Associação operador-máquina
- Cálculo de produtividade

### 📈 Relatórios
- Relatório de uso de máquinas
- Relatório de custos de manutenção
- Relatório de produtividade
- Dashboard com estatísticas gerais

## 🛠️ Tecnologias Utilizadas

- **Backend:** Laravel 11.x
- **Frontend:** Blade Templates + Tailwind CSS
- **Banco de Dados:** MySQL/SQLite
- **Autenticação:** Laravel Breeze
- **Testes:** PHPUnit/Pest

## 📋 Requisitos do Sistema

- PHP >= 8.2
- Composer
- Node.js >= 16.x
- NPM ou Yarn
- MySQL >= 8.0 ou SQLite
- Git

## 🚀 Deploy no Railway

### Opção 1: Deploy Automático (Recomendado)
1. Faça fork deste repositório
2. Conecte seu GitHub ao Railway
3. Siga o guia completo: [RAILWAY_SETUP.md](RAILWAY_SETUP.md)

### Opção 2: Instalação Local

#### 1. Clone o repositório
```bash
git clone https://github.com/eduardoRduraes/projeto_expoagro.git
cd projeto_expoagro
```

### 2. Instale as dependências do PHP
```bash
composer install
```

### 3. Instale as dependências do Node.js
```bash
npm install
```

### 4. Configure o ambiente
```bash
# Copie o arquivo de configuração
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 5. Configure o banco de dados
Edite o arquivo `.env` com suas configurações de banco:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestor_implementos
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

**Ou use SQLite para desenvolvimento:**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/caminho/absoluto/para/database.sqlite
```

### 6. Execute as migrações
```bash
# Crie o banco de dados (se usando SQLite)
touch database/database.sqlite

# Execute as migrações
php artisan migrate

# (Opcional) Execute os seeders para dados de exemplo
php artisan db:seed
```

### 7. Compile os assets
```bash
# Para desenvolvimento
npm run dev

# Para produção
npm run build
```

### 8. Inicie o servidor
```bash
php artisan serve
```

O sistema estará disponível em: `http://localhost:8000`

## 🧪 Executando os Testes

O projeto possui uma suíte completa de testes (83 testes):

```bash
# Executar todos os testes
php artisan test

# Executar testes com cobertura
php artisan test --coverage

# Executar testes específicos
php artisan test --filter=MaquinaTest
```

## 📁 Estrutura do Projeto

```
app/
├── Http/Controllers/     # Controllers da aplicação
├── Models/              # Models Eloquent
├── Rules/               # Regras de validação customizadas
└── ...

database/
├── migrations/          # Migrações do banco
├── factories/           # Factories para testes
└── seeders/            # Seeders

resources/
├── views/              # Templates Blade
├── css/                # Estilos CSS
└── js/                 # JavaScript

tests/
├── Feature/            # Testes de funcionalidade
└── Unit/               # Testes unitários
```

## 🎯 Como Usar

### 1. Primeiro Acesso
1. Acesse `http://localhost:8000`
2. Clique em "Register" para criar uma conta
3. Faça login com suas credenciais

### 2. Cadastro Inicial
1. **Operadores:** Cadastre os operadores que utilizarão as máquinas
2. **Máquinas:** Cadastre os implementos agrícolas
3. **Uso:** Registre o uso diário das máquinas
4. **Manutenções:** Registre manutenções quando necessário

### 3. Relatórios
- Acesse o menu "Relatórios" para visualizar:
  - Uso de máquinas por período
  - Custos de manutenção
  - Produtividade dos operadores

## 🔧 Comandos Úteis

```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Recriar banco de dados
php artisan migrate:fresh --seed

# Gerar factory/seeder
php artisan make:factory NomeFactory
php artisan make:seeder NomeSeeder

# Executar queue (se necessário)
php artisan queue:work
```

## 🤝 Contribuindo

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 📞 Suporte

Para suporte ou dúvidas:
- Abra uma [issue](https://github.com/eduardoRduraes/projeto_expoagro/issues)
- Entre em contato: [seu-email@exemplo.com]

---

**Desenvolvido com ❤️ para a gestão eficiente de implementos agrícolas**
