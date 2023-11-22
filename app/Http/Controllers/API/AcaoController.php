<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Acao;

class AcaoController extends Controller
{
    public function index($hash_server) {
        /*$acoes = Acao::where('status', '0')->where('hash_server', trim($hash_server))->orderBy('created_at', 'asc')
            ->get(['id', 'created_at', 'hash_server', 'ip_server', 'hash_vm', 'acao', 'resultado', 'status'])->toArray();*/

        /*if( isset($acoes[0]['ip_server']) && $acoes[0]['ip_server'] != \Request::ip() ) {
            return response()->json(['error' => true, 'message' => 'IP address not allowed'], 403);
            exit();
        }*/
       
        $acoes = DB::table('acoes')
            ->join('vms', 'vms.id', '=', 'acoes.vm_id')
            ->join('servidores', 'servidores.id', '=', 'vms.servidor_id')
            ->where('servidores.hash', $hash_server)
            ->where('acoes.status', '0')
            ->select('acoes.id', 'acoes.created_at', 'acoes.hash_vm', 'acoes.acao', 'acoes.resultado', 'acoes.status', 'servidores.ip as check_ip')
            ->orderBy('acoes.created_at', 'asc')->get()->toArray();

        if( isset($acoes[0]) && $acoes[0]->check_ip != \Request::ip() ) {
            return response()->json(['error' => true, 'message' => 'IP address not allowed'], 403);
            exit();
        }

        return response()->json(['error' => false, 'data' => $acoes]);      
    }

    public function update(Request $request, $hash_server, $hash_vm, $acao_id) {   
        $validator = \Validator::make($request->all(), [
            'resultado' => 'required',
        ]);

        if( $validator->fails() ) {
            return response()->json([
                'error'     => true,
                'message'   => 'Validation Error.', $validator->errors()
            ]);      
        }

        $acao = DB::table('acoes')
            ->join('vms', 'vms.id', '=', 'acoes.vm_id')
            ->join('servidores', 'servidores.id', '=', 'vms.servidor_id')
            ->where('servidores.hash', $hash_server)
            ->where('acoes.hash_vm', $hash_vm)
            ->where('acoes.id', $acao_id)
            ->where('acoes.status', '0')
            ->select('acoes.*', 'servidores.ip as check_ip')
            ->orderBy('acoes.created_at', 'desc')->limit(1)->first();

        /*$acao = Acao::where('status', '0')->where('id', trim($acao_id))->where('hash_server', trim($hash_server))
            ->where('hash_vm', trim($hash_vm))->orderBy('created_at', 'desc')->limit(1)->first();*/
        
        if( isset($acao) ) {
            if( $acao->check_ip != \Request::ip() ) {
                return response()->json(['error' => true, 'message' => 'IP address not allowed'], 403);
                exit();
            }

            $acao = Acao::find($acao->id);
            $acao->update([
                'resultado' => $request->get('resultado'),
                'status'    => '1',
            ]);
            return response()->json(['error' => false, 'message' => 'Updated successfully']);
        }
        else{
            return response()->json(['error' => true, 'message' => 'Register not found']);  
        }       
    }
}
