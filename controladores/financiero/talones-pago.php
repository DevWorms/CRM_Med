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
                    <h2 style="display:inline;" class="title_header">Financiero - Capturar Talones de Pago </h2>
                    <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title=""></span>
                    <div id="error"></div>
                    <hr>
                    <br>
                    
                    <div class="row">
                        <div class="col-md-12 talonesPago_btn">
                            <div class="col-xs-3 col-xs-offset-3" align="center">
                                <a href="talon_nuevo" class="btn btn-primary btn-lg" id="talon_nuevoId">Talon nuevo</a>
                            </div>
                            <div class="col-xs-3" align="center">
                                <a href="talon_viejo" class="btn btn-primary btn-lg" id="talon_viejoId">Talon viejo</a>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>