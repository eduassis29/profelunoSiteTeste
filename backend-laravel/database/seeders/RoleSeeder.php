<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'professor',
            'description' => 'Professor que cria e ministra aulas',
        ]);

        Role::create([
            'name' => 'aluno',
            'description' => 'Aluno que participa de aulas',
        ]);
    }
}
