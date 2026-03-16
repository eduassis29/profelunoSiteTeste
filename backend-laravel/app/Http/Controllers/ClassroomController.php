<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    public function BuscarSalaAluno(Request $request)
    {
        $professores = collect([]);

        return view('aluno.buscar-sala', compact('professores'));
    }

    public function HistoricoAulasAluno(Request $request)
    {
        $professores = collect([]);

        return view('aluno.historico-aulas', compact('professores'));
    }

    public function showClassroom($id)
    {
        $classroom = (object) [
            'id' => $id,
            'title' => 'Aula de Exemplo',
            'teacher' => (object) ['name' => 'Prof. Nome'],
            'materials' => collect([]),
        ];

        return view('aluno.sala-aula', compact('classroom'));
    }

    public function join($id)
    {
        return redirect()->route('aluno.dashboard');
    }

    public function teacherClassrooms()
    {
        $professores = collect([]);

        return view('professor.sala-buscar', compact('professores'));
    }
}
