<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Device;
use App\Models\Driver;
use App\Models\incidence;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class MonitoringDriverController extends Controller
{
    public function index($id)
    {
        $actual=Carbon::now();
        $año=$actual->year;
        $array_speed=array();
        $array_distance=array();

        $fecha=Carbon::now();
        $año=$fecha->year;

        $user=Driver::where("id_device","=",$id)->get();
        // return $user[0]->id_user;
      // $user=Driver::findOrFail($id);
        $id_user=$user[0]->id_user;

        $user=User::findOrFail($id_user);

        $device=Device::findOrFail($id);
        $actual = \Carbon\Carbon::now();
        $nacimiento =\Carbon\Carbon::parse($user->date_of_birth);
        $dif=$actual->diffInMonths($nacimiento);
        $años=$dif/12;
        $edad=(int)$años;


        $conductor=Driver::where("id_device","=",$id)->get()[0];
        $date_registro=\Carbon\Carbon::parse( $conductor->created_at);
        $dias=$actual->diffInDays($date_registro);
        $monitoreo=(int)$dias;

        for($i=1;$i<=12;$i++){
            $vel=$this->countFaltasSpeed($año,$i,$id);
            array_push($array_speed,$vel);
        }
        for($k=1;$k<=12;$k++){
            $dis=$this->countFaltasDistance($año,$k,$id);
            array_push($array_distance,$dis);
        }
        
    
        
        return view('admin.devices.monitoring.index',compact('id','año','array_distance','array_speed','device','user','edad','monitoreo'));
    }

    public function countFaltasSpeed($year,$mes,$id_driver)
    {
        $total_v=incidence::where('id_driver','=',$id_driver)->whereYear('created_at','=',$year)
                        ->whereMonth('created_at','=',$mes)->where('type','=',0)->count();

        return $total_v;
    }
    public function countFaltasDistance($year,$mes,$id_driver)
    {
        $total_d=incidence::where('id_driver','=',$id_driver)->whereYear('created_at','=',$year)
                        ->whereMonth('created_at','=',$mes)->where('type','=',1)->count();

        return $total_d;
    }

    public  function  scriptArduino($id)
    {
        $device=Device::findOrFail($id);
        $name='script_id_user-'.$id.'.ino';
        if($device->url_script==''){
         //   Storage::put('scripts-arduino/'.$name,"import us  libr");
            Storage::append('scripts-arduino/'.$name, "variables y demas: $id");
            Storage::append('scripts-arduino/'.$name, "finnn");
            $url="/storage/scripts-arduino/".$name;
            $device->url_script=$url;
            if($device->update()){
                return Storage::download('scripts-arduino/'.$name,'script-'.$device->reference.'.ino');
            }else{
                return  back()->with('message','Ocurrio un error en la descarga');
            }
        }else{
            return Storage::download('scripts-arduino/'.$name,'script-'.$device->reference.'.ino');
        }


    }
}
