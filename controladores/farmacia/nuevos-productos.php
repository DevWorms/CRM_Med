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
                <div class="thumbnail"  style="overflow-x: scroll;">
                    <div class="caption-full">

                        <h2 style="display:inline; color:#337ab7;">Farmacia - Añadir Productos </h2>

                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Añade productos nuevos al área de farmacia para llevar el control de productos"></span>

                        <div id="error"></div>

                        <hr>

                        <form action="" method="POST" id="create-form">
                        	<br>
                            <input type="hidden" name="get" id="get" value="create">
                            <!-- PRIMERA FILA -->
                            <div class="form-group row">
                                <div class="col-md-4">
	                                <fieldset class="form-inline">
	                                    <label for="">Producto&nbsp;&nbsp;</label><br>
	                                    <input type="text" class="search-query form-control input-width" id="nombre" name="nombre" placeholder="Nombre del Producto" required/>
	                                </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Tipo&nbsp;&nbsp;</label><br>
                                        <select class="selectpicker" id="tipo" name="tipo">
                                          <option value="Consumible">Consumible</option>
                                          <option value="Medicamento">Medicamento</option>
                                          <option value="Insumos">Insumos</option>
                                          <option value="Otros">Otros</option>
                                        </select>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Presentación&nbsp;&nbsp;</label><br>
                                        <input type="text" class="form-control ui-autocomplete-input input-width" id="presentacion" name="presentacion" placeholder="Ejemplo: caja, bolsa, frasco" required/>
                                    </fieldset>
                                </div>
                            </div>
                            <!-- FIN PRIMERA FILA -->

							<!-- SEGUNDA FILA -->
                            <div class="form-group row space">
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="piezas">Cantidad de Piezas&nbsp;&nbsp;</label><br>
                                        <input type="text" id="piezas" name="piezas" class="form-control input-width" placeholder="Ejemplo: 5, 10, 20, 100" required>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="existencia">Cantidad de gramaje&nbsp;&nbsp;</label><br>
                                        <input type="text" id="cant_gramaje" name="cant_gramaje" class="form-control input-width" placeholder="Ejemplo: 1, 10, 15, 20" required>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Gramaje&nbsp;&nbsp;</label><br>
                                        <input type="text" class="form-control ui-autocomplete-input input-width" id="gramaje" name="gramaje" placeholder="Ejemplo: gr, ui, pz, ml" required/>
                                    </fieldset>
                                </div>
                            </div>
							<!-- FIN SEGUNDA FILA -->

                            <!-- TERCERA FILA -->
                            <div class="form-group row space">

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Fecha de Caducidad&nbsp;&nbsp;</label><br>
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

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="lote">Lote&nbsp;&nbsp;</label><br>
                                        <input type="text" id="lote" name="lote" class="form-control input-width" placeholder="Lote del Producto" required>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="existencia">Existencia </label>
                                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Este será el número que se restará cada que se genere una salida del producto."></span>
                                        <br>
                                        <input type="text" id="existencia" name="existencia" class="form-control input-width" placeholder="Cantidad de productos a ingresar" required>
                                    </fieldset> 
                                </div>
                            </div>
                            <!-- FIN TERCERA FILA -->

                            <!-- CUARTA FILA -->
                            <div class="form-group row space">

                                <div class="col-md-6">
                                    <fieldset class="form-inline">
                                        <label for="descripcion">Descripción (Opcional) &nbsp;&nbsp;</label><br>
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

                        

                        <div id="error"></div>
                        <!-- Contactos -->
                </div>
            </div>
    
    <script type="text/javascript" src="<?php echo app_url(); ?>js/nuevos_productos.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>
