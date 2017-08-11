/**
 * Created by rk521 on 14.02.17.
 */

$('document').ready(function() {

    $("#registrar").click(function () {
        createUsuario();
    });

    $("#actualizarUsuario").click(function(e){
        $("#sectionActUsr").slideToggle(500);
    });

    $("#searcUsuario").keypress(function(e){
        if(e.keyCode == 13){
            getUserSearch();
        }
    });

    getListUsuarios();

});

function createUsuario() {
    var data = $("#newUser").serialize();
    if (($('#password').val() != $('#confirm_password').val()) && ($('#password').val())) {
        $.notify("Las contraseñas no coinciden", "error");
        $("#error").fadeIn(1000, function() {
            $("#error").html('<div class="alert alert-danger"> &nbsp; Las contraseñas no coinciden</div>');
        });
    } else {
        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Usuarios.php',
            data: data,
            dataType: "json",
            success: function (response) {
                if (response.estado == 1) {
                    $.notify("Usuario creado exitosamente", "success");
                    cleanAll();
                }
                else {
                    $.notify(response.mensaje, "error");
                    $("#error").fadeIn(1000, function () {
                        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                    });
                }
            },
            error: function (response) {
                console.log(response);
            }
        });
    }
}

function cleanAll() {
    $('#password').val("");
    $('#confirm_password').val("");
    $('#nombre').val("");
    $('#apPat').val("");
    $('#apMat').val("");
    $('#username').val("");
    $('#perm_farmacia').prop( "checked", false );
    $('#perm_recepcion').prop( "checked", false );
    $('#perm_medico').prop( "checked", false );
    $('#perm_financiero').prop( "checked", false );
    $("#error").html('');
}

function getListUsuarios(){
    $("#wait").show();
    var parametros = {"get":"getListUsuarios"};
    $.ajax({
        url: APP_URL + 'class/Usuarios.php',
        type: 'POST',
        dataType: 'json',
        data: parametros,
        success: function(response){
            var contenido = "";
            if(response.estado == "1"){
                response.rows.forEach(function(item){
                    contenido += "<tr>";
                    contenido += "<td>" + item.nombre + " " + ((item.apPaterno == null) ? "" : item.apPaterno) + " " + ((item.apMaterno == null) ? "" : item.apMaterno)+ "</td>";
                    contenido += "<td>" + item.numeroUsuario + "</td>";
                    contenido += "<td>" + item.incorporacion + "</td>";
                    contenido += "<td>" + ((item.nombre_tipo_usuario == null) ? "sin tipo" : item.nombre_tipo_usuario) + "</td>";
                    contenido += "<td>" + "<a href='#' onclick='openEditUser("+item.id+")'><i class='glyphicon glyphicon-pencil'></i></a>" + "</td>";
                    contenido += "</tr>"; 
                });
                $("#listUsuarios").html(contenido);
            }
        },error: function(error){
            $("#wait").hide();
            error(error);
        },complete: function () {
                $("#wait").hide();
        }
    });  
}

function getUserSearch(){
    $("#wait").show();
    var search= $("#searcUsuario").val();
    var parametros = {"get":"getUserSearch", "search" : search};
    $.ajax({
        url: APP_URL + 'class/Usuarios.php',
        type: 'POST',
        dataType: 'json',
        data: parametros,
        success: function(response){
            var contenido = "";
            if(response.estado == "1"){
                response.rows.forEach(function(item){
                    contenido += "<tr>";
                    contenido += "<td>" + item.nombre + " " + ((item.apPaterno == null) ? "" : item.apPaterno) + " " + ((item.apMaterno == null) ? "" : item.apMaterno)+ "</td>";
                    contenido += "<td>" + item.numeroUsuario + "</td>";
                    contenido += "<td>" + item.incorporacion + "</td>";
                    contenido += "<td>" + ((item.nombre_tipo_usuario == null) ? "sin tipo" : item.nombre_tipo_usuario) + "</td>";
                    contenido += "<td>" + "<a href='#' onclick='openEditUser("+item.id+")'><i class='glyphicon glyphicon-pencil'></i></a>" +"</td>";
                    contenido += "</tr>"; 
                });
                $("#listUsuarios").html(contenido);
            }
        },error: function(error){
            $("#wait").hide();
            error(error);
        },complete: function () {
            $("#wait").hide();
        }
    });
}

function error(msg) {
    $("#error").fadeIn(1000, function () {
        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + msg + '</div>');
    });
}

function openEditUser(idUser){
   
    var parametros = {"get":"getUser", "id" : idUser};
    $.ajax({
        url: APP_URL + 'class/Usuarios.php',
        type: 'POST',
        dataType: 'json',
        data: parametros,
        beforeSend: function () {
            $("#wait").show();
        },
        success: function(response){
            if(response.estado == 1){
               $("#modal-editUser").modal().show(); 
                var usuario = response.rows[0];
                //DATOS GENERALES
                $("#e-nombre").val(usuario.nombre);
                $("#e-paterno").val(usuario.apPaterno);
                $("#e-materno").val(usuario.apMaterno);
                $("#e-numero").val(usuario.numeroUsuario);
                $("#e-tipousuario").val((usuario.id_tipo == null ? "0" : usuario.id_tipo));
                //DATOS DE PERMISOS
                checkarPermiso(usuario.farmacia,$("#e-perm_farmacia"));
                checkarPermiso(usuario.recepcion,$("#e-perm_recepcion"));
                checkarPermiso(usuario.medico,$("#e-perm_medico"));
                checkarPermiso(usuario.citas,$("#e-perm_citas"));
                checkarPermiso(usuario.financiero,$("#e-perm_financiero"));
                //BOTON
                $("#editModifyUser").html('<button class="btn btn-primary" onclick="event.preventDefault();modifyUser('+usuario.id+')" name=""><b>Modificar</b></button>');
            }
            
        },error: function(error){
            $("#wait").hide();
            error(error);
        },complete: function () {
            $("#wait").hide();
        }
    });
}

function checkarPermiso(permiso,checkbox){
    if(permiso == 1){
        $(checkbox).prop('checked', true); 
    }else{
        $(checkbox).prop('checked', false); 
    }
}
function modifyUser(id){ 
    var data = $("#modifyUser").serialize();
    data += "&id_usuario=" +id + "&get=modifyUser";
    if (($('#e-contrasena').val() != $('#e-ncontrasena').val()) && ($('#e-contrasena').val())) {
        $.notify("Las contraseñas no coinciden", "error");
        $("#error").fadeIn(1000, function() {
            $("#error").html('<div class="alert alert-danger"> &nbsp; Las contraseñas no coinciden</div>');
        });
    } else {
        $("#error").html('');
        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Usuarios.php',
            data: data,
            dataType: "json",
            beforeSend: function () {
                $("#wait").show();
                $("#modal-editUser").modal('hide');
                $("#editModifyUser").html("");
            },
            success: function (response) {
                if (response.estado == 1) {
                    $.notify("Usuario modificado exitosamente", "success");
                }
                else {
                    $.notify(response.mensaje, "error");
                    $("#error").fadeIn(1000, function () {
                        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                    });
                }
            },
            error: function (response) {
                $("#wait").hide();
                $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response + '</div>');
            },complete: function () {
                $("#wait").hide();
                getListUsuarios();
            }
        });
    }
}