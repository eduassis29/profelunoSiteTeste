<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassroomController
{
    public function studentBrowse()
    {
        $classrooms = Classroom::where('status', 'active')
            ->whereNotIn('id', Auth::user()->classrooms()->pluck('id'))
            ->paginate(12);

        return view('aluno.sala-buscar', compact('classrooms'));
    }

    public function teacherClassrooms()
    {
        $classrooms = Auth::user()->ownedClassrooms()->paginate(12);
        return view('professor.sala-buscar', compact('classrooms'));
    }

    public function showClassroom($id)
    {
        $classroom = Classroom::findOrFail($id);
        return view('aluno.sala-aula', compact('classroom'));
    }

    public function join(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);
        Auth::user()->classrooms()->attach($classroom);

        return redirect()->route('classroom.show', $id);
    }
}
