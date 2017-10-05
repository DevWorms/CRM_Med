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
                    <h2 style="display:inline; color:#337ab7;">Financiero - Confirmar Pagos </h2>
                    <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title=""></span>
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
                                                <div class="col-xs-5">
                                                    <span class="caja-pago_label">Nombre del Cliente:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Concepto:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Cantidad:</span>
                                                </div>
                                                <div class="col-xs-6">
                                                    <span>Juan Pérez Rodriguez</span>
                                                    <br>
                                                    <span>Operación</span>
                                                    <br>
                                                    <span>$ 20,000</span>
                                                </div>    
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="row">
                                                    <div class="col-xs-12" align="right">
                                                        <span><b>Fecha de Pago:</b> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger">Eliminar</button>
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
                                                <div class="col-xs-5">
                                                    <span class="caja-pago_label">Nombre del Cliente:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Concepto:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Cantidad:</span>
                                                </div>
                                                <div class="col-xs-6">
                                                    <span>Juan Pérez Rodriguez</span>
                                                    <br>
                                                    <span>Operación</span>
                                                    <br>
                                                    <span>$ 20,000</span>
                                                </div>    
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="row">
                                                    <div class="col-xs-12" align="right">
                                                        <span><b>Fecha de Pago:</b> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger">Eliminar</button>
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
                                                <div class="col-xs-5">
                                                    <span class="caja-pago_label">Nombre del Cliente:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Concepto:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Cantidad:</span>
                                                </div>
                                                <div class="col-xs-6">
                                                    <span>Juan Pérez Rodriguez</span>
                                                    <br>
                                                    <span>Operación</span>
                                                    <br>
                                                    <span>$ 20,000</span>
                                                </div>    
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="row">
                                                    <div class="col-xs-12" align="right">
                                                        <span><b>Fecha de Pago:</b> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger">Eliminar</button>
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
                                                <div class="col-xs-5">
                                                    <span class="caja-pago_label">Nombre del Cliente:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Concepto:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Cantidad:</span>
                                                </div>
                                                <div class="col-xs-6">
                                                    <span>Juan Pérez Rodriguez</span>
                                                    <br>
                                                    <span>Operación</span>
                                                    <br>
                                                    <span>$ 20,000</span>
                                                </div>    
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="row">
                                                    <div class="col-xs-12" align="right">
                                                        <span><b>Fecha de Pago:</b> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin Tarjeta -->
                                </div>

                                <!-- +++++++++  PESTAÑA CONFIRMADOS  +++++++++ -->
                                <div id="confirmados" class="tab-pane fade">            
                                    <!-- Tarjeta Pagos por confirmar -->
                                    <div class="row">
                                        <div class="col-xs-10 col-xs-offset-1 caja-pago">
                                            <div class="col-xs-8">
                                                <div class="col-xs-5">
                                                    <span class="caja-pago_label">Nombre del Cliente:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Concepto:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Cantidad:</span>
                                                </div>
                                                <div class="col-xs-6">
                                                    <span>Juan Pérez Rodriguez</span>
                                                    <br>
                                                    <span>Operación</span>
                                                    <br>
                                                    <span>$ 20,000</span>
                                                </div>    
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="row">
                                                    <div class="col-xs-12" align="right">
                                                        <span><b>Fecha de Pago:</b> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger">Eliminar</button>
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
                                                <div class="col-xs-5">
                                                    <span class="caja-pago_label">Nombre del Cliente:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Concepto:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Cantidad:</span>
                                                </div>
                                                <div class="col-xs-6">
                                                    <span>Juan Pérez Rodriguez</span>
                                                    <br>
                                                    <span>Operación</span>
                                                    <br>
                                                    <span>$ 20,000</span>
                                                </div>    
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="row">
                                                    <div class="col-xs-12" align="right">
                                                        <span><b>Fecha de Pago:</b> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Fin Tarjeta -->
                                </div>

                                <!-- +++++++++  PESTAÑA NO CONFIRMADOS  +++++++++ -->
                                <div id="no-confirmados" class="tab-pane fade">            
                                    <!-- Tarjeta Pagos por confirmar -->
                                    <div class="row">
                                        <div class="col-xs-10 col-xs-offset-1 caja-pago">
                                            <div class="col-xs-8">
                                                <div class="col-xs-5">
                                                    <span class="caja-pago_label">Nombre del Cliente:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Concepto:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Cantidad:</span>
                                                </div>
                                                <div class="col-xs-6">
                                                    <span>Juan Pérez Rodriguez</span>
                                                    <br>
                                                    <span>Operación</span>
                                                    <br>
                                                    <span>$ 20,000</span>
                                                </div>    
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="row">
                                                    <div class="col-xs-12" align="right">
                                                        <span><b>Fecha de Pago:</b> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger">Eliminar</button>
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
                                                <div class="col-xs-5">
                                                    <span class="caja-pago_label">Nombre del Cliente:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Concepto:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Cantidad:</span>
                                                </div>
                                                <div class="col-xs-6">
                                                    <span>Juan Pérez Rodriguez</span>
                                                    <br>
                                                    <span>Operación</span>
                                                    <br>
                                                    <span>$ 20,000</span>
                                                </div>    
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="row">
                                                    <div class="col-xs-12" align="right">
                                                        <span><b>Fecha de Pago:</b> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger">Eliminar</button>
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
                                                <div class="col-xs-5">
                                                    <span class="caja-pago_label">Nombre del Cliente:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Concepto:</span>
                                                    <br>
                                                    <span class="caja-pago_label">Cantidad:</span>
                                                </div>
                                                <div class="col-xs-6">
                                                    <span>Juan Pérez Rodriguez</span>
                                                    <br>
                                                    <span>Operación</span>
                                                    <br>
                                                    <span>$ 20,000</span>
                                                </div>    
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="row">
                                                    <div class="col-xs-12" align="right">
                                                        <span><b>Fecha de Pago:</b> 10-10-2017</span>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 50px;">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-success">Confirmar</button>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-block btn-danger">Eliminar</button>
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
            </div>
        </div>
    </div>
</div>

<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>