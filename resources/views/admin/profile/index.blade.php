@extends('admin.layouts.master')

@section('title') @lang('translation.Profile') @endsection

@section('css')
    <link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Contacts @endslot
        @slot('title') Profile @endslot
    @endcomponent
    <div class="card p-2">
    <div class="row">

        @if($errors->any())
            <div class="alert alert-danger" id="alert-errors">
                <ul>
                    @foreach($errors->all() as $error)
                      <li>{{ $error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(Session::has('message') && Session::has('alert-class') )
            <div class="{{ Session::get('alert-class') }} mb-2" id="alert-profile">
                <p>{{Session::get('message')}}</p>
            </div>
        @endif
        <div class="col-xl-4">
            <div class="overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Bienvenido !</h5>
                                
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class= "pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img src="{{ isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('/assets/images/users/avatar-1.jpg') }}" alt="" class="img-thumbnail rounded-circle" style="height:65px;width:65px">
                            </div>
                            <h5 class="font-size-15 text-truncate">{{ Auth::user()->name }}</h5>
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">

                                
                                <div class="mt-4 offset-7">
                                    
                                    <a href="javascript:void(0)" class="btn btn-primary waves-effect waves-light btn-sm" data-bs-toggle="modal"
                                    data-bs-target=".update-profile">Editar Perfil</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- end card -->

            <div class="col-xl-8">
                <div>
                    <h4 class="card-title mb-4">Informacion personal</h4>

                    <p class="text-muted mb-4">Hola {{Auth::user()->name}},aqui podras encontrar toda la informacion correspondiente 
                        a tu perfil donde podras editar tu informacion personal
                    </p>
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Nombres completos :</th>
                                    <td>{{ Auth::user()->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Apellidos completos :</th>
                                    <td>{{ Auth::user()->last_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Fecha de nacimiento :</th>
                                    <td>{{ date('d-m-Y', strtotime(Auth::user()->dob)) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Numero de identificacion :</th>
                                    <td>{{ Auth::user()->id_user }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Genero :</th>
                                    @if(Auth::user()->gender=="m")
                                        <td>Masculino</td>
                                    @elseif(Auth::user()->gender=="f")
                                        <td>Masculino</td>
                                    @else
                                        <td>Sin definir</td>
                                    @endif
                                   
                                </tr>
                                <tr>
                                    <th scope="row">E-mail :</th>
                                    <td>{{ Auth::user()->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Ciudad :</th>
                                    <td>{{Auth::user()->city}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>    
    </div>
@include('admin.profile.edit')

@endsection
@section('script')
   

    <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $(document).ready(function(){
        $("#alert-profile").fadeTo(2000, 500).slideUp(500, function(){
              $("#alert-profile").slideUp(500);
        });
        $("#alert-errors").fadeTo(5000, 500).slideUp(500, function(){
              $("#alert-errors").slideUp(500);
        });
    
        $("#avatar").change(function() {
            readURL(this);
        });

        });
        function readURL(input) {
            if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#imagenPrev').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
