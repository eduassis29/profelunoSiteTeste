#!/bin/bash

# 🚀 Railway Deployment Checklist
# Execute este script para validar sua configuração antes do deploy

set -e

COLOR_GREEN='\033[0;32m'
COLOR_RED='\033[0;31m'
COLOR_YELLOW='\033[1;33m'
COLOR_BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${COLOR_BLUE}========================================${NC}"
echo -e "${COLOR_BLUE}  Profeluno - Railway Deploy Checklist${NC}"
echo -e "${COLOR_BLUE}========================================${NC}\n"

PASSED=0
FAILED=0

check() {
    local name=$1
    local cmd=$2

    if eval "$cmd" > /dev/null 2>&1; then
        echo -e "${COLOR_GREEN}✓${NC} $name"
        ((PASSED++))
    else
        echo -e "${COLOR_RED}✗${NC} $name"
        ((FAILED++))
    fi
}

echo -e "${COLOR_YELLOW}📋 Verificando arquivos...${NC}"
check "Procfile existe" "test -f Procfile"
check "docker-compose.prod.yml existe" "test -f docker-compose.prod.yml"
check ".env.example existe" "test -f .env.example"
check "GUIA_RAILWAY.md existe" "test -f GUIA_RAILWAY.md"
check "backend-dotnet/Dockerfile.prod existe" "test -f backend-dotnet/Dockerfile.prod"
check "backend-laravel/Dockerfile.prod existe" "test -f backend-laravel/Dockerfile.prod"

echo -e "\n${COLOR_YELLOW}🔧 Verificando configurações...${NC}"
check "Program.cs com variáveis de ambiente" "grep -q 'GetEnvironmentVariable.*DB_HOST' backend-dotnet/Program.cs"
check "appsettings.Production.json existe" "test -f backend-dotnet/appsettings.Production.json"

echo -e "\n${COLOR_YELLOW}📦 Verificando dependências...${NC}"
check "Docker instalado" "command -v docker"
check "Docker Compose instalado" "command -v docker-compose"

echo -e "\n${COLOR_YELLOW}📝 Verificando documentation...${NC}"
check "README.md existe" "test -f README.md"
check "RAILWAY_SETUP_SUMMARY.md existe" "test -f RAILWAY_SETUP_SUMMARY.md"

echo -e "\n${COLOR_BLUE}========================================${NC}"
echo -e "Resultados: ${COLOR_GREEN}$PASSED Passou${NC} | ${COLOR_RED}$FAILED Falhou${NC}"
echo -e "${COLOR_BLUE}========================================${NC}\n"

if [ $FAILED -eq 0 ]; then
    echo -e "${COLOR_GREEN}✓ Sua aplicação está pronta para Railway!${NC}"
    echo -e "\n${COLOR_YELLOW}Próximos passos:${NC}"
    echo "1. Gerar APP_KEY: php -r 'echo \"base64:\" . base64_encode(random_bytes(32));'"
    echo "2. Criar conta em railway.app (se não tiver)"
    echo "3. Seguir as instruções em GUIA_RAILWAY.md"
    echo "4. Fazer push para GitHub"
    echo "5. Autorizar Railway no seu repositório"
    exit 0
else
    echo -e "${COLOR_RED}✗ Alguns problemas foram encontrados${NC}"
    echo "Verifique os itens acima e tente novamente."
    exit 1
fi
