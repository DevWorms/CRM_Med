/**
 * Created by rk521 on 14.02.17.
 */

$('document').ready(function () {

    $("#registrar").click(function () {
        createUsuario();
    });

    $("#actualizarUsuario").click(function (e) {
        $("#sectionActUsr").slideToggle(500);
    });

    $("#searcUsuario").keypress(function (e) {
        if (e.keyCode == 13) {
            getUserSearch();
        }
    });

    $(function() {
        var i = $('#div_inputCedulas p').size() + 1;
        $('#add_cedula').click(function() {
            $("<p><input type='text' class='form-control' id='cedula"+i+"' name='cedulas[]' value=''" +
            "placeholder='Cedula profesional'><a href='#' id='delete_cedula"+i+"' onclick='deleteCedula("+i+")'style='font-size:10px'>Eliminar</a></p>"
        ).appendTo("#div_inputCedulas");
                i++;
                return false;
        });
    });

    getListUsuarios();

    $('#type').change(function () {
        switch ($("#type").val()) {
            case "1":
                // Activa los permisos de Administrador
                $("#perm_farmacia").prop('checked', true);
                $("#perm_recepcion").prop('checked', true);
                $("#perm_medico").prop('checked', true);
                $("#perm_financiero").prop('checked', true);
                $("#perm_citas").prop('checked', true);
                $("#perm_admin").prop('checked', true);
                $("#perm_med_admin").prop('checked', true);

                $("#perm_med_admin").prop('disabled', false);
                $("#perm_medico").prop('disabled', false);
                break;
            case "2":
                // Activa los permisos de Médico
                $("#perm_farmacia").prop('checked', false);
                $("#perm_recepcion").prop('checked', false);
                $("#perm_medico").prop('checked', true);
                $("#perm_financiero").prop('checked', false);
                $("#perm_citas").prop('checked', false);
                $("#perm_admin").prop('checked', false);
                $("#perm_med_admin").prop('checked', false);
                
                $("#perm_med_admin").prop('disabled', false);
                $("#perm_medico").prop('disabled', false);
                break;
            case "3":
                // Activa los permisos de Farmacia
                $("#perm_farmacia").prop('checked', true);
                $("#perm_recepcion").prop('checked', false);
                $("#perm_medico").prop('checked', false);
                $("#perm_financiero").prop('checked', false);
                $("#perm_citas").prop('checked', false);
                $("#perm_admin").prop('checked', false);
                $("#perm_med_admin").prop('checked', false);

                $("#perm_med_admin").prop('disabled', true);
                $("#perm_medico").prop('disabled', true);
                break;
            case "4":
                // Activa los permisos de Recepcionista
                $("#perm_farmacia").prop('checked', false);
                $("#perm_recepcion").prop('checked', true);
                $("#perm_medico").prop('checked', false);
                $("#perm_financiero").prop('checked', false);
                $("#perm_citas").prop('checked', false);
                $("#perm_admin").prop('checked', false);
                $("#perm_med_admin").prop('checked', false);

                $("#perm_med_admin").prop('disabled', true);
                $("#perm_medico").prop('disabled', true);
                break;
            case "5":
                // Activa los permisos de CallCenter
                $("#perm_farmacia").prop('checked', false);
                $("#perm_recepcion").prop('checked', false);
                $("#perm_medico").prop('checked', false);
                $("#perm_financiero").prop('checked', false);
                $("#perm_citas").prop('checked', true);
                $("#perm_admin").prop('checked', false);
                $("#perm_med_admin").prop('checked', false);

                $("#perm_med_admin").prop('disabled', true);
                $("#perm_medico").prop('disabled', true);
                break;
            case "6":
                // Activa los permisos de Financiero
                $("#perm_farmacia").prop('checked', false);
                $("#perm_recepcion").prop('checked', false);
                $("#perm_medico").prop('checked', false);
                $("#perm_financiero").prop('checked', true);
                $("#perm_citas").prop('checked', false);
                $("#perm_admin").prop('checked', false);
                $("#perm_med_admin").prop('checked', false);

                $("#perm_med_admin").prop('disabled', true);
                $("#perm_medico").prop('disabled', true);
                break;
            case "7":
                // Activa los permisos de Médico Administrador
                $("#perm_farmacia").prop('checked', false);
                $("#perm_recepcion").prop('checked', false);
                $("#perm_medico").prop('checked', false);
                $("#perm_financiero").prop('checked', false);
                $("#perm_citas").prop('checked', false);
                $("#perm_admin").prop('checked', false);
                $("#perm_med_admin").prop('checked', true);

                $("#perm_med_admin").prop('disabled', false);
                $("#perm_medico").prop('disabled', false);
                break;
        }
    });
});

function createUsuario() {
    
    if (camposValidos()) {
        // Si los campos son válidos
        var data = $("#newUser").serialize();
        console.log(data);
        
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
            }
        });
    
    }
}

function camposValidos() {
    // si existe algún campo está vacio
    if ( !$('#nombre').val() || !$('#apPat').val() || !$('#apMat').val() || !$('#password').val() || 
    !$('#confirm_password').val() || !$('#username').val()) {
        (!$('#nombre').val())? $.notify('Falta nombre', 'error'):'';
        (!$('#apPat').val())? $.notify('Falta Apellido paterno', 'error'):'';
        (!$('#apMat').val())? $.notify('Falta Apellido materno', 'error'):'';
        (!$('#username').val())? $.notify('Falta numero de usuario', 'error'):'';
        (!$('#password').val() || !$('#confirm_password').val())? $.notify('Falta contraseña', 'error'):'';
        ($('#password').val() != $('#confirm_password').val())? $.notify('Las contraseñas deben de coincidir', 'error'):'';
       // (!$('#type').val()) ? $.notify('Indique el tipo de usuario', 'error'):'';   
        return false;
    } else {
        // si todos los campos están llenos
        // -> EVALUAR TIPO DE CARACTERES (falta)
        return true;    
    }
}

function cleanAll() {
    $('#password').val("");
    $('#confirm_password').val("");
    $('#nombre').val("");
    $('#apPat').val("");
    $('#apMat').val("");
    $('#username').val("");
    $('#perm_farmacia').prop("checked", false);
    $('#perm_recepcion').prop("checked", false);
    $('#perm_medico').prop("checked", false);
    $('#perm_financiero').prop("checked", false);
    $('#perm_citas').prop("checked", false);
    $('#perm_admin').prop("checked", false);
    $('#perm_med_admin').prop("checked", false);
    $('#type').val('Seleccionar tipo').prop('selected', true);
    $("#error").html('');
}

function getListUsuarios() {
    $("#wait").show();
    var parametros = {"get": "getListUsuarios"};
    $.ajax({
        url: APP_URL + 'class/Usuarios.php',
        type: 'POST',
        dataType: 'json',
        data: parametros,
        success: function (response) {
            var contenido = "";
            if (response.estado == "1") {
                response.rows.forEach(function (item) {
                    if (item.id_tipo != 5) {
                        contenido += "<tr>";
                        contenido += "<td>" + item.nombre + " " + ((item.apPaterno == null) ? "" : item.apPaterno) + " " + ((item.apMaterno == null) ? "" : item.apMaterno) + "</td>";
                        contenido += "<td>" + item.numeroUsuario + "</td>";
                        contenido += "<td>" + item.incorporacion + "</td>";
                        contenido += "<td>" + ((item.nombre_tipo_usuario == null) ? "sin tipo" : item.nombre_tipo_usuario) + "</td>";
                        contenido += "<td>" + "<a href='#' onclick='openEditUser(" + item.id + ")'><i class='glyphicon glyphicon-pencil'></i></a>" + "</td>";
                        contenido += "</tr>";
                    }
                    
                });
                $("#listUsuarios").html(contenido);
            }
        }, error: function (error) {
            $("#wait").hide();
            error(error);
        }, complete: function () {
            $("#wait").hide();
        }
    });
}

function getUserSearch() {
    $("#wait").show();
    var search = $("#searcUsuario").val();
    var parametros = {"get": "getUserSearch", "search": search};

    $.ajax({
        url: APP_URL + 'class/Usuarios.php',
        type: 'POST',
        dataType: 'json',
        data: parametros,
        success: function (response) {
            var contenido = "";
            if (response.estado == "1") {
                response.rows.forEach(function (item) {
                    contenido += "<tr>";
                    contenido += "<td>" + item.nombre + " " + ((item.apPaterno == null) ? "" : item.apPaterno) + " " + ((item.apMaterno == null) ? "" : item.apMaterno) + "</td>";
                    contenido += "<td>" + item.numeroUsuario + "</td>";
                    contenido += "<td>" + item.incorporacion + "</td>";
                    contenido += "<td>" + ((item.nombre_tipo_usuario == null) ? "sin tipo" : item.nombre_tipo_usuario) + "</td>";
                    contenido += "<td>" + "<a href='#' onclick='openEditUser(" + item.id + ")'><i class='glyphicon glyphicon-pencil'></i></a>" + "</td>";
                    contenido += "</tr>";
                });
                $("#listUsuarios").html(contenido);
            }
        }, error: function (error) {
            $("#wait").hide();
            error(error);
        }, complete: function () {
            $("#wait").hide();
        }
    });
}

function error(msg) {
    $("#error").fadeIn(1000, function () {
        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + msg + '</div>');
    });
}

function openEditUser(idUser) {
    var parametros = {"get": "getUser", "id": idUser};

    $.ajax({
        url: APP_URL + 'class/Usuarios.php',
        type: 'POST',
        dataType: 'json',
        data: parametros,
        beforeSend: function () {
            $("#wait").show();
        },
        success: function (response) {
            if (response.estado == 1) {
                $("#modal-editUser").modal().show();
                var usuario = response.rows[0];

                //DATOS GENERALES
                $("#e-nombre").val(usuario.nombre);
                $("#e-paterno").val(usuario.apPaterno);
                $("#e-materno").val(usuario.apMaterno);
                $("#e-numero").val(usuario.numeroUsuario);
                $("#e-tipousuario").val((usuario.id_tipo == null ? "0" : usuario.id_tipo));

                //DATOS DE PERMISOS
                checkarPermiso(usuario.farmacia, $("#e-perm_farmacia"));
                checkarPermiso(usuario.recepcion, $("#e-perm_recepcion"));
                checkarPermiso(usuario.medico, $("#e-perm_medico"));
                checkarPermiso(usuario.citas, $("#e-perm_citas"));
                checkarPermiso(usuario.financiero, $("#e-perm_financiero"));
                checkarPermiso(usuario.admin, $("#e-perm_admin"));
                checkarPermiso(usuario.admin, $("#e-perm_med_admin"));


                //BOTON
                $("#editModifyUser").html('<button class="btn btn-primary" onclick="event.preventDefault();modifyUser(' + usuario.id + ')" name=""><b>Modificar</b></button>');
            }

        }, error: function (error) {
            $("#wait").hide();
            error(error);
        }, complete: function () {
            $("#wait").hide();
        }
    });
}

function checkarPermiso(permiso, checkbox) {
    if (permiso == 1) {
        $(checkbox).prop('checked', true);
    } else {
        $(checkbox).prop('checked', false);
    }
}

function modifyUser(id) {
    var data = $("#modifyUser").serialize();
    data += "&id_usuario=" + id + "&get=modifyUser";
    if (($('#e-contrasena').val() != $('#e-ncontrasena').val()) && ($('#e-contrasena').val())) {
        $.notify("Las contraseñas no coinciden", "error");
        $("#error").fadeIn(1000, function () {
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
            }, complete: function () {
                $("#wait").hide();
                getListUsuarios();
            }
        });
    }
}