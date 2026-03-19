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
            'situacao_materia' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 2,
            'nome_materia' => 'Português',
            'situacao_materia' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 3,
            'nome_materia' => 'Inglês',
            'situacao_materia' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 4,
            'nome_materia' => 'História',
            'situacao_materia' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 5,
            'nome_materia' => 'Geografia',
            'situacao_materia' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 6,
            'nome_materia' => 'Ciências',
            'situacao_materia' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 7,
            'nome_materia' => 'Educação Física',
            'situacao_materia' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        Materias::create([
            'id' => 8,
            'nome_materia' => 'Artes',
            'situacao_materia' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 9,
            'nome_materia' => 'Filosofia',
            'situacao_materia' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Materias::create([
            'id' => 10,
            'nome_materia' => 'Sociologia',
            'situacao_materia' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
