var total = 0;
$(document).ready(function() {
    $("#print").click(function () {
        printDiv();
    });

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

        defaultView: 'agendaDay',
        navLinks: true, // can click day/week names to navigate views
        editable: false,
        eventLimit: true, // allow "more" link when too many events

        events: function(start, end, timezone, callback) {
            $.ajax({
                url: APP_URL + 'class/Calendario.php',
                type: 'POST',
                data: {
                    get: 'events'
                },
                beforeSend: function () {
                    $("#wait").show();
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.estado == 1) {
                        var events = [];
                        total = response.eventos.length;

                        response.eventos.forEach(function (item) {
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
                                    url: "#" + item.id, payload: item, title: title,
                                    start: item.fecha + "T" + item.hora_ini, id: item.id, color: item.color
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
                }, error: function (response) {
                    error(response.responseJSON.mensaje);
                },
                complete: function () {
                    $("#wait").hide();
                }
            });
        },
        eventClick: function(calEvent, jsEvent, view) {
            openModal(calEvent.payload.cita_id);
        }
    });
});

function loadMedicos() {
    $.ajax({
        url: APP_URL + 'class/Medico.php',
        type: 'POST',
        data: {
            get: 'getMedicos'
        },
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            console.log(response);
        },
        error: function (response) {
            error(response.responseJSON.mensaje);
        },
        complete: function () {
            $("#wait").hide();
        }
    });
}

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

function openModal(id) {
    $("#DetalleEvento-" + id).modal("show");
}

function setAsistencia(id, user_id) {
    $.ajax({
        url: APP_URL + 'class/Calendario.php',
        type: 'POST',
        data: {
            get: 'asistencia',
            asistencia: $('#asistio-' + id).val(),
            id: id,
            user_id: user_id
        },
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                if (response.redirect == 1) {
                    window.location.href = APP_URL + 'control#user=' + user_id;
                }
                $.notify("Se guardaron los cambios correctamente", "success");
                $("#DetalleEvento-" + id).modal("hide");
            } else {
                error(response.mensaje);
            }
        }, error: function (response) {
            error(response.responseJSON.mensaje);
        },
        complete: function () {
            $("#wait").hide();
        }
    });
}

function error(msg) {
    $.notify(msg, "error");
    $("#error").fadeIn(1000, function () {
        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + msg + '</div>');
    });
}