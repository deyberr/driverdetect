$(document).ready(function(){
    
    $(".btn_delete_device").click(function(){
        Swal.fire({
        title: 'Estas seguro?',
        text: "No podras revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText:  'Cancelar',
        }).then((result) => {
             if (result.isConfirmed) {

                const id_device=$(this).attr("id");
                const url_del="http://localhost:8000/admin/devices/"+id_device;
                const token=$('meta[name="csrf-token"]').attr('content');
                const div=$(this).closest('.devices__card');
                $.ajax({
                     url:url_del,
                     type:"DELETE",
                     dataType:"json",
                     data:{
                         '_token':token
                     },
                    success:function(data){
                        div.animate({
                            opacity: 'hide', // animate fadeOut
                            width: 'hide'  // animate slideUp
                        }, 'fast', 'linear', function() {
                            $(this).remove();
                        });
                        setTimeout(() => {
                            Swal.fire(
                                'Eliminado!',
                                'El dispositivo fue eliminado',
                                'success'
                            )
                        }, 1000);
                        
                        },
                        error:function(error){

                        }

                //End peticion ajax
                });
                 
            }
        })    
    
    });

    $('.devices__card').hover(function () {
        $(this).children().last().css('display', 'block');
      }, function () {
        $(this).children().last().css('display', 'none');
      });
    

});