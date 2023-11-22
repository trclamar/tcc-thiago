<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Vm;

class IndexController extends Controller
{
    private $guard = 'web';

    public function index() {
        $user = Auth::guard($this->guard)->user();
        return view('users.index', ['vms' => $user->vms]);
    }

    public function inativo() {
        if( Auth::guard($this->guard)->user()->status == "A" ) {
            return redirect()->route('user.index');
        }
        return view('users.inativo');
    }
    
    public function show($id) {
        $user = Auth::guard($this->guard)->user();       
        $check = DB::table('vms')
            ->join('vms_users', 'vms.id', '=', 'vms_users.vm_id')
            ->where('vms_users.vm_id', $id)->where('vms_users.user_id', $user->id)
            ->select('vms.*')->orderBy('vms.id', 'desc')->limit(1)->first();
       
        if( isset($check) ) {
            return view('users.vm', ['vm' => Vm::find($check->id)]);
        }
    }
    
    public function ajaxStatus(Request $request) {
        $request->validate([
            'server_hash' => 'required',
            'vm_hash'     => 'required',
            'vm_id'       => 'required',
        ]);

        $user = Auth::guard($this->guard)->user();       
        $check = DB::table('vms')
            ->join('vms_users', 'vms.id', '=', 'vms_users.vm_id')
            ->where('vms_users.vm_id', $request->get('vm_id'))->where('vms_users.user_id', $user->id)
            ->select('vms.*')->orderBy('vms.id', 'desc')->limit(1)->first(); 
        
        if( isset($check) ) {                   
            return view('users.vm_ajax', ['vm' => Vm::find($check->id)]);
        }

        return '';
    }
}
