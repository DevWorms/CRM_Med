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
						<h2 style="display:inline; color:#337ab7;">Recepción - Pagos (versión 1) </h2>
                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Registra pagos a los pacientes así como ventas en recepción, similar a la versión beta."></span>
                        <hr>
						
                        <div class="form-group row">
                            <div class="col-md-12" align="center">
                                <div id="custom-search-input">
                                    <div class="input-group col-md-9" >
                                        <input type="text" class="search-query form-control" id="param" name="param" placeholder="Buscar ..." />
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" id="busqueda">
                                                <span class=" glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="user"></div>
                        <input type="hidden" id="user_id" value="">
                        <hr>
                        <div id="error"></div>

                        <div class="form-group row space">
                            <form id="nuevoPago" name="nuevoPago" method="POST">
                                <div class="col-md-6">
                                    <h2>Nuevo Pago</h2>
                                    <div class="jumbotron">
                                        <div class="row">

                                            <div class="col-md-12">

                                                <label for="selec_presup">Selecciona Presupuesto</label>
                                                <select id="selec_presup" class="form-control" name="selec_presup">
                                                    <option value="0">Otros</option>
                                                </select>

                                                <br>
                                                <label for="monto">Monto</label>
                                                <input type="number" id="monto" name="monto" class="form-control" required>

                                                <br>
                                                <label for="concepto">Concepto</label>
                                                <input type="text" id="concepto" name="concepto" class="form-control" required>

                                                <br>
                                                <label for="recibo">Número de Recibo</label>
                                                <input type="number" id="recibo" name="recibo" class="form-control" required>

                                                <br>
                                                <label for="fecha">Fecha de Recibo</label>
                                                <input type="text" id="fecha" name="fecha" class="form-control">

                                                <br>
                                                <div class="form-group" align="right">
                                                    <button type="submit" class="btn btn-primary" id="registrar">Registrar Pago</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="col-md-6">
                                <form id="nuevoPresupuesto" name="nuevoPresupuesto" method="POST">
                                    <h2>Nuevo Presupuesto</h2>
                                    <div class="jumbotron">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="nom_presup">Nombre Presupuesto</label>
                                                <input type="text" id="nombre" name="nombre" class="form-control" required>

                                                <br>
                                                <label for="costo_pres">Costo Presupuesto</label>
                                                <input type="number" id="precio" name="precio" class="form-control" required>

                                                <br>
                                                <div class="form-group" align="right">
                                                    <button type="submit" class="btn btn-primary" id="registrar">Crear nuevo presupuesto</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <h2>Presupuestos del Paciente</h2>
                                <div class="jumbotron">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select id="mostrar_presup" class="form-control" name="mostrar_presup">
                                                <option value="0">Otros</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>		
                </div>	        
			</div>
        <script type="text/javascript" src="<?php echo app_url(); ?>js/pagos.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>
