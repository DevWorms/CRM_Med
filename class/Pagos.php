<?php
include dirname(__FILE__) . '/../controladores/datos/ConexionBD.php';
include dirname(__FILE__) . '/../controladores/sesion/Session.php';

session_start();

/**
 * Created by PhpStorm.
 * User: rk521
 * Date: 25.03.17
 * Time: 16:23
 */
class Pagos {
    private $pdo;

    /**
     * Pedidos constructor.
     */
    public function __construct() {
        $this->pdo = ConexionBD::obtenerInstancia()->obtenerBD();
    }

    public function createPresupuesto($data) {
        $res = ['estado' => 0];
        $user_id = $data['user_id'];
        $nombre = $data['nombre'];
        $costo = $data['costo'];

        try {
            $query = "SELECT * FROM pacientes WHERE id=:user_id;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":user_id", $user_id, PDO::PARAM_INT);
            $stm->execute();
            $resultado = $stm->fetchAll();

            if (count($resultado) == 0) {
                $res['mensaje'] = "No se encontro el folio: " . $user_id;
            } else {
                $query = "INSERT INTO presupuestos (precio, nombre, pacientes_id) VALUES (:nombre, :costo, :user_id);";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                $stm->bindValue(":costo", $costo, PDO::PARAM_STR);
                $stm->bindValue(":user_id", $user_id, PDO::PARAM_INT);
                $stm->execute();
                $id = $this->pdo->lastInsertId();

                $res['estado'] = 1;
                $res['mensaje'] = "Presupuesto creado correctamente.";
                $res['id'] = $id;
            }
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    public function getPresupuestos($id) {
        $res = ['estado' => 0];

        try {
            $query = "SELECT id, precio, nombre FROM presupuestos WHERE pacientes_id=:id;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":id", $id, PDO::PARAM_INT);
            $stm->execute();
            $presupuestos = $stm->fetchAll();

            $res['estado'] = 1;
            $res['presupuestos'] = $presupuestos;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    public function addPago($data) {
        $res = ['estado' => 0];
        $user_id = $data['user_id'];
        $presupuesto_id = $data['selec_presup'];
        $nombre = $data['concepto'];
        $costo = $data['monto'];
        $fechado = $data['fecha'];
        $id_pago = $data['recibo'];
        $restante = 0;

        try {
            $query = "SELECT * FROM presupuestos WHERE id=:id;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":id", $presupuesto_id, PDO::PARAM_INT);
            $stm->execute();
            $presupuesto = $stm->fetchAll();

            if (count($presupuesto) == 0) {
                $res['mensaje'] = "No se encontro el presupuesto: " . $presupuesto_id;
            } else {
                // restante = total presupuesto - (pagado + pago)
                $pres = $this->calculaPagado($presupuesto_id);
                $restante = $presupuesto[0]['precio'] - ($pres['pagado'] + $costo);

                $query = "INSERT INTO pagos (id_pago, monto, concepto, folio_anterior, resta, fechado, id_presupuesto, pacientes_id, orden_pago, fecha) 
                          VALUES (:id_pago, :monto, :concepto, :folio_anterior, :resta, :fechado, :id_presupuesto, :pacientes_id, :orden_pago, now());";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":monto", $costo, PDO::PARAM_STR);
                $stm->bindValue(":concepto", $nombre, PDO::PARAM_STR);
                $stm->bindValue(":folio_anterior", $pres['folio_anterior'], PDO::PARAM_INT);
                $stm->bindValue(":resta", $restante, PDO::PARAM_STR);
                $stm->bindValue(":fechado", $fechado, PDO::PARAM_STR);
                $stm->bindValue(":id_presupuesto", $presupuesto_id, PDO::PARAM_INT);
                $stm->bindValue(":pacientes_id", $user_id, PDO::PARAM_INT);
                $stm->bindValue(":orden_pago", $pres['orden_pago'], PDO::PARAM_INT);
                $stm->bindValue(":id_pago", $id_pago, PDO::PARAM_INT);
                $stm->execute();

                $res['estado'] = 1;
                $res['mensaje'] = "El pago se guardo correctamente.";
            }
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    private function calculaPagado($id_presupuesto) {
        $query = "SELECT * FROM pagos WHERE id_presupuesto=:id;";
        $stm = $this->pdo->prepare($query);
        $stm->bindValue(":id", $id_presupuesto, PDO::PARAM_INT);
        $stm->execute();
        $pagos = $stm->fetchAll();

        $pagado = 0;
        $orden_pago = 1;
        $folio_anterior = null;
        if (count($pagos) > 0) {
            foreach ($pagos as $pago) {
                $pagado += $pago['monto'];

                // Obtiene el folio mayor
                if ($pago['orden_pago'] > $folio_anterior) {
                    $folio_anterior = $pago['id_pago'];
                }

                $orden_pago = $pago['orden_pago'] + 1;
            }
        }

        $res['orden_pago'] = $orden_pago;
        $res['pagado'] = $pagado;
        $res['folio_anterior'] = $folio_anterior;
        return $res;
    }

    public function addPresupuesto($data) {
        $res = ['estado' => 0];
        $user_id = $data['user_id'];
        $nombre = $data['nombre'];
        $precio = $data['precio'];

        try {
            $query = "SELECT * FROM pacientes WHERE id=:id;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":id", $user_id, PDO::PARAM_INT);
            $stm->execute();
            $usuario = $stm->fetchAll();

            if (count($usuario) == 0) {
                $res['mensaje'] = "No se encontro el paciente: " . $user_id;
            } else {
                $id = $this->getPresupuestoID();

                // restante = total presupuesto - (pagado + pago)
                $query = "INSERT INTO presupuestos (id, nombre, precio, pacientes_id) 
                          VALUES (:id, :nombre, :precio, :pacientes_id);";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                $stm->bindValue(":precio", $precio, PDO::PARAM_STR);
                $stm->bindValue(":pacientes_id", $user_id, PDO::PARAM_INT);
                $stm->bindValue(":id", $id, PDO::PARAM_INT);
                $stm->execute();

                $res['estado'] = 1;
                $res['mensaje'] = "El presupuesto se guardo correctamente.";
            }
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    private function getPresupuestoID() {
        $query = "SELECT MAX(id) FROM presupuestos;";
        $stm = $this->pdo->prepare($query);
        $stm->execute();
        $id = $stm->fetchAll();

        return $id[0][0]+1;
    }
}

if (isset($_POST['get'])) {
    if (auth()) {
        $get = $_POST['get'];
        $p = new Pagos();

        switch ($get) {
            case 'createPresupuesto':
                echo $p->createPresupuesto($_POST);
                break;
            case 'getPresupuestos':
                echo $p->getPresupuestos($_POST['id']);
                break;
            case 'addPago':
                echo $p->addPago($_POST);
                break;
            case 'addPresupuesto':
                echo $p->addPresupuesto($_POST);
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