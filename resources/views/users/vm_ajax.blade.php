<div class="card" style="width: 45rem;">
    @php( $status = \Helper::getStatusVm($vm->hash) )
    @if( isset($status) && $status->filedata != null )
        <img style="height: 400px" class="card-img-top" src="data:image/png;base64,{{ $status->filedata }}">
    @else
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Nenhuma imagem encontrada!</li>
        </ul>
    @endif
    <i style="text-align:center;font-size:12px" id="countdown">&nbsp;</i>
    <div class="card-body">
        <h5 class="card-title">{{ $vm->name }}</h5>
        <p class="card-text">{{ $vm->servidor->name }}</p>
        @if( isset($status) )
            <p class="card-text">
                <i>Status: {{ $status->status }}</i><br />
                <i style="text-align:center;font-size:12px">Última atualização: {{ \Carbon\Carbon::parse($status->created_at)->format('d/m/Y H:i') }}</i>
            </p>           
        @endif
        <p class="card-text">{{ $vm->description }}</p>                   
        <p class="card-text"><strong>Ações:</strong></p>               
        
        <form class="post_form" action="{{ route('vm.acao.store', $vm->id) }}" method="POST">
            @csrf                
            <div class="form-group">                       
                <select class="form-control" id="acao" name="acao" required>
                    <option value="">Selecione</option>
                    @foreach( \Helper::actions() as $key => $acao )
                        <option value="{{ $key }}">{{ $acao }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enviar comando</button>
        </form>

    </div>

    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Últimas ações:</strong></li>
        @php( $ultimas = $vm->acoes->sortByDesc('created_at')->slice(0, 15) )
        @if( count($ultimas) > 0 )
            @foreach( $vm->acoes->sortByDesc('created_at')->slice(0, 15) as $acao )
                <li class="list-group-item">
                    Status: {{ \Helper::getStatusName($acao->status) }}<br />
                    Ação: {{ \Helper::actionName($acao->acao) }}<br />
                    Data de criação: {{ \Carbon\Carbon::parse($acao->created_at)->format('d/m/Y H:i') }}
                    @if( $acao->status == '1' )
                        <br />
                        Data de execução: {{ \Carbon\Carbon::parse($acao->updated_at)->format('d/m/Y H:i') }}<br />
                        Resultado: {{ $acao->resultado }}
                    @endif
                </li>
            @endforeach
        @else
            <li class="list-group-item">
                Não há ações!
            </li>
        @endif
    </ul>
</div>