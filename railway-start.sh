#!/bin/bash

# Script baseado no Procfile padrão para railway
# Garante que migrações sejam rodadas antes do app iniciar

set -e

echo "🚀 Profeluno - Railway Initialization"
echo "======================================"

# Variáveis de ambiente
export DB_HOST=${DB_HOST:-localhost}
export DB_PORT=${DB_PORT:-5432}
export DB_DATABASE=${DB_DATABASE:-profeluno}
export PORT=${PORT:-8000}
export DOTNET_PORT=${DOTNET_PORT:-8080}

echo "📊 Variáveis de Ambiente:"
echo "  DB_HOST: $DB_HOST"
echo "  DB_PORT: $DB_PORT"
echo "  DB_DATABASE: $DB_DATABASE"
echo "  PORT: $PORT"
echo "  DOTNET_PORT: $DOTNET_PORT"

# Iniciar docker-compose
echo ""
echo "📦 Iniciando serviços..."
exec docker-compose -f docker-compose.prod.yml up
