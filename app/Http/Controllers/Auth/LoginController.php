<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Validator,Hash, Auth, Mail;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function postLogin(Request $request)
    {
        
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];

        $messages = [
            'email.required' => 'Su correo electrónico es requerido.',
            'email.email' => 'El formato de su correo electrónico es invalido.',
            'email.unique' => 'Ya existe un usuario registrado con su correo electrónico.',
            'password.required' => 'Por favor escriba una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ];
        
        $validator = \Validator::make($request->all(), $rules, $messages);
        $remember=request()->filled('remember'); 
        
        if ($validator->fails()):
            
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
        else:
            if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember)):
                if(Auth::user()->role == 'admin'):
                    return redirect('/admin/dashboard');
                elseif(Auth::user()->role == 'user'):
                    return redirect('/user/dashboard');
                endif;
            else:
                return back()->with('message', 'La contaseña o el correo electrónico son erroneos')->with('typealert', 'danger');

            endif;

        endif;
    }

    public function logout()
    {
        
        if(Auth::guest()){
            return redirect('/login');   
        }else{   
            $status = Auth::user()->status;
        }
        Auth::logout();
        if($status == 100):
            return redirect('/login')->with('message', 'El usuario se encuentra suspendio')->with('typealert', 'danger');
        else:
            return redirect('/login');
        endif;
    }

}
