/**
 * Created by rk521 on 22.01.17.
 */
$('document').ready(function() {
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
            this.value = terms.join( ", " );
            return false;
        }
    });

    $("#gramaje").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 1,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                url : APP_URL + 'class/Inventario.php',
                data: {
                    search: $('#gramaje').val(),
                    get: 'getGramaje'
                },
                dataType: "json",
                success: function (data) {
                    response($.map(data.productos, function (el) {
                        return el.gramaje;
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

    $("#tipo").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 1,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                url : APP_URL + 'class/Inventario.php',
                data: {
                    search: $('#tipo').val(),
                    get: 'getTipo'
                },
                dataType: "json",
                success: function (data) {
                    response($.map(data.tipos, function (el) {
                        return el.tipo;
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

    $("#presentacion").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 1,
        source: function (request, response) {
            $.ajax({
                type : 'POST',
                url : APP_URL + 'class/Inventario.php',
                data: {
                    search: $('#presentacion').val(),
                    get: 'getPresentacion'
                },
                dataType: "json",
                success: function (data) {
                    response($.map(data.productos, function (el) {
                        return el.presentacion;
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

    $('#importe').keyup(function() {
        delay(function(){
            var iva = parseInt($('#importe').val()) * .16;
            $('#iva').val(iva);
            var total = parseInt($('#importe').val()) + iva;
            $('#total').val(total);
        }, 1000 );
    });

    $('#pneto').keyup(function() {
        delay(function(){
            var iva = parseInt($('#pneto').val()) * .16;
            $('#p_iva').val(iva);
            var total = parseInt($('#pneto').val()) + iva;
            $('#p_total').val(total);
        }, 1000 );
    });
});

var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

function createFacture() {
    var data = $("#create-form").serialize();
    $.ajax({
        type: 'POST',
        url: APP_URL + 'class/Facturas.php',
        data: data,
        dataType: "json",
        success: function (response) {
            if (response.estado == 1) {
                $.notify("Orden de comprada creada exitosamente", "success");
                $("#error").fadeIn(1000, function () {
                    $("#error").html('<div class="alert alert-success"> &nbsp; ' + response.mensaje + '</div>');
                });
                createPDF(response.id);
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

function addProducto() {
    var fechaCaducidad = new Date($("#fecha2").val());
    var hoy = new Date();
    if(fechaCaducidad >  hoy){
        $('#productos tr:last').after('<tr>' +
        '<td>' + $('#producto').val() + '<input id="v_producto[]" name="v_producto[]" type="hidden" value="' + $('#producto').val() + '"></td>' +
        '<td>' + $('#unidades').val() + '<input id="v_unidades[]" name="v_unidades[]" type="hidden" value="' + $('#unidades').val() + '"></td>' +
        '<td>' + $('#gramaje').val() + '<input id="v_gramaje[]" name="v_gramaje[]" type="hidden" value="' + $('#gramaje').val() + '"></td>' +
        '<td>' + $('#tipo').val() + '<input id="v_tipo[]" name="v_tipo[]" type="hidden" value="' + $('#tipo').val() + '"></td>' +
        '<td>' + $('#presentacion').val() + '<input id="v_presentacion[]" name="v_presentacion[]" type="hidden" value="' + $('#presentacion').val() + '"></td>' +
        '<td>' + $('#caja').val() + '<input id="v_caja[]" name="v_caja[]" type="hidden" value="' + $('#caja').val() + '"></td>' +
        '<td>' + $('#fecha2').val() + '<input id="v_caducidad[]" name="v_caducidad[]" type="hidden" value="' + $('#fecha2').val() + '"></td>' +
        '<td>' + $('#lote').val() + '<input id="v_lote[]" name="v_lote[]" type="hidden" value="' + $('#lote').val() + '"></td>' +
        '<td><a style="color:red" href="#" onclick="event.preventDefault();removeProducto(this)"><i class="glyphicon glyphicon-remove"></i></a></td>' + 
        '</tr>');
        cleanProductoForm();
    }else{
        $.notify("La fecha de caducidad no puede ser menor a la actual", "error");
    }
    
}

function removeProducto(rProducto){
    var row = $(rProducto).parent("td").parent("tr");
    $(row).remove();
}

function cleanProductoForm() {
    $('#producto').val('');
    $('#gramaje').val('');
    $('#unidades').val('');
}

function cleanAll() {
    cleanProductoForm();

    var table = document.getElementById("productos");
    for(var i = table.rows.length - 1; i > 0; i--) {
        table.deleteRow(i);
    }

    $('#fecha').val('');
    $('#factura').val('');
    $('#proveedor').val('');
    $('#importe').val('');
    $('#iva').val('');
    $('#total').val('');
}

function createPDF(id) {
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
        doc.text("Detalle de orden de compra   #" + id + "                  Fecha: " + new Date().getDate() + " de " + parseMonth() + " de " + new Date().getFullYear(), data.settings.margin.left, 22);

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
        [$("#fecha").val(), $("#credito").val()]
    ];

    doc.autoTable(columns, rows, {addPageContent: pageContent, startY: 30, theme: 'plain'});
    var elem = document.getElementById("productos");
    var res = doc.autoTableHtmlToJson(elem);
    doc.autoTable(res.columns, res.data, {startY: doc.autoTable.previous.finalY + 14});

    if (typeof doc.putTotalPages === 'function') {
        doc.putTotalPages(totalPagesExp);
    }

    doc.save('orden_de_compra-' + new Date().getDate() + '-' + (parseInt(new Date().getMonth() + 1)) + '-' + new Date().getFullYear() + '.pdf');

    cleanAll();
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