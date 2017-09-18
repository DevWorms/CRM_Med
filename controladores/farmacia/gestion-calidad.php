    <?php
        include dirname(__FILE__) . '/../layouts/header.php';
    ?>

    <div class="container">
        <?php include dirname(__FILE__) . "/../layouts/navbar.php"; ?>
    </div>
    
    <!-- Page Content -->
    <div class="container">
        <div class="row">

           <div class="col-md-3">
                <p class="lead">Farmacia</p>
                <div class="list-group">
                    <a href="ordenes.php" class="list-group-item"><span class="glyphicon glyphicon-list-alt"></span>&nbsp &nbsp Facturas / Inventarios</a>
                    
                    <a href="ordenes-compra.php" class="list-group-item disabled"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp &nbsp Ordenes de Compra</a>

                    <a href="pedidos.php" class="list-group-item disabled"><span class="glyphicon glyphicon-edit"></span>&nbsp &nbsp Ordenes de Pedido</a>

                    <a href="catalogos.php" class="list-group-item"><span class="glyphicon glyphicon-th"></span>&nbsp &nbsp Catálogos</a>
                    
                    <a href="gestion-calidad.php" class="list-group-item disabled active"><span class="glyphicon glyphicon-cog"></span>&nbsp &nbsp Gestión de Calidad</a>

                    <a href="dir-telefonico.php" class="list-group-item"><span class="glyphicon glyphicon-phone-alt"></span>&nbsp &nbsp Directorios Telefónico</a>

                    <a href="reportes.php" class="list-group-item"><span class="glyphicon glyphicon-stats"></span>&nbsp &nbsp Reportes</a>
                 </div>
            </div>

            <div class="col-md-9">
                <div class="thumbnail">
                    <div class="caption-full">
						<h4><a href="#">Gestión de Calidad</a></h4> 
						<div class="row">
							<div class="col-md-12" align="center">
								<div class="alert alert-danger" role="alert">
								  	<h2><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>&nbsp&nbspConstruyendo ...</h2>
								</div>
							</div>
						</div>
                    </div>		
                </div>	        
			</div>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>