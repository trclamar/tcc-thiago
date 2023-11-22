@extends('layouts.app-admin', ['control' => 'geral'])

@section('content')
<div class="container-fluid">

    <h1 class="mt-4">Lista de servidores Cadastrados</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Servidores</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            
            @include('components.alert', ['errors' => $errors])
            
            <div id="top" class="row">
                <div class="col-sm-3">
                    <h2>Itens</h2>
                </div>
                <div class="col-sm-6">
                    <form action="{{ route('servidores.index') }}" method="get">
                        <div class="input-group h2">                     
                            <input name="termo" value="{{ request()->filled('termo') ? request()->termo : '' }}" 
                                class="form-control" id="search" type="text" placeholder="Pesquise por nome">                                                                                       
                        </div>
                        <button class="btn btn-primary" type="submit">Buscar</button>
                        <a href="{{ route('servidores.index') }}">Esquecer busca</a>
                    </form>                              
                </div>
            </div>
            <br />
            <h5 class="card-title"> 
                Exibindo {{ $servidores->count() }} servidores de {{ $servidores->total() }}
            </h5>
            
            <p><a class="btn btn-primary" href="{{ route('servidores.create') }}" role="button">Novo</a></p>
            
            <div id="list" class="row">          
                <div class="table-responsive col-md-12">
                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Hash</th>
                                <th>IP</th>
                                <th>Local</th>
                                <th>Data de cadastro</th>
                                <th>Última edição</th>
                                <th class="actions">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( count($servidores) > 0 )
                                @foreach( $servidores as $server )
                                    <tr>
                                        <td>{{ $server->id }}</td>
                                        <td>{{ $server->name }}</td>
                                        <td>{{ $server->hash }}</td>
                                        <td>{{ $server->ip }}</td>
                                        <td>{{ $server->local->local }}</td>
                                        <td>{{ \Carbon\Carbon::parse($server->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($server->updated_at)->format('d/m/Y H:i') }}</td>
                                        <td class="actions">
                                            <a class="btn btn-warning btn-xs" href="{{ route('servidores.edit', $server->id) }}">Editar</a>                                       
                                        </td>
                                    </tr>    
                                @endforeach
                            @endif              
                        </tbody>
                    </table>
                </div>            
            </div> <!-- /#list -->

            <div class="card-footer">
                {{ $servidores->appends(request()->input())->links() }}
            </div>


        </div>
    </div>
    
</div>
@endsection
