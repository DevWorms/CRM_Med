    <?php
        include dirname(__FILE__) . '/../layouts/header.php';
    ?>

    <div class="container">
        <?php include dirname(__FILE__) . "/../layouts/navbar.php"; ?>
    </div>
    
    <!-- Page Content -->
    <div class="container">
        <div class="row">

            <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>

			<div class="col-md-9"  style="overflow-x: scroll;">
                <div class="thumbnail border_content"  style="overflow-x: scroll;">
                    <div class="caption-full" ng-app="">

                        <h2 style="display:inline;" class="title_header">Farmacia - Añadir Productos </h2>

                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Añade productos nuevos al inventario de Farmacia; puedes visualizar una vista preliminar en la parte final del formulario."></span>

                        <div id="error"></div>

                        <hr>

                        <form action="" method="POST" id="create-form">
                            <input type="hidden" name="get" id="get" value="create">
                            <!-- PRIMERA FILA -->
                            <div class="form-group row">
                                <div class="col-md-4">
	                                <fieldset class="form-inline">
	                                    <label for="">Producto</label><br>
	                                    <input type="text" class="search-query form-control input-width" id="nombre" name="nombre" placeholder="Nombre del Producto" ng-model="nombre" required/>
	                                </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Tipo</label><br>
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
                            <!-- FIN PRIMERA FILA -->

							<!-- SEGUNDA FILA -->
                            <div class="form-group row space">
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="piezas">Cantidad de Piezas</label>
                                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Cantidad de piezas o productos que contiene la presentación."></span>
                                        <br>
                                        <input type="text" id="piezas" name="piezas" class="form-control input-width" placeholder="Ejemplo: 5, 10, 20, 100" ng-model="piezas" required>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="existencia">Cantidad de gramaje</label>
                                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="La cantidad de gramaje que tiene el producto."></span>
                                        <br>
                                        <input type="text" id="cant_gramaje" name="cant_gramaje" class="form-control input-width" placeholder="Ejemplo: 1, 10, 15, 20" ng-model="cantidad" required>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Gramaje</label>
                                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Unidad de medida que tiene el producto."></span>
                                        <br>
                                        <input type="text" class="form-control ui-autocomplete-input input-width" id="gramaje" name="gramaje" placeholder="Ejemplo: gr, ui, pz, ml" ng-model="gramaje" required/>
                                    </fieldset>
                                </div>
                            </div>
							<!-- FIN SEGUNDA FILA -->

                            <!-- TERCERA FILA -->
                            <div class="form-group row space">

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Fecha de Caducidad</label>
                                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Si el producto no caduca, recomendamos agrega una fecha superior a 2 años."></span>
                                        <br>
                                        <div class="input-group">
                                        <input type="text" class="search-query form-control" id="fecha" name="fecha" placeholder="aaaa / mm / dd" ng-model="caducidad" required/>
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
                                        <label for="lote">Lote</label>
                                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Número de Lote del producto que gestiona mejor su trazabilidad."></span>
                                        <br>
                                        <input type="text" id="lote" name="lote" class="form-control input-width" placeholder="Lote del Producto" ng-model="lote" required>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="existencia">Existencia </label>
                                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Este será el número que se restará cada que se genere una salida del producto."></span>
                                        <br>
                                        <input type="text" id="existencia" name="existencia" class="form-control input-width" placeholder="Cantidad de productos a ingresar" ng-model="existencia" required>
                                    </fieldset> 
                                </div>
                            </div>
                            <!-- FIN TERCERA FILA -->

                            <!-- CUARTA FILA -->
                            <div class="form-group row space">

                                <div class="col-md-6">
                                    <fieldset class="form-inline">
                                        <label for="descripcion">Descripción (Opcional)</label><br>
                                        <textarea id="descripcion" name="descripcion" class="form-control input-width" placeholder="Agrega una descripción del producto."></textarea>
                                    </fieldset>
                                </div>         

                                <div class="col-md-4" align="right">
                                    <fieldset class="form-inline fs-sp">
                                        <button class="btn btn-primary btn-form" onclick="event.preventDefault(); createProducto();" name=""><b>Añadir</b></button>
                                    </fieldset>
                                </div>                      
                            </div>
                            <!-- FIN CUARTA FILA -->
                        </form>

                        <hr>


                        <h3 align="center">Vista preliminar en Inventario.</h3>
                        <!-- Contactos -->
                        <table class="table table-bordered table-striped" id="catalogo" style="font-size: 90%">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Tipo</th>
                                <th>Presentación</th>
                                <th>Fecha de Caducidad</th>
                                <th>Lote</th>
                                <th>Existencia</th>
                            </tr>
                            </thead>
                            <tbody>
                                <td>{{nombre}}</td>
                                <td>{{tipo}}</td>
                                <td>{{presentacion}} con {{piezas}} pieza(s) de  {{cantidad}}{{gramaje}}</td>
                                <td>{{caducidad}}</td>
                                <td>{{lote}}</td>
                                <td>{{existencia}}</td>
                            </tbody>
                        </table>
                        

                        <div id="error"></div>
                        <!-- Contactos -->
                </div>
            </div>
    
    <script type="text/javascript" src="<?php echo app_url(); ?>js/nuevos_productos.js"></script>
    <script type="text/javascript" src="<?php echo app_url(); ?>js/angular.min.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>
