<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct() 
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function login(Request $request) 
    { 
        $this->validator($request);

        if(Auth::guard('admin')->attempt($request->only('email','password'), $request->filled('remember'))) {
            return redirect()
                ->intended(route('admin.index'))
                ->with('status_login','Login efetuado com sucesso!');
        }

        return $this->loginFailed();
    }

    public function index() {
        return view('admin.auth.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()
            ->route('admin.login')
            ->with('status_login','Você se desconectou!');
    }

    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            //'g-recaptcha-response' => 'required|captcha',
            'email'    => 'required|email|exists:admins|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'Login ou senha incorretos, tente novamente!',
            //'g-recaptcha-response.required' => 'Você deve verificar o reCAPTCHA.',
            //'g-recaptcha-response.captcha' => 'Erro reCAPTCHA! tente novamente mais tarde ou entre em contato com o administrador do site.',
        ];

        //validate the request.
        $request->validate($rules, $messages);
    }

    private function loginFailed()
    {
        return redirect()
            ->back()->withInput()
            ->with('error_login','Login ou senha incorretos, tente novamente!');
    }
}
