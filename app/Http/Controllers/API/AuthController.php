<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    private $guard = 'admin';

    public function login(Request $request)
    {       
        $validator = \Validator::make($request->all(), [
            'email'     => 'email|required',
            'password'  => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'error'     => true,
                'message'   => 'Validation Error.', $validator->errors()
            ]);      
        }

        if ( !auth()->guard($this->guard)->attempt($request->only(['email', 'password'])) ) {
            return response()->json([
                'error'     => true,
                'message'   => 'Invalid Credentials'
            ], 403);
        }

        $accessToken = auth()->guard($this->guard)->user()->createToken('authToken')->accessToken;
        return response()->json([
            'error'         => false,
            'user'          => auth()->guard($this->guard)->user()->name, 
            'access_token'  => $accessToken
        ], 200);
    }
}
