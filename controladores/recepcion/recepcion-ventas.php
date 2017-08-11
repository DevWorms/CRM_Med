    <?php include dirname(__FILE__) . '/../layouts/header.php'; ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <p class="lead">Administrador</p>
                <div class="list-group">
                    <a href="recepcion.php" class="list-group-item active"><span class="glyphicon glyphicon-user"></span>&nbsp &nbsp Recepcion</a>
                    
                    <a href="../admin/pagos-financiamiento.php" class="list-group-item"><span class="glyphicon glyphicon-usd"></span>&nbsp &nbsp Pagos</a>

                     <a href="../admin/dir-telefonico.php" class="list-group-item"><span class="glyphicon glyphicon-cog"></span>&nbsp &nbsp Gestión de Calidad</a>
                    
                    <a href="../admin/reportes.php" class="list-group-item"><span class="glyphicon glyphicon-phone-alt"></span>&nbsp &nbsp Directorio Telefónico</a>
                 </div>
            </div>

            <div class="col-md-9">
                <div class="thumbnail">
                    <div class="caption-full">
						<h4><a href="#">Recepción</a></h4> 
						
                        <div class="row">
							<div class="col-md-12">
								<div align="center">
                                    <a class="btn btn-primary" href="recepcion.php" role="button">Clientes</a>
                                    <a class="btn btn-primary active" role="recepcion-ventas.php">Ventas</a>
                                </div>
							</div>
                        </div>
                        <br>

                        <div class="form-group row">
                            <div class="col-md-12" align="center">
                                <div id="custom-search-input">
                                    <div class="input-group col-md-9" >
                                        <input type="text" class="search-query form-control" placeholder="Buscar ..." id="paramProd"/>
                                        <span class="input-group-btn" id="buscarProducto">
                                            <button class="btn btn-primary" type="button">
                                                <span class=" glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <table class="table table-bordered table-striped">
                                <thead>
                                  <tr>
                                    <th>Producto</th>
                                    <th>Presentación</th>
                                    <th>Gramaje</th>
                                    <th>Existencia</th>
                                    <th>Fecha Caducidad</th>
                                    <th>Precio</th>
                                    <th>Descuento</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </tbody>
                        </table>
                        
                        <div class="form-group row space">
                            <div class="col-md-6">
                                <fieldset class="form-inline">
                                    <label for="">Total&nbsp;</label>
                                    <input type="text" class="form-control" id="gramaje" placeholder="Total">
                                </fieldset>                                
                            </div>
                        </div>



                        <div class="form-group row space">
                            <div class="col-md-6">
                                <fieldset class="form-inline">
                                    <div align="right">
                                        <label for="">Subtotal&nbsp;</label>
                                        <input type="text" class="form-control" id="unidades" placeholder="Subtotal">
                                    </div> 
                                </fieldset>                                
                            </div>
                            <div class="col-md-6">
                                <fieldset class="form-inline">
                                    <label for="">IVA&nbsp;</label>
                                    <input type="text" class="form-control" id="gramaje" placeholder="I V A">
                                </fieldset>                                
                            </div>
                        </div>

                        <div class="form-group row space" align="right">
                            <div class="col-md-12">
                                <a class="btn btn-success" href="#" role="button">Vender</a>    
                            </div>
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

            <div class="modal fade" tabindex="-1" role="dialog" id="searchModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Agregar Producto</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="productoSel"> Producto: </label>
                                <select name="productoSel" id="productoSel" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <label for="precio"> Precio: </label>
                                <input type="text" name="precio" id="precio" value="0" min="0" disabled class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cantidad"> Cantidad: </label>
                                <input type="number" name="cantidad" id="cantidad" value="0" min="0" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!--MIS Scripts-->
            <script type="text/javascript" src="<?php echo app_url(); ?>js/recepcion.js"></script>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>