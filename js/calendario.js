var total = 0;
$(document).ready(function() {
    // Listener - imprimir calendario
    $("#print").click(function() {
        printDiv();
    });

    // Listener - Al dar click en NO reagendar
    $("#no-reagendar").change(function() {
        if ($('#no-reagendar').prop("checked")) {
            $("#reagendarCita-fecha").prop("disabled", true);
            $("#reagendarCita-hora").prop("disabled", true);
        } else {
            $("#reagendarCita-fecha").prop("disabled", false);
            $("#reagendarCita-hora").prop("disabled", false);
        }
    });

    // Listener - cerrar modal detalle de evento
    $('#DetalleEvento').on('hidden.bs.modal', function() {
        // Resetea el modal detalle de evento al cerrarlo
        resetModal();
    });

    loadEvents();
});

/*
 * Carga los eventos en el calendario
 */
function loadEvents() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'listDay,listWeek,month'
        },

        views: {
            listDay: { buttonText: 'Dia' },
            listWeek: { buttonText: 'Semana' }
        },

        timezone: 'America/Mexico_City',
        defaultView: 'agendaDay',
        navLinks: true,
        editable: false,
        eventLimit: true,

        events: function(start, end, timezone, callback) {
            end = moment(end).format("YYYY-MM-DD HH.mm:ssZZ");
            start = moment(start).format("YYYY-MM-DD HH:mm:ssZZ");

            $.ajax({
                url: APP_URL + 'class/Calendario.php',
                type: 'POST',
                data: {
                    get: 'events',
                    fecha_inicio: start,
                    fecha_fin: end
                },
                beforeSend: function() {
                    $("#wait").show();
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.estado == 1) {
                        var events = [];
                        total = response.eventos.length;

                        response.eventos.forEach(function(item) {
                            var title = item.tipo_cita + " - " + item.apPaterno;
                            if (item.apMaterno) {
                                title = title + " " + item.apMaterno;
                            }
                            title = title + " " + item.nombre;
                            if (item.hora_fin) {
                                var event = {
                                    url: "#" + item.id,
                                    payload: item,
                                    title: title,
                                    end: item.fecha + "T" + item.hora_fin,
                                    start: item.fecha + "T" + item.hora_ini,
                                    id: item.id,
                                    color: item.color
                                };
                            } else {
                                var event = {
                                    url: "#" + item.id,
                                    payload: item,
                                    title: title,
                                    start: item.fecha + "T" + item.hora_ini,
                                    id: item.id,
                                    color: item.color
                                };
                            }
                            var actionsTemplate = _.template($('#modal_detalle_evento').text());
                            $('#modalsEventos').append(actionsTemplate(item));
                            events.push(event);
                        });

                        callback(events);
                    } else {
                        error(response.mensaje);
                    }
                },
                error: function(response) {
                    error(response.responseJSON.mensaje);
                },
                complete: function() {
                    $("#wait").hide();
                }
            });
        },
        eventClick: function(calEvent, jsEvent, view) {
            openModal(calEvent.payload);
        }
    });
}

/*
 * Asynctask, obtiene una lista de médicos
 */
function loadMedicos() {
    $.ajax({
        url: APP_URL + 'class/Medico.php',
        type: 'POST',
        data: {
            get: 'getMedicos'
        },
        dataType: "JSON",
        beforeSend: function() {
            $("#wait").show();
        },
        success: function(response) {
            var medicos = response.medicos;
            medicos.forEach(function(medico) {
                $("#medico-").append("<option value='" + medico.id + "'>" + medico.nombre + " " + medico.apPaterno + "</option>");
            });
        },
        error: function(response) {
            error(response.responseJSON.mensaje);
        },
        complete: function() {
            $("#wait").hide();
        }
    });
}

/*
 * Asynckask, asigna un médico a un paciente
 */
function asignarMedico(id) {
    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Medico.php',
        data: {
            get: 'atender',
            paciente_id: id,
            medico_id: $("#medico-").val()
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                msg(response.mensaje, "success");
                $("#medico-detalleEvento").html("<p>Medico asignado correctamente</p>");
            } else {
                msg(response.mensaje, "danger");
            }
        },
        error: function(response) {
            msg("Ocurrio un error", "danger");
        }
    });
}

/*
 * Imprime el reporte de citas del calendario
 */
function printDiv() {
    // Cuenta por día
    if ($(".fc-event-container > a").length > 0) {
        total = $(".fc-event-container > a").length;
    }

    // Cuenta por semana
    if ($(".fc-list-item").length > 0) {
        total = $(".fc-list-item").length;
    }

    // Cuenta por mes
    if ($(".fc-day-grid-event").length > 0) {
        total = $(".fc-day-grid-event").length;
    }

    $('#calendar').printThis({
        importCSS: true,
        loadCSS: APP_URL + "plugins/FullCalendar/fullcalendar.min.css",
        header: '<div>' +
            '<h2>Calendario de citas</h2>' +
            '<h4>(' + total + ' citas en total)</h4>' +
            '</div>'
    });
}

/*
 * Abre el modal detalle de evento, y carga la información de la cita
 */
function openModal(cita) {
    $("#header-detalleEvento").html('<h4 class="modal-title" style="text-align:center;">' + cita.tipo_cita + ' - ' + cita.apPaterno + ' ' + cita.apMaterno + ' ' + cita.nombre + '</h4>');
    $("#paciente-detalleEvento").html('<p>Paciente: ' + cita.apPaterno + ' ' + cita.apMaterno + ' ' + cita.nombre + '</p>');
    $("#folio-detalleEvento").html('<p>Folio: <strong>' + cita.id + '</strong></p>');
    $("#procedimiento-detalleEvento").html('<p>Procedimiento: ' + cita.procedimiento + '</p>');
    $("#telefono-detalleEvento").html('<p>Teléfono: ' + cita.telefono + '</p>');
    $("#tipoCita-detalleEvento").html('<p>Tipo de cita: ' + cita.tipo_cita + '</p>');
    $("#fecha-detalleEvento").html('<p>Fecha: ' + cita.fecha + ' ' + cita.hora_ini + '</p>');

    if (cita.is_paciente == 1) {
        if (!cita.id_relacion_mp && cita.tipo_cita != 'Primera Vez') {
            $("#medico-detalleEvento").html('<label for="medico-">Asignar médico:</label>\n' +
            '   <select id="medico-"></select>\n' +
            '   <button class="btn btn-success btn-sm" onclick="asignarMedico(\'' + cita.id + '\');">Asignar</button>');
            loadMedicos();
        } else {
            $("#medico-detalleEvento").html('<p>Médico asignado: ' + cita.medico_nombre + ' ' + cita.medico_apellido + '</p>');
        }
    }

    if (cita.asistencia == 0) {
        $("#asistencia-detalleEvento").html('<select id="asistioSelect-detalleEvento" class="form-control">\n' +
            //'                                                <option disabled selected></option>\n' +
            '                                                <option value="1">Si</option>\n' +
            '                                                <option value="2">No</option>\n' +
            '                                            </select>');

        $("#asistioSelect-detalleEvento").change(function() {
            if ($("#asistioSelect-detalleEvento").val() == 2) {
                displayReagendar(true, cita.fecha, cita.hora_ini);
            } else {
                displayReagendar(false, null, null);
            }
        });
    } else {
        if ((cita.asistencia == 1) || (cita.asistencia == 2)) {
            if (cita.asistencia == 1) {
                $("#asistencia-detalleEvento").html('<a href="control#user=' + cita.id + '">Si</a>');
            } else {
                $("#asistencia-detalleEvento").html('<a href="control#user=' + cita.id + '">No</a>');
            }
        } else {
            $("#asistencia-detalleEvento").html('<a href="control#user=' + cita.id + '">En espera</a>');
        }
    }

    $("#button-detalleEvento").html('<button class="btn btn-primary btn-block" type="submit" name="up_button" onclick="event.preventDefault(); setAsistencia(\'' + cita.cita_id + '\', \'' + cita.id + '\');" id="up_button">Guardar</button>');
    $("#DetalleEvento").modal("show");
}

/*
 * Muestra el formulario para reagendar la cita
 */
function displayReagendar(display, fecha, hora) {
    if (display) {
        $("#reagendarCita").show();
    } else {
        $("#reagendarCita").hide();
    }

    $("#reagendarCita-fecha").val(fecha);
    $("#reagendarCita-hora").val(hora);
}

/*
 * Asiste o no a la cita
 */
function setAsistencia(id, user_id) {
    var data = null;
    if ($('#no-reagendar').prop("checked") || $('#asistioSelect-detalleEvento').val() == 1) {
        data = {
            get: 'asistencia',
            asistencia: $('#asistioSelect-detalleEvento').val(),
            id: id,
            user_id: user_id,
            reagendar: null,
            nueva_fecha: null,
            nueva_hora: null
        };
    } else {
        data = {
            get: 'asistencia',
            asistencia: $('#asistioSelect-detalleEvento').val(),
            id: id,
            user_id: user_id,
            reagendar: 1,
            nueva_fecha: $("#reagendarCita-fecha").val(),
            nueva_hora: $("#reagendarCita-hora").val()
        };
    }

    $.ajax({
        url: APP_URL + 'class/Calendario.php',
        type: 'POST',
        data: data,
        beforeSend: function() {
            $("#wait").show();
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                if (response.redirect == 1) {
                    window.location.href = APP_URL + 'control#user=' + user_id;
                }
                $.notify("Se guardaron los cambios correctamente", "success");
                $("#DetalleEvento").modal("hide");
            } else {
                error(response.mensaje);
            }
        },
        error: function(response) {
            error(response.responseJSON.mensaje);
        },
        complete: function() {
            $("#wait").hide();
            $('#calendar').fullCalendar('refetchEvents');
        }
    });
}

/*
 * Resetea los datos en el modal de detalle de evento
 */
function resetModal() {
    $("#header-detalleEvento").html('');
    $("#paciente-detalleEvento").html('');
    $("#folio-detalleEvento").html('');
    $("#procedimiento-detalleEvento").html('');
    $("#telefono-detalleEvento").html('');
    $("#tipoCita-detalleEvento").html('');
    $("#fecha-detalleEvento").html('');
    $("#medico-detalleEvento").html('');
    $("#asistencia-detalleEvento").html('');
    $("#button-detalleEvento").html('');
    $("#reagendarCita").hide();
    $('#no-reagendar').prop("checked", false);
    $("#reagendarCita-fecha").prop("disabled", false);
    $("#reagendarCita-hora").prop("disabled", false);
}

/*
 * Muestra un mensaje de error
 */
function error(msg) {
    $.notify(msg, "error");
    $("#error").fadeIn(1000, function() {
        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + msg + '</div>');
    });
}

/*
 * Muestra un mensaje de diferente tipo
 */
function msg(msg, type) {
    $.notify(msg, type);
    $("#error").fadeIn(1000, function() {
        $("#error").html('<div class="alert alert-' + type + '"> &nbsp; ' + msg + '</div>');
    });
}