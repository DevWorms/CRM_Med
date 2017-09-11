/**
 * Created by rk521 on 2/05/17.
 */
$().ready(function() {
    loadPacientesEnespera();
});

function loadPacientesEnespera() {
    var table = document.getElementById("table_en_espera");
    if (table !== null) {
        for (var i = table.rows.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
    }

    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Medico.php',
        data : {
            get: 'enEspera'
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                if (response.pacientes.length > 0) {
                    response.pacientes.forEach(function (p) {
                        var nombre = p.nombre + " " + p.apPaterno;
                        if (p.apMaterno) {
                            nombre = nombre + " " + p.apMaterno;
                        }

                        $('#table_en_espera tr:last').after('<tr>' +
                            '<td >' + nombre + '</td>' +
                            '<td style="text-align:center">' + p.tratamiento + '</td>' +
                            '<td style="text-align:center">' + p.hora_ini + '</td>' +
                            '<td><span class="btn btn-success" onclick="atender(' + p.id + ')">Atender Paciente</span></td>' +
                            '</tr>');
                    });
                } else {
                    $('#table_en_espera tr:last').after('<tr>' +
                        '<td colspan="4" style="text-align:center">No hay pacientes en espera</td>' +
                        '</tr>');
                }
            } else {
                msg(response.mensaje, "danger");
            }
        },
        error: function (response) {
            msg("Ocurrio un error", "danger");
        }
    });
}

function atender(paciente_id) {
    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Medico.php',
        data : {
            get: 'atender',
            paciente_id: paciente_id
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                msg(response.mensaje, "success");
                window.location.href = APP_URL + "expediente_folio#" + paciente_id;
            } else {
                msg(response.mensaje, "danger");
            }
        },
        error: function (response) {
            msg("Ocurrio un error", "danger");
        }
    });
}

function msg(msg, type) {
    $("#error").fadeIn(1000, function () {
        $("#error").html('<div class="alert alert-' + type + '"> &nbsp; ' + msg + '</div>');
    });
}