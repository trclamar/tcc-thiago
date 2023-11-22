@extends('layouts.app-admin', ['control' => 'geral'])

@section('content')
<div class="container-fluid">

    <h1 class="mt-4">Editar Local: {{ $local->local }}</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $local->local }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">

            @include('components.alert', ['errors' => $errors])                 
            <form class="post_form" enctype="multipart/form-data" action="{{ route('locais.update', $local->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="local">Local</label>
                    <input id="local" type="text" class="form-control" value="{{ $local->local }}" name="local" required />
                </div>
                
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="submit" class="btn btn-secondary" 
                    onclick="window.location='{{ route('locais.index') }}';return false;">Voltar</button>
            </form>

            <script type="application/javascript">

            </script>

        </div>
    </div>
    
</div>
@endsection
