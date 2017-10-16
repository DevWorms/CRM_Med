/**
 * Created by rk521 on 25.03.17.
 */

var id = null;
$(document).ready(function() {
    /******************
     * PAGOS VERSION 1
     *****************/
    if (!$("#user_id").val()) {
        $("#nuevoPago input").prop("disabled", true);
        $("#nuevoPresupuesto input").prop("disabled", true);
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
    $("form#nuevoPago").submit(function() {
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
                    $("#error").fadeIn(1000, function () {
                        $("#error").html('<div class="alert alert-success"> &nbsp; ' + data.mensaje + '</div>');
                    });

                    $('#nuevoPago')[0].reset();
                } else {
                    $("#error").fadeIn(1000, function() {
                        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + data.mensaje + '</div>');
                    });
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
        $("#error").fadeIn(1000, function() {
            $("#error").html("");
        });

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
                    $("#error").fadeIn(1000, function () {
                        $("#error").html('<div class="alert alert-success"> &nbsp; ' + data.mensaje + '</div>');
                    });

                    $('#nuevoPresupuesto')[0].reset();
                    loadPresupuestos($("#user_id").val());
                } else {
                    $("#error").fadeIn(1000, function() {
                        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + data.mensaje + '</div>');
                    });
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
                    $("#nuevoPago input").prop("disabled", false);
                    $("#nuevoPresupuesto input").prop("disabled", false);
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
                        contenido += "<td> $" + pago.saldo + "</td>";
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
            },
            success: function(response) {
                if (response.estado == "1") {
                    $.notify(response.mensaje, "success");
                    obtenerPagos();
                } else {
                    $.notify(response.mensaje, "error");
                }
            },
            error: function(error) {
                $.notify(error, "error");
                $("#wait").hide();
            },
            complete: function() {
                $("#wait").hide();
            }
        });
    }else {
        $.notify("Debes selecionar un paciente y un presupuesto","info");
    }
    

}