/**
 * Created by rk521 on 26/05/17.
 */

$('document').ready(function() {
     $("#fecha").change(function() {
         var date = Date.parse($("#fecha").val());
         if(!isNaN(date)) {
             getCountCitas("fecha", "citas_by_date");
         }
     });

    $("#new_fecha").change(function() {
        var date = Date.parse($("#new_fecha").val());
        if(!isNaN(date)) {
            getCitas("new_fecha", "citas_by_date_2");
        }
    });

    $("#new_registrar_cita").click(function () {
        createUserAndCita();
    });

    $("#registrar_cita").click(function () {
        actualizarCita();
    });

    // Buscador de pacientes
    $("#prospecto").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 4,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                url  : APP_URL + 'class/Paciente.php',
                data : {
                    get: 'autoSearchFirstDate',
                    param: $("#prospecto").val()
                },
                success: function (data) {
                    data = JSON.parse(data);
                    response($.map(data.pacientes, function (el) {
                        var apMaterno = "";

                        if(el.apMaterno != null){
                            apMaterno = el.apMaterno;
                        }

                            return el.id + " - " + el.apPaterno + " " + apMaterno + " " + el.nombre;
                    }));
                }
            });
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        delay: 700,
        select: function( event, ui ) {
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.value );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( "" );
            return false;
        }
    });

    $("#busqueda").click(function () {
        getPaciente( $("#prospecto").val() );
    });

    // Autocomplete procedimientos
    $("#new_procedimiento").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                url  : APP_URL + 'class/Recepcion.php',
                data : {
                    get: 'procedimientos',
                    search: $("#new_procedimiento").val()
                },
                success: function (data) {
                    data = JSON.parse(data);
                    response($.map(data.procedimientos, function (el) {
                        return el.nombre_cita
                    }));
                }
            });
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        delay: 700,
        select: function( event, ui ) {
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.value );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( "" );
            return false;
        }
    });

    //Autocompletado anuncios
    $("#new_anuncio").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 4,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                url  : APP_URL + 'class/Recepcion.php',
                data : {
                    get: 'anuncios',
                    search: $("#new_anuncio").val()
                },
                success: function (data) {
                    data = JSON.parse(data);
                    response($.map(data.anuncios, function (el) {
                        return el.referencia
                    }));
                }
            });
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        delay: 700,
        select: function( event, ui ) {
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.value );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( "" );
            return false;
        }
    });
});

function actualizarCita() {
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            post: 'updateCita',
            id_paciente: $("#paciente_id").val(),
            id_cita: $("#cita_id").val(),
            fecha: $("#fecha").val(),
            hora: $("#hora").val(),
            tipo: 1,
            comentario: $("#comentario_cita").val(),
            tratamiento: $("#tratamientos").val()
        },
        success :  function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-success"> &nbsp; ' + response.mensaje + '</div>');
                });
                cleanPaciente();
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

function createUserAndCita() {
    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Paciente.php',
        data: {
            post: 'addPacienteAndCita',
            fecha: $("#new_fecha").val(),
            hora: $("#new_hora").val(),
            proc: $("#new_procedimiento").val(),
            ref: $("#new_anuncio").val(),
            apM: $("#new_apMat").val(),
            apP: $("#new_apPat").val(),
            nombre: $("#new_nombre").val(),
            telefono: $("#new_telefono").val(),
            telefono2: $("#other_telefono").val(),
            comentario: $("#new_comentario_cita").val()
        },
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                $.notify(response.mensaje, "success");
                clearNuevoPaciente();
            } else {
                error(response.mensaje);
            }
        },
        error: function (response) {
            error("Ocurrio un error");
        },
        complete: function () {
            $("#wait").hide();
        }
    });
}

function clearNuevoPaciente() {
    $("#new_fecha").val("");
    $("#new_hora").val("");
    $("#new_procedimiento").val("");
    $("#new_anuncio").val("");
    $("#new_apMat").val("");
    $("#new_apPat").val("");
    $("#new_nombre").val("");
    $("#new_telefono").val("");
    $("#other_telefono").val("");
    $("#new_comentario_cita").val("");

    $("#error").html("");

    var table = document.getElementById("citas_by_date_2");
    if (table !== null) {
        for (var i = table.rows.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
    }
}

function getPaciente(id) {
    id = String(id).split(" - ");
    id = id[0];

    if ($("#tratamientos")) {
        getTratamientos(id);
    }

    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            get: 'pacienteFirstDate',
            id: id
        },
        beforeSend: function () {
            $("#wait").show();
        },
        success :  function(response) {
            response = JSON.parse(response);
            if (response.estado === 0) {
                error(response.mensaje);
                cleanPaciente();
            }
            else {
                loadData(response);
                $.notify("Usuario encontrado", "success");
            }
        },
        error : function (response) {
            error("Ocurrio un error al procesar la solicitud");
            cleanPaciente();
        },
        complete: function () {
            $("#wait").hide();
        }
    });
}

function getTratamientos(id) {
    $('#tratamientos')
        .find('option')
        .remove()
        .end();

    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            post: 'tratamientos',
            id: id
        },
        success :  function(response) {
            response = JSON.parse(response);
            if (response.estado === 1) {
                response.tratamientos.forEach(function (t) {
                    $('#tratamientos').append($('<option>', {
                        value: t.id,
                        text : t.tratamiento
                    }));
                });
            }
            else {
                error(response.mensaje);
            }
        },
        error : function (response) {
            error("Ocurrio un error al procesar la solicitud");
            cleanPaciente();
        }
    });
}

function loadData(data) {
    var cita = data.cita;
    data = data.paciente[0];
    nombre = data.nombre;
    nombre += (data.apPaterno != null) ? " " + data.apPaterno : "";
    nombre += (data.apMaterno != null) ? " " + data.apMaterno : "";

    $("#error").html("");
    $('#registrar_cita').css({"visibility": "visible"});
    $('#pago').css({"visibility": "visible"});

    document.getElementById("nombreP").innerHTML = "Nombre: " + "<b>" + nombre + "</b>";
    document.getElementById("telP").innerHTML = "Teléfono: " + "<b>" + data.telefono + "</b>";
    document.getElementById("folioP").innerHTML = "Folio: " + "<b>" + data.id + "</b>";

    document.getElementById("msgCitaUpdate").innerHTML = "Actualizar Cita";

    if (cita.length > 0) {
        cita = cita[0];
        $("#fecha").prop("disabled", false).val(cita.fecha);
        $("#citas_by_date").prop("disabled", false).val(cita.comentario);
        $("#hora").prop("disabled", false).val(cita.hora_ini);
        $("#tratamientos").prop("disabled", false);
        $("#comentario_cita").prop("disabled", false).val(cita.comentario);

        $("#paciente_id").val(cita.pacientes_id);
        $("#cita_id").val(cita.id);

        getCountCitas("fecha", "citas_by_date");
    } else {
        $("#error").fadeIn(1000, function () {
            $("#error").html('<div class="alert alert-warning"> &nbsp; No se encontró la cita del usuario</div>');
        });
    }
}

function getCitas(fecha_id, table_id) {
    var table = document.getElementById("citas_by_date");
    if (table !== null) {
        for (var i = table.rows.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Paciente.php',
            data: {
                post: 'citasCallCenter',
                fecha: $("#" + fecha_id).val()
            },
            beforeSend: function () {
                $("#wait").show();
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.estado == 1) {
                    $("#error").html("");
                    response.citas.forEach(function (cita) {
                        var nombre = '<td style="text-align:center"></td>';
                        if (cita.type == 1) {
                            nombre = '<td style="text-align:center"><a href="#">' + cita.apPaterno + ' ' + cita.nombre + '</a></td>';
                        }
                        $('#' + table_id + ' tr:last').after('<tr>' +
                            '<td style="text-align:center">' + cita.hora_ini + '</td>' +
                            '<td style="text-align:center">' + cita.tipo_cita + '</td>' +
                            nombre +
                            '</tr>');
                    });
                    if (Object.keys(response.citas).length < 1) {
                        $('#' + table_id + ' tr:last').after('<tr>' +
                            '<td colspan="2" style="text-align:center">No se encontraron citas el día ' + $("#"+fecha_id).val() + '</td>' +
                            '</tr>');
                    }
                } else {
                    error(response.mensaje);
                }
            },
            error: function (response) {
                error("Ocurrio un error");
            },
            complete: function () {
                $("#wait").hide();
            }
        });
    }
}


function getCountCitas(fecha_id,table_id){
    var table = document.getElementById("citas_by_date");
    if (table !== null) {
        for (var i = table.rows.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Paciente.php',
            data: {
                post: 'getCountCitasHoraByFecha',
                fecha: $("#" + fecha_id).val()
            },
            beforeSend: function () {
                $("#wait").show();
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.estado == 1) {
                    $("#error").html("");
                    var contenido = "";
                    response.conteo_citas.forEach(function (cita) {
                        contenido += "<tr>";
                        contenido += "<td>" + cita.hora_ini + "</td>";
                        contenido += "<td style='text-align: center'>" + cita.citasXhora + "</td>";
                        contenido += "</tr>";
                    });
                    $('#' + table_id + ' tr:last').after(contenido);
                    if (Object.keys(response.conteo_citas).length < 1) {
                        $('#' + table_id + ' tr:last').after('<tr>' +
                            '<td colspan="2" style="text-align:center">No se encontraron citas el día ' + $("#"+fecha_id).val() + '</td>' +
                            '</tr>');
                    }
                } else {
                    error(response.mensaje);
                }
            },
            error: function (response) {
                error("Ocurrio un error");
            },
            complete: function () {
                $("#wait").hide();
            }
        });
    }
}

function error(msg) {
    $("#error").fadeIn(1000, function () {
        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + msg + '</div>');
    });
}

function cleanPaciente() {
    $('#registrar_cita').css({"visibility": "hidden"});
    $('#pago').css({"visibility": "hidden"});

    document.getElementById("nombreP").innerHTML = "";
    document.getElementById("telP").innerHTML = "";
    document.getElementById("folioP").innerHTML = "";

    $("#fecha").prop( "disabled", true ).val("");
    $("#citas_by_date").prop( "disabled", true ).val("");
    $("#hora").prop( "disabled", true ).val("");
    $("#tratamientos").prop( "disabled", true ).val("");
    $("#comentario_cita").prop( "disabled", true ).val("");
    $("#prospecto").val("");

    var table = document.getElementById("citas_by_date");
    if (table !== null) {
        for (var i = table.rows.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
    }
}