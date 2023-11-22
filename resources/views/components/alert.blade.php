@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {!! session('success') !!}
    </div>
@endif

@if(session('error_login'))
    <div class="alert alert-danger">
        {{ session('error_login') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        Os seguintes erros foram encontrados:<br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif