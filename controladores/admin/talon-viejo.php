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
                        <div class="col-md-12">
                            <a href="talones"><span class="btn btn-primary" id="regrsar_viejoId">regresar</span></a>
                            <br>
                            <br>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Fecha&nbsp;&nbsp;</label><br>
                                        <div class="input-group talon-pagoViejo-tamano-calendario-input">
                                        <input type="date" class="search-query form-control" id="fecha_Pagos_Talon_viejo" name="fecha_Pagos_Talon_viejo" placeholder="aaaa / mm / dd" required/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Número de recibo&nbsp;&nbsp;</label><br>
                                        <input type="text" class="search-query form-control input-width" id="folio_Pagos_Talon_viejo" name="folio_Pagos_Talon_viejo" placeholder="" required/>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Paciente&nbsp;&nbsp;</label><br>
                                        <input type="text" class="search-query form-control input-width" id="paciente_Pagos_Talon_viejo" name="paciente_Pagos_Talon_viejo" placeholder="" required/>
                                    </fieldset>
                                </div>
                            </div>
                            <!-- FIN PRIMERA FILA -->

                            <!-- SEGUNDA FILA -->
                            <div class="form-group row space">
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Concepto&nbsp;&nbsp;</label><br>
                                        <input type="text" class="search-query form-control input-width" id="concepto_Pagos_Talon_viejo" name="concepto_Pagos_Talon_viejo" placeholder="" required/>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Forma de pago&nbsp;&nbsp;</label><br>
                                        <select class="selectpicker" id="forma_pago_Talon_viejo" name="forma_pago_Talon_viejo">
                                          <option value="Consumible">Efectivo</option>
                                          <option value="Consumible">VISA</option>
                                          <option value="Consumible">AMEX</option>
                                          <option value="Consumible">Financiamiento</option>
                                        </select>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Planes de Financiamiento&nbsp;&nbsp;</label><br>
                                        <select class="selectpicker" id="planes_pago_Talon_viejo" name="planes_pago_Talon_viejo">
                                          <option value="Consumible">3 Meses</option>
                                          <option value="Consumible">6 Meses</option>
                                          <option value="Consumible">12 Meses</option>
                                          <option value="Consumible">18 Meses</option>
                                          <option value="Consumible">24 Meses</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <!-- FIN SEGUNDA FILA -->
                             <!-- TERCERA FILA -->
                            <div class="form-group row space">
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="piezas">Monto&nbsp;&nbsp;</label><br>
                                        <input type="text" id="monto__Talon_viejo" name="monto_Talon_viejo" class="form-control input-width" required>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="existencia">Observaciones&nbsp;&nbsp;</label><br>
                                        <input type="text" id="observacines__Talon_viejo" name="observaciones__Talon_viejo" class="form-control input-width" required>
                                    </fieldset> 
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="alertas">Médico que autoriza&nbsp;&nbsp;</label><br>
                                        <input type="text" class="form-control input-width" id="medico_Talon_viejo" name="medico_Talon_viejo" required>
                                    </fieldset>
                                </div>
                            </div>
                            <!-- FIN TERCERA FILA -->
                            <div class="form-group row space">
                                <div class="col-md-12">
                                    <center>
                                        <button class="btn btn-primary" type="button">Capturar</button>
                                    </center>
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