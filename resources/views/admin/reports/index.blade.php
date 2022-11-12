@extends('admin.layouts.master')

@section('title')
    @lang('translation.Reports') 
@endsection

@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Reports @endslot
        @slot('title') Reports @endslot
    @endcomponent

    
    <div class="mt-4">
    @if(Session::has('e-report'))
        <div class="alert alert-danger">
            <p>{{Session::get('e-report')}}</p>
        </div>
    @endif
      <p>En los siguientes filtros podra escojer el rango de tiempo en el cual se generaran los reportes
        y boletines estadisticos, los reportes semestrales se clasifican de la siguiente manera, semestre inicial (enero-junio) - semestre final (julio-diciembre)
      </p>
    </div>
    {!! Form::open(['route' => ['admin.filter.reports'], 'enctype' =>'multipart/form-data', 'method' => 'post', 'required']) !!}
    <div class="mt-3 row">
    
      <div class="col-12 col-sm-6 col-lg-3 form-group">
          <label for="año_r">Año</label>
          <input type="radio" class="radio_input" checked name="radio" id="año_r" value="r_año">
          <input type="number"  class="form-control" name="año" id="año">
      </div>
      <div class="col-12 col-sm-6 col-lg-3 form-group">
            <label for="semestre_r">Semestre</label>
            <input type="radio" class="radio_input" name="radio" id="semestre_r" value="r_semestre">
            <select disabled class="form-control" name="semestre" id="semestre">
              <option value="inicial">Inicial</option>
              <option value="final">Final</option>
            </select>
      </div>
      <div class="col-12 col-sm-6 col-lg-3 form-group">
            <label for="mes_r">Mes</label>
            <input type="radio" class="radio_input" name="radio" id="mes_r" value="r_mes">
            <input disabled type="month" class="form-control" name="mes" id="mes">
      </div>

      <div class=" mt-2 col-12 col-sm-6 col-lg-3 form-group">
            <button type="submit" class="btn btn-success btn_consultar">Consultar</button>
            @php
                
                $existe="";
                if(isset($incidencias)){
                    if(count($incidencias)>0){
                    $existe="si";
                    }
                }else{
                    
                }
            @endphp
            {!!Form::close()!!}
            @if($existe=="si")
            
            <a href="http://localhost:8000/admin/pdf-reports?type={{Session::get('type_report')}}&value={{ Session::get('data_report') }}"
                target="_blank" class="btn btn-primary" rel="noopener noreferrer">Pdf</a>
            @endif
        
      </div>
    </div>
       
    

    
  
 
   <div class="mt-4 container_table">
   @if(isset($incidencias))       
   @if(count($incidencias)>0)
          <table id="table__annual" class="table w-100">
              
                <thead>
                   <tr>
                       <th>Id dispositivo</th>
                       <th>Longitud</th>
                       <th>Latitud</th>
                       <th>Velocidad</th>
                       <th>Proximidad</th>
                       <th>Genero</th>
                       <th>Edad</th>
                       <th>Ciudad</th>
                       <th>Fecha</th>
                       <th>Hora</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach($incidencias as $inc)
                     @php
                     
                            $separar = (explode(" ",$inc->created_at));
                            $fecha=$separar[0];
                            $hora=$separar[1];
                            $user_id=\DB::table('drivers')->where('id',$inc->id_driver)->pluck('id_user');
                            $user=\DB::table('users')->find($user_id);

                            $actual = \Carbon\Carbon::now();
                            $nacimiento =\Carbon\Carbon::parse($user->date_of_birth);
                            $dif=$actual->diffInMonths($nacimiento);
                            $meses=$dif/12;
                            $años=(int)$meses;
    
                     @endphp
                    <tr>
                        <td>{{$inc->id_device}}</td>
                        <td>{{$inc->lon}}</td>
                        <td>{{$inc->lat}}</td>
                        <td>{{$inc->speed}}</td>
                        <td>{{$inc->proximity}}</td>
                        @if($user->gender)
                        @if($user->gender=='m')
                            <td>Masculino</td>
                        @else
                            <td>Femenino</td>
                        @endif
                        @else
                            <th>Indefinido</th>
                        @endif
                        
                        <td>{{$años}}</td>
                        <td>cali</td>
                        <td>{{$fecha}}</td>
                        <td>{{$hora}}</td>
                    </tr>
                    @endforeach
                    
                </tbody>

                <tfoot>

                </tfoot>
            </table>
        @else
            <h4>No existen registros</h4>
            <hr>
        @endif
        @endif
    <!-- End container table-->
    </div>


@endsection

@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

    <!--Sweet Alert-->
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script>
        $(document).ready(function(){
            $("#table__annual").DataTable(
                {
                    paging:true,
                    responsive:true,
                    columnDefs: [
                        { responsivePriority: 1, targets: 0 },
                        { responsivePriority: 7, targets: -1 }
                    ],
                    dom: 'Bfrtip',
                      buttons: [
                          'excelHtml5',
                      ]
                }
            );
            $("input[type=radio][name=radio]").change(function(){
                if(this.value=="r_año"){
                    $("#año").removeAttr("disabled");
                    $("#semestre").attr("disabled","disabled");
                    $("#mes").attr("disabled","disabled");
                }else if(this.value=="r_semestre"){
                    $("#año").removeAttr("disabled");
                    $("#semestre").removeAttr("disabled");
                    $("#mes").attr("disabled","disabled");
                }else if(this.value=="r_mes"){
                    $("#año").attr("disabled","disabled");
                    $("#semestre").attr("disabled","disabled");
                    $("#mes").removeAttr("disabled");
                    
                }else{
                    alert('Opps, recargue la pagina')
                }
            })
            
            
            $(".btn_consultar").click(function(){

            })
            
        })
    </script>
@endsection