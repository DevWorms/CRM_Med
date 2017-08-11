<?php

/**
 * Created by PhpStorm.
 * User: rk521
 * Date: 23.03.17
 * Time: 17:13
 */

include dirname(__FILE__) . '/../controladores/datos/ConexionBD.php';

class CatalogoUsuario {
    private $conn;

    function __construct() {
        $this->conn = ConexionBD::obtenerInstancia()->obtenerBD();
    }

    public function getProfile($user_id) {
        $res['estado'] = 0;

        try {
            $query = "SELECT * FROM pacientes WHERE id=:user_id;";
            $stm = $this->conn->prepare($query);
            $stm->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stm->execute();

            $user = $stm->fetchAll();

            $res['estado'] = 1;
            $res['mensaje'] = "success";
            $res['user'] = $user;
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        return json_encode($res);
    }

    public function getHistorialPagos($user_id) {
        $res['estado'] = 0;

        try {
            $query = "SELECT * FROM pagos WHERE pacientes_id=:user_id;";
            $stm = $this->conn->prepare($query);
            $stm->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stm->execute();

            $historial = $stm->fetchAll();

            $res['estado'] = 1;
            $res['mensaje'] = "success";
            $res['historial'] = $historial;
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        return json_encode($res);
    }

    public function getPagosBySesion($sesion_is) {
        $res['estado'] = 0;

        try {
            $query = "SELECT * FROM pagos WHERE id_presupuesto=:presupuesto_id;";
            $stm = $this->conn->prepare($query);
            $stm->bindParam(":presupuesto_id", $sesion_is, PDO::PARAM_INT);
            $stm->execute();

            $pagos = $stm->fetchAll();

            $res['estado'] = 1;
            $res['mensaje'] = "success";
            $res['pagos'] = $pagos;
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        return json_encode($res);
    }
}

if (isset($_POST['get'])) {
    if (auth()) {
        $get = $_POST['get'];
        $c = new CatalogoUsuario();

        switch ($get) {
            case 'profile':
                echo $c->getProfile($_POST['user_id']);
                break;
            case 'pagos':
                echo $c->getHistorialPagos($_POST['user_id']);
                break;
            default:
                header("Location: " . app_url() . "404");
        }
    } else {
        return json_encode(['estado' => 0, 'mensaje' => 'Error de credenciales']);
    }
} else {
    header("Location: " . app_url() . "404");
}