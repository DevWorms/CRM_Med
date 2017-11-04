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
                    <h2 style="display:inline;" class="title_header">Financiero - Ver Pagos de los Clientes</h2>
                    <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Ve todos los pagos de un cliente en específico."></span>
                    <div id="error"></div>
                    <hr>
                     <!-- Search Bar -->
                    <div class="form-group row">
                        <div class="col-md-12" align="center">
                            <div id="custom-search-input">
                                <div class="input-group col-md-9">
                                    <input type="text" class="search-query form-control" id="param" name="param"
                                           placeholder="Buscar pago por nombre del Cliente"/>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="validateOrden">
                                            <span class=" glyphicon glyphicon-search"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Search Bar -->
                    <br>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <!-- +++++++++  PESTAÑA POR CONFIRMAR  +++++++++ -->
                        <div id="por-confirmar">
                            <!-- Tarjeta Pagos por confirmar -->
                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1 caja-pago">
                                    <div class="col-xs-8">
                                        <div class="col-xs-6">
                                            <span class="caja-pago_label"># Recibo:</span>
                                            <br>
                                            <span class="caja-pago_label">Nombre del Cliente:</span>
                                            <br>
                                            <span class="caja-pago_label">Concepto:</span>
                                            <br>
                                            <span class="caja-pago_label">Monto:</span>
                                            <br>
                                            <span class="caja-pago_label">Financiamiento (Meses):</span>
                                        </div>
                                        <div class="col-xs-6">
                                            <span>10308</span>
                                            <br>
                                            <span>Juan Pérez Rodriguez</span>
                                            <br>
                                            <span>Operación</span>
                                            <br>
                                            <span>$ 20,000</span>
                                            <br>
                                            <span>12 MESES</span>
                                        </div>    
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="row">
                                            <div class="col-xs-12" align="right">
                                                <span class="caja-pago_label">Fecha de Pago: </span><span>10-10-2017</span>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px;">
                                            <div class="col-xs-offset-4 col-xs-4">
                                                <div class="status-box confirmado" align="center">
                                                    <span>CONFIRMADO</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta Pagos por confirmar -->
                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1 caja-pago">
                                    <div class="col-xs-8">
                                        <div class="col-xs-6">
                                            <span class="caja-pago_label"># Recibo:</span>
                                            <br>
                                            <span class="caja-pago_label">Nombre del Cliente:</span>
                                            <br>
                                            <span class="caja-pago_label">Concepto:</span>
                                            <br>
                                            <span class="caja-pago_label">Monto:</span>
                                            <br>
                                            <span class="caja-pago_label">Financiamiento (Meses):</span>
                                        </div>
                                        <div class="col-xs-6">
                                            <span>10308</span>
                                            <br>
                                            <span>Juan Pérez Rodriguez</span>
                                            <br>
                                            <span>Operación</span>
                                            <br>
                                            <span>$ 20,000</span>
                                            <br>
                                            <span>12 MESES</span>
                                        </div>    
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="row">
                                            <div class="col-xs-12" align="right">
                                                <span class="caja-pago_label">Fecha de Pago: </span><span>10-10-2017</span>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px;">
                                            <div class="col-xs-offset-2 col-xs-8">
                                                <div class="status-box no-confirmado" align="center">
                                                    <span>NO CONFIRMADO</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta Pagos por confirmar -->
                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1 caja-pago">
                                    <div class="col-xs-8">
                                        <div class="col-xs-6">
                                            <span class="caja-pago_label"># Recibo:</span>
                                            <br>
                                            <span class="caja-pago_label">Nombre del Cliente:</span>
                                            <br>
                                            <span class="caja-pago_label">Concepto:</span>
                                            <br>
                                            <span class="caja-pago_label">Monto:</span>
                                            <br>
                                            <span class="caja-pago_label">Financiamiento (Meses):</span>
                                        </div>
                                        <div class="col-xs-6">
                                            <span>10308</span>
                                            <br>
                                            <span>Juan Pérez Rodriguez</span>
                                            <br>
                                            <span>Operación</span>
                                            <br>
                                            <span>$ 20,000</span>
                                            <br>
                                            <span>12 MESES</span>
                                        </div>    
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="row">
                                            <div class="col-xs-12" align="right">
                                                <span class="caja-pago_label">Fecha de Pago: </span><span>10-10-2017</span>
                                            </div>
                                        </div>
                                       <div class="row" style="margin-top: 50px;">
                                            <div class="col-xs-offset-1 col-xs-10">
                                                <div class="status-box por-confirmar" align="center">
                                                    <span>POR CONFIRMAR</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tarjeta Pagos por confirmar -->
                            <div class="row">
                                <div class="col-xs-10 col-xs-offset-1 caja-pago">
                                    <div class="col-xs-8">
                                        <div class="col-xs-6">
                                            <span class="caja-pago_label"># Recibo:</span>
                                            <br>
                                            <span class="caja-pago_label">Nombre del Cliente:</span>
                                            <br>
                                            <span class="caja-pago_label">Concepto:</span>
                                            <br>
                                            <span class="caja-pago_label">Monto:</span>
                                            <br>
                                            <span class="caja-pago_label">Financiamiento (Meses):</span>
                                        </div>
                                        <div class="col-xs-6">
                                            <span>10308</span>
                                            <br>
                                            <span>Juan Pérez Rodriguez</span>
                                            <br>
                                            <span>Operación</span>
                                            <br>
                                            <span>$ 20,000</span>
                                            <br>
                                            <span>12 MESES</span>
                                        </div>    
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="row">
                                            <div class="col-xs-12" align="right">
                                                <span class="caja-pago_label">Fecha de Pago: </span><span>10-10-2017</span>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 50px;">
                                            <div class="col-xs-offset-4 col-xs-4">
                                                <div class="status-box confirmado" align="center">
                                                    <span>CONFIRMADO</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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