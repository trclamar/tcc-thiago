<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Local;

class LocalController extends Controller
{
    public function index() {        
        if( request()->filled('termo') ) {
            $locais = Local::where('local', 'LIKE', '%'.request()->termo.'%')->orderBy('created_at', 'desc')->paginate(30);
        }else {
            $locais = Local::orderBy('created_at', 'desc')->paginate(30);
        }
        return view('admin.locais.index', ['locais' => $locais]);
    }

    public function create() {
        return view('admin.locais.novo');
    }

    public function store(Request $request) {
        $request->validate([
            'local' => ['required', 'string', 'max:255'],
        ]);

        Local::create( $request->all() );

        return redirect()->route('locais.create')
            ->with('success', 'Local criado com sucesso!');
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        $local = Local::find($id);      
        if( isset($local) ) {
            return view('admin.locais.edit', ['local' => $local]);
        }
    }

    public function update(Request $request, $id) {
        $request->validate([
            'local' => ['required', 'string', 'max:255'],
        ]);

        $local = Local::find($id);        
        $local->update( $request->all() );
            
        return redirect()->route('locais.edit', $id)
            ->with('success', 'Local atualizado com sucesso!');

    }

    public function destroy($id) {

    }
}
