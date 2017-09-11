<?php
include dirname(__FILE__) . '/../layouts/header.php';
include dirname(__FILE__) . '/../utilidades/funciones/func_fill_selects.php';
?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>
        <div class="col-md-9">
            <div class="thumbnail">
                <div class="caption-full">
                    <h2 style="display:inline; color:#337ab7;">Administrador - Crear usuario </h2>
                    <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Gestiona los usuarios en la aplicación."></span>
                    <hr>
                    <div id="error"></div>

                    <!-- formulario -->
                    <form id="newUser">
                        <input type="hidden" id="get" name="get" value="create">
                        <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label for="nombre">Nombre(s)</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="apPat">Apellido Paterno</label>
                                <input type="text" id="apPat" name="apPat" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label for="apMat">Apellido Materno</label>
                                <input type="text" id="apMat" name="apMat" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="username">Número de usuario</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="confirm_password">Confirmar contraseña</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6 form-group">
                                <label for="type">Tipo de usuario</label>
                                <select id="type" class="form-control">
                                    <option disabled selected>Seleccionar tipo</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Médico</option>
                                    <option value="3">Farmacia</option>
                                    <option value="4">Recepcionista</option>
                                    <option value="5">CallCenter</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <div id="div_cedula" style="display: none">
                                    <label for="cedula">Cedula profesional</label>
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cedula profesional">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8">
                                <div class="col-md-3 form-group">
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="perm_farmacia" name="perm_farmacia">Farmacia</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="perm_recepcion" name="perm_recepcion">Recepción</label>
                                    </div>
                                </div>
                                <div class="col-md-3 form-group">
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="perm_medico" name="perm_medico">Médico</label>
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="perm_financiero" name="perm_financiero">Financiero</label>
                                    </div>
                                </div>

                                <div class="col-md-2 form-group">
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="perm_citas" name="perm_citas">Citas</label>
                                    </div>
                                </div>
                            </div>
                            <span class="btn btn-primary" id="registrar">Crear nuevo usuario</span>
                            <div class="col-md-8"></div>
                        </div>
                    </form>
                    <!-- formulario -->

                    <!--TITULO CONTENIDO MODIFICAR-->
                    <br>
                    <div class="row">
                        <div class="col-md-12" align="left">
                            <H3 id="actualizarUsuario" style="cursor:pointer">
                                <span class="glyphicon glyphicon-refresh"></span> 
                                Modificar Usuario
                            </H3>  
                        </div> 
                    </div>
                    <!--TITULO CONTENIDO MODIFICAR-->

                    <!--INICIO CONTENIDO MODIFICAR-->
                    <div id="sectionActUsr" class="row" style="max-width: 100%;display: none">
                        <div class="col-md-12">
                        <div class="input-group">
                                <input type="text" class="search-query form-control" placeholder="Buscar usuario..." id="searcUsuario" name="searcUsuario" autofocus/>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" id="busquedaU" onclick="getUserSearch()">
                                        <span class=" glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                            <hr>
                            <table class="table table-bordered table-responsive">
                                <thead>
                                    <th>Usuario</th>
                                    <th>Número de usuario</th>
                                    <th>Incorporacoón</th>
                                    <th>Tipo de usuario</th>
                                    <th></th>
                                </thead>
                                <tbody id="listUsuarios"></tbody>
                            </table>
                        </div>
                    </div>  
                    <!--FIN CONTENIDO MODIFICAR-->

                </div> 
            </div>
        </div>
    </div>
    
    <!--MODAL MODIFICAR USUARIOS-->
        <div id="modal-editUser" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Editar Usuario</h4>
                    </div>
                    <div class="modal-body">
                    <form id="modifyUser">
                      <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <label>
                                Apellido nombre
                                <input type="text" class="form-control" name="e-nombre" id="e-nombre">
                            </label>
                        </div>
                         <div class="col-md-6 col-xs-12">
                            <label>
                                Apellido paterno
                                <input type="text" class="form-control" name="e-paterno" id="e-paterno">
                            </label>
                        </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6 col-xs-12">
                            <label>
                                Apellido materno
                                <input type="text" class="form-control" name="e-materno" id="e-materno">
                            </label>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <label>
                                Número de usuario
                                <input type="text" class="form-control" name="e-numero" id="e-numero">
                            </label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <label>
                                Nueva contraseña
                                <input type="password" class="form-control" name="e-contrasena" id="e-contrasena" placeholder="Nueva contraseña">
                            </label>
                        </div> 
                        <div class="col-md-6 col-xs-12">
                            <label>
                                Repetir contraseña
                                <input type="password" class="form-control" name="e-ncontrasena" id="e-ncontrasena" placeholder="Ingresar de nuevo">
                            </label>
                        </div> 
                      </div>
                      <div class="row">
                          <div class="col-md-6 col-xs-12">
                            <label>
                                Tipo de usuario
                                <select class="form-control" name="e-tipousuario" id="e-tipousuario">
                                    <?php fillSelect("tipo_usuarios","id_tipo_usuario","nombre_tipo_usuario"); ?>
                                </select>
                            </label>
                          </div>
                          <div class="col-md-6 col-xs-12">
                            Permisos
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <label>
                                        <input type="checkbox" id="e-perm_farmacia" name="e-perm_farmacia">
                                        &nbsp;Farmacia
                                    </label>
                                    <label>
                                        <input type="checkbox" id="e-perm_recepcion" name="pe-erm_recepcion">
                                        &nbsp;Recepción
                                    </label>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label>
                                        <input type="checkbox" id="e-perm_medico" name="e-perm_medico">
                                        &nbsp;Médico
                                    </label>
                                    <label>
                                        <input type="checkbox" id="e-perm_financiero" name="e-perm_financiero">
                                        &nbsp;Financiero
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <label>
                                        <input type="checkbox" id="e-perm_citas" name="e-perm_citas">
                                        &nbsp;Citas
                                    </label>
                                </div>
                            </div>
                          </div>
                      </div>
                    </div>
                    </form>
                    <div class="modal-footer" id="editModifyUser">
                    </div>
                </div>
            </div>
        </div>
        
        
    <script type="text/javascript" src="<?php echo app_url(); ?>js/usuarios.js"></script>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>