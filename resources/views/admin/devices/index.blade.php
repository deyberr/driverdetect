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
