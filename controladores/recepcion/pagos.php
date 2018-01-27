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
    
<!-- TABS LOGIC -->
<script type="text/javascript">
    $(document).ready(function(){
        //La que inicia
        $('ul.tabs_pagos li a:first').addClass('activee');
        $('ul.tabs_pagos li a span:first').addClass('tab-textselec');
        //Oculta los tabs
        $('.secciones article').hide();
        //Muestra el primer tab
        $('.secciones article:first').show();

        $('ul.tabs_pagos li a').click(function(){
            //Remueve todas las clases 'active'
            $('ul.tabs_pagos li a').removeClass('activee');
            //Remueve todos los estilos color blanco (letra)
            $('ul.tabs_pagos li a span').removeClass('tab-textselec');
            //Agrega color gris a todos (letra)
            $('ul.tabs_pagos li a span').addClass('tab-text');
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
<!-- /TABS LOGIC-->

<div class="container">
    <div class="row">
        <!--MENU-->
        <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>
        <!--/ MENU -->
        
        <!-- CONTENIDO-->
        <div class="col-md-9">
            <div class="thumbnail border_content">

                <div class="caption-full">
                <!--TITULO-->
                <h2 style="display:inline;" class="title_header">&nbsp; Recepción - Pagos</h2>
                <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Registra pagos de los pacientes."></span>
                <hr>
                <!-- / TITULO -->
                
            
                <div class="wrap">
                    <!--TABS MENU-->
                    <ul class="tabs_pagos">
                        <li>
                            <a href="#tab1" style="text-decoration:none;">
                                <span class="tab-text" id="tab1n">
                                    Registrar Nuevo Pago
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab2" style="text-decoration:none;">
                                <span class="tab-text" id="tab2n">
                                    Agregar Presupuesto
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab3" style="text-decoration:none;">
                                <span class="tab-text" id="tab3n">
                                    Venta de Productos
                                </span>
                            </a>
                        </li>
                    </ul>
                    <!-- / TABS MENU -->
                    <hr>
                    <!--TABS CONTENT-->
                    <div class="secciones">


                        <!-- TAB 2 -->
                        <article id="tab1">
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
                                    <button class="btn btn-primary" style="float: right;display: none;" id="btn-imprimir">
                                        Imprimir <i class="glyphicon glyphicon-print"></i>
                                    </button> 
                                </div>
                                <form id="form-crearPago">
                                    <input type="hidden" name="paciente_id" id="paciente_id">
                                    <input type="hidden" name="presupuesto" id="presupuesto">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset class="form-inline">
                                                <label for="piezas">Importe&nbsp;&nbsp;</label><br>
                                                <input type="text" id="importe_pago" name="importe_pago" class="form-control input-width" required>
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
                                                <label for="">Fecha de Recibo&nbsp;&nbsp;
                                                    <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Agrega la fecha únicamente cuando registres un pago anterior; si el pago es actual, déjalo en blanco."></span>
                                                </label><br>
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
                                                    <option value="Tarjeta Crédito">Tarjeta de Crédito</option>
                                                    <option value="Tarjeta Débito">Tarjeta de Débito</option>
                                                    <option value="AMEX">American Express</option>
                                                    <option value="Financiamiento">Financiamiento</option>
                                                    <option value="Otro">Otro Medio (Añadir en Observaciones)</option>
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
                                        <button id="btn-nvopago"class="btn btn-success col-md-12 btn_exito" type="button"
                                        onclick="crearPago()">Registrar Pago</button>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <!-- / TAB PAGO-->


                        <!-- TAB 1 PAGO VERSION 1 -->
                        <article id="tab3">
                            <!--BUSCADOR-->
                            <div class="form-group row">
                            </div>
                            <div id="error"></div>
                            <input type="hidden" name="user_id" id="user_id">
                            <!--/ BUSCADOR --> 
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-8">
                                    Hola Mundo de Ventas
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>     
                        </article>
                        <!-- /TAB 1 PAGO VERSION 1 -->


                        <!-- TAB 1 PAGO VERSION 1 -->
                        <article id="tab2">
                            <!--BUSCADOR-->
                            <div class="form-group row">
                                <div class="col-md-12" align="center">
                                    <div id="custom-search-input">
                                        <div class="input-group col-md-9" >
                                            <input type="text" class="search-query form-control" id="param" name="param" placeholder="Buscar Paciente..." />
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button" id="busqueda">
                                                    <span class=" glyphicon glyphicon-search"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="error"></div>
                            <input type="hidden" name="user_id" id="user_id">
                            <!--/ BUSCADOR --> 
                            <div class="row">
                                <div class="col-md-2">
                                </div>
                                <div class="col-md-8">
                                    <!-- FORMULARIO PAGO V1 MUEVO PRESUPUESTO-->
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
                                                        <button type="submit" class="btn btn-success btn_exito" id="registrar">Crear nuevo presupuesto</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>     
                        </article>
                        <!-- /TAB 1 PAGO VERSION 1 -->

                    </div>
                    <!--/ TABS CONTENT -->
    
                    </div>
                </div>
                
            </div>
        </div>
        <!-- / CONTENIDO -->

    </div>
</div>


<script type="text/javascript" src="<?php echo app_url(); ?>js/pagos.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>
