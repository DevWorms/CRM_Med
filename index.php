<?php

include 'App/route.php';

$route = new Route();

	//	RUTAS DE ADMINISTRADOR
	$route->add('/caja', 'controladores/admin/caja.php');
	$route->add('/modificar_usuarios', 'controladores/admin/modificar_usuarios.php');
	$route->add('/reporte_citas_usuarios', 'controladores/admin/reporte_cita_usuarios.php');
	$route->add('/reporte_citas', 'controladores/admin/reportes.php');
	$route->add('/usuarios', 'controladores/admin/usuarios.php');

	//	RUTAS DE CALL CENTER
    $route->add('/citas_programar', 'controladores/callcenter/callcenter.php');
    $route->add('/directorio_center', 'controladores/callcenter/directorio.php');

	//	RUTAS DE FARMACIA
	$route->add('/registrar_factura', 'controladores/farmacia/facturas.php');
	$route->add('/inventario', 'controladores/farmacia/inventarios.php');
	$route->add('/agregar_productos', 'controladores/farmacia/nuevos-productos.php');
	$route->add('/orden_compra', 'controladores/farmacia/ordenes.php');
	$route->add('/rep_salida_productos', 'controladores/farmacia/reporte-salidas.php');
	$route->add('/salida_productos', 'controladores/farmacia/salida-productos.php');

	//	RUTAS DE FINANCIERO
	$route->add('/confirmar', 'controladores/financiero/confirmar-pagos.php');
  	$route->add('/finanzas-caja', 'controladores/financiero/finanzas-caja.php');
  	$route->add('/finanzas', 'controladores/financiero/finanzas.php');
  	$route->add('/pagos-cliente', 'controladores/financiero/pagos-cliente.php');
  	$route->add('/talon_nuevo', 'controladores/financiero/talon-nuevo.php');
  	$route->add('/talon_viejo', 'controladores/financiero/talon-viejo.php');
  	$route->add('/talones', 'controladores/financiero/talones-pago.php');

	//	RUTAS DE MÉDICO ADMINISTRADOR


	//	RUTAS DE MÉDICO
	$route->add('/expediente_folio', 'controladores/medico/expediente_paciente.php');
	$route->add('/mis_pacientes', 'controladores/medico/mis_pacientes.php');
	$route->add('/quirofano', 'controladores/medico/quirofano.php');
	$route->add('/recibir_paciente', 'controladores/medico/recibir_paciente.php');

	//	RUTAS DE RECEPCIÓN
	$route->add('/calendario', 'controladores/recepcion/calendario.php');
	$route->add('/control', 'controladores/recepcion/control.php');
	$route->add('/leads', 'controladores/recepcion/leads.php');
	$route->add('/paciente', 'controladores/recepcion/paciente.php');
	$route->add('/pagos', 'controladores/recepcion/pagos.php');
	$route->add('/primera_cita', 'controladores/recepcion/primera.php');
	$route->add('/citas', 'controladores/recepcion/recepcion.php');
	$route->add('/registro', 'controladores/recepcion/registro.php');
	

	// 	---------------------	//

	//	OTRAS RUTAS
	$route->add('/', 'controladores/index.php');
	$route->add('/404', 'controladores/layouts/404.php');
	$route->add('/cerrar', 'controladores/sesion/cerrar_sesion.php');
	$route->add('/configuracion', 'controladores/layouts/configuracion.php');

$route->submit();