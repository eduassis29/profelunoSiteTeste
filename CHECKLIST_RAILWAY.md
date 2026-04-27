# 🎯 CHECKLIST - Preparação para Railway.app

## ✅ Arquivos de Configuração

### Criados
- [ ] `GUIA_RAILWAY.md` - Guia completo de deploy
- [ ] `.env.example` - Template de variáveis ambiente
- [ ] `Procfile` - Arquivo de inicialização
- [ ] `railway.json` - Configuração Railway
- [ ] `docker-compose.prod.yml` - Compose production
- [ ] `backend-dotnet/Dockerfile.prod` - .NET production
- [ ] `backend-laravel/Dockerfile.prod` - Laravel production
- [ ] `nginx.conf` - Configuração web server
- [ ] `supervisord.conf` - Process manager
- [ ] `railway-init.sh` - Script inicialização
- [ ] `RAILWAY_SETUP_SUMMARY.md` - Sumário mudanças
- [ ] `check-railway.sh` - Script validação

### Modificados
- [ ] `backend-dotnet/Program.cs` - Variáveis de ambiente
- [ ] `backend-dotnet/appsettings.Production.json` - Config Production
- [ ] `backend-dotnet/appsettings.Development.json` - Config Development

## 🔐 Variáveis de Ambiente

### Gerar APP_KEY
```bash
php -r 'echo "base64:" . base64_encode(random_bytes(32));'
```

### No Railway Dashboard, adicione:
- [ ] `APP_ENV` = production
- [ ] `APP_DEBUG` = false
- [ ] `APP_KEY` = base64:... (gerado acima)
- [ ] `DB_DATABASE` = profeluno
- [ ] `DB_USERNAME` = postgres
- [ ] `PORT` = 8000 (ou deixar automático)
- [ ] `DOTNET_PORT` = 8080 (ou deixar automático)

### Auto-Provisioned pelo Railway:
- [ ] `POSTGRES_HOST` (from PostgreSQL plugin)
- [ ] `POSTGRES_PORT` (from PostgreSQL plugin)
- [ ] `POSTGRES_PASSWORD` (from PostgreSQL plugin)
- [ ] `DATABASE_URL` (from PostgreSQL plugin)

## 📦 Serviços Railway

### PostgreSQL
- [ ] Criar novo serviço "Database > PostgreSQL"
- [ ] Conectar ao projeto
- [ ] Anotar credenciais

### Laravel Service
- [ ] Build: `docker-compose -f docker-compose.prod.yml build`
- [ ] Start: `docker-compose -f docker-compose.prod.yml up laravel`
- [ ] Ou via Procfile

### .NET Service
- [ ] Build: `docker-compose -f docker-compose.prod.yml build`
- [ ] Start: `docker-compose -f docker-compose.prod.yml up dotnet`

## 🧪 Testes Locais (Opcional)

```bash
# Build images
docker-compose -f docker-compose.prod.yml build

# Rodas serviços
docker-compose -f docker-compose.prod.yml up

# Verificar health
curl http://localhost:8000
curl http://localhost:8080
```

## 🚀 Deploy

1. [ ] Fazer commit de todos arquivos
2. [ ] Push para GitHub
3. [ ] Ir para railway.app
4. [ ] Criar novo projeto
5. [ ] Conectar repositório GitHub
6. [ ] Autorizar Railway
7. [ ] Aguardar build automático
8. [ ] Verificar logs (Railway Dashboard)
9. [ ] Testar endpoints

## 🔍 Validação Pós-Deploy

- [ ] Aplicação Laravel acessível (porta 8000)
- [ ] Aplicação .NET acessível (porta 8080)
- [ ] Banco de dados conectado
- [ ] Migrações rodadas
- [ ] Assets carregados corretamente
- [ ] Endpoints respondendo
- [ ] Logs sem erros críticos

## 📝 Documentação Relacionada

- Ler: `GUIA_RAILWAY.md` - Instruções passo a passo
- Ler: `RAILWAY_SETUP_SUMMARY.md` - Resumo das mudanças
- Referência: `docker-compose.prod.yml` - Configuração dos serviços
- Referência: `.env.example` - Variáveis de ambiente

## 🆘 Troubleshooting

### Erro na conexão com banco
- Verificar se PostgreSQL está provisionado
- Validar credenciais em variáveis de ambiente
- Checar logs: `Railway Dashboard > Logs`

### Porta em uso
- Railway gerencia portas automaticamente
- Não hardcode em código
- Use variáveis: `PORT`, `DOTNET_PORT`

### Migrações falhando
- Checar permissões no banco
- Validar string de conexão
- Testar migrações localmente antes

### Assets não carregando
- Verificar build do npm/vite
- Checar nginx.conf
- Validar paths públicos

---

**Status:** ⏳ Aguardando execução
**Última atualização:** 2024
**Próximo passo:** Seguir `GUIA_RAILWAY.md`
