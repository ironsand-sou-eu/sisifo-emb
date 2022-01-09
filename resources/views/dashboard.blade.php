<x-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Seja bem vindo, amado(a) Mestre(a)!</h1>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2 shadow mb-4">    
                <a href="#cardEspaider" class="card-header d-block py-3 pb-sm-0 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="cardEspaider" style="text-decoration: none;">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Dados de correspondência</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">Versão do Espaider</div>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse" id="cardEspaider">
                    <div class="card-body pb-0">
                        <ul class="mb-0">
                            <li><a href="{{ url('/espaider-juizos') }}" class='collapse-item'>Juízos</a></li>
                            <li><a href="{{ url('/espaider-orgaos') }}" class='collapse-item'>Órgãos</a></li>
                            <li><a href="{{ url('/espaider-comarcas') }}" class='collapse-item'>Comarcas</a></li>
                            <li><a href="{{ url('/espaider-ufs') }}" class='collapse-item'>Unidades Federativas</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 shadow mb-4">
                <a href="#cardTribunais" class="card-header d-block py-3 pb-sm-0 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="cardTribunais" style="text-decoration: none;">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Dados de correspondência</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">Versão dos tribunais</div>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse" id="cardTribunais">
                    <div class="card-body pb-0">
                        <ul class="mb-0">
                            <li><a href="{{ url('/sistemas-jud-juizos') }}" class='collapse-item'>Juízos (outros sistemas)</a></li>
                            <li><a href="{{ url('/eselo-juizos') }}" class='collapse-item'>Juízos (e-Selo)</a></li>
                            <li><a href="{{ url('/eselo-comarcas') }}" class='collapse-item'>Comarcas (e-Selo)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 pb-sm-0 shadow mb-4">    
                <a href="#cardConfig" class="card-header d-block py-3 pb-sm-0 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="cardConfig" style="text-decoration: none;">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Dados do Sísifo</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">Permissões e Logs</div>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse" id="cardConfig">
                    <div class="card-body pb-0">
                        <ul class="mb-0">
                            <li><a href="{{ url('/users') }}" class='collapse-item'>Usuários do Sísifo</a></li>
                            <li><a href="{{ url('/log-alteracoes') }}" class='collapse-item'>Logs</a></li>
                            <li><a href="{{ url('/tabelas') }}" class='collapse-item'>Tabelas</a></li>
                            <li><a href="{{ url('/campos') }}" class='collapse-item'>Campos</a></li>
                            <li><a href="{{ url('/tipos-permissoes') }}" class='collapse-item'>Tipos de permissão</a></li>
                            <li><a href="{{ url('/generos') }}" class='collapse-item'>Gêneros</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>