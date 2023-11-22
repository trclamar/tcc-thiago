<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">                          
                <div class="sb-sidenav-menu-heading">Menu</div>
                
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" 
                    aria-expanded="{{ $control == 'geral' ? 'true' : 'false'}}" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Geral
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ $control == 'geral' ? 'show' : 'false'}}" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('locais.index') }}">Locais</a>
                        <a class="nav-link" href="{{ route('servidores.index') }}">Servidores</a>
                        <a class="nav-link" href="{{ route('vms.index') }}">Máquinas virtuais</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts2" 
                    aria-expanded="{{ $control == 'user' ? 'true' : 'false'}}" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Usuários
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ $control == 'user' ? 'show' : ''}}" id="collapseLayouts2" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('users.index') }}">Usuários</a>
                    </nav>
                </div>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logado como: {{ $user->name }}</div>           
        </div>
    </nav>
</div>