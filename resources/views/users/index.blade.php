@extends('layouts.app-user', ['control' => 'geral'])

@section('content')

<div class="container-fluid">
    <h1 class="mt-4">Máquinas virtuais</h1>
    <br /><br />

    <div class="list-group">
        @if( count($vms) > 0 )
            @foreach( $vms as $vm )
                <a href="{{ route('vm.show.index', $vm->id) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $vm->name }}</h5>
                        <small class="text-muted"></small>
                    </div>
                    <p class="mb-1">{{ $vm->description }}</p>
                    <small class="text-muted">Servidor: {{ $vm->servidor->name }}</small>
                </a>
            @endforeach    
        @else
            <p>Não há maquinas virtuais.</p>
        @endif
    </div>

</div>

@endsection
