    <?php
        include dirname(__FILE__) . '/../layouts/header.php';
    ?>
    <!-- Page Content -->
    <script type="text/javascript">
        $(document).ready(function(){
            //La que inicia
            $('ul.tabs li a:first').addClass('activee');
            $('ul.tabs li a span:first').addClass('tab-textselec');
            //Oculta los tabs
            $('.secciones article').hide();
            //Muestra el primer tab
            $('.secciones article:first').show();

            $('ul.tabs li a').click(function(){
                //Remueve todas las clases 'active'
                $('ul.tabs li a').removeClass('activee');
                //Remueve todos los estilos color blanco (letra)
                $('ul.tabs li a span').removeClass('tab-textselec');
                //Agrega color gris a todos (letra)
                $('ul.tabs li a span').addClass('tab-text');
                //Al tab seleccionado le agrega la clase 'active'
                $(this).addClass('activee');
                //Oculta las demas secciones
                $('.secciones article').hide();
                //almacena en una varaible el valor del href '#tab()'
                var activeTab = $(this).attr('href'); 
                //Muestra la etiqueta con ese tab
                $(activeTab).show();
                $(activeTab+'n').removeClass('tab-text');
                $(activeTab+'n').addClass('tab-textselec');
                return false;
            });
        });
    </script>
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

                        <div class="wrap">
        <ul class="tabs">
            <li><a href="#tab1" style="text-decoration:none;"><span class="tab-text" id="tab1n">Nuevo Pago</span></a></li>
            <li><a href="#tab2" style="text-decoration:none;"><span class="tab-text" id="tab2n">Nuevo Presupuesto</span></a></li>
        </ul>

        <div class="secciones">
            <article id="tab1">
                <form id="nuevoPago" name="nuevoPago" method="POST">
                                <div class="col-md-12">
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
                                                <input type="text" id="fechaAbierta" name="fecha" class="form-control" readonly>

                                                <br>
                                                <div class="form-group" align="right">
                                                    <button type="submit" class="btn btn-primary" id="registrar">Registrar Pago</button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
            </article>
            <article id="tab2">
                <div class="col-md-12">
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
            </article>
        </div>
    </div>

                        <div class="form-group row space">


                    </div>		
                </div>	        
			</div>
        <script type="text/javascript" src="<?php echo app_url(); ?>js/pagos.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>
