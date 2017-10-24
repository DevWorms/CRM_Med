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

                        <h2 style="display:inline; color:#337ab7;">Call Center - Directorio de Leads </h2>

                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Información de leads registrados."></span>
                        <hr>
                        <div id="error"></div>

                            <div id="segmentoActualizar">
                                <table class="table table-striped" id="pacientes">
                                    <thead>
                                      <tr>
                                        <th style="text-align:center">Nombre Completo</th>
                                        <th style="text-align:center">Folio</th>
                                        <th style="text-align:center">Teléfono</th>
                                        <th style="text-align:center">Teléfono 2</th>
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
                </div>          
            </div>

    <script type="text/javascript" src="<?php echo app_url(); ?>js/directorio_center.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>