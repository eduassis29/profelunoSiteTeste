{{-- resources/views/aluno/sala-buscar.blade.php --}}
@extends('layouts.app')

@section('title', 'Buscar Salas de Aula')

@section('content')
<div class="search-section">
    <h2 class="search-title">
        <i class="fas fa-search"></i>
        Buscar Salas de Aula
    </h2>

    <form class="search-form" method="GET" action="{{-- route('aluno.browse') --}}">
        <div class="search-input-group">
            <input 
                type="text" 
                name="search" 
                placeholder="Busque por professor, matéria ou tópico..."
                value="{{ request('search') }}"
            >
            <i class="fas fa-search"></i>
        </div>

        <div class="search-input-group">
            <select name="subject">
                <option value="">Todas as Matérias</option>
                <option value="matematica" {{ request('subject') === 'matematica' ? 'selected' : '' }}>Matemática</option>
                <option value="portugues" {{ request('subject') === 'portugues' ? 'selected' : '' }}>Português</option>
                <option value="historia" {{ request('subject') === 'historia' ? 'selected' : '' }}>História</option>
                <option value="geografia" {{ request('subject') === 'geografia' ? 'selected' : '' }}>Geografia</option>
                <option value="ciencias" {{ request('subject') === 'ciencias' ? 'selected' : '' }}>Ciências</option>
                <option value="ingles" {{ request('subject') === 'ingles' ? 'selected' : '' }}>Inglês</option>
            </select>
        </div>

        <button type="submit" class="btn-search">
            <i class="fas fa-search"></i>
            Buscar
        </button>
    </form>
</div>

<div class="filter-chips">
    <span class="chip {{ !request('level') ? 'active' : '' }}" data-level="">Todos os Níveis</span>
    <span class="chip {{ request('level') === 'fundamental' ? 'active' : '' }}" data-level="fundamental">Fundamental</span>
    <span class="chip {{ request('level') === 'medio' ? 'active' : '' }}" data-level="medio">Médio</span>
    <span class="chip {{ request('level') === 'superior' ? 'active' : '' }}" data-level="superior">Superior</span>
</div>

<div class="results-header">
    <h2 class="section-title">
        <i class="fas fa-list"></i>
        Salas Disponíveis
    </h2>
    <div style="display: flex; gap: 10px; align-items: center;">
        <span class="results-count">{{-- $classrooms->total() --}} sala(s) encontrada(s)</span>
        <select class="sort-select">
            <option value="recent">Mais Recentes</option>
            <option value="popular">Mais Populares</option>
            <option value="students">Mais Alunos</option>
        </select>
    </div>
</div>

<div class="teachers-grid">
    {{-- @forelse($classrooms as $classroom) --}}
        <div class="teacher-card">
            <div class="teacher-header">
                <div class="teacher-avatar">
                    <i class="fas fa-chalkboard-user"></i>
                </div>
            </div>

            <div class="teacher-info">
                <h3>{{-- $classroom->title --}}</h3>
                <p class="teacher-subject">{{ $classroom->subject ?? 'Sem matéria definida' }}</p>
                <div class="teacher-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half"></i>
                    <span>4.5</span>
                </div>
            </div>

            <div class="teacher-details">
                <div class="detail-row">
                    <i class="fas fa-user"></i>
                    <span>Prof. {{-- $classroom->teacher->name --}}</span>
                </div>
                <div class="detail-row">
                    <i class="fas fa-users"></i>
                    <span>{{-- $classroom->students()->count() }} / {{ $classroom->max_students --}} alunos</span>
                </div>
                <div class="detail-row">
                    <i class="fas fa-calendar"></i>
                    <span>{{-- $classroom->level ?? 'Sem nível' --}}</span>
                </div>
            </div>

            <div class="teacher-tags">
                <span class="tag">{{-- $classroom->subject --}}</span>
                {{-- @if($classroom->status === 'active') --}}
                    <span class="tag" style="background: rgba(40, 199, 111, 0.2); color: var(--success-color);">Ativa</span>
                {{-- @endif --}}
            </div>

            <div class="teacher-footer">
                <p>{{ $classroom->description ?? 'Sem descrição' }}</p>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="{{-- route('aluno.join', $classroom->id) --}}" method="POST" class="btn-primary" style="flex: 1; text-align: center;">
                    <i class="fas fa-plus"></i>
                    Entrar na Sala
                </a>
                <button class="btn-secondary">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
        </div>
    {{-- @empty --}}
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <h3>Nenhuma sala encontrada</h3>
            <p>Tente ajustar seus critérios de busca</p>
        </div>
    {{-- @endforelse --}}
</div>

<!-- Pagination -->
<div style="margin-top: 30px;">
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/sala-buscar.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/sala-buscar.js') }}"></script>
@endsection
