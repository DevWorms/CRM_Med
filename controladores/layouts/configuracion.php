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
                        <h2 style="display:inline; color:#337ab7;">Configuración </h2>
                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Configura tu Clave y Nombre de Usuario, así como tu contraseña."></span>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-2 col-md-offset-2">
                                <p class="form-title">Usuario</p>
                            </div>

                            <div class="col-md-7" style="margin-top: 10px;">
                                <div class="row config-info">
                                    <div class="col-xs-4">
                                        <b>Nombre de Usuario:</b>
                                    </div>
                                    <div class="col-xs-4">
                                        <p>Juan Pérez</p>
                                    </div>
                                </div>
                                <div class="row config-info">
                                    <div class="col-xs-4">
                                        <b>Clave de Usuario:</b>
                                    </div>
                                    <div class="col-xs-4">
                                        <p>0999099</p>
                                    </div>
                                </div> 
                                <div class="row boton-cambiar">
                                    <div class="col-md-4">
                                        <button class="btn btn-sm btn-danger btn-block" data-toggle="modal" data-target="#updateUser">Cambiar</button>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-md-2 col-md-offset-2">
                                <p class="form-title">Contraseña</p>
                            </div>

                            <div class="col-md-7" style="margin-top: 10px;">
                                <div class="row config-info">
                                    <div class="col-xs-4">
                                        <b>*****</b>
                                    </div>
                                </div> 
                                <div class="row boton-cambiar">
                                    <div class="col-md-4">
                                        <button class="btn btn-sm btn-danger btn-block" data-toggle="modal" data-target="#updatePassModal">Cambiar</button>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>          
                </div>
            </div>

            <div id="updateUser" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-body" style="background:#EFEFEF !important;" align="center">
                            <p class="modal-title">Usuario</p>
                            
                            <p class="modal-subtitle">Introduce tu nuevo nombre y clave de Usuario</p>
                            
                            <form class="space25px">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-offset-1 col-xs-10">
                                            <input type="text" placeholder="Nombre de Usuario" class="form-control" id="user_name" name="user_name" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group space25px">
                                    <div class="row">
                                        <div class="col-xs-offset-1 col-xs-10">
                                            <input type="text" placeholder="Clave de Usuario" class="form-control" id="user_id" name="user_id" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group space25px" align="center">
                                    <div class="row">
                                        <div class="col-xs-offset-4 col-xs-4">
                                            <button type="submit" class="btn btn-default btn-block boton-rojo"  name="enviar" id="enviar">Cambiar contraseña</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="updatePassModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-body" style="background:#EFEFEF !important;" align="center">
                            <p class="modal-title">Cambio de Contraseña</p>

                            <p class="modal-subtitle">Introduce dos veces tu contraseña nueva para confirmar, los campos debajo deben coincidir para poder continuar.</p>
                            
                            <form class="space25px">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-offset-1 col-xs-10">
                                            <input type="password" placeholder="Nueva contraseña" class="form-control" id="pwd" name="pwd" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group space25px">
                                    <div class="row">
                                        <div class="col-xs-offset-1 col-xs-10">
                                            <input type="password" placeholder="Confirmar contraseña" class="form-control" id="pwd_confirm" name="pwd_confirm" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group space25px" align="center">
                                    <div class="row">
                                        <div class="col-xs-offset-4 col-xs-4">
                                            <button type="submit" class="btn btn-default btn-block boton-rojo"  name="enviar" id="enviar">Cambiar contraseña</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
 
    <script type="text/javascript" src="<?php echo app_url(); ?>js/recepcion.js"></script>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>