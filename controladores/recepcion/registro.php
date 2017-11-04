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

                        <h2 style="display:inline; color:#337ab7;">Recepción - Registro de Pacientes Existentes</h2>

                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Agrega un paciente existente al sistema."></span>

                        <div id="error"></div>
                        <hr>

                            
                            <h3>Captura los datos del paciente.</h3>
                            <br>
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

                            <div id="segmentoActualizar">
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

    <script type="text/javascript" src="<?php echo app_url(); ?>js/recepcion.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>