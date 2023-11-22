@extends('layouts.app-admin', ['control' => 'geral'])

@section('content')
<div class="container-fluid">

    <h1 class="mt-4">Adicionar Novo Servidor</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Novo Servidor</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">

            @include('components.alert', ['errors' => $errors])                 
            <form class="post_form" enctype="multipart/form-data" action="{{ route('servidores.store') }}" method="POST">
                @csrf

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
                    <input id="name" type="text" class="form-control" value="{{ old('name') }}" name="name" required />
                </div>

                <div class="form-group">
                    <label for="hash">Hash - <a href="javaScript:;" id="md5">Gerar hash</a></label>
                    <input id="hash" type="text" class="form-control" value="{{ old('hash') }}" name="hash" required />
                </div>

                <div class="form-group">
                    <label for="ip">IP</label>
                    <input id="ip" type="text" class="form-control" value="{{ old('ip') }}" name="ip" required />
                </div>
                
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea class="form-control" name="description" id="description" rows="5">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Adicionar</button>
                <button type="submit" class="btn btn-secondary" 
                    onclick="window.location='{{ route('servidores.index') }}';return false;">Voltar</button>
            </form>

            <script type="application/javascript">
                jQuery('#md5').click(function() {
                    var random = Math.floor(Math.random() * 999999999) + 1;
                    jQuery('#hash').val( jQuery.MD5('' + random + '') );
                });
            </script>

        </div>
    </div>
    
</div>
@endsection
