@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="logo-text">
                    <h1>ProfeLuno</h1>
                    <p>Sistema de Aulas Virtuais</p>
                </div>
            </div>
        </div>

        <h2>Criar Conta</h2>
        <p>Registre-se para começar</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label for="name">Nome Completo</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    required 
                    autofocus
                >
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="role_id">Tipo de Usuário</label>
                <select 
                    name="role_id" 
                    id="role_id" 
                    class="form-control @error('role_id') is-invalid @enderror"
                    required
                >
                    <option value="">Selecione...</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-control @error('password') is-invalid @enderror"
                    required
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Senha</label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    class="form-control"
                    required
                >
            </div>

            <button type="submit" class="btn-primary">Registrar</button>
        </form>

        <div class="auth-footer">
            <p>Já tem uma conta? <a href="{{ route('login') }}">Faça login aqui</a></p>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection
