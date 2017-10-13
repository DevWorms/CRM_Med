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
            <div class="thumbnail">

                <!--TITULO-->
                <h2 style="display:inline; color:#337ab7;">Recepción - Pagos</h2>
                <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Registra pagos a los pacientes así como ventas en recepción, similar a la versión beta."></span>
                <hr>
                <!-- / TITULO -->
                
            
                <div class="wrap">
                    <!--TABS MENU-->
                    <ul class="tabs_pagos">
                        <li>
                            <a href="#tab1" style="text-decoration:none;">
                                <span class="tab-text" id="tab1n">
                                    Pagos Versión 1
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab2" style="text-decoration:none;">
                                <span class="tab-text" id="tab2n">
                                    Pagos Versión 2
                                </span>
                            </a>
                        </li>
                    </ul>
                    <!-- / TABS MENU -->
                    <hr>
                    <!--TABS CONTENT-->
                    <div class="secciones">
                        <!-- TAB 1 PAGO VERSION 1 -->
                        <article id="tab1">
                            <!--BUSCADOR-->
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
                            <div id="error"></div>
                            <input type="hidden" name="user_id" name="user_id">
                            <!--/ BUSCADOR --> 
                            <div class="row">
                                <div class="col-md-6">
                                    <!--  FORMULARIO PAGO V1 NUEVO PAGO-->
                                    <form id="nuevoPago" name="nuevoPago" method="POST">
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
                                                        <button type="submit" class="btn btn-primary" id="registrar">
                                                            Registrar Pago
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--  /FORMULARIO PAGO V1 NUEVO PAGO-->
                                </div>
                                <div class="col-md-6">
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
                                                        <button type="submit" class="btn btn-primary" id="registrar">Crear nuevo presupuesto</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- /FORMULARIO PAGO V1 NUEVO PRESUPUESTO-->
                                    <!--RESUPUESTO DEL PACIENTE -->
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
                                    <!-- /RESUPUESTO DEL PACIENTE -->
                                </div>
                            </div>     
                        </article>
                        <!-- /TAB 1 PAGO VERSION 1 -->

                        <!-- TAB 2 PAGO VERSION 2-->
                        <article id="tab2">
                            <div class="jumbotron">
                                <!--FILA CABECERA-->
                                <div class="row">
                                    <!-- Buscador -->
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div id="custom-search-input">
                                                <div class="input-group col-md-12" >
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
                                    <br><br>
                                    <!-- Datos paciente -->
                                    <div class="col-md-6">
                                        <br>
                                         Descripción 1
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <fieldset class="form-inline " style="width: 70%;">
                                            <label for="">Procedimiento / Producto&nbsp;&nbsp;</label><br>
                                            <select class="selectpicker" id="Proce_Produ" name="Proce_Produ">
                                                <option value="Consumible">Procedimiento</option>
                                                <option value="Consumible">Producto</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="jumbotron">
                                <!--FILA CABECERA-->
                                <div class="container">         
                                    <table class="table table-striped">
                                        <thead>
                                             <tr>
                                                <th>Monto</th>
                                                <th>Concepto</th>
                                                <th>Nombre de presupuesto</th>
                                                <th>Precio de presupuesto</th>
                                                <th>Número de Recibo</th>
                                                <th>Restante</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                        </tbody>
                                    </table>
                                </div>

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
                                            <label for="existencia">Observaciones&nbsp;&nbsp;</label><br>
                                            <input type="text" id="existencia" name="existencia" class="form-control input-width" required>
                                        </fieldset> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <br>
                                        <fieldset class="form-inline">
                                            <label for="">Forma de pago&nbsp;&nbsp;</label><br>
                                            <select class="selectpicker" id="forma_pago" name="forma_pago">
                                                <option value="Consumible">Efectivo</option>
                                                <option value="Consumible">VISA</option>
                                                <option value="Consumible">AMEX</option>
                                                <option value="Consumible">Financiamiento</option>
                                            </select>
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
                                                    <option value="Consumible">3 Meses</option>
                                                    <option value="Consumible">6 Meses</option>
                                                    <option value="Consumible">12 Meses</option>
                                                    <option value="Consumible">18 Meses</option>
                                                    <option value="Consumible">24 Meses</option>
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <br>
                                            <hr class="pago_linea">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <br>
                                        <button class="btn btn-primary col-md-12">Imprimir</button>
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <button class="btn btn-primary col-md-12">Registrar Pago</button>
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
