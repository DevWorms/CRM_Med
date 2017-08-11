$(document).ready(function () {

    $("#searchPac").on( "keydown", function( event ) {
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
                    param: $("#searchPac").val()
                },
                success: function (data) {
                    data = JSON.parse(data);
                    response($.map(data.pacientes, function (el) {
                        if(el.is_paciente == "1")
                            return el.id + " - " + el.apPaterno + " " + el.nombre;
                    }));
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
            var paciente = ui.item.value.split(" - ")[0];
            $("#paciente").val(paciente);
            return false;
        }
    });

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
                    response($.map(data.rows, function (el) {
                            return el.id + " - " + el.apPaterno + " " + el.nombre;
                    }));
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

    $("#searchUser").on( "keydown", function( event ) {
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
                    get: 'getUserSearch',
                    search: $("#searchUser").val()
                },
                success: function (data) {
                    data = JSON.parse(data);
                    response($.map(data.rows, function (el) {
                            return el.id + " - " + el.apPaterno + " " + el.nombre;
                    }));
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
            var usuario = ui.item.value.split(" - ")[0];
            $("#usuario").val(usuario);
            return false;
        }
    });

    // por defecto arrojamos 15 primeras
    getReporteSalidas();

});

function getReporteSalidas(){
    var formData = $("#form-getSalidas").serialize();
    $.ajax({
        url  : APP_URL + 'class/Inventario.php',
        type: 'POST',
        dataType: 'json',
        data: formData,
        beforeSend: function(){
            $("#wait").show();
        },
        success: function(response){
            if(response.estado == "1"){
                console.log(response.salidas);
                var contenido = "";
                var salidas = response.salidas;
                for (var i = 0; i < salidas.length ; i++) {
                    contenido += "<tr>";
                    contenido += "<td>" + salidas[i].nUsuario + "</td>";
                    contenido += "<td>" + salidas[i].nMedico + "</td>";
                    contenido += "<td>" + salidas[i].nPaciente + "</td>";
                    contenido += "<td>" + salidas[i].fecha + "</td>";
                    contenido += "<td>" + salidas[i].comentario + "</td>";
                    contenido += "<td><a href='#' onclick=getDetalleSalida(" + salidas[i].id + ")>Detalles <i class='glyphicon glyphicon-align-left'></td>";
                    contenido += "<tr>";
                }
                $("#repMasterOutProductos").html(contenido);
            }else{
                $.notify(response.mensaje , "error");
            }

        },error: function(error){
            $.notify(error , "error");
        },complete:function(){
            $("#usuario").val("0");
            $("#medico").val("0");
            $("#paciente").val("0");
            $("#searchPac").val("");
            $("#searchMed").val("");
            $("#searchUser").val(""); 
            $("#fecha").val("");   
            $("#wait").hide();
        }
    });

    
}

function getDetalleSalida(master){
    $.ajax({
        url  : APP_URL + 'class/Inventario.php',
        type: 'POST',
        dataType: 'json',
        data: {"get":"getDetalleSalidas" , "master" : master},
        beforeSend: function(){
            $("#wait").show();
        },
        success: function(response){
            if(response.estado == "1"){
                $("#modal-detaProductOt").modal().show();
                var contenido = "";
                var detalles = response.detalles;
                for (var i = 0; i < detalles.length ; i++) {
                    contenido += "<tr>";
                    contenido += "<td>" + detalles[i].nombre + "</td>";
                    contenido += "<td>" + detalles[i].cantidad + "</td>";
                    contenido += "<tr>";
                }
                $("#detaOutPoducts").html(contenido);
            }else{
                $.notify(response.mensaje , "error");
            }

        },error: function(error){
            $.notify(error , "error");
        },complete:function(){
   
            $("#wait").hide();
        }
    });
}