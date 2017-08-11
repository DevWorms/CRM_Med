<?php include dirname(__FILE__) . '/../layouts/header.php'; ?>
<style>
    .ui-autocomplete { z-index:2147483647; }
</style>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>

        <input type="hidden" id="get" name="get" value="create">
        <div class="col-md-9">
            <div class="thumbnail">
                <div class="caption-full">
                    <h2 style="display:inline; color:#337ab7;">Farmacia - Reporte Salida de Productos </h2>

                    <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right"
                          title="Enlista las salidas de productos generadas"></span>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Filtros de búsqueda</h4>
                            <hr>
                            <form id="form-getSalidas">
                            <input type="hidden" id="get" name="get" class="form-control" value="reporteSalidaProductos">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" id="searchUser" name="searchUser" class="form-control" placeholder="Buscar por usuario">
                                    <input type="hidden" id="usuario" name="usuario" class="form-control" value="0">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="searchMed" name="searchMed" class="form-control" placeholder="Buscar por médico">
                                    <input type="hidden" id="medico" name="medico" class="form-control" value="0">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="searchPac" name="searchPac" class="form-control" placeholder="Buscar por paciente">
                                    <input type="hidden" id="paciente" name="paciente" class="form-control" value="0">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="fecha" name="fecha" class="form-control" placeholder="Fecha de salida">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12" align="right">
                                    <button type="button" class="btn btn-primary" onclick="getReporteSalidas()">
                                        Buscar Salidas <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </div>
                            </div>
                            </form>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Usuario</th>
                                                <th>Médico</th>
                                                <th>Paciente</th>
                                                <th>Fecha</th>
                                                <th>Comentario</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody id="repMasterOutProductos"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DETALLE SALIDAS -->
    <div id="modal-detaProductOt" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Detall de  productos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                </thead>
                                <tbody id="detaOutPoducts">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ MODAL DETALLE DALIDAS-->
</div>

<script src="<?php echo app_url(); ?>js/rep_salida_productos.js" type="text/javascript"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>