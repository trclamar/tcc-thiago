<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vm;
use App\Servidor;
use App\User;

class VmController extends Controller
{
    public function index() {        
        if( request()->filled('termo') ) {
            $vms = Vm::where('name', 'LIKE', '%'.request()->termo.'%')->orderBy('created_at', 'desc')->paginate(30);
        }else {
            $vms = Vm::orderBy('created_at', 'desc')->paginate(30);
        }
        return view('admin.vms.index', ['vms' => $vms]);
    }

    public function create() {
        $servidores = Servidor::orderBy('created_at', 'desc')->get();
        $users      = User::where('status', 'A')->orderBy('created_at', 'desc')->get();
        return view('admin.vms.novo', ['servidores' => $servidores, 'users' => $users]);
    }

    public function store(Request $request) {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'hash'  => ['required', 'unique:vms'],
            'servidor_id'  => ['required'],
        ]);

        $vm = Vm::create( $request->all() );

        if( isset($vm) ) {
            $users = $request->get('users');      
            if( $users != null && is_array($users) ) {
                $vm->usuarios()->sync($users);
            }
        }

        return redirect()->route('vms.create')
            ->with('success', 'VM criada com sucesso!');
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        $vm = Vm::find($id);      
        if( isset($vm) ) {
            $servidores = Servidor::orderBy('created_at', 'desc')->get();
            $users      = User::where('status', 'A')->orderBy('created_at', 'desc')->get();
            return view('admin.vms.edit', [
                'vm' => $vm, 
                'servidores' => $servidores, 
                'users' => $users, 
                'vm_users' => $vm->usuarios->pluck('id')->toJson()
            ]);
        }
    }

    public function update(Request $request, $id) {
        $vm = Vm::find($id);
        if( isset($vm) ) {
            $request->validate([
                'name'  => ['required', 'string', 'max:255'],
                'hash'  => ['required'],
                'servidor_id'  => ['required'],
            ]);

            $users = $request->get('users');
            if( $users != null && is_array($users) ) {
                $vm->usuarios()->sync($users);
            }else { 
                $vm->usuarios()->detach();
            }

            $vm->update( $request->only('name', 'servidor_id', 'description') );                
            return redirect()->route('vms.edit', $id)->with('success', 'VM atualizada com sucesso!');
        }

    }

    public function destroy($id) {

    }
}
