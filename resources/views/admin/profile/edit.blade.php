<!--  Update Profile example -->
<div class="modal fade update-profile" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="{{ route('updateProfile',Auth::user()->id) }}" enctype="multipart/form-data" id="update-profile">
                        @csrf
                        
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-2">
                                    <label for="useremail" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="useremail" value="{{ Auth::user()->email }}" name="email"
                                           placeholder="Ingrese su e-mail" autofocus required>
                                    
                                </div>

                                <div class="mb-2">
                                    <label for="last_name" class="form-label">Apellidos completos</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                           value="{{ Auth::user()->last_name }}" id="last_name" name="last_name" 
                                           placeholder="Ingrese su apellido completo" required >
                                    
                                </div>

                                <div class="mb-2">
                                    <label for="tipo_identificacion" class="form-label">Tipo de identificacion</label>
                                    <select name="tipo_identificacion" id="tipo_identificacion"
                                            class="form-select @error('tipo_identificacion') is-invalid @enderror"
                                            placeholder="Seleccione su tipo de identificacion" required>
                                        @foreach($type_id as $key=>$item)
                                            <option value="{{ $key }}" @if($user->type=== $item) selected='selected' @endif> {{ $item }}</option>
                                        @endforeach
                                    </select>
                                  
                                   
                                </div>

                                <div class="mb-2">
                                    <label for="i_city" class="form-label">Ciudad</label>
                                    
                                        {!! Form::text('city', Auth::user()->city, ['class' => 'form-control','id'=>'i_city','placeholder'=>"Ingrese su ciudad de origen", 'required']) !!}
                                    
                                    
                                </div>
                            <!--Finaliza col left -->
                            </div>

                            <div class="col-12 col-sm-6">
                            
                                <div class="mb-2">
                                    <label for="username" class="form-label">Nombres completos</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           value="{{ Auth::user()->name }}" id="username" name="name" autofocus
                                           placeholder="Ingrese su nombre completo" required>
                                    
                                </div>

                                <div class="mb-2">
                                    <label for="date_of_birth">Fecha de nacimiento</label>
                                    <div class="input-group" id="datepicker1">
                                        <input type="text" class="form-control @error('date_of_birth') is-invalid @enderror"
                                            placeholder="dd-mm-yyyy" data-date-format="dd-mm-yyyy"
                                            data-date-container='#datepicker1' data-date-end-date="0d"
                                            value="{{ date('d-m-Y', strtotime(Auth::user()->date_of_birth)) }}"
                                            data-provide="datepicker" required name="date_of_birth" autofocus id="date_of_birth">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                    
                                </div>

                                <div class="mb-2">
                                    <label for="identificacion" class="form-label">Numero de identificacion</label>
                                    <input type="text" class="form-control @error('identificacion') is-invalid @enderror"
                                           value="{{ Auth::user()->id_user }}" id="identificacion" name="identificacion" autofocus
                                           placeholder="Ingrese su numero de identificacion" required>
    
                                </div>

                                <div class="mb-2">
                                    <label for="gender" class="form-label">Genero</label>
                                    
                                        {!! Form::select('gender',['m'=>'Masculino','f'=>'Femenino'], Auth::user()->gender, ['class' => 'form-select','id'=>'i_gender','placeholder'=>"Seleccione el genero", 'required']) !!}
                                    
                                </div>

                                

                            <!--Finaliza col right -->
                            </div>

                        <!--Finaliza row edit profile-->
                        </div>

                        
                        

                        <div class="mb-3">
                            <label for="avatar">Foto de perfil</label>
                            <div class="input-group">
                                <input type="file"
                                    class="form-control @error('avatar') is-invalid @enderror"
                                    id="avatar" name="avatar" accept="image/*" required>
                                <label class="input-group-text" for="avatar">Subir</label>
                            </div>
                            <div class="text-start mt-2">
                                <img src="{{ asset(Auth::user()->avatar) }}" id="imagenPrev" alt=""
                                    class="rounded-circle avatar-lg">
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdateProfile" data-id="{{ Auth::user()->id }}"
                                type="submit">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->