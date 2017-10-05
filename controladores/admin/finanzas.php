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
                    <h3 style="display:inline; color:#337ab7;">Financiero - Capturar Entradas y Salidas de Dinero </h3>
                    <span class=" glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title=""></span>
                    <div id="error"></div>
                    <hr>
                    <br>
                    
                    <ul class="nav nav-tabs nav-bottom-space">
                        <li class="active"><a data-toggle="tab" href="#entradas">Capturar Entradas de Dinero</a></li>
                        <li><a data-toggle="tab" href="#salidas">Capturar Salidas de Dinero</a></li>
                    </ul>
                
                    <div class="tab-content">
                        <!-- +++++++++  PESTAÑA ENTRADAS DE DINERO  +++++++++ -->
                        <div id="entradas" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-xs-6 col-xs-offset-3" align="center">
                                    <form class="form-inline form-top-space">
                                        
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="pwd">Fecha:</label>
                                            </div>
                                            <div class="col-xs-8">
                                                <div class="input-group">
                                                    <input type="text" class="search-query form-control" id="fecha" name="fecha" placeholder="aaaa / mm / dd" required="">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary" type="button">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="pwd">Concepto:</label>
                                            </div>
                                            <div class="col-xs-8">
                                                <input type="password" class="form-control input-sp-width" id="pwd">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="pwd">Cantidad:</label>
                                            </div>
                                            <div class="col-xs-8">
                                                <input type="password" class="form-control input-sp-width" id="pwd">
                                            </div>
                                        </div>
                                        <br>

                                        <button type="submit" class="btn btn-primary btn-sp-submit">Capturar Entrada</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- +++++++++  PESTAÑA SALIDAS DE DINERO  +++++++++ -->
                        <div id="salidas" class="tab-pane fade"> 
                            <div class="row">
                                <div class="col-xs-6 col-xs-offset-3" align="center">
                                    <form class="form-inline form-top-space">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="pwd">Fecha:</label>
                                            </div>
                                            <div class="col-xs-8">
                                                <div class="input-group">
                                                    <input type="text" class="search-query form-control" id="fecha" name="fecha" placeholder="aaaa / mm / dd" required="">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary" type="button">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="pwd">Concepto:</label>
                                            </div>
                                            <div class="col-xs-8">
                                                <input type="password" class="form-control input-sp-width" id="pwd">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label for="pwd">Cantidad:</label>
                                            </div>
                                            <div class="col-xs-8">
                                                <input type="password" class="form-control input-sp-width" id="pwd">
                                            </div>
                                        </div>
                                        <br>

                                        <button type="submit" class="btn btn-primary btn-sp-submit">Capturar Salida</button>
                                    </form>
                                </div>
                            </div>          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>