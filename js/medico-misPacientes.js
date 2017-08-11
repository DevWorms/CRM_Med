/**
 * Created by rk521 on 2/05/17.
 */
$().ready(function() {
    loadMisPacientes();
});

function loadMisPacientes() {
    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Medico.php',
        data : {
            get: 'misPacientes'
        },
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                if (response.pacientes.length > 0) {
                    $("#pacientes_div").html("");
                    var i = 1;
                    response.pacientes.forEach(function (p) {
                        var nombre = p.nombre + " " + p.apPaterno;
                        if (p.apMaterno) {
                            nombre = nombre + " " + p.apMaterno;
                        }

                        $("#pacientes_div").append(
                            '<h5 id="paciente_' + i + '" style="cursor:pointer" onclick="showDetail(' + p.id + ')"> ' + i + '. ' + p.id + ' - ' + nombre + ' </h5>' +
                            '<div id="info_paciente_' + p.id + '" style="display: none">' +
                            '<table class="table sm-table table-condensed" id="tratamientos_' + p.id + '">' +
                            '<thead>' +
                            '<tr>' +
                            '<th>Procedimientos</th>' +
                            '<th>Ultima cita</th>' +
                            '<th>Proxima Cita</th>' +
                            '<th>Teléfono</th>' +
                            '<th>Ver Completo</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>' +
                            '</tbody>' +
                            '</table>' +
                            '</div>' +
                            '<hr class="gradient">'
                        );

                        i = i+1;
                    });
                } else {
                    $("#pacientes_div").html(
                        "<h5 >No tienes pacientes asignados</h5>"
                    );
                    $('#table_en_espera tr:last').after('<tr>' +
                        '<td colspan="4" style="text-align:center">No tienes pacientes asignados</td>' +
                        '</tr>');
                }
            } else {
                msg(response.mensaje, "danger");
            }
        },
        error: function (response) {
            msg("Ocurrio un error", "danger");
        },
        complete: function () {
            var others = document.querySelectorAll('*[id^="info_paciente_"]');
            others.forEach(function (item) {
                //$(item).slideUp(500);
            });
            $("#wait").hide();
        }
    });
}

function showDetail(id_paciente) {
    var others = document.querySelectorAll('*[id^="info_paciente_"]');
    others.forEach(function (item) {
        $(item).slideUp(500);
    });

    if ($("#info_paciente_" + id_paciente).is(":visible")) {
        $("#info_paciente_" + id_paciente).slideUp(500);
    } else {
        getDetail(id_paciente);
    }
}

function getDetail(id_paciente) {
    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Medico.php',
        data : {
            get: 'detalleMiPaciente',
            id: id_paciente
        },
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                response.procedimientos.forEach(function (proc) {
                    var last_date = "", next_date = "", telefono = "";
                    if (proc.last_date) {
                        last_date = proc.last_date;
                    }

                    if (proc.next_date) {
                        next_date = proc.next_date;
                    }

                    $('#tratamientos_' + id_paciente + ' tr:last').after('<tr>' +
                        '<td>' + proc.tratamiento + '</td>' +
                        '<td>' + last_date + '</td>' +
                        '<td>' + next_date + '</td>' +
                        '<td>' + telefono + '</td>' +
                        '<td><a class="btn btn-success btn-sm" href="' + APP_URL + 'expediente_folio#' + id_paciente + '" >Ver</a></td>' +
                        '</tr>');
                });

                $("#info_paciente_" + id_paciente).slideToggle(500);
            } else {
                msg(response.mensaje, "danger");
            }
        },
        error: function (response) {
            msg("Ocurrio un error", "danger");
        },
        complete: function () {
            $("#wait").hide();
        }
    });
}

function msg(msg, type) {
    $("#error").fadeIn(1000, function () {
        $("#error").html('<div class="alert alert-' + type + '"> &nbsp; ' + msg + '</div>');
    });
}