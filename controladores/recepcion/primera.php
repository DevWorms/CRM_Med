<?php
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
                    <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right"
                          title="Encuentra a un usuario a través del buscador escribiendo su nombre; si la búsqueda arroja un resultado, podrás programarle una nueva cita"></span>
                    <hr>

                    <div class="row">
                        <div class="col-md-12" align="center">
                            <div align="center">
                                <a class="btn btn-primary"
                                   role="button" <?php echo '<a href="' . app_url() . 'citas"' ?> >Usuarios con registro
                                    previo</a>
                                <a class="btn btn-primary active" role="button">Usuarios de primera vez</a>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div id="error"></div>
                    <div class="form-group row space">
                        <div class="col-md-5" align="right">
                            <!--
                                <img src="../../img/user-male.png" class="img-rounded" width="100" height="100">
                            -->
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-4 form-group">
                                <label for="new_nombre">Nombre(s)</label>
                                <input type="text" id="new_nombre" name="new_nombre" class="form-control"
                                       placeholder="Campo Requerido" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="new_apPat">Apellido Paterno</label>
                                <input type="text" id="new_apPat" name="new_apPat" class="form-control"
                                       placeholder="Campo Requerido" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="new_apMat">Apellido Materno</label>
                                <input type="text" id="new_apMat" name="new_apMat" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-3 form-group">
                                <label for="new_procedimiento">Procedimiento</label>
                                <input type="text" id="new_procedimiento" name="new_procedimiento" class="form-control"
                                       placeholder="Campo Requerido" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="new_anuncio">Donde vió el anuncio</label>
                                <input type="text" id="new_anuncio" name="new_anuncio" class="form-control"
                                       placeholder="Campo Requerido" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="new_telefono">Teléfono 1</label>
                                <input type="number" id="new_telefono" name="new_telefono" class="form-control"
                                       placeholder="Campo Requerido" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="other_telefono">Teléfono 2</label>
                                <input type="number" id="other_telefono" name="other_telefono" class="form-control">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <fieldset class="form-inline">
                                <div>
                                    <label for="">Fechas Disponibles</label>
                                    <fieldset class="form-inline">
                                        <div class="input-group">
                                            <input type="text" class="search-query form-control" id="new_fecha"
                                                   name="new_fecha" placeholder="aaaa / mm / dd" required/>
                                            <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="button">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </button>
                                                </span>
                                        </div>
                                    </fieldset>
                                    <br><br>
                                    <table class="table table-striped" id="citas_by_date">
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
                                    <label for="new_hora">Seleccionar Hora</label>
                                    <input type="text" id="new_hora" name="new_hora" placeholder="hh:mm am"
                                           value=""/>
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
                    <hr>
                    <div class="form-group row space" align="center">
                        <div class="col-md-12">
                            <div class="col-md-8 form-group"></div>
                            <div class="col-md-4 form-group">
                                <a class="btn btn-success" href="#" id="new_registrar_cita" role="button">
                                    <span class="glyphicon glyphicon-edit"></span> Confirmar Cita
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="<?php echo app_url(); ?>js/recepcion.js"></script>
<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>