<?php include dirname(__FILE__) . '/../layouts/header.php'; 
 include dirname(__FILE__) . '/../utilidades/funciones/func_option_select.php'; 
 ?>

<style>
    .ui-autocomplete { z-index:2147483647; }
</style>

<div class="container">
    <?php include dirname(__FILE__) . "/../layouts/navbar.php"; ?>
</div>
    
<!-- Page Content -->
<div class="container" style="overflow-y: scroll;">
    <div class="row">
        <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>

        <input type="hidden" id="get" name="get" value="create">
        <div class="col-md-9">
            <div class="thumbnail border_content">
                <div class="caption-full">
                    <h2 style="display:inline;" class="title_header">Médico - Quirófano </h2></h2>

                    <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right"
                          title="Registro de pacientes ingresados a quirófano y sus involucrados"></span>
                    <hr>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10 col-md-ofset-1">
                            <div class="row">
                                <div class="col-md-12">
                                        <div class="input-group">
                                              <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                              <input type="text" id="searchPac" name="searchPac" class="form-control" placeholder="Paciente intervenido">
                                        </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                     <button class="btn btn-info btn-block" onclick='$("#modal-addOutProduct").modal().show()'>
                                        <i class="glyphicon glyphicon-plus"></i> Añadir Producto
                                    </button>
                                </div>
                            </div>
                            <br>
                            <!--FORM-->
                            <form id="form-genSalidas">
                            <input type="hidden" id="user" name="user" value="<?php echo $_SESSION["Id"];?>">
                            <input type="hidden" id="medico" name="medico" value='<?php echo $_SESSION["Id"]; ?>' >
                              <input type="hidden" id="medicoCirugia" name="medicoCirugia" value='<?php echo $_SESSION["Id"]; ?>'>
                            <input type="hidden" id="paciente" name="paciente" value="" >
                            <input type="hidden" id="get" name="get" value="generarSalida">
                            <!-- Datos para quirofano-->
                            <input type="hidden" id="infoProcedimiento" name="infoProcedimiento" value="" >

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th style="display: none;">id</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>&nbsp;</th>
                                        </thead>
                                        <tbody id="productosToOut"></tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="searchMed" name="searchMed" class="form-control" placeholder="Médico responsable" value='<?php echo $_SESSION["Id"].'- '.$_SESSION['Nombre'];?>'>
                                </div>
                            </div>
                            <br>
                              <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="searchMedCirugia" name="searchMedCirugia" class="form-control" placeholder="Médico que realiza la cirugia" value='<?php echo $_SESSION["Id"].'- '.$_SESSION['Nombre'];?>'>
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                <label for="">Entrada al quirófano</label>
                                    <fieldset class="form-inline">
                                        <div class="input-group">
                                            <input type="text" class="search-query form-control" id="fechaEntrada" name="fechaEntrada" placeholder="aaaa / mm / dd" required/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </button>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <label for="">Seleccionar hora</label>
                                            <input type="text" id="horaQuirofano" placeholder="hh:mm am" value="" class="form-control" />
                                        </div>
                                    </fieldset>                                
                                </div>
                                <div class="col-md-6">
                                    <label for="">Salida del quirófano</label>
                                        <fieldset class="form-inline">
                                        <div class="input-group">
                                            <input type="text" class="search-query form-control" id="fechaSalida" name="fechaSalida" placeholder="aaaa / mm / dd" required/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </button>
                                            </span>
                                        </div>
                                        <div class="input-group">
                                            <label for="">Seleccionar hora</label>
                                            <input type="text" id="horaSalidaQuirofano" placeholder="hh:mm am" value="" class="form-control" />
                                        </div>
                                    </fieldset>                 
                                </div>
                            </div>
                            <br>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea style="resize: none;" name="procedimiento" id="procedimiento"  class="form-control" placeholder="Información del procedimiento"></textarea>
                                   </div>
                            </div>
                            <br>
                            <hr>
                            <div class="row">
                                <div class="col-md-9">
                                    <div id="error"></div>
                                    <div id="progressbox" style="">
                                        <div id="progressbar" class="progressbar"></div ><div id="statustxt" class="statustxt">0%</div>
                                    </div>
                                    <div id="header">
                                    </div>
                                    <hr>
                                    <div id="error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#resumen">Resumen</a></li>
                                        <li><a data-toggle="tab" href="#observaciones" onclick="loadObservaciones();">Observaciones</a></li>
                                        <li><a data-toggle="tab" href="#documentos" onclick="getDocuments(); loadPresupuestosFaster();">Documentos</a></li>
                                    </ul>
                                    <div class="tab-content"> 
                            <!-- +++++++++++++++++    PESTAÑA DE RESUMEN    ++++++++++++++++++++ -->
                                        <div id="resumen" class="tab-pane fade in active">
                                            <h3>Resumen</h3>

                                            <div class="col-md-7">
                                                <H4><b> Información del Paciente </b></H4>
                                                <div id="info">
                                                    Dirección:
                                                    <br>
                                                    Ocupación:
                                                    <br>
                                                    Fecha de Nacimiento:
                                                    <br>
                                                    Edad:
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <H4><b> Medios de Contacto </b></H4>
                                                <div id="contacto">
                                                    Teléfono:
                                                    <br>
                                                    Email:
                                                    <br>
                                                    Nombre de Familiar:
                                                    <br>
                                                    Teléfono de Familiar:
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <hr class="gradient">
                                                <H4 align="center"><b> Antecedentes </b></H4>
                                                <br>

                                                <div class="col-md-4">
                                                    <strong>Quirúrgicos: </strong><div id="quirurgicos_div"></div>
                                                    <br>
                                                    <strong>Alérgicos: </strong> <div id="alergicos_div"></div>
                                                    <br>
                                                    <strong>Anestesia: </strong> <div id="anestesia_div"></div>
                                                </div>

                                                <div class="col-md-4">
                                                    <strong>Padecimientos: </strong> <div id="padecimientos_div"></div>
                                                    <br>
                                                    <strong>Medicamentos: </strong> <div id="medicamentos_div"></div>
                                                </div>

                                                <div class="col-md-4">
                                                    <strong>Tabaquismo:</strong> <div id="tabaquismo_div"></div>
                                                    <br>
                                                    <strong>Otros:</strong> <div id="otros_div"></div>
                                                </div>

                                                <br>
                                            </div>

                                            <div class="col-md-12" align="center">
                                                <hr class="dashed">
                                                <H4><b> Historial </b></H4>
                                                <br>
                                            </div>

                                            
                                            <table class="table sm-table table-condensed" id="historial">
                                                <thead>
                                                    <tr>
                                                        <th>Presupuestos</th>
                                                        <th>Sesiones o Consultas</th>
                                                        <th>Ultima cita</th>
                                                        <th>% Pagado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                                           
                                            <!-- +++++++++++++++++    PESTAÑA DE OBSERVACIONES    ++++++++++++++++++++ -->
                                                   <div id="observaciones" class="tab-pane fade">
                                            <h3>Observaciones</h3>
                                            <br>

                                            <div>
                                                <textarea id="nueva_observacion" name="nueva_observacion" class="form-control" rows="2"></textarea>

                                                <hr class="dashed">
                                            </div>

                                            <div id="observaciones_table"></div>


                                        </div>
                                            <!-- +++++++++++++++++    PESTAÑA DE DOCUMENTOS    ++++++++++++++++++++ -->
                                    <div id="documentos" class="tab-pane fade">
                                    <h3>Documentos</h3>
                                    <br>

                                   <!-- MOSTRAR ESTA PARTE CUANDO ESCOGEN VALUE 1 O 2   
                                    Y ADEMÁS SELECCIONAN UN PRESUPUESTO, PARA       
                                    MOSTRAR LOS DOCUMENTOS ASOCIADOS AL PRESUPUESTO -->
                                    <div class="col-md-12">
                                        <hr class="gradient">

                                        <table class="table sm-table table-condensed" id="tbl_documents">
                                            <thead>
                                                <tr>
                                                    <th>Nombre del Documento</th>
                                                    <th>Tipo de Expediente</th>
                                                    <th>Descripción</th>
                                                    <th>Añadido por</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>


                           <!--Aqui se acab la sección de xpediente medico -->     
                            </div>

                            </div>
                            <div class="row">
                                <div class="col-md-9"></div>
                                <div class="col-md-3">
                                    <button class="btn btn-success btn_exito" type="button" onclick="generarIngreso()">
                                        <i class="glyphicon glyphicon-tag"></i>
                                         Registrar ingreso
                                    </button>
                                </div>
                            </div>
                            </form>
                            <!--form-->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALS PARA SELECCION DE PRODUCTOS, MEDICO Y PACIENTE-->
    <div id="modal-addOutProduct" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Agregar productos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control ui-autocomplete-input" id="searchProd" name="searchProd" placeholder="Buscar producto" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <thead>
                                    <th style="display: none;">ID</th>
                                    <th>Producto</th>
                                    <th>Existencia</th>
                                    <th>Cantidad</th>
                                    <th>&nbsp;</th>
                                </thead>
                                <tbody id="preOutPoducts">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <div class="row">
                        <div align="center" class="col-md-12">
                            <button class="btn btn-info" onclick="pastProductoSelection()">
                                Listo <i class="glyphicon glyphicon-ok-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ MODALS PARA SELECCION DE PRODUCTOS, MEDICO Y PACIENTE-->
</div>


<script src="<?php echo app_url(); ?>js/medico-expediente.js" type="text/javascript"></script>
<script src="<?php echo app_url(); ?>js/medico_quirofano.js" type="text/javascript"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>
