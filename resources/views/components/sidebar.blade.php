<ul class="navbar-nav bg-gradient-sisifo sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-landmark"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SÍSIFO</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Início</span></a>
    </li>

    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Externas
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-folder"></i>
            <span>Espaider</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a href="{{ url('/espaider-juizos') }}" class='collapse-item'>Juízos</a>
                <a href="{{ url('/espaider-orgaos') }}" class='collapse-item'>Órgãos</a>
                <a href="{{ url('/espaider-comarcas') }}" class='collapse-item'>Comarcas</a>
                <a href="{{ url('/espaider-ufs') }}" class='collapse-item'>Unidades Federativas</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-folder"></i>
            <span>Tribunais</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Utilities:</h6> -->
                <a href="{{ url('/sistemas-jud-juizos') }}" class='collapse-item'>Juízos (outros sistemas)</a>
                <a href="{{ url('/eselo-juizos') }}" class='collapse-item'>Juízos (e-Selo)</a>
                <a href="{{ url('/eselo-comarcas') }}" class='collapse-item'>Comarcas (e-Selo)</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Internas
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
            <i class="fas fa-fw fa-cog"></i>
            <span>Permissões e Logs</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Login Screens:</h6> -->
                <a href="{{ url('/users') }}" class='collapse-item'>Usuários do Sísifo</a>
                <a href="{{ url('/log-alteracoes') }}" class='collapse-item'>Logs</a>
                <a href="{{ url('/tabelas') }}" class='collapse-item'>Tabelas</a>
                <a href="{{ url('/campos') }}" class='collapse-item'>Campos</a>
                <a href="{{ url('/tipos-permissoes') }}" class='collapse-item'>Tipos de permissão</a>
                <a href="{{ url('/generos') }}" class='collapse-item'>Gêneros</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>