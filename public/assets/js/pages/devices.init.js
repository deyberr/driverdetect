/******/ (function() { // webpackBootstrap
let __webpack_exports__ = {};
/*!********************************************!*\
  !*** ./resources/js/pages/devices.init.js ***!
  \********************************************/
$(document).ready(function () {
  $(".btn_delete_device").click(function () {
    let _this = this;

    Swal.fire({
      title: 'Estas seguro?',
      text: "No podras revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar'
    }).then(function (result) {
      if (result.isConfirmed) {
        let id_device = $(_this).attr("id");
        let url_del = "/admin/devices/" + id_device;
        let token = $('meta[name="csrf-token"]').attr('content');
        let div = $(_this).closest('.devices__card');
        $.ajax({
          url: url_del,
          type: "DELETE",
          dataType: "json",
          data: {
            '_token': token
          },
          success: function success(data) {
            div.animate({
              opacity: 'hide',
              // animate fadeOut
              width: 'hide' // animate slideUp

            }, 'fast', 'linear', function () {
              $(this).remove();
            });
            setTimeout(function () {
              Swal.fire('Eliminado!', 'El dispositivo fue eliminado', 'success');
            }, 1000);
          },
          error: function error(_error) {} //End peticion ajax

        });
      }
    });
  });
  $('.devices__card').hover(function () {
    $(this).children().last().css('display', 'block');
  }, function () {
    $(this).children().last().css('display', 'none');
  });
});
/******/ })()
;
