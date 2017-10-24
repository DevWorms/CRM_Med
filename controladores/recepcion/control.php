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

                        <h2 style="display:inline; color:#337ab7;">Recepción - Control Pacientes </h2>

                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Modifica y controla el registro de Pacientes y Leads."></span>

                        <div id="error"></div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12" align="center">
                                <div align="center">
                                    <a class="btn btn-primary active" role="button"><h4>Pacientes</h4></a>

                                    <a class="btn btn-primary" <?php echo '<a href="' . app_url() . 'leads"' ?> role="button"><h4>Leads</h4></a>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div id="segmentoActualizar">
                            <div >
                                <table class="table table-striped" id="pacientes">
                                    <thead>
                                      <tr>
                                        <th style="text-align:center">Nombre Completo</th>
                                        <th style="text-align:center">Folio</th>
                                        <th style="text-align:center">Teléfono</th>
                                        <th style="text-align:center">Correo Electrónico</th>
                                        <th style="text-align:center">Modificar</th>
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
    <script type="text/javascript" src="<?php echo app_url(); ?>js/control.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>