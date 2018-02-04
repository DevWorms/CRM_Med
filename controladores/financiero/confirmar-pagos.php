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
                                    <input type="hidden" name="paciente_id" id="paciente_id">
                                    <input type="hidden" name="pago_id" id="pago_id">                                    
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
                                <div id="por-confirmar" class="tab-pane fade in active"> </div>
                                <!-- +++++++++  PESTAÑA CONFIRMADOS  +++++++++ -->
                                <div id="confirmados" class="tab-pane fade"> </div>
                                <!-- +++++++++  PESTAÑA NO CONFIRMADOS  +++++++++ -->
                                <div id="no-confirmados" class="tab-pane fade"> </div>
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
                                <button id="confirmar-pago" class="btn btn-sm btn-default btn-block" data-dismiss="modal">SI</button>
                            </div>
                            <div class="col-xs-3">
                                <button class="btn btn-sm btn-default btn-block" data-dismiss="modal">NO</button>
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
                                <button id="eliminar-pago" class="btn btn-sm btn-default btn-block" data-dismiss="modal">SI</button>
                            </div>
                            <div class="col-xs-3">
                                <button class="btn btn-sm btn-default btn-block" data-dismiss="modal">NO</button>
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