    <?php 
        error_reporting(E_ALL);
        include dirname(__FILE__) . '/../layouts/header.php';
        include dirname(__FILE__) . '/../utilidades/funciones/func_option_select.php'; 
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
						<h2 style="display:inline; color:#337ab7;">Recepción - Programar Citas </h2>
                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Programar nuevas citas a pacientes registrados."></span>
                        <hr>

                        <div class="row">
                            <div class="col-md-12" align="center">
                                <div align="center">
                                    <a class="btn btn-primary active" role="button">Generar cita a <i>Paciente</i></a>

                                    <a class="btn btn-primary" <?php echo '<a href="' . app_url() . 'primera_cita"' ?> role="button">Generar cita a <i>Lead</i></a>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="form-group row">
                            <div class="col-md-12" align="center">
                                <div id="custom-search-input">
                                    <div class="input-group col-md-9" >
                                        <input type="text" class="search-query form-control" placeholder="Folio o Nombre del Paciente" id="prospecto" name="prospecto" autofocus/>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" id="busquedaP">
                                                <span class=" glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="error"></div>

                        <div class="form-group row">

                            <div class="col-md-4 col-md-offset-1">
                                <fieldset class="form-inline">
                                    <div>
                                        <p id="nombreP">
                                            <!--  NOMBRE DEL PACIENTE  -->
                                        </p>
                                        <p id="telP">
                                            <!--  TELÉFONO DEL PACIENTE  -->
                                        </p>
                                        <p id="folioP">
                                            <!--  FOLIO DEL PACIENTE  -->
                                        </p>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-3">
                                <div>
                                    <p id="proximaCita">
                                        <!--  proxima cita  -->
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div>
                                    <p id="otrasCitas">
                                        <!--  otras citas -->
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row" align="center">
                            <div class="col-md-4">
                                <fieldset class="form-inline">
                                    <label for="">Fechas Disponibles</label>
                                    <fieldset class="form-inline">
                                        <div class="input-group">
                                            <input type="text" class="search-query form-control" id="fecha" name="fecha" placeholder="aaaa / mm / dd" required/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </fieldset>
                                    <br><br>
                                    <div id="scrollCitas" class="scroll">
                                        <table class="table table-striped" id="citas_by_date">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center">Hora</th>
                                                    <th style="text-align:center">Cantidad de Citas</th>
                                                </tr>
                                            </thead>
                                            <tbody style="text-align:center;">
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                                
                            <div class="col-md-4">
                                <fieldset class="form-inline">
                                    <div align="center">
                                        <label for="">Seleccionar Hora</label>
                                        <input type="text" id="hora" placeholder="hh:mm am" value="" />
                                    </div>
                                </fieldset>

                                <br>                     
                                <fieldset class="form-inline">
                                    <div align="center">
                                        <label for="tipo_cita">Tipo de Cita</label>
                                        <select class="selectpicker" id="tipo_cita">

                                            <!-- Mostrar opciones -->
                                            <?php   echo Mostrar_Tipos_Citas(); ?>

                                        </select>
                                    </div>
                                </fieldset>

                                <br>                                                           
                                <fieldset class="form-inline">
                                    <div align="center">
                                        <label for="tratamientos">Procedimiento</label>
                                        <select class="form-control" id="tratamientos">

                                            <!--    MOSTRAR TRATAMIENTO DEL PACIENTE    -->

                                        </select>
                                    </div>
                                </fieldset>

                            </div>

                            <div class="col-md-4">
                                <fieldset class="form-inline">
                                    <div align="center">
                                        <label for="comentario_cita">Añadir Comentario (Opcional)</label>
                                        <textarea id="comentario_cita" name="comentario_cita" class="form-control" rows="5"></textarea>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <!--SE GUARDA LA PERSONA QUE CREO LA CITA-->
                        <input type="hidden" name="created_by" id="created_by" value="<?php echo $_SESSION['Id']?>"> 
                        <br>        
                        <div class="form-group row" align="center">
                            <div class="col-md-12">
                                <a class="btn btn-success" href="#" id="registrar_cita" role="button" style="visibility: hidden"><span class="glyphicon glyphicon-edit"></span> Confirmar Cita</a>

                                <!--
                                    <a class="btn btn-info" href="#" role="button" id="pago" style="visibility: hidden"><span class="glyphicon glyphicon-usd"></span> Agregar Pago</a>
                                -->
                            </div>        
                        </div>
                    </div>		
                </div>	        
			</div>
 
    <script type="text/javascript" src="<?php echo app_url(); ?>js/recepcion.js"></script>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>