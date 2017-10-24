/**
 * Created by chemasmas on 22/01/17.
 */

var total_rows;
var page_num = 1;

$().ready(function() {

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
            post: 'pagesUsers'
        },
        success :  function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                total_rows = parseInt(response.pagesUsers);

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
                post: 'pacientesPrimera',
                page: page
            },
            beforeSend: function () {
                $("#wait").show();
            },
            success: function (response) {
                response = JSON.parse(response);

                if (response.estado == 1) {
                    response.pacientes.forEach(function (paciente) {
                        var nombre = '<td style="text-align:center">' + paciente.apPaterno;
                        if (paciente.apMaterno) {
                            nombre = nombre + ' ' + paciente.apMaterno + ' ' + paciente.nombre;
                        }
                        else    {
                            nombre = nombre + ' ' + paciente.nombre;
                        }
                        nombre = nombre + '</a></td>';

                        var modificaPaciente = "";
                        var modificaPrimeraVez = "";
                        //agregamos poder modificar usuarios primera vez
                            
                        if(paciente.email) {
                            modificaPaciente =  '<td style="text-align:center">' + paciente.email + '</td>';
                        }
                        else{
                            modificaPaciente =  '<td style="text-align:center"> - </td>';
                        }

                        var telefonoUsuario = " - "
                        
                        if(paciente.telefono)
                            telefonoUsuario = paciente.telefono;

                        $('#pacientes tr:last').after('<tr>' + nombre +
                            '<td style="text-align:center">' + paciente.id + '</td>' +
                            '<td style="text-align:center">' + telefonoUsuario + '</td>' +
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
