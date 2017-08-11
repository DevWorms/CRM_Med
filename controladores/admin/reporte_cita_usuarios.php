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

                        <h2 style="display:inline; color:#337ab7;">Administrador - Reporte Citas Usuarios </h2>
                        <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Revisa el número de citas citas generadas por el equipo de recepción y de CallCenter."></span>
                            <br>
                            <br>
                            <br>
                                <div class="row container-fluid">
                                    <div class="col-md-1"></div>
                                        <div class="panel panel-primary col-xs-11 col-md-5">
                                          <div class="panel-heading">Usuario que generó más citas de primera vez</div>
                                          <div class="panel-body" id="masCitasPv"></div>
                                        </div>

                                        <div class="panel panel-primary  col-xs-11 col-md-5">
                                          <div class="panel-heading">Usuario que generó menos citas de primera vez</div>
                                          <div class="panel-body" id="menosCitasPv"></div>
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                    <div class="row container-fluid ">
                                        <div class="col-md-1"></div>
                                        <div class="panel panel-primary col-xs-11 col-md-5">
                                          <div class="panel-heading">Usuario que generó más citas en total</div>
                                          <div class="panel-body" id="masCitasTotal"></div>
                                        </div>

                                        <div class="panel panel-primary col-xs-11 col-md-5">
                                          <div class="panel-heading">Usuario que generó menos citas en total</div>
                                          <div class="panel-body" id="menosCitasTotal"></div>
                                        </div>
                                        <div class="col-md-1"></div>
                              
                            </div>
                                

                                <div class="input-group">
                                <input type="text" class="search-query form-control" placeholder="Buscar usuario..." id="searchRepUsuario" name="searchRepUsuario" autofocus/>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" onclick="reporteCitasUsuariosBySearch()">
                                        <span class=" glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                            <hr>
                                <div class="table-responsive">
                                  <table class="table table-bordered">
                                      <thead>
                                        <th>
                                            Usuario
                                        </th>
                                        <th>
                                            Número
                                        </th>
                                        <th>
                                            #Primera vez
                                        </th>
                                        <th>
                                            #Pre operatorias
                                        </th>
                                        <th>
                                            #Cirugía
                                        </th>
                                        <th>
                                            #Post operatorias
                                        </th>
                                        <th>
                                            #Valoración
                                        </th>
                                        <th>
                                            #Revisión
                                        </th> 
                                        <th>
                                            #Tratamiento
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