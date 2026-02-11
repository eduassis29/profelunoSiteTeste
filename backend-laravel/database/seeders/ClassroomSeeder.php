<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Material;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar um professor
        $professor = User::where('role_id', 1)->first();
        
        if (!$professor) {
            echo "Nenhum professor encontrado. Execute create_test_users.php primeiro.\n";
            return;
        }

        // Criar salas de aula
        $classrooms = [
            [
                'title' => 'Matemática Fundamental',
                'description' => 'Introdução aos conceitos básicos de matemática',
                'subject' => 'Matemática',
                'level' => 'Iniciante',
                'status' => 'active',
                'max_students' => 30,
                'start_time' => now(),
                'end_time' => now()->addHours(1),
            ],
            [
                'title' => 'Álgebra Avançada',
                'description' => 'Aprofundamento em equações e funções algébricas',
                'subject' => 'Matemática',
                'level' => 'Intermediário',
                'status' => 'active',
                'max_students' => 25,
                'start_time' => now()->addHours(2),
                'end_time' => now()->addHours(3),
            ],
            [
                'title' => 'Geometria Espacial',
                'description' => 'Estudo de formas tridimensionais e suas propriedades',
                'subject' => 'Matemática',
                'level' => 'Avançado',
                'status' => 'pending',
                'max_students' => 20,
                'start_time' => now()->addDay(),
                'end_time' => now()->addDay()->addHours(1),
            ],
            [
                'title' => 'Cálculo I',
                'description' => 'Fundamentos de cálculo diferencial e integral',
                'subject' => 'Matemática',
                'level' => 'Avançado',
                'status' => 'completed',
                'max_students' => 35,
                'start_time' => now()->subDay(),
                'end_time' => now()->subDay()->addHours(1),
            ],
        ];

        foreach ($classrooms as $classroomData) {
            $classroom = Classroom::create([
                ...$classroomData,
                'teacher_id' => $professor->id,
            ]);

            // Adicionar alguns materiais
            Material::create([
                'classroom_id' => $classroom->id,
                'title' => 'Apresentação da Aula',
                'type' => 'slide',
                'file_path' => 'materials/' . $classroom->id . '/apresentacao.pdf',
                'file_url' => null,
                'description' => 'Slides da aula de ' . $classroom->title,
            ]);

            Material::create([
                'classroom_id' => $classroom->id,
                'title' => 'Exercícios Práticos',
                'type' => 'document',
                'file_path' => 'materials/' . $classroom->id . '/exercicios.pdf',
                'file_url' => null,
                'description' => 'Exercícios para praticar os conceitos da aula',
            ]);

            echo "✓ Sala criada: {$classroom->title}\n";
        }

        // Adicionar alunos às salas
        $alunos = User::where('role_id', 2)->get();
        
        foreach (Classroom::all() as $classroom) {
            if ($alunos->count() > 0) {
                $randomCount = min(rand(1, 2), $alunos->count());
                $alunos->random($randomCount)->each(function ($aluno) use ($classroom) {
                    $classroom->students()->attach($aluno->id, [
                        'status' => 'active',
                        'joined_at' => now(),
                    ]);
                });
            }
        }

        echo "\n✓ Alunos adicionados às salas de aula\n";
    }
}
