    <?php include dirname(__FILE__) . '/../layouts/header.php'; ?>
    
    <div class="container">
        <?php include dirname(__FILE__) . "/../layouts/navbar.php"; ?>
    </div>
    
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <?php include dirname(__FILE__) . '/../layouts/menu.php'; ?>
            <div class="col-md-9">
                <div class="thumbnail">
                    <div class="caption-full">
						<h4><a href="#">Pagos</a></h4> 
						
                        <div class="row">
							<div class="col-md-12" align="center">
								<div align="center">
                                    <a class="btn btn-primary active" href="pagos-financiamiento.php" role="button">Financiamiento</a>
                                    <a class="btn btn-primary" href="pagos.php" role="button">Pagos</a>
                                </div>
							</div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <div class="col-md-12" align="center">
                                <div id="custom-search-input">
                                    <div class="input-group col-md-9" >
                                        <input type="text" class="search-query form-control" placeholder="Buscar ..." />
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button">
                                                <span class=" glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>


                        <div class="form-group row" align="center">
                            <div class="col-md-6">
                                  <h4>Antes</h4>
                                  <img src="<?php echo app_url(); ?>img/user-male.png" class="img-thumbnail" alt="Antes" width="200" height="200">
                            </div>
                            <div class="col-md-6">
                                  <h4>Despues</h4>
                                  <img src="<?php echo app_url(); ?>img/user-male.png" class="img-thumbnail" alt="Despues" width="200" height="200">
                            </div>
                        </div>
                        

                        <div class="form-group row" align="center">
                            <div class="col-md-6">
                                  <button type="button" class="btn btn-default btn-sm">Subir foto</button>
                            </div>
                            <div class="col-md-6">
                                  <button type="button" class="btn btn-default btn-sm">Subir foto</button>
                            </div>
                        </div>

                        <div class="form-group row space">
                            <div class="col-md-12">
                                <div class="jumbotron">
                                    <form>
                                        <div class="form-group row" align="right">
                                            <div class="col-md-offset-6">
                                            <fieldset class="form-inline">
                                                <label for="">Fecha de Incorporación&nbsp&nbsp</label>
                                                <div class="input-group">
                                                <input type="text" class="search-query form-control" placeholder="dd / mm / aaaa" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-primary" type="button">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </fieldset>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-9">
                                                <label for="">Tipo de Pago&nbsp&nbsp</label>
                                                <select class="selectpicker" data-width="75%">
                                                  <option>Efectivo</option>
                                                  <option>Financiamiento</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-9">
                                                <label for="">Bueno por&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                                                <select class="selectpicker" data-width="75%">
                                                  <option>...</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group" align="right">
                                            <button type="submit" class="derecha btn btn-primary">Registrar Pago</button>        
                                        </div>
                                    </form>

                                    <table class="table table-bordered table-hover table-striped" style="background-color:white">
                                            <thead>
                                              <tr>
                                                <th>Tipo de Pago</th>
                                                <th>Monto</th>
                                                <th>Fecha</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                <td align="center">Efectivo</td>
                                                <td align="right">$ 7,000</td>
                                                <td align="right">11/02/2016</td>
                                              </tr>
                                              <tr>
                                                <td align="center">Financiamiento</td>
                                                <td align="right">$ 5,000</td>
                                                <td align="right">12/02/2016</td>
                                              </tr>
                                              <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                              </tr>
                                                <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                              </tr>
                                                <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                              </tr>
                                            </tbody>
                                    </table>    
                                </div>
                            </div>
                        </div> 

                    </div>		
                </div>	        
			</div>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>