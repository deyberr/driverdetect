@extends('admin.layouts.master-without-nav')

@section('title')
    @lang('translation.Login') 
@endsection

@section('css')
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/owl.carousel/owl.carousel.min.css') }}">
@endsection

@section('body')

    <body class="auth-body-bg">
    @endsection

    @section('content')

        <div>
            <div class="container-fluid p-0">
                <div class="row g-0 p-5 " style="height:100vh;background: #141E30;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #243B55, #141E30);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #243B55, #141E30); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
">

                    
                    <!-- end col -->

                    <div class=" col-12 col-sm-8 col-md-7 card m-auto col-lg-8 col-xl-8" style="height:auto;box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);">
                        <div class="row" style="max-height:900px">
                            <div class="d-none d-lg-inline-block col-5">
                                <img class="w-100 h-100 img-fluid" style="object-fit:cover" src="{{ URL::asset('/images/login/login-wallpaper.jpg') }}" alt="" srcset="">
                            </div>
                            <div class="col-12 col-lg-7">
                            <!-- Col login -->
                                <div class=" p-md-4 p-3">
                                <div class="w-100">

                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5">
                                        <a href="index" class="d-block auth-logo">
                                           
                                        </a>
                                    </div>
                                    <div class="my-auto">

                                        <div>
                                            <h4 class="text-primary text-center">Bienvenido de vuelta!</h4>
                                            <p class="text-muted mt-5">Ingresa tus datos para iniciar sesión.</p>
                                        </div>

                                        <div class="mt-3">
                                            <form class="form-horizontal" method="POST" action="{{ route('post.login') }}">
                                                @csrf

                                                @if(Session::has('message'))
                                                    
                                                        <p class="alert alert-danger alerta"  style="padding:5px !important">
                                                            {{ Session::get('message') }}
                                                        </p>
                                                @endif

                                                @if(Session::has('password-change') && Session::has('class-alert') )
                                                    
                                                        <p class="alert {{Session::get('class-alert')}} alerta"  style="padding:5px !important">
                                                            {{ Session::get('password-change') }}
                                                        </p>
                                                @endif

                                                @if(Session::has('contraseña'))
                                                    
                                                    <p class="alert alert-success alerta"  style="padding:5px !important">
                                                        {{ Session::get('contraseña') }}
                                                    </p>
                                                @endif
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Email</label>
                                                    <input name="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="username"
                                                        value="admin@themesbrand.com"
                                                        placeholder="Enter Email" autocomplete="email" autofocus>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                                <div class="mb-3">
                                                    <div class="float-end">
                                                        @if (Route::has('password.request'))
                                                            <a href="{{ route('password.request') }}"
                                                                class="text-muted">Olvidaste tu contraseña?</a>
                                                        @endif
                                                    </div>
                                                    <label class="form-label">Password</label>
                                                    <div
                                                        class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror">
                                                        <input type="password" name="password"
                                                            class="form-control  @error('password') is-invalid @enderror"
                                                            id="userpassword" value="12345678" placeholder="Enter password"
                                                            aria-label="Password" aria-describedby="password-addon">
                                                        <button class="btn btn-light " type="button" id="password-addon"><i
                                                                class="mdi mdi-eye-outline"></i></button>
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" name="remember" type="checkbox" id="remember"
                                                        {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember">
                                                        Recuerda mi sesión
                                                    </label>
                                                </div>

                                                <div class="mt-3 d-grid">
                                                    <button class="btn btn-primary waves-effect waves-light"
                                                        type="submit">LogIn
                                                    </button>
                                                </div>
                                     
                                            </form>
                                            <!--
                                            <div class="mt-5 text-center">
                                                <p>Don't have an account ? <a href="{{ url('register') }}"
                                                        class="fw-medium text-primary"> Signup now </a> </p>
                                            </div>
                                             -->
                                        </div>
                                    </div>
                     
                                </div>

                                </div>
                                </div>
                            </div>
                            <!-- end col login-->
                        </div>
                        
                    </div>
                    <!-- end col -->

                    


                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </div>

    @endsection
    @section('script')
        <script>
            $(document).ready(function(){
                $(".alerta").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alerta").slideUp(500);
                });
            })
        </script>
    @endsection
