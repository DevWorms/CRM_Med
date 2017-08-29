/**
 * Created by rk521 on 22.01.17.
 */
$('document').ready(function() {
    if (!$("#orden_id").val()) {
        $("#nuevaFactura input").prop("disabled", true);
    }

    $("#validateOrden").click(function () {
        validar();
    });

    $("#terminar").hide();
    $("#imprimir").hide();
    $("#registrar").hide();

    $("#proveedor").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                url : APP_URL + 'class/Facturas.php',
                data: {
                    search: $('#proveedor').val(),
                    get: 'proveedores'
                },
                dataType: "json",
                success: function (data) {
                    response($.map(data.proveedores, function (el) {
                        return el.nombre;
                    }));
                }, error: function (data) {
                    console.log("error" + data);
                }
            });
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        delay: 700,
        select: function( event, ui ) {
            //var terms = split(this.value) ;
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
});

function validar() {
    var id = $("#param").val();
    $("#error").html('');
    // Limpia la tabla de productos
    var table = document.getElementById("productos");
    for(var i = table.rows.length - 1; i > 0; i--) {
        table.deleteRow(i);
    }

    $.ajax({
        type : 'POST',
        post: 'autoSearch',
        url  : APP_URL + 'class/Facturas.php',
        data : {
            get: 'getOrden',
            id: id
        },
        success: function (data) {
            data = JSON.parse(data);
            if (data.estado == 1) {
                // habilita el form y carga el valor de la orden
                $("#nuevaFactura input").prop("disabled", false);
                $("#orden_id").val(data.orden.id);
                $("#orden_fecha").val(data.orden.fecha_requerimiento);
                $("#orden_credito").val(data.orden.dias_credito);
                $("#registrar").show();

                //Muestra los productosv
                var observacion = "";
                data.productos.forEach(function (p) {
                    if( p.observacion != null && p.observacion != ""){
                        observacion = p.observacion;
                    }else{
                        observacion = '<span class="glyphicon glyphicon-remove"></span>';
                    }
                    $('#productos tr:last').after('<tr>' +
                        '<td>' + p.producto + '<input id="v_producto[]" name="v_producto[]" type="hidden" value="' + p.producto + '"></td>' +
                        '<td>' + p.unidades + '<input id="v_unidades[]" name="v_unidades[]" type="hidden" value="' + p.unidades + '"></td>' +
                        '<td>' + p.gramaje + '<input id="v_gramaje[]" name="v_gramaje[]" type="hidden" value="' + p.gramaje + '"></td>' +
                        '<td>' + p.tipo + '<input id="v_tipo[]" name="v_tipo[]" type="hidden" value="' + p.tipo + '"></td>' +
                        '<td>' + p.presentacion + '<input id="v_presentacion[]" name="v_presentacion[]" type="hidden" value="' + p.presentacion + '"></td>' +
                        '<td>' + p.caja + '<input id="v_caja[]" name="v_caja[]" type="hidden" value="' + p.caja + '"></td>' +
                        '<td>' + p.caducidad + '<input id="v_caducidad[]" name="v_caducidad[]" type="hidden" value="' + p.caducidad + '"></td>' +
                        '<td>' + p.lote + '<input id="v_lote[]" name="v_lote[]" type="hidden" value="' + p.lote + '"></td>' +
                        '<td align="center" style="color:red;cursor:pointer"><div id="addObservacion-'+p.id+'" onclick="openModal('+p.id+');">'+observacion+'</td>'+
                        '</tr>');

                    var actionsTemplate = _.template($('#modal_detalle').text());
                    $('#modals').append(actionsTemplate(p));
                });
            } else {
                // habilita el form y carga el valor de la orden
                $("#nuevaFactura input").prop("disabled", true);
                $("#orden_id").val(data.id);

                $("#error").fadeIn(1000, function() {
                    $("#error").html('<div class="alert alert-danger"> &nbsp; ' + data.mensaje + '</div>');
                });
            }
        },
        error: function (data) {
            $("#error").fadeIn(1000, function() {
                $("#error").html('<div class="alert alert-danger"> &nbsp; ' + data.mensaje + '</div>');
            });
        }
    });

    $('#importe').keyup(function() {
        delay(function(){
            var iva = parseInt($('#importe').val()) * .16;
            $('#iva').val(iva);
            var total = parseInt($('#importe').val()) + iva;
            $('#total').val(total);
        }, 1000 );
    });
}

var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

function createFactura() {
    $("#error").fadeIn(1000, function () {
        $("#error").html('');
    });

    var data = $("#nuevaFactura").serialize();

    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Facturas.php',
        data: data,
        dataType: "json",
        success: function (response) {
            if (response.estado == 1) {
                $.notify("Factura creada exitosamente", "success");
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-success"> &nbsp; ' + response.mensaje + '</div>');
                });

                limpiar();
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

function openModal(id) {
    $("#observacionProducto-"+id).text($("#addObservacion-" + id).text());
    $("#Observacion-" + id).modal("show");
}

function limpiar() {
    $("#registrar").hide();
    $("#terminar").show();
    $("#imprimir").show();
}

function terminar() {
    $("#terminar").hide();
    $("#imprimir").hide();
    $("#registrar").hide();
    $("#param").val("");

    $('#nuevaFactura')[0].reset();
    $("#error").html("");

    $("#nuevaFactura input").prop("disabled", true);
    $("#orden_id").val("");

    // Limpia la tabla de productos
    var table = document.getElementById("productos");
    for(var i = table.rows.length - 1; i > 0; i--) {
        table.deleteRow(i);
    }
}

function imprimir() {
    var doc = new jsPDF();
    var totalPagesExp = "{total_pages_count_string}";

    function parseMonth() {
        switch (new Date().getMonth()+1) {
            case 1:
                return "Enero";
                break;
            case 2:
                return "Febrero";
                break;
            case 3:
                return "Marzo";
                break;
            case 4:
                return "Abril";
                break;
            case 5:
                return "Mayo";
                break;
            case 6:
                return "Junio";
                break;
            case 7:
                return "Julio";
                break;
            case 8:
                return "Agosto";
                break;
            case 9:
                return "Septiembre";
                break;
            case 10:
                return "Octubre";
                break;
            case 11:
                return "Noviembre";
                break;
            case 12:
                return "Diciembre";
                break;
        }
    }

    var base64Img = null;

    imgToBase64(APP_URL + 'img/logo1.jpg', function(base64) {
        base64Img = base64;
    });

    var pageContent = function (data) {
        // HEADER
        doc.setFontSize(12);
        doc.setTextColor(40);
        doc.setFontStyle('normal');

        if (base64Img) {
            doc.addImage(base64Img, 'JPEG', data.settings.margin.left, 15, 10, 10);
        }
        doc.text("Detalle de factura   #" + $("#factura").val() + "                  Fecha: " + new Date().getDate() + " de " + parseMonth() + " de " + new Date().getFullYear(), data.settings.margin.left, 22);

        // FOOTER
        var str = "Página " + data.pageCount;
        // Total page number plugin only available in jspdf v1.0+
        if (typeof doc.putTotalPages === 'function') {
            str = str + " de " + totalPagesExp;
        }
        doc.setFontSize(10);
        doc.text(str, data.settings.margin.left, doc.internal.pageSize.height - 10);
    };

    var columns = ["Fecha de Requerimiento", "Días de crédito"];
    var rows = [
        [$("#orden_fecha").val(), $("#orden_credito").val()]
    ];
    doc.autoTable(columns, rows, {addPageContent: pageContent, startY: 30, theme: 'plain'});


    var columnsF = ["Fecha de Incorporación", "Proveedor", "Precio Neto", "IVA", "Total"];
    var rowsF = [
        [$("#fecha").val(), $("#proveedor").val(), $("#importe").val(), $("#iva").val(), $("#total").val()]
    ];
    doc.autoTable(columnsF, rowsF, {addPageContent: pageContent, startY: 50, theme: 'plain'});

    var elem = document.getElementById("productos");
    var res = doc.autoTableHtmlToJson(elem);
    doc.autoTable(res.columns, res.data, {startY: doc.autoTable.previous.finalY + 14});

    if (typeof doc.putTotalPages === 'function') {
        doc.putTotalPages(totalPagesExp);
    }

    doc.save('Detalle_factura-' + new Date().getDate() + '-' + (parseInt(new Date().getMonth() + 1)) + '-' + new Date().getFullYear() + '.pdf');
}

function imgToBase64(url, callback) {
    if (!window.FileReader) {
        callback(null);
        return;
    }
    var xhr = new XMLHttpRequest();
    xhr.responseType = 'blob';
    xhr.onload = function() {
        var reader = new FileReader();
        reader.onloadend = function() {
            callback(reader.result.replace('text/xml', 'image/jpeg'));
        };
        reader.readAsDataURL(xhr.response);
    };
    xhr.open('GET', url);
    xhr.send();
}

function addObservacion(id) {
    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Facturas.php',
        data: {
            get: 'addObservacion',
            id: id,
            observacion: $("#observacionProducto-"+id).val()
        },
        dataType: "json",
        success: function (response) {
            if (response.estado == 1) {
                $.notify(response.mensaje, "success");
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-success"> &nbsp; ' + response.mensaje + '</div>');
                });

                $("#addObservacion-"+id).html("");
                $("#addObservacion-"+id).html($("#observacionProducto-"+id).val());
                $("#Observacion-"+id).modal('hide');
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