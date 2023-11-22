<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Admin</title>
        <link href="{{ asset('css/') }}/styles.css" rel="stylesheet" />

        <script src="{{ asset('js/jquery.min.js') }}"></script>       
        <script src="{{ asset('biblioteca/bootstrap-4.5.0-dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('biblioteca/bootstrap-4.5.0-dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('biblioteca/MD5-Hash-String/jquery.md5.min.js') }}"></script>
        <script src="{{ asset('biblioteca/Strong-Password-Generator/js/password.js') }}"></script>
        <script src="{{ asset('js/') }}/scripts.js"></script>      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        
        @php ($user = Auth::guard('admin')->user())

        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="{{ route('admin.index') }}">Admin</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            
            <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">              
            </div>

            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $user->name }}
                        <i class="fas fa-user fa-fw"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">                      
                        <a class="dropdown-item" href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sair
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>


        <div id="layoutSidenav">
            @include('admin.components.main-menu', ['control' => $control ?? ''])
            <div id="layoutSidenav_content">
                <main>                  
                    @yield('content')
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <script type="application/javascript">           
            jQuery('.post_form').on('submit', function() {
                jQuery(this).find(':input[type=submit]').prop('disabled', true);
            });
            
            jQuery(document).on( 'focus', ':input', function() {
                jQuery(this).attr( 'autocomplete', 'disabled' );
            });           
        </script>

    </body>
</html>
