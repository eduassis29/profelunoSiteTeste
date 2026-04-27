# 📋 ARQUITETURA - Comparação Local vs Railway

## Local (docker-compose.yml)
```
┌─────────────────────────────────────┐
│      Sua Máquina Local              │
├─────────────────────────────────────┤
│ 🌐 Laravel   │ 🔵 .NET  │ 🐘 DB   │
│ :8000       │ :9000   │ :5432  │
│             │         │        │
│ Ambiente    │ Conf    │ Dados  │
│ localhost   │ local   │ local  │
└─────────────────────────────────────┘
```

## Production (Railway - docker-compose.prod.yml)
```
┌──────────────────────────────────────────────────────────────┐
│            🚂 Railway.app (Cloud)                            │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌────────────────┐  ┌────────────────┐  ┌─────────────┐   │
│  │   NGINX        │  │   .NET API     │  │ PostgreSQL  │   │
│  │  (Proxy)       │  │   (Port: 8080) │  │  (Managed)  │   │
│  │ (Port: 8000)   │  │                │  │             │   │
│  │                │  │ - Swagger OFF  │  │ - Auto      │   │
│  │ - Laravel      │  │ - Health Check │  │   provisioned  │
│  │ - Static Files │  │ - Env Vars     │  │ - Backups   │   │
│  │ - Compression  │  │                │  │   automáticos  │
│  └────────────────┘  └────────────────┘  └─────────────┘   │
│         ▲                    ▲                   ▲            │
│         │                    │                   │            │
│         └────────────────────┴───────────────────┘            │
│                    Environment Variables                      │
│              (DB_HOST, PORT, APP_KEY, etc)                   │
│                                                              │
│  🔒 HTTPS Automático (Railway)                              │
│  📊 Monitoring & Logs em Tempo Real                         │
│  🔄 CI/CD Automático (Git Push)                             │
│  📈 Auto-scaling Disponível                                 │
└──────────────────────────────────────────────────────────────┘
```

## Mudanças Necessárias para Railway

### 1. Porta Dinâmica
```
Local:      :9000 (hardcoded)
├─> docker-compose.yml

Railway:    $PORT (variável Railway)
├─> docker-compose.prod.yml
├─> Program.cs
├─> Procfile
```

### 2. Banco de Dados
```
Local:      localhost:5432 (máquina local)
├─> Credenciais: postgres/postgres

Railway:    $POSTGRES_HOST:$POSTGRES_PORT (auto-provisioned)
├─> Credenciais: $POSTGRES_PASSWORD (auto-gerada)
├─> Database: $DATABASE_URL (auto-criada)
```

### 3. Configuração de Ambiente
```
Local Development:
├─ ASPNETCORE_ENVIRONMENT = Development
├─ APP_DEBUG = true
├─ Swagger = Habilitado
└─ Logs = Detalhados

Railway Production:
├─ ASPNETCORE_ENVIRONMENT = Production
├─ APP_DEBUG = false
├─ Swagger = Desabilitado
└─ Logs = Essenciais apenas
```

### 4. Docker Images
```
Local:
├─ node:20 (full image)
├─ php:8.3 (full image)
└─ .NET SDK (full image)

Railway (Otimizado):
├─ node:20-alpine (91% redução)
├─ php:8.3-fpm-alpine (85% redução)
└─ mcr.microsoft.com/dotnet/aspnet:8.0 (80% redução)
```

## Fluxo de Deployment

```
1. Git Push
   ↓
2. GitHub Webhook → Railway
   ↓
3. Railway Detects Change
   ↓
4. Build Images
   ├─ Backend Laravel
   ├─ Backend .NET
   └─ PostgreSQL (pulled)
   ↓
5. Run Tests (opcional)
   ↓
6. Deploy Serviços
   ├─ Pull env vars
   ├─ Start containers
   └─ Run migrations
   ↓
7. Health Checks
   ├─ :8000 responsive?
   ├─ :8080 responsive?
   └─ DB connected?
   ↓
8. Live! 🚀
   └─ App accessible via railway-url.app
```

## Variáveis Disponíveis

### Fornecidas por Railway (Auto)
```
POSTGRES_HOST          # Host do banco auto-provisioned
POSTGRES_PORT          # Porta do banco
POSTGRES_PASSWORD      # Sudo password gerada
DATABASE_URL           # String de conexão completa
```

### Fornecidas por Você
```
APP_KEY                # Laravel encryption key
APP_ENV                # environment (production)
APP_DEBUG              # debug mode (false)
DB_DATABASE            # nome do banco (profeluno)
```

### Gerenciadas por Railway
```
PORT                   # Porta disponível do Railway
RAILWAY_*              # Variáveis internas
```

## Ciclo de Vida HTTP

### Local
```
Client → :8000 (Docker Container)
         │
         ├─→ Laravel (PHP)
         ├─→ Vite Assets
         └─→ :9000 (Docker Container)
             └─→ .NET Backend
                 └─→ localhost:5432 (DB)
```

### Railway
```
Client → https://app-name.railway.app
         │
         ├─→ Nginx (Proxy)
         │    ├─→ Static Files (Cache)
         │    └─→ Laravel :8000
         │          ├─→ .NET :8080
         │          └─→ DB (Railway Managed)
         │
         └─→ Monitored & Logged
```

---

**Resumo:** Seu código não muda, apenas a forma de executar! 🎯
