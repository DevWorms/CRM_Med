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

                        <h2 style="display:inline; color:#337ab7;">Farmacia - Inventario</h2>

                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Inventario actual de farmacia."></span>

                        <div id="error"></div>

                        <hr>

                        

                        <div class="form-group row">
                            <div class="col-md-12" align="center">
                                <form action="" method="POST" id="search-form">
                                    <div class="input-group col-md-9">
                                        <input type="text" class="search-query form-control" id="search" name="search"  placeholder="Buscar ..." required>
                                        <span class="input-group-btn">
                                            <button  class="btn btn-primary" type="button" onclick="event.preventDefault(); searchProducto();">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div id="error"></div>
                        <!-- Contactos -->
                        <table class="table table-bordered table-striped" id="catalogo" style="font-size: 90%">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Existencia</th>
                                <th>Tipo</th>
                                <th>Presentación</th>
                                <th>Lote</th>
                                <th>Fecha de Caducidad</th>
                                <th>Editar</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div align="center" class="thumbnail">
                            <ul class="pagination" id="pagination">
                            </ul>
                        </div>
                </div>
            </div>
    <!-- MODAL EDICION PRODUCTOS -->
    <div id="modal-editProducto" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Editar producto</h4>
            </div>
            <div class="modal-body">
              <form action="" method="POST" id="editProd-form" name="editProd-form">
                <input type="hidden" name="get" id="get" value="modifyProducto">

                <!-- PRIMERA FILA -->
                <div class="form-group row">
                    <div class="col-md-4">
                        <fieldset class="form-inline">
                            <label for="">Producto&nbsp;&nbsp;</label><br>
                            <textarea class="search-query form-control input-width" id="e-nombre" name="e-nombre" placeholder="" required></textarea>
                        </fieldset>
                    </div>

                    <div class="col-md-4">
                        <fieldset class="form-inline">
                            <div>
                                <label for="">Tipo&nbsp;&nbsp;</label><br>
                                <select class="selectpicker" id="e-tipo" name="e-tipo">
                                  <option value="Consumible">Consumible</option>
                                  <option value="Medicamento">Medicamento</option>
                                  <option value="Insumos">Insumos</option>
                                  <option value="Otros">Otros</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-md-4">
                        <fieldset class="form-inline">
                            <div style="width: 100%">
                                <label for="">Presentación&nbsp;&nbsp;</label><br>
                                <select class="selectpicker" id="e-presentacion" name="e-presentacion">
                                  <option value="Caja">Caja</option>
                                  <option value="Bolsa">Bolsa</option>
                                  <option value="Solucion">Solucion</option>
                                  <option>* Nuevo</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <!-- FIN PRIMERA FILA -->

                <!-- SEGUNDA FILA -->
                <div class="form-group row space">
                    <div class="col-md-4">
                        <fieldset class="form-inline">
                            <label for="e-piezas">Cantidad de Piezas&nbsp;&nbsp;</label><br>
                            <input type="text" id="e-piezas" name="e-piezas" class="form-control input-width" required>
                        </fieldset>
                    </div>

                    <div class="col-md-4">
                        <fieldset class="form-inline">
                            <label for="e-cant_gramaje">Cantidad de Gramaje&nbsp;&nbsp;</label><br>
                            <input type="text" id="e-cant_gramaje" name="e-cant_gramaje" class="form-control input-width" required>
                        </fieldset>
                    </div>

                    <div class="col-md-4">
                        <fieldset class="form-inline">
                            <div>
                                <label for="">Gramaje&nbsp;&nbsp;</label><br>
                                <select class="selectpicker" id="e-gramaje" name="e-gramaje">
                                  <option value="gr">gr</option>
                                  <option value="kg">kg</option>
                                  <option value="ml">ml</option>
                                  <option value="L">L</option>
                                  <option>* Nuevo</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <!-- FIN SEGUNDA FILA -->

                <div class="form-group row space"> 

                    <div class="col-md-4">
                        <fieldset class="form-inline">
                            <label for="">Fecha de Caducidad&nbsp;&nbsp;</label><br>
                            <div class="input-group">
                            <input type="text" class="search-query form-control" id="e-fecha" name="e-fecha" placeholder="aaaa / mm / dd" required/>
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
                            <label for="e-lote">Lote&nbsp;&nbsp;</label><br>
                            <input type="text" id="e-lote" name="e-lote" class="form-control input-width" required>
                        </fieldset>
                    </div>

                    <div class="col-md-4">
                        <fieldset class="form-inline">
                            <label for="e-existencia">Existencia&nbsp;&nbsp;</label><br>
                            <input type="text" id="e-existencia" name="e-existencia" class="form-control input-width" required>
                        </fieldset>
                    </div>
                </div>

                <!-- BOTON -->
                <div class="form-group row space">    
                    <div class="col-md-6">
                        <fieldset class="form-inline">
                            <label for="e-descripcion">Descripción (Opcional)&nbsp;&nbsp;</label><br>
                            <textarea id="e-descripcion" name="e-descripcion" class="form-control input-width"></textarea>
                        </fieldset>
                    </div>
                </div>
                <!-- FIN BOTON -->
            </form>
                </div>
                <div class="modal-footer" id="editModifyProd">

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo app_url(); ?>js/inventario.js"></script>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>
