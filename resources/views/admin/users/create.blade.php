@extends('admin.layouts.master')

@section('title') 
@lang('translation.Users') 
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/fontawesome.min.css" integrity="sha512-Rcr1oG0XvqZI1yv1HIg9LgZVDEhf2AHjv+9AuD1JXWGLzlkoKDVvE925qySLcEywpMAYA/rkg296MkvqBF07Yw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <div class="alert alert-success p-2" id="success-alert">
      <p>El usuario se registro con exito!</p>
    </div>
    @endif
      <h3>Creacion de usuarios</h3>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-6 m-auto">
                {!! Form::open(['route' => ['users.store'], 'enctype' =>'multipart/form-data', 'method' => 'post','id'=>'id_form', 'required']) !!}
                 @csrf
                  <div class="row">
                      <div class="col-md-6">
                         <div class="form-group" >
                           <label for="i_name">Nombres completos</label>
                           {!! Form::text('name', null, ['class' => 'form-control','id'=>'i_name' , 'required',  'minlength=3' ,'maxlength=30']) !!} 
                         
                        
                         </div>
                      </div>

                      <div class="col-md-6">
                         <div class="form-group">
                           <label for="i_lastname">Apellidos completos</label>
                           {!! Form::text('last_name',null, ['class' => 'form-control','id'=>'i_lastname' , 'required',  'minlength=3' ,'maxlength=60']) !!} 
                         </div>
                      </div>
                      <!--End first row name lastname-->
                  </div>
                  
                  <div class="row mt-2">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="i_email">Email</label>
                          {!! Form::text('email', null, ['class' => 'form-control','id'=>'i_email', 'required']) !!} 
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="i_birth">Fecha de nacimiento</label>
                          {!! Form::date('date_of_birth', null, ['class' => 'form-control','id'=>'i_birth', 'required']) !!} 
                          
                      </div>
                    </div>
                    <!--End row foto-email-->
                  </div>     


                  <div class="row mt-2">

                      <div class="col-md-6">
                        <div class="input-group d-flex flex-column">
                         <div class="input-group-prepend">
                           <label for="i_type_id">Tipo de identificacion</label>
                         </div>
                         <div>
                           {!! Form::select('type_id_doc', $tipos_id, null, ['class' => 'form-select','id'=>'i_type_id','placeholder'=>"Seleccione el tipo de identificación", 'required',  'minlength=3' ,'maxlength=50']) !!}
                         </div>
                           
                        </div>
                      </div>

                       <div class="col-md-6">
                         <div class="form-group">
                          <label for="i_id_user">Numero de identificacion</label>
                          {!! Form::number('id_user', null, ['class' => 'form-control','id'=>'i_id_user', 'required']) !!} 
                         </div>
                       </div>
                       <!--End row 4 cedula-->
                  </div>


                  <div class="row mt-2">

                    <div class="col-md-6">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <label for="i_role">Rol de usuario</label>
                        </div>
                        <div class="w-100">
                         {!! Form::select(  'type_id_role', ['admin'=>'Admin','user'=>'User'], 0, ['class' => 'form-select','id'=>'i_role','placeholder'=>"Seleccione el rol de usuario", 'required']) !!}
                        </div>
                      </div>

                    </div>


                    <div class="col-md-6">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <label for="i_gender">Genero del usuario</label>
                        </div>
                        <div class="w-100">
                         {!! Form::select('gender',['m'=>'Masculino','f'=>'Femenino'], 0, ['class' => 'form-select','id'=>'i_gender','placeholder'=>"Seleccione el genero", 'required']) !!}
                        </div>
                      </div>
                    </div>
                  <!--End row 5 role-gender-->
                  </div>


                  
                  <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="city_id">Ciudad de origen</label>
                          {!! Form::text('city', null, ['class' => 'form-control','id'=>'city_id', 'required']) !!} 
                         </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group mt-3">
                        {!! Form::submit('Registrar usuario', ['class' => 'btn btn-success w-100','id'=>'btn_submit_user', 'required']) !!} 
                      </div>
                    </div>

                  </div>
                  
                {!!Form::close()!!}
            </div>
        </div>

        
        
    <!--End container--> 
    </div>
    
    <style> 
    
    input {
    display: block;
    margin: 0 auto;
}
i{ display: block;
    margin: 0 auto;}
label {
    display: inline-block;
}
    </style> 
@endsection
@section('script')
    
    <script type="text/javascript" src="{{ asset('assets/libs/jquery-validation/jquery-validation.min.js')}}"></script>

    <script>
 
        $(document).ready(function(){

          $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
              $("#success-alert").slideUp(500);
          });
          
          $("#id_form").validate({
   
            rules: {
      name:{
        required:true,
        minlength:3,
        maxlength:255 
      },
      
      last_name:{
        required:true,
        minlength:3,
        maxlength:255
      },
      email:{
        required:true,
        email:true
      },
      date_of_birth:{
        required: true,
        date: true
      },
      type_id_role:{
        required: true,
        minlength:1
      },
      type_id_doc:{
        required: true,
        minlength:1
      },
      id_user:{
        required: true,
        minlength:1,
        maxlength:50
      },
      gender:{
        required: true,
        minlength:1,
        maxlength:1 
      },
      city:{
        required:true,
        minlength:1,
        maxlength:20
      }

    },
    messages: {
      name:{
        required: '@lang('validation.custom.name.required')',
        minlength: '@lang('validation.custom.name.minlength')',
        maxlength:'@lang('validation.custom.name.maxlength')'
      },
      last_name:{
        required: '@lang('validation.custom.last_name.required')',
        minlength: '@lang('validation.custom.last_name.minlength')',
        maxlength:'@lang('validation.custom.last_name.maxlength')' 
      },
      email:{
        required: '@lang('validation.custom.email.required')',        
       email: '@lang('validation.custom.email.email')'    
      },
      date_of_birth:{
        required: '@lang('validation.custom.date_of_birth.required')',
        date:'@lang('validation.custom.date_of_birth.date')'
      }, 
      type_id:{
        required: '@lang('validation.custom.type_id.required')'
      
     
      },
      id_user:{
        required: '@lang('validation.custom.id_user.required')',
        minlength: '@lang('validation.custom.id_user.minlength')' 
     
      },
      gender:{
        required: '@lang('validation.custom.gender.required')',
        minlength: '@lang('validation.custom.gender.minlength')'  
     
      },
      city:{
        required: '@lang('validation.custom.city.required')',
        minlength: '@lang('validation.custom.city.minlength')',
        
      }

    
    }
        });
        
        })
    </script>
    
@endsection