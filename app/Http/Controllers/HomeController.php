<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        
        return abort(404);
    }

    public function profileAdmin()
    {
        $user=Auth::user(); 
        $type_id = array('0' => 'Cedula de ciudadania', '1' => 'Tarjeta de identidad','2' => 'Cedula de extranjeria', '3' => 'Pasaporte');
        return view('admin.profile.index',compact('user','type_id'));
    }

    public function profileUser()
    {
        $user=Auth::user(); 
        $type_id = array('0' => 'Cedula de ciudadania', '1' => 'Tarjeta de identidad','2' => 'Cedula de extranjeria', '3' => 'Pasaporte');
        return view('user.profile.index',compact('user','type_id'));
    }

    public function root()
    {
        //
        return view('admin.index');
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {   
        
        $rules=[
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'identificacion' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required'],
            'city' => ['required', 'string'],
            'tipo_identificacion'=>['required'],
            'email' => ['required','email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
        $messages = [
            'name.required' => 'Sus nombres son requeridos.',
            'name.string' => 'Nombres invalidos.',
            'last_name.required' => 'Sus apellidos son requeridos.',
            'last_name.string' => 'Apellidos invalidos.',
            'identificacion.required' => 'Su identificacion es requerida.',
            'date_of_birth.string' => 'Fecha de nacimiento invalida.',
            'date_of_birth.required' => 'Su Fecha de nacimiento es requerida.',
            'city.string' => 'Ciudad invalida.',
            'city.required' => 'Su ciudad de origen es requerida.',
            'gender.required' => 'Su genero es requerido.',
            'tipo_identificacion.required' => 'Su tipo de identificacion es requerido.',
            'email.required' => 'Su email es requerido.',
            'email.email' => 'Su formato de email es invalido.',
            'avatar.nullable' => 'Por favor seleccione una imagen.',
            'avatar.image' => 'No corresponde a una imagen.',
            'avatar.mimes' => 'Seleccione imagen de tipo jpg,jpeg o png.',
            'avatar.max' => 'El tamaño de la imagen excede lo permitido.',
        ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return back()->withErrors($validator)->with('message', 'Se ha producido un error')->with('typealert', 'danger');
        }else{

            $user = User::findOrFail($id);
            $user->name = $request->get('name');
            $user->last_name = $request->get('last_name');
            $user->gender = $request->get('gender');
            $user->email = $request->get('email');
            $user->id_user = $request->get('identificacion');
            $user->date_of_birth = date('Y-m-d', strtotime($request->get('date_of_birth')));
            $user->city=$request->get('city');
            $user->type_id=$request->get('tipo_identificacion');
            if ($request->file('avatar')) {
                if($user->avatar){
                    @unlink($user->avatar);
                }
                $avatar = $request->file('avatar');
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatarPath = public_path('./images/storage/users-photo-profile/');
                $avatar->move($avatarPath, $avatarName);
                $user->avatar = './images/storage/users-photo-profile/' . $avatarName;
            }
           
            $user->update();
            if ($user) {
                Session::flash('message', 'Los datos fueron actualizados correctamente!');
                Session::flash('alert-class', 'alert-success');
                return redirect()->back();
            } else {
                Session::flash('message', 'Ocurrio un error!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
 
        }
        
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "
                Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code 
        } else {
            $user = User::findOrFail($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('password-change', 'Contraseña actualizada!');
                Session::flash('class-alert', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Contraseña actualizada!"
                ], 200); // Status code here
            } else {
                Session::flash('password-change', 'Algo ocurrio mal!');
                Session::flash('class-alert', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Algo ocurrio mal!"
                ], 200); // Status code here
            }
        }
    }
}
