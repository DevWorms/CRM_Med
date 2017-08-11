    <?php
        include dirname(__FILE__) . '/../layouts/header.php';
    ?>
    <!-- Page Content -->
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <?php include dirname(__FILE__) . "/../layouts/menu.php"; ?>

            <div class="col-md-9">
                <div class="thumbnail">
                    <div class="caption-full">
						<form>
                        	<h4><a href="#">Directorio Telefónico</a></h4> 
	                        	<!-- Search -->
	                        	<div class="form-group row">
							        <div class="col-md-12">
						                <div class="input-group stylish-input-group input-append">
						                    <input type="text" class="form-control"  placeholder="Buscar contacto ..." >
						                    <span class="input-group-addon">
						                        <button type="submit">
						                            <span class="glyphicon glyphicon-search"></span>
						                        </button>  
						                    </span>
						                </div>
							        </div>
								</div>  
							    <!-- /Search -->

								<!-- Contactos -->
								<table class="table table-bordered table-striped">
		                                <thead>
		                                  <tr>
		                                    <th>Número Contacto</th>
		                                    <th>Nombre</th>
		                                    <th>Número Telefónico</th>
		                                  </tr>
		                                </thead>
		                                <tbody>
		                                  <tr>
		                                    <td>1</td>
		                                    <td>Analilia Domínguez</td>
		                                    <td>55-12-34-23-19</td>
		                                  </tr>
		                                  <tr>
		                                    <td>2</td>
		                                    <td>Guzmán Arenas</td>
		                                    <td>55-10-90-34-71</td>
		                                  </tr>
		                                  <tr>
		                                    <td>3</td>
		                                    <td>Antonia Limón</td>
		                                    <td>55-88-48-72-32</td>
		                                  </tr>
		                                    <tr>
		                                    <td>4</td>
		                                    <td>Zoe Perez</td>
		                                    <td>55-12-15-90-10</td>
		                                  </tr>
		                                    <tr>
		                                    <td>5</td>
		                                    <td>Lilia Martínez</td>
		                                    <td>55-10-89-45-92</td>
		                                  </tr>
		                                </tbody>
		                        </table>	

		                        <div align="center" clas="thumbnail">
		                            <ul class="pagination" >
		                                <li><a href="#">&laquo;</a></li>
		                                <li class="active"><a href="#">1</a></li>
		                                <li><a href="#">2</a></li>
		                                <li><a href="#">3</a></li>
		                                <li><a href="#">&raquo;</a></li>
		                            </ul>
		                        </div>
								<!-- /Contactos -->
						</form>
                    </div>		
                </div>	        
			</div>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>