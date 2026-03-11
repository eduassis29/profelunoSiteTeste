@extends('layouts.app')

@section('title', 'Dashboard - Admin')

@section('content')
    <div class="admin-dashboard">
        <h1>Bem-vindo, {{ auth()->user()->nome_usuario ?? 'Administrador' }}</h1>
        <p>Use o menu para navegar pelas funcionalidades do painel administrativo.</p>

        <div class="admin-cards">
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon primary">
                        <i class="fas fa-users-cog"></i>
                    </div>
                </div>
                <div class="stat-value">
                    <h3>{{ \App\Models\User::count() }}</h3>
                    <p class="stat-label">Usuários cadastrados</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon success">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
                <div class="stat-value">
                    <h3>{{ \App\Models\Cargo::count() }}</h3>
                    <p class="stat-label">Tipos de Acesso</p>
                </div>
            </div>
        </div>

        <p class="mt-4">Por enquanto, este painel apresenta apenas o acesso ao dashboard. Em breve será possível gerenciar usuários, cargos e configurações do sistema.</p>
    </div>
@endsection
