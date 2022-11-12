@extends('admin.layouts.master')

@section('title') 
@lang('translation.Users') 
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
        @slot('li_1') Users @endslot
        @slot('title') Users @endslot
    @endcomponent


    <div class="container">
        <div>
            <h3>Administrador de usuarios</h3>
        </div>
        <hr>

        <div class="mt-4">

            <div class="mb-4">
                <div>
                    <a href="{{ route('users.create') }}"
                       title="Add user" 
                       class="btn btn-primary">
                    
                         <span>Añadir usuario</span>
                       
                    </a>
                </div>
            </div>


            <table id="table__users" class="table w-100">
                <thead>
                   <tr>
                       <th>Avatar</th>
                       <th>Nombres</th>
                       <th>Apellidos</th>
                       <th>Email</th>
                       <th>Rol</th>
                       <th>Genero</th>
                       <th>Opciones</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="row_user">
                        <td>foto.jpgg</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role}}</td>
                        @if($user->gender!="" && $user->gender="m")
                            <td>Masculino</td>
                        @elseif($user->gender!="" && $user->gender="f")
                            <td>Femenino</td>
                        @else
                           <td>sin definir</td>
                        @endif
                        <td nowrap="nowrap">
                            <a href="/admin/users/{{$user->id}}/edit"
                               title="Edit user" class="btn btn-success"
                               style="padding:2px 10px">

                                <i class="bx bx-edit-alt" style="font-size:20px"></i>
                            </a>

                            <a href="javascript:void(0)" id="{{$user->id}}"
                               title="Delete user" class="deleteUser btn btn-danger"
                               style="padding:2px 10px">

                                <i class="bx bx-user-x" style="font-size:20px"></i>
                            </a>
                        </td>

                    </tr>
                    @endforeach
                    
                </tbody>

                <tfoot>

                </tfoot>
            </table>
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
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

    <!--Sweet Alert-->
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    
    <script>

        $(document).ready(function(){
            $("#table__users").DataTable(
                {
                    paging:true,
                    responsive:true,
                    columnDefs: [
                        { responsivePriority: 1, targets: 0 },
                        { responsivePriority: 7, targets: -1 }
                    ]
                }
            );
            $(".deleteUser").click(function (){
                const row = $(this).closest('.row_user');
                const id_user=$(this).attr('id');
                const token=$('meta[name="csrf-token"]').attr('content');
                const url="http://localhost:8000/admin/users/"+id_user;
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "No podras revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar!',
                    cancelButtonText:'Cancelar'
                }).then((result) => {
                     if (result.isConfirmed) {
                        $.ajax({
                            type:'DELETE',
                            url:url,
                            data:{
                                '_token':token,
                            },
                            dataType:'JSON',
                            success:function(data){
                                console.log(data.success);
                                row.animate({
                                    opacity: 'hide',
                                    width: 'hide'

                                }, 'fast', 'linear', function () {
                                    $(this).remove();
                                });
                                setTimeout(() => {
                                    Swal.fire(
                                    'Eliminado!',
                                    'El usuario fue eliminado.',
                                    'success'
                                )
                                }, 1000);
                            },
                            error:function(error){
                                console.log(error.responseText);
                            }
                        })
                        

                        }
                })
            });
        })
    </script>
    
@endsection