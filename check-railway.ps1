# PowerShell script for Windows - Railway Configuration Checking

$GREEN = "Green"
$RED = "Red"
$YELLOW = "Yellow"
$BLUE = "Cyan"

Write-Host "========================================" -ForegroundColor $BLUE
Write-Host "  Profeluno - Railway Deploy Checklist" -ForegroundColor $BLUE
Write-Host "========================================" -ForegroundColor $BLUE
Write-Host ""

$PASSED = 0
$FAILED = 0

function Check-Item {
    param(
        [string]$Name,
        [scriptblock]$TestBlock
    )

    try {
        if (& $TestBlock) {
            Write-Host "✓ $Name" -ForegroundColor $GREEN
            $script:PASSED++
        }
        else {
            Write-Host "✗ $Name" -ForegroundColor $RED
            $script:FAILED++
        }
    }
    catch {
        Write-Host "✗ $Name" -ForegroundColor $RED
        $script:FAILED++
    }
}

Write-Host "📋 Verificando arquivos..." -ForegroundColor $YELLOW
Check-Item "Procfile existe" { Test-Path "Procfile" }
Check-Item "docker-compose.prod.yml existe" { Test-Path "docker-compose.prod.yml" }
Check-Item ".env.example existe" { Test-Path ".env.example" }
Check-Item "GUIA_RAILWAY.md existe" { Test-Path "GUIA_RAILWAY.md" }
Check-Item "backend-dotnet/Dockerfile.prod existe" { Test-Path "backend-dotnet/Dockerfile.prod" }
Check-Item "backend-laravel/Dockerfile.prod existe" { Test-Path "backend-laravel/Dockerfile.prod" }

Write-Host ""
Write-Host "🔧 Verificando configurações..." -ForegroundColor $YELLOW
$programCsPath = "backend-dotnet/Program.cs"
if (Test-Path $programCsPath) {
    $content = Get-Content $programCsPath -Raw
    Check-Item "Program.cs com variáveis de ambiente" { $content -match "GetEnvironmentVariable" }
}

Check-Item "appsettings.Production.json existe" { Test-Path "backend-dotnet/appsettings.Production.json" }

Write-Host ""
Write-Host "📦 Verificando ferramentas..." -ForegroundColor $YELLOW
Check-Item "Docker instalado" { Get-Command docker -ErrorAction SilentlyContinue }
Check-Item "Docker Compose instalado" { Get-Command docker-compose -ErrorAction SilentlyContinue }
Check-Item "Git instalado" { Get-Command git -ErrorAction SilentlyContinue }

Write-Host ""
Write-Host "📝 Verificando documentação..." -ForegroundColor $YELLOW
Check-Item "README.md existe" { Test-Path "README.md" }
Check-Item "RAILWAY_SETUP_SUMMARY.md existe" { Test-Path "RAILWAY_SETUP_SUMMARY.md" }
Check-Item "RAILWAY_READY.md existe" { Test-Path "RAILWAY_READY.md" }

Write-Host ""
Write-Host "========================================" -ForegroundColor $BLUE
Write-Host "Resultados: $PASSED Passou | $FAILED Falhou" -ForegroundColor $BLUE
Write-Host "========================================" -ForegroundColor $BLUE
Write-Host ""

if ($FAILED -eq 0) {
    Write-Host "✓ Sua aplicação está pronta para Railway!" -ForegroundColor $GREEN
    Write-Host ""
    Write-Host "Próximos passos:" -ForegroundColor $YELLOW
    Write-Host "1. Gerar APP_KEY (execute no PowerShell):"
    Write-Host "   `$key = [Convert]::ToBase64String((1..32 | ForEach-Object { Get-Random -Minimum 0 -Maximum 256 -as [byte] }))"
    Write-Host "   `$key = 'base64:' + `$key"
    Write-Host "   Write-Host `$key"
    Write-Host ""
    Write-Host "2. Criar conta em railway.app (se não tiver)"
    Write-Host "3. Seguir as instruções em GUIA_RAILWAY.md"
    Write-Host "4. Fazer push para GitHub"
    Write-Host "5. Autorizar Railway no seu repositório"
    Write-Host ""
    exit 0
}
else {
    Write-Host "✗ Alguns problemas foram encontrados" -ForegroundColor $RED
    Write-Host "Verifique os itens acima e tente novamente." -ForegroundColor $RED
    exit 1
}
