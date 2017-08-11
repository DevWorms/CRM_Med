<?php
require_once dirname(__FILE__) . '/../../datos/ConexionBD.php';

//++++++++++++++++++++++++++++++++++++++++++       MASTER      +++++++++++++++++++++++++++++++++++++++++++++

function Mostrar_Permisos($id_usuario) {
    $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

    $operacion = "SELECT * FROM accesos WHERE id_usuario = ?";
    $sentencia = $pdo->prepare($operacion);
    $sentencia->bindParam(1,$id_usuario);
    $sentencia->execute();
    $resultado = $sentencia->fetch();

    $permiso['perm_farmacia'] = $resultado["farmacia"];
    $permiso['perm_recepcion'] = $resultado["recepcion"];
    $permiso['perm_medico'] = $resultado["medico"];
    $permiso['perm_financiero'] = $resultado["financiero"];
    $permiso['perm_citas'] = $resultado["citas"];

    return $permiso;
}
?>