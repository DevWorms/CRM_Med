<?php include dirname(__FILE__) . '/../layouts/header.php'; ?>

<div class="container">
    <?php include dirname(__FILE__) . "/../layouts/navbar.php"; ?>
</div>
    
<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>

        <input type="hidden" id="get" name="get" value="create">
        <div class="col-md-9">
            <div class="thumbnail border_content">
                <div class="caption-full">
                    <h2 style="display:inline;" class="title_header">Farmacia - Registrar Factura </h2>
                    <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Registra los productos solicitados en la orden de compra y corrobora que todos los productos hayan sido entregados. Al registrar la factura, los productos se agregan automáticamente al inventario"></span>
                    <hr>

                    <div class="form-group row">
                        <div class="col-md-12" align="center">
                            <div id="custom-search-input">
                                <div class="input-group col-md-9">
                                    <input type="text" class="search-query form-control" id="param" name="param"
                                           placeholder="Buscar orden de compra por folio"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="validateOrden">
                                            <span class=" glyphicon glyphicon-search"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="nuevaFactura" name="nuevaFactura" method="POST">
                        <div id="error"></div>
                        <br>
                        <input type="hidden" value="" id="orden_id" name="orden_id">
                        <input type="hidden" value="" id="orden_fecha" name="orden_fecha">
                        <input type="hidden" value="" id="orden_caja" name="orden_caja">
                        <input type="hidden" value="" id="orden_pastilla" name="orden_pastilla">
                        <input type="hidden" value="" id="orden_credito" name="orden_credito">
                        <input type="hidden" id="get" name="get" value="createFactura">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <div>
                                            <label for="factura">Número o Folio de Factura</label>
                                            <input type="text" class="form-control" id="factura" name="factura" placeholder="Número de Factura" required>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="fecha">Fecha de Factura</label>
                                        <span class="glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Fecha en que se generó la compra."></span>
                                        <div class="input-group">
                                            <input type="text" class="search-query form-control" id="fecha" name="fecha"
                                                   placeholder="aaaa / mm / dd" required/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <div>
                                            <label for="proveedor">Proveedor</label>
                                            <span class="glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Nombre del proveedor que generó la factura."></span>
                                            <br>
                                            <input type="text" class="form-control" id="proveedor" name="proveedor" placeholder="Proveedor" required>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <br>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="importe">Precio Bruto</label>
                                        <span class="glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Precio antes de IVA."></span>
                                        <input type="number" class="form-control" id="importe" name="importe"
                                               placeholder="" required>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="iva">IVA</label>
                                        <span class="glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Monto del IVA."></span>
                                        <br>
                                        <input type="number" class="form-control" id="iva" name="iva" required>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                            <label for="total">Total</label>
                                            <span class="glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Suma del precio bruto más IVA registrado en la factura de compra."></span>
                                            <br>
                                            <input type="number" class="form-control" id="total" name="total"   required>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <hr class="dashed">


                            <h4 align="center">Productos en la orden de compra.</h4>

                                <table class="table table-bordered table-striped" id="productos">
                                    <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Tipo</th>
                                        <th>Presentación</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario<br>
                                            <span class="glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Costo de compra por unidad del producto agregado."></span>
                                        </th>
                                        <th>Fecha de Caducidad<br>
                                            <span class="glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Fecha de caducidad del lote a ingresar."></span>
                                        </th>
                                        <th>Lote<br>
                                            <span class="glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Número de lote del producto que gestiona mejor su trazabilidad."></span>
                                        </th>
                                        <th>Existencia<br>
                                            <span class="glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Este será el número que se restará cada que se genere una salida de inventario"></span>
                                        </th>
                                        <th>
                                            Disponible<br>
                                            <span class="glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Si el producto no se encontró disponible, marcar la casilla y añadir una observación"></span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            <div class="form-group" align="center">
                                <span class="btn btn-default" onclick="event.preventDefault(); terminar();"
                                      id="terminar">Terminar</span>
                                <span class="btn btn-primary" onclick="event.preventDefault(); createFactura();"
                                      id="registrar">Guardar Factura</span>
                                <span class="btn btn-success" onclick="event.preventDefault(); imprimir();"
                                      id="imprimir">Imprimir Informe</span>
                            </div>

                    </form>
                </div>
            </div>

                <div id="modals"></div>
                <script type="text/template" id="modal_detalle">
                    <div id="Observacion-${id}" class="modal" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="text-align:center;">${nombre}</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <div class="col-md-12">
                                            <label for="observacionProducto-${id}">Observación</label>
                                            <textarea class="form-control" id="observacionProducto-${id}"
                                                      name="observacionProducto-${id}" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-group" align="right">
                                        <div class="col-md-12">
                                            <div class="col-md-8"></div>
                                            <div class="col-md-4">
                                                <button class="btn btn-primary btn-block" type="submit" name="up_button"
                                                        onclick="event.preventDefault(); addObservacion(${id})"
                                                        id="up_button">Guardar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </script>

                <script src="<?php echo app_url(); ?>js/facturasNew.js" type="text/javascript"></script>
                <script src="<?php echo app_url(); ?>js/jsPDF/jspdf.min.js" type="text/javascript"></script>
                <script src="<?php echo app_url(); ?>js/jsPDF/jspdf.plugin.autotable.js"
                        type="text/javascript"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>