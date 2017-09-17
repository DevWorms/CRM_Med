<?php
include dirname(__FILE__) . '/../sesion/sesion.php';
include dirname(__FILE__) . '/../utilidades/funciones/func_fechas.php';
?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">MediLaser CRM</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li class="active">
            <a class="nav-link" href="#">
                        <!-- MOSTRAR NOMBRE DE USUARIO EN APP -->
                        <p style="texl-align:center">
                        <p><?php echo $_SESSION['Nombre']; ?></p>
                        <p><?php ObtenerFechaHoy(); ?></p>
                        </p>
                        <span class="sr-only">(current)</span>
            </a>
        </li>
        <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Configuración</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="#">Cerrar Sesión</a></li>
                </ul>
              </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div><!--/.container-fluid -->
</nav>