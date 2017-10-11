function updatePerfil(){
	var datos = $("#form-updatePerfil").serialize();
	$.ajax({
        type: 'POST',
        url: APP_URL + 'class/Usuarios.php',
        data: datos,
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                $.notify(response.mensaje, "success");
            } else {
                $.notify(response.mensaje, "error");
            }
        },
        error: function (response) {
            $.notify("Oops! Ocurrio un error inesperado", "error");
        },
        complete: function () {
            $("#wait").hide();
        }
    });
}
function updatePassword(){

	var datos = $("#form-updatePass").serialize();
	$.ajax({
        type: 'POST',
        url: APP_URL + 'class/Usuarios.php',
        data: datos,
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                $.notify(response.mensaje, "success");
            } else {
                $.notify(response.mensaje, "error");
            }
        },
        error: function (response) {
             $.notify("Oops! Ocurrio un error inesperado", "error");
        },
        complete: function () {
            $("#wait").hide();
        }
    });

}