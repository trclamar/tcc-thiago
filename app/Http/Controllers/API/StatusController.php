<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Status;
use App\Helpers\Helper;

class StatusController extends Controller
{
    public function store(Request $request) 
    {   
        if( !in_array(\Request::ip(), Helper::getAllowedIps()) ) {
            return response()->json(['error' => true, 'message' => 'IP address not allowed'], 403);
            exit();
        }
        
        $validator = \Validator::make($request->all(), [
            'hash_server'   => 'required',
            'hash_vm'       => 'required',
            'filedata'      => 'required',
            'status'        => 'required',
        ]);

        if( $validator->fails() ) {
            return response()->json([
                'error'     => true,
                'message'   => 'Validation Error.', $validator->errors()
            ]);      
        }
        
        Status::create([
            'hash_server'   => $request->get('hash_server'),
            'hash_vm'       => $request->get('hash_vm'),
            'filedata'      => $request->get('filedata'),
            'status'        => $request->get('status'),
        ]);
        return response()->json(['error' => false, 'message' => 'Successfully created']);      
    }
}
