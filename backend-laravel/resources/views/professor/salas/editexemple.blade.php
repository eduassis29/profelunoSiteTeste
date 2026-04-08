{{-- resources/views/professor/salas/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Sala — ' . $sala->titulo)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/sala-professor.css') }}">
@endsection

@section('content')

{{-- ============================================================
     HEADER
     ============================================================ --}}
<div class="page-header">
    <div class="page-header-left">
        <a href="{{ route('professor.salas.show', $sala->id) }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Voltar
        </a>
        <h1 class="page-title">Editar Sala</h1>
        <p class="page-subtitle">{{ $sala->titulo }}</p>
    </div>
    <div class="page-header-right">
        {{-- Badge de status atual --}}
        <span class="status-badge {{ $sala->status }}">
            @if($sala->status === 'active')
                <i class="fas fa-circle pulse-dot"></i> Ao Vivo
            @elseif($sala->status === 'pending')
                <i class="fas fa-clock"></i> Agendada
            @else
                <i class="fas fa-check-circle"></i> Concluída
            @endif
        </span>
    </div>
</div>

{{-- Alertas --}}
@if($errors->has('api'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        {{ $errors->first('api') }}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        {{ session('warning') }}
    </div>
@endif

{{-- Aviso: sala ao vivo não pode ter dados principais alterados --}}
@if($sala->status === 'active')
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Sala em andamento.</strong>
        Apenas o status pode ser alterado enquanto a aula está ao vivo.
    </div>
@endif

<form
    action="{{ route('professor.salas.update', $sala->id) }}"
    method="POST"
    id="formEditarSala"
>
    @csrf
    @method('PUT')

    <div class="form-grid-two">

        {{-- ── Coluna principal ─────────────────────────────────────────── --}}
        <div class="form-col-main">

            {{-- CARD: Dados Principais --}}
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-info-circle"></i>
                    <h3>Dados Principais</h3>
                </div>
                <div class="form-card-body">

                    {{-- Título --}}
                    <div class="form-group">
                        <label for="titulo" class="form-label">
                            Título da Sala <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="titulo"
                            name="titulo"
                            class="form-control @error('titulo') is-invalid @enderror"
                            placeholder="Ex: Álgebra Linear — Turma A"
                            value="{{ old('titulo', $sala->titulo) }}"
                            maxlength="255"
                            required
                            {{ $sala->status === 'active' ? 'disabled' : '' }}
                        >
                        <span class="char-count">
                            <span id="tituloCount">{{ strlen(old('titulo', $sala->titulo)) }}</span>/255
                        </span>
                        @error('titulo')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Descrição --}}
                    <div class="form-group">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea
                            id="descricao"
                            name="descricao"
                            class="form-control @error('descricao') is-invalid @enderror"
                            rows="4"
                            placeholder="Descreva o conteúdo que será abordado..."
                            {{ $sala->status === 'active' ? 'disabled' : '' }}
                        >{{ old('descricao', $sala->descricao) }}</textarea>
                        @error('descricao')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Matéria + Max Alunos --}}
                    <div class="form-row-two">
                        <div class="form-group">
                            <label for="materia_id" class="form-label">
                                Matéria <span class="required">*</span>
                            </label>
                            <select
                                id="materia_id"
                                name="materia_id"
                                class="form-control filter-select @error('materia_id') is-invalid @enderror"
                                required
                                {{ $sala->status === 'active' ? 'disabled' : '' }}
                            >
                                <option value="">Selecione a matéria</option>
                                @forelse($materias as $materia)
                                    <option
                                        value="{{ $materia['id'] }}"
                                        {{ old('materia_id', $sala->materia_id) == $materia['id'] ? 'selected' : '' }}
                                    >
                                        {{ $materia['nome'] }}
                                    </option>
                                @empty
                                    <option value="" disabled>Nenhuma matéria disponível</option>
                                @endforelse
                            </select>
                            @error('materia_id')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="max_alunos" class="form-label">
                                Máx. de Alunos <span class="required">*</span>
                            </label>
                            <input
                                type="number"
                                id="max_alunos"
                                name="max_alunos"
                                class="form-control @error('max_alunos') is-invalid @enderror"
                                value="{{ old('max_alunos', $sala->max_alunos) }}"
                                min="1"
                                max="500"
                                required
                            >
                            @error('max_alunos')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Data/hora início + fim --}}
                    <div class="form-row-two">
                        <div class="form-group">
                            <label for="data_hora_inicio" class="form-label">
                                Data e Hora de Início
                            </label>
                            <input
                                type="datetime-local"
                                id="data_hora_inicio"
                                name="data_hora_inicio"
                                class="form-control @error('data_hora_inicio') is-invalid @enderror"
                                value="{{ old('data_hora_inicio', $sala->data_hora_inicio?->format('Y-m-d\TH:i')) }}"
                                {{ $sala->status === 'active' ? 'disabled' : '' }}
                            >
                            @error('data_hora_inicio')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="data_hora_fim" class="form-label">
                                Data e Hora de Fim
                            </label>
                            <input
                                type="datetime-local"
                                id="data_hora_fim"
                                name="data_hora_fim"
                                class="form-control @error('data_hora_fim') is-invalid @enderror"
                                value="{{ old('data_hora_fim', $sala->data_hora_fim?->format('Y-m-d\TH:i')) }}"
                            >
                            @error('data_hora_fim')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- URL externa + Status --}}
                    <div class="form-row-two">
                        <div class="form-group">
                            <label for="url" class="form-label">
                                Link Externo
                                <span class="optional-tag">Opcional</span>
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-link"></i>
                                <input
                                    type="url"
                                    id="url"
                                    name="url"
                                    class="form-control @error('url') is-invalid @enderror"
                                    placeholder="https://meet.google.com/..."
                                    value="{{ old('url', $sala->url) }}"
                                >
                            </div>
                            <span class="field-hint">
                                <i class="fas fa-info-circle"></i>
                                Se vazio, utiliza a sala Jitsi gerada automaticamente.
                            </span>
                            @error('url')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select
                                id="status"
                                name="status"
                                class="form-control filter-select @error('status') is-invalid @enderror"
                            >
                                <option value="pending"   {{ old('status', $sala->status) === 'pending'   ? 'selected' : '' }}>
                                    Agendada (Pendente)
                                </option>
                                <option value="active"    {{ old('status', $sala->status) === 'active'    ? 'selected' : '' }}>
                                    Ativa (Ao Vivo)
                                </option>
                                <option value="completed" {{ old('status', $sala->status) === 'completed' ? 'selected' : '' }}>
                                    Concluída
                                </option>
                            </select>
                            @error('status')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Room name (somente leitura — informativo) --}}
                    @if($sala->room_name)
                    <div class="form-group">
                        <label class="form-label">
                            Sala Jitsi
                            <span class="optional-tag">Gerado automaticamente</span>
                        </label>
                        <div class="input-with-icon readonly-field">
                            <i class="fas fa-video"></i>
                            <input
                                type="text"
                                class="form-control"
                                value="{{ env('JITSI_URL', 'https://meet.suaplataforma.com') }}/{{ $sala->room_name }}"
                                readonly
                            >
                            <button
                                type="button"
                                class="btn-copy-url"
                                data-copy="{{ env('JITSI_URL', 'https://meet.suaplataforma.com') }}/{{ $sala->room_name }}"
                                title="Copiar link"
                            >
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- CARD: Conteúdo --}}
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-folder-open"></i>
                    <h3>
                        Conteúdo de Apoio
                        <span class="optional-tag">Opcional</span>
                    </h3>
                </div>
                <div class="form-card-body">

                    @if(count($conteudos))
                        <p class="section-hint">
                            <i class="fas fa-info-circle"></i>
                            Selecione o conteúdo vinculado a esta sala.
                        </p>

                        <div class="conteudo-grid">
                            @foreach($conteudos as $conteudo)
                            <label class="conteudo-card" for="conteudo_{{ $conteudo['id'] }}">
                                <input
                                    type="radio"
                                    id="conteudo_{{ $conteudo['id'] }}"
                                    name="conteudo_id"
                                    value="{{ $conteudo['id'] }}"
                                    {{ old('conteudo_id', $sala->conteudo_id) == $conteudo['id'] ? 'checked' : '' }}
                                    class="conteudo-radio"
                                >
                                <div class="conteudo-card-inner">
                                    <div class="conteudo-tipo-badge {{ $conteudo['tipo'] ?? 'other' }}">
                                        @switch($conteudo['tipo'] ?? '')
                                            @case('pdf')  <i class="fas fa-file-pdf"></i> PDF @break
                                            @case('pptx') <i class="fas fa-file-powerpoint"></i> PPTX @break
                                            @case('docx') <i class="fas fa-file-word"></i> DOCX @break
                                            @case('mp4')  <i class="fas fa-file-video"></i> MP4 @break
                                            @case('link') <i class="fas fa-link"></i> Link @break
                                            @default       <i class="fas fa-file"></i> Arquivo
                                        @endswitch
                                    </div>
                                    <div class="conteudo-info">
                                        <strong>{{ $conteudo['titulo'] }}</strong>
                                        @if(!empty($conteudo['descricao']))
                                            <span>{{ Str::limit($conteudo['descricao'], 60) }}</span>
                                        @endif
                                    </div>
                                    <div class="conteudo-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                            </label>
                            @endforeach

                            {{-- Opção: sem conteúdo --}}
                            <label class="conteudo-card conteudo-none" for="conteudo_none">
                                <input
                                    type="radio"
                                    id="conteudo_none"
                                    name="conteudo_id"
                                    value=""
                                    {{ old('conteudo_id', $sala->conteudo_id) === null ? 'checked' : '' }}
                                    class="conteudo-radio"
                                >
                                <div class="conteudo-card-inner">
                                    <div class="conteudo-tipo-badge none">
                                        <i class="fas fa-ban"></i>
                                    </div>
                                    <div class="conteudo-info">
                                        <strong>Sem conteúdo</strong>
                                        <span>Remover vínculo de conteúdo</span>
                                    </div>
                                    <div class="conteudo-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    @else
                        <div class="empty-state-inline">
                            <i class="fas fa-folder-open"></i>
                            <p>Nenhum conteúdo cadastrado.</p>
                            <a href="{{ route('professor.conteudos.create') }}" class="btn-form-next" target="_blank">
                                <i class="fas fa-plus"></i> Cadastrar Conteúdo
                            </a>
                        </div>
                        <input type="hidden" name="conteudo_id" value="">
                    @endif

                </div>
            </div>

            {{-- CARD: Simulado --}}
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-clipboard-list"></i>
                    <h3>
                        Simulado Vinculado
                        <span class="optional-tag">Opcional</span>
                    </h3>
                </div>
                <div class="form-card-body">

                    @if(count($simulados))
                        <div class="conteudo-grid">
                            @foreach($simulados as $simulado)
                            <label class="conteudo-card" for="simulado_{{ $simulado['id'] }}">
                                <input
                                    type="radio"
                                    id="simulado_{{ $simulado['id'] }}"
                                    name="simulado_id"
                                    value="{{ $simulado['id'] }}"
                                    {{ old('simulado_id', $sala->simulado_id) == $simulado['id'] ? 'checked' : '' }}
                                    class="simulado-radio"
                                >
                                <div class="conteudo-card-inner">
                                    <div class="conteudo-tipo-badge simulado">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <div class="conteudo-info">
                                        <strong>{{ $simulado['titulo'] }}</strong>
                                        @if(!empty($simulado['descricao']))
                                            <span>{{ Str::limit($simulado['descricao'], 60) }}</span>
                                        @endif
                                        @if(!empty($simulado['questoes_count']))
                                            <span class="badge-questoes">
                                                {{ $simulado['questoes_count'] }} questões
                                            </span>
                                        @endif
                                    </div>
                                    <div class="conteudo-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                            </label>
                            @endforeach

                            {{-- Opção: sem simulado --}}
                            <label class="conteudo-card conteudo-none" for="simulado_none">
                                <input
                                    type="radio"
                                    id="simulado_none"
                                    name="simulado_id"
                                    value=""
                                    {{ old('simulado_id', $sala->simulado_id) === null ? 'checked' : '' }}
                                    class="simulado-radio"
                                >
                                <div class="conteudo-card-inner">
                                    <div class="conteudo-tipo-badge none">
                                        <i class="fas fa-ban"></i>
                                    </div>
                                    <div class="conteudo-info">
                                        <strong>Sem simulado</strong>
                                        <span>Remover vínculo de simulado</span>
                                    </div>
                                    <div class="conteudo-check">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    @else
                        <div class="empty-state-inline">
                            <i class="fas fa-clipboard-list"></i>
                            <p>Nenhum simulado cadastrado.</p>
                            <a href="{{ route('professor.simulados.create') }}" class="btn-form-next" target="_blank">
                                <i class="fas fa-plus"></i> Criar Simulado
                            </a>
                        </div>
                        <input type="hidden" name="simulado_id" value="">
                    @endif

                </div>
            </div>

        </div>

        {{-- ── Coluna lateral ───────────────────────────────────────────── --}}
        <div class="form-col-side">

            {{-- Resumo das alterações --}}
            <div class="preview-card">
                <div class="preview-card-header">
                    <i class="fas fa-eye"></i>
                    Prévia do Card
                </div>
                <div class="preview-card-body">
                    <div class="mini-class-card">
                        <div class="mini-ribbon {{ $sala->status }}" id="previewRibbon">
                            @if($sala->status === 'active')
                                <i class="fas fa-circle"></i> Ao Vivo
                            @elseif($sala->status === 'pending')
                                <i class="fas fa-clock"></i> Agendada
                            @else
                                <i class="fas fa-check"></i> Concluída
                            @endif
                        </div>
                        <div class="mini-card-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h4 id="previewTitulo">{{ $sala->titulo }}</h4>
                        <span id="previewMateria" class="mini-subject">
                            {{ $sala->materia ?? '—' }}
                        </span>
                        <div class="mini-meta">
                            <span>
                                <i class="fas fa-users"></i>
                                <span id="previewAlunos">{{ $sala->max_alunos }}</span> alunos
                            </span>
                            <span>
                                <i class="fas fa-calendar"></i>
                                <span id="previewData">
                                    {{ $sala->data_hora_inicio?->format('d/m/Y') ?? 'Sem data' }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info da sala --}}
            <div class="tips-card">
                <div class="tips-card-header">
                    <i class="fas fa-clock-rotate-left"></i>
                    Informações da Sala
                </div>
                <ul class="tips-list">
                    <li>
                        <strong>Criada em:</strong>
                        {{ $sala->created_at?->format('d/m/Y H:i') ?? '—' }}
                    </li>
                    <li>
                        <strong>Última atualização:</strong>
                        {{ $sala->updated_at?->format('d/m/Y H:i') ?? '—' }}
                    </li>
                    @if($sala->room_name)
                    <li>
                        <strong>Room ID:</strong>
                        <span class="monospace">{{ Str::limit($sala->room_name, 20) }}</span>
                    </li>
                    @endif
                    @if($sala->avaliacao !== null)
                    <li>
                        <strong>Avaliação média:</strong>
                        <span>⭐ {{ number_format($sala->avaliacao, 1) }}</span>
                    </li>
                    @endif
                </ul>
            </div>

            {{-- Ações rápidas --}}
            <div class="tips-card">
                <div class="tips-card-header">
                    <i class="fas fa-bolt"></i>
                    Ações Rápidas
                </div>
                <div class="quick-actions">
                    @if($sala->status === 'pending')
                        <a href="{{ route('professor.salas.iniciar', $sala->id) }}" class="btn-start-now w-full">
                            <i class="fas fa-play"></i>
                            Iniciar Agora
                        </a>
                    @elseif($sala->status === 'active')
                        <a href="{{ route('professor.salas.show', $sala->id) }}" class="btn-enter-live w-full">
                            <i class="fas fa-video"></i>
                            Entrar na Aula
                        </a>
                    @endif
                    <button
                        type="button"
                        class="btn-danger-outline w-full btn-delete-sala"
                        data-id="{{ $sala->id }}"
                    >
                        <i class="fas fa-trash"></i>
                        Deletar Sala
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- Ações do formulário --}}
    <div class="form-actions">
        <a href="{{ route('professor.salas.show', $sala->id) }}" class="btn-form-cancel">
            <i class="fas fa-times"></i> Cancelar
        </a>
        <button type="submit" class="btn-form-submit">
            <i class="fas fa-save"></i>
            Salvar Alterações
        </button>
    </div>

</form>

{{-- Modal de confirmação de exclusão --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon danger">
            <i class="fas fa-trash-alt"></i>
        </div>
        <h3>Deletar Sala</h3>
        <p>Tem certeza que deseja deletar esta sala? Esta ação não pode ser desfeita.</p>
        <div class="modal-actions">
            <button class="modal-btn cancel" id="cancelDelete">Cancelar</button>
            <form id="deleteForm" method="POST" action="{{ route('professor.salas.destroy', $sala->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="modal-btn confirm danger">Deletar</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/sala-professor.js') }}"></script>
<script>
// ── Mapa de nomes de matéria para a prévia ────────────────────────────────────
const materiaNames = {
    @foreach($materias as $m)
        "{{ $m['id'] }}": "{{ $m['nome'] }}",
    @endforeach
};

// ── Atualiza prévia em tempo real ─────────────────────────────────────────────
function updatePreview() {
    const titulo  = document.getElementById('titulo')?.value || '{{ $sala->titulo }}';
    const matId   = document.getElementById('materia_id')?.value;
    const alunos  = document.getElementById('max_alunos')?.value || '{{ $sala->max_alunos }}';
    const inicio  = document.getElementById('data_hora_inicio')?.value;
    const status  = document.getElementById('status')?.value || '{{ $sala->status }}';

    document.getElementById('previewTitulo').textContent  = titulo;
    document.getElementById('previewMateria').textContent = materiaNames[matId] || '{{ $sala->materia ?? "—" }}';
    document.getElementById('previewAlunos').textContent  = alunos;

    if (inicio) {
        document.getElementById('previewData').textContent =
            new Date(inicio).toLocaleDateString('pt-BR');
    }

    const ribbon = document.getElementById('previewRibbon');
    const labels = {
        active:    '<i class="fas fa-circle"></i> Ao Vivo',
        pending:   '<i class="fas fa-clock"></i> Agendada',
        completed: '<i class="fas fa-check"></i> Concluída',
    };
    ribbon.className  = `mini-ribbon ${status}`;
    ribbon.innerHTML  = labels[status] || labels.pending;
}

['titulo', 'materia_id', 'max_alunos', 'data_hora_inicio', 'status'].forEach(id => {
    document.getElementById(id)?.addEventListener('input',  updatePreview);
    document.getElementById(id)?.addEventListener('change', updatePreview);
});

// Contador de caracteres
document.getElementById('titulo')?.addEventListener('input', function () {
    document.getElementById('tituloCount').textContent = this.value.length;
});

// ── Copiar URL da sala Jitsi ──────────────────────────────────────────────────
document.querySelector('.btn-copy-url')?.addEventListener('click', function () {
    const url = this.dataset.copy;
    navigator.clipboard.writeText(url).then(() => {
        const original = this.innerHTML;
        this.innerHTML = '<i class="fas fa-check"></i>';
        setTimeout(() => { this.innerHTML = original; }, 2000);
    });
});

// ── Modal de exclusão ─────────────────────────────────────────────────────────
document.querySelector('.btn-delete-sala')?.addEventListener('click', () => {
    document.getElementById('deleteModal').classList.add('active');
});
document.getElementById('cancelDelete')?.addEventListener('click', () => {
    document.getElementById('deleteModal').classList.remove('active');
});
document.querySelector('.modal-overlay')?.addEventListener('click', function (e) {
    if (e.target === this) this.classList.remove('active');
});
</script>
@endsection