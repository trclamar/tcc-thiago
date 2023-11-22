@extends('layouts.app-admin', ['control' => 'user'])

@section('content')
<div class="container-fluid">

    <h1 class="mt-4">Lista de Usuários Cadastrados</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Usuários</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-body">
            
            @include('components.alert', ['errors' => $errors])
            
            <div id="top" class="row">
                <div class="col-sm-3">
                    <h2>Itens</h2>
                </div>
                <div class="col-sm-6">
                    <form action="{{ route('users.index') }}" method="get">
                        <div class="input-group h2">                     
                            <input name="termo" value="{{ request()->filled('termo') ? request()->termo : '' }}" 
                                class="form-control" id="search" type="text" placeholder="Pesquise por nome">                                                                                       
                        </div>
                        <button class="btn btn-primary" type="submit">Buscar</button>
                        <a href="{{ route('users.index') }}">Esquecer busca</a>
                    </form>                              
                </div>
            </div>
            <br />
            <h5 class="card-title"> 
                Exibindo {{ $users->count() }} usuários de {{ $users->total() }}
            </h5>
            
            <p><a class="btn btn-primary" href="{{ route('users.create') }}" role="button">Novo</a></p>
            
            <div id="list" class="row">          
                <div class="table-responsive col-md-12">
                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>status</th>
                                <th>Máquinas virtuais</th>
                                <th>Data de cadastro</th>   
                                <th>Última edição</th>                             
                                <th class="actions">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( count($users) > 0 )
                                @foreach( $users as $user )
                                    @php( $vms = implode(', ', $user->vms->pluck('name')->toArray()) )
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->status }}</td>
                                        <td>{{ $vms }}</td>
                                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') }}</td>
                                        <td class="actions">
                                            <a class="btn btn-warning btn-xs" href="{{ route('users.edit', $user->id) }}">Editar</a>                                       
                                        </td>
                                    </tr>    
                                @endforeach
                            @endif              
                        </tbody>
                    </table>
                </div>            
            </div> <!-- /#list -->

            <div class="card-footer">
                {{ $users->appends(request()->input())->links() }}
            </div>


        </div>
    </div>
    
</div>
@endsection
