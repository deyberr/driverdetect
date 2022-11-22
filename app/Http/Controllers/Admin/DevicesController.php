<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Driver;
use App\Models\Speed;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreDevicesRequest;
use Illuminate\Support\Str;
use App\Models\incidence;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $incidencias=incidence::all();
       

        $devices=DB::table('devices')->paginate(12);
        $users=User::where('role','user')->pluck('name','id');

        return view('admin.reports.index',compact('devices','users','incidencias'));
        return view('admin.devices.index',compact('devices','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function searchDevice(Request $request)
    {

        $device_find=$request->search__device;
        if($device_find==''){
            return redirect()->back();
        }

        $devices=Device::where('reference','LIKE','%'.$device_find.'%')->paginate(12);
        $users=User::where('role','user')->pluck('name','id');

        return view('admin.devices.index',compact('users','devices'));

    }
    public function filterDevice($filter)
    {
        $valor=$filter;
        $users=User::where('role','user')->pluck('name','id');

        if($valor=='active'){
            $devices=Device::where('status',1)->paginate(12);
            return view('admin.devices.index',compact('users','devices'));
        }elseif($valor=='inactive'){
            $devices=Device::where('status',2)->paginate(12);
            return view('admin.devices.index',compact('users','devices'));
        }elseif($valor=='repose'){
            $devices=Device::where('status',0)->paginate(12);
            return view('admin.devices.index',compact('users','devices'));
        }else{
            return redirect()->back();
        }

    }

    public function speedsDevice(Request $request, $id)
    {

        if($request->ajax()){

            $driver=Driver::select('id_device')->where('id','=',$id)->get();
            $id_device=$driver[0]->id_device;
            $device=Device::findOrFail($id_device);

            //si esta en reposo devuelve 0km/h
            if($device->status==0){
                return response()->json([
                    'success' => 0
                ]);

            //si esta  activo  consulta  el ultimo registro
            }elseif($device->status==1){

                $speed=Speed::latest()->take(1)->where('id_device','=',$id_device)->select('value')->get();
                if(count($speed)>0){
                    $value=$speed;
                }else{
                    $value=0;
                }

                return response()->json([
                        'success' => $value
                ]);

            }else{
                return response()->json([
                    'error' => 'ocurrio un error'
            ]);
            }

        }


    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { //return  $request;
        $device= new Device();
        $device->key=(string) Str::uuid();
        $device->model=$request->input('año');
        $device->displacement=$request->input('cilindraje_c');
        $device->licence_plate=$request->input('placa_c');
        $device->reference=$request->input('referencia_c');
        $device->type_brake=$request->input('freno_c');
        $device->status="0";
        $device->save();
        $driver=new driver();
        $driver->id_user=$request->input('id_driver');
        $driver->id_device=$device->id;
        $driver->save();
        return back()->with('message', 'dispositivo agregado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'sisa';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $d=Device::FindOrFail($id);
        $users=User::where('role','user')->pluck('name','id');
        $id_user=Driver::where('id_device',$id)->pluck('id_user')->first();

        return view('admin.devices.edit',compact('d','users','id_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDevicesRequest $request, $id)
    {

            $d=Device::findOrFail($id);
            $driver=Driver::where('id_device',$id)->get()->first();
            if($driver){
                $driver->id_user=$request->input('id_driver');
                $driver->update();
            }
            $d->reference=$request->input('reference');
            $d->displacement=$request->input('displacement');
            $d->type_brake=$request->input('type_brake');
            $d->licence_plate=$request->input('licence_plate');
            $d->model=$request->input('model');
            $d->update();

            return redirect()->route('devices.index')->with('message','El dispositivo se actualizo correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(Device::findOrFail($id)->delete($id)){
            return response()->json(['success'=>'se elimino']);
        }


    }
}
