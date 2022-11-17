<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Http\Requests\StoreUsersRequest;
use Illuminate\Support\Str;
use  App\Mail\passwordSendMailable;
use Illuminate\Support\Facades\Mail;
use App\Models\User;



class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types_id = array('0' => 'Cedula de ciudadania', '1' => 'Tarjeta de identidad','2' => 'Cedula de extranjeria', '3' => 'Pasaporte');
        return view('admin.users.create',compact('types_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreUsersRequest $request)
    { 
        $tempassword=Str::random(8);

        $user= new User();
        $user->last_name=$request->input('last_name');   
        $user->name=$request->input('name');        
        $user->date_of_birth=$request->input('date_of_birth');      
        $user->password=bcrypt($tempassword);       
        $user->type_id=$request->input('type_id_doc');       
        $user->id_user=$request->input('id_user');     
        $user->role=$request->input('type_id_role');        
        $user->gender=$request->input('gender');
        $user->email=$request->input('email');
        $user->avatar="./images/default/photo-user-default.jpeg";       
        $user->status="0";
        $user->city=$request->input('city');
        $user->save(); 
        Mail::to($request->input('email'))->send(new passwordSendMailable($request->input('email'),$request->input('name'),$tempassword, "Credenciales Driver Detect"));
    
        return back()->with('mensaje', 'Haz agregado un usuario ');
    
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);
        $types_id = array('0' => 'Cedula de ciudadania', '1' => 'Tarjeta de identidad','2' => 'Cedula de extranjeria', '3' => 'Pasaporte');
        return view('admin.users.edit',compact('user','types_id'));
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $user->name=e($request->input('name'));
        $user->last_name=e($request->input('last_name'));
        $user->email=e($request->input('email'));
        $user->date_of_birth=e($request->input('date_of_birth'));
        $user->type_id=e($request->input('type_id_doc'));
        $user->id_user=e($request->input('id_user'));
        $user->role=e($request->input('type_id_role'));
        $user->gender=e($request->input('gender'));
        if($user->update()){
            return redirect('/admin/users');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete($id);
        
        return response()->json([
            'success' => 'se elimino correctamente'
        ]);
    }
}
