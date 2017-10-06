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
                    <h2 style="display:inline; color:#337ab7;">Financiero - Capturar Talones de Pago </h2>
                    <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title=""></span>
                    <div id="error"></div>
                    <hr>
                    <br>
                    
                    <div class="row">
                        <div class="col-md-12 talonesPago_btn"><center>
                            <a href="talon_nuevo"><span class="btn btn-primary talonesPago_btnLetra" id="talon_nuevoId">Talon nuevo</span></a>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="talon_viejo"><span class="btn btn-primary talonesPago_btnLetra" id="talon_viejoId">Talon viejo</span></a>
                        </center>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>