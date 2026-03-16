<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        $userCargo = session('user_cargo'); // 'aluno', 'professor', 'admin'

        if ($userCargo !== $role) {
            return match ($userCargo) {
                'professor' => redirect('/professor/dashboard'),
                'admin'     => redirect('/admin/dashboard'),
                default     => redirect('/aluno/dashboard'),
            };
        }

        return $next($request);
    }
}