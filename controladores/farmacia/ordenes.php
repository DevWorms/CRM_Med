    <?php include dirname(__FILE__) . '/../layouts/header.php'; ?>
    
    <div class="container">
        <?php include dirname(__FILE__) . "/../layouts/navbar.php"; ?>
    </div>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>

            <form action="" method="POST" id="create-form" ng-app="">
                <input type="hidden" id="get" name="get" value="create">

                <div class="col-md-9">
                    <div class="thumbnail border_content">
                        <div class="caption-full">
                            <h2 style="display:inline;" class="title_header">Farmacia - Ordenes de compra </h2>
                                <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Genera una nueva orden de compra para los productos en inventario."></span>

                                <div id="error"></div>

                                 <hr>  
                        
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <fieldset class="form-inline">
                                            <label for="fecha">Fecha de Requerimiento</label>
                                            <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Añade la fecha para cuando requieres los productos."></span>
                                            <div class="input-group">
                                                <input type="text" class="search-query form-control" id="fecha" name="fecha" placeholder="aaaa / mm / dd" required/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="button">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                            <label for="comentario">Comentario (Opcional)</label>
                                            <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Comentario adicional para el encargado de compras."></span>
                                            <textarea class="form-control" id="comentario" name="comentario"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                </div>
                        </div>      
                    </div>

                    <div class="thumbnail border_content">
                        <div class="caption-full">

                            <div class="form-group row space">
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Producto</label><br>
                                        <input type="text" class="search-query form-control input-width" id="nombre" name="nombre" placeholder="Nombre del Producto" ng-model="nombre" required/>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Tipo</label>
                                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="No aparecerá en la lista de compras, es para la captura del producto a inventario."></span>
                                        <select class="selectpicker" id="tipo" name="tipo" ng-model="tipo">
                                            <option value="Consumible">Consumible</option>
                                            <option value="Medicamento">Medicamento</option>
                                            <option value="Insumos">Insumos</option>
                                            <option value="Otros">Otros</option>
                                        </select>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Presentación</label><br>
                                        <input type="text" class="form-control ui-autocomplete-input input-width" id="presentacion" name="presentacion" placeholder="Ejemplo: caja, bolsa, frasco" ng-model="presentacion" required/>
                                    </fieldset>
                                </div>
                            </div>

                            <br>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <fieldset class="form-inline">
                                        <label for="piezas">Cantidad de Piezas</label>
                                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Cantidad de piezas o productos que contiene la presentación."></span>
                                        <br>
                                        <input type="number" min="1" id="piezas" name="piezas" class="form-control input-width" placeholder="Ejemplo: 5, 10, 20, 100" ng-model="piezas" required>
                                    </fieldset>
                                </div>

                                <div class="col-md-3">
                                    <fieldset class="form-inline">
                                        <label for="existencia">Cantidad de gramaje</label>
                                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="La cantidad de gramaje que tiene el producto."></span>
                                        <br>
                                        <input type="text" id="cant_gramaje" name="cant_gramaje" class="form-control input-width" placeholder="Ejemplo: 1, 10, 15, 20" ng-model="cantidad" required>
                                    </fieldset>
                                </div>

                                <div class="col-md-3">
                                    <fieldset class="form-inline">
                                        <label for="">Gramaje</label>
                                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Unidad de medida que tiene el producto."></span>
                                        <br>
                                        <input type="text" class="form-control ui-autocomplete-input input-width" id="gramaje" name="gramaje" placeholder="Ejemplo: gr, ui, ml" ng-model="gramaje" required/>
                                    </fieldset>
                                </div>

                                <div class="col-md-3">
                                    <fieldset class="form-inline">
                                        <label for="piezas">Cantidad de Solicitud</label>
                                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="El número de productos que solicitarás."></span>
                                        <br>
                                        <input type="number" min="1" id="solicitud" name="solicitud" class="form-control input-width" placeholder="Ejemplo: 5, 10, 20, 100" ng-model="solicitud" required>
                                    </fieldset>
                                </div>
                            </div>

                            <hr>

                            <h4 align="center">Vista preliminar en solicitud.</h4>
                    
                            <!-- Contactos -->
                            <table class="table table-bordered table-striped" id="catalogo" style="font-size: 90%">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Presentación</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>{{nombre}}</td>
                                    <td>{{presentacion}} con {{piezas}} pieza(s) de  {{cantidad}}{{gramaje}}</td>
                                    <td>{{solicitud}}</td>
                                </tbody>
                            </table>



                            <div class="form-group row">
                                <div class="col-md-12">
                                    <fieldset class="form-inline" style="margin-top: 10px" align="center">
                                        <button onclick="event.preventDefault(); validarProducto();" class="derecha btn btn-primary">Añadir</button>
                                    </fieldset>
                                </div>
                            </div>

                            <hr class="dashed">

                            <table class="table table-bordered table-striped" id="productos">
                                    <thead>
                                      <tr>
                                          <th>Producto</th>
                                          <th>Presentación</th>
                                          <th>Cantidad</th>
                                          <th>Quitar</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                            </table>
                    
                            <div class="form-group" align="center">
                                    <button onclick="event.preventDefault(); createFacture();" class="btn btn-success btn_exito">Generar orden de compra</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    
    <script type="text/javascript" src="<?php echo app_url(); ?>js/angular.min.js"></script>
    <script src="<?php echo app_url(); ?>js/facturas.js" type="text/javascript"></script>
    <script src="<?php echo app_url(); ?>js/jsPDF/jspdf.min.js" type="text/javascript"></script>
    <script src="<?php echo app_url(); ?>js/jsPDF/jspdf.plugin.autotable.js" type="text/javascript"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>