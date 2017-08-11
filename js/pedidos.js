/**
 * Created by rk521 on 22.01.17.
 */
var rows_per_page = 5;
var total_rows;
var page_num = 1;

$('document').ready(function() {
    init();
});

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
        url  : APP_URL + 'class/Pedidos.php',
        data : {
            get: 'pages'
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
                    $("#btn-login").html('&nbsp; Iniciar Sesión');
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
    var table = document.getElementById("pedidos");
    for (var i = table.rows.length - 1; i > 0; i--) {
        table.deleteRow(i);
    }
    getPedidos(page_num);
}

function getPedidos(page) {
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Pedidos.php',
        data : {
            get: 'pedidos',
            page: page
        },
        success :  function(response) {
            response = JSON.parse(response);

            if (response.estado == 1) {
                response.pedidos.forEach(function (pedido) {
                    var apellidop = '', apellidom = '';
                    if (pedido.apPaterno != null) { apellidop = pedido.apPaterno; }
                    if (pedido.apMaterno != null) { apellidom = pedido.apMaterno; }

                    $('#pedidos tr:last').after('<tr id="pedido-' + pedido.id + '" onclick="showDetail(' + pedido.id + ');" class="select-row">' +
                        '<td><form><input type="checkbox" name="checkbox-'+ pedido.id +'" id="checkbox-'+ pedido.id +'"></form></td>' +
                        '<td>' + pedido.fecha + '</td>' +
                        '<td>' + pedido.numeroUsuario + ' - ' + pedido.nombre + ' ' + apellidop + ' ' + apellidom + '</td>' +
                        '<td>' + pedido.procedimiento + '</td>' +
                        '</tr>');
                });
            }
            else {
                $("#error").fadeIn(1000, function() {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                    $("#btn-login").html('&nbsp; Iniciar Sesión');
                });
            }
        },
        error : function (response) {
            console.log(response);
        }
    });
}

function showDetail(id) {
    $.ajax({
        type : 'POST',
        url  : APP_URL + 'class/Pedidos.php',
        data : {
            get: 'pedido',
            id: id
        },
        success :  function(response) {
            response = JSON.parse(response);

            if (response.estado == 1) {
                var table = document.getElementById("productos");
                for (var i = table.rows.length - 1; i > 0; i--) {
                    table.deleteRow(i);
                }

                $('tr.select-row').css("background-color", "");
                $('#pedido-' + id).attr('style', 'background-color: #E0E6F8');

                response.productos.forEach(function (producto) {
                    $('#productos tr:last').after('<tr>' +
                        '<td>' + producto.nombre + '</td>' +
                        '<td>' + producto.tipo + '</td>' +
                        '<td>' + producto.presentacion + '</td>' +
                        '<td>' + producto.gramaje + '</td>' +
                        '<td>' + producto.cantidad + '</td>' +
                        '</tr>');
                });
            }
            else {
                $("#error").fadeIn(1000, function() {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                    $("#btn-login").html('&nbsp; Iniciar Sesión');
                });
            }
        },
        error : function (response) {
            console.log(response);
        }
    });
}