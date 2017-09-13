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

                        <h2 style="display:inline; color:#337ab7;">Recepción - Control Pacientes </h2>

                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Agrega un nuevo paciente o modifica uno existente al registro de la base de datos"></span>

                        <div id="error"></div>

                        <hr>

                            <H3 id="nuevo" style="cursor:pointer"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Registro </H3>
                            <div id="segmentoNuevo">
                                Captura los datos del paciente.
                                <br><br>
                                <div class="col-md-12">
                                    <div class="col-md-4 form-group">
                                        <label for="nombre">Nombre(s)</label>
                                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Campo Requerido">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="apPat">Apellido Paterno</label>
                                        <input type="text" id="apPat" name="apPat" class="form-control" placeholder="Campo Requerido">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="apMat">Apellido Materno</label>
                                        <input type="text" id="apMat" name="apMat" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-3 form-group">
                                        <label for="domicilio">Domicilio</label>
                                        <input type="text" id="domicilio" name="domicilio" class="form-control" placeholder="Campo Requerido">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="tel">Teléfono</label>
                                        <input type="text" id="tel" name="tel" class="form-control" placeholder="Campo Requerido">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" id="email" name="email" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="ocupacion">Ocupación</label>
                                        <input type="text" id="ocupacion" name="ocupacion" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-3 form-group">
                                        <label for="fecha_nac">Fecha de Nacimiento</label>
                                        <input type="date" id="fecha_nac" name="fecha_nac" class="form-control">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="edad">Edad</label>
                                        <input type="number" id="edad" name="edad" class="form-control" disabled>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="nombre_familiar">Nombre de Familiar</label>
                                        <input type="text" id="nombre_familiar" name="nombre_familiar" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="tel_familiar">Telefono de Familiar</label>
                                        <input type="text" id="tel_familiar" name="tel_familiar" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="col-md-3 form-group">
                                        <label for="referencia">¿Donde vio el anuncio?</label>
                                        <input type="text" id="referencia" name="referencia" class="form-control">
                                    </div>
                                    <div class="col-md-5 form-group">
                                        <label for="folio">¿Folio anterior? <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Si el usuario ya estaba previamente registrado, puedes agregar el folio con el que fue dado de alta; en caso contrario dejar este espacio en blanco"></span></label>
                                        <input type="number" id="folio" name="folio" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                </div>

                                <div class="form-group" align="right">
                                    <span class="btn btn-primary" id="registrar">Crear nuevo registro</span>
                                </div>
                            </div>
                            <hr>
                            <H3 id="actualizar" style="cursor:pointer"><span class="glyphicon glyphicon-refresh"></span> Modificar Registro</H3>
                            <div id="segmentoActualizar">
                                <div class="form-group row">
                                    <div class="col-md-12" align="center">
                                        <form action="" method="POST" id="search-form">
                                            <div class="input-group col-md-9">
                                                <input type="text" class="form-control" id="param" name="param"  placeholder="Buscar ..." required>
                                                <span class="input-group-btn">
                                                    <button  class="btn btn-primary" type="button" onclick="onclick="event.preventDefault(); showPaciente();"">
                                                        <span class="glyphicon glyphicon-search"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <table class="table table-striped" id="pacientes">
                                    <thead>
                                      <tr>
                                        <th style="text-align:center">Nombre Completo</th>
                                        <th style="text-align:center">Folio</th>
                                        <th style="text-align:center">Teléfono</th>
                                        <th style="text-align:center">Modificar</th>
                                        <th style="text-align:center">Modificar <br> primera vez</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div align="center" class="thumbnail">
                                    <ul class="pagination" id="pagination">
                                    </ul>
                                </div>
                            </div>

                    </div>      
                </div>          
            </div>

            <!--Modales-->
            <div class="modal fade" tabindex="-1" role="dialog" id="errorModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Error</h4>
                        </div>
                        <div class="modal-body" id="ErrorModalBody">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div class="modal fade" tabindex="-1" role="dialog" id="exitoModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Exito!!</h4>
                        </div>
                        <div class="modal-body" id="ExitoModalBody">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <div id="modalsEdit"></div>

            <script type="text/template" id="modal_edit_paciente">
                <div id="EditPaciente-${id}" class="modal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" style="text-align:center;">Editar paciente ${nombre} ${apPaterno} ${apMaterno}</h4>
                            </div>

                            <form class="form-signin" method="post" action="#">
                                <div class="modal-body" >
                                    <input type="hidden" id="up_id_${id}" name="up_id_${id}" value="${id}">

                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label for="up_new_id_${id}">Folio: </label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" id="up_new_id_${id}" name="up_new_id_${id}" class="form-control" placeholder="Campo Requerido" value="${id}">
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="up_nombre_${id}">Nombre(s)</label>
                                            <input type="text" id="up_nombre_${id}" name="up_nombre_${id}" class="form-control" placeholder="Campo Requerido" value="${nombre}">
                                        </div>
                                        <div class="form-group">
                                            <label for="up_apMat_${id}">Apellido Materno</label>
                                            <input type="text" id="up_apMat_${id}" name="up_apMat_${id}" class="form-control" value="${apMaterno}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="up_apPat_${id}">Apellido Paterno</label>
                                            <input type="text" id="up_apPat_${id}" name="up_apPat_${id}" class="form-control" placeholder="Campo Requerido" value="${apPaterno}">
                                        </div>
                                        <div class="form-group">
                                            <label for="up_domicilio_${id}">Domicilio</label>
                                            <input type="text" id="up_domicilio_${id}" name="up_domicilio_${id}" class="form-control" placeholder="Campo Requerido" value="${domicilio}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="up_tel_${id}">Teléfono</label>
                                            <input type="text" id="up_tel_${id}" name="up_tel_${id}" class="form-control" placeholder="Campo Requerido" value="${telefono}">
                                        </div>
                                        <div class="form-group">
                                            <label for="up_fecha_nac_${id}">Fecha de Nacimiento</label>
                                            <input type="date" id="up_fecha_nac_${id}" name="up_fecha_nac_${id}" class="form-control" value="${fecha_nacimiento}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="up_email_${id}">E-mail</label>
                                            <input type="email" id="up_email_${id}" name="up_email_${id}" class="form-control" value="${email}">
                                        </div>
                                        <div class="form-group">
                                            <label for="up_edad_${id}">Edad</label>
                                            <input type="number" id="up_edad_${id}" name="up_edad_${id}" class="form-control" value="${edad}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="up_ocupacion_${id}">Ocupación</label>
                                            <input type="text" id="up_ocupacion_${id}" name="up_ocupacion_${id}" class="form-control" value="${ocupacion}">
                                        </div>
                                        <div class="form-group">
                                            <label for="up_nombre_familiar_${id}">Nombre de Familiar</label>
                                            <input type="text" id="up_nombre_familiar_${id}" name="up_nombre_familiar_${id}" class="form-control" value="${nombreFamiliar}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="up_tel_familiar_${id}">Telefono de Familiar</label>
                                            <input type="text" id="up_tel_familiar_${id}" name="up_tel_familiar_${id}" class="form-control" value="${telefonoFamiliar}">
                                        </div>
                                        <div class="form-group">
                                            <label for="up_referencia_${id}">¿Donde vio el anuncio?</label>
                                            <input type="text" id="up_referencia_${id}" name="up_referencia_${id}" class="form-control" value="${referencia}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="modal-footer">
                                    <div class="form-group" align="right">
                                        <div class="col-md-12">
                                            <div class="col-md-8"></div>
                                            <div class="col-md-4">
                                                <button class="btn btn-primary btn-block" type="submit" name="up_button" onclick="event.preventDefault(); editPaciente(${id})"
                                                    id="up_button">Actualizar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </script>
    <script type="text/javascript" src="<?php echo app_url(); ?>js/recepcion.js"></script>

    <script>
        $(document).ready(function(){
            
            //  OCULTA LOS SEGMENTOS DE "NUEVO REGISTRO" Y "ACTUALIZAR PACIENTE"
            //$("#segmentoNuevo").hide();    
            $("#segmentoActualizar").hide(); 

            $("#nuevo").click(function(){
                $("#segmentoNuevo").slideToggle();
                $("#segmentoActualizar").slideUp();
            });

            $("#actualizar").click(function(){
                $("#segmentoActualizar").slideToggle();
                $("#segmentoNuevo").slideUp();
            });

        });
    </script>


<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>