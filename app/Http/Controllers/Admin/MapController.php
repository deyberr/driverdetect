<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\incidence;
class MapController extends Controller
{
    public function index()
    {  // $coordenadas=incidence::pluck('lat', 'lon')->toJson(); 
        $original_json_string=incidence::all()->toJson(); 
        $original_data = json_decode($original_json_string, true);
        $coordinates = array();
        foreach($original_data as $key => $value) {
            $coordinates[] = array('lat' => $value['lat'], 'lon' => $value['lon']);
        }
        $new_data = array(
            'type' => 'FeatureCollection',
            'features' => array(
                'type' => 'Feature',
                'geometry' => array('type' => 'Point', 'coordinates' => $coordinates),
                'properties' => array('name' => 'value'),
            ),
        );
        
        $final_data = json_encode($new_data, true);
        
      

        return view('admin.map.index', ['coordenadas'=>$final_data]);
    }
}
