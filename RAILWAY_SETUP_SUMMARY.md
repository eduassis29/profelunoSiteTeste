# CONFIGURAÇÃO RAILWAY.APP - RESUMO DAS MUDANÇAS

## Arquivos Criados/Modificados para Railway

### 📁 Novos Arquivos

1. **`GUIA_RAILWAY.md`** - Guia completo de deploy
   - Passo a passo para configurar no Railway
   - Variáveis de ambiente necessárias
   - Troubleshooting
   - Segurança e monitoring

2. **`.env.example`** - Template de variáveis de ambiente
   - Configurações para desenvolvimento e production
   - Exemplo de valores

3. **`Procfile`** - Arquivo de inicialização Railway
   - Define como iniciar a aplicação
   - Compatível com Railway

4. **`railway.json`** - Configuração do Railway (opcional)
   - Metadados do projeto

5. **`docker-compose.prod.yml`** - Docker Compose para production
   - Otimizado para Railway
   - Health checks configurados
   - Variáveis de ambiente parametrizadas

6. **Backend Dockerfiles Production**:
   - `backend-dotnet/Dockerfile.prod` - Multi-stage build .NET
   - `backend-laravel/Dockerfile.prod` - Production-ready Laravel
   - `nginx.conf` - Configuração Nginx para Laravel
   - `supervisord.conf` - Gerenciador de processos Laravel

7. **`railway-init.sh`** - Script de inicialização

### 🔄 Arquivos Modificados

1. **`backend-dotnet/Program.cs`**
   - ✅ Lê variáveis de ambiente (DB_HOST, DB_PORT, etc)
   - ✅ Porta dinâmica via variável PORT
   - ✅ Swagger apenas em desenvolvimento

2. **`backend-dotnet/appsettings.Production.json`**
   - ✅ Novo arquivo para configurações production

3. **`backend-dotnet/appsettings.Development.json`**
   - ✅ Configurações específicas para desenvolvimento

4. **`docker-compose.yml`** - Não modificado (para desenvolvimento local)

## 🎯 Principais Mudanças para Railway

### 1. Porta Dinâmica
**Antes:**
```csharp
builder.WebHost.UseUrls("http://*:9000");
```

**Depois:**
```csharp
var port = Environment.GetEnvironmentVariable("PORT") ?? "9000";
builder.WebHost.UseUrls($"http://+:{port}");
```

### 2. String de Conexão Dinâmica
**Antes:**
```json
"DefaultConnection": "Host=localhost;Port=5432;..."
```

**Depois:**
```csharp
// Lê de variáveis de ambiente
var connectionString = $"Host={dbHost};Port={dbPort};...";
```

### 3. Configuração de Ambiente
**Novo:**
```bash
ASPNETCORE_ENVIRONMENT=Production
DB_HOST=railway-provided-host
DB_PASSWORD=railway-generated-password
PORT=8080
```

### 4. Docker para Production
- Imagens otimizadas (Alpine base)
- Multi-stage builds
- Health checks
- Sem volumes locais
- Restart policies

### 5. Health Checks
```yaml
healthcheck:
  test: ["CMD", "curl", "-f", "http://localhost:8000"]
  interval: 30s
  timeout: 3s
  retries: 3
```

## 📊 Estrutura de Deploy

```
Railway Project
├── PostgreSQL Service (auto-provisioned)
├── Laravel Service (porta 8000)
└── .NET Service (porta 8080)
```

## 🔐 Variáveis de Ambiente Requeridas no Railway

```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...
DB_HOST=<auto from PostgreSQL plugin>
DB_PORT=<auto from PostgreSQL plugin>
DB_DATABASE=profeluno
DB_USERNAME=postgres
DB_PASSWORD=<auto from PostgreSQL plugin>
```

## ✅ Próximos Passos

1. Gerar `APP_KEY`:
   ```bash
   php -r 'echo "base64:" . base64_encode(random_bytes(32));'
   ```

2. Criar PostgreSQL no Railway

3. Adicionar variáveis de ambiente

4. Fazer push para GitHub

5. Railway detecta e deploy automaticamente

## 🔗 Relacionado

- Ver `GUIA_RAILWAY.md` para instruções completas
- Ver `docker-compose.prod.yml` para detalhes dos serviços
- Ver `backend-dotnet/Program.cs` para configuração .NET
