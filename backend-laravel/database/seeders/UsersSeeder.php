<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $professor = User::create([
        //     'name' => 'Prof. João da Silva',
        //     'email' => 'professor@test.com',
        //     'password' => Hash::make('password123'),
        //     'role_id' => 1, // Professor
        //     'bio' => 'Professor de Matemática com 10 anos de experiência',
        //     'certification' => 'Licenciado em Matemática - USP',
        //     'subjects' => 'Matemática, Geometria'
        // ]);

        // $aluno = User::created([
        //     'name' => 'João Silva',
        //     'email' => 'aluno@test.com',
        //     'password' => Hash::make('password123'),
        //     'role_id' => 2, // Aluno
        // ]);
    }
}
