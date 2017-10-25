<?php

include 'App/route.php';

$route = new Route();

	
	//	RUTAS DE CALL CENTER
    $route->add('/citas_programar', 'controladores/callcenter/callcenter.php');
    $route->add('/directorio_center', 'controladores/callcenter/directorio.php');

	//	RUTAS DE RECEPCIÓN
	$route->add('/citas', 'controladores/recepcion/recepcion.php');
	$route->add('/registro', 'controladores/recepcion/registro.php');
	$route->add('/calendario', 'controladores/recepcion/calendario.php');
	$route->add('/admin', 'controladores/recepcion/pagos.php');
	$route->add('/primera_cita', 'controladores/recepcion/primera.php');
	$route->add('/pagos', 'controladores/recepcion/pagos.php');
	$route->add('/paciente', 'controladores/recepcion/paciente.php');
	$route->add('/control', 'controladores/recepcion/control.php');
	$route->add('/leads', 'controladores/recepcion/leads.php');

	//	RUTAS DE FARMACIA
	$route->add('/orden_compra', 'controladores/farmacia/ordenes.php');
	$route->add('/catalogo', 'controladores/farmacia/catalogo-productos.php');
	$route->add('/registrar_factura', 'controladores/farmacia/facturas.php');
	$route->add('/salida_productos', 'controladores/farmacia/salida-productos.php');
	$route->add('/rep_salida_productos', 'controladores/farmacia/reporte-salidas.php');

	//	RUTAS DE ADMINISTRADOR
	$route->add('/usuarios', 'controladores/admin/usuarios.php');
	$route->add('/reporte_citas', 'controladores/admin/reportes.php');
	$route->add('/reporte_citas_usuarios', 'controladores/admin/reporte_cita_usuarios.php');
	$route->add('/caja', 'controladores/admin/caja.php');

	$route->add('/confirmar', 'controladores/admin/confirmar-pagos.php');
  	$route->add('/talones', 'controladores/admin/talones-pago.php');
  	$route->add('/talon_nuevo', 'controladores/admin/talon-nuevo.php');
  	$route->add('/talon_viejo', 'controladores/admin/talon-viejo.php');
  	$route->add('/finanzas', 'controladores/admin/finanzas.php');
  	$route->add('/finanzas-caja', 'controladores/admin/finanzas-caja.php');
  	$route->add('/pagos-cliente', 'controladores/admin/pagos-cliente.php');

	//	RUTAS DE MÉDICO
	$route->add('/recibir_paciente', 'controladores/medico/recibir_paciente.php');
	$route->add('/mis_pacientes', 'controladores/medico/mis_pacientes.php');
	$route->add('/expediente_folio', 'controladores/medico/expediente_paciente.php');
	$route->add('/quirofano', 'controladores/medico/quirofano.php');

	//	OTRAS RUTAS
	$route->add('/', 'controladores/index.php');
	$route->add('/404', 'controladores/layouts/404.php');
	$route->add('/cerrar', 'controladores/sesion/cerrar_sesion.php');
	$route->add('/configuracion', 'controladores/layouts/configuracion.php');


	//	+++++++++++++++++	AÚN EN ESPERA...	++++++++++++++++++++++++
	$route->add('/pedidos', 'controladores/admin/pedidos-farmacia.php');
	$route->add('/directorio', 'controladores/farmacia/dir-telefonico.php');

$route->submit();