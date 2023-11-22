<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Servidor;

class ServerController extends Controller
{
    public function index() {       
        $servers = Servidor::all()->toArray();
        return response()->json([
            'error'     => false,
            'data'      => $servers
        ]);
    }
}
