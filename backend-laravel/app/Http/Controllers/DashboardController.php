<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController
{
    public function studentDashboard()
    {
        $user = Auth::user();
        $classrooms = $user->classrooms()->latest()->get();

        return view('aluno.dashboard', [
            'classrooms' => $classrooms,
            'totalClasses' => $classrooms->count(),
            'completedClasses' => $classrooms->where('status', 'completed')->count(),
        ]);
    }

    public function teacherDashboard()
    {
        $user = Auth::user();
        $classrooms = $user->ownedClassrooms()->latest()->get();

        return view('professor.dashboard', [
            'classrooms' => $classrooms,
            'totalClasses' => $classrooms->count(),
            'activeClasses' => $classrooms->where('status', 'active')->count(),
        ]);
    }
}
