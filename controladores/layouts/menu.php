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
            echo	'<a href="' . app_url() . 'citas_programar" class="list-group-item "><span class="glyphicon glyphicon-edit"></span>&nbsp Recepción - Programar Citas</a>';
        }
        ?>
        <!--	Permisos de Recepción	-->
        <?php
        if ($perm_recepcion == 1)	{
            echo	'<a href="' . app_url() . 'citas" class="list-group-item "><span class="glyphicon glyphicon-edit"></span>&nbsp Recepción - Programar Citas</a>';
            echo	'<a href="' . app_url() . 'control" class="list-group-item "><span class="glyphicon glyphicon-user"></span>&nbsp Recepción - Control Pacientes</a>';
            echo	'<a href="' . app_url() . 'calendario" class="list-group-item "><span class="glyphicon glyphicon-calendar"></span>&nbsp Recepción - Calendario</a>';
            echo    '<a href="'. app_url() .'pagos" class="list-group-item"><span class="glyphicon glyphicon-usd"></span>&nbsp Recepción - Pagos</a>';
        }
        ?>
        <!--	Permisos de Farmacia	-->
        <?php
        if ($perm_farmacia == 1)	{
            echo    '<a href="'. app_url() .'catalogo" class="list-group-item"><span class="glyphicon glyphicon-plus"></span>&nbsp Farmacia - Añadir Productos</a>';
            echo	'<a href="'. app_url() .'orden_compra" class="list-group-item"><span class="glyphicon glyphicon-list-alt"></span>&nbsp Farmacia - Ordenes de Compra</a>';
            echo    '<a href="'. app_url() .'registrar_factura" class="list-group-item"><span class="glyphicon glyphicon-save-file"></span>&nbsp Farmacia - Registrar Factura</a>';
            echo    '<a href="'. app_url() .'salida_productos" class="list-group-item"><span class="glyphicon glyphicon-tag"></span>&nbsp Farmacia - Salida Productos</a>';
            echo    '<a href="'. app_url() .'rep_salida_productos" class="list-group-item"><span class="glyphicon glyphicon-file"></span>&nbsp Farmacia - Reporte Salida Productos</a>';
        }
        ?>
        <!--    Permisos de Médico   -->
        <?php
        if ($perm_medico == 1) {
            echo    '<a href="'. app_url() .'recibir_paciente" class="list-group-item"><span class="glyphicon glyphicon-time"></span>&nbsp Médico - Pacientes en Espera <span class="label label-danger counting" id="counterEnEspera">0</span></a>';
            echo    '<a href="'. app_url() .'mis_pacientes" class="list-group-item"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp Médico - Mis Pacientes</a>';
        }
        ?>
        <!--    Permisos de Administrador   -->
        <?php
        if ($perm_administrador == 1) {
            echo    '<a href="'. app_url() .'usuarios" class="list-group-item"><span class="glyphicon glyphicon-upload"></span>&nbsp Administrador - Nuevos Usuarios</a>';
            echo    '<a href="'. app_url() .'reporte_citas" class="list-group-item"><span class="glyphicon glyphicon-tasks"></span>&nbsp Administrador - Reporte Citas</a>';
            echo    '<a href="'. app_url() .'reporte_citas_usuarios" class="list-group-item"><span class="glyphicon glyphicon-th-list"></span>&nbsp Administrador - Reporte Citas Usuarios</a>';
        }
        ?>
<hr>
        <a href="<?php echo app_url(); ?>cerrar" class="list-group-item"><span class="glyphicon glyphicon-log-out"></span>&nbsp Cerrar Sesión</a>
    </div>
</div>