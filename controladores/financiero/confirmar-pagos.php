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
                    
                    <h2 style="display:inline;" class="title_header">Financiero - Confirmar Pagos </h2>
                    <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Ve pagos por confirmar, confirmalos o eliminalos."></span>
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

                    <!-- Tarjetas -->
                    <div class="row">
                        <div class="col-md-12">
                            
                            <ul class="nav nav-tabs nav-bottom-space">
                                <li class="active"><a data-toggle="tab" href="#por-confirmar">Pagos por confirmar</a></li>
                                <li><a data-toggle="tab" href="#confirmados">Pagos Confirmados</a></li>
                                <li><a data-toggle="tab" href="#no-confirmados">Pagos no confirmados</a></li>
                            </ul>
                        
                            <div class="tab-content">
                                <!-- +++++++++  PESTAÑA POR CONFIRMAR  +++++++++ -->
                                <div id="por-confirmar" class="tab-pane fade in active">
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
                                                        <span class="caja-pago_label">Fecha de Pago:</span><span> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success" data-toggle="modal" data-target="#modal-confirmar">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger" data-toggle="modal" data-target="#modal-eliminar">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin Tarjeta -->

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
                                                        <span class="caja-pago_label">Fecha de Pago:</span><span> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success" data-toggle="modal" data-target="#modal-confirmar">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger" data-toggle="modal" data-target="#modal-eliminar">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin Tarjeta -->

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
                                                        <span class="caja-pago_label">Fecha de Pago:</span><span> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success" data-toggle="modal" data-target="#modal-confirmar">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger" data-toggle="modal" data-target="#modal-eliminar">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin Tarjeta -->

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
                                                        <span class="caja-pago_label">Fecha de Pago:</span><span> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success" data-toggle="modal" data-target="#modal-confirmar">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger" data-toggle="modal" data-target="#modal-eliminar">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin Tarjeta -->
                                </div>

                                <!-- +++++++++  PESTAÑA CONFIRMADOS  +++++++++ -->
                                <div id="confirmados" class="tab-pane fade">
                                    <!-- Tarjeta Pagos confirmados -->
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
                                                        <span class="caja-pago_label">Fecha de Pago:</span><span> 10-10-2017</span>
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
                                    <!-- Fin Tarjeta -->

                                    <!-- Tarjeta Pagos confirmados -->
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
                                                        <span class="caja-pago_label">Fecha de Pago:</span><span> 10-10-2017</span>
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
                                    <!-- Fin Tarjeta -->
                                </div>

                                <!-- +++++++++  PESTAÑA NO CONFIRMADOS  +++++++++ -->
                                <div id="no-confirmados" class="tab-pane fade">
                                    <!-- Tarjeta Pagos no confirmados -->
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
                                                        <span class="caja-pago_label">Fecha de Pago:</span><span> 10-10-2017</span>
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
                                    <!-- Fin Tarjeta -->
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- Tarjetas -->

                </div>
            </div>
        </div>

        <!-- Modals -->
        <div id="modal-confirmar" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body" style="background:#EFEFEF !important;" align="center">
                        
                        <div class="row">
                            <div class="col-xs-12" align="center">
                                <p class="modal-title">¿Esta seguro que desea <span class="confirmar-highlight">confirmar</span> este pago?</p>
                            </div>
                        </div>
                        
                        <div class="row confirmar-modal_botones">
                            <div class="col-xs-offset-3 col-xs-3">
                                <button class="btn btn-sm btn-default btn-block">SI</button>
                            </div>
                            <div class="col-xs-3">
                                <button class="btn btn-sm btn-default btn-block">NO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-eliminar" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body" style="background:#EFEFEF !important;" align="center">
                        
                        <div class="row">
                            <div class="col-xs-12" align="center">
                                <p class="modal-title">¿Esta seguro que desea <span class="eliminar-highlight">eliminar</span> este pago?</p>
                            </div>
                        </div>
                        
                        <div class="row confirmar-modal_botones">
                            <div class="col-xs-offset-3 col-xs-3">
                                <button class="btn btn-sm btn-default btn-block">SI</button>
                            </div>
                            <div class="col-xs-3">
                                <button class="btn btn-sm btn-default btn-block">NO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin Modals -->
    </div>
</div>
<script type="text/javascript" src="<?php echo app_url(); ?>js/pagos.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>