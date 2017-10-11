<?php
require_once dirname(__FILE__) . '/../datos/ConexionBD.php';
if (isset($_POST['id_usuario']) && isset($_POST['contrasena'])) {
    $id_usuario = $_POST['id_usuario'];
    $contrasena = hash('sha256', $_POST['contrasena']);
        $pdo = ConexionBD::obtenerInstancia()->obtenerBD();
        $consultaSesion = "SELECT * FROM usuarios INNER JOIN accesos ON usuarios.id = accesos.id_usuario WHERE numeroUsuario = ? AND password = ?";
        $sentenciaSesion = $pdo->prepare($consultaSesion);
        $sentenciaSesion->bindParam(1, $id_usuario);
        $sentenciaSesion->bindParam(2, $contrasena);
        $sentenciaSesion->execute();
        $resultado = $sentenciaSesion->fetchAll();
        $res = [
            'estado' => 0,
            'mensaje' => ''
        ];
        // Valida el inicio de sesión normal
        if (count($resultado) == 1) {
            $resultado = $resultado[0];
            if ($resultado['citas'] == 1 && $resultado['recepcion'] == 0) { //citas
                $res['url'] = "citas_programar";
            } elseif ($resultado['citas'] == 0 && $resultado['recepcion'] == 0 && $resultado['farmacia'] == 1) { // Si es farmacia
                $res['url'] = "catalogo";
            } elseif ( $resultado['citas'] == 0 && $resultado['recepcion'] == 0 && $resultado['farmacia'] == 0 
                && $resultado['medico'] == 1 ) { // Si es medico
                $res['url'] = "mis_pacientes";
            } elseif ($resultado['citas'] == 1 && $resultado['recepcion'] == 1 && $resultado['farmacia'] == 1 
            && $resultado['medico'] == 1 ) { // Admin
                $res['url'] = "citas";
            } else { // Si es medico
                $res['url'] = "citas";
            }

            session_start();
            $_SESSION["Id"] = $resultado['id'];
            $_SESSION["Nombre"] = $resultado['nombre'] . ' ' . $resultado['apPaterno'] . ' ' . $resultado['apMaterno'];
            $_SESSION["name"] =$resultado['nombre'] ;
            $_SESSION["paterno"] =$resultado['apPaterno'] ;
            $_SESSION["materno"] =$resultado['apMaterno'];
            $_SESSION["token"] = hash('sha256', $resultado['id']);
            $_SESSION["url"] = $res['url'];
            $_SESSION["numeroUsuario"] = $resultado['numeroUsuario'];
            $_SESSION["accesos_citas"] = $resultado["citas"];
            $_SESSION["accesos_farmacia"] = $resultado["farmacia"];
            $_SESSION["accesos_financiero"] = $resultado["financiero"];
            $_SESSION["accesos_medico"] = $resultado["medico"];
            $_SESSION["accesos_recepcion"] = $resultado["recepcion"];
            $_SESSION["accesos_admin"] = $resultado["admin"];
            session_write_close();
            
            $res['estado'] = 1;
            $res['mensaje'] = "Bienvenido " . $resultado['nombre'] . ' ' . $resultado['apPaterno'];
        } else {
            $res['mensaje'] = "Usuario o contraseña incorrectos";
        }
        // Devuelve json como respuesta
        echo json_encode($res);
} else {
    // Si se intenta acceder sin parametros redirecciona al inicio
    header("Location: " . app_url());
}
?>