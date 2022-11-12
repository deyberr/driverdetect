@extends('admin.layouts.master')

@section('title') 
@lang('translation.Dashboard') 
@endsection

@section('css')
   
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
@endsection
@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboards @endslot
        @slot('title') Dashboard @endslot
    @endcomponent

    <style>
        .idevice{
          font-size:20px;
        }
        .itotal{
          color:gray;
        }
        .iconectado{
          color:green;
        }
        .idesconectado{
          color:red;
        }
        
    </style>
    <div class="row">
        <div class="col-12 col-lg-4">
           <div class="card p-3" style="height:80px;">
               <span class="d-flex justify-content-between">
                  <h5 class="text-muted">Dispositivos totaless</h5>
                  <h4 class="text-muted">{{$d_totales}}</h4>
               </span>
               <div>
                <i class="bx bx-chip idevice itotal"></i>
               </div>
           </div>
        </div>

         <div class="col-12 col-lg-4">
           <div class="card p-3" style="height:80px;">
               <span class="d-flex justify-content-between">
                  <h5 class="text-muted">Dispositivos activos</h5>
                  <h4 class="text-muted">{{$d_activos}}</h4>
               </span>
               <div>
                <i class="bx bx-power-off idevice iconectado"></i>
               </div>
           </div>
        </div>

        <div class="col-12 col-lg-4">
           <div class="card p-3" style="height:80px;">
               <span class="d-flex justify-content-between">
                  <h5 class="text-muted">Dispositivos en reposo</h5>
                  <h4 class="text-muted">{{$d_reposo}}</h4>
               </span>
               <div>
                <i class="bx bx-power-off idevice idesconectado"></i>
               </div>
           </div>
        </div>


    <div class="row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Registro estadistico</h4>
                    <div id="mix-line-bar" class="e-charts w-100"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Promedio de velocidad KM/H</h4>
                    <div id="gauge-chart" class="e-charts w-100"></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- end row -->

    <div class="row">
       <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Genero de conductores</h4>
                    <div id="pie-chart" style="height:300px;width:90%"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Proximidad</h4>
                    <div id="proximidad-driver" style="height:300px;width:90%"></div>
                </div>
                <span class="text-muted">Incidencias correspondientes a no mantener distancia de seguridad entre vehiculos</span>
            </div>
        </div>
        
    </div>

</div>
    

@endsection
@section('script')


    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/echarts/echarts.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>

    <script src="{{ URL::asset('/assets/js/utils/socket.js') }}"></script>

<script>


<?php
       echo "const hombres ='$hombres';";
       echo "const mujeres ='$mujeres';";
       echo "const month0 ='$month0';";
       echo "const month1 ='$month1';";
       echo "const month2 ='$month2';";
       echo "const month3 ='$month3';";
       echo "const month4 ='$month4';";
       echo "const month5 ='$month5';";

       echo "const value0 ='$value0';";
       echo "const value1 ='$value1';";
       echo "const value2 ='$value2';";
       echo "const value3 ='$value3';";
       echo "const value4 ='$value4';";
       echo "const value5 ='$value5';";

       echo "const impru0 ='$impru0';";
       echo "const impru1 ='$impru1';";
       echo "const impru2 ='$impru2';";
       echo "const impru3 ='$impru3';";
       echo "const impru4 ='$impru4';";
       echo "const impru5 ='$impru5';";
       

?>
const km_20_40=@json($km_20_40);
const km_40_60=@json($km_40_60);
const km_60_80=@json($km_60_80);
const km_80_100=@json($km_80_100);


//Genero pie-char
var dom = document.getElementById("pie-chart");
var myChart = echarts.init(dom);
var app = {};
option = null;
option = {
  tooltip: {
    trigger: 'item',
    formatter: "{a} <br/>{b} : {c} ({d}%)"
  },
  legend: {
    orient: 'vertical',
    left: 'left',
    data: ['Hombre', 'Mujer'],
    textStyle: {
      color: '#8791af'
    }
  },
  color: ['#f46a6a', '#34c38f', '#50a5f1', '#f1b44c', '#556ee6'],
  series: [{
    name: 'Total',
    type: 'pie',
    radius: '55%',
    center: ['50%', '60%'],
    data: [{
      value: hombres,
      name: 'Hombre'
    }, {
      value: mujeres,
      name: 'Mujer'
    }],
    itemStyle: {
      emphasis: {
        shadowBlur: 10,
        shadowOffsetX: 0,
        shadowColor: 'rgba(0, 0, 0, 0.5)'
      }
    }
  }]
};
;

//if (option && (typeof option === "undefined" ? "undefined" : _typeof(option)) === "object") {
  option && myChart.setOption(option, true);
//} 

//GRAFICAS ESTADISTICAS PANEL PRINCIPAL
var token = $('meta[name="csrf-token"]').attr('content'); // mix line & bar

const element = document.getElementById("mix-line-bar");
const general = echarts.init(element);
const appp = {};
opcion = null;
appp.title = 'Data view';
opcion = {
  // Setup grid
  grid: {
    zlevel: 0,
    x: 80,
    x2: 50,
    y: 30,
    y2: 30,
    borderWidth: 0,
    backgroundColor: 'rgba(0,0,0,0)',
    borderColor: 'rgba(0,0,0,0)'
  },
  tooltip: {
    trigger: 'axis',
    axisPointer: {
      type: 'cross',
      crossStyle: {
        color: '#999'
      }
    }
  },
  toolbox: {
    orient: 'center',
    left: 0,
    top: 20,
    feature: {
      dataView: {
        readOnly: false,
        title: "Data View"
      },
      magicType: {
        type: ['line', 'bar'],
        title: {
          line: "For line chart",
          bar: "For bar chart"
        }
      },
      restore: {
        title: "restore"
      },
      saveAsImage: {
        title: "Download Image"
      }
    }
  },
  color: ['#34c38f', '#556ee6', '#f46a6a'],
  legend: {
    data: ['Velocidad', 'Infracciones'],
    textStyle: {
      color: '#8791af'
    }
  },
  xAxis: [{
    type: 'category',
    data: [month5,month4,month3,month2,month1,month0],
    axisPointer: {
      type: 'shadow'
    },
    axisLine: {
      lineStyle: {
        color: '#8791af'
      }
    }
  }],
  yAxis: [{
    type: 'value',
    name: 'Km/h',
    min: 0,
    max: 250,
    interval: 50,
    axisLine: {
      lineStyle: {
        color: '#8791af'
      }
    },
    splitLine: {
      lineStyle: {
        color: "rgba(166, 176, 207, 0.1)"
      }
    },
    axisLabel: {
      formatter: '{value} km/h'
    }
  }, {
    type: 'value',
    name: 'Infracciones',
    min: 0,
    max: 200,
    interval: 20,
    axisLine: {
      lineStyle: {
        color: '#8791af'
      }
    },
    splitLine: {
      lineStyle: {
        color: "rgba(166, 176, 207, 0.1)"
      }
    },
    axisLabel: {
      formatter: '{value} '
    }
  }],
  series: [{
    name: 'Velocidad',
    type: 'bar',
    data: [value5,value4,value3,value2,value1,value0]
  },
   {
    name: 'Infracciones',
    type: 'line',
    yAxisIndex: 1,
    data: [impru5, impru4, impru3, impru2, impru1, impru0]
  }]
};
; //if (option && (typeof option === "undefined" ? "undefined" : _typeof(option)) === "object") {

opcion && general.setOption(opcion, true); //}
// gauge chart

const dom_vel = document.getElementById("gauge-chart");
const chart_vel = echarts.init(dom_vel);
const app_vel = {};
opcion_vel = null;
opcion_vel = {
  series: [{
    type: 'gauge',
    axisLine: {
      lineStyle: {
        width: 25,
        color: [[0.3, '#67e0e3'], [0.7, '#37a2da'], [1, '#fd666d']]
      }
    },
    pointer: {
      itemStyle: {
        color: 'auto'
      }
    },
    axisTick: {
      distance: -10,
      length: 8,
      lineStyle: {
        color: '#fff',
        width: 2
      }
    },
    splitLine: {
      distance: -40,
      length: 30,
      lineStyle: {
        color: '#fff',
        width: 0
      }
    },
    axisLabel: {
      color: 'auto',
      distance: 40,
      fontSize: 15
    },
    detail: {
      valueAnimation: true,
      formatter: '{value} km/h',
      fontSize: 20,
      color: 'auto'
    },
    data: [{
      value: 50
    }]
  }]
};


opcion_vel && chart_vel.setOption(opcion_vel, true);


const proximidad = document.getElementById('proximidad-driver');
const chart_proxi = echarts.init(proximidad);

const option_proxi = {
  title: {
    text: 'Rango Km/h'
  },
  tooltip: {
    trigger: 'axis'
  },
  legend: {
    data: ['20-40', '40-60', '60-80', '80-100']
  },
  grid: {
    left: '3%',
    right: '4%',
    bottom: '3%',
    containLabel: true
  },
  toolbox: {
    feature: {
      saveAsImage: {}
    }
  },
  xAxis: {
    type: 'category',
    data: [month5, month4,month3,month2,month1,month0]
  },
  yAxis: {
    type: 'value'
  },
  series: [
    {
      name: '20-40',
      type: 'line',
      step: 'start',
      data: [km_20_40[5],km_20_40[4],km_20_40[3],km_20_40[2],km_20_40[1],km_20_40[0]]
    },
    {
      name: '40-60',
      type: 'line',
      step: 'middle',
      data: [km_40_60[5],km_40_60[4],km_40_60[3],km_40_60[2],km_40_60[1],km_40_60[0]]
    },
    {
      name: '60-80',
      type: 'line',
      step: 'end',
      data: [km_60_80[5],km_60_80[4],km_60_80[3],km_60_80[2],km_60_80[1],km_60_80[0]]
    },
    {
      name: '80-100',
      type: 'line',
      step: 'end',
      data: [km_80_100[5],km_80_100[4],km_80_100[3],km_80_100[2],km_80_100[1],km_80_100[0]]
    }
  ]
};

option_proxi && chart_proxi.setOption(option_proxi);



const topic = '/driverdetect';
let speedsValues = [];

function onConnect() {

    console.log("onConnect Topic ",topic);
    clientMQTT.subscribe(topic);

}


function onMessageArrived(message) {

    try {

        const {id,values} = JSON.parse(message.payloadString)
        
        const speed = values.speed.toFixed(2);
       
        speedsValues = [...speedsValues,speed];

        const sum = speedsValues.reduce((previus,current)=>Number(previus)+Number(current));

        const avg = Number(sum/speedsValues.length).toFixed(2);

        opcion_vel.series[0].data[0].value = avg;
        chart_vel.setOption(opcion_vel, true);

        if(speedsValues.length == 20) {

          speedsValues = [];
        }

        
    } catch (error) {
        console.log('error ',error);
    }

}

clientMQTT.onMessageArrived = onMessageArrived;

options.onSuccess=onConnect;

clientMQTT.connect(options);

</script>

@endsection