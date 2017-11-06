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
    console.log(data);
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

function validarProducto() {
    if(!$("#fecha").val())
        $.notify("Ingresa la fecha de requerimiento", "error");
    else if(!$("#nombre").val())
        $.notify("Ingresa el nombre del producto", "error");
    else if(!$("#tipo").val())
        $.notify("Ingresa el tipo de producto", "error");
    else if(!$("#presentacion").val())
        $.notify("Ingresa la presentación del producto", "error");
    else if(!$("#piezas").val())
        $.notify("Ingresa las piezas del producto", "error");
    else if(!$("#cant_gramaje").val())
        $.notify("Ingresa la cantidad de gramaje del producto", "error");
    else if(!$("#gramaje").val())
        $.notify("Ingresa el gramaje del producto", "error");
    else if(!$("#solicitud").val())
        $.notify("Ingresa la cantidad a solicitar", "error");
    else
        addProducto();
}

function addProducto() {
    var producto = $("#nombre").val();
    var presentacion = $("#presentacion").val();
    var solicitud = $("#solicitud").val();
    var piezas = $("#piezas").val();
    var cant_gramaje = $("#cant_gramaje").val();
    var gramaje = $("#gramaje").val();

    if(producto && solicitud){
        $('#productos tr:last').after('<tr>' +
        '<td>' + producto + '<input id="v_producto[]" name="v_producto[]" type="hidden" value="' + producto + '"></td>' +
        '<td>' + presentacion + ' con ' + piezas + ' pieza(s) de ' + cant_gramaje + gramaje +

        '<input id="v_presentacion[]" name="v_presentacion[]" type="hidden" value="' + presentacion +'">' + 
        '<input id="v_piezas[]" name="v_piezas[]" type="hidden" value="' + piezas +'">' + 
        '<input id="v_gramaje[]" name="v_gramaje[]" type="hidden" value="' + gramaje +'">' +
        '<input id="v_cant_gramaje[]" name="v_cant_gramaje[]" type="hidden" value="' + cant_gramaje +'">' +


        '</td>' +
        '<td>' + solicitud + '<input id="v_solicitud[]" name="v_solicitud[]" type="hidden" value="' + solicitud + '"></td>' +
        '<td><a style="color:red" href="#" onclick="event.preventDefault();removeProducto(this)"><i class="glyphicon glyphicon-remove"></i></a></td>' + 
        '</tr>');
        cleanProductoForm();
    }else{
        $.notify("Debes capturar al menos un producto y la cantidad", "error");
    }   
}

function removeProducto(rProducto){
    var row = $(rProducto).parent("td").parent("tr");
    $(row).remove();
}

function cleanProductoForm() {
    $('#nombre').val('');
    $('#solicitud').val('');
    $('#presentacion').val('');
    $('#piezas').val('');
    $('#cant_gramaje').val('');
    $('#gramaje').val('');
}

function cleanAll() {
    cleanProductoForm();

    var table = document.getElementById("productos");
    for(var i = table.rows.length - 1; i > 0; i--) {
        table.deleteRow(i);
    }

    $('#presentacion').val('');
    $('#piezas').val('');
    $('#cant_gramaje').val('');
    $('#gramaje').val('');
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

    var columns = ["Fecha de Requerimiento", "Comentario"];
    var rows = [
        [$("#fecha").val(), $("#comentario").val()]
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