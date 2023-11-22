@extends('layouts.app-admin', ['control' => 'geral'])

@section('content')
<div class="container-fluid">

    <h1 class="mt-4">Editar VM: {{ $vm->name }}</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $vm->name }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">

            @include('components.alert', ['errors' => $errors])                 
            <form class="post_form" enctype="multipart/form-data" action="{{ route('vms.update', $vm->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="servidor_id">Servidor</label>
                    <select class="form-control" name="servidor_id" id="servidor_id" required>
                        <option value="">Selecione</option>
                        @foreach( $servidores as $server )
                            <option value="{{ $server->id }}">{{ $server->name }}</option>
                        @endforeach                   
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input id="name" type="text" class="form-control" value="{{ $vm->name }}" name="name" required />
                </div>

                <div class="form-group">
                    <label for="hash">Hash</label>
                    <input readonly="readonly" id="hash" type="text" class="form-control" value="{{ $vm->hash }}" name="hash" required />
                </div>
                
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea class="form-control" name="description" id="description" rows="5">{{ $vm->description }}</textarea>
                </div>

                <h6>Usuários</h6>
                @foreach( $users as $user )
                    <div class="form-check">
                        <input name="users[]" class="form-check-input" type="checkbox" value="{{ $user->id }}" id="user_{{ $user->id }}">
                        <label class="form-check-label" for="user_{{ $user->id }}">{{ $user->name }}</label>
                    </div>
                @endforeach
                <br /><br />

                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="submit" class="btn btn-secondary" 
                    onclick="window.location='{{ route('vms.index') }}';return false;">Voltar</button>
            </form>

            <script type="application/javascript">
                jQuery("#servidor_id").val('{{ $vm->servidor_id }}');

                var users = {{ $vm_users }};
                jQuery.each( users, function( key, value ) {
                    jQuery('#user_' + value).prop('checked', true);
                });
            </script>

        </div>
    </div>
    
</div>
@endsection
