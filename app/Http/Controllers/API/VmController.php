<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vm;

class VmController extends Controller
{
    public function index() {       
        $vms = Vm::all()->toArray();
        return response()->json([
            'error'     => false,
            'data'      => $vms
        ]);
    }
}
