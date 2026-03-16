{{-- resources/views/partials/sidebar.blade.php --}}
<div class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('home') }}" class="logo">
            <div class="logo-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="logo-text">
                <h2>ProfeLuno</h2>
                @if (session('cargo_id') === 1)
                <p>Aluno Dashboard</p>

                @elseif (session('cargo_id') === 2)
                <p>Professor Dashboard</p>
                
                @elseif (session('cargo_id') === 3)
                <p>Admin Dashboard</p>
                @endif
            </div>
        </a>
    </div>

    <nav class="sidebar-menu">
        @if (session('cargo_id') === 2)
            <div class="menu-item">
                <a href="{{ route('professor.dashboard') }}" class="menu-link {{ request()->routeIs('professor.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('professor.sala-aula') }}" class="menu-link {{ request()->routeIs('professor.sala-aula') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-user"></i>
                    <span>Minhas Salas</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('professor.conteudos') }}" class="menu-link {{ request()->routeIs('professor.conteudos') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Conteúdos</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('professor.avaliacoes') }}" class="menu-link {{ request()->routeIs('professor.avaliacoes') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Avaliações</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('professor.relatorios') }}" class="menu-link {{ request()->routeIs('professor.relatorios') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Relatórios</span>
                </a>
            </div>
        @elseif (session('cargo_id') === 1)
            <div class="menu-item">
                <a href="{{ route('aluno.dashboard') }}" class="menu-link {{ request()->routeIs('aluno.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Início</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('aluno.buscar-sala') }}" class="menu-link {{ request()->routeIs('aluno.buscar-sala') ? 'active' : '' }}">
                    <i class="fas fa-search"></i>
                    <span>Buscar Salas</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('aluno.minhas-aulas') }}" class="menu-link {{ request()->routeIs('aluno.minhas-aulas') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Minhas Aulas</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('aluno.historico') }}" class="menu-link {{ request()->routeIs('aluno.historico') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Histórico</span>
                </a>
            </div>
        @elseif (session('cargo_id') === 3)
            <div class="menu-item">
                <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.usuarios') }}" class="menu-link {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Gerenciar Usuários</span>
                </a>
            </div>
        @endif

        <hr style="border-color: var(--border-color); margin: 20px 15px;">

        {{-- <div class="menu-item">
            <a href="{{ route('configuracoes') }}" class="menu-link">
                <i class="fas fa-cog"></i>
                <span>Configurações</span>
            </a>
        </div> --}}
        <div class="menu-item">
            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="button" onclick="openLogoutModal()" class="menu-link" style="width: 100%; border: none; background: none; padding: 12px 15px; text-align: left; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sair</span>
                </button>
            </form>
        </div>
    </nav>
</div>

<div id="logout-modal" class="logout-modal-overlay" onclick="closeLogoutModal(event)">
    <div class="logout-modal-box">
        <div class="logout-modal-icon">
            <i class="fas fa-sign-out-alt"></i>
        </div>
        <h3 class="logout-modal-title">Tem certeza que deseja sair?</h3>
        <br>
        {{-- <p class="logout-modal-text"> Você precisará fazer login novamente para acessar o sistema.</p> --}}
        <div class="logout-modal-actions">
            <button type="button" class="logout-btn-cancel" onclick="closeLogoutModal()">
                Cancelar
            </button>
            <button type="button" class="logout-btn-confirm" onclick="confirmLogout()">
                <i class="fas fa-sign-out-alt"></i>
                Sair
            </button>
        </div>
    </div>
</div>

<script>
    function openLogoutModal() {
        const modal = document.getElementById('logout-modal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLogoutModal(event) {
        if (event && event.target !== document.getElementById('logout-modal')) return;
        const modal = document.getElementById('logout-modal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    function confirmLogout() {
        document.getElementById('logout-form').submit();
    }

    // Fecha com a tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('logout-modal');
            if (modal.classList.contains('active')) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    });
</script>