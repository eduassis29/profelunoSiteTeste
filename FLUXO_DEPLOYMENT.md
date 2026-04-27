```
Fluxo de Deployment no Railway

┌─────────────────────────────────────────────────────────────────┐
│  Seu Computador (Local)                                         │
│  ┌──────────────────────────────────────────────────────┐      │
│  │ 1. Gerar APP_KEY                                   │      │
│  │    $ php -r 'echo "base64:..." '                   │      │
│  │                                                      │      │
│  │ 2. Fazer Commit de Arquivos                        │      │
│  │    $ git add .                                      │      │
│  │    $ git commit -m "Add Railway config"            │      │
│  │                                                      │      │
│  │ 3. Push para GitHub                                │      │
│  │    $ git push origin main                          │      │
│  └──────────────────────────────────────────────────────┘      │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  GitHub                                                         │
│  ┌──────────────────────────────────────────────────────┐      │
│  │ - Recebe push                                      │      │
│  │ - Ativa Webhook para Railway                       │      │
│  └──────────────────────────────────────────────────────┘      │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  Railway Platform                                               │
│  ┌──────────────────────────────────────────────────────┐      │
│  │ 1. Detecção de Mudanças                           │      │
│  │    ✓ Dockerfile.prod detectado                    │      │
│  │    ✓ docker-compose.prod.yml detectado            │      │
│  │                                                      │      │
│  │ 2. Build de Imagens                               │      │
│  │    ├─ Construir Laravel (Dockerfile.prod)         │      │
│  │    ├─ Construir .NET (Dockerfile.prod)            │      │
│  │    └─ PostgreSQL → Usar imagem oficial            │      │
│  │                                                      │      │
│  │ 3. Verificação de Saúde                           │      │
│  │    ├─ Health Check :8000 (Laravel)                │      │
│  │    ├─ Health Check :8080 (.NET)                   │      │
│  │    └─ Health Check BD (PostgreSQL)                │      │
│  └──────────────────────────────────────────────────────┘      │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  Serviços Rodando                                               │
│  ┌──────────────────────────────────────────────────────┐      │
│  │ 🌐 Laravel (Port 8000)                             │      │
│  │    ├─ NGINX Proxy                                  │      │
│  │    ├─ PHP-FPM                                      │      │
│  │    ├─ Assets Vite                                  │      │
│  │    └─ Supervisord Manager                         │      │
│  │                                                      │      │
│  │ 🔵 .NET Backend (Port 8080)                       │      │
│  │    ├─ API Controllers                              │      │
│  │    ├─ Swagger (OFF em Prod)                       │      │
│  │    └─ Health Endpoint                              │      │
│  │                                                      │      │
│  │ 🐘 PostgreSQL (Managed)                           │      │
│  │    ├─ Dados Persistidos                           │      │
│  │    ├─ Backups Automáticos                         │      │
│  │    └─ Connection Pool                              │      │
│  └──────────────────────────────────────────────────────┘      │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  Ambiente Production                                            │
│  ┌──────────────────────────────────────────────────────┐      │
│  │ ✅ APP ONLINE em: https://seu-app.railway.app     │      │
│  │                                                      │      │
│  │ Variáveis de Ambiente Aplicadas:                   │      │
│  │ - APP_ENV=production                               │      │
│  │ - DB_HOST=railway-db-host.railway.app             │      │
│  │ - PORT=8000 (atribuído pelo Railway)              │      │
│  │ - Todas as outras configurações...                │      │
│  │                                                      │      │
│  │ Monitore em Railway Dashboard:                     │      │
│  │ - Logs em tempo real                               │      │
│  │ - CPU/Memória/Rede                                │      │
│  │ - Status dos containers                            │      │
│  │ - Histórico de deploys                            │      │
│  └──────────────────────────────────────────────────────┘      │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│  Usuários da Aplicação                                          │
│  ┌──────────────────────────────────────────────────────┐      │
│  │ Acesso:                                            │      │
│  │ https://seu-app.railway.app                        │      │
│  │                                                      │      │
│  │ ✓ HTTPS Automático (Railway)                      │      │
│  │ ✓ Compressão Gzip (Nginx)                         │      │
│  │ ✓ Cache de Assets (1 ano)                         │      │
│  │ ✓ Performance Otimizada                           │      │
│  └──────────────────────────────────────────────────────┘      │
└─────────────────────────────────────────────────────────────────┘
```

## Diagrama de Componentes

```
┌─────────────────────────────────────────────────────────────┐
│  Railway Network (Rede Privada)                            │
│                                                             │
│  ┌──────────────┐  ┌──────────────┐  ┌────────────────┐   │
│  │   NGINX      │  │   PHP-FPM    │  │   .NET Core    │   │
│  │  Port 8000   │  │   (Laravel)  │  │   Port 8080    │   │
│  │              │  │              │  │                │   │
│  │ - Reverse    │  │ - Web Server │  │ - APIs REST    │   │
│  │   Proxy      │  │ - Router     │  │ - Controllers  │   │
│  │ - Cache      │  │ - Middleware │  │ - Services     │   │
│  │ - Gzip       │  │ - Database   │  │ - Database     │   │
│  │   Compress   │  │   Queries    │  │   Queries      │   │
│  └──────────────┘  └──────────────┘  └────────────────┘   │
│         │                │                    │             │
│         └────────────────┴────────────────────┘             │
│                          │                                   │
│                          ▼                                   │
│                  ┌──────────────┐                           │
│                  │  PostgreSQL  │                           │
│                  │  (Railway    │                           │
│                  │   Managed)   │                           │
│                  │              │                           │
│                  │ - Persistência│                          │
│                  │ - Backup Auto│                           │
│                  │ - Connection │                           │
│                  │   Pool       │                           │
│                  └──────────────┘                           │
│                                                             │
└─────────────────────────────────────────────────────────────┘
                         ▲
                         │
              ┌──────────┴──────────┐
              │                     │
         Railway Load              Private
         Balancer                  Network
              │                     │
         HTTPS/TLS                 Internal
         Automático                DNS
```

## Sequência de Arquivo Necessário

```
1. Variáveis de Ambiente
   ▼
2. Dockerfiles Produktive
   ▼
3. docker-compose.prod.yml
   ▼
4. Program.cs (Env Vars)
   ▼
5. Procfile (Entrada)
   ▼
6. Git Push
   ▼
7. Railway Detecta
   ▼
8. Build & Deploy
   ▼
9. Live! 🚀
```

---

Para visualizar em tempo real, abra: [GUIA_RAILWAY.md](GUIA_RAILWAY.md)
