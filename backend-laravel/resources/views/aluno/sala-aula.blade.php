{{-- resources/views/aluno/sala-aula.blade.php --}}
@extends('layouts.app')

@section('title', 'Aula ao Vivo')

@section('content')
<div class="top-bar">
    <div class="class-info">
        <div class="class-title">
            <h2>{{ $classroom->title }}</h2>
            <p>Prof. {{ $classroom->teacher->name }}</p>
        </div>
        <span class="live-indicator">
            <i class="fas fa-circle"></i>
            AO VIVO
        </span>
    </div>
    <div class="top-actions">
        <a href="{{ route('aluno.dashboard') }}" class="btn-leave">Sair da Aula</a>
    </div>
</div>

<div class="main-container">
    {{-- Seção de Vídeo --}}
    <div class="video-section">
        <div class="main-video-container">
            <div class="video-placeholder">
                <i class="fas fa-video"></i>
                <p>Vídeo será exibido aqui</p>
            </div>
            <div class="video-overlay">
                <div class="viewer-count">
                    <i class="fas fa-users"></i>
                    <span id="viewerCount">1</span> participante(s)
                </div>
            </div>
        </div>

        <!-- Participants Strip -->
            {{-- Faixa de Participantes --}}
        <div class="participants-strip" id="participantsStrip">
            <div class="participant-video">
                <div class="participant-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <p class="participant-name">Você</p>
                <div class="participant-status">
                    <i class="fas fa-microphone-slash muted"></i>
                </div>
            </div>
        </div>

        <!-- Control Bar -->
            {{-- Barra de Controle --}}
        <div class="control-bar">
            <button class="control-btn" id="micBtn" title="Microfone">
                <i class="fas fa-microphone-slash"></i>
            </button>
            <button class="control-btn" id="cameraBtn" title="Câmera">
                <i class="fas fa-video-slash"></i>
            </button>
            <button class="control-btn" id="screenBtn" title="Compartilhar Tela">
                <i class="fas fa-share-square"></i>
            </button>
            <button class="control-btn" id="chatBtn" title="Chat">
                <i class="fas fa-comments"></i>
            </button>
            <button class="control-btn" id="participantsBtn" title="Participantes">
                <i class="fas fa-users"></i>
            </button>
        </div>
    </div>

    <!-- Sidebar -->
        {{-- Barra Lateral --}}
    <div class="sidebar">
        <!-- Sidebar Tabs -->
            {{-- Abas da Barra Lateral --}}
        <div class="sidebar-tabs">
            <button class="sidebar-tab active" id="chatTab">
                <i class="fas fa-comments"></i>
                Chat
            </button>
            <button class="sidebar-tab" id="participantsTab">
                <i class="fas fa-users"></i>
                Participantes
            </button>
            <button class="sidebar-tab" id="materialsTab">
                <i class="fas fa-file-pdf"></i>
                Materiais
            </button>
        </div>

        <!-- Sidebar Content -->
            {{-- Conteúdo da Barra Lateral --}}
        <div class="sidebar-content">
            <!-- Chat Section -->
                        {{-- Seção de Chat --}}
            <div class="chat-container" id="chatSection">
                <div class="chat-messages" id="chatMessages">
                    <div class="chat-message">
                        <div class="message-header">
                            <div class="message-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <p class="message-name">{{ $classroom->teacher->name }}</p>
                                <p class="message-time">14:30</p>
                            </div>
                        </div>
                        <p class="message-text teacher">Bem-vindo à aula!</p>
                    </div>
                </div>

                <div class="chat-input-container">
                    <input type="text" class="chat-input" id="chatInput" placeholder="Envie uma mensagem...">
                    <button class="btn-send" id="sendBtn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>

            <!-- Participants Section (Hidden by default) -->
            <div class="participants-list" id="participantsSection" style="display: none;">
                <div class="participant-item">
                    <div class="participant-item-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="participant-item-info">
                        <p class="participant-item-name">{{ Auth::user()->name }}</p>
                        <p class="participant-item-role">Aluno</p>
                    </div>
                    <div class="participant-item-status">
                        <span class="status-icon muted">
                            <i class="fas fa-microphone-slash"></i>
                        </span>
                    </div>
                </div>

                <div class="participant-item">
                    <div class="participant-item-avatar" style="background: linear-gradient(135deg, #7367f0, #9f8cfe);">
                        <i class="fas fa-chalkboard-user"></i>
                    </div>
                    <div class="participant-item-info">
                        <p class="participant-item-name">{{ $classroom->teacher->name }}</p>
                        <p class="participant-item-role teacher">Professor</p>
                    </div>
                    <div class="participant-item-status">
                        <span class="status-icon">
                            <i class="fas fa-microphone"></i>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Materials Section (Hidden by default) -->
            <div class="materials-list" id="materialsSection" style="display: none;">
                @if($classroom->materials()->count() > 0)
                    @foreach($classroom->materials as $material)
                        <div class="material-item">
                            <div class="material-header">
                                <div class="material-icon {{ strtolower($material->type) }}">
                                    @if($material->type === 'pdf')
                                        <i class="fas fa-file-pdf"></i>
                                    @elseif($material->type === 'slide')
                                        <i class="fas fa-presentation"></i>
                                    @elseif($material->type === 'video')
                                        <i class="fas fa-film"></i>
                                    @else
                                        <i class="fas fa-file"></i>
                                    @endif
                                </div>
                                <div class="material-info">
                                    <h4>{{ $material->title }}</h4>
                                    <p>{{ $material->description }}</p>
                                </div>
                            </div>
                            <div class="material-actions">
                                <a href="{{ $material->file_url }}" class="btn-material" download>
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="text-align: center; color: var(--text-secondary); padding: 20px;">
                        Nenhum material disponível
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/video-aula.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/video-aula.js') }}"></script>
@endsection
