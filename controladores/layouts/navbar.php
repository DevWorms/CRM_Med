<?php
include dirname(__FILE__) . '/../sesion/sesion.php';
include dirname(__FILE__) . '/../utilidades/funciones/func_fechas.php';
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand col-md-8" href="#"><h1>MediLaser CRM</h1></a>
        <!-- columna de 8 espacios para el nombre/logo -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ">
                <li class="nav-item active">
                    <a class="nav-link" href="#">
                        <!-- MOSTRAR NOMBRE DE USUARIO EN APP -->
                        <p style="texl-align:center">
                        <h4><?php echo $_SESSION['Nombre']; ?></h4>
                        <h6><?php //ObtenerFechaHoy(); ?></h6>
                        </p>
                        <span class="sr-only">(current)</span></a>
                </li>
                <li>
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                            <h5>Menú</h5>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="#">Cerrar Sesión</a>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="test" tabindex="-1" href="#">Alt. Info <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">Pass</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Correo</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Nombre, Ap Pat, Ap Mat</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Teléfono</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>