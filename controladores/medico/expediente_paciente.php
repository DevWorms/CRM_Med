    <?php
        include dirname(__FILE__) . '/../layouts/header.php';
        include dirname(__FILE__) . '/../utilidades/funciones/func_option_select.php'; 
    ?>

    <style>
        .ui-autocomplete { z-index:2147483647; }
    </style>

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
                        <div id="error"></div>
                        <div id="header" style="display: inline">
                        </div>
                        <span class="glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Acceso al expediente completo del paciente "></span>
                        
                        <hr>
                        <div id="error"></div>

                        <div class="col-md-12">
                            
                <!-- //////////////////////    PESTAÑAS DISPONIBLES    ////////////////////// -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#resumen">Resumen</a></li>
                                <li><a data-toggle="tab" href="#presupuesto">Nuevo Presupuesto</a></li>
                                <li><a data-toggle="tab" href="#detalle_presupuestos" onclick="loadPresupuestos();">Ver Presupuestos</a></li>
                                <li><a data-toggle="tab" href="#observaciones" onclick="loadObservaciones();">Observaciones</a></li>
                                <li><a data-toggle="tab" href="#documentos" onclick="getDocuments(); loadPresupuestosFaster();">Documentos</a></li>
                                <li><a data-toggle="tab" href="#administracion">Administración</a></li>
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

                                        <div align="right" class="col-md-12">
                                            <span class="btn btn-default" id="actualizar_info" data-toggle="modal" data-target="#myModal">Actualizar antecedentes</span>
                                        </div>
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

                    <!-- +++++++++++++++++    PESTAÑA DE NUEVO PRESUPUESTO    ++++++++++++++++++++ -->
                                <div id="presupuesto" class="tab-pane fade">
                                    
                                    <h3>Nuevo Presupuesto</h3>
                                    <br>                                    
                                    
                                    <div class="col-md-12">
                                        <div class="col-md-6 form-group">
                                            <label for="nombre_presupuesto">Nombre</label>
                                            <input type="text" id="nombre_presupuesto" name="nombre_presupuesto" class="form-control">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="tipo_presupuesto">Tipo</label><br>
                                            <select class="selectpicker" id="tipo_presupuesto" name="tipo_presupuesto">
                                                <option value="1">Tratamiento</option>
                                                <option value="2">Cirugía</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-8 form-group">
                                            <label for="descripcion_presupuesto">Descripción</label>
                                            <textarea id="descripcion_presupuesto" name="descripcion_presupuesto" class="form-control" rows="4"></textarea>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="numero_citas">Número de Sesiones o Consultas</label>
                                            <input type="number" id="numero_citas" name="numero_citas" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-3 form-group">
                                            <label for="precio_normal">Precio Normal</label>
                                            <input type="number" id="precio_normal" name="precio_normal" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="precio_promocion">Precio Promoción</label>
                                            <input type="number" id="precio_promocion" name="precio_promocion" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="precio_contado">Precio Contado</label>
                                            <input type="number" id="precio_contado" name="precio_contado" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="fecha">Vigencia</label>
                                            <input type="text" class="search-query form-control" id="fecha" name="fecha" placeholder="aaaa / mm / dd" required/>
                                        </div>
                                    </div>

                                    <div align="right" class="col-md-12">
                                        <br>
                                        <button class="btn btn-success" id="crear_presupuesto" name="crear_presupuesto">Generar Presupuesto</button>
                                    </div>

                                </div>

                            <!-- +++++++++++++++++    PESTAÑA DE PRESUPUESTOS    ++++++++++++++++++++ -->
                                <div id="detalle_presupuestos" class="tab-pane fade">
                                    <h3>Detalle de Presupuestos</h3> 
                                    <br>

                                    <div class="col-md-12">
                                        <button type="button" onclick="filtrar(1);" class="btn btn-primary" >Todos</button>
                                        <button type="button" onclick="filtrar(2);" class="btn btn-info" >Tratamientos</button>
                                        <button type="button" onclick="filtrar(3);" class="btn btn-success" >Cirugías</button>
                                        <button type="button" onclick="filtrar(4);" class="btn btn-default" >No Iniciados</button>
                                        <button type="button" onclick="filtrar(5);" class="btn btn-danger" >Vigencia Cadúca</button>
                                        <br><br>
                                    </div>

                                    <div id="prespuestos"></div>
                                </div>

                            <!-- +++++++++++++++++    PESTAÑA DE OBSERVACIONES    ++++++++++++++++++++ -->
                                <div id="observaciones" class="tab-pane fade">
                                    <h3>Observaciones</h3>
                                    <br>

                                    <div>
                                        <label for="nueva_observacion">Agrega una nueva observación</label>
                                        <textarea id="nueva_observacion" name="nueva_observacion" class="form-control" rows="2"></textarea>

                                        <div align="right">
                                            <br>
                                            <button class="btn btn-primary" id="btn_nueva_observacion" name="btn_nueva_observacion">Añadir observación</button>
                                        </div>

                                        <hr class="dashed">
                                    </div>

                                    <div id="observaciones_table"></div>


                                </div>

                            <!-- +++++++++++++++++    PESTAÑA DE DOCUMENTOS    ++++++++++++++++++++ -->
                                <div id="documentos" class="tab-pane fade">
                                    <h3>Agregar Nuevo Documento</h3>
                                    <br>

                                    <div class="col-md-12" align="center"> 
                                        <label for="tipo_documento">Selecciona Documento</label><br>
                                        <select class="selectpicker" id="tipo_documento" name="tipo_documento" onchange="cargarDocumentos()">
                                        <?php 
                                            mostrarExpedientesMaster();
                                         ?>
                                        </select>

                                        <hr class="dashed">
                                    </div>

                            <!--    +++++++++++++++++++++++++++++++++++++++++++++   -->
                            <!--    MOSTRAR ESTA PARTE CUANDO ESCOGEN VALUE 1 O 2   -->
                            <!--    +++++++++++++++++++++++++++++++++++++++++++++   -->
                                    <div id="docs1" style="display: none">
                                        <form enctype="multipart/form-data" method="POST" id="uploadDocument" name="uploadDocument">
                                            <div class="col-md-12" >
                                                <div class="col-md-4 form-group">
                                                    <label for="nombre_documento">Nombre del Documento</label><br>
                                                    <select class="form-control" id="nombre_documento" name="nombre_documento">
                                                    </select>
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label for="select_presupuesto">Seleccionar Presupuesto</label><br>
                                                    <select class="form-control" id="select_presupuesto" name="select_presupuesto">
                                                    </select>
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label for="tipo_expediente">Selecciona Expediente</label><br>
                                                    <select class="selectpicker" id="tipo_expediente" name="tipo_expediente">
                                                        <option value="1">Laboratorios</option>
                                                        <option value="2">Estudio Anexo / Complementario</option>
                                                        <option value="3">Valoración Cirujano</option>
                                                        <option value="4">Valoración Cardiólogo</option>
                                                        <option value="5">Interconsulta</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="col-md-6 form-group">
                                                    <label for="descripcion_documento">Descripción</label>
                                                    <textarea id="descripcion_documento" name="descripcion_documento" class="form-control" rows="2"></textarea>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="buscar_documento">Buscar documento</label>
                                                    <input type="file" name="buscar_documento" id="buscar_documento">
                                                </div>
                                            </div>

                                            <div class="col-md-12" align="right">
                                                <button class="btn btn-primary" id="btn_nuevo_documento" name="btn_nuevo_documento">Añadir documento</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div id="docs2" style="display: none">
                                        <form enctype="multipart/form-data" method="POST" id="uploadOtroDocument" name="uploadOtroDocument">
                                            <!--    +++++++++++++++++++++++++++++++++++++++++++++   -->
                                            <!--      MOSTRAR ESTA PARTE CUANDO ESCOGEN VALUE 3     -->
                                            <!--    +++++++++++++++++++++++++++++++++++++++++++++   -->
                                            <div class="col-md-12">
                                                <div class="col-md-6 form-group">
                                                    <label for="nombre_otro_documento">Nombre del documento</label>
                                                    <input type="text" id="nombre_otro_documento" name="nombre_otro_documento" class="form-control">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="buscar_otro_documento">Buscar Documento</label>
                                                    <input type="file" name="buscar_otro_documento" id="buscar_otro_documento">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="col-md-6 form-group">
                                                    <label for="descripcion_otro_documento">Descripción</label>
                                                    <textarea id="descripcion_otro_documento" name="descripcion_otro_documento" class="form-control" rows="2"></textarea>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <br><br>
                                                    <button class="btn btn-primary" id="agregar_otro_documento" name="agregar_otro_documento">Añadir documento</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                            <!--    +++++++++++++++++++++++++++++++++++++++++++++   -->
                            <!--    MOSTRAR ESTA PARTE CUANDO ESCOGEN VALUE 1 O 2   -->
                            <!--    Y ADEMÁS SELECCIONAN UN PRESUPUESTO, PARA       -->
                            <!--    MOSTRAR LOS DOCUMENTOS ASOCIADOS AL PRESUPUESTO -->
                            <!--    +++++++++++++++++++++++++++++++++++++++++++++   -->

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

                    <!-- +++++++++++++++++    PESTAÑA DE ADMINISTRACIÓN    ++++++++++++++++++++ -->
                                <div id="administracion" class="tab-pane fade">
                                    <h3>Administrar Paciente</h3>
                                    
                                    <table class="table sm-table table-condensed" id="admon_table">
                                        <thead>
                                            <tr>
                                                <th>Presupuesto</th>
                                                <th>Pagado</th>
                                                <th>Restante</th>             
                                                <th>% Para que se opere</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row"></div>
                    </div> 
                </div>          
            </div>


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Actualizar Antecedentes del Paciente</h4>
                </div>

                <div class="modal-body">
                    <label for="quirurgicos_txt">Quirúrgicos</label>
                    <input type="text" id="quirurgicos_txt" name="quirurgicos_txt" class="form-control"><br>
                
                    <label for="alergicos_txt">Alérgicos</label>
                    <input type="text" id="alergicos_txt" name="alergicos_txt" class="form-control"><br>
                
                    <label for="">Anestesia</label><br>
                    <input type="checkbox" value=""> General</label>
                    <input type="checkbox" value=""> Local</label>
                    <br><br>

                    <label for="padeceimientos_txt">Padecimientos</label>
                    <input type="text" id="padeceimientos_txt" name="padeceimientos_txt" class="form-control"><br>
                
                    <label for="medicamentos_txt">Medicamentos</label>
                    <input type="text" id="medicamentos_txt" name="medicamentos_txt" class="form-control"><br>
                
                    <label for="tabaquismo_txt">Tabaquismo</label>
                    <input type="text" id="tabaquismo_txt" name="tabaquismo_txt" class="form-control"><br>
                
                    <label for="otros_txt">Otros</label>
                    <input type="text" id="otros_txt" name="otros_txt" class="form-control"><br>

                    <div align="center">
                        <button class="btn btn-info" id="actualizar_info_btn" data-toggle="modal" data-target="#myModal">Actualizar Antecedentes</button>
                    </div>
                </div>

            </div>

        </div>
    </div>

            <!-- Modal actualizar porcentaje de operación -->
            <div class="modal fade" id="modalPorcentajes" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Actualizar porcentajes de operación</h4>
                        </div>

                        <div class="modal-body">
                            <div class="col-md-6">
                                <label for="porcentajes_txt">Porcentaje</label>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" id="pocentajes_id_txt" name="pocentajes_id_txt">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" id="porcentajes_txt" name="porcentajes_txt" class="form-control">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div><br>
                            </div>
                            <div  align="center">
                                <button class="btn btn-info" id="actualizar_porcentajes_btn" >Actualizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal transferir paciente -->
            <div class="modal fade" id="modalTransferirPaciente" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Transferir paciente</h4>
                        </div>

                        <div class="modal-body">
                            <div class="col-md-6">
                                <label for="transferir_medico">Asignar a:</label>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" id="transferir_paciente_id" name="transferir_paciente_id">
                                <input type="hidden" id="transferir_medico_id" name="transferir_medico_id">
                                <input type="text" id="transferir_medico_nombre" name="transferir_medico_nombre" class="form-control ui-autocomplete"><br>
                            </div>
                            <br>
                            <br>
                            <div  align="center">
                                <button class="btn btn-info" id="transferir_paciente_btn" >Transferir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal generar nueva cita -->
            <div class="modal fade" id="generarCita" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Generar nueva cita</h4>
                        </div>

                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div id="header">
                                        <H4> Procedimiento: </H4>
                                    </div>
                                    <div id="procedimiento">
                                        ${nombre}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="header">
                                        <H4> Observaciones: </H4>
                                    </div>
                                    <div id="procedimiento_observaciones">
                                        ${comentario}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr class="dotted">
                                <h3 align="center">Editar Cita</h3>
                            </div>

                            <div class="form-group row space" align="center">
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="">Fechas Disponibles</label>
                                        <fieldset class="form-inline">
                                            <div class="input-group">
                                                <input type="text" class="search-query form-control" id="fecha_${id}" name="fecha_${id}" placeholder="aaaa / mm / dd" value="${fecha}" required/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="button">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </fieldset>
                                        <br><br>
                                        <table class="table table-striped" id="citas_by_date_${id}">
                                            <thead>
                                            <tr>
                                                <th style="text-align:center">Hora</th>
                                                <th style="text-align:center">Tipo de Cita</th>
                                            </tr>
                                            </thead>
                                            <tbody style="text-align:center;">
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <div align="center">
                                            <label for="hora_${id}">Seleccionar Hora</label>
                                            <input type="text" id="hora_${id}" placeholder="hh:mm am" value="${hora_ini}" />
                                        </div>
                                    </fieldset>

                                    <br>
                                    <fieldset class="form-inline">
                                        <div align="center">
                                            <label for="tipo_cita_${id}">Tipo de Cita</label>
                                            <select class="form-control" id="tipo_cita_${id}">
                                            </select>
                                        </div>
                                    </fieldset>

                                    <br>
                                    <fieldset class="form-inline">
                                        <div align="center">
                                            <label for="tratamientos_${id}">Tratamiento</label>
                                            <select class="form-control" id="tratamientos_${id}">
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <div align="center">
                                            <label for="comentario_cita">Añadir Comentario (Opcional)</label>
                                            <textarea id="comentario_cita" name="comentario_cita" class="form-control" rows="3"></textarea>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <button class="btn btn-info" id="btn_generarCita">Generar cita</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="<?php echo app_url(); ?>js/medico-expediente.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>