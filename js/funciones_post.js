function postform() {}

function form1() {

    var id_usuario = $("#id_usuario").val();
    var contrasena = $("#contrasena").val();

    var phpPost = "id_usuario=" + id_usuario + "&contrasena=" + contrasena;

    $.ajax({scriptCharset: "utf-8",
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        cache: false,
        type: "POST",
        data: phpPost,
        dataType: "text",
        url: APP_URL + "controladores/sesion/iniciar_sesion.php",
        success: function (info) {
            console.log(phpPost);
            
            if (info == "1") {
                $("#btnSiguiente").show();
                notifyMe();
                $("#btn_form1").hide();
            }
            
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function notifyMe(phpPost) {

    // Comprobar que el browser soporta notificaciones.
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }

    // COmprobar si el usuario acepta notificaciones
    else if (Notification.permission === "granted") {
    // Si acepta, se crea la notificación;
        var notification = new Notification("Los datos se almacenaron con éxito");
    }

      // Si no acepta, debemos pedirle permiso para su uso
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            // Si acepta, se crea la notificación;
            if (permission === "granted") {
                var notification = new Notification("Hi there!");
            }
        });
    }
}


$(document).ready(function () {

    //pantalla 01
    $("#btn_iniciar_sesion").click(function () {
            form1();
    }); 

});