<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Boletin</title>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    <style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Roboto:500,700');
  
      .titulo{
        font-size:38px;
        color:#4A2658;
        text-align:center;
        font-weight:bold;
      }
      .subtitulo{
        font-size:23px;
        color:#353335;
        font-weight:800;
      }
      .fecha{
        font-size:28px;
        color:#4A2658;
        font-weight:BOLD;
        text-align:center;
        
      }
      .img-wallpaper{
        width: 100%;
        height: 390px;
        margin-top:30px;
        object-fit:cover;
      }
      .img-logo-app{
        width: 120px;
        height: 80px;
        object-fit:cover;
        position:absolute;
        right:15px;
        top:-25px;
      }
      .img-chart{
        width: 700px;
        height: 280px;
      }
      
      .container_header{
        position: relative;
      }
      .text-chart{
        margin:20px 0px;
        font-size:17px;
      }
      .img-chart-circle{
        width: 700px;
        height: 300px;
      }
    </style>
  </head>
  
  <body>
    <div class="container_header">
      <p class="subtitulo text-app">DRIVER DETECT</p>
      <img src="{{ public_path('assets/images/logo-system.png') }}" alt="logo" class="img-logo-app">
    </div>
    
    <p class="titulo" style="width:100%"><span>BOLETIN INFORMATIVO {{Session::get('tipo')}}</span></p>
    <p class="fecha" style="width:100%">{{Session::get('fecha')}}</p>
    
    <p><img alt="Imagen de portada" src="{{ public_path('/images/reports/wallpaper-pdfreport.jpg') }}" class="img-wallpaper" title=""></p>
    
    <p style="margin-top:20px;font-size:18px">
        El Presente boletin fue generado con los registros generados entre la fecha de {{Session::get('fecha')}}, en el cual se presenta
        registradas <strong>{{$count_incidences}} </strong>imprudencias de motociclistas en la ciudad de Pasto-Colombia  
    </p>

    <p style="margin-top:30px"><span style="font-size:17px">Fecha de Publicacion {{ \Carbon\Carbon::now()->locale('es')->format('Y-m-d') }}</span></p>
    <hr>
    
    <p class="subtitulo" style="margin-top:200px">Velocidad Promedio en Jornada Diurna</p>
    <p class="text-chart">En la siguiente grafica se especifica la velocidad promedio registrada entre las cero y seis horas de la madrugada,
      se encuentra categorizada por hombres y mujeres
    </p>
    <p><img alt="grafica reporte" src="https://quickchart.io/chart?width=700&height=280&c={{$provelo_diurna}}" class="img-chart"></p>
      

    <p class="subtitulo">Velocidad Promedio en Jornada Nocturna</p>
    <p class="text-chart">En la siguiente grafica se especifica la velocidad promedio registrada entre las siete y once horas de la mañana,
      se encuentra categorizada por hombres y mujeres
    </p>
    <p><img alt="grafica reporte" src="https://quickchart.io/chart?width=700&height=280&c={{$provelo_nocturna}}" class="img-chart"></p>
      
      
           
    <p class="subtitulo" style="margin-top:200px">Imprudencias segun el tipo de freno</p>
    <p class="text-chart">En la siguiente grafica se especifica las imprudencias generadas segun el tipo de freno implementado en 
      las motocicletas, los valores que se especifican estan representados en porcentajes 
    </p>
    <p><img alt="grafica reporte" src="https://quickchart.io/chart?width=700&height=300&c={{$tipo_freno}}" class="img-chart-circle"></p>
            

           

    <p class="subtitulo">Grupo etario &nbsp;con respecto a imprudencias generadas</p>
    <p class="text-chart">En la siguiente grafica se especifica la relacion que existe entre el grupo etario
      y la cantidad de imprudencias cometidas por los motociclistas
    </p>
    <p><img alt="grafica reporte" src="https://quickchart.io/chart?width=700&height=280&c={{$grupoEdadyFalta}}" class="img-chart"></p>
          
       
    <p class="subtitulo" style="margin-top:200px">Relaci&oacute;n &nbsp;entre imprudencias y cilindraje</p>
    <p class="text-chart">En la siguiente grafica se especifica la relacion que existe entre el cilindraje de las motocicletas
      y la cantidad de imprudencias cometidas, tambien se encuentra categorizada la cantidad de hombres y mujeres
    </p>
    <p><img alt="grafica reporte" src="https://quickchart.io/chart?width=700&height=280&c={{$cilindrajeyFalta}}" class="img-chart"></p>
                   
    <hr style="margin-top:550px">
                
    <p class="c7"><span>&copy; Driver Detect</span></p>
                          
  </body>
  
  </html>