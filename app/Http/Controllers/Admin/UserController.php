<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Servidor;

class UserController extends Controller
{
    public function index() {        
        if( request()->filled('termo') ) {
            $users = User::where('name', 'LIKE', '%'.request()->termo.'%')->orderBy('created_at', 'desc')->paginate(30);
        }else {
            $users = User::orderBy('created_at', 'desc')->paginate(30);
        }
        return view('admin.users.index', ['users' => $users]);
    }

    public function create() {
        $servidores = Servidor::orderBy('created_at', 'desc')->get();
        return view('admin.users.novo', ['servidores' => $servidores]);
    }

    public function store(Request $request) {
        $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8'],
            'status'    => 'required'
        ]);

        $pass = Hash::make( $request->input('password') );
        $request->merge(['password' => $pass]);

        $user = User::create( $request->all() );
        if( isset($user) ) {
            $vms = $request->get('vms');      
            if( $vms != null && is_array($vms) ) {
                $user->vms()->sync($vms);
            }
        }

        return redirect()->route('users.create')
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        $user = User::find($id);      
        if( isset($user) ) {
            $servidores = Servidor::orderBy('created_at', 'desc')->get();
            return view('admin.users.edit', [
                'user' => $user, 
                'servidores' => $servidores,
                'user_vms' => $user->vms->pluck('id')->toJson()
            ]);
        }
    }

    public function update(Request $request, $id) {
        $user = User::find($id);
        if( isset($user) ) {
            $request->validate([
                'name'      => ['required', 'string', 'max:255'],
                'status'    => 'required'
            ]);

            if( $request->input('password') != null ) {
                $pass = Hash::make( $request->input('password') );
                $request->merge(['password' => $pass]);
            }else {
                $request->request->remove('password');
            }

            $vms = $request->get('vms');
            if( $vms != null && is_array($vms) ) {
                $user->vms()->sync($vms);
            }else { 
                $user->vms()->detach();
            }
                    
            $user->update( $request->all() );
                
            return redirect()->route('users.edit', $id)
                ->with('success', 'Usuário atualizado com sucesso!');
        }

    }

    public function destroy($id) {

    }
}
