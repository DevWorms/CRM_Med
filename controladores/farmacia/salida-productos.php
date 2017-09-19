<?php include dirname(__FILE__) . '/../layouts/header.php'; ?>
<style>
    .ui-autocomplete { z-index:2147483647; }
</style>

<div class="container">
    <?php include dirname(__FILE__) . "/../layouts/navbar.php"; ?>
</div>
    
<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>

        <input type="hidden" id="get" name="get" value="create">
        <div class="col-md-9">
            <div class="thumbnail">
                <div class="caption-full">
                    <h2 style="display:inline; color:#337ab7;">Farmacia - Salida de Productos </h2>

                    <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right"
                          title="Registrar la salida de productos de farmacia y sus involucrados"></span>
                    <hr>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10 col-md-ofset-1">
                            <div class="row">
                                <button class="col-md-12 btn btn-info" onclick='$("#modal-addOutProduct").modal().show()'>
                                    <i class="glyphicon glyphicon-plus"></i> Añadir Producto
                                </button>
                            </div>
                            <br>
                            <!--FORM-->
                            <form id="form-genSalidas">
                            <input type="hidden" id="user" name="user" value="<?php echo $_SESSION["Id"];?>">
                            <input type="hidden" id="medico" name="medico" value="">
                            <input type="hidden" id="paciente" name="paciente" value="">
                            <input type="hidden" id="get" name="get" value="generarSalida">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th style="display: none;">id</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>&nbsp;</th>
                                        </thead>
                                        <tbody id="productosToOut"></tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="searchPac" name="searchPac" class="form-control" placeholder="Para que paciente">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="searchMed" name="searchMed" class="form-control" placeholder="Médico que solicita">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea style="resize: none;" name="comentario" id="comentario"  class="form-control" placeholder="Comentarios ..."></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-9"></div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary" type="button" onclick="generarSalida()">
                                        <i class="glyphicon glyphicon-tag"></i>
                                        Registrar salida
                                    </button>
                                </div>
                            </div>
                            </form>
                            <!--form-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS PARA SELECCION DE PRODUCTOS, MEDICO Y PACIENTE-->
    <div id="modal-addOutProduct" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Agregar productos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control ui-autocomplete-input" id="searchProd" name="searchProd" placeholder="Buscar producto" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <th style="display: none;">ID</th>
                                    <th>Producto</th>
                                    <th>Existencia</th>
                                    <th>Cantidad</th>
                                    <th>&nbsp;</th>
                                </thead>
                                <tbody id="preOutPoducts">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div align="center" class="col-md-12">
                            <button class="btn btn-info" onclick="pastProductoSelection()">
                                Listo <i class="glyphicon glyphicon-ok-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ MODALS PARA SELECCION DE PRODUCTOS, MEDICO Y PACIENTE-->
</div>

<script src="<?php echo app_url(); ?>js/salida_productos.js" type="text/javascript"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>
