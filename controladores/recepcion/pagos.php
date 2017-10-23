<!--HEADER-->
<?php
    include dirname(__FILE__) . '/../layouts/header.php';
?>
<!--/HEADER -->

<!--NABVAR-->
<div class="container">
    <?php include dirname(__FILE__) . "/../layouts/navbar.php"; ?>
</div>
<!-- /NAVBAR -->
    

<div class="container">
    <div class="row">
        <!--MENU-->
        <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>
        <!--/ MENU -->
        
        <!-- CONTENIDO-->
        <div class="col-md-9">
            <div class="thumbnail">

                <!--TITULO-->
                <h2 style="display:inline; color:#337ab7;"> &nbsp; Recepción - Pagos</h2>
                <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Registra pagos a los pacientes así como ventas en recepción, similar a la versión beta."></span>
                <hr>
                <!-- / TITULO -->
                
            
                <div class="wrap">
                    <!--TABS CONTENT-->
                    <div class="secciones">
                        <!-- TAB 2 PAGO VERSION 2-->
                        <article id="tab2">
                            <div class="jumbotron">
                                <!--FILA CABECERA-->
                                <div class="row">
                                    <!-- Buscador -->
                                    <div class="col-md-12">
                                        <label>Paciente</label><br>
                                        <div class="form-group row">
                                            <div id="custom-search-input">
                                                <div class="input-group col-md-12" >
                                                    
                                                    <input type="text" class="search-query form-control" id="paciente_Pagos" name="paciente_Pagos" placeholder="Buscar Paciente" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary" type="button" id="btn-paciente">
                                                            <span class="glyphicon glyphicon-list-alt"></span>
                                                        </button>
                                                    </span>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br><br>
                                    <!-- Datos paciente -->
                                    <div class="col-md-12" id="review_paciente" style="text-align: center;">
                                        <br>
                                    </div>
                                    <div class="col-md-12">
                                        <select class="form-control" id="Proce_Produ" name="Proce_Produ"  onchange="obtenerPagos()" style="font-weight: bold;">
                                            <option>Sin presupuesto para mostrar - Elija un paciente</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="jumbotron">
                                <!--FILA CABECERA-->
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12"  style="display: none;cursor: pointer;" id="pre-tabla-pagos" onclick="mostrarTabla()">
                                        </div>
                                    </div>
                                    <hr>       
                                    <table class="table table-striped table-condensed" id="tabla-pagos" style="display: none">
                                        <thead>
                                             <tr>
                                                <th>Fecha</th>
                                                <th>Folio</th>
                                                <th>Concepto</th>
                                                <th>Importe del pago</th>                
                                                <th>Saldo</th>
                                                <th>Forma de pago</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <!--
                                        <button class="btn btn-primary" style="float: right;display: none;" id="btn-imprimir">
                                            Imprimir <i class="glyphicon glyphicon-print"></i>
                                        </button> 
                                    -->
                                </div>
                                <form id="form-crearPago">
                                    <input type="hidden" name="paciente_id" id="paciente_id">
                                    <input type="hidden" name="presupuesto" id="presupuesto">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-inline">
                                                <label for="">Fecha&nbsp;&nbsp;</label><br>
                                                <div class="input-group calendario_pago">
                                                    <input type="date" class="search-query form-control" id="fecha" name="fecha" placeholder="aaaa / mm / dd" required/>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary" type="button">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-inline">
                                                <label for="">Folio&nbsp;&nbsp;</label><br>
                                                <input type="text" class="search-query form-control input-width" id="folio_Pagos" name="folio_Pagos" placeholder="" required/>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-inline">
                                                <br>
                                                <label for="piezas">Importe&nbsp;&nbsp;</label><br>
                                                <input type="text" id="importe_pago" name="importe_pago" class="form-control input-width" required>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-inline">
                                                <br>
                                                <label for="existencia">Concepto&nbsp;&nbsp;</label><br>
                                                <input type="text" id="concepto" name="concepto" class="form-control input-width" required>
                                            </fieldset> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <br>
                                            <fieldset class="form-inline">
                                                <label for="">Forma de pago&nbsp;&nbsp;</label><br>
                                                <select class="selectpicker" id="forma_pago" name="forma_pago">
                                                    <option value="Efectivo">Efectivo</option>
                                                    <option value="VISA">VISA</option>
                                                    <option value="AMEX">AMEX</option>
                                                    <option value="Financiamiento">Financiamiento</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset class="form-inline">
                                                <br>
                                                <label for="existencia">Observaciones&nbsp;&nbsp;</label><br>
                                                <input type="text" id="observaciones" name="observaciones" class="form-control input-width" required>
                                            </fieldset> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <br>
                                            <input type="checkbox" id="finan" name="finan" value="Ocultar_pago" onclick="Mostrar_Ocultar_Pago()"> ¿Es con financiamiento?
                                         </div>
                                    </div>
                                    <div id="financi_seleci" name="financi_seleci" class="container" style="display: none">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <hr class="pago_linea">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <fieldset class="form-inline">
                                                    <br>
                                                    <label for="">Meses&nbsp;&nbsp;</label><br>
                                                    <select class="selectpicker" id="meses_pago" name="meses_pago">
                                                        <option value="3">3 Meses</option>
                                                        <option value="6">6 Meses</option>
                                                        <option value="12">12 Meses</option>
                                                        <option value="18">18 Meses</option>
                                                        <option value="24">24 Meses</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-6">
                                                <fieldset class="form-inline">
                                                    <br>
                                                    <label for="existencia">Financiera&nbsp;&nbsp;</label><br>
                                                    <input type="text" id="financiera" name="financiera" class="form-control input-width" required>
                                                </fieldset> 
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <br>
                                        <button class="btn btn-primary col-md-12" type="button"
                                        onclick="crearPago()">Registrar Pago</button>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <!-- / TAB 2 PAGO VERSION 2-->

                    </div>
                    <!--/ TABS CONTENT -->
    
                    
                </div>
                
            </div>
        </div>
        <!-- / CONTENIDO -->

    </div>
</div>


<script type="text/javascript" src="<?php echo app_url(); ?>js/pagos.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>
