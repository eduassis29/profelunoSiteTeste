# 🚀 Guia de Deploy - Railway.app

## 📋 Pré-requisitos

- Conta no Railway.app
- Docker instalado localmente (para testes)
- Repositório Git com este código

## 🔧 Configuração no Railway

### 1. Criar Novo Projeto no Railway

1. Acesse [railway.app](https://railway.app)
2. Clique em "New Project"
3. Selecione "Deploy from GitHub"
4. Autorize e selecione seu repositório

### 2. Configurar Variáveis de Ambiente

No Dashboard do Railway, adicione os seguintes variables no seu projeto:

```
# App Configuration
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_Generated_Key_Here

# Database PostgreSQL
DB_CONNECTION=pgsql
DB_DATABASE=profeluno
DB_USERNAME=postgres
DB_PASSWORD=${POSTGRES_PASSWORD}

# Host do banco (Railway auto-provision)
DB_HOST=${POSTGRES_HOST}
DB_PORT=${POSTGRES_PORT}

# URLs
LARAVEL_URL=https://your-railway-url.railway.app
API_DOTNET_URL=https://your-railway-dotnet-url.railway.app

# Jitsi
JITSI_URL=https://meet.jit.si/

# Portas
PORT=8000
DOTNET_PORT=8080
```

### 3. Criar PostgreSQL no Railway

1. No seu projeto Railway, clique em "New Service"
2. Selecione "Database" → "PostgreSQL"
3. Railway criará automaticamente: `POSTGRES_HOST`, `POSTGRES_PORT`, `POSTGRES_PASSWORD`, `POSTGRES_URL`

### 4. Gerar APP_KEY para Laravel

Você precisa gerar uma chave criptografada para Laravel:

```bash
# Local, execute:
php -r 'echo "base64:" . base64_encode(random_bytes(32));'
```

Copie a saída e adicione como `APP_KEY` no Railway.

### 5. Deploy

O Railway detectará automaticamente:
- `Dockerfile.prod` ou `docker-compose.prod.yml`
- `Procfile` (se configurado)

Se usar `docker-compose.prod.yml`:

```
# No Railway dashboard
Build Command: docker-compose -f docker-compose.prod.yml build
Start Command: docker-compose -f docker-compose.prod.yml up
```

## 📍 Estrutura de Serviços

A aplicação tem 3 componentes principais:

### Laravel (Port: 8000)
- Frontend com Vite
- API REST
- Session/Queue management
- Dependência: PostgreSQL

### .NET (Port: 8080)
- API Backend
- Integração com Jitsi
- Lógica de negócio
- Dependência: PostgreSQL

### PostgreSQL (Port: 5432)
- Banco de dados compartilhado
- Managed pelo Railway

## 🔄 Environment Variables Reference

| Variável | Descrição | Exemplo |
|----------|-----------|---------|
| `APP_ENV` | Ambiente da aplicação | production |
| `APP_DEBUG` | Debug mode | false |
| `APP_KEY` | Chave criptografia Laravel | base64:... |
| `DB_HOST` | Host do PostgreSQL | railway-postgres-host |
| `DB_PORT` | Porta PostgreSQL | 5432 |
| `DB_DATABASE` | Nome do banco | profeluno |
| `DB_USERNAME` | Usuário DB | postgres |
| `DB_PASSWORD` | Senha DB | (auto-gerada Railway) |
| `PORT` | Porta Laravel | 8000 |
| `DOTNET_PORT` | Porta .NET | 8080 |

## 🐛 Troubleshooting

### Erro de Conexão com Banco de Dados

1. Verifique se PostgreSQL está provisionado no Railway
2. Confirme as variáveis `POSTGRES_HOST`, `POSTGRES_PORT`, `POSTGRES_PASSWORD`
3. Certifique-se que as credenciais são passadas corretamente

### Porta já em uso

Railway gerencia as portas automaticamente. Se receber erro:
- Use PORT e DOTNET_PORT como variáveis
- Não hardcode portas em código

### Migrações não rodando

Adicione logs no início:

```yaml
# docker-compose.prod.yml
laravel:
  command: |
    sh -c "php artisan migrate --force && php -S 0.0.0.0:8000"
```

### Volumes não persistem

Railway não usa volumes locais. Para upload de arquivos:
1. Use storage externo (S3, etc)
2. Ou configure Railway com volumes gerenciados

## 📊 Monitoring

No Railway Dashboard você pode:
- Ver logs em tempo real
- Monitorar CPU/Memória
- Visualizar Health Checks
- Configurar alertas

## 🔐 Segurança

- ✅ APP_DEBUG sempre `false` em production
- ✅ Senhas geradas pelo Railway (nunca hardcode)
- ✅ Use HTTPS (Railway fornece SSL automaticamente)
- ✅ Configure CORS corretamente entre serviços

## 🚀 Deploy Automático

Uma vez conectado ao GitHub:
1. Cada push para a branch principal dispara build automático
2. Railway constrói os containers
3. Aplicação é atualizada automaticamente
4. Histórico de deployments disponível

## 📝 Checklist de Deploy

- [ ] PostgreSQL provisionado e conectado
- [ ] APP_KEY gerado e adicionado
- [ ] Todas variáveis de ambiente configuradas
- [ ] Health checks passando
- [ ] Logs sem erros críticos
- [ ] Endpoints acessíveis
- [ ] Testes básicos de funcionalidade

## 📞 Suporte

Para mais informações:
- [Railway Docs](https://docs.railway.app)
- [Laravel Hosting Guide](https://laravel.com/docs/deployment)
- [ASP.NET Core Deployment](https://learn.microsoft.com/en-us/dotnet/core/deployment/)

