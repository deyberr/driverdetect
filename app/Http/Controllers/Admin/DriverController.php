<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    public function LinkDriver(Request $request)
    {
        $driver=new Driver;
        $driver->id_user=e($request->input('id_user'));
        $driver->modelo_moto=e($request->input('marca'));
        $driver->cilindraje=e($request->input('cilindraje'));
        $driver->placa=e($request->input('placa'));
        if($driver->save()){
            return redirect('/admin/devices/1');
        }
    }

    public function RemoveDriver($id)
    {

    }

    public function UpdateDriver(Request $request,$id)
    {

    }
}
