@extends('admin.layouts.master')

@section('title')
@lang('translation.Devices')
@endsection

@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Select 2 -->
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" />

@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Devices @endslot
        @slot('title') Devices @endslot
    @endcomponent
@include('admin.devices.create')


    <div class="container">
        <div>
            <h4>Administrador de dispositivos</h4>
        </div>
        <hr>

        @if(Session::has('message'))
            <div class="alert alert-success">
                <p style="padding:2px !important">{{Session::get('message')}}</p>
            </div>
        @endif

        <div class="options row mb-4 mt-4">
            <div class="col-4 col-sm-6 col-md-4">
                <button type="button" data-bs-toggle="modal" data-bs-target="#create_device"
                        class="btn btn-md btn-primary">
                        Agregar
                </button>
            </div>

            <div class="d-flex col-8 col-sm-6 col-md-4">
                    <form action="{{ route('admin.search.devices') }}" class="form-group d-flex" method="post">
                        @csrf
                        <input class="form-control" placeholder="search device..." type="text"
                                name="search__device" id="i_search_devices">

                        <button type="submit"
                                class="btn btn-primary bx bx-search"
                                id="btn_search">
                        </button>
                    </form>
            </div>


            <div class="col-12 col-md-4 mt-2">
                <a href="{{ route('devices.index') }}"   class="btn btn-sm btn-secondary me-1">Todos</a>
                <a href="/admin/devices/filter/active"  class="btn btn-sm btn-success me-1">Activos</a>
                <a href="/admin/devices/filter/repose" class="btn btn-sm btn-warning me-1">Reposo</a>
                <a href="/admin/devices/filter/inactive" class="btn btn-sm btn-danger me-3">Inactivos</a>
            </div>

        </div>

        <div>

           <div id="container__devices" class="row">
           @if(count($devices)>0)
           @foreach($devices as $dev)

            <div class="devices__card card position-relative p-2  border col-sm-10 col-md-6 col-lg-4 ">
            <a href="{{ route('admin.monitoring.driver',$dev->id) }}" id="{{$dev->id}}">
            <div class="row">
                    <div class="col-3 d-flex align-items-center">
                        @php
                            $driver=\DB::table('drivers')->where('id_device',$dev->id)->get();
                            foreach($driver as $dr){
                                $id_user=$dr->id_user;
                            }

                            $user=\DB::table('users')->find($id_user);

                        @endphp
                       <img class="photo__perfil__device img-thumbnail rounded-circle" src="{{URL::asset($user->avatar)}}"  alt="Foto de perfil" srcset="">
                    </div>
                    <div class="col-9 p-2">
                        <div class="position-relative">
                             <p class="devices{{$dev->status}}" data-type="status">{{$dev->reference}}</p>
                        </div>
                        @if($user->name)
                            <small class="text-muted">{{$user->name}}</small>
                        @else
                            <small class="text-muted">Sin asignar</small>
                        @endif

                    </div>
            </div>
                <div class="options__device position-absolute">
                     <span>
                         <a href="devices/{{$dev->id}}/edit"id="{{$dev->id}}" class="btn_edit__device">
                            <i class="bx bx-edit-alt btn btn-warning p-1"></i>
                         </a>

                        <a href="javascript:void(0)" id="{{$dev->id}}" class="btn_delete_device">
                            <i class="bx bx-trash btn btn-danger p-1"></i>
                        </a>

                     </span>
                </div>
                </a>
            </div>

           @endforeach
           @else
                <h4 class="mt-2 text-muted">No existen registros</h4>
           @endif
           </div>

           <div class="d-flex justify-content-center mt-4">
            {{ $devices->links() }}
           </div>

        </div>

    <!--End container-->
    </div>

@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/devices.init.js') }}"></script>


    <!-- Select 2 -->
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/libs/paho/paho-mqtt.min.js') }}" type="text/javascript"></script>

    <script src="{{ URL::asset('/assets/js/utils/socket.js') }}"></script>

    <script type="module">

        let _timeouts = {};

        const FIVE_MINUTS_IN_MS = 300000;
        const topic = '/driverdetect';

        function onConnect() {

            console.log("onConnect Topic ",topic);
            clientMQTT.subscribe(topic);

        }

        function onMessageArrived(message) {

            try {
   
                console.log(message.payloadString)
                const {id,values} = JSON.parse(message.payloadString);
        
                const adiv = document.getElementById(id);

                const target = adiv.querySelector("[data-type='status']");

                target.className = 'devices1';
                
                if(_timeouts[id]){

                    clearTimeout(_timeouts[id])
                }
                _timeouts[id] = setTimeout(() => {

                    target.className = 'devices0';
                    
                }, FIVE_MINUTS_IN_MS);
                
            } catch (error) {
                console.log('error ',error);
            }
            

        }

        clientMQTT.onMessageArrived = onMessageArrived;

        options.onSuccess=onConnect;

        clientMQTT.connect(options);



        $(document).ready(function() {
        $('#select_c').select2({
            dropdownParent: $('#create_device')
        });

        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                $(".alert").slideUp(500);
        });

        });
    </script>

@endsection