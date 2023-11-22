@extends('layouts.app-admin', ['control' => 'geral'])

@section('content')
<div class="container-fluid">

    <h1 class="mt-4">Editar Servidor: {{ $servidor->name }}</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $servidor->name }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">

            @include('components.alert', ['errors' => $errors])                 
            <form class="post_form" enctype="multipart/form-data" action="{{ route('servidores.update', $servidor->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="local_id">Local</label>
                    <select class="form-control" name="local_id" id="local_id" required>
                        <option value="">Selecione</option>
                        @foreach( $locais as $local )
                            <option value="{{ $local->id }}">{{ $local->local }}</option>
                        @endforeach                   
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input id="name" type="text" class="form-control" value="{{ $servidor->name }}" name="name" required />
                </div>

                <div class="form-group">
                    <label for="hash">Hash</label>
                    <input readonly="readonly" id="hash" type="text" class="form-control" value="{{ $servidor->hash }}" name="hash" required />
                </div>

                <div class="form-group">
                    <label for="ip">IP</label>
                    <input id="ip" type="text" class="form-control" value="{{ $servidor->ip }}" name="ip" required />
                </div>
                
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea class="form-control" name="description" id="description" rows="5">{{ $servidor->description }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="submit" class="btn btn-secondary" 
                    onclick="window.location='{{ route('servidores.index') }}';return false;">Voltar</button>
            </form>

            <script type="application/javascript">
                jQuery("#local_id").val('{{ $servidor->local_id }}');
            </script>

        </div>
    </div>
    
</div>
@endsection
