{{-- resources/views/admin/materias/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Nova Matéria')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-info">
        <h2><i class="fas fa-plus-circle"></i> Nova Matéria</h2>
        <p>Cadastre uma nova matéria na plataforma</p>
    </div>
    <a href="{{ route('admin.materias.index') }}" class="btn-cancel">
        <i class="fas fa-arrow-left"></i>
        Voltar
    </a>
</div>

<div class="form-card">
    <div class="form-card-header">
        <div class="form-card-header-icon">
            <i class="fas fa-book"></i>
        </div>
        <div>
            <h3>Dados da Matéria</h3>
            <p>Campos marcados com <span style="color:#ea5455;">*</span> são obrigatórios</p>
        </div>
    </div>

    @include('admin.materias._form', [
        'action' => route('admin.materias.store'),
        'method' => 'POST',
    ])
</div>

@endsection