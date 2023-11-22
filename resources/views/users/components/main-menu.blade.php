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
                        <a class="nav-link" href="{{ route('user.index') }}">Máquinas virtuais</a>
                    </nav>
                </div>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logado como: {{ $user->name }}</div>           
        </div>
    </nav>
</div>