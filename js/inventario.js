/**
 * Created by rk521 on 22.01.17.
 */
var rows_per_page = 5;
var total_rows;
var page_num = 1;

$('document').ready(function() {
    init();

    $("#search-form").validate({
        rules: {
            search: {
                required: true
            }
        },
        messages: {
            search: {
                required: "Introduce un producto a buscar"
            }
        },
        submitHandler: searchProducto
    });

    /*AUTOCOMPLETADO PARA GRAMAJE*/
    $("#gramaje").on("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function(request, response) {
            $.ajax({
                type: 'POST',
                url: APP_URL + 'class/Inventario.php',
                data: {
                    search: $("#gramaje").val(),
                    get: "getGramaje"
                },
                dataType: "json",
                success: function(data) {
                    response($.map(data.productos, function(el) {
                        return el.gramaje;
                    }));
                },
                error: function(data) {
                    console.log("error" + data);
                }
            });
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        delay: 700,
        select: function(event, ui) {
            //var terms = split(this.value) ;
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join("");
            return false;
        }
    });

    /*AUTOCOMPLETADO PARA PRESENTACION*/
    $("#presentacion").on("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function(request, response) {
            $.ajax({
                type: 'POST',
                url: APP_URL + 'class/Inventario.php',
                data: {
                    search: $("#presentacion").val(),
                    get: "getPresentacion"
                },
                dataType: "json",
                success: function(data) {
                    response($.map(data.productos, function(el) {
                        return el.presentacion;
                    }));
                },
                error: function(data) {
                    console.log("error" + data);
                }
            });
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        delay: 700,
        select: function(event, ui) {
            //var terms = split(this.value) ;
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join("");
            return false;
        }
    });
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
        type: 'POST',
        url: APP_URL + 'class/Inventario.php',
        data: {
            get: 'pages'
        },
        success: function(response) {
            response = JSON.parse(response);

            if (response.estado == 1) {
                total_rows = parseInt(response.pages);

                //Loop through every available page and output a page link
                var count = 1;
                for (var x = 0; x < total_rows; x++) {
                    if (page_num == x + 1) {
                        $('#pagination').append('<li id="page-' + (x + 1) + '" class="active"><a href="#' + (x + 1) + '" onclick="getPage(' + (x + 1) + ');">' + (x + 1) + '</a></li>');
                    } else {
                        $('#pagination').append('<li id="page-' + (x + 1) + '"><a href="#' + (x + 1) + '" onclick="getPage(' + (x + 1) + ');">' + (x + 1) + '</a></li>');
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
        error: function(response) {
            console.log(response);
        }
    });
}

function getPage(page_num) {
    $('li.active').removeClass("active");
    $("#page-" + page_num).attr("class", "active");

    //Clear the existing data view
    var table = document.getElementById("catalogo");
    for (var i = table.rows.length - 1; i > 0; i--) {
        table.deleteRow(i);
    }
    getCatalogo(page_num);
}

function getCatalogo(page) {
    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Inventario.php',
        data: {
            get: 'catalogo',
            page: page
        },
        success: function(response) {
            response = JSON.parse(response);

            if (response.estado == 1) {

                response.inventario.forEach(function(producto) {
                    $('#catalogo tr:last').after('<tr' + getColorAlerta(producto) + '>' +
                        '<td>' + producto.nombre + '</td>' +
                        '<td>' + producto.tipo + '</td>' +
                        '<td>' + producto.presentacion + ' con ' + producto.pzs_presentacion + ' piezas de ' + producto.cant_gramaje + ' ' + producto.gramaje + '</td>' +
                        '<td>' + producto.caducidad + '</td>' +
                        '<td>' + producto.lote + '</td>' +
                        '<td>' + producto.existencia + '</td>' +
                        '<td><a href="#" onclick="showEditProducto(' + producto.id + ')"><i class="glyphicon glyphicon-pencil"></i></a></td>' +
                        '</tr>');
                });
            } else {
                $("#error").fadeIn(1000, function() {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                    $("#btn-login").html('&nbsp; Iniciar Sesión');
                });
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function getColorAlerta(producto) {
    var decFecha = producto.caducidad.split("-");
    var caducidad = new Date(decFecha[0], (decFecha[1] - 1), decFecha[2]);
    var hoy = new Date();
    var timeDiff = hoy.getTime() - caducidad.getTime();
    var diffDays = 0;
    var colorAlerta = "";
    if (timeDiff > 0) {
        // si la diferencia es positiva hoy es mayor que la caducidad, ya caduco
        colorAlerta = " style='background-color: rgba(255,0,0,0.5)'";
    } else {
        //si la diferencia es negativa aun no caduca pero alertamos cuanto falta
        timeDiff = Math.abs(timeDiff);
        diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));


        if (diffDays < 30) {
            colorAlerta = " style='background-color: rgba(255,0,0,0.5)'";
        } else if (diffDays >= 30 && diffDays < 60) {
            colorAlerta = " style='background-color: rgba(247,232,9,0.3)'";
        } else if (diffDays >= 60 ) {
            colorAlerta = " style='background-color: rgba(0, 255, 0, 0.3)'";
        }

    }

    return colorAlerta;
}

function searchProducto() {
    var data = $("#search-form").serialize();
    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Inventario.php',
        data: {
            get: 'search',
            search: $('#search').val()
        },
        success: function(response) {
            response = JSON.parse(response);

            if (response.estado == 1) {
                var table = document.getElementById("catalogo");
                for (var i = table.rows.length - 1; i > 0; i--) {
                    table.deleteRow(i);
                }
                $('#pagination').html("");

                response.productos.forEach(function(producto) {

                    $('#catalogo tr:last').after('<tr' + getColorAlerta(producto) + '>' +

                        '<td>' + producto.nombre + '</td>' +
                        '<td>' + producto.tipo + '</td>' +
                        '<td>' + producto.presentacion + ' con ' + producto.pzs_presentacion + ' piezas de ' + producto.cant_gramaje + ' ' + producto.gramaje + '</td>' +
                        '<td>' + producto.caducidad + '</td>' +
                        '<td>' + producto.lote + '</td>' +
                        '<td>' + producto.existencia + '</td>' +
                        '<td><a href="#" onclick="showEditProducto(' + producto.id + ')"><i class="glyphicon glyphicon-pencil"></i></a></td>' +
                        '</tr>');
                });
            } else {
                $("#error").fadeIn(1000, function() {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function ordenarPor(valor) {
    
    console.log(valor);

    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Inventario.php',
        data: {
            get: 'ordenar',
            search: valor
        },
        success: function(response) {
            response = JSON.parse(response);

            if (response.estado == 1) {
                var table = document.getElementById("catalogo");
                for (var i = table.rows.length - 1; i > 0; i--) {
                    table.deleteRow(i);
                }
                $('#pagination').html("");

                response.productos.forEach(function(producto) {

                    $('#catalogo tr:last').after('<tr' + getColorAlerta(producto) + '>' +

                        '<td>' + producto.nombre + '</td>' +
                        '<td>' + producto.tipo + '</td>' +
                        '<td>' + producto.presentacion + ' con ' + producto.pzs_presentacion + ' piezas de ' + producto.cant_gramaje + ' ' + producto.gramaje + '</td>' +
                        '<td>' + producto.caducidad + '</td>' +
                        '<td>' + producto.lote + '</td>' +
                        '<td>' + producto.existencia + '</td>' +
                        '<td><a href="#" onclick="showEditProducto(' + producto.id + ')"><i class="glyphicon glyphicon-pencil"></i></a></td>' +
                        '</tr>');
                });
            } else {
                $("#error").fadeIn(1000, function() {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }
        },
        error: function(response) {
            console.log(response);
        }
    });
}

function createProducto() {
    if (camposValidos()) { // Si todos los campos son validos
        var data = $("#create-form").serialize();
        $.ajax({
            type: 'POST',
            url: APP_URL + 'class/Inventario.php',
            data: data,
            success: function(response) {
                response = JSON.parse(response);

                if (response.estado == 1) {
                    $('#create-form')[0].reset();
                    init();
                    $.notify("Producto creado exitosamente", "success");
                    $("#error").html("");
                } else {
                    $("#error").fadeIn(1000, function() {
                        $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                    });
                }
            },
            error: function(response) {
                console.log(response);
            }
        });
    }
}

/* FUNCION PARA ABRIR MODAL PARA LA EDICION DEP RODUCTO INDIVIDUAL */
function showEditProducto(idProducto) {
    $.ajax({
        url: APP_URL + 'class/Inventario.php',
        type: 'POST',
        data: { idProd: idProducto, get: 'getProductoById' },
        beforeSend: function() {
            $("#wait").show();
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                var producto = response.producto[0];
                $("#modal-editProducto").modal().show();
                $("#e-nombre").val(producto.nombre);
                $("#e-fecha").val(producto.caducidad);
                $("#e-tipo").val(producto.tipo);
                $("#e-presentacion").val(producto.presentacion);
                $("#e-gramaje").val(producto.gramaje);
                $("#e-existencia").val(producto.existencia);
                $("#e-cant_gramaje").val(producto.cant_gramaje);
                $("#e-piezas").val(producto.pzs_presentacion);
                $("#e-alertas").val(producto.minStock);
                $("#e-lote").val(producto.lote);
                $("#e-descripcion").val(producto.descripcion);
                $("#editModifyProd").html('<button class="btn btn-primary" onclick="event.preventDefault();modifyProducto(' + producto.id + ')" name=""><b>Modificar</b></button>');
            } else {
                $("#error").fadeIn(1000, function() {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }

        },
        error: function(response) {
            console.log(response);
        },
        complete: function() {
            $("#wait").hide();
        }
    });
}

/*FUNCION PARA MODIFICAR LOS PRODUCTOS*/
function modifyProducto(idProducto) {
    var formData = $("#editProd-form").serialize();
    formData += "&idProducto=" + idProducto;
    console.log(formData);
    $.ajax({
        url: APP_URL + 'class/Inventario.php',
        type: 'POST',
        data: formData,
        beforeSend: function() {
            $("#wait").show();
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.estado == 1) {
                $('#editProd-form')[0].reset();
                init();
                $.notify("Producto modificado exitosamente", "success");
                $("#error").html("");
                $("#editModifyProd").html("");
                $("#modal-editProducto").modal('hide');
            } else {
                $("#error").fadeIn(1000, function() {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                });
            }

        },
        error: function(response) {
            console.log(response);
        },
        complete: function() {
            $("#wait").hide();
        }
    });
}

function isC1Valido(cadena) {
    var caract = new RegExp(/^([a-zA-Z0-9 \.%(),-/_])+$/);
    if (caract.test(cadena) == false) {
        return false;
    } else {
        return true;
    }
}

function isC2Valido(cadena) {
    var caract = new RegExp(/^([0-9])+$/);
    if (caract.test(cadena) == false) {
        return false;
    } else {
        return true;
    }
}

function isC3Valido(cadena) {
    var caract = new RegExp(/^([a-zA-z0-9 \./])+$/);
    if (caract.test(cadena) == false) {
        return false;
    } else {
        return true;
    }
}

function notifies(mssg, wichColor) {
    $.notify(mssg, wichColor);
}

/* FUNCION PARA VALIDAR LOS CAMPOS DEL MODULO */
function camposValidos() {
    // Si existe algun campo vacío
    if (!$('#nombre').val() || !$('#fecha').val() || !$('#existencia').val() || !$('#cant_gramaje').val() ||
        !$('#piezas').val() || !$('#lote').val()) {
        if (!$('#piezas').val()) notifies('El campo "Piezas por presentación" no debe estar vacio', 'warning');
        if (!$('#cant_gramaje').val()) notifies('El campo "Catidad gramaje" no debe estar vacio', 'warning');
        if (!$('#lote').val()) notifies('El campo "Lote " no debe estar vacio', 'warning');
        if (!$('#existencia').val()) notifies('El campo "Existencia" no debe estar vacio', 'warning');
        if (!$('#fecha').val()) notifies('Falta "fecha de caducidad"', 'warning');
        if (!$('#nombre').val()) notifies('El campo "Nombre" no debe estar vacio', 'warning');
        //return false;
    } else { // Si Todos los campos estan llenos
        // Si no son validos
        if (!isC1Valido($('#nombre').val()) || !isC2Valido($('#existencia').val()) || !isC2Valido($('#piezas').val()) || !isC3Valido($('#lote').val()) || !isC3Valido($('#cant_gramaje').val())) {
            notifies('Existen Campos con caracteres inválidos', 'warning');
        } else { // Si caracteres validos
            return true;
        }
    }
}

