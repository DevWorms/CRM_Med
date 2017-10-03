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
      <a class="navbar-brand navbar-brand-custom" href="#"><img class="navbar-logo" src="img/logo1.jpg" alt=""></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li>
            <p class="navbar-fecha"> <?php ObtenerFechaHoy(); ?> </p>
        </li>
        <li class="dropdown">
            <a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-bell-o icono-notificaciones" aria-expanded="true"></i><span class="badge">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-sp" align="center">
              <p>No tienes notificaciones</p>
            </div>   
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo $_SESSION['Nombre']; ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li>
                <?php  echo '<a href="' . app_url() . 'configuracion">'; ?>
                  <i class="fa fa-cog dropdown-icon" aria-hidden="true"></i>Configuración
                </a>
              </li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo app_url(); ?>cerrar"><i class="fa fa-sign-out dropdown-icon"></i>Cerrar Sesión</a></li>
            </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div><!--/.container-fluid -->
</nav>