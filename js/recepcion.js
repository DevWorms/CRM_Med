/**
 * Created by chemasmas on 22/01/17.
 */

var total_rows;
var page_num = 1;

$().ready(function() {
    var calendar = document.getElementById("fecha");
    if (calendar !== null) {
        $("#fecha").change(function() {
            var date = Date.parse($("#fecha").val());
            if(!isNaN(date)) {
                getCountCitas("fecha","citas_by_date");
            }
        });
    }

    var calendar2 = document.getElementById("new_fecha");
    if (calendar2 !== null) {
        $("#new_fecha").change(function() {
            var date = Date.parse($("#new_fecha").val());
            if(!isNaN(date)) {
                getCitas("new_fecha");
            }
        });
    }

    $("#actualizar").click(function(event) {
       $("#error").html("");
    });

    $("#busqueda").click(function () {
        getPaciente( $("#param").val() );
    });

    // busqueda por enter
    $("#prospecto").keypress(function(e){
        if(e.keyCode == 13){
          getPaciente( $("#prospecto").val() );  
        }
    });

    $("#busquedaP").click(function () {
        getPaciente( $("#prospecto").val() );
    });

    $("#buscarProducto").click(function () {
        getProducto( $("#paramProd").val());
    });

    $("#registrar").click(function () {
        addPaciente();
    });

    $("#fecha_nac").keyup(function() {
        delay(function() {
            var fecha = new Date($("#fecha_nac").val());
            $('#edad').val((new Date().getFullYear()) - fecha.getFullYear());
        }, 1000 );
    });

    $(document).keypress(function(e) {
        if (e.which == 13) {
            var search = $('#param').val();
            if (search) {
                getPaciente( $("#param").val() );
            }
        }
    });

    // Buscador de pacientes y prospectos
    $("#prospecto").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                post: 'autoSearch',
                url  : APP_URL + 'class/Paciente.php',
                data : {
                    post: 'allSearch',
                    param: $("#prospecto").val()
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
            return false;
        }
    });

    // Buscador de pacientes
    $("#param").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                post: 'autoSearch',
                url  : APP_URL + 'class/Paciente.php',
                data : {
                    post: 'autoSearch',
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
            return false;
        }
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
        minLength: 0,
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

    $("#registrar_cita").click(function () {
        createCita();
    });

    $("#new_registrar_cita").click(function () {
        createUserAndCita();
    });

    var table = document.getElementById("pacientes");
    if (table) {
        init();


        // Si recibe un usuario por 'get'
        if (window.location.hash !== '') {
            var hash = window.location.hash.substring(0, 6);
            if (hash == "#user=") {
                var id = parseInt(window.location.hash.substring(6));
                loadEditPaciente(id);
            }
        }
    }
});

var delay = (function() {
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

function clearNuevoPaciente() {
    $("#new_fecha").val("");
    $("#new_hora").val("");
    $("#new_procedimiento").val("");
    $("#new_anuncio").val("");
    $("#new_apMat").val("");
    $("#new_apPat").val("");
    $("#new_nombre").val("");

    $("#error").html("");

    var table = document.getElementById("citas_by_date");
    if (table !== null) {
        for (var i = table.rows.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
    }
}

function init() {
    initPageNumbers();

    if (window.location.hash !== '') {
        var hash_num = parseInt(window.location.hash.substring(1));
        if (hash_num > 0) {
            page_num = hash_num;
        }
    }

    getPage(page_num);
    $('#pagination').html("");
}

function initPageNumbers() {
    //Get total rows number
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            post: 'pages'
        },
        success :  function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                total_rows = parseInt(response.pages);

                //Loop through every available page and output a page link
                var count = 1;
                for (var x = 0;  x < total_rows; x++) {
                    if (page_num == x+1) {
                        $('#pagination').append('<li id="page-' + (x+1) + '" class="active"><a href="#'+ (x+1) +'" onclick="getPage('+ (x+1) +');">'+ (x+1) +'</a></li>');
                    } else {
                        $('#pagination').append('<li id="page-' + (x+1) + '"><a href="#'+ (x+1) +'" onclick="getPage('+ (x+1) +');">'+ (x+1) +'</a></li>');
                    }
                    count++;
                }
            } else {
                $("#error").fadeIn(1000, function() {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }
        },
        error : function (response) {
            console.log(response);
        }
    });
}

function showPaciente() {
    var id = String($("#param").val()).split(" - ");
    id = id[0];

    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            get: 'paciente',
            id: id
        },
        beforeSend: function () {
            $("#wait").show();
        },
        success :  function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                var paciente = response.paciente[0];
                var actionsTemplate = _.template($('#modal_edit_paciente').text());
                $('#modalsEdit').append(actionsTemplate(paciente));
                $("#EditPaciente-" + paciente.id).modal().show();
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

function loadEditPaciente(id) {
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            get: 'paciente',
            id: id
        },
        success :  function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                var paciente = response.paciente[0];
                var actionsTemplate = _.template($('#modal_edit_paciente').text());
                $('#modalsEdit').append(actionsTemplate(paciente));
                $("#EditPaciente-" + paciente.id).modal().show();
            }
        },
        error : function (response) {
            error("Ocurrio un error al procesar la solicitud");
            cleanPaciente();
        }
    });
}

//para obtener informacion de las citas
function getInfoCitas(id){
    var generalCitas = [];
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            get: 'pacienteFull',
            id: id
        },success : function(response){
            response = JSON.parse(response.toString());
            generalCitas.push(response.citas);
            generalCitas.push(response.nextDate);
            loadCitas(generalCitas);
        },error: function(response){
             $("#error").fadeIn(1000, function () {
                $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
            });
        }});    
}

function loadCitas(lascitas){
    var citas = lascitas;
    var proximaCita = "";
    var otrasCitas = "";

    // si no hay valores en nextDate tomamos la primera de otras citas
    if(citas[1].length <= 0){
        proximaCita = citas[0][0].fecha + " " + citas[0][0].hora_ini;
        // y luego interamso otras citas a partir del segundo elemento
        if(citas[0].length  > 1){
            for(var cont = 1; cont < citas[0].length ; cont++){
                otrasCitas += citas[0][cont].fecha + " " + citas[0][cont].hora_ini + "<br>";
            }  
        }
    }else{
        // si hay elemento en nextDate lo tomamos e iteramos normalmente otrascitas
        proximaCita = citas[1][0].fecha + " " + cita[1][0].hora_ini;
        for(var cont = 0; cont < citas[0].length ; cont++){
            otrasCitas += citas[0][cont].fecha + " " + citas[0][cont].hora_ini + "<br>";
        }
        
    }
    document.getElementById("proximaCita").innerHTML = "Próxima cita <br>" + proximaCita;
    document.getElementById("otrasCitas").innerHTML = "Otras citas <br>" + otrasCitas;
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
            get: 'paciente',
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
                loadData(response.paciente);
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

function error(msg) {
    $("#error").fadeIn(1000, function () {
        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + msg + '</div>');
    });
}

function loadData(data) {
    data = data[0];

    nombre = data.nombre;
    nombre += (data.apPaterno != null) ? " " + data.apPaterno : "";
    nombre += (data.apMaterno != null) ? " " + data.apMaterno : "";

    $("#error").html("");
    $('#registrar_cita').css({"visibility": "visible"});
    $('#pago').css({"visibility": "visible"});

    document.getElementById("nombreP").innerHTML = "Nombre: <a href='" + APP_URL + "/paciente#" + data.id + "'>" + nombre + "</a>";
    document.getElementById("telP").innerHTML = "Teléfono: " + data.telefono;
    document.getElementById("folioP").innerHTML = "Folio: " + data.id;

    //cargamos las citas
    getInfoCitas(data.id);
    
}

function getProducto(nombre) {
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Inventario.php',
        data : {
            get: 'search',
            search: nombre
        },
        success :  function(response) {
            response = JSON.parse(response);
            loadSearch(response.productos);

        },
        error : function (response) {
            error("Fallo");
        }
    });
}

function loadSearch(productos) {
    $("#productoSel").html("");

    for (i=0; i<productos.length; i++) {
        $("#productoSel").append("<option>"+productos[i].nombre+"</option>");
    }

    $('#searchModal').modal();
}

function exitoModal(paciente) {
    html = "<h4>Se creo el paciente: ";
    html += paciente.nombre + " " + paciente.apPaterno + " " + paciente.apMaterno +" ";
    html += "con el folio: <strong>" + paciente.id + "</strong></h4>";

    $('#ExitoModalBody').html(html);
    $('#exitoModal').modal();
}

function cleanPaciente() {
    $('#registrar_cita').css({"visibility": "hidden"});
    $('#pago').css({"visibility": "hidden"});

    document.getElementById("nombreP").innerHTML = "";
    document.getElementById("telP").innerHTML = "";
    document.getElementById("folioP").innerHTML = "";
    document.getElementById("proximaCita").innerHTML = "";
    document.getElementById("otrasCitas").innerHTML = "";
}

function getPage(page_num) {
    $('li.active').removeClass("active");
    $("#page-" + page_num).attr("class", "active");

    //Clear the existing data view
    var table = document.getElementById("pacientes");
    for(var i = table.rows.length - 1; i > 0; i--) {
        table.deleteRow(i);
    }
    tableEditPacientes(page_num);
}

function tableEditPacientes(page) {
    var table = document.getElementById("pacientes");
    if (table !== null) {
        for (var i = table.rows.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }

        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Paciente.php',
            data: {
                post: 'pacientes',
                page: page
            },
            beforeSend: function () {
                $("#wait").show();
            },
            success: function (response) {
                response = JSON.parse(response);

                if (response.estado == 1) {
                    response.pacientes.forEach(function (paciente) {
                        var nombre = '<td style="text-align:center">' + paciente.nombre + ' ' + paciente.apPaterno;
                        if (paciente.apMaterno) {
                            nombre = nombre + ' ' + paciente.apMaterno;
                        }
                        nombre = nombre + '</td>';
                        var modificaPaciente = "";
                        var modificaPrimeraVez = "";
                        //agregamos poder modificar usuarios primera vez
                        if(paciente.is_paciente == "1"){
                            modificaPaciente = '<td style="text-align:center"><a href="#" onclick="openEditPaciente(' + paciente.id + ')"><span class="glyphicon glyphicon-pencil"></span></a></td>';
                            modificaPrimeraVez =  "<td></td>";
                        }else if(paciente.is_paciente == "0"){
                            modificaPrimeraVez = '<td style="text-align:center"><a href="#" onclick="openEditPaciente(' + paciente.id + ')"><span class="glyphicon glyphicon-pencil"></span></a></td>';
                            modificaPaciente = "<td></td>";
                        }
                        $('#pacientes tr:last').after('<tr>' + nombre +
                            '<td style="text-align:center">' + paciente.id + '</td>' +
                            '<td style="text-align:center">' + paciente.telefono + '</td>' +
                            modificaPaciente + modificaPrimeraVez +'</tr>');

                        var actionsTemplate = _.template($('#modal_edit_paciente').text());
                        $('#modalsEdit').append(actionsTemplate(paciente));
                    });
                }
                else {
                    $("#error").fadeIn(1000, function () {
                        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                    });
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

function openEditPaciente(id) {
    $('#EditPaciente-' + id).modal('show');
}

function editPaciente(id) {
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            post: 'update',
            id: $('#up_id_' + id).val(),
            new_id: $('#up_new_id_' + id).val(),
            nombre: $('#up_nombre_' + id).val(),
            apP: $('#up_apPat_' + id).val(),
            apM: $('#up_apMat_' + id).val(),
            dom: $('#up_domicilio_' + id).val(),
            tel: $('#up_tel_' + id).val(),
            ocp: $('#up_ocupacion_' + id).val(),
            nom_fam: $('#up_nombre_familiar_' + id).val(),
            tel_fam: $('#up_tel_familiar_' + id).val(),
            email: $('#up_email_' + id).val(),
            fecha: $('#up_fecha_nac_' + id).val(),
            edad: $('#up_edad_' + id).val(),
            ref: $('#up_referencia_' + id).val()

        },
        beforeSend: function () {
            $("#wait").show();
        },
        success :  function(response) {
            response = JSON.parse(response);

            if (response.estado == 1) {
                $('#EditPaciente-' + id).modal('hide');
                $.notify("Paciente actualizado exitosamente", "success");
                tableEditPacientes(page_num);
                $("#error").html("");
            } else {
                error(response.mensaje);
            }
        },
        error : function (response) {
            error("Ocurrio un error");
        },
        complete: function () {
            $("#wait").hide();
        }
    });
}

function cleanForm() {
    $("#nombre").val("");
    $("#apPat").val("");
    $("#apMat").val("");
    $("#domicilio").val("");
    $("#tel").val("");
    $("#email").val("");
    $("#fecha_nac").val("");
    $("#edad").val("");
    $("#ocupacion").val("");
    $("#tel_familiar").val("");
    $("#nombre_familiar").val("");
    $("#referencia").val("");
    $("#folio").val("");
}

function addPaciente() {
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Paciente.php',
        data : {
            post: 'add',
            nombre: $("#nombre").val(),
            apP: $("#apPat").val(),
            apM: $("#apMat").val(),
            dom: $("#domicilio").val(),
            tel: $("#tel").val(),
            email: $("#email").val(),
            fecha: $("#fecha_nac").val(),
            edad: $("#edad").val(),
            ocp: $("#ocupacion").val(),
            tel_fam: $("#tel_familiar").val(),
            nom_fam: $("#nombre_familiar").val(),
            ref: $("#referencia").val(),
            folio: $("#folio").val()
        },
        beforeSend: function () {
            $("#wait").show();
        },
        success :  function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                exitoModal(response.paciente[0]);
                $.notify("Paciente creado exitosamente", "success");
                cleanForm();
                tableEditPacientes();
                $("#error").html("");
            } else {
                $.notify(response.mensaje, "error");
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }
        },
        error : function (response) {
            error("Ocurrio un error");
        },
        complete: function () {
            $("#wait").hide();
        }
    });
}

function getCitas(fecha_id) {
    var table = document.getElementById("citas_by_date");
    if (table !== null) {
        for (var i = table.rows.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Paciente.php',
            data: {
                post: 'citas',
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
                        $('#citas_by_date tr:last').after('<tr>' +
                            '<td style="text-align:center">' + cita.hora_ini + '</td>' +
                            '<td style="text-align:center">' + cita.tipo_cita + '</td>' +
                            '</tr>');
                    });
                    if (Object.keys(response.citas).length < 1) {
                        $('#citas_by_date tr:last').after('<tr>' +
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
            comentario: $("#comentario_cita").val()
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

function createCita() {
    var id = String($("#prospecto").val()).split(" - ");
    id = id[0];

    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Paciente.php',
        data: {
            post: 'createCita',
            fecha: $("#fecha").val(),
            hora: $("#hora").val(),
            tipo: $("#tipo_cita").val(),
            id_paciente: id,
            comentario: $("#comentario_cita").val(),
            tratamiento: $("#tratamientos").val(),
            created_by : $("#created_by").val()
        },
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                $.notify("Cita creada correctamente", "success");
                cleanCitaForm();
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

function cleanCitaForm() {
    $("#fecha").val("");
    $("#hora").val("");
    $("#prospecto").val("");
    $("#comentario_cita").val(""),

    document.getElementById("nombreP").innerHTML = "";
    document.getElementById("telP").innerHTML = "";
    document.getElementById("folioP").innerHTML = "";
    document.getElementById("tratamientos").innerHTML = "";
    $('#registrar_cita').css({"visibility": "hidden"});

    var table = document.getElementById("citas_by_date");
    if (table !== null) {
        for (var i = table.rows.length - 1; i > 0; i--) {
            table.deleteRow(i);
        }
    }
}
