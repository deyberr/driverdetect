@extends('admin.layouts.master')

@section('title')
    @lang('translation.Support') 
@endsection

@section('css')
    <!-- Sweet Alert-->
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Support @endslot
        @slot('title') Support @endslot
    @endcomponent
<div class="container__support">

<div class="row">
    <div class="col-12">
        <!-- <p>Si tienes algunas dudas con respecto al correcto 
        funcionamiento del aplicativo ingresa en el siguiente link
                <a target="_blank" href="{{ route('admin.support.tutorial') }}"
                    class="">
                    Tutorial
                </a>
        </p> -->
    </div>
</div>
<div class="row mt-1">
    
    <div id="card-form" class="col-12 col-sm-9 col-md-6 m-auto">


            {!! Form::open(['route' => ['admin.support.contact'], 'enctype' =>'multipart/form-data', 'method' => 'post']) !!}
                <div class="card">
                    
                    <div class="card-body form-group">
                        <h4>Contactanos</h4>
                       <hr>

                        @if(Session::has('message'))
                                                    
                            <p class="alert alert-success alerta" id="success-alert"  style="padding:5px !important">
                                {{ Session::get('message') }}
                            </p>
                        @endif

                       
                        <div class="row">
                        
                            <div class="col-12 col-sm-6">
                            <label for="nombres_id">Nombre completo</label>
                            <input type="text" name="nombres" required  
                                   class="@error('nombres') is-invalid @enderror form-control"
                                   id="nombres_id" placeholder="Ingrese sus nombres">
                            
                            @error('nombres')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            </div>
                            
                            <div class="col-12 col-sm-6">
                            <label for="apellidos_id">Apellido completo</label>
                            <input class="@error('apellidos') is-invalid @enderror form-control"
                                   type="text" name="apellidos"  required
                                   id="apellidos_id" placeholder="Ingrese sus apellidos">
                            
                            @error('apellidos')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            </div>
                        </div>

                        <div>
                            <label for="email_id">E-mail</label>
                            <input class="@error('email') is-invalid @enderror form-control"
                                   type="email" name="email" required
                                   id="email_id" placeholder="Ingrese su e-mail">
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label for="asunto_id">Asunto</label>
                            <textarea  required  placeholder="Ingrese el asunto" 
                                       class="form-control @error('asunto') is-invalid @enderror"
                                       name="asunto" id="asunto_id" rows="3"></textarea>
                            
                            @error('asunto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        
                    </div>
                    <div class="card-footer">
                        {!! Form::submit('Enviar',['class'=>'form-control btn btn-success','id'=>'btn_enviar']) !!}
                    </div>
                 </div>
            {!! Form::close() !!}
    </div>

    <div class="d-none d-md-inline-block col-md-6">
        <img  src="{{ asset('assets/images/contact_suport.svg') }}" alt="" srcset="" width="300" heigth="250">
    </div>

    
</div>
</div>

<style>
    #card-form{
        -webkit-box-shadow: 6px 9px 11px -3px rgba(41,38,41,1);
        -moz-box-shadow: 6px 9px 11px -3px rgba(41,38,41,1);
        box-shadow: 6px 9px 11px -3px rgba(41,38,41,1);
    }
    
</style>

@endsection

@section('script')
    

    <!--Sweet Alert-->
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    
   
    <script>
        $(document).ready(function(){

            $("#success-alert").fadeTo(1000, 500).slideUp(500, function(){
                $("#success-alert").slideUp(500);
            });
        });
      
    </script>
@endsection