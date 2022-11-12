<!-- Open Modal Create User -->
<div class="modal fade" id="create_device" tabindex="-1"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center w-100" id="exampleModalLabel">Registro de dispositivos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

          {!! Form::open(['route' => ['devices.store'], 'enctype' =>'multipart/form-data', 'method' => 'POST']) !!}

                <div class="form-group mt-2">
                    <label >Conductor</label>
                    <div class="w-100">
                      {!! Form::select('id_driver',$users, null, ['id'=>'select_c','class' => 'form-control','required','placeholder'=>'Escoja al conductor','style' => 'width:100%;']) !!}
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label>Año de lanzamiento</label>
                    {!! Form::text('año', null, ['class' => 'form-control','required','placeholder'=>'año de lanzamiento']) !!}
                </div>

                <div class="form-group mt-4">
                    <label>Cilindraje</label>
                    {!! Form::number('cilindraje_c', null, ['class' => 'form-control','required','placeholder'=>'Ingrese el cilindraje ']) !!}

                </div>

                <div class="form-group mt-4">
                    <label>Placa del vehiculo</label>
                    {!! Form::text('placa_c', null, ['class' => 'form-control','required','placeholder'=>'Ingrese la placa ']) !!}
                </div>
                 <div class="form-group mt-4">
                    <label>Referencia</label>
                    {!! Form::text('referencia_c', null, ['class' => 'form-control','required','placeholder'=>'Ingrese la referencia']) !!}
                </div>

                <div class="form-group mt-4">
                    <label>Tipo de frenos</label>
                    {!! Form::select('freno_c',['Tambor'=>'Tambor','Abs'=>'Abs','Cbs'=>'Cbs','Abs-Cbs'=>'Abs-Cbs'], null, ['class' => 'form-control','required','placeholder'=>'Ingrese el tipo de freno ']) !!}
                </div>


      </div>
      <div class="modal-footer d-flex gap-1 justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        {!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- Close Modal Create User -->
