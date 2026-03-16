<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function DashboardAluno()
    {
        $totalClasses = 0;
        $completedClasses = 0;
        $classrooms = collect([]);

        return view('aluno.dashboard', compact('totalClasses', 'completedClasses', 'classrooms'));
    }

    public function DashboardProfessor()
    {
        $totalClasses = 0;
        $activeClasses = 0;
        $classrooms = collect([]);

        return view('professor.dashboard', compact('totalClasses', 'activeClasses', 'classrooms'));
    }

    public function DashboardAdmin()
    {
        return view('admin.dashboard');
    }
}
