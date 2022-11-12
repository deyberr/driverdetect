@extends('admin.layouts.master')

@section('title') 
@lang('translation.Monitoring')
@endsection

@section('css')
  
    <!-- Select 2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Edit @endslot
        @slot('title') Edit @endslot
    @endcomponent

  <div class="row">
    
    <div class="col-10 col-md-6  m-auto">
      <div class="card">
          <h4  class="text-center p-2">Editar Dispositivo</h4>
        <div class="card-body">
        @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error}}</li>
            @endforeach
        </ul>
    </div>
    @endif
            <div>
              <form class="form-horizontal" method="post" action="{{ route('devices.update',$d->id) }}">
                @csrf
                @method('PUT')
                      <div class="form-group mt-2">
                          <label >Conductor</label>
                          <div class="w-100">
                              {!! Form::select('id_driver',$users, $id_user, ['id'=>'select_e','class' => 'form-control','required','placeholder'=>'Escoja al conductor','style' => 'width:100%;']) !!} 
                          </div>
                          
                      </div>

                      <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mt-4">
                              <label>Marca de la motocicleta</label>
                              {!! Form::text('reference', $d->reference, ['class' => 'form-control','required','placeholder'=>'Ingrese la marca o referencia']) !!} 
                            </div>
                            @error('reference')
                                  <span class="invalid-feedback" role="alert">
                                      <strong style="font-size:12px">{{ $message }}</strong>
                                  </span>
                            @enderror
                        </div>
                        <div class="col-12  col-md-6">
                            <div class="form-group mt-4">
                              <label>Modelo</label>
                              {!! Form::number('model', $d->model, ['class' => 'form-control','required','placeholder'=>'Ingrese el modelo ']) !!} 
                            </div>
                            
                        </div>
                      </div>

                    
                      <div class="row">
                        <div class="col-12 col-md-6">
                          <div class="form-group mt-4">
                            <label>Cilindraje</label>
                            {!! Form::number('displacement', $d->displacement, ['class' => 'form-control','required','placeholder'=>'Ingrese el cilindraje ']) !!} 
                          
                          </div>
                            
                        </div>
                        <div class="col-12 col-md-6">
                          <div class="form-group mt-4">
                            <label>Placa del vehiculo</label>
                            {!! Form::text('licence_plate', $d->licence_plate, ['class' => 'form-control','required','placeholder'=>'Ingrese la placa ']) !!} 
                          </div>
                           
                        </div>
                      </div>

                      <div class="form-group mt-4">
                          <label>Estado</label>
                          @php
                          if($d->status==0 || $d->status==1){
                              $status=0;
                          }else{
                              $status=2;
                          }
                          @endphp
                          {!! Form::select('status',['0'=>'Activo','2'=>'Inactivo'], $status, ['class' => 'form-control','required','placeholder'=>'Estado del dispositivo']) !!}

                         
                      </div>

                      <div class="form-group mt-4">
                          <label>Tipo de frenos</label>
                          {!! Form::select('type_brake',['Tambor'=>'Tambor','Abs'=>'Abs','Cbs'=>'Cbs','Abs-Cbs'=>'Abs-Cbs'], $d->type_brake, ['class' => 'form-control','required','placeholder'=>'Ingrese el tipo de freno ']) !!} 
                         
                      </div>

                
            </div>
            <div  class="d-flex justify-content-center gap-2 mt-3">
              <a href="/admin/devices" class="btn btn-secondary w-100">Cancelar</a>
              {!! Form::submit('Actualizar',['class'=>'btn btn-primary w-100']) !!}
            </div>
            </form>
        </div>
        <!--end card-body-->
      </div>
    </div>
  </div>
  

@endsection

@section('script')
<!-- Select 2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
      $('#select_e').select2();
    })
</script>
      
@endsection