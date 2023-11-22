@extends('layouts.app-user', ['control' => 'geral'])

@section('content')

<div class="container-fluid">
    <h1 class="mt-4">Máquina virtual: {{ $vm->name }}</h1>
    <a class="btn btn-secondary btn-sm" href="{{ route('user.index') }}" role="button">Voltar</a>
    <br /><br /><br />
	
	<div class="d-flex align-items-center justify-content-center">
        <div class="p-2 bd-highlight col-example">
			@if(session('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert" style="width:720px;">
					{!! session('success') !!}
				</div>
			@endif
		</div>
    </div>

    <div class="d-flex align-items-center justify-content-center" id="mainBox"></div>
    <br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>

<script type="application/javascript">
    jQuery(document).ready(function() {  
		function getData() {                                                                
			jQuery.ajax({
				type: "post",
				url: "{{ url('/painel/ajax_status') }}",
				data: {
					server_hash: "{{ $vm->servidor->hash }}",
                    vm_hash: "{{ $vm->hash }}",
                    vm_id: "{{ $vm->id }}",       
					_token: jQuery('meta[name="csrf-token"]').attr('content')
				},
				dataType: 'html',
				cache: false,
				beforeSend: function(){},
				success: function(data) {
					if(data != '') {
						jQuery('#mainBox').html('');
						jQuery("#mainBox").prepend(data); 
					}else {
						jQuery('#mainBox').html('');
						jQuery("#mainBox").prepend('<p>Não há conteúdo.</p>'); 
					}          

                    var timeleft = 20;
                    var downloadTimer = setInterval(function() {
                        if( timeleft <= 0 ) {
                            clearInterval(downloadTimer);
                        }else {
                            document.getElementById("countdown").innerHTML = "Os dados serão atualizados em " + timeleft + " segundos.";
                        }
                        timeleft -= 1;
                    }, 1000);

				},
				complete: function() { 
					setTimeout(getData, 20000);
				}
			});
		}
		getData();
	});
</script>
@endsection
