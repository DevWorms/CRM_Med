<?php
include dirname(__FILE__) . '/../controladores/datos/ConexionBD.php';
include dirname(__FILE__) . '/../controladores/sesion/Session.php';
/**
 * Created by PhpStorm.
 * User: rk521
 * Date: 23.03.17
 * Time: 21:13
 */
class Recepcion {
    private $pdo;

    /**
     * Inventario constructor.
     */
    public function __construct() {
        $this->pdo = ConexionBD::obtenerInstancia()->obtenerBD();
    }

    public function getProcedimientos($search) {
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "SELECT DISTINCT nombre_cita FROM tipo_citas WHERE nombre_cita LIKE :search;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":search", "%$search%", PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['procedimientos'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    public function getAnuncio($search) {
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "SELECT DISTINCT referencia FROM pacientes WHERE referencia LIKE :search;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":search", "%$search%", PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['anuncios'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }
}

if (isset($_POST['get'])) {
    if (auth()) {
        $get = $_POST['get'];
        $r = new Recepcion();

        switch ($get) {
            case 'procedimientos':
                echo $r->getProcedimientos($_POST['search']);
                break;
            case 'anuncios':
                echo $r->getAnuncio($_POST['search']);
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