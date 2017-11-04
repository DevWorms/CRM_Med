$(document).ready(function () {
    reporteCitasUsuarios();

    //SEARCH POR ENTER
    $("#searchRepUsuario").keypress(function (e) {
        if (e.keyCode == 13) {
            reporteCitasUsuariosBySearch();
        }
    });
});

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
                    contenido += "<td align='center'>" + item.nombre + " " + ((item.apPaterno == null) ? "" : item.apPaterno) + " " + ((item.apMaterno == null) ? "" : item.apMaterno) + "</td>";
                    contenido += "<td align='center'>" + item.primeravez + "</td>";
                    contenido += "<td align='center'>" + item.valoracion + "</td>";
                    contenido += "<td align='center'>" + item.revision + "</td>";
                    contenido += "<td align='center'>" + item.tratamiento + "</td>";
                    contenido += "</tr>";
                });

                $("#tblReporteCitasUsr").html(contenido);
            }
        }, error: function (error) {
            $.notify(error, "error");
        }, complete: function () {
            $("#wait").hide();
        }
    });
}

function reporteCitasUsuariosDia(dias) {
    $.ajax({
        url: APP_URL + 'class/Usuarios.php',
        type: 'POST',
        dataType: 'json',
        data: {
            get: 'reporteDias',
            search: dias
        },
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            if (response.estado == 1) {
                var reporte = response.rows;
                var contenido = "";
                reporte.forEach(function (item) {
                    contenido += "<tr>";
                    contenido += "<td align='center'>" + item.nombre + " " + ((item.apPaterno == null) ? "" : item.apPaterno) + " " + ((item.apMaterno == null) ? "" : item.apMaterno) + "</td>";
                    contenido += "<td align='center'>" + item.primeravez + "</td>";
                    contenido += "<td align='center'>" + item.valoracion + "</td>";
                    contenido += "<td align='center'>" + item.revision + "</td>";
                    contenido += "<td align='center'>" + item.tratamiento + "</td>";
                    contenido += "</tr>";
                });

                $("#tblReporteCitasUsr").html(contenido);
            }
        }, error: function (error) {
            $.notify(error, "error");
        }, complete: function () {
            $("#wait").hide();
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
                    contenido += "<td align='center'>" + item.nombre + " " + ((item.apPaterno == null) ? "" : item.apPaterno) + " " + ((item.apMaterno == null) ? "" : item.apMaterno) + "</td>";
                    contenido += "<td align='center'>" + item.primeravez + "</td>";
                    contenido += "<td align='center'>" + item.valoracion + "</td>";
                    contenido += "<td align='center'>" + item.revision + "</td>";
                    contenido += "<td align='center'>" + item.tratamiento + "</td>";
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