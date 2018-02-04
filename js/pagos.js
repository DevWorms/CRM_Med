/**
 * Created by rk521 on 25.03.17.
 */

var id = null;
$(document).ready(function() {
    /******************
     * PAGOS VERSION 1
     *****************/
    if (!$("#user_id").val()) {
        enableFormNvoPresupuesto(false);
        enableFormNvoPago(false);
    }

    $("#busqueda").click(function () {
        getPaciente();
    });

    // Buscador de pacientes
    $("#param").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                post: 'autoSearch',
                url  : APP_URL + 'class/Paciente.php',
                data : {
                    post: 'allSearch',
                    param: $("#param").val()
                },
                success: function (data) {
                    data = JSON.parse(data);
                    response($.map(data.pacientes, function (el) {
                        return el.id + " - " + el.apPaterno + " " + el.nombre;
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
            $("#paciente_id").val(ui.item.value.split("-")[0].trim());
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

    // Agregar pago click
    $("form#form-crearPago").submit(function() {
        if (!$("#orden_pago") || !$("#monto") || !$("#concepto") || !$("#fecha")) {
            $("#error").fadeIn(1000, function() {
                $("#error").html('<div class="alert alert-danger"> &nbsp; Completa los campos requeridos</div>');
            });
            return false;
        }

        $("#error").fadeIn(1000, function() {
            $("#error").html("");
        });

        var formData = new FormData($(this)[0]);
        formData.append('get', 'addPago');
        formData.append('user_id', $("#user_id").val());
        formData.append('fecha', $("#fechaAbierta").val());
        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Pagos.php',
            data: formData,
            dataType: 'json',
            success: function (data) {
                if (data.estado == 1) {
                    $.notify(data.mensaje, "succes");
                    cleanFormNvoPago()
                } else {
                    $.notify(data.mensaje, "error");
                }
            },
            cache: false,
            contentType: false,
            processData: false,
            error : function (response) {
                response = response.responseJSON;
                $("#error").fadeIn(1000, function() {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }
        });
        return false;
    });

    // Agregar presupuesto click
    $("form#nuevoPresupuesto").submit(function() {
        var formData = new FormData($(this)[0]);
        formData.append('get', 'addPresupuesto');
        formData.append('user_id', $("#user_id").val());

        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Pagos.php',
            data: formData,
            dataType: 'json',
            success: function (data) {
                if (data.estado == 1) {
                    $.notify(data.mensaje, "success");
                    loadPresupuestos($("#user_id").val());
                } else {
                    $.notify(data.mensaje, "error");
                }
            },
            cache: false,
            contentType: false,
            processData: false,
            error : function (response) {
                response = response.responseJSON;
                $("#error").fadeIn(1000, function() {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }
        });
        return false;
    });

/******************
 * PAGOS VERSION 2
 *****************/

 //BUSCADOR Y SELECTOR DE PACIENTE 
 $("#paciente_Pagos").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                post: 'autoSearch',
                url  : APP_URL + 'class/Paciente.php',
                data : {                    post: 'allSearch',
                    param: $("#paciente_Pagos").val()
                },
                success: function (data) {
                    data = JSON.parse(data);
                    response($.map(data.pacientes, function (el) {
                        return el.id + " - " + el.apPaterno + " " + el.nombre;
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
            $("#paciente_id").val(ui.item.value.split("-")[0].trim());
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
  // BUSCADOR Y SELECTOR DE MEDICO QUE SOLICITE
$("#searchMed").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                post: 'autoSearch',
                url  : APP_URL + 'class/Usuarios.php',
                data : {
                    get: 'getMedicosSearch',
                    param: $("#searchMed").val()
                },
                success: function (data) {
                    data = JSON.parse(data);
                    response($.map(data.medicos, function (el) {
                        return el.id + " - " + el.apPaterno + " " + el.nombre;
                    }));
                },error:function(error){
                    console.log(error);
                }
            });
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        delay: 300,
        select: function( event, ui ) {
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.value );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( "" );
            var medico = ui.item.value.split(" - ")[0];
            $("#medico").val(medico);
            return false;
        }
    });

    // generar informacion y presupuesto del paciente
    $("#btn-paciente").click(function(){
        obtenerPaciente();
    });

    $("#validateOrden").click(function () { 
        getPagosPorConfirmar();
    });

    // BOTONES DE LOS MODALS
    $("#confirmar-pago").click(function (e) { 
        e.preventDefault();
        confirmarPago();
    });
    $("#eliminar-pago").click(function (e) { 
        e.preventDefault();
        eliminarPago();
    });
});

/******************
 * PAGOS VERSION 1
 *****************/
function getPaciente() {
    if ($("#param").val()) {
        var id = String($("#param").val()).split(" - ");
        id = id[0];

        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Paciente.php',
            data: {
                get: 'paciente',
                id: id
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.estado == 1) {
                    var paciente = response.paciente[0];
                    $("#user_id").val(paciente.id);
                    // Activa los forms
                    enableFormNvoPresupuesto(true);
                    // Carga los presupuestos
                    loadPresupuestos(paciente.id);
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

function loadPresupuestos(id) {
    $('#mostrar_presup, #selec_presup')
        .find('option')
        .remove()
        .end();

    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Pagos.php',
        data: {
            get: 'getPresupuestos',
            id: id
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                response.presupuestos.forEach(function (presupuesto) {
                    $('#mostrar_presup, #selec_presup').append($('<option>', {
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






/******************
 * PAGOS VERSION 2
 *****************/

/* CheckBox Selección */

function Mostrar(){
    document.getElementById("financi_seleci").style.display = "block";
}
function Ocultar(){
    document.getElementById("financi_seleci").style.display = "none";
}
function Mostrar_Ocultar_Pago(){
    var caja = document.getElementById("financi_seleci");
    if (caja.style.display == "none") {
        Mostrar();
    }else{
        Ocultar();
    }
}

function mostrarDescripcion(descripcion){
    $("#review_paciente").html(descripcion);
}

function obtenerPresupuesto(id){

    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Pagos.php',
        data: {
            get: 'getPresupuestos',
            'id': id
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                var contenido = "<option value='0'>Seleccionar presupuesto</option>";
                var presupuestos = 0;
                response.presupuestos.forEach(function (presupuesto) {
                    contenido+= "<option value='" + presupuesto.id + "'>" + presupuesto.nombre;
                    contenido += "- $ " + presupuesto.precio + "</option>";;
                    presupuestos++;
                });

                if(presupuestos <= 0){
                   contenido = "<option value='0'>Sin presupuestos</option>";
                }
                $("#Proce_Produ").html(contenido);
                $("#Proce_Produ").slideDown(350);
                
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

function obtenerPaciente() {
    if ($("#paciente_id").val()) {
        var id = $("#paciente_id").val();

        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Paciente.php',
            data: {
                get: 'paciente',
                'id': id
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.estado == 1) {
                    var paciente = response.paciente[0];
                    var contenido = "<p style='font-size:95%'>";
                    contenido += "Nombre "+ paciente.nombre + " " + paciente.apPaterno + " " + paciente.apMaterno + "<br>";
                    contenido += "Telefono: " + paciente.telefono + "<br>";
                    contenido += "Folio: " + paciente.id;
                    contenido += "</p>"; 
                    mostrarDescripcion(contenido);
                    // Carga los presupuestos
                    obtenerPresupuesto(paciente.id);
                    enableFormNvoPago(true);
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
    }else{
        $.notify("Debes selecionar un paciente","info");
    }
}

function obtenerPagos(){
    if ($("#paciente_id").val() && $("#Proce_Produ").val() !=0) {
        var paciente = $("#paciente_id").val();
        var presupuesto = $("#Proce_Produ").val();
        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Pagos.php',
            data: {
                'get': 'getPagos',
                'paciente': paciente,
                'presupuesto' : presupuesto
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.estado == 1) {
                    // cantidad de resultados
                    var preContenido = "<h4> Ver tabla de pagos - Pagos efectuados: ";
                    preContenido+= response.no_pagos + " &nbsp;";
                    preContenido +="<i class='glyphicon glyphicon-circle-arrow-down'>";

                    $("#pre-tabla-pagos").html(preContenido);
                    $("#pre-tabla-pagos").slideDown(350);

                    var pagos = response.pagos;
                    var contenido = "";
                    pagos.forEach(function(pago){
                        contenido += "<tr>";
                        contenido += "<td>" + pago.fecha + "</td>";
                        contenido += "<td>" + pago.folio_anterior + "</td>";
                        contenido += "<td>" + pago.concepto + "</td>";
                        contenido += "<td> $" + pago.monto + "</td>";
                        contenido += "<td> $" + pago.resta + "</td>";
                        contenido += "<td>" + pago.forma_pago + "</td>";
                        contenido +="</tr>";
                    });

                    $("#tabla-pagos tbody").html(contenido);
                    $("#presupuesto").val(presupuesto);

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
    }else{
        $("#btn-imprimir").hide(350);
        $("#tabla-pagos").hide(350); 
        $("#pre-tabla-pagos").hide(350)
        $.notify("Debes selecionar un paciente y un presupuesto","info");
    } 
}

function mostrarTabla(){
    $("#btn-imprimir").slideToggle(350);
    $("#tabla-pagos").slideToggle(400);
}

function crearPago(){
    if ($("#paciente_id").val() && $("#Proce_Produ").val() !=0) {
    var datos = $("#form-crearPago").serialize();
    datos += "&get=crearPago";
    $.ajax({
            url: APP_URL + 'class/Pagos.php',
            type: 'POST',
            dataType: 'json',
            data: datos,
            beforeSend: function() {
                $("#wait").show();
                console.log(datos);
            },
            success: function(response) {
                if (response.estado == "1") {
                    $.notify(response.mensaje, "success");
                    obtenerPagos();
                    cleanFormNvoPago();
                } else {
                    $.notify(response.mensaje, "error");
                }
            }
        });
    }else {
        $.notify("Debes selecionar un paciente y un presupuesto","info");
    }
}

function enableFormNvoPresupuesto(estado) {
    if(estado) {
        $("#nuevoPresupuesto input").prop("disabled", false);
        $("#registrar").prop("disabled", false);
    } else {
        $("#nuevoPresupuesto input").prop("disabled", true);
        $("#registrar").prop("disabled", true);
    }
}

function enableFormNvoPago(estado) {
    if(estado) {
        $("#form-crearPago input").prop("disabled", false);
        $("#btn-nvopago").prop("disabled", false);
        $("#forma_pago").prop("disabled", false);
    } else {
        $("#form-crearPago input").prop("disabled", true);
        $("#btn-nvopago").prop("disabled", true);
        $("#forma_pago").prop("disabled", true);
    }
}

function cleanFormNvoPresupuesto() {
    $("#user_id").val("");
    $("#nuevoPresupuesto input").val("");
    enableFormNvoPresupuesto(false);
}
function cleanFormNvoPago() {
    $("#user_id").val("");
    $("#form-crearPago input").val("");
    $("#paciente_Pagos").val("");
    enableFormNvoPago(false);
}

function getPagosPorConfirmar() {
    /**
     *  SE OBTIENEN TODOS LOS PAGOS
     */
    if ($("#paciente_id").val()) {
        var idPaciente = $("#paciente_id").val();
        $("#por-confirmar").html('');
        $("#confirmados").html('');
        $("#no-confirmados").html('');
        $.ajax({
            type: "POST",
            url: APP_URL + 'class/Pagos.php',
            data: {
                idpaciente: idPaciente,
                get: "getPagosPaciente"
            },
            success: function (response) {
               response = JSON.parse(response);
               if (response.estado == "1") {
                   $.notify(response.mensaje, "success");
                   var pagos = response.pagos;
                   pagos.forEach(function (pago) {  
                       if(pago.revisado == 0) {
                        cardpagosPorConfirmar(pago);
                       }
                       if (pago.revisado == 1) {
                        cardPagosConfirmados(pago, pago.confirmado);
                       } 
                   });
               } else {
                   $.notify(response.mensaje, "error");
               }
            }
        });
    } else {
        $.notify("Debes selecionar un paciente","info");
    }
}
function cardpagosPorConfirmar(pago) {
    var contenido = '';
        contenido += '<div class="col-xs-10 col-xs-offset-1 caja-pago"><div class="col-xs-8">';
        contenido += '<div class="col-xs-6"><span class="caja-pago_label"># Recibo:</span><br>';
        contenido += '<span class="caja-pago_label">Nombre del Cliente:</span><br>';
        contenido += '<span class="caja-pago_label">Concepto:</span><br>';
        contenido += '<span class="caja-pago_label">Monto:</span><br>';
        contenido += '<span class="caja-pago_label">Financiamiento (Meses):</span></div>';
        contenido += '<div class="col-xs-6">';
        contenido += '<span >' + pago.id_pago + '</span><br>';
        contenido += '<span>' + pago.nombre + '</span><br>';
        contenido += '<span>' + pago.concepto +'</span><br>';
        contenido += '<span>$ ' + pago.monto + '</span><br>';
        contenido += '<span>' + pago.plan_financiamiento + ' MESES</span>';
        contenido += '</div>';
        contenido += '</div> <div class="col-xs-4"> <div class="row">';
        contenido += '<div class="col-xs-12" align="right">';
        contenido += '<span class="caja-pago_label">Fecha de Pago:</span><span> ' + pago.fecha + '</span></div></div>';
        contenido += '<div class="row" style="margin-top: 50px;"><div class="col-xs-6">';
        contenido += '<button class="btn btn-sm btn-block btn-success" data-toggle="modal" onclick="setId(' + pago.id_pago + ')"data-target="#modal-confirmar">Confirmar</button>';
        contenido += '</div><div class="col-xs-6">';
        contenido += '<button class="btn btn-sm btn-block btn-danger" data-toggle="modal" onclick="setId(' + pago.id_pago + ')" data-target="#modal-eliminar">Eliminar</button>';
        contenido += '</div></div></div></div>';
    $("#por-confirmar").append(contenido);
}

function cardPagosConfirmados(pago, estado) {
    var contenido = '';
    var label = '';
    var lbl_color = '';
    if (estado == 1) {
        lbl_color = "confirmado";
        label = 'CONFIRMADO';
        $("#confirmados").append(contenido);
    } else {
        lbl_color = "no-confirmado";
        label = 'NO CONFIRMADO';
        $("#no-confirmados").append(contenido);
    }
    contenido += '<div class="row"><div class="col-xs-10 col-xs-offset-1 caja-pago">';
    contenido += '<div class="col-xs-8"><div class="col-xs-6">';
    contenido += '<span class="caja-pago_label"># Recibo:</span><br>';
    contenido += '<span class="caja-pago_label">Nombre del Cliente:</span><br>';
    contenido += '<span class="caja-pago_label">Concepto:</span><br>';
    contenido += '<span class="caja-pago_label">Monto:</span><br>';
    contenido += '<span class="caja-pago_label">Financiamiento (Meses):</span></div>';
    contenido += '<div class="col-xs-6">';
    contenido += '<span>' + pago.id_pago + '</span><br>';
    contenido += '<span>' + pago.nombre + '</span><br>';
    contenido += '<span>' + pago.concepto +'</span><br>';
    contenido += '<span>$ ' + pago.monto + '</span><br>';
    contenido += '<span>' + pago.plan_financiamiento + ' MESES</span>';
    contenido += '</div></div>';
    contenido += '<div class="col-xs-4"><div class="row"><div class="col-xs-12" align="right">';
    contenido += '<span class="caja-pago_label">Fecha de Pago:</span>';
    contenido += '<span> 10-10-2017</span></div></div><div class="row" style="margin-top: 50px;">';
    contenido += '<div class="col-xs-offset-2 col-xs-4">';
    contenido += '<div class="status-box '+ lbl_color +'" align="center">';
    contenido += '<span>'+ label +'</span></div></div></div></div></div></div>';
    if (estado == 1) {
        $("#confirmados").append(contenido);
    } else {
        $("#no-confirmados").append(contenido);
    }
}

function setId(id) {
    $("#pago_id").val(id);    
}

function confirmarPago() {
    if ($("#paciente_id").val() && $("#pago_id").val()) {
        console.log("ok");
        $.ajax({
            type: "POST",
            url: APP_URL + 'class/Pagos.php',
            data: {
                get: "confirmarPago",
                idpaciente: $("#paciente_id").val(),
                idpago: $("#pago_id").val()
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.estado == "1") {
                    $.notify(response.mensaje, "success");
                    getPagosPorConfirmar();
                } else {
                    $.notify(response.mensaje, "error");
                }
            }
        });
    }
}
function eliminarPago() {
    if ($("#paciente_id").val() && $("#pago_id").val()) {
        console.log("ok");
        $.ajax({
            type: "POST",
            url: APP_URL + 'class/Pagos.php',
            data: {
                get: "eliminarPago",
                idpaciente: $("#paciente_id").val(),
                idpago: $("#pago_id").val()
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.estado == "1") {
                    $.notify(response.mensaje, "success");
                    getPagosPorConfirmar();
                } else {
                    $.notify(response.mensaje, "error");
                }
            },
        });
    }
}