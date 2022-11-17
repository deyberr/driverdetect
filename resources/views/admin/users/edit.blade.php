@extends('admin.layouts.master')

@section('title') 
@lang('translation.Users') 
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Users @endslot
        @slot('title') Users @endslot
    @endcomponent


    <div class="container">
        <div>
          @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('mensaje'))
    <div class="alert alert-success">
    </div>
    @endif
      <h3>Edicion de usuarios</h3>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-6 m-auto">
                {!! Form::open(['route' => array('users.update',$user->id), 'enctype' =>'multipart/form-data', 'method' => 'put','id'=>'id_form']) !!}
                 @csrf
                  <div class="row">
                      <div class="col-md-6">
                         <div class="form-group" >
                           <label for="i_name">Nombres completos</label>
                           {!! Form::text('name', $user->name, ['class' => 'form-control','id'=>'i_name' , 'required',  'minlength=3' ,'maxlength=30']) !!} 
                         
                        
                         </div>
                      </div>

                      <div class="col-md-6">
                         <div class="form-group">
                           <label for="i_lastname">Apellidos completos</label>
                           {!! Form::text('last_name',$user->last_name, ['class' => 'form-control','id'=>'i_lastname' , 'required',  'minlength=3' ,'maxlength=60']) !!} 
                         </div>
                      </div>
                      <!--End first row name lastname-->
                  </div>
                  
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="i_email">Email</label>
                          {!! Form::text('email', $user->email, ['class' => 'form-control','id'=>'i_email', 'required']) !!} 
                      </div>
                    </div>

                    <div class="col-md">
                      <div class="form-group">
                        <label for="i_birth">Fecha de nacimiento</label>
                          {!! Form::date('date_of_birth', $user->date_of_birth, ['class' => 'form-control','id'=>'i_birth', 'required']) !!} 
                          
                      </div>
                    </div>
                    <!--End row foto-email-->
                  </div>     


                  <div class="row mt-2">

                      <div class="col-md-6">
                        <div class="form-group">
                          
                         <label for="i_type_id">Tipo de identificacion</label>
                         <div>
                           {!! Form::select('type_id_doc', $types_id, $user->type_id, ['class' => 'form-select','id'=>'i_type_id','placeholder'=>"Seleccione el tipo de identificación", 'required',  'minlength=3' ,'maxlength=50']) !!}
                         </div>
                           
                        </div>
                      </div>

                       <div class="col-md-6">
                         <div class="form-group">
                          <label for="i_id_user">Numero de identificacion</label>
                          {!! Form::number('id_user', $user->id_user, ['class' => 'form-control','id'=>'i_id_user', 'required']) !!} 
                         </div>
                       </div>
                       <!--End row 4 cedula-->
                  </div>


                  <div class="row mt-2">

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="i_role">Rol de usuario</label>
                    
                        <div>
                         {!! Form::select(  'type_id_role', ['admin'=>'Admin','user'=>'User'], $user->role, ['class' => 'form-select','id'=>'i_role','placeholder'=>"Seleccione el rol de usuario", 'required']) !!}
                        </div>
                      </div>

                    </div>


                    <div class="col-md-6">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <label for="i_gender">Genero del usuario</label>
                        </div>
                        <div class="w-100">
                         {!! Form::select('gender',['m'=>'Masculino','f'=>'Femenino'], $user->gender, ['class' => 'form-select','id'=>'i_gender','placeholder'=>"Seleccione el genero", 'required']) !!}
                        </div>
                      </div>
                    </div>
                  <!--End row 5 role-gender-->
                  </div>

                  <div class="form-group mt-3 d-flex justify-content-center">
                    <a href="/admin/users" class="btn btn-danger me-2">Regresar</a>
                   {!! Form::submit('Guardar', ['class' => 'btn btn-success','id'=>'btn_submit_user', 'required']) !!} 
                  </div>

                {!!Form::close()!!}
            </div>
        </div>

        
        
    <!--End container--> 
    </div>
    
    <style> 
    
    input {
      display: block;
    }
    i{ 
      display: block;
    }
    label {
      display: inline-block;
    }
   
    </style> 
@endsection
@section('script')

@endsection