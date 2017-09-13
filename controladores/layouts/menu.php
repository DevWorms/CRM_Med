<?php
include dirname(__FILE__) . '/../sesion/sesion.php';
include dirname(__FILE__) . '/../utilidades/funciones/func_accesos.php';
include dirname(__FILE__) . '/../utilidades/funciones/func_fechas.php';


//	OBTENER PERMISOS POR MEDIO DEL ID DE SESIÓN
$permisos = Mostrar_Permisos($_SESSION['Id']);
$perm_farmacia = $permisos['perm_farmacia'];
$perm_recepcion = $permisos['perm_recepcion'];
$perm_medico = $permisos['perm_medico'];
$perm_administrador = $permisos['perm_financiero'];
$perm_citas = $permisos['perm_citas'];
?>

<div class="col-md-3">

    <!-- MOSTRAR NOMBRE DE USUARIO EN APP -->
    <p>
    <h4><?php echo $_SESSION['Nombre']; ?></h4>
    <h6><?php echo ObtenerFechaHoy(); ?></h6>
    </p>

    <!-- MOSTRAR ACCESOS LATERALES POR PERMISOS DE USUARIO	-->
    <div class="list-group">
        <!--	Permisos de Recepción	-->
        <?php
        if ($perm_citas == 1 && $perm_recepcion == 0)	{
            echo	'<a href="' . app_url() . 'citas_programar" class="list-group-item "><i class="fa fa-pencil-square-o"></i>&nbsp Recepción - Programar Citas</a>';
        }
        ?>
        <!--	Permisos de Recepción	-->
        <?php
        if ($perm_recepcion == 1)	{
            echo	'<a href="' . app_url() . 'citas" class="list-group-item "><i class="fa fa-pencil-square-o"></i></span>&nbsp Recepción - Programar Citas</a>';
            echo	'<a href="' . app_url() . 'control" class="list-group-item "><i class="fa fa-user"></i></span>&nbsp Recepción - Control Pacientes</a>';
            echo	'<a href="' . app_url() . 'calendario" class="list-group-item "><i class="fa fa-calendar"></i>&nbsp Recepción - Calendario</a>';
            echo    '<a href="'. app_url() .'pagos" class="list-group-item"><i class="fa fa-usd"></i>&nbsp Recepción - Pagos</a>';
        }
        ?>
        <!--	Permisos de Farmacia	-->
        <?php
        if ($perm_farmacia == 1)	{
            echo    '<a href="'. app_url() .'catalogo" class="list-group-item"><i class="fa fa-plus"></i>&nbsp Farmacia - Añadir Productos</a>';
            echo	'<a href="'. app_url() .'orden_compra" class="list-group-item"><i class="fa fa-list-alt"></i>&nbsp Farmacia - Ordenes de Compra</a>';
            echo    '<a href="'. app_url() .'registrar_factura" class="list-group-item"><i class="fa fa-clipboard"></i>&nbsp Farmacia - Registrar Factura</a>';
            echo    '<a href="'. app_url() .'salida_productos" class="list-group-item"><i class="fa fa-arrow-right"></i>&nbsp Farmacia - Salida Productos</a>';
            echo    '<a href="'. app_url() .'rep_salida_productos" class="list-group-item"><i class="fa fa-file-text"></i></span>&nbsp Farmacia - Reporte Salida Productos</a>';
        }
        ?>
        <!--    Permisos de Médico   -->
        <?php
        if ($perm_medico == 1) {
            echo    '<a href="'. app_url() .'recibir_paciente" class="list-group-item"><i class="fa fa-clock-o"></i>&nbsp Médico - Pacientes en Espera <span class="label label-danger counting" id="counterEnEspera">0</span></a>';
            echo    '<a href="'. app_url() .'mis_pacientes" class="list-group-item"><i class="fa fa-heartbeat"></i>&nbsp Médico - Mis Pacientes</a>';
        }
        ?>
        <!--    Permisos de Administrador   -->
        <?php
        if ($perm_administrador == 1) {
            echo    '<a href="'. app_url() .'usuarios" class="list-group-item"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp Administrador - Nuevos Usuarios</a>';
            echo    '<a href="'. app_url() .'reporte_citas" class="list-group-item"><i class="fa fa-server"></i>&nbsp Administrador - Reporte Citas</a>';
            echo    '<a href="'. app_url() .'reporte_citas_usuarios" class="list-group-item"><i class="fa fa-th-list"></i>&nbsp Administrador - Reporte Citas Usuarios</a>';
        }
        ?>
<hr>
        <a href="<?php echo app_url(); ?>cerrar" class="list-group-item"><i class="fa fa-sign-out"></i>&nbsp Cerrar Sesión</a>
    </div>
</div>