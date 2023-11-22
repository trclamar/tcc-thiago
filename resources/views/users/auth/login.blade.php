<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="robots" content="noindex">
        <title>Login do Usuário</title>
        <link href="{{ asset('css/') }}/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <!--{!! NoCaptcha::renderJs() !!}-->
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login do Usuário</h3></div>                                    
                                    <div class="card-body">
                                        @include('components.alert', ['errors' => $errors])
                                        @if(session('status_login'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{session('status_login')}}
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('user.login.submit') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label class="small mb-1" for="email">Email</label>
                                                <input class="form-control py-4" id="email" type="email" value="{{ old('email') }}" name="email" required placeholder="E-mail" autocomplete="email" autofocus />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="password">Senha</label>
                                                <input class="form-control py-4" id="password" type="password" placeholder="Senha" name="password" required autocomplete="current-password" />
                                            </div>

                                            <!--{!! NoCaptcha::display() !!}-->
                                            
                                            <br />
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="remember">Manter logado</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('biblioteca/bootstrap-4.5.0-dist/js/bootstrap.min.js') }}"></script>       
    </body>
</html>
