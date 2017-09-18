$(document).ready(function () {
    reporteCitasUsuarios();

    //SEARCH POR ENTER
    $("#searchRepUsuario").keypress(function (e) {
        if (e.keyCode == 13) {
            reporteCitasUsuariosBySearch();
        }
    });
});

function reporteUsuarioMasCitasPv() {
    $.ajax({
        url: APP_URL + 'class/Usuarios.php',
        type: 'POST',
        dataType: 'json',
        data: {"get": 'reporteUsuarioMasCitasPv'},
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            if (response.estado == 1) {
                // Mas citas de primera vez
                var usuario = response.rows[0];
                var nombre = usuario.nombre + " " + ((usuario.apPaterno == null) ? "" : usuario.apPaterno) + " " + ((usuario.apMaterno == null) ? "" : usuario.apMaterno);
                var numero = usuario.numeroUsuario;
                var citas = usuario.citas;
                var checkins = usuario.checkins;
                $("#masCitasPv").html("<b>" + nombre + "<br> Número de Usuario: " + numero + "<br>Número de Citas: " + citas + "<br>Checkins: " + checkins + "</br>");

                // Menos citas de primera vez
                usuario = response.rows[1];
                nombre = usuario.nombre + " " + ((usuario.apPaterno == null) ? "" : usuario.apPaterno) + " " + ((usuario.apMaterno == null) ? "" : usuario.apMaterno);
                numero = usuario.numeroUsuario;
                citas = usuario.citas;
                checkins = usuario.checkins;
                $("#menosCitasPv").html("<b>" + nombre + "<br>Número deUsuario: " + numero + "<br>Número de Citas: " + citas + "<br>Checkins: " + checkins + "</b>");

                // Mas citas totales
                usuario = response.rows[2];
                nombre = usuario.nombre + " " + ((usuario.apPaterno == null) ? "" : usuario.apPaterno) + " " + ((usuario.apMaterno == null) ? "" : usuario.apMaterno);
                numero = usuario.numeroUsuario;
                citas = usuario.citas;
                checkins = usuario.checkins;
                $("#masCitasTotal").html("<b>" + nombre + "<br> #Usuario: " + numero + "<br>Número de Citas: " + citas + "<br>Checkins: " + checkins + "</b>");

                // Menos citas totales
                usuario = response.rows[3];
                nombre = usuario.nombre + " " + ((usuario.apPaterno == null) ? "" : usuario.apPaterno) + " " + ((usuario.apMaterno == null) ? "" : usuario.apMaterno);
                numero = usuario.numeroUsuario;
                citas = usuario.citas;
                checkins = usuario.checkins;
                $("#menosCitasTotal").html("<b>" + nombre + "<br> #Usuario: " + numero + "<br>Número de Citas: " + citas + "<br>Checkins: " + checkins + "</b>");
            }
        }, error: function (error) {
            $.notify(error, "error");
        }, complete: function () {
            $("#wait").hide();
        }
    });

}

function reporteCitasUsuarios() {
    $.ajax({
        url: APP_URL + 'class/Usuarios.php',
        type: 'POST',
        dataType: 'json',
        data: {"get": 'reporteCitasUsuarios'},
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            if (response.estado == 1) {
                var reporte = response.rows;
                var contenido = "";
                reporte.forEach(function (item) {
                    contenido += "<tr>";
                    contenido += "<td>" + item.nombre + " " + ((item.apPaterno == null) ? "" : item.apPaterno) + " " + ((item.apMaterno == null) ? "" : item.apMaterno) + "</td>";
                    contenido += "<td>" + item.numeroUsuario + "</td>";
                    contenido += "<td>" + item.primeravez + "</td>";
                    contenido += "<td>" + item.preoperatorios + "</td>";
                    contenido += "<td>" + item.cirugia + "</td>";
                    contenido += "<td>" + item.postoperatorio + "</td>";
                    contenido += "<td>" + item.valoracion + "</td>";
                    contenido += "<td>" + item.revision + "</td>";
                    contenido += "<td>" + item.tratamiento + "</td>";
                    contenido += "</tr>";
                });

                $("#tblReporteCitasUsr").html(contenido);
            }
        }, error: function (error) {
            $.notify(error, "error");
        }, complete: function () {
            reporteUsuarioMasCitasPv();
        }
    });
}

function reporteCitasUsuariosBySearch() {
    $.ajax({
        url: APP_URL + 'class/Usuarios.php',
        type: 'POST',
        dataType: 'json',
        data: {"get": 'reporteCitasUsuariosBySearch', "search": document.getElementById("searchRepUsuario").value},
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            if (response.estado == 1) {
                var reporte = response.rows;
                var contenido = "";
                reporte.forEach(function (item) {
                    contenido += "<tr>";
                    contenido += "<td>" + item.nombre + " " + ((item.apPaterno == null) ? "" : item.apPaterno) + " " + ((item.apMaterno == null) ? "" : item.apMaterno) + "</td>";
                    contenido += "<td>" + item.numeroUsuario + "</td>";
                    contenido += "<td>" + item.primeravez + "</td>";
                    contenido += "<td>" + item.preoperatorios + "</td>";
                    contenido += "<td>" + item.cirugia + "</td>";
                    contenido += "<td>" + item.postoperatorio + "</td>";
                    contenido += "<td>" + item.valoracion + "</td>";
                    contenido += "<td>" + item.revision + "</td>";
                    contenido += "<td>" + item.tratamiento + "</td>";
                    contenido += "</tr>";
                });

                $("#tblReporteCitasUsr").html(contenido);
            }
        }, error: function (error) {
            $.notify(error, "error");
            $("#wait").hide();
        }, complete: function () {
            $("#wait").hide();
        }
    });
} 