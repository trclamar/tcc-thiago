@extends('layouts.app-admin', ['control' => 'user'])

@section('content')
<div class="container-fluid">

    <h1 class="mt-4">Editar Usuário: {{ $user->name }}</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $user->name }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">

            @include('components.alert', ['errors' => $errors])                 
            <form class="post_form" enctype="multipart/form-data" action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input id="name" type="text" class="form-control" value="{{ $user->name }}" name="name" required />
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" class="form-control" value="{{ $user->email }}" name="email" required />
                </div>

                <div class="form-group">
                    <label for="password">Senha - <a href="javaScript:;" id="password_generate">Gerar senha</a></label>
                    <input id="password" type="password" class="form-control" name="password" autocomplete="new-password" placeholder="******" />
                    <p><i id="box_password">&nbsp;</i></p>
                </div>        

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status" required>
                        <option value="A">Ativo</option>
                        <option value="I">Inativo</option>
                    </select>
                </div>

                <br /><h6>Máquinas virtuais</h6>
                @foreach( $servidores as $server )
                    @php( $vms = $server->vms )
                    @if( count($vms) > 0 )
                        <hr />
                        <p><i>{{ $server->name }}</i></p>
                        @foreach( $vms as $vm )
                            <div class="form-check">
                                <input name="vms[]" class="form-check-input" type="checkbox" value="{{ $vm->id }}" id="vm_{{ $vm->id }}">
                                <label class="form-check-label" for="vm_{{ $vm->id }}">{{ $vm->name }}</label>
                            </div>
                        @endforeach
                    @endif
                @endforeach
                <br /><br />

                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="submit" class="btn btn-secondary" 
                    onclick="window.location='{{ route('users.index') }}';return false;">Voltar</button>
            </form>

            <script type="application/javascript">
                jQuery("#status").val('{{ $user->status }}');
                var vms = {{ $user_vms }};
                jQuery.each( vms, function( key, value ) {
                    jQuery('#vm_' + value).prop('checked', true);
                });

                jQuery('#password_generate').click(function() {
                    var new_app = password.generate();
                    jQuery('#password').val(new_app);
                    jQuery('#box_password').empty().html(new_app);
                });
            </script>

        </div>
    </div>
    
</div>
@endsection
