<?php
/**
 * Script para criar usuários de teste no banco de dados
 * Execute com: php create_test_users.php
 */

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Criar usuário professor
$professor = User::create([
    'name' => 'Prof. João da Silva',
    'email' => 'professor@test.com',
    'password' => Hash::make('password123'),
    'role_id' => 1, // Professor
    'bio' => 'Professor de Matemática com 10 anos de experiência',
    'certification' => 'Licenciado em Matemática - USP',
    'subjects' => 'Matemática, Geometria'
]);

echo "✓ Professor criado: {$professor->email}\n";

// Criar usuário aluno
$aluno = User::create([
    'name' => 'João Silva',
    'email' => 'aluno@test.com',
    'password' => Hash::make('password123'),
    'role_id' => 2, // Aluno
]);

echo "✓ Aluno criado: {$aluno->email}\n";

// Criar segundo aluno
$aluno2 = User::create([
    'name' => 'Maria Santos',
    'email' => 'maria@test.com',
    'password' => Hash::make('password123'),
    'role_id' => 2, // Aluno
]);

echo "✓ Aluno criado: {$aluno2->email}\n";

echo "\n=== Credenciais de Teste ===\n";
echo "Professor:\n";
echo "  Email: professor@test.com\n";
echo "  Senha: password123\n\n";
echo "Aluno 1:\n";
echo "  Email: aluno@test.com\n";
echo "  Senha: password123\n\n";
echo "Aluno 2:\n";
echo "  Email: maria@test.com\n";
echo "  Senha: password123\n";
