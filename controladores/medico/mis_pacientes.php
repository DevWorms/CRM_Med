    <?php
        include dirname(__FILE__) . '/../layouts/header.php';
    ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>

            <div class="col-md-9">
                <div class="thumbnail">
                    <div class="caption-full">
                        <div id="error"></div>
                        <h2 style="display:inline; color:#337ab7;">Médico - Mis Pacientes</h2>
                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Catálogo de mis pacientes asignados"></span>
                        <hr>
                        <div id="error"></div>
                            <div class="col-md-12" id="pacientes_div"></div>
                            <div class="row"></div>
                    </div> 
                </div>          
            </div>
            <script src="<?php echo app_url(); ?>js/medico-misPacientes.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>