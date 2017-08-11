<?php
include dirname(__FILE__) . '/../controladores/datos/ConexionBD.php';
include dirname(__FILE__) . '/../controladores/sesion/Session.php';

/**
 * Created by PhpStorm.
 * User: rk521
 * Date: 22.01.17
 * Time: 05:49
 */
class Pedidos {
    private $pdo;
    private $pagination = 5;

    /**
     * Pedidos constructor.
     * @param $pdo
     */
    public function __construct() {
        $this->pdo = ConexionBD::obtenerInstancia()->obtenerBD();
    }

    public function getPedidos($page = 1) {
        $res = [
            'estado' => 0,
        ];

        try {
            $from = (($page - 1) * $this->pagination);

            $query = "select pedidos.*, usuarios.nombre, usuarios.apPaterno, usuarios.apMaterno, usuarios.numeroUsuario FROM pedidos inner join usuarios on pedidos.solicitante=usuarios.id ORDER BY id LIMIT :from, :to";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":from", $from, PDO::PARAM_INT );
            $stm->bindValue(":to", $this->pagination, PDO::PARAM_INT );

            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['pedidos'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage() . $query;
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function countPages() {
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "SELECT count(id) FROM pedidos;";
            $stm = $this->pdo->prepare($query);

            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['pages'] = ceil($resultado[0][0] / $this->pagination);
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage() . $query;
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function getProductos($id) {
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "SELECT * FROM pedidos_has_productos WHERE pedidos_id = :id";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":id", $id, PDO::PARAM_INT );

            $stm->execute();
            $resultado = $stm->fetchAll();
            $productos = [];

            foreach ($resultado as $r) {
                $stm_producto = $this->pdo->prepare("SELECT * from productos WHERE id = ?");
                $stm_producto->bindValue(1, $r['productos_id'], PDO::PARAM_STR);
                $stm_producto->execute();

                $producto = $stm_producto->fetchAll();
                $data['nombre'] = $producto[0]['nombre'];
                $data['tipo'] = $producto[0]['tipo'];
                $data['presentacion'] = $producto[0]['presentacion'];
                $data['gramaje'] = $producto[0]['gramaje'];
                $data['cantidad'] = $r['cantidad'];

                array_push($productos, $data);
            }

            $res['productos'] = $productos;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage() . $query;
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }
}

if (isset($_POST['get'])) {
    if (auth()) {
        $get = $_POST['get'];
        $p = new Pedidos();

        switch ($get) {
            case 'pedidos':
                $p->getPedidos($_POST['page']);
                break;
            case 'pages':
                $p->countPages();
                break;
            case 'pedido':
                $p->getProductos($_POST['id']);
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