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
                <div class="thumbnail border_content">
                    <div class="caption-full">
                        <div id="error"></div>
                        <h2 style="display:inline;" class="title_header">Médico - Pacientes en Espera</h2>
                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Listado de pacientes de primera vez en espera"></span>
                        <hr>
                        <div id="error"></div>
                            <div class="col-md-12">

                                <table class="table table-hover" id="table_en_espera">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Procedimiento</th>
                                            <th>Hora de Cita</th>
                                            <th>Atender</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row"></div>
                    </div> 
                </div>          
            </div>
            <script src="<?php echo app_url(); ?>js/medico.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>