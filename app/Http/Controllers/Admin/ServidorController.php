<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Servidor;
use App\Local;

class ServidorController extends Controller
{
    public function index() {        
        if( request()->filled('termo') ) {
            $servidores = Servidor::where('name', 'LIKE', '%'.request()->termo.'%')->orderBy('created_at', 'desc')->paginate(30);
        }else {
            $servidores = Servidor::orderBy('created_at', 'desc')->paginate(30);
        }
        return view('admin.servidores.index', ['servidores' => $servidores]);
    }

    public function create() {
        $locais = Local::orderBy('created_at', 'desc')->get();
        return view('admin.servidores.novo', ['locais' => $locais]);
    }

    public function store(Request $request) {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'hash'  => ['required', 'unique:servidores'],
            'ip'    => 'required|ipv4',
            'local_id'    => ['required'],
        ]);

        Servidor::create( $request->all() );

        return redirect()->route('servidores.create')
            ->with('success', 'Servidor criado com sucesso!');
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        $servidor = Servidor::find($id);      
        if( isset($servidor) ) {
            $locais = Local::orderBy('created_at', 'desc')->get();
            return view('admin.servidores.edit', ['servidor' => $servidor, 'locais' => $locais]);
        }
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'hash'  => ['required'],
            'ip'    => 'required|ipv4',
            'local_id'    => ['required'],
        ]);

        $servidor = Servidor::find($id);        
        $servidor->update( $request->only('name', 'ip', 'local_id', 'description') );
            
        return redirect()->route('servidores.edit', $id)
            ->with('success', 'Servidor atualizado com sucesso!');

    }

    public function destroy($id) {

    }
}
