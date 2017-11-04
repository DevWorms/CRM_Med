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

            <div class="col-md-9">
                <div class="thumbnail">
                    <div class="caption-full">

                        <h2 style="display:inline; color:#337ab7;">Administrador - Reporte Citas </h2>
                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Revisa el número de citas que se tuvieron al día y cuales se llevaron a cabo."></span>
                        <div id="error"></div>
                        <br>
                        <div>
                            <div class="cuadradoAsitio"></div>
                            <p style="margin-left: 30px;">La cita de primera vez se llevó a cabo</p>
                        </div>
                        <div>
                            <div class="cuadradoNoAsitio"></div>
                            <p style="margin-left: 30px; margin-top: 0;">Otras citas que se llevaron a cabo</p>
                        </div>
                        <div>
                            <div class="cuadradoNoAsitio" style="background:#ea62a1"></div>
                            <p style="margin-left: 30px; margin-top: 0;">Citas que no se llevaron a cabo</p>
                        </div>
                        <hr>
                        <div id='calendar'></div>
                    </div>      
                </div>          
            </div>

        <div id="modal-detalleReporteCita" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Detalle de citas.</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-condensed">
                            <thead>
                                <th>
                                    Fecha
                                </th>
                                <th>
                                    Hora Programada
                                </th>
                                <th>
                                    Paciente
                                </th>
                            </thead>
                            <tbody id="detalleCita">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer" id="editModifyProd">
                      
                    </div>
                </div>
            </div>
        </div>
    <script src="<?php echo app_url(); ?>js/reporteCalendario.js"></script>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>