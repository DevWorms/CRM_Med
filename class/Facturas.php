<?php
include dirname(__FILE__) . '/../controladores/datos/ConexionBD.php';
include dirname(__FILE__) . '/../controladores/sesion/Session.php';

if(!isset($_SESSION)){
    session_start();
}
/**
 * Created by PhpStorm.
 * User: rk521
 * Date: 22.01.17
 * Time: 14:09
 */
class Facturas {
    private $pdo;

    /**
     * Facturas constructor.
     */
    public function __construct() {
        $this->pdo = ConexionBD::obtenerInstancia()->obtenerBD();
    }

    public function createOrden($data) {
        $fecha = $data['fecha'];
        $dias_credito = $data['credito'];
        $caja = $data['caja'];
        //$pastilla = $data['pastilla'];

        $res = [
            'estado' => 0,
        ];

        if (count($data['v_producto']) > 0) {
            try {
                $query = "INSERT INTO ordenes_compra (fecha_requerimiento, dias_credito, created_at) VALUES (?, ?, NOW())";
                $stm = $this->pdo->prepare($query);

                $stm->bindValue(1, $fecha, PDO::PARAM_STR);
                $stm->bindValue(2, $dias_credito, PDO::PARAM_STR);
                $stm->execute();
                $id = $this->pdo->lastInsertId();

                for ($i = 0; $i < count($data['v_producto']); $i++) {
                    $query = "INSERT INTO orden_productos (producto, unidades, gramaje, tipo, presentacion, orden_id, caja, caducidad, lote, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, now())";
                    $stm = $this->pdo->prepare($query);

                    $stm->bindValue(1, $data['v_producto'][$i], PDO::PARAM_STR);
                    $stm->bindValue(2, $data['v_unidades'][$i], PDO::PARAM_INT);
                    $stm->bindValue(3, $data['v_gramaje'][$i], PDO::PARAM_STR);
                    $stm->bindValue(4, $data['v_tipo'][$i], PDO::PARAM_STR);
                    $stm->bindValue(5, $data['v_presentacion'][$i], PDO::PARAM_STR);
                    $stm->bindValue(6, $id, PDO::PARAM_INT);
                    $stm->bindValue(7, $data['v_caja'][$i], PDO::PARAM_STR);
                    $stm->bindValue(8, $data['v_caducidad'][$i], PDO::PARAM_STR);
                    $stm->bindValue(9, $data['v_lote'][$i], PDO::PARAM_STR);
                    $stm->execute();
                }

                $res['mensaje'] = "Orden de compra creada correctamente";
                $res['estado'] = 1;
                $res['id'] = $id;
            } catch (Exception $e) {
                $res['mensaje'] = $e->getMessage();
            }
        } else {
            $res['mensaje'] = "Ingresa al menos un producto";
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    private function selectOrCreateProveedor($proveedor) {
        try {
            $query = "SELECT id FROM proveedores WHERE nombre = :proveedor;";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":proveedor", $proveedor, PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            if (count($resultado) === 1) {
                $id = $resultado[0][0];
            } else {
                $query = "INSERT INTO proveedores (nombre) VALUES (:nombre);";
                $stm = $this->pdo->prepare($query);

                $stm->bindValue(":nombre", $proveedor, PDO::PARAM_STR);
                $stm->execute();

                $id = $this->pdo->lastInsertId();
            }

            return $id;
        } catch (Exception $ex) {
            return 0;
        }
    }

    public function getIdProveedor($proveedor) {
        try {
            $query = "SELECT id FROM proveedores WHERE nombre = ?";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(1, $proveedor, PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            return $resultado[0][0];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getProveedores($string) {
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "SELECT nombre FROM proveedores WHERE nombre LIKE :search";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":search", "%$string%", PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['proveedores'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function getOrdenById($id) {
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "SELECT * FROM ordenes_compra WHERE id LIKE :id";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":id", $id, PDO::PARAM_INT);
            $stm->execute();
            $resultado = $stm->fetchAll();

            if (count($resultado) === 1) {
                $query = "SELECT * FROM orden_productos WHERE orden_id=:id";
                $stm2 = $this->pdo->prepare($query);
                $stm2->bindValue(":id", $id, PDO::PARAM_INT);
                $stm2->execute();
                $productos = $stm2->fetchAll();

                $res['estado'] = 1;
                $res['orden'] = $resultado[0];
                $res['productos'] = $productos;
            } else {
                $res['estado'] = 0;
                $res['mensaje'] = "No se encontro la orden: " . $id;
            }
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function createFactura($data) {
        $res = ['estado' => 0];
        $numeroFactura = $data['factura'];
        $importe = $data['importe'];
        $iva = $data['iva'];
        $total = $data['total'];
        $fecha_expedicion = $data['fecha'];
        $proveedor = $data['proveedor'];
        $orden_id = $data['orden_id'];
        $dias_credito = $data['credito'];
        $caja = $data['caja'];
        $pastilla = $data['pastilla'];

        $proveedores_id = $this->selectOrCreateProveedor($proveedor);

        try {
            /*
            $query = "INSERT INTO facturas (numeroFactura, importe, iva, total, fecha_expedicion, proveedores_id, 
                      dias_credito, caja, pastilla, fecha_captura) VALUES (:numeroFactura, :importe, :iva, :total, 
                      :fecha_expedicion, :proveedores_id, :dias_credito, :caja, :pastilla, now());";
            */
            $query = "INSERT INTO facturas (numeroFactura, importe, iva, total, fecha_expedicion, proveedores_id, 
                      fecha_captura, capturo_id, orden_id) VALUES (:numeroFactura, :importe, :iva, :total, :fecha_expedicion, 
                      :proveedores_id, now(), :user_id, :orden_id);";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":numeroFactura", $numeroFactura, PDO::PARAM_INT);
            $stm->bindValue(":importe", $importe, PDO::PARAM_STR);
            $stm->bindValue(":iva", $iva, PDO::PARAM_STR);
            $stm->bindValue(":total", $total, PDO::PARAM_STR);
            $stm->bindValue(":fecha_expedicion", $fecha_expedicion, PDO::PARAM_STR);
            $stm->bindValue(":proveedores_id", $proveedores_id, PDO::PARAM_INT);
            $stm->bindValue(":user_id", $_SESSION['Id'], PDO::PARAM_INT);
            $stm->bindValue(":orden_id", $orden_id, PDO::PARAM_INT);
            //$stm->bindValue(":dias_credito", $dias_credito, PDO::PARAM_STR);
            //$stm->bindValue(":caja", $caja, PDO::PARAM_STR);
            //$stm->bindValue(":pastilla", $pastilla, PDO::PARAM_STR);
            $stm->execute();

            $id = $this->pdo->lastInsertId();

            $res['estado'] = 1;
            $res['mensaje'] = "Factura creada correctamente";
            $res['factura'] = $id;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        echo json_encode($res);
    }

    public function addObservacion($id, $observacion) {
        $res = ['estado' => 0];

        try {
            $query = "UPDATE orden_productos SET observacion=:observacion WHERE id=:id;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":observacion", $observacion, PDO::PARAM_STR);
            $stm->bindValue(":id", $id, PDO::PARAM_INT);
            $stm->execute();

            $res['estado'] = 1;
            $res['mensaje'] = "Observación guardada correctamente";
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        echo json_encode($res);
    }
}

if (isset($_POST['get'])) {
    if (auth()) {
        $get = $_POST['get'];
        $f = new Facturas();

        switch ($get) {
            case 'create':
                $f->createOrden($_POST);
                break;
            case 'proveedores':
                $f->getProveedores($_POST['search']);
                break;
            case 'getOrden':
                $f->getOrdenById($_POST['id']);
                break;
            case 'createFactura':
                $f->createFactura($_POST);
                break;
            case 'addObservacion':
                $f->addObservacion($_POST['id'], $_POST['observacion']);
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