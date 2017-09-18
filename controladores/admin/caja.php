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
                    <h2 style="display:inline; color:#337ab7;">Administrador - Corte de Caja </h2>
                    <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Genera por cada día un corte de caja que incluye ingresos y egresos."></span>
                    <div id="error"></div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Folio del Paciente</th>
                                        <th>Nombre del Paciente</th>
                                        <th>Procedimiento</th>
                                        <th>Costo</th>
                                        <th>Imp. Pago</th>
                                        <th>Concepto</th>
                                        <th>Folio</th>
                                        <th>Forma de Pago</th>
                                        <th>Observaciones</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="corteDeCaja"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>