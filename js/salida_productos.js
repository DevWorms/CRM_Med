$(document).ready(function() {
    $("#searchProd").on("keydown", function(event) {
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
                    get: "searchProductoToOut",
                    busqueda: $("#searchProd").val()
                },
                dataType: "json",
                success: function(data) {
                    response($.map(data.productos, function(el) {
                        return el.id + " - " + el.nombre + " - " + el.existencia;
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
        delay: 300,
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
            var valores = ui.item.value.split(" - ");
            if (!isDuplicatedProduct(valores[0])) {
                addToPre(valores[0], valores[1], valores[2]);
            } else {
                $.notify("Ya tienes agregado el producto", "warning");
            }
            $("#searchProd").val("");
            return false;
        }
    });

    $("#searchPac").on("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function(request, response) {
            $.ajax({
                type: 'POST',
                post: 'autoSearch',
                url: APP_URL + 'class/Paciente.php',
                data: {
                    post: 'allSearch',
                    param: $("#searchPac").val()
                },
                success: function(data) {
                    data = JSON.parse(data);
                    response($.map(data.pacientes, function(el) {
                        if (el.is_paciente == "1")
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
        select: function(event, ui) {
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join("");
            var paciente = ui.item.value.split(" - ")[0];
            $("#paciente").val(paciente);
            return false;
        }
    });

    $("#searchMed").on("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function(request, response) {
            $.ajax({
                type: 'POST',
                post: 'autoSearch',
                url: APP_URL + 'class/Usuarios.php',
                data: {
                    get: 'getMedicosSearch',
                    param: $("#searchMed").val()
                },
                success: function(data) {
                    data = JSON.parse(data);
                    response($.map(data.medicos, function(el) {
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
        select: function(event, ui) {
            var terms = String(this.value).split(".");
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value);
            // add placeholder to get the comma-and-space at the end
            terms.push("");
            this.value = terms.join("");
            var medico = ui.item.value.split(" - ")[0];
            $("#medico").val(medico);
            return false;
        }
    });

});


function addToPre(id, nombre, existencia) {

    var contenido = "";

    contenido += "<tr><td style='display:none'>" + id + "</td><td>" + nombre + "</td><td>" + existencia + "</td>";

    contenido += "<td><input class='form-control' type='number' min='1' max='" + existencia + "' name='cantidad'/></td></tr>";

    if ($("#preOutPoducts tr:last").length > 0) {

        $("#preOutPoducts tr:last").after(contenido);

    } else {

        $("#preOutPoducts").html(contenido);

    }

}


function pastProductoSelection() {

    var contenido = "";
    $("#preOutPoducts tr").each(function(ind, elem) {
        var val = $(elem).children("td");
        var idProd = $(val)[0].innerText;
        var nombreProd = $(val)[1].innerText;
        var cantidad = $($(val)[3].firstChild).val();
        var existencia = $(val)[2].innerText;
        if (cantidad) {
            if (Number(cantidad) > 0 && Number(cantidad) <= Number(existencia)) {
                contenido += "<tr>";
                contenido += "<td style='display:none'>" + idProd;
                contenido += "<input id='out_productoId[]' name='out_productoId[]' type='hidden' value='" + idProd + "'></td>";
                contenido += "<td>" + nombreProd + "</td>";
                contenido += "<td>" + cantidad;
                contenido += "<input id='out_productoCant[]' name='out_productoCant[]' type='hidden' value='" + cantidad + "'></td>";
                contenido += "<td><a href='#' style='color:red' onclick='removeRow(this)'><i class='glyphicon glyphicon-remove'></i></a></td>"
                contenido += "</tr>";
            } else {
                if (Number(cantidad) == 0) {
                    $.notify("No puedes agregar la salida de 0 " + nombreProd, "warning");
                } else {
                    $.notify("Intentaste agregar una cantidad de " + cantidad + " con una existencia de " + existencia + " para el producto " + nombreProd, "warning");
                }
            }
        } else {
            $.notify("Ingresaste una cantidad no valida para el producto " + nombreProd, "warning");
        }
    });

    if ($("#productosToOut tr:last").length > 0) {
        $("#productosToOut tr:last").after(contenido);
    } else {
        $("#productosToOut").html(contenido);
    }
    $("#modal-addOutProduct").modal("hide");
    $("#preOutPoducts").html("");

}


function removeRow(elemento) {
    $(elemento).parent("td").parent("tr").remove();
}


function generarSalida() {
    if ($("#productosToOut tr").length <= 0) {
        $.notify("Para generar la salida de productos debe agregar al menos 1", "warning");
    } else if (!$("#medico").val()) {
        $.notify("Debe elegir un medico", "warning");
    } else if (!$("#paciente").val()) {
        $.notify("Debe elegir un paciente", "warning");
    } else {
        var formData = $("#form-genSalidas").serialize();
        $.ajax({
            url: APP_URL + 'class/Inventario.php',
            type: 'POST',
            dataType: 'json',
            data: formData,
            beforeSend: function() {
                $("#wait").show();
            },
            success: function(response) {
                if (response.estado == "1") {
                    $.notify(response.mensaje, "success");
                } else {
                    $.notify(response.mensaje, "error");
                }
            },
            error: function(error) {
                $.notify(error, "error");
            },
            complete: function() {
                $("#productosToOut").html("");
                $("#user").val("");
                $("#medico").val("");
                $("#paciente").val("");
                $("#searchPac").val("");
                $("#searchMed").val("");
                $("#comentario").val("");
                $("#wait").hide();
            }
        });
    }

}

function isDuplicatedProduct(id) {
    var toReturn = false;
    $("#preOutPoducts tr").each(function(ind, elem) {
        var val = $(elem).children("td");
        var idProd = $(val)[0].innerText;
        if (Number(id) === Number(idProd)) {
            toReturn = true;
            return false;
        }
    });
    if (!toReturn) {
        $("#productosToOut tr").each(function(ind, elem) {
            var val = $(elem).children("td");
            var idProd = $(val)[0].innerText;
            if (Number(id) === Number(idProd)) {
                toReturn = true;
                return false;
            }
        });
    }

    return toReturn;
}