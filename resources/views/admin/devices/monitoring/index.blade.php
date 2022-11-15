@extends('admin.layouts.master')

@section('title') 
@lang('translation.Monitoring')
@endsection

@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @lang('translation.Monitoring') @endslot
        @slot('title') @lang('translation.Monitoring') @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img style="width:70px; height:70px" src="{{ isset($user->avatar) ? asset($user->avatar) : asset('/images/default/photo-user-default.jpeg') }}" alt="" class="img-thumbnail rounded-circle">
                            </div>
                            <h5 class="font-size-15 text-truncate">{{ Str::ucfirst($user->name) }}</h5>
                            
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">

                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="font-size-15">Edad</h5>
                                        <p class="text-muted mb-0">
                                            {{$edad}}
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="font-size-15">Ciudad</h5>
                                        <p class="text-muted mb-0">{{$user->city}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Velocidad</h4>
        
                            <div class="mt-4 mt-sm-0" style="height:300px">
                                <div id="velocimetro-driver" class="h-100 apex-charts"></div>
                            </div>
                    <p class="text-muted mb-0">Velocidad de la motocicleta en tiempo real</p>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted fw-medium">Imprudencias</p>
                                    <h5 class="mb-0">{{$count_inc}}</h5>
                                </div>

                                <div class="mini-stat-icon avatar-sm rounded-circle bg-danger align-self-center">
                                    <span class="avatar-title rounded-circle bg-danger">
                                        <i class="bx bx-error-circle font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted fw-medium">Placa</p>
                                    <h5 class="mb-0">{{$device->licence_plate}}</h5>
                                </div>

                                <div class="mini-stat-icon avatar-sm rounded-circle bg-warning align-self-center">
                                    <span class="avatar-title rounded-circle bg-secondary">
                                        <i class="bx bx-wallet-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted fw-medium">Motocicleta</p>
                                    <h5 class="mb-0">{{$device->reference}}</h5>
                                </div>

                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-cycling font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted fw-medium">Monitoreo</p>
                                    <h5 class="mb-0">{{$monitoreo}} dias</h5>
                                </div>

                                <div class="avatar-sm rounded-circle bg-success align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-success">
                                        <i class="bx bx-timer font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row p-2 justify-content-end">
                <a href="{{ route('admin.script.download',$device->id) }}" class="w-auto nav-link text-muted">
                <span class="w-auto">
                    Descargar script arduino
                    <i class="bx bx-file font-size-20"></i>
                </span>
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex flex-wrap">
                        <h4 class="card-title mb-4">Imprudencias en la conduccion</h4>
                        <div class="ms-auto">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Week</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Month</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Year</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="stacked-column-chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>

      
@endsection
@section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- echarts -->
<script src="{{ URL::asset('/assets/libs/echarts/echarts.min.js') }}"></script>

<!-- monitoring init -->
<script src="{{ URL::asset('/assets/js/pages/monitoring.init.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>

<script src="{{ URL::asset('/assets/js/utils/socket.js') }}"></script>

<script>

    const d=@json($array_distance);
    const s=@json($array_speed);
    var options_c = {
    chart: {
    height: 360,
    type: 'bar',
    stacked: true,
    toolbar: {
      show: false
    },
    zoom: {
      enabled: true
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '15%',
      endingShape: 'rounded'
    }
  },
  dataLabels: {
    enabled: false
  },
  series: [{
    name: 'Exceso de velocidad',
    data: s
  }, {
    name: 'Distancia de seguridad',
    data: d
  }],
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
  },
  colors: ['#556ee6', '#f1b44c', '#34c38f'],
  legend: {
    position: 'bottom'
  },
  fill: {
    opacity: 1
  }
};
var chart = new ApexCharts(document.querySelector("#stacked-column-chart"), options_c);
chart.render(); 

//Velocimetro

var chartVel = document.getElementById('velocimetro-driver');
var chartInit = echarts.init(chartVel);
var optionV;
optionV = {
  tooltip: {
    formatter: '{a} <br/>{b} : {c}%'
  },
  series: [{
    name: 'Pressure',
    type: 'gauge',
    progress: {
      show: true
    },
    detail: {
      valueAnimation: true,
      formatter: '{value}'
    },
    data: [{
      value: 0,
      name: 'KM/H'
    }]
  }]
};
optionV && chartInit.setOption(optionV);

    


const topic = '/driverdetect/'+{{$id}};

    function onConnect() {

    console.log("onConnect Topic ",topic);
    clientMQTT.subscribe(topic);

}



function onMessageArrived(message) {

    try {

        const {id,values} = JSON.parse(message.payloadString);
        
        optionV.series[0].data[0].value = values.speed.toFixed(2);
        chartInit.setOption(optionV, true);
        
    } catch (error) {
        console.log('error ',error);
    }

}

clientMQTT.onMessageArrived = onMessageArrived;

options.onSuccess=onConnect;

clientMQTT.connect(options);
</script>

<script type="module">

     

</script>

@endsection