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
            <div class="thumbnail border_content">
                <div class="caption-full">
                    <h2 style="display:inline;" class="title_header">Administrador - Modificar Usuarios</h2>
                    <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Actualiza la información de los usuarios con acceso al sistema."></span>
                    <hr>
                    <div id="error"></div>

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
                                    <th>Incorporación</th>
                                    <th>Tipo de usuario</th>
                                    <th>Editar</th>
                                </thead>
                                <tbody id="listUsuarios"></tbody>
                            </table>
                        </div>

                    <!--TITULO CONTENIDO MODIFICAR-->
                    <br>
                    <div class="row">
                    </div>
                    <!--TITULO CONTENIDO MODIFICAR-->
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
                                    <option value="5">Call Center</option>
                                    <option value="4">Recepción</option>
                                    <option value="3">Farmacia</option>
                                    <option value="2">Médico</option>
                                    <option value="7">Médico Administrador</option>
                                    <option value="6">Financiero</option>
                                    <option value="1">Administrador</option>
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
                                        <input type="checkbox" id="e-perm_recepcion" name="e-perm_recepcion">
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
                                    <label>
                                        <input type="checkbox" id="e-perm_admin" name="e-perm_admin">
                                        &nbsp;Administrador
                                    </label>
                                    <label>
                                        <input type="checkbox" id="e-perm_med_admin" name="e-perm_med_admin">
                                        &nbsp;Médico Administrador
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