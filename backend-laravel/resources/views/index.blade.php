@extends('layouts.app')

@section('title', 'ProfeLuno - Sistema de Aulas Virtuais')

@section('content')
<div class="welcome-container" style="text-align: center; padding: 100px 20px;">
    <div class="welcome-card">
        <div class="welcome-icon" style="font-size: 60px; margin-bottom: 20px;">
            <i class="fas fa-graduation-cap" style="color: var(--primary-color);"></i>
        </div>
        <h1 style="font-size: 32px; margin-bottom: 10px;">Bem-vindo ao ProfeLuno</h1>
        <p style="color: var(--text-secondary); margin-bottom: 30px;">
            Sistema de Aulas Virtuais para Professores e Alunos
        </p>
        
        @if (!Auth::check())
            <div style="display: flex; gap: 15px; justify-content: center;">
                <a href="{{ route('login') }}" class="btn-primary" style="padding: 12px 30px;">
                    <i class="fas fa-sign-in-alt"></i> Fazer Login
                </a>
                <a href="{{ route('register') }}" style="background: var(--card-bg); color: var(--text-primary); border: 1px solid var(--border-color); padding: 12px 30px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-user-plus"></i> Registrar-se
                </a>
            </div>
        @else
            <p>Você está conectado como <strong>{{ Auth::user()->name }}</strong></p>
            <p style="color: var(--text-secondary); margin-top: 20px;">
                Redirecionando para o dashboard...
            </p>
            <script>
                setTimeout(function() {
                    window.location.href = "{{ Auth::user()->role->name === 'professor' ? route('professor.dashboard') : route('aluno.dashboard') }}";
                }, 2000);
            </script>
        @endif
    </div>
</div>
@endsection