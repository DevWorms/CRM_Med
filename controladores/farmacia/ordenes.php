    <?php include dirname(__FILE__) . '/../layouts/header.php'; ?>
    
    <div class="container">
        <?php include dirname(__FILE__) . "/../layouts/navbar.php"; ?>
    </div>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>
            <form action="" method="POST" id="create-form">
            <input type="hidden" id="get" name="get" value="create">
            <div class="col-md-9">
                <div class="thumbnail border_content">
                    <div class="caption-full">
                        <h2 style="display:inline;" class="title_header">Farmacia - Ordenes de compra </h2>

                        <span class=" glyphicon glyphicon-question-sign circulo_info" data-toggle="tooltip" data-placement="right" title="Genera una nueva orden de compra para los productos en inventario"></span>

                        <div id="error"></div>

                        <hr>  
                            
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="fecha">Fecha de Requerimiento</label>
                                        <div class="input-group">
                                            <input type="text" class="search-query form-control" id="fecha" name="fecha" placeholder="aaaa / mm / dd" required/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-8">
                                    <fieldset class="form-inline">
                                        <label for="credito">Días de crédito (Opcional)</label>
                                        <input type="number" class="form-control" id="credito" name="credito" placeholder="Días de crédito por los productos solicitados.">
                                    </fieldset>
                                </div>
                            </div>

                            <div class="form-group row">
                            </div>
                    </div>		
                </div>

                <div class="thumbnail">
                    <div class="caption-full">

                            <div class="form-group row space">
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="producto">Producto&nbsp;&nbsp;</label>
                                        <br>
                                        <input type="text" class="form-control"  id="producto" name="producto" placeholder="Nombre Producto">
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="unidades">Capacidad de empaque&nbsp;&nbsp;</label>
                                        <input type="text" class="form-control" id="unidades" name="unidades" placeholder="Capacidad de empaque">
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="gramaje">Gramaje&nbsp;&nbsp;</label>
                                        <br>
                                        <input type="text" class="form-control" id="gramaje" name="gramaje" placeholder="gramos">
                                    </fieldset>
                                </div>
                            </div>

                            <br>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="tipo">Tipo&nbsp;&nbsp;</label>
                                        <br>
                                        <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Consumible, Medicamento">
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <div>
                                            <label for="presentacion">Presentación&nbsp;&nbsp;</label>
                                            <input type="text" class="form-control" id="presentacion" name="presentacion" placeholder="Spray, Tabletas, Soluciones">
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="caja">Caja&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <br>
                                        <input type="text" class="form-control" id="caja" name="caja" placeholder="Caja">
                                    </fieldset>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="fecha2">Fecha de Caducidad</label>
                                        <div class="input-group">
                                            <input type="text" class="search-query form-control" id="fecha2" name="fecha2" placeholder="aaaa / mm / dd" required/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-4">
                                    <fieldset class="form-inline">
                                        <label for="lote">Lote&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="text" class="form-control" id="lote" name="lote">
                                    </fieldset>
                                </div>
                                
                            </div>


                            <div class="form-group row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <fieldset class="form-inline" style="margin-top: 25px">
                                        <button onclick="event.preventDefault(); addProducto();" class="derecha btn btn-primary">Añadir</button>
                                    </fieldset>
                                </div>
                            </div>
                            <hr>
                        <table class="table table-bordered table-striped" id="productos">
                                <thead>
                                  <tr>
                                      <th>Producto</th>
                                      <th>Capacidad de empaque</th>
                                      <th>Gramaje</th>
                                      <th>Tipo</th>
                                      <th>Presentación</th>
                                      <th>Caja</th>
                                      <th>Fecha de caducidad</th>
                                      <th>Lote</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                        </table>
                        
                        <div class="form-group" align="center">
                                <button onclick="event.preventDefault(); createFacture();" class="derecha btn btn-danger">Generar orden de compra</button>
                        </div>
                    </div>
                </div>
			</div>
            </form>
            <script src="<?php echo app_url(); ?>js/facturas.js" type="text/javascript"></script>
            <script src="<?php echo app_url(); ?>js/jsPDF/jspdf.min.js" type="text/javascript"></script>
            <script src="<?php echo app_url(); ?>js/jsPDF/jspdf.plugin.autotable.js" type="text/javascript"></script>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>