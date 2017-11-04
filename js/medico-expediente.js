/**
 * Created by rk521 on 25.03.17.
 */
var id = null;
$().ready(function () {
    // Si recibe un usuario por 'get'
    if (window.location.hash !== '') {
        var hash_num = parseInt(window.location.hash.substring(1));
        if (hash_num > 0) {
            if (hash_num) {
                loadPaciente(hash_num);
            }
        }
    }

    $("#crear_presupuesto").click(function () {
        
        nuevoPresupuesto();
        event.preventDefault();
    });

    $("#btn_nueva_observacion").click(function () {
        event.preventDefault();
        addObservacion();
    });

    $("#actualizar_info_btn").click(function () {
        event.preventDefault();
        updateAntecedentes();
    });

    $("#btn_nuevo_documento").click(function () {
        uploadDocument();
    });

    $("#agregar_otro_documento").click(function () {
        uploadOtherDocument();
    });

    $("#actualizar_porcentajes_btn").click(function () {
        updatePorcentaje();
    });

    $("#tipo_documento").on('change', function () {
        switch (this.value) {
            case 1:
                openDocs();
                break;
            case "1":
                openDocs();
                break;
            case 2:
                openDocs();
                break;
            case "2":
                openDocs();
                break;
            case 3:
                openOtherDocs();
                break;
            case "3":
                openOtherDocs();
                break;
        }
    });

    $('#progressbox').hide();

    $("#transferir_medico_nombre").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: APP_URL + 'class/Medico.php',
                type: 'POST',
                data: {
                    get: 'searchMedicos',
                    search: $("#transferir_medico_nombre").val()
                },
                dataType: "JSON",
                success: function (data) {
                    response($.map(data.medicos, function (el) {
                        //return el.id + " - " + el.apPaterno + " " + el.nombre;
                        return {
                            label: el.nombre + " " + el.apPaterno,
                            value: el.nombre + " " + el.apPaterno,
                            id: el.id,
                            nombre: el.nombre,
                            apellido: el.apellido
                        };
                    }));
                }
            });
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        delay: 1000,
        select: function( event, ui ) {
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.value );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( "" );
            $("#transferir_medico_id").val(ui.item.id);
            return false;
        }
    });
    
    $("#transferir_paciente_btn").click(function () {
        transferirParciente();
    });
});

function transferirParciente() {
    $.ajax({
        url: APP_URL + 'class/Medico.php',
        type: 'POST',
        data: {
            get: 'transferirPaciente',
            paciente_id: $("#transferir_paciente_id").val(),
            medico_id: $("#transferir_medico_id").val()
        },
        dataType: "JSON",
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            if (response.estado == 1) {
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-success"> &nbsp; ' + response.mensaje + '</div>');
                });

                window.location.href = APP_URL + "mis_pacientes";
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
        },
        complete: function () {
            $("#wait").hide();
        }
    });
}

function openDocs() {
    if (!$("#docs1").is(":visible")) {
        $("#docs1").slideToggle(500);
        $("#docs2").slideUp(500);
    }
}

function openOtherDocs() {
    if (!$("#docs2").is(":visible")) {
        $("#docs1").slideUp(500);
        $("#docs2").slideToggle(500);
    }
}

function loadPaciente(id) {
    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Medico.php',
        data: {
            get: 'getExpediente1',
            id: id
        },
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
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
                nombre = nombre + " - " + paciente.id

                $("#header").html('<h2 style="display:inline;" class="title_header">' + nombre + '</h2>');

                // Informacion del paciente
                var domicilio = "", ocupacion = "", fecha_nacimiento = "", edad = "", created_at = "";
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

                $("#info").html("<strong>Dirección</strong>: " + domicilio + "<br><strong>Ocupación</strong>: " + ocupacion +
                    "<br><strong>Fecha de Nacimiento</strong>: " + fecha_nacimiento + "<br><strong>Edad</strong>: " + edad +
                    "<br><br>Agregado</strong>: " + created_at);

                // Contacto
                var telefono = "", telefono2 = "", email = "", nombreFamiliar = "", telefonoFamiliar = "";
                if (paciente.telefono) {
                    telefono = paciente.telefono;
                }

                if (paciente.telefono2) {
                    telefono2 = paciente.telefono2;
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

                $("#contacto").html("<strong>Teléfono</strong>: " + telefono + "<br><strong>Teléfono 2</strong>: " + telefono2 + "<br><strong>Email</strong>: " + email +
                    "<br><strong>Nombre de Familiar</strong>: " + nombreFamiliar + "<br><strong>Teléfono de Familiar</strong>: " + telefonoFamiliar);

                var table = document.getElementById("historial");
                for (var i = table.rows.length - 1; i > 0; i--) {
                    table.deleteRow(i);
                }

                table = document.getElementById("admon_table");
                for (var i = table.rows.length - 1; i > 0; i--) {
                    table.deleteRow(i);
                }
                response.historial.forEach(function (presupuesto) {
                    var sesiones = "", last_date = "", porcentaje_operacion = "";
                    if (presupuesto.numero_sesiones) {
                        sesiones = presupuesto.numero_sesiones;
                    }

                    if (presupuesto.last_date) {
                        last_date = presupuesto.last_date;
                    }

                    if (presupuesto.porcentaje_operacion) {
                        porcentaje_operacion = presupuesto.porcentaje_operacion;
                    }

                    $('#historial tr:last').after('<tr>' +
                        '<td>' + presupuesto.nombre + '</td>' +
                        '<td>' + sesiones + '</td>' +
                        '<td>' + last_date + '</td>' +
                        '<td>' + presupuesto.porcentajePagado + '%</td>' +
                        '</tr>');

                    // Administración
                    $('#admon_table tr:last').after('<tr>' +
                        '<td>' + presupuesto.nombre + '</td>' +
                        '<td>' + presupuesto.porcentajePagado + '%</td>' +
                        '<td>' + presupuesto.porcentajeRestante + '%</td>' +
                        '<td id="porcentaje_tbl_' + presupuesto.id + '">' + porcentaje_operacion + '</td>' +
                        '<td><div class="btn-group form-group">' +
                        '<button type="button" class="btn btn-default">Opciones</button>' +
                        '<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                        '<span class="caret"></span>' +
                        '<span class="sr-only">Toggle Dropdown</span>' +
                        '</button>' +
                        '<ul class="dropdown-menu">' +
                        '<li><a href="#' + id + '" onclick="modificarPorcentaje(' + presupuesto.id + ', ' + porcentaje_operacion + ');">Modificar Porcentajes</a></li>' +
                        '<li><a href="#' + id + '" onclick="openTransferirParciente(' + id + ', ' + porcentaje_operacion + ');">Transferir</a></li>' +
                        '<li><a href="#" onclick="event.preventDefault(); openGenerarCita(' + presupuesto.id + ')">Generar Cita</a></li>' +
                        '<li role="separator" class="divider"></li>' +
                        '<li><a href="#" onclick="event.preventDefault(); deletePresupuesto('+ presupuesto.id +', '+ id + ')">Eliminar Presupuesto</a></li>' +
                        '</ul>' +
                        '</div></td>' +
                        '</tr>');
                });

                // antecedentes
                if (response.antecedentes.length > 0) {
                    var a = response.antecedentes[0];
                    $("#quirurgicos_div").append(a.quirurgicos);
                    $("#alergicos_div").append(a.alergicos);
                    $("#anestesia_div").append(a.anestecia);
                    $("#padecimientos_div").append(a.padecimientos);
                    $("#medicamentos_div").append(a.medicamentos);
                    $("#tabaquismo_div").append(a.tabaquismo);
                    $("#otros_div").append(a.otro);

                    $("#quirurgicos_txt").val(a.quirurgicos);
                    $("#alergicos_txt").val(a.alergicos);
                    $("#anestesia_txt").val(a.anestecia);
                    $("#padeceimientos_txt").val(a.padecimientos);
                    $("#medicamentos_txt").val(a.medicamentos);
                    $("#tabaquismo_txt").val(a.tabaquismo);
                    $("#otros_txt").val(a.otro);
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
        },
        complete: function () {
            $("#wait").hide();
        }
    });
}

function openTransferirParciente(paciente_id) {
    $("#modalTransferirPaciente").modal().toggle();
    $("#transferir_paciente_id").val(paciente_id);
}

function modificarPorcentaje(presupuesto_id, porcentaje) {
    $("#modalPorcentajes").modal().toggle();
    $("#pocentajes_id_txt").val(presupuesto_id);
    $("#porcentajes_txt").val(porcentaje);
}

function updatePorcentaje() {
    var presupuesto_id = $("#pocentajes_id_txt").val();
    var porcentaje = $("#porcentajes_txt").val();

    if (porcentaje && presupuesto_id) {
        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Medico.php',
            data: {
                get: 'updatePorcentajeOperacion',
                presupuesto_id: presupuesto_id,
                porcentaje: porcentaje
            },
            beforeSend: function () {
                $("#wait").show();
            },
            success: function (response) {
                response = JSON.parse(response);

                if (response.estado == 1) {
                    $("#error").fadeIn(1000, function () {
                        $("#error").html('<div class="alert alert-success"> &nbsp; ' + response.mensaje + '</div>');
                    });

                    $('#porcentaje_tbl_' + presupuesto_id).html(porcentaje);
                    $('#modalPorcentajes').modal('toggle');
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
            },
            complete: function () {
                $("#wait").hide();
            }
        });
    }
}

function deletePresupuesto(id, user_id) {
    var r = confirm("¿Deseas eliminar el presupuesto?");
    if (r === true) {
        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Medico.php',
            data: {
                get: 'deletePresupuesto',
                id: id
            },
            beforeSend: function () {
                $("#wait").show();
            },
            success: function (response) {
                response = JSON.parse(response);

                if (response.estado == 1) {
                    $("#error").fadeIn(1000, function () {
                        $("#error").html('<div class="alert alert-success"> &nbsp; ' + response.mensaje + '</div>');
                    });
                } else {
                    $("#error").fadeIn(1000, function () {
                        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                    });
                }

                loadPaciente(user_id);
            },
            error: function (response) {
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            },
            complete: function () {
                $("#wait").hide();
            }
        });
    }
}

function openGenerarCita(id) {
    $("#generarCita").modal("show");
}

function loadPresupuestos() {
    if (window.location.hash !== '') {
        var hash_num = parseInt(window.location.hash.substring(1));
        if (hash_num > 0) {
            if (hash_num) {
                $.ajax({
                    type: 'POST',
                    url: APP_URL + 'class/Medico.php',
                    data: {
                        get: 'getExpediente2',
                        id: hash_num
                    },
                    beforeSend: function () {
                        $("#wait").show();
                    },
                    success: function (response) {
                        response = JSON.parse(response);

                        if (response.estado == 1) {
                            response.presupuestos.forEach(function (presupuesto) {
                                var type = "", classType = '<div class="panel ', types = "presupuesto";

                                if (presupuesto.cirugia == 1) {
                                    type = "panel-success";
                                    types = types + " cirgua";
                                }

                                if (presupuesto.tratamiento == 1) {
                                    type = "panel-info";
                                    types = types + " tratamiento";
                                }

                                if (presupuesto.caducado == 1) {
                                    type = "panel-danger";
                                    types = types + " caducado";
                                }

                                if (presupuesto.no_iniciado == 1) {
                                    type = "panel-default";
                                    types = types + " no_iniciado";
                                }

                                var tipo = "";
                                if (presupuesto.tipo == 1) {
                                    tipo = "Tratamiento";
                                }

                                if (presupuesto.tipo == 2) {
                                    tipo = "Cirugia";
                                }

                                classType = classType + type + ' form-group">';

                                var descripcion = "", precio = "", promocion = "", contado = "", vigencia = "";
                                if (presupuesto.descripcion) {
                                    descripcion = presupuesto.descripcion;
                                }
                                if (presupuesto.precio) {
                                    precio = presupuesto.precio;
                                }
                                if (presupuesto.promocion) {
                                    promocion = presupuesto.promocion;
                                }
                                if (presupuesto.contado) {
                                    contado = presupuesto.contado;
                                }
                                if (presupuesto.vigencia) {
                                    vigencia = presupuesto.vigencia;
                                }

                                $("#prespuestos").html("");
                                $("#prespuestos").append(
                                    '<div class="col-md-6 ' + types + '">' +
                                    classType +
                                    '<div class="panel-heading">' +
                                    '<h3 class="panel-title"><b>' + presupuesto.nombre + '</b></h3>' +
                                    '' + tipo + ' - @NUM_SESIONES / @NUM_CONSULTAS' +
                                    '</div>' +
                                    '<div class="panel-body">' +
                                    'Descripción: ' + descripcion +
                                    '<hr>' +
                                    'Precio Normal: ' + precio +
                                    '<br>' +
                                    'Precio Promoción: ' + promocion +
                                    '<br>' +
                                    'Precio Contado: ' + contado +
                                    '</div>' +
                                    '<div class="panel-footer">' +
                                    'Creado: ' +
                                    '<br>' +
                                    'Vigencia: ' + vigencia +
                                    '</div>' +
                                    '</div>' +
                                    '</div>'
                                );
                            });
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
                    },
                    complete: function () {
                        $("#wait").hide();
                    }
                });
            }
        }
    }
}

function loadObservaciones() {
    if (window.location.hash !== '') {
        var hash_num = parseInt(window.location.hash.substring(1));
        if (hash_num > 0) {
            if (hash_num) {
                $.ajax({
                    type: 'POST',
                    url: APP_URL + 'class/Medico.php',
                    data: {
                        get: 'getExpediente3',
                        id: hash_num
                    },
                    beforeSend: function () {
                        $("#wait").show();
                    },
                    success: function (response) {
                        response = JSON.parse(response);

                        if (response.estado == 1) {
                            // Observaciones
                            if (response.observaciones.length > 0 ) {
                                $("#observaciones_table").html("");
                                response.observaciones.forEach(function (observacion) {
                                    var nombre = observacion.nombre;
                                    if (observacion.apPaterno) {
                                        nombre = nombre + " " + observacion.apPaterno;
                                    }

                                    if (observacion.apPaterno) {
                                        nombre = nombre + " " + observacion.apMaterno;
                                    }
                                    $("#observaciones_table").append(
                                        '<div class="well">' +
                                        observacion.observacion +
                                        '<hr class="gradient">' +
                                        'Agregado por ' + nombre + ' el día ' + observacion.created_at +
                                        '</div>'
                                    )
                                });
                            } else {
                                $("#observaciones_table").html('<div class="well">Aún no se han agregado observaciones</div>');
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
                    },
                    complete: function () {
                        $("#wait").hide();
                    }
                });
            }
        }
    }
}

function nuevoPresupuesto() {
    if (window.location.hash !== '') {
        var hash_num = parseInt(window.location.hash.substring(1));
        if (hash_num > 0) {
            if (hash_num) {
                if (!validaNuevoPresupuesto()) {
                    $("#error").fadeIn(1000, function () {
                        $("#error").html('<div class="alert alert-danger"> &nbsp; Todos los campos son obligatorios</div>');
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: APP_URL + 'class/Medico.php',
                        data: {
                            get: 'addPresupuesto',
                            user_id: hash_num,
                            nombre: $("#nombre_presupuesto").val(),
                            tipo: $("#tipo_presupuesto").val(),
                            descripcion: $("#descripcion_presupuesto").val(),
                            numero_sesiones: $("#numero_citas").val(),
                            precio: $("#precio_normal").val(),
                            promocion: $("#precio_promocion").val(),
                            contado: $("#precio_contado").val(),
                            vigencia: $("#fecha").val()
                        },
                        beforeSend: function () {
                            $("#wait").show();
                        },
                        success: function (response) {
                            response = JSON.parse(response);
                            if (response.estado == 1) {
                                $("#error").fadeIn(1000, function () {
                                    $("#error").html('<div class="alert alert-success"> &nbsp; ' + response.mensaje + '</div>');
                                });

                                cleanFormPresupuesto();
                            } else {
                                $("#error").fadeIn(1000, function () {
                                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                                });
                            }
                        },
                        error: function (response) {
                            response = JSON.parse(response);
                            $("#error").fadeIn(1000, function () {
                                $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                            });
                        },
                        complete: function () {
                            $("#wait").hide();
                        }
                    });
                }
            }
        }
    }
}

function validaNuevoPresupuesto() {
    return !(!$("#nombre_presupuesto").val() || !$("#tipo_presupuesto").val() || !$("#descripcion_presupuesto").val()
        || !$("#numero_citas").val() || !$("#precio_normal").val() || !$("#precio_promocion").val()
        || !$("#precio_contado").val() || !$("#fecha").val());
}

function cleanFormPresupuesto() {
    $("#nombre_presupuesto").val("");
    $("#tipo_presupuesto").val("");
    $("#descripcion_presupuesto").val("");
    $("#numero_citas").val("");
    $("#precio_normal").val("");
    $("#precio_promocion").val("");
    $("#precio_contado").val("");
    $("#fecha").val("");
}

function filtrar(type) {
    $(".presupuesto").css('display', 'none');

    switch (type) {
        case 1:
            $(".presupuesto").show();
            break;
        case 2:
            $(".tratamiento").show();
            break;
        case 3:
            $(".cirgua").show();
            break;
        case 4:
            $(".no_iniciado").show();
            break;
        case 5:
            $(".caducado").show();
            break;
    }
}

function addObservacion() {
    if (window.location.hash !== '') {
        var hash_num = parseInt(window.location.hash.substring(1));
        if (hash_num > 0) {
            if (hash_num) {
                $.ajax({
                    type: 'POST',
                    url: APP_URL + 'class/Medico.php',
                    data: {
                        get: 'addObservacion',
                        paciente_id: hash_num,
                        observacion: $("#nueva_observacion").val()
                    },
                    beforeSend: function () {
                        $("#wait").show();
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        if (response.estado == 1) {
                            $("#error").fadeIn(1000, function () {
                                $("#error").html('<div class="alert alert-success"> &nbsp; ' + response.mensaje + '</div>');
                            });

                            $("#nueva_observacion").val("");
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
                    },
                    complete: function () {
                        $("#wait").hide();
                        loadObservaciones();
                    }
                });
            }
        }
    }
}

function updateAntecedentes() {
    if (window.location.hash !== '') {
        var hash_num = parseInt(window.location.hash.substring(1));
        if (hash_num > 0) {
            if (hash_num) {
                $.ajax({
                    type: 'POST',
                    url: APP_URL + 'class/Medico.php',
                    data: {
                        get: 'updateAntecedentes',
                        paciente_id: hash_num,
                        quirurgicos: $("#quirurgicos_txt").val(),
                        alergicos: $("#alergicos_txt").val(),
                        //anestecia: $("#").val(),
                        padecimientos: $("#padeceimientos_txt").val(),
                        medicamentos: $("#medicamentos_txt").val(),
                        tabaquismo: $("#tabaquismo_txt").val(),
                        otro: $("#otros_txt").val()
                    },
                    beforeSend: function () {
                        $("#wait").show();
                    },
                    success: function (response) {
                        response = JSON.parse(response);
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
                    error: function (response) {
                        $("#error").fadeIn(1000, function () {
                            $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                        });
                    },
                    complete: function () {
                        $("#wait").hide();
                    }
                });
            }
        }
    }
}

function uploadDocument() {
    $('#progressbar').width('0%'); //update progressbar percent complete
    $('#statustxt').html('0%');
    var fsize = $('#buscar_documento')[0].files[0].size;
    if (fsize > 2097152) {
        event.preventDefault();
        $("#error").fadeIn(1000, function () {
            $("#error").html('<div class="alert alert-danger"> &nbsp; Tamaño máximo 2mb</div>');
        });
    } else {

        var ftype = $('#buscar_documento')[0].files[0].type;

        switch (ftype) {
            case 'image/png':
            case 'image/gif':
            case 'image/jpeg':
            case 'image/pjpeg':
            case 'text/plain':
            case 'text/html':
            case 'application/x-zip-compressed':
            case 'application/pdf':
            case 'application/msword':
            case 'application/vnd.ms-excel':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
            case 'application/vnd.ms-powerpoint':
            case 'application/vnd.oasis.opendocument.spreadsheet':
            case 'application/vnd.oasis.opendocument.presentation':
                break;
            default:
                event.preventDefault();
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; Archivo no soportado</div>');
                });
                return false;
        }

        if (window.location.hash !== '') {
            var hash_num = parseInt(window.location.hash.substring(1));
            if (hash_num > 0) {
                if (hash_num) {
                    $("form#uploadDocument").submit(function () {
                        $("#error").fadeIn(1000, function () {
                            $("#error").html("");
                        });

                        var formData = new FormData($(this)[0]);
                        formData.append('get', "uploadFile");
                        formData.append('paciente_id', hash_num);

                        $.ajax({
                            url: APP_URL + 'class/Medico.php',
                            type: 'POST',
                            data: formData,
                            beforeSend: function () {
                                $('#progressbox').show();
                            },
                            success: function (data) {
                                data = JSON.parse(data);
                                if (data.estado == 1) {
                                    $("#error").fadeIn(1000, function () {
                                        $("#error").html('<div class="alert alert-success"> &nbsp; ' + data.mensaje + '</div>');
                                    });

                                    $('#uploadDocument')[0].reset();
                                    getDocuments();
                                }
                                else {
                                    $("#error").fadeIn(1000, function () {
                                        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + data.mensaje + '</div>');
                                    });
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            xhr: function () {
                                var xhr = $.ajaxSettings.xhr();
                                xhr.upload.onprogress = function (evt) {
                                    var percentComplete = evt.loaded / evt.total * 100;
                                    $('#progressbox').show();
                                    $('#progressbar').width(percentComplete + '%'); //update progressbar percent complete
                                    $('#statustxt').html(percentComplete + '%'); //update status text
                                    if (percentComplete > 50) {
                                        $('#statustxt').css('color', '#000'); //change status text to white after 50%
                                    }
                                };
                                xhr.upload.onload = function () {

                                };
                                return xhr;
                            },
                            error: function () {
                                $("#error").fadeIn(1000, function () {
                                    $("#error").html('<div class="alert alert-danger"> &nbsp; Ocurrio un error al cargar el archivo. Code: 0</div>');
                                });
                            },
                            complete: function () {
                                $("#wait").hide();
                            }
                        });
                        return false;
                    });
                }
            }
        }
    }
}

function uploadOtherDocument() {
    $('#progressbar').width('0%'); //update progressbar percent complete
    $('#statustxt').html('0%');
    var fsize = $('#buscar_otro_documento')[0].files[0].size;
    if (fsize > 2097152) {
        event.preventDefault();
        $("#error").fadeIn(1000, function () {
            $("#error").html('<div class="alert alert-danger"> &nbsp; Tamaño máximo 2mb</div>');
        });
    } else {

        var ftype = $('#buscar_otro_documento')[0].files[0].type;

        switch (ftype) {
            case 'image/png':
            case 'image/gif':
            case 'image/jpeg':
            case 'image/pjpeg':
            case 'text/plain':
            case 'text/html':
            case 'application/x-zip-compressed':
            case 'application/pdf':
            case 'application/msword':
            case 'application/vnd.ms-excel':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
            case 'application/vnd.ms-powerpoint':
            case 'application/vnd.oasis.opendocument.spreadsheet':
            case 'application/vnd.oasis.opendocument.presentation':
                break;
            default:
                event.preventDefault();
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; Archivo no soportado</div>');
                });
                return false;
        }

        if (window.location.hash !== '') {
            var hash_num = parseInt(window.location.hash.substring(1));
            if (hash_num > 0) {
                if (hash_num) {
                    $("form#uploadOtroDocument").submit(function () {
                        $("#error").fadeIn(1000, function () {
                            $("#error").html("");
                        });

                        var formData = new FormData($(this)[0]);
                        formData.append('get', "uploadOtherFile");
                        formData.append('paciente_id', hash_num);

                        $.ajax({
                            url: APP_URL + 'class/Medico.php',
                            type: 'POST',
                            data: formData,
                            beforeSend: function () {
                                $('#progressbox').show();
                            },
                            success: function (data) {
                                data = JSON.parse(data);
                                if (data.estado == 1) {
                                    $("#error").fadeIn(1000, function () {
                                        $("#error").html('<div class="alert alert-success"> &nbsp; ' + data.mensaje + '</div>');
                                    });

                                    $('#uploadOtroDocument')[0].reset();
                                    getDocuments();
                                }
                                else {
                                    $("#error").fadeIn(1000, function () {
                                        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + data.mensaje + '</div>');
                                    });
                                }
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            xhr: function () {
                                var xhr = $.ajaxSettings.xhr();
                                xhr.upload.onprogress = function (evt) {
                                    var percentComplete = evt.loaded / evt.total * 100;
                                    $('#progressbox').show();
                                    $('#progressbar').width(percentComplete + '%'); //update progressbar percent complete
                                    $('#statustxt').html(percentComplete + '%'); //update status text
                                    if (percentComplete > 50) {
                                        $('#statustxt').css('color', '#000'); //change status text to white after 50%
                                    }
                                };
                                xhr.upload.onload = function () {

                                };
                                return xhr;
                            },
                            error: function () {
                                $("#error").fadeIn(1000, function () {
                                    $("#error").html('<div class="alert alert-danger"> &nbsp; Ocurrio un error al cargar el archivo. Code: 0</div>');
                                });
                            },
                            complete: function () {
                                $("#wait").hide();
                            }
                        });
                        return false;
                    });
                }
            }
        }
    }
}

function getDocuments() {
    if (window.location.hash !== '') {
        var hash_num = parseInt(window.location.hash.substring(1));
        if (hash_num > 0) {
            if (hash_num) {
                $.ajax({
                    type: 'POST',
                    url: APP_URL + 'class/Medico.php',
                    data: {
                        get: 'getDocuments',
                        id: hash_num
                    },
                    beforeSend: function () {
                        $("#wait").show();
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        if (response.estado == 1) {
                            var table = document.getElementById("tbl_documents");
                            for (var i = table.rows.length - 1; i > 0; i--) {
                                table.deleteRow(i);
                            }

                            response.documentos.forEach(function (d) {
                                var nombre = "";
                                if (d.nombre) { nombre = d.nombre; }
                                if (d.apPaterno) { nombre = nombre + " " + d.apPaterno; }
                                if (d.apMaterno) { nombre = nombre + " " + d.apMaterno; }

                                $('#tbl_documents tr:last').after('<tr>' +
                                    '<td><a href="' + d.url + '" target="_blank">' + d.nombre_expediente + '</a></td>' +
                                    '<td>' + d.expediente + '</td>' +
                                    '<td>' + d.descripcion + '</td>' +
                                    '<td>' + nombre + '</td>' +
                                    '<td><td align="center"><a onclick="deleteFile(' + d.id + ');"><span class="glyphicon glyphicon-remove"></span></a></td></td>' +
                                    '</tr>');
                            })
                        }
                        else {
                            $("#error").fadeIn(1000, function () {
                                $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                            });
                        }
                    },
                    error: function (response) {
                        $("#error").fadeIn(1000, function () {
                            $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                        });
                    },
                    complete: function () {
                        $("#wait").hide();
                    }
                });
            }
        }
    }
}

function deleteFile(id) {
    var r = confirm("¿Realmente deseas eliminar el archivo?");
    if (r === true) {
        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Medico.php',
            data: {
                get: 'deleteFile',
                id: id
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.estado == 1) {
                    $("#error").fadeIn(1000, function () {
                        $("#error").html('<div class="alert alert-success"> &nbsp; ' + response.mensaje + '</div>');
                    });

                    getDocuments();
                }
                else {
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

/*
 * Este método es más rápido que loadPresupuestos, ya que solo devuelve los nombres
 */
function loadPresupuestosFaster() {
    $('#select_presupuesto')
        .find('option')
        .remove()
        .end();

    if (window.location.hash !== '') {
        var hash_num = parseInt(window.location.hash.substring(1));
        if (hash_num > 0) {
            if (hash_num) {
                $.ajax({
                    type: 'POST',
                    url: APP_URL + 'class/Pagos.php',
                    data: {
                        get: 'getPresupuestos',
                        id: hash_num
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        if (response.estado == 1) {
                            response.presupuestos.forEach(function (presupuesto) {
                                $('#select_presupuesto').append($('<option>', {
                                    value: presupuesto.id,
                                    text : presupuesto.nombre
                                }));
                            })
                        }
                        else {
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
    }
}

/**
 * [cargarDocumentos a partir del expediente master]
 * Se dispara en el evenvto onchange
 */
function cargarDocumentos(){
    var tipoDoc= $("#tipo_documento").val();
    $.ajax({
            type: 'POST',
            url: APP_URL + 'controladores/utilidades/funciones/func_option_select.php',
            data: {
                'post': 'Mostrar_Nombre_Documentos',
                'tipo_expediente': tipoDoc
            },
            success: function (response) {
                $("#nombre_documento").html(response);
            },
            error: function (response) {
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; Ocurrio algo inesperado</div>');
                });
            }
        });
    
    nombre_documento
}