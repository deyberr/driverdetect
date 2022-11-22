 
@extends('admin.layouts.master')

@section('title')
    @lang('translation.Map') 
@endsection

@section('css')
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.0/mapbox-gl.css" rel="stylesheet">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet">
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Map @endslot
        @slot('title') Map @endslot
    @endcomponent

<style>
    #map{
        width:100%;
        height:550px;
    }
    .marker-distance{
        font-size:25px;
        color:blue;
    }
    .marker-velocity{
        font-size:25px;
        color:green;
    }
    .info-velocity{
        color:green;
        font-size:35px;
    }
    .info-distance{
        color:blue;
        font-size:35px;
    }

    .tabcontent {
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }
</style>

    <h3>Georeferenciacion de imprudencias</h3>
    <hr>

    <div class="description mt-2">
        <p>Mapa de la ciudad de San Juan de Pasto donde se encuentran registrados todos
           las imprudencias de los motociclistas registrados en el sistema, cada incidente
           esta representado por medio de un marcador especifico que cuenta con informacion
           precisa.
        </p>
    </div>

    <p class="mt-3 text-center w-100">Tipos de marcadores</p>
    <div class="markers mt-3 mb-3 d-flex justify-content-center gap-2">
    
      <div class="card w-25 markers__info">
            <i class="fas fa-map-marker-alt m-auto info-velocity"></i>
            <div class="markers__content m-auto">
                <p><small>Distancia de seguridad</small></p>
            </div>
      </div>
      <div class="card w-25 markers__info ">
            <i class="fas fa-map-marker-alt m-auto info-distance"></i>
            <div class="markers__content m-auto">
                <p><small>Exceso de velocidad</small></p>
            </div>
      </div>  
        
    </div>
    
    <div id="faltas" class="tabcontent" style="width:100%; height:550px; " >
      <div id="map">
 
      </div>
  
    </div>    

@endsection
@section('script')
<script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>
<script src="{{ URL::asset('/assets/libs/echarts/echarts.min.js') }}"></script>
<script>

mapboxgl.accessToken = 'pk.eyJ1IjoiZGV5YmVyMTk5OSIsImEiOiJja3Z5aDVoczE5enF3Mm5xMW96bnNhZnp4In0.vFKnY9XndL8Ks2ioZwpPtA';
let app = {{  Illuminate\Support\Js::from($coordenadas) }};
app = JSON.parse(app);


app.coordinates.forEach(element => {

    let text;
    if (element.type== '0') {

        text=element.proximity+' metros a '+element.speed+' km/h';
        
    }else{
    
        text=element.speed+' km/h';

    }
    element.text = text;
   
});



let centergp=[-77.2811100, 1.2136100];
const map = new mapboxgl.Map({
          container: 'map', 
          style: 'mapbox://styles/mapbox/streets-v11', 
          center: centergp, 
          zoom: 14 
});

var nav = new mapboxgl.NavigationControl();
map.addControl(nav,"top-left");






app.coordinates.forEach(marker=>{

    const markerVel=document.createElement('i');
    markerVel.classList.add("marker-velocity", "fas", "fa-map-marker-alt")

    const markerDis=document.createElement('i');
    markerDis.classList.add("marker-distance", "fas", "fa-map-marker-alt")

    new mapboxgl.Marker((marker.type=='0')?markerVel:markerDis).setLngLat({
    lng:marker.lon,
    lat:marker.lat
    }).setPopup(
        new mapboxgl.Popup({ offset: 25 }) // add popups
        .setHTML(
           marker.text
        )
    ).
    addTo(map);
})
// new mapboxgl.Marker(marker2).setLngLat({
//     lng:-77.2851100,
//     lat:1.2136100
// }).setPopup(
//     new mapboxgl.Popup({ offset: 25 }) // add popups
//       .setHTML(
//         `<h5>Bajab brf - 05:14 pm</h5><p> 5 metros de distancia a 70 km/h</p>`
//       )
//   ).
// addTo(map);

// new mapboxgl.Marker(markerDis).setLngLat({
//     lng:-77.2711100,
//     lat:1.2136100
// }).setPopup(
//     new mapboxgl.Popup({ offset: 25 }) // add popups
//       .setHTML(
//         `<h5>Yamaha rx - 12:14 pm</h5><p> 3 metros de distancia a 30 km/h</p>`
//       )
//   ).
// addTo(map);

// new mapboxgl.Marker(marker).setLngLat({
//     lng:-77.2751100,
//     lat:1.2136100
// }).setPopup(
//     new mapboxgl.Popup({ offset: 25 }) // add popups
//       .setHTML(
//         `<h5>Honda cbr - 02:30 am </h5><p>60 km/h</p>`
//       )
//   ).
// addTo(map);

</script>

@endsection