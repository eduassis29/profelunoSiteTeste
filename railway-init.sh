#!/bin/bash

# Script de inicialização para Railway
# Run migrations e inicia os serviços

set -e

echo "🚀 Iniciando aplicação Profeluno no Railway..."

# Executar migrações
echo "📦 Rodando migrações do banco de dados..."

# Laravel migrations
cd /app
php artisan migrate --force
php artisan config:cache
php artisan route:cache

echo "✅ Aplicação pronta!"
