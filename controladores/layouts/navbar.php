<?php

//	OBTENER PERMISOS POR MEDIO DEL ID DE SESIÓN
$perm_farmacia = $_SESSION['accesos_farmacia'];
$perm_recepcion = $_SESSION['accesos_recepcion'];
$perm_medico = $_SESSION['accesos_medico'];
$perm_administrador = $_SESSION['perm_financiero'];
$perm_financiero = $_SESSION['accesos_financiero'];
$perm_citas = $_SESSION['accesos_citas'];
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
      integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

                <!-- Estilos para el navbar -->
                <style>
                    /* nombre/logo */
                    .navbar-brand {
                        top: 10px;
                        left: 30px;
                    }

                    /* botón menú */
                    .dropdown {
                        top: 20px;
                        left: 50px;
                    }

                    .dropdown button {
                        width: 70px;
                    }

                    .dropdown-submenu {
                        position: relative;
                    }

                    }
                </style>
                <!-- Script para controlar el botón menú -->
                <script>
                    $(document).ready(function () {
                        $('.dropdown-submenu a.test').on("click", function (e) {
                            $(this).next('ul').toggle();
                            e.stopPropagation();
                            e.preventDefault();
                        });
                    });
                </script>
            </ul>
        </div>
    </div>
</nav>