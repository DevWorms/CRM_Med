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
                    <h3 style="display:inline; color:#337ab7;">Financiero - Capturar Entradas y Salidas de Dinero </h3>
                    <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Captura entradas y salidas de dinero."></span>
                    <div id="error"></div>
                    <hr>
                    <br>
                    
                    <ul class="nav nav-tabs nav-bottom-space">
                        <li class="active"><a class="a-entradas" data-toggle="tab" href="#entradas">Capturar Entradas de Dinero</a></li>
                        <li><a class="a-salidas" data-toggle="tab" href="#salidas">Capturar Salidas de Dinero</a></li>
                    </ul>
                
                    <div class="tab-content">
                        <!-- +++++++++  PESTAÑA ENTRADAS DE DINERO  +++++++++ -->
                        <div id="entradas" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-xs-6 col-xs-offset-3" align="center">
                                    <form class="form-inline form-top-space" id="entradas-form">
                                        
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="fecha-entrada">Fecha:</label>
                                            </div>
                                            <div class="col-xs-8">
                                                <div class="input-group">
                                                    <input type="text" class="search-query form-control" name="fecha-entrada" id="fecha-entrada" placeholder="aaaa / mm / dd" required="">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary" type="button">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="concepto-entrada">Concepto:</label>
                                            </div>
                                            <div class="col-xs-8">
                                                <input type="text" class="form-control input-sp-width" name="concepto-entrada" id="concepto-entrada">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="monto-entrada">Monto:</label>
                                            </div>
                                            <div class="col-xs-8">
                                                <input type="text" class="form-control input-sp-width" name="monto-entrada" id="monto-entrada">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="observaciones-entrada">Observaciones:</label>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <textarea class="form-control textarea-sp" rows="5" name="observaciones-entrada" id="observaciones-entrada" form="entradas-form"></textarea>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sp-submit">Capturar Entrada</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- +++++++++  PESTAÑA SALIDAS DE DINERO  +++++++++ -->
                        <div id="salidas" class="tab-pane fade"> 
                            <div class="row">
                                <div class="col-xs-6 col-xs-offset-3" align="center">
                                    <form class="form-inline form-top-space">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="fecha-salida">Fecha:</label>
                                            </div>
                                            <div class="col-xs-8">
                                                <div class="input-group">
                                                    <input type="text" class="search-query form-control" name="fecha-salida" id="fecha-salida" placeholder="aaaa / mm / dd" required="">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary" type="button">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="concepto-salida">Concepto:</label>
                                            </div>
                                            <div class="col-xs-8">
                                                <input type="text" class="form-control input-sp-width" name="concepto-salida" id="concepto-salida" required="">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="cantidad-salida">Monto:</label>
                                            </div>
                                            <div class="col-xs-8">
                                                <input type="text" class="form-control input-sp-width" name="monto-salida" id="monto-salida" required="">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="observaciones-salida">Observaciones:</label>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <textarea class="form-control textarea-sp" rows="7" name="observaciones-salida" id="observaciones-salida" form="entradas-form"></textarea>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sp-submit">Capturar Salida</button>
                                    </form>
                                </div>
                            </div>          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>