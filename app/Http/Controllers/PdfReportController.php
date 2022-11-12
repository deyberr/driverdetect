<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\incidence;
use App\Models\Device;
use PDF,DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon; 

class PdfReportController extends Controller
{
    public function PdfReportUser(Request $request)
    {
    }

    public function PdfReportAdmin(Request $request)
    {

       

      $date = Carbon::now()->format('Y-m-d');
      //CONSULTAS

      $diurna= DB::table('incidences')
      ->whereTime('created_at', '>=', '06:00:00')
      ->whereTime('created_at', '<', '21:00:00');

      $nocturna= DB::table('incidences')
        ->whereTime('created_at', '>=', '21:00:00')
        ->orWhereTime('created_at', '<', '06:00:00');
      

      //Grupo etario-faltas
      $etario_m= incidence::join("devices","incidences.id_device","=","devices.id")
        ->join("drivers","incidences.id_driver","=","drivers.id")
        ->join("users","drivers.id_user","=","users.id")
        ->where("users.gender","=","m")
        ->select("users.date_of_birth");
      
      $etario_f= incidence::join("devices","incidences.id_device","=","devices.id")
        ->join("drivers","incidences.id_driver","=","drivers.id")
        ->join("users","drivers.id_user","=","users.id")
        ->where("users.gender","=","f")
        ->select("users.date_of_birth");

      //cilindraje
      $cc_100_m= incidence::join("devices","incidences.id_device","=","devices.id")
        ->join("drivers","incidences.id_driver","=","drivers.id")
        ->join("users","drivers.id_user","=","users.id")
        ->where("users.gender","=","m")
        ->where("devices.displacement",">=","100")
        ->where("devices.displacement","<=","124");
      
      $cc_100_f= incidence::join("devices","incidences.id_device","=","devices.id")
        ->join("drivers","incidences.id_driver","=","drivers.id")
        ->join("users","drivers.id_user","=","users.id")
        ->where("users.gender","=","f")
        ->where("devices.displacement",">=","100")
        ->where("devices.displacement","<=","124");

      $cc_125_m= incidence::join("devices","incidences.id_device","=","devices.id")
        ->join("drivers","incidences.id_driver","=","drivers.id")
        ->join("users","drivers.id_user","=","users.id")
        ->where("users.gender","=","m")
        ->where("devices.displacement",">=","125")
        ->where("devices.displacement","<=","149");
      
      $cc_125_f= incidence::join("devices","incidences.id_device","=","devices.id")
        ->join("drivers","incidences.id_driver","=","drivers.id")
        ->join("users","drivers.id_user","=","users.id")
        ->where("users.gender","=","f")
        ->where("devices.displacement",">=","125")
        ->where("devices.displacement","<=","149");

      $cc_150_m= incidence::join("devices","incidences.id_device","=","devices.id")
        ->join("drivers","incidences.id_driver","=","drivers.id")
        ->join("users","drivers.id_user","=","users.id")
        ->where("users.gender","=","m")
        ->where("devices.displacement",">=","150")
        ->where("devices.displacement","<=","200");
      
      $cc_150_f= incidence::join("devices","incidences.id_device","=","devices.id")
        ->join("drivers","incidences.id_driver","=","drivers.id")
        ->join("users","drivers.id_user","=","users.id")
        ->where("users.gender","=","f")
        ->where("devices.displacement",">=","150")
        ->where("devices.displacement","<=","200");
      
      $cc_200_m= incidence::join("devices","incidences.id_device","=","devices.id")
        ->join("drivers","incidences.id_driver","=","drivers.id")
        ->join("users","drivers.id_user","=","users.id")
        ->where("users.gender","=","m")
        ->where("devices.displacement",">=","200");
      
      $cc_200_f= incidence::join("devices","incidences.id_device","=","devices.id")
        ->join("drivers","incidences.id_driver","=","drivers.id")
        ->join("users","drivers.id_user","=","users.id")
        ->where("users.gender","=","f")
        ->where("devices.displacement",">=","200");
      
        
        
      //VALIDAR  REPORTE

      $tipo_reporte=$request->query('type');
      $valor=$request->query('value');

      if($tipo_reporte=='año'){
          Session::flash('tipo','ANUAL');
          Session::flash('fecha',$valor);
          $diurna->whereYear('created_at', '=',$valor);
          $nocturna->whereYear('created_at', '=', $valor);
          $id_devices=incidence::whereYear('created_at', '=', $valor)->pluck('id_device');
          $count_incidences=incidence::whereYear('created_at', '=', $valor)->count();
          $etario_f->whereYear('incidences.created_at', '=',$valor);
          $etario_m->whereYear('incidences.created_at', '=',$valor);
          $cc_100_m->whereYear('incidences.created_at','=',$valor);
          $cc_100_f->whereYear('incidences.created_at','=',$valor);
          $cc_125_m->whereYear('incidences.created_at','=',$valor);
          $cc_125_f->whereYear('incidences.created_at','=',$valor);
          $cc_150_m->whereYear('incidences.created_at','=',$valor);
          $cc_150_f->whereYear('incidences.created_at','=',$valor);
          $cc_200_m->whereYear('incidences.created_at','=',$valor);
          $cc_200_f->whereYear('incidences.created_at','=',$valor);
      }elseif($tipo_reporte=='sini'){
          Session::flash('tipo','SEMESTRAL');
          Session::flash('fecha',$valor.' (Enero-Junio)');
          $diurna->whereYear('created_at', '=',$valor)->whereMonth('created_at','>=','01')->whereMonth('created_at','<=','06');
          $nocturna->whereYear('created_at', '=', $valor)->whereMonth('created_at','>=','01')->whereMonth('created_at','<=','06');
          $id_devices=incidence::whereYear('created_at', '=', $valor)->whereMonth('created_at','>=','01')->whereMonth('created_at','<=','06')->pluck('id_device');
          $count_incidences=incidence::whereYear('created_at', '=', $valor)->whereMonth('created_at','>=','01')->whereMonth('created_at','<=','06')->count();
          $etario_f->whereYear('incidences.created_at', '=',$valor)->whereMonth('incidences.created_at','>=','01')->whereMonth('incidences.created_at','<=','06');
          $etario_m->whereYear('incidences.created_at', '=',$valor)->whereMonth('incidences.created_at','>=','01')->whereMonth('incidences.created_at','<=','06');
          $cc_100_m->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','01')->whereMonth('incidences.created_at','<=','06');
          $cc_100_f->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','01')->whereMonth('incidences.created_at','<=','06');
          $cc_125_m->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','01')->whereMonth('incidences.created_at','<=','06');
          $cc_125_f->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','01')->whereMonth('incidences.created_at','<=','06');
          $cc_150_m->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','01')->whereMonth('incidences.created_at','<=','06');
          $cc_150_f->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','01')->whereMonth('incidences.created_at','<=','06');
          $cc_200_m->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','01')->whereMonth('incidences.created_at','<=','06');
          $cc_200_f->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','01')->whereMonth('incidences.created_at','<=','06');
          
      }elseif($tipo_reporte=='sfin'){
          Session::flash('tipo','SEMESTRAL');
          Session::flash('fecha',$valor.' (Enero-Junio)');
          $diurna->whereYear('created_at', '=',$valor)->whereMonth('created_at','>=','07')->whereMonth('created_at','<=','12');
          $nocturna->whereYear('created_at', '=', $valor)->whereMonth('created_at','>=','07')->whereMonth('created_at','<=','12');
          $id_devices=incidence::whereYear('created_at', '=', $valor)->whereMonth('created_at','>=','07')->whereMonth('created_at','<=','12')->pluck('id_device');
          $count_incidences=incidence::whereYear('created_at', '=', $valor)->whereMonth('created_at','>=','07')->whereMonth('created_at','<=','06')->count();
          $etario_f->whereYear('incidences.created_at', '=',$valor)->whereMonth('incidences.created_at','>=','07')->whereMonth('incidences.created_at','<=','12');
          $etario_m->whereYear('incidences.created_at', '=',$valor)->whereMonth('incidences.created_at','>=','07')->whereMonth('incidences.created_at','<=','12');
          $cc_100_m->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','07')->whereMonth('incidences.created_at','<=','12');
          $cc_100_f->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','07')->whereMonth('incidences.created_at','<=','12');
          $cc_125_m->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','07')->whereMonth('incidences.created_at','<=','12');
          $cc_125_f->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','07')->whereMonth('incidences.created_at','<=','12');
          $cc_150_m->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','07')->whereMonth('incidences.created_at','<=','12');
          $cc_150_f->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','07')->whereMonth('incidences.created_at','<=','12');
          $cc_200_m->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','07')->whereMonth('incidences.created_at','<=','12');
          $cc_200_f->whereYear('incidences.created_at','=',$valor)->whereMonth('incidences.created_at','>=','07')->whereMonth('incidences.created_at','<=','12');
          
      }elseif($tipo_reporte=='mes'){
        
            $arreglo = (explode("-",$valor));
            $año=$arreglo[0];
            $mes=$arreglo[1];
            Session::flash('tipo','MENSUAL');
            Session::flash('fecha',$año.'-'.$mes);

            $diurna->whereYear('created_at', '=',$año)->whereMonth('created_at','=',$mes);
            $nocturna->whereYear('created_at', '=', $año)->whereMonth('created_at','=',$mes);
            $id_devices=incidence::whereYear('created_at', '=', $año)->whereMonth('created_at','=',$mes)->pluck('id_device');
            $count_incidences=incidence::whereYear('created_at', '=', $año)->whereMonth('created_at','=',$mes)->count();
            $etario_f->whereYear('incidences.created_at', '=',$año)->whereMonth('incidences.created_at','=',$mes);
            $etario_m->whereYear('incidences.created_at', '=',$año)->whereMonth('incidences.created_at','=',$mes);
            $cc_100_m->whereYear('incidences.created_at','=',$año)->whereMonth('incidences.created_at','=',$mes);
            $cc_100_f->whereYear('incidences.created_at','=',$año)->whereMonth('incidences.created_at','=',$mes);
            $cc_125_m->whereYear('incidences.created_at','=',$año)->whereMonth('incidences.created_at','=',$mes);
            $cc_125_f->whereYear('incidences.created_at','=',$año)->whereMonth('incidences.created_at','=',$mes);
            $cc_150_m->whereYear('incidences.created_at','=',$año)->whereMonth('incidences.created_at','=',$mes);
            $cc_150_f->whereYear('incidences.created_at','=',$año)->whereMonth('incidences.created_at','=',$mes);
            $cc_200_m->whereYear('incidences.created_at','=',$año)->whereMonth('incidences.created_at','=',$mes);
            $cc_200_f->whereYear('incidences.created_at','=',$año)->whereMonth('incidences.created_at','=',$mes);

      }else{
        return redirect()->back()->with('e-report', 'Hubo un error, intentalo mas tarde');
      }
      $diurna=$diurna->get();
      $nocturna=$nocturna->get();
      $etario_f=$etario_f->get();
      $etario_m=$etario_m->get();

      $cc_100_m=$cc_100_m->count();
      $cc_100_f=$cc_100_f->count();

      $cc_125_m=$cc_125_m->count();
      $cc_125_f=$cc_125_f->count();

      $cc_150_m=$cc_150_m->count();
      $cc_150_f=$cc_150_f->count();

      $cc_200_m=$cc_200_m->count();
      $cc_200_f=$cc_200_f->count();
      


        //JORNADA DIURNA
        $h6_h9_m=array();
        $h6_h9_f=array();
        $h9_h12_m=array();
        $h9_h12_f=array();
        $h12_h15_m=array();
        $h12_h15_f=array();
        $h15_h18_m=array();
        $h15_h18_f=array();
        $h18_h21_m=array();
        $h18_h21_f=array();

        $avg_6_9_m=0;
        $avg_6_9_f=0;
        $avg_9_12_m=0;
        $avg_9_12_f=0;
        $avg_12_15_m=0;
        $avg_12_15_f=0;
        $avg_15_18_m=0;
        $avg_15_18_f=0;
        $avg_18_21_m=0;
        $avg_18_21_f=0;


        //JORNADA NOCTURNA
        $h21_h24_m=array();
        $h21_h24_f=array();
        $h24_h3_m=array();
        $h24_h3_f=array();
        $h3_h6_m=array();
        $h3_h6_f=array();

        $avg_21_24_m=0;
        $avg_21_24_f=0;
        $avg_24_3_m=0;
        $avg_24_3_f=0;
        $avg_3_6_m=0;
        $avg_3_6_f=0;

        //TIPO DE FRENOS
         $abs=0;
         $cbs=0;
         $cbs_abs=0;
         $tambor=0;

         $avg_abs=0;
         $avg_cbs=0;
         $avg_cbs_abs=0;
         $avg_tambor=0;

         $label_freno=array();
         $array_freno=array();

         //Grupo Etario
         $num_18_24_m=0;
         $num_25_30_m=0;
         $num_31_40_m=0;
         $num_41_50_m=0;
         $num_51_60_m=0;
         $num_61_m=0;

         $num_18_24_f=0;
         $num_25_30_f=0;
         $num_31_40_f=0;
         $num_41_50_f=0;
         $num_51_60_f=0;
         $num_61_f=0;

         if(isset($etario_m)){
            foreach($etario_m as $etm){
              
              $fecha_nac = Carbon::createFromFormat('Y-m-d', $etm['date_of_birth']);
              $fecha_act = Carbon::createFromFormat('Y-m-d', $date);
          
              $diff = $fecha_act->diffInYears($fecha_nac); 
              if($diff>=18 && $diff<=24){
                $num_18_24_m=$num_18_24_m+1;

              }elseif($diff>=25 && $diff<=30){
                $num_25_30_m=$num_25_30_m+1;

              }elseif($diff>=31 && $diff<=40){
                $num_31_40_m=$num_31_40_m+1;

              }elseif($diff>=41 && $diff<=50){
                $num_41_50_m=$num_41_50_m+1;

              }elseif($diff>=51 && $diff<=60){
                $num_51_60_m=$num_51_60_m+1;

              }elseif($diff>=61){
                $num_61_m=$num_61_m+1;

              }
            }
         }else{
           
         }

         if(isset($etario_f)){
          foreach($etario_f as $etf){
            
            $fecha_nac = Carbon::createFromFormat('Y-m-d', $etf['date_of_birth']);
            $fecha_act = Carbon::createFromFormat('Y-m-d', $date);
        
            $diff = $fecha_act->diffInYears($fecha_nac); 
            if($diff>=18 && $diff<=24){
              $num_18_24_f=$num_18_24_f+1;

            }elseif($diff>=25 && $diff<=30){
              $num_25_30_f=$num_25_30_f+1;

            }elseif($diff>=31 && $diff<=40){
              $num_31_40_f=$num_31_40_f+1;

            }elseif($diff>=41 && $diff<=50){
              $num_41_50_f=$num_41_50_f+1;

            }elseif($diff>=51 && $diff<=60){
              $num_51_60_f=$num_51_60_f+1;

            }elseif($diff>=61){
              $num_61_f=$num_61_f+1;

            }
          }
       }else{
         
       }



      //VALIDACIONES 
      if(isset($diurna)){

        foreach($diurna as $reg){
          
          $hora = date('H:i:s',strtotime($reg->created_at));
        
          if(Driver::findOrFail($reg->id_driver)->user['gender']=='m' && $hora>='06:00:00' && $hora<'09:00:00'){
            array_push($h6_h9_m,$reg->speed);  
          }elseif(Driver::findOrFail($reg->id_driver)->user['gender']=='f' && $hora>='06:00:00' && $hora<'09:00:00'){
            array_push($h6_h9_f,$reg->speed); 
          }

          if(Driver::findOrFail($reg->id_driver)->user['gender']=='m' && $hora>='09:00:00' && $hora<'12:00:00'){
            array_push($h9_h12_m,$reg->speed);  
          }elseif(Driver::findOrFail($reg->id_driver)->user['gender']=='f' && $hora>='09:00:00' && $hora<'12:00:00'){
            array_push($h9_h12_f,$reg->speed); 
          }

          if(Driver::findOrFail($reg->id_driver)->user['gender']=='m' && $hora>='12:00:00' && $hora<'15:00:00'){
            array_push($h12_h15_m,$reg->speed);  
          }elseif(Driver::findOrFail($reg->id_driver)->user['gender']=='f' && $hora>='12:00:00' && $hora<'15:00:00'){
            array_push($h12_h15_f,$reg->speed); 
          }

          if(Driver::findOrFail($reg->id_driver)->user['gender']=='m' && $hora>='15:00:00' && $hora<'18:00:00'){
            array_push($h15_h18_m,$reg->speed);  
          }elseif(Driver::findOrFail($reg->id_driver)->user['gender']=='f' && $hora>='15:00:00' && $hora<'18:00:00'){
            array_push($h15_h18_f,$reg->speed); 
          }

          if(Driver::findOrFail($reg->id_driver)->user['gender']=='m' && $hora>='18:00:00' && $hora<'21:00:00'){
            array_push($h18_h21_m,$reg->speed);  
          }elseif(Driver::findOrFail($reg->id_driver)->user['gender']=='f' && $hora>='18:00:00' && $hora<'21:00:00'){
            array_push($h18_h21_f,$reg->speed); 
          }
          
        }
        }
        
        if(isset($nocturna)){

          foreach($nocturna as $reg){
            
            $hora = date('H:i:s',strtotime($reg->created_at));
          
            if(Driver::findOrFail($reg->id_driver)->user['gender']=='m' && $hora>='21:00:00' && $hora<'24:00:00'){
              array_push($h21_h24_m,$reg->speed);  
            }elseif(Driver::findOrFail($reg->id_driver)->user['gender']=='f' && $hora>='21:00:00' && $hora<'24:00:00'){
              array_push($h21_h24_f,$reg->speed); 
            }
  
            if(Driver::findOrFail($reg->id_driver)->user['gender']=='m' && $hora>='00:00:00' && $hora<'03:00:00'){
              array_push($h24_h3_m,$reg->speed);  
            }elseif(Driver::findOrFail($reg->id_driver)->user['gender']=='f' && $hora>='00:00:00' && $hora<'03:00:00'){
              array_push($h24_h3_f,$reg->speed); 
            }
  
            if(Driver::findOrFail($reg->id_driver)->user['gender']=='m' && $hora>='03:00:00' && $hora<'06:00:00'){
              array_push($h3_h6_m,$reg->speed);  
            }elseif(Driver::findOrFail($reg->id_driver)->user['gender']=='f' && $hora>='03:00:00' && $hora<'06:00:00'){
              array_push($h3_h6_f,$reg->speed); 
            }      
          }
        }


        if(array_sum($h6_h9_m)>0){
          $avg_6_9_m=array_sum($h6_h9_m)/count($h6_h9_m);
        }
        if(array_sum($h6_h9_f)>0){
          $avg_6_9_f=array_sum($h6_h9_f)/count($h6_h9_f);
        }
        if(array_sum($h9_h12_m)>0){
          $avg_9_12_m=array_sum($h9_h12_m)/count($h9_h12_m);
        }
        if(array_sum($h9_h12_f)>0){
          $avg_9_12_f=array_sum($h9_h12_f)/count($h9_h12_f);
        }

        if(array_sum($h12_h15_m)>0){
          $avg_12_15_m=array_sum($h12_h15_m)/count($h12_h15_m);
        }
        if(array_sum($h12_h15_f)>0){
          $avg_12_15_f=array_sum($h12_h15_f)/count($h12_h15_f);
        }

        if(array_sum($h15_h18_m)>0){
          $avg_15_18_m=array_sum($h15_h18_m)/count($h15_h18_m);
        }
        if(array_sum($h15_h18_f)>0){
          $avg_15_18_f=array_sum($h15_h18_f)/count($h15_h18_f);
        }

        if(array_sum($h18_h21_m)>0){
          $avg_18_21_m=array_sum($h18_h21_m)/count($h18_h21_m);
        }
        if(array_sum($h18_h21_f)>0){
          $avg_18_21_f=array_sum($h18_h21_f)/count($h18_h21_f);
        }

        //nocturna
        if(array_sum($h21_h24_m)>0){
          $avg_21_24_m=array_sum($h21_h24_m)/count($h21_h24_m);
        }
        if(array_sum($h21_h24_f)>0){
          $avg_21_24_f=array_sum($h21_h24_f)/count($h21_h24_f);
        }

        if(array_sum($h24_h3_m)>0){
          $avg_24_3_m=array_sum($h24_h3_m)/count($h24_h3_m);
        }
        if(array_sum($h24_h3_f)>0){
          $avg_24_3_f=array_sum($h24_h3_f)/count($h24_h3_f);
        }

        if(array_sum($h3_h6_m)>0){
          $avg_3_6_m=array_sum($h3_h6_m)/count($h3_h6_m);
        }
        if(array_sum($h3_h6_f)>0){
          $avg_3_6_f=array_sum($h3_h6_f)/count($h3_h6_f);
        }


        //TIPOS DE FRENO
        if(isset($id_devices)){
          foreach($id_devices as $id_d){
            $device=Device::select('type_brake')->where('id',$id_d)->first();
            $type_brake=$device->type_brake;
            
            if($type_brake=='Abs'){
                $abs=$abs+1;
            }elseif($type_brake=='Cbs'){
                $cbs=$cbs+1;
            }elseif($type_brake=='Tambor'){
                $tambor=$tambor+1;
            }elseif($type_brake=='Abs-Cbs'){
                $cbs_abs=$cbs_abs+1;
            }else{
              
            }
          }
        }
        

        if($abs>0){
            $avg_abs=intval(($abs*100)/$count_incidences);
            array_push($label_freno,"ABS");
            array_push($array_freno,$avg_abs);
        }
        if($cbs>0){
            $avg_cbs=intval(($cbs*100)/$count_incidences);
            array_push($label_freno,"CBS");
            array_push($array_freno,$avg_cbs);
        }
        if($tambor>0){
          $avg_tambor=intval(($tambor*100)/$count_incidences);
          array_push($label_freno,"TAMBOR");
          array_push($array_freno,$avg_tambor);
        }
        if($cbs_abs>0){
          $avg_cbs_abs=intval(($cbs_abs*100)/$count_incidences);
          array_push($label_freno,"CBS-ABS");
          array_push($array_freno,$avg_cbs_abs);
        }



      //GRAFICAS
      $provelo_diurna='{
        type: "line",
        data: {
          labels: ["6H-9H", "9H-12H", "12H-15H", "15H-18H","18H-21H"],
          datasets: [
            {
              label: "Hombres",
              backgroundColor: "rgb(255, 99, 132)",
              borderColor: "rgb(255, 99, 132)",
              fill: false,
              data: ['.$avg_6_9_m.','.$avg_9_12_m.','.$avg_12_15_m.','.$avg_15_18_m.','.$avg_18_21_m.'],
            },   {
              label: "Mujeres",
              backgroundColor: "rgb(54, 162, 235)",
              borderColor: "rgb(54, 162, 235)",
              fill: false,
              data: ['.$avg_6_9_f.','.$avg_9_12_f.','.$avg_12_15_f.','.$avg_15_18_f.','.$avg_18_21_f.'],
            },
          ],
        },
        options: {
          responsive: true,
          title: {
            display: true,
            text: "Velocidad Promedio en Jornada Diurna",
          },
         
        }
   
      }'; 

    $provelo_nocturna=' {
      type: "line",
      data: {
        labels: ["21H-24H", "24H-3H", "3H-6H"],
        datasets: [
          {
            label: "Hombres",
            backgroundColor: "rgb(255, 99, 132)",
            borderColor: "rgb(255, 99, 132)",
            fill: false,
            data: ['.$avg_21_24_m.','.$avg_24_3_m.','.$avg_3_6_m.'],
          },  {
            label: "Mujeres",
            backgroundColor: "rgb(54, 162, 235)",
            borderColor: "rgb(54, 162, 235)",
            fill: false,
            data: ['.$avg_21_24_f.','.$avg_24_3_f.','.$avg_3_6_f.'],
          },
        ],
      },
      options: {
        responsive: true,
        title: {
          display: true,
          text: "Velocidad Promedio en Jornada Nocturna",
        },
        "yAxes": [{
          "scaleLabel": {
            "display": true,
            "labelString": "valu4e"
          }
        }]
      }
 
    }'; 
  
    
    $tipo_freno='
  {
    type: "pie",
    data: {
      labels: ["'.implode('","',$label_freno).'"],
      datasets: [{
        data: ['.implode(',',$array_freno).']
      }]
    }
  }
  '; 

$grupoEdadyFalta="{
  type: 'bar',
  data: {
    labels: ['faltas'],
    datasets: [{
      label: 'Hombres',
      data: [50]
    }, {
      label: 'Mujeres',
      data: [100]
    }]
  }
}"; 

$generoyFalta="{
  type: 'bar',
  data: {
    labels: ['Q1', 'Q2', 'Q3', 'Q4','q5','q6','q7','q8','q9'],
    datasets: [{
      label: 'Hombres',
      data: [50, 60, 70, 180,200,100,50,90]
    }, {
      label: 'Mujeres',
      data: [100, 200, 300, 400,500,250,260,120]
    }]
  }
}"; 
$cilindrajeyFalta="{
  type: 'bar',
  data: {
    labels: ['100-124', '125-149', '150-200', '>200'],
    datasets: [{
      label: 'Hombres',
      data: [".$cc_100_m.", ".$cc_125_m.",".$cc_150_m.",".$cc_200_m."]
    }, {
      label: 'Mujeres',
      data: [".$cc_100_f.", ".$cc_125_f.",".$cc_150_f.",".$cc_200_f."]
    }]
  }
}";
$grupoEdadyFalta="{
  type: 'bar',
  data: {
    labels: ['18 -24', '25 - 30', '31 -40', '41 - 50','51 - 60','>60'],
    datasets: [{
      label: 'Hombres',
      data: [".$num_18_24_m.",".$num_25_30_m.",".$num_31_40_m.",".$num_41_50_m.",".$num_51_60_m.",".$num_61_m."]
    }, {
      label: 'Mujeres',
      data: [".$num_18_24_f.",".$num_25_30_f.",".$num_31_40_f.",".$num_41_50_f.",".$num_51_60_f.",".$num_61_f."]
    }]
  }
}"; 

      $nombre="Mister Pollo";

        $pdf = PDF::loadView('PdfReportAdmin',['count_incidences'=>$count_incidences,'provelo_diurna' => $provelo_diurna,'provelo_nocturna' => $provelo_nocturna,'tipo_freno'=>$tipo_freno,'grupoEdadyFalta'=>$grupoEdadyFalta, 'generoyFalta'=>$generoyFalta,'cilindrajeyFalta'=>$cilindrajeyFalta]);

        return $pdf->stream('reporte.pdf');
    }
}
