<?php include dirname(__FILE__) . '/../layouts/header.php'; ?>

<div class="container">
    <?php include dirname(__FILE__) . "/../layouts/navbar.php"; ?>
</div>
    
<!-- Page Content -->
<div class="container">
    <div class="row">

        <div class="col-md-3">
            <p class="lead">Farmacia</p>
            <div class="list-group">
                <a href="/inventario/add" class="list-group-item"><span class="glyphicon glyphicon-edit"></span>&nbsp; &nbsp;
                    Añadir a Inventario</a>

                <a href="#" class="list-group-item active"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;
                    &nbsp; Pedidos a Farmacia</a>

                <a href="/catalogo" class="list-group-item"><span class="glyphicon glyphicon-th"></span>&nbsp;
                    &nbsp; Catálogos</a>

                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-cog"></span>&nbsp;
                    &nbsp; Gestión de Calidad</a>

                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-phone-alt"></span>&nbsp;
                    &nbsp; Directorios Telefónico</a>

                <a href="/reportes" class="list-group-item"><span class="glyphicon glyphicon-stats"></span>&nbsp;
                    &nbsp; Reportes</a>
            </div>
        </div>


        <div class="col-md-9">
            <div class="thumbnail">
                <div class="caption-full">
                    <form>
                        <h4><a href="#">Pedidos a Farmacia</a></h4>
                        <br>
                        <!-- Primera tabla -->
                        <table class="table table-bordered table-striped" id="pedidos" name="pedidos">
                            <thead>
                            <tr>
                                <th>Enviado</th>
                                <th>Fecha de Pedido</th>
                                <th>Nombre del Solicitante</th>
                                <th>Procedimiento</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div align="center" clas="thumbnail">
                            <ul class="pagination" id="pagination">
                            </ul>
                        </div>

                        <div id="error"></div>

                        <br>
                        <p>Productos Solicitados</p>
                        <!-- Segunda Tabla-->
                        <table class="table table-bordered table-striped" id="productos" name="productos">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Tipo</th>
                                <th>Presentación</th>
                                <th>Gramaje</th>
                                <th>Cantidad</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- /Segunda Tabla-->
                        <div align="right">
                            <button class="btn btn-default" type="submit" name=""><b>Imprimir</b></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="<?php echo app_url(); ?>js/pedidos.js" type="text/javascript"></script>
    <?php include dirname(__FILE__) . '/../layouts/footer.php'; ?>