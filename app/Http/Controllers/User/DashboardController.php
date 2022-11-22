<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Device;
use App\Models\Driver;
use Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        
        $id_usuario=Auth::user()->id;
        $id_user=Driver::findOrFail($id_usuario)->pluck('id_user');
        $user=User::findOrFail($id_user)->first();
        $device=Device::findOrFail($id_usuario); 
        $actual = \Carbon\Carbon::now();
        $nacimiento =\Carbon\Carbon::parse($user->date_of_birth);
        $dif=$actual->diffInMonths($nacimiento);
        $años=$dif/12;
        $edad=(int)$años;

        $conductor=Driver::findOrFail($id_usuario)->first();
        $date_registro=\Carbon\Carbon::parse( $conductor->created_at);
        $dias=$actual->diffInDays($date_registro);
        $monitoreo=(int)$dias;
        return view('user.dashboard.index',compact('device','user','edad','monitoreo'));
    }
}
