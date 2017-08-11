$(document).ready(function() {
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
                    get: 'reporteEventos'
                },
                beforeSend: function () {
                    $("#wait").show();
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.estado == 1) {
                        var events = [];
                        response.eventos.forEach(function (item) {
                            var title = item.cuantas;
                            if(item.asistencia == "1"){
                                title += " cita(s) se llevaron a cabo";
                            }else if(item.asistencia == "0" || item.asistencia == "2"){
                                title += " cita(s) no se lllevaron a cabo";
                            }else if(item.asistencia == 3){
                                title += " cita(s) de primera vez se llevaron a cabo";
                            }

                            var event = {
                                url: "#" + "",
                                payload: item,
                                title: title,
                                end: item.fecha,
                                start: item.fecha,
                                id: "",
                                color: item.color
                            };
                            

                            /*var actionsTemplate = _.template($('#modal_detalle_evento').text());
                            $('#modalsEventos').append(actionsTemplate(item));*/
                            events.push(event);
                        });
                        callback(events);
                    } else {
                        error(response.mensaje);
                    }
                }, error: function (response) {
                    error(response.responseJSON.mensaje);
                     $("#wait").hide();
                },
                complete: function () {
                    $("#wait").hide();
                }
            });
        },
        eventClick: function(calEvent, jsEvent, view) {
            getDetalle(calEvent.payload.fecha, calEvent.payload.asistencia);
        }
    });
});

function getDetalle(fechaCita,asistenciaCita) {
    $.ajax({
       url: APP_URL + 'class/Calendario.php',
        type: 'POST',
        data: {
            get: 'reporteEventosDetalle',
            fecha : fechaCita,
            asistencia : asistenciaCita
        },
        beforeSend: function () {
            $("#wait").show();
        },
        success:function(response){
            $("#modal-detalleReporteCita").modal().show();
            response = JSON.parse(response);
            if(response.estado == "1"){
                var detalle = response.detalle;
                var rows = "";
                
                detalle.forEach(function(cita){
                    var paterno = "";
                    var materno = "";
                    if(cita.apPaterno != null){
                        paterno = cita.apPaterno;
                    }
                    if(cita.apMaterno != null){
                        materno = cita.apMaterno;
                    }
                    rows += "<tr><td>"+cita.fecha+"</td>";
                    rows += "<td>"+cita.hora_ini+"</td>";
                    rows += "<td>"+cita.nombre + " " + paterno + " " + materno +"</td></tr>";
                });

                $("#detalleCita").html(rows); 
            }
            
        }, error: function (response) {
            error(response.responseJSON.mensaje);
            $("#wait").hide();
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