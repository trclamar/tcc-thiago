<?php

namespace App\Helpers;

use App\Status;
use App\Servidor;

use Illuminate\Support\Facades\DB;

class Helper
{ 
    public static function actionName($action) {
        $actions = self::actions();
        return $actions[$action];
    }

    public static function actions() {
        return 
            [
                '1' => 'Ligar',
                '2' => 'Desligar normal',
                '3' => 'Desligar forçado',
                '4' => 'Reiniciar',
            ];
    }

    public static function getStatusName($status) {
        if( $status == '0' ) {
            return 'Pendente';
        }

        return 'Executado';
    }

    public static function getStatusVm($hash_vm) {
        
        return DB::table('status')
            ->join('vms', 'vms.hash', '=', 'status.hash_vm')
            ->join('servidores', 'servidores.hash', '=', 'status.hash_server')
            ->where('status.hash_vm', $hash_vm)
            ->select('status.*')->orderBy('status.created_at', 'desc')->limit(1)->first();

        /*return
            Status::where('hash_server', trim($hash_server))->where('hash_vm', trim($hash_vm))
            ->orderBy('created_at', 'desc')->limit(1)->first();*/
    }

    public static function getAllowedIps() {         
        $ips = Servidor::pluck('ip')->toArray();
        return array_unique($ips);
    }
}