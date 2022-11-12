<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Speed;
use App\Models\Driver;
use App\Models\incidence;
use Carbon\Carbon;


class DashboardController extends Controller
{
    
    public function index()
    {   
        $km_20_40=array();
        $km_40_60=array(); 
        $km_60_80=array(); 
        $km_80_100=array(); 

        $month0="";
        $month1="";
        $month2="";
        $month3="";
        $month4="";
        $month5="";
        $value0=0;
        $impru0=0;
        $value1=0;
        $impru1=0;
        $value2=0;
        $impru2=0;
        $value3=0;
        $impru3=0;
        $value4=0;
        $impru4=0;
        $value5=0;
        $impru5=0;
        
        $fecha = Carbon::now()->startOfMonth()->subMonth(2);
        for($i=0;$i<6;$i++){
            $fecha = Carbon::now()->startOfMonth()->subMonth($i);
            ${"month" . $i}=$fecha->format("F");
            $result=$this->slq_speed($fecha->month,$fecha->year);
            ${"value" .$i}=$result['value'];
            ${"impru" .$i}=$result['impru'];
            array_push($km_20_40,$result['prox_20_40']);
            array_push($km_40_60,$result['prox_40_60']);
            array_push($km_60_80,$result['prox_60_80']);
            array_push($km_80_100,$result['prox_80_100']);
            
            
        }
        
        $d_totales=Device::all()->count();
        $d_activos=Device::where('status',1)->count();
        $d_reposo=Device::where('status',0)->count();
        $hombres=Driver::join('users',"drivers.id_user","=","users.id")->where('users.gender','=','m')->count();
        $mujeres=Driver::join('users',"drivers.id_user","=","users.id")->where('users.gender','=','f')->count();
        
        return view('admin.dashboard.index',compact('km_20_40','km_40_60','km_60_80','km_80_100','value0','value1','value2','value3','value4','value5','impru0','impru1','impru2','impru3','impru4','impru5','month0','month1','month2','month3','month4','month5','hombres','mujeres','d_totales','d_activos','d_reposo'));
    }

    public function slq_speed($mes,$año)
    {
        $imp=incidence::where('type','=',0)->whereMonth('created_at',$mes)->whereYear('created_at', $año)->count();
        $vel=Speed::whereMonth('created_at',$mes)->whereYear('created_at',$año)->avg('value');

        $prox_20_40=incidence::where('type','=',1)->whereMonth('created_at',$mes)->whereYear('created_at', $año)
                        ->where('speed','>=','20')->where('speed','<','40')->count();
        
        $prox_40_60=incidence::where('type','=',1)->whereMonth('created_at',$mes)->whereYear('created_at', $año)
                        ->where('speed','>=','40')->where('speed','<','60')->count();
        
        $prox_60_80=incidence::where('type','=',1)->whereMonth('created_at',$mes)->whereYear('created_at', $año)
                        ->where('speed','>=','60')->where('speed','<','80')->count();
        
        $prox_80_100=incidence::where('type','=',1)->whereMonth('created_at',$mes)->whereYear('created_at', $año)
                        ->where('speed','>=','80')->where('speed','<=','100')->count();
        if(empty($vel)){
            $vel=0;
        }
        if(empty($vel)){
            $imp=0;
        }
        if(empty($prox_20_40)){
            $prox_20_40=0;
        }
        if(empty($prox_40_60)){
            $prox_40_60=0;
        }
        if(empty($prox_60_80)){
            $prox_60_80=0;
        }
        if(empty($prox_80_100)){
            $prox_80_100=0;
        }
        return ['value'=>$vel,'impru'=>$imp,'prox_20_40'=>$prox_20_40,'prox_40_60'=>$prox_40_60,'prox_60_80'=>$prox_60_80,'prox_80_100'=>$prox_80_100];
        
    }

    public function speeds(Request $request)
    {
        
        if($request->ajax()){
            $speeds=Speed::latest()->take(10)->get();
            $value=$speeds->avg('value');
            if($value){
                return response()->json([
                    'success' => $value
                ]);
            }else{
                return response()->json([
                    'error' => 'Algo salio mal'
                ]);
            }
            
        }
}
}