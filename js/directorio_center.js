/**
 * Created by chemasmas on 22/01/17.
 */

var total_rows;
var page_num = 1;

$().ready(function() {

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

    $(document).keypress(function(e) {
        if (e.which == 13) {
            var search = $('#param').val();
            if (search) {
                getPaciente( $("#param").val() );
            }
        }
    });


    // Buscador de pacientes
    $("#param").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 4,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                url  : APP_URL + 'class/Paciente.php',
                data : {
                    get: 'autoSearchFirstDate',
                    param: $("#param").val()
                },
                success: function (data) {
                    data = JSON.parse(data);
                    response($.map(data.pacientes, function (el) {
                        var apMaterno = "";

                        if(el.apMaterno != null){
                            apMaterno = el.apMaterno;
                        }
                            return el.id + " - " + el.apPaterno + " " + apMaterno + " " + el.nombre;

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


function error(msg) {
    $("#error").fadeIn(1000, function () {
        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + msg + '</div>');
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

        console.log(page);

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
                        else {
                            nombre = nombre + ' ' + paciente.nombre;
                        }
                        nombre = nombre + '</td>';
                        var telefono = paciente.telefono;
                        var telefono2 = paciente.telefono2;

                        if(paciente.telefono == null || paciente.telefono == "") {
                            telefono = "No Disponible";
                        }

                        if(paciente.telefono2 == null || paciente.telefono2 == "") {
                            telefono2 = "No Disponible";
                        }

                        if(paciente.is_paciente == "0"){
                            $('#pacientes tr:last').after('<tr>' + nombre +
                                '<td style="text-align:center">' + paciente.id + '</td>' +
                                '<td style="text-align:center">' + telefono + '</td>' +
                                '<td style="text-align:center">' + telefono2 + '</tr>');

                            var actionsTemplate = _.template($('#modal_edit_paciente').text());
                            $('#modalsEdit').append(actionsTemplate(paciente));
                        }

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

