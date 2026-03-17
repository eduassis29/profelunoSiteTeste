<?php

namespace Database\Seeders;

use App\Models\Materias;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function Symfony\Component\Clock\now;

class MateriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Materias::create([
            'id' => 1,
            'nome_materia' => 'Matemática',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 2,
            'nome_materia' => 'Português',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 3,
            'nome_materia' => 'Inglês',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 4,
            'nome_materia' => 'História',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 5,
            'nome_materia' => 'Geografia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 6,
            'nome_materia' => 'Ciências',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 7,
            'nome_materia' => 'Educação Física',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        Materias::create([
            'id' => 8,
            'nome_materia' => 'Artes',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 9,
            'nome_materia' => 'Filosofia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 10,
            'nome_materia' => 'Sociologia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
