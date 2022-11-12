@extends('user.layouts.master')

@section('title') @lang('translation.Dashboard') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboards @endslot
        @slot('title') Dashboard @endslot
    @endcomponent


    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Bienvenido!</h5>
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
                                <img src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('/assets/images/users/avatar-1.jpg') }}" alt="" class="img-thumbnail img-profile rounded-circle">
                            </div>
                            <h5 class="font-size-15 text-truncate">{{ Str::ucfirst(Auth::user()->name) }}</h5>
                            
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">

                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="font-size-15">Edad</h5>
                                        <p class="text-muted mb-0">{{$edad}}</p>
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
                                    <h5 class="mb-0">10</h5>
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

            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex flex-wrap">
                        <h4 class="card-title mb-4">Perfil de conduccion</h4>
                    
                    </div>

                    <div id="stacked-column-chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>

        <div class="card">
                <div class="card-body">
        
                            <div class="mt-4 mt-sm-0" style="height:300px">
                                <div id="historial-velocimetro" class="h-100 apex-charts"></div>
                            </div>
                    <p class="text-muted mb-0">Velocidad promedio en los ultimos dias de la semana</p>
                </div>
            </div>
    </div>

    <style>
        .img-profile{
            height: 72px;
            width: 72px;
            object-fit:cover; 
        }
    </style>
    

@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>


    <!-- echarts -->
    <script src="{{ URL::asset('/assets/libs/echarts/echarts.min.js') }}"></script>

    <!-- monitoring init -->
    <script src="{{ URL::asset('/assets/js/pages/monitoring.init.js') }}"></script>

<script>

let velocymeter = document.getElementById('velocimetro-driver');
let chartVel = echarts.init(velocymeter);
let optionsVel;

let historial = document.getElementById('historial-velocimetro');
let chartHistorial = echarts.init(historial);
let opciones;

opciones = {
  title: {
    text: 'Historial reciente Km/h'
  },
  tooltip: {
    trigger: 'axis'
  },
  legend: {
    data: ['Jornada diurna', 'Jornada nocturna']
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
    boundaryGap: false,
    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
  },
  yAxis: {
    type: 'value'
  },
  series: [
    {
      name: 'Jornada diurna',
      type: 'line',
      stack: 'Total',
      data: [50, 70, 40, 35, 89, 100, 79]
    },
    {
      name: 'Jornada nocturna',
      type: 'line',
      stack: 'Total',
      data: [80, 70, 98, 120, 67, 67, 67]
    },
    
  ]
};

opciones && chartHistorial.setOption(opciones);
</script>
@endsection