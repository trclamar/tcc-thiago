<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Vm;
use App\Acao;

class AcaoController extends Controller
{
    private $guard = 'web';

    public function store($id, Request $request) {
        $request->validate([
            'acao'  => ['required'],
        ]);
        
        $user = Auth::guard($this->guard)->user();       
        $check = DB::table('vms')
            ->join('vms_users', 'vms.id', '=', 'vms_users.vm_id')
            ->where('vms_users.vm_id', $id)->where('vms_users.user_id', $user->id)
            ->select('vms.*')->orderBy('vms.id', 'desc')->limit(1)->first();

        if( $check ) {
            $vm     = Vm::find($check->id);
            $server = $vm->servidor;

            if( isset($vm, $server) ) {
                Acao::create([
                    'servidor_id'   => $server->id,
                    'vm_id'         => $vm->id,
                    'hash_server'   => $server->hash,
                    'ip_server'     => $server->ip,
                    'hash_vm'       => $vm->hash,
                    'acao'          => $request->get('acao'),
                ]);
            }
        }  

        return redirect()->back()
                ->with('success', 'Ação enviada com sucesso!'); 
    }
}
