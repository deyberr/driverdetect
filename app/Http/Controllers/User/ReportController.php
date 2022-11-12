<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\incidence;

class ReportController extends Controller
{
    public function index()
    {
        $incidencias=incidence::all();
        return view('user.reports.index');
    }
    public function filterReport(Request $request)
    {   
        if($request->input('radio')=='r_mes'){
            
            $arreglo = (explode("-",$request->input('mes')));
            $año=$arreglo[0];
            $mes=$arreglo[1];
           
            $incidencias=incidence::whereYear('created_at', $año)
                            ->whereMonth('created_at', $mes)
                            ->get();
            return view('user.reports.index',compact('incidencias'));
        }
        elseif($request->input('radio')=='r_semestre'){
            $opcion=$request->input('semestre');
            $año=$request->input('año');
            if($opcion=='inicial'){
                    $incidencias=incidence::whereYear('created_at', $año)
                        ->whereMonth('created_at','>=' , '01')
                        ->whereMonth('created_at','<=', '06')
                        ->get();

                    return view('user.reports.index',compact('incidencias'));

            }elseif($opcion=='final'){
                    $incidencias=incidence::whereYear('created_at', $año)
                        ->whereMonth('created_at','>=' , '07')
                        ->whereMonth('created_at','<=', '12')
                        ->get();

                    return view('user.reports.index',compact('incidencias'));
            }else{
                return redirect()->back();
            }
        }
        elseif($request->input('radio')=='r_año'){
            $año=$request->input('año');
            $incidencias=incidence::whereYear('created_at', $año)->get();
            return view('user.reports.index',compact('incidencias'));
        }
        else{
            return redirect()->back();
        }
        
    }
}
