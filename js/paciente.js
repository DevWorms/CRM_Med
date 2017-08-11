/**
 * Created by rk521 on 25.03.17.
 */
var id = null;
$().ready(function() {
    // Si recibe un usuario por 'get'
    if (window.location.hash !== '') {
        var hash_num = parseInt(window.location.hash.substring(1));
        if (hash_num > 0) {
            if (hash_num) {
                loadPaciente(hash_num);
            }
        }
    }
});

function loadPaciente(id) {
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            get: 'pacienteFull',
            id: id
        },
        success :  function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                var paciente = response.paciente;
                //Nombre
                var nombre = paciente.nombre;
                if (paciente.apPaterno) {
                    nombre = nombre + " " + paciente.apPaterno;
                }

                if (paciente.apMaterno) {
                    nombre = nombre + " " + paciente.apMaterno;
                }

                $("#header").html("<h4>" + nombre + "</h4>");

                //Folio
                $("#folio").html("Folio N° " + paciente.id);

                // Informacion del paciente
                var domicilio = "", ocupacion = "", fecha_nacimiento = "", edad = "",  created_at = "";
                if (paciente.domicilio) {
                    domicilio = paciente.domicilio;
                }

                if (paciente.ocupacion) {
                    ocupacion = paciente.ocupacion;
                }

                if (paciente.fecha_nacimiento) {
                    fecha_nacimiento = paciente.fecha_nacimiento;
                }

                if (paciente.edad) {
                    edad = paciente.edad;
                }

                if (paciente.created_at) {
                    created_at = paciente.created_at;
                }

                $("#info").html("Dirección: " + domicilio + "<br>Ocupación: " + ocupacion +
                    "<br>Fecha de Nacimiento: " + fecha_nacimiento + "<br>Edad: " + edad +
                    "<br><br>Agregado: " + created_at);

                // Contacto
                var telefono = "", email = "", nombreFamiliar = "", telefonoFamiliar = "", telefono2 = "";
                if (paciente.telefono) {
                    telefono = paciente.telefono;
                }

                if (paciente.email) {
                    email = paciente.email;
                }

                if (paciente.nombreFamiliar) {
                    nombreFamiliar = paciente.nombreFamiliar;
                }

                if (paciente.telefonoFamiliar) {
                    telefonoFamiliar = paciente.telefonoFamiliar;
                }

                if (paciente.telefono2) {
                    telefono2 = paciente.telefono2;
                }

                $("#contacto").html("Teléfono: " + telefono + "<br>Teléfono 2: " + telefono2 + "<br>Email: " + email +
                    "<br>Nombre de Familiar: " + nombreFamiliar + "<br>Teléfono de Familiar: " + telefonoFamiliar);

                // Tabla de pagos
                response.pagos.forEach(function (pago) {
                    $('#table_pagos tr:last').after('<tr>' +
                        '<td>' + pago.monto + '</td>' +
                        '<td>' + pago.concepto + '</td>' +
                        '<td>' + pago.nombre + '</td>' +
                        '<td>' + pago.precio + '</td>' +
                        '<td>' + pago.id_pago + '</td>' +
                        '<td>' + pago.resta + '</td>' +
                        '<td>' + pago.fechado + '</td>' +
                        '</tr>');
                });

                var oC = $("#otrasCitas"), pC = $("#proximaCita");
                oC.html("");
                pC.html("");

                // Muestra la cita
                response.citas.forEach(function (cita, i) {
                    /*if (i === 0) {
                        pC.html(
                            '<a href="#" data-toggle="modal" data-target="#cita_' + cita.id + '">' + cita.fecha + ' ' + cita.hora_ini + '</a>'
                        );
                    } else {*/
                        oC.append(
                            '<a href="#" data-toggle="modal" data-target="#cita_' + cita.id + '">' + cita.fecha + ' ' + cita.hora_ini + '</a>'+
                            '<br>'
                        );
                    //}

                    var template = _.template($('#modal_cita_paciente').text());
                    $('#modalsCitas').append(template(cita));
                });

                if (response.nextDate.id) {
                    var nextDate = response.nextDate;
                    pC.html(
                        '<a href="#" data-toggle="modal" data-target="#cita_' + nextDate.id + '">' + nextDate.fecha + ' ' + nextDate.hora_ini + '</a>'
                    );

                    var template = _.template($('#modal_cita_paciente').text());
                    $('#modalsCitas').append(template(nextDate));
                }
            } else {
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }
        },
        error : function (response) {
            $("#error").fadeIn(1000, function () {
                $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
            });
        }
    });
}

function getCitas(id_cita) {
    var table = document.getElementById("citas_by_date_" + id_cita);
    if (table !== null) {
        for (var i = table.rows.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Paciente.php',
            data: {
                post: 'citas',
                fecha: $("#fecha_" + id_cita).val()
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.estado == 1) {
                    $("#error").html("");
                    response.citas.forEach(function (cita) {
                        $('#citas_by_date_' + id_cita +' tr:last').after('<tr>' +
                            '<td style="text-align:center">' + cita.hora_ini + '</td>' +
                            '<td style="text-align:center">' + cita.tipo_cita + '</td>' +
                            '</tr>');
                    });
                    if (Object.keys(response.citas).length < 1) {
                        $('#citas_by_date_' + id_cita +' tr:last').after('<tr>' +
                            '<td colspan="2" style="text-align:center">No se encontraron citas el día ' + $("#fecha_" + id_cita).val() + '</td>' +
                            '</tr>');
                    }
                } else {
                    $("#error").fadeIn(1000, function () {
                        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                    });
                }
            },
            error: function (response) {
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }
        });
    }
}

function getTratamientos(user_id, cita_id) {
    $('#tratamientos_' + cita_id)
        .find('option')
        .remove()
        .end();

    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            post: 'tratamientos',
            id: user_id
        },
        success :  function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                response.tratamientos.forEach(function (t) {
                    $('#tratamientos_' + cita_id).append($('<option>', {
                        value: t.id,
                        text : t.tratamiento
                    }));
                });
            }
            else {
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }
        },
        error : function (response) {
            $("#error").fadeIn(1000, function () {
                $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
            });
        }
    });
}

function getTipoDeCitas(id) {
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            post: 'mostrarTiposCitas'
        },
        success :  function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                response.tipos.forEach(function (t) {
                    $('#tipo_cita_' + id).append($('<option>', {
                        value: t.id_cita,
                        text : t.nombre_cita
                    }));
                });
            }
            else {
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }
        },
        error : function (response) {
            $("#error").fadeIn(1000, function () {
                $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
            });
        }
    });
}

function cancelarCita(cita_id) {
    var r = confirm("¿Deseas cancelar la cita?");
    if (r === true) {
        deleteCita(cita_id);
    }
}

function deleteCita(cita_id) {
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            post: 'deleteCita',
            cita_id: cita_id
        },
        success :  function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                $("#cita_" + cita_id).modal('toggle');
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-success"> &nbsp; ' + response.mensaje + '</div>');
                });

                if (window.location.hash !== '') {
                    var hash_num = parseInt(window.location.hash.substring(1));
                    if (hash_num > 0) {
                        if (hash_num) {
                            loadPaciente(hash_num);
                        }
                    }
                }
            } else {
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }
        },
        error : function (response) {
            $("#error").fadeIn(1000, function () {
                $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
            });
        }
    });
}

function actualizarCita(cita_id, paciente_id) {
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            post: 'updateCita',
            id_paciente: paciente_id,
            id_cita: cita_id,
            fecha: $("#fecha_" + cita_id).val(),
            hora: $("#hora_" + cita_id).val(),
            tipo: $("#tipo_cita_" + cita_id).val(),
            comentario: $("#comentario_cita_" + cita_id).val(),
            tratamiento: $("#tratamientos_" + cita_id).val()
        },
        success :  function(response) {
            response = JSON.parse(response);
            $("#cita_" + cita_id).modal('toggle');
            if (response.estado == 1) {
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-success"> &nbsp; ' + response.mensaje + '</div>');
                });
            } else {
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }
        },
        error : function (response) {
            $("#error").fadeIn(1000, function () {
                $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
            });
        }
    });
}