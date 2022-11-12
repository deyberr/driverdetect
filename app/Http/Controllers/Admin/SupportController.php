<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Mail\SupportContactSendMailable;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function index()
    {
        return view('admin.support.index');
    }

    public function tutorial()
    {
        return view('admin.support.tutorial');
    }

    public function contact(Request $request)
    {
        
            $rules = [
                'email' => 'required|email',
                'nombres' => 'required', 
                'apellidos' => 'required',
                'asunto' => 'required'
            ];
            $messages = [
                'email.required' => 'Su correo electrónico es requerido',
                'email.email' => 'El formato de su correo electrónico es invalido',
                'apellidos.required' => 'Los apellidos son requeridos',
                'nombres.required' => 'Los nombres son requeridos',
                'asunto.required' => 'El asunto es requerido',
            ];
            $validator = \Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()){
                return back()->withErrors($validator);
            }else{
                
                Mail::to('deyberluna@hotmail.com')->send(new SupportContactSendMailable($request['email'],$request['apellidos'],$request['nombres'],$request['asunto']));
                return back()->with('message','El e-mail fue enviado con exito');
            }
        
    }
}
