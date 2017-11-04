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

                        <h2 style="display:inline;" class="title_header">Administrador - Reporte de Desempeño de Citas</h2>
                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Revisa el reporte de desempeño de los colaboradores con perfil de citas."></span>
                                <div class="row container-fluid">                                

                            <hr>
                            <h3 align="center">Se muestra información de los últimos 30 días</h3>


                            <div class="col-md-3" align="center">
                                <button type="button" class="btn btn-primary" onclick="reporteCitasUsuariosDia(7)">
                                    Ver 7 días
                                </button>
                            </div>

                            <div class="col-md-3" align="center">
                                <button type="button" class="btn btn-primary" onclick="reporteCitasUsuariosDia(15)">
                                    Ver 15 días
                                </button>
                            </div>

                            <div class="col-md-3" align="center">
                                <button type="button" class="btn btn-primary" onclick="reporteCitasUsuariosDia(30)">
                                    ver 30 días
                                </button>
                            </div>
                            <div class="col-md-3" align="center">
                                <button type="button" class="btn btn-primary" onclick="reporteCitasUsuariosDia(45)">
                                    Ver 45 días
                                </button>
                            </div>

                            <br><br><br>
                            <div class="input-group">
                                <input type="text" class="search-query form-control" placeholder="Buscar usuario..." id="searchRepUsuario" name="searchRepUsuario" autofocus/>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" onclick="reporteCitasUsuariosBySearch()">
                                        <span class=" glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>

                            <br>
                                <div class="table-responsive">
                                  <table class="table table-bordered">
                                      <thead>
                                        <th>
                                            Usuario
                                        </th>
                                        <th>
                                            Citas de Primera vez
                                        </th>
                                        <th>
                                            Citas de Valoración
                                        </th>
                                        <th>
                                            Citas de Revisión
                                        </th> 
                                        <th>
                                            Citas de Tratamiento
                                        </th>
                                      </thead>
                                    <tbody id="tblReporteCitasUsr">
                                    </tbody>
                                  </table>
                                </div>
                
                    </div>      
                </div>          
            </div>
    <script src="<?php echo app_url(); ?>js/reportesUsuario.js"></script>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>