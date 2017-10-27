<?php
include dirname(__FILE__) . '/../controladores/datos/ConexionBD.php';
include dirname(__FILE__) . '/../controladores/sesion/Session.php';

class Inventario {
    private $pdo;
    private $pagination = 10;

    /**
     * Inventario constructor.
     */
    public function __construct() {
        $this->pdo = ConexionBD::obtenerInstancia()->obtenerBD();
    }

    public function getInventario($page = 1) {
        $res = [
            'estado' => 0,
        ];

        try {
            $from = (($page - 1) * $this->pagination);

            $query = "SELECT * FROM productos WHERE existencia > 0 ORDER BY caducidad ASC, nombre ASC LIMIT :from, :to";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":from", $from, PDO::PARAM_INT );
            $stm->bindValue(":to", $this->pagination, PDO::PARAM_INT );

            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['inventario'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function countPages() {
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "SELECT count(id) FROM productos WHERE existencia > 0;";
            $stm = $this->pdo->prepare($query);

            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['pages'] = ceil($resultado[0][0] / $this->pagination);
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function searchProducto($string) {
        $res = [
            'estado' => 0,
        ];

        try {

            $query = "SELECT * FROM productos WHERE nombre LIKE :search AND existencia > 0 ORDER BY caducidad ASC;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":search", "%$string%", PDO::PARAM_STR);

            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['productos'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function getPresentacion($string){
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "SELECT presentacion FROM productos WHERE presentacion LIKE :search group by presentacion;";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":search", "%$string%", PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['productos'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function getGramaje($string){
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "SELECT gramaje FROM productos WHERE gramaje LIKE :search group by gramaje;";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":search", "%$string%", PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['productos'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function getTipo($string){
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "SELECT tipo FROM productos WHERE tipo LIKE :search group by tipo;";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":search", "%$string%", PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['tipos'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function createProducto($nombre, $fecha, $tipo, $presentacion, $gramaje, $piezas, $lote,$descripcion,$existencia,$cant_gramaje) {
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "INSERT INTO productos (nombre, tipo, gramaje, presentacion, existencia, caducidad, lote, pzs_presentacion, descripcion, cant_gramaje)
            VALUES ('$nombre', '$tipo', '$gramaje', '$presentacion', '$existencia', '$fecha', '$lote', '$piezas', '$descripcion', '$cant_gramaje')";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(1, $nombre, PDO::PARAM_STR);
            $stm->bindValue(2, $tipo, PDO::PARAM_STR);
            $stm->bindValue(3, $presentacion, PDO::PARAM_STR);
            $stm->bindValue(4, $gramaje, PDO::PARAM_STR);
            $stm->bindValue(5, $fecha, PDO::PARAM_STR);
            $stm->bindValue(6, $lote, PDO::PARAM_INT);
            $stm->bindValue(7, $piezas, PDO::PARAM_STR);
            $stm->bindValue(8, $descripcion, PDO::PARAM_STR);
            $stm->bindValue(9, $existencia, PDO::PARAM_INT);
            $stm->bindValue(10, $cant_gramaje, PDO::PARAM_STR);
            $stm->execute();

            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function getProductoById($idProducto){
        $res = [
            'estado' => 0,
        ];

        try {

            $query = "SELECT * FROM productos WHERE id= :id;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":id", $idProducto, PDO::PARAM_INT);

            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['producto'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function modifyProducto($nombre, $fecha, $tipo, $presentacion, $gramaje, $piezas, $lote,$descripcion,$existencia,$cant_gramaje,$idProducto) {
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "UPDATE productos SET nombre = ?, tipo = ?, presentacion = ?, gramaje = ?, caducidad = ?, lote = ?, pzs_presentacion = ?,descripcion = ?,existencia = ?,cant_gramaje = ? WHERE id = ?";
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(1, $nombre, PDO::PARAM_STR);
            $stm->bindValue(2, $tipo, PDO::PARAM_STR);
            $stm->bindValue(3, $presentacion, PDO::PARAM_STR);
            $stm->bindValue(4, $gramaje, PDO::PARAM_STR);
            $stm->bindValue(5, $fecha, PDO::PARAM_STR);
            $stm->bindValue(6, $lote, PDO::PARAM_INT);
            $stm->bindValue(7, $piezas, PDO::PARAM_STR);
            $stm->bindValue(8, $descripcion, PDO::PARAM_STR);
            $stm->bindValue(9, $existencia, PDO::PARAM_INT);
            $stm->bindValue(10, $cant_gramaje, PDO::PARAM_STR);
            $stm->bindValue(11, $idProducto, PDO::PARAM_INT);
            $stm->execute();

            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function searchProductoToOut($string) {
        $res = [
            'estado' => 0,
        ];

        try {

            $query = "SELECT id, nombre, existencia FROM productos WHERE nombre LIKE :search AND existencia > 0 ORDER BY caducidad ASC limit 15;";

            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":search", "%$string%", PDO::PARAM_STR);

            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['productos'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }


    public function generarSalida($data){
        $res = [
            'estado' => 0,
        ];
        try{
            // primero validamos que al menos un producto salga
            $ids = $data["out_productoId"];
            $cantidades = $data["out_productoCant"];
            $tempIns = 0;
            for($i=0; $i< count($ids); $i++){
                $query = "SELECT existencia from productos WHERE id= :idProd";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":idProd", $ids[$i], PDO::PARAM_INT);
                $stm->execute();
                $resultado = $stm->fetchAll();
                $existenciaBD = $resultado[0]["existencia"];
                if($cantidades[$i] > $existenciaBD){
                    $tempIns += 1;
                }
            }

            if($tempIns < count($ids)){
                // si podemos insertar al menos 1 comenzamos insertando el master
                $query = "INSERT INTO salida_productos_master (user_id,medico_id,paciente_id,comentario) VALUES(?,?,?,?)";
                $stm = $this->pdo->prepare($query);
                $stm->bindParam(1,$data["user"]);
                $stm->bindParam(2,$data["medico"]);
                $stm->bindParam(3,$data["paciente"]);
                $stm->bindParam(4,$data["comentario"]);
                if($stm->execute()){
                    $idMaster = $this->pdo->lastInsertId();
                    // Una vez insertado el master insertamos detalle y checamos existencia uno a uno
                    $errorDeta = "";
                    $errorResta = "";
                    for($i=0; $i< count($ids); $i++){
                        $query = "SELECT existencia from productos WHERE id= :idProd";
                        $stm = $this->pdo->prepare($query);
                        $stm->bindValue(":idProd", $ids[$i], PDO::PARAM_INT);
                        $stm->execute();
                        $resultado = $stm->fetchAll();
                        $existenciaBD = $resultado[0]["existencia"];
                        if($cantidades[$i] <= $existenciaBD){
                            // si se pudo insertar el detalle restamos la existencia
                            if($this->generarDetalleSalida($idMaster,$ids[$i],$cantidades[$i])){
                                if(!$this->restarExistencia($ids[$i],$cantidades[$i])){
                                    $errorResta = $ids[$i].",";
                                }
                            }else{
                                $errorDeta = $ids[$i].",";
                            }
                        }
                    }
                    if($errorResta == "" AND $errorDeta == ""){
                        $res['estado'] = 1;
                        $res['mensaje'] = "Salida generada";
                    }else{
                        $res['estado'] = 0;
                        $res['mensaje'] = "No se pudo genera la salida de algunos productos : " . $errorDeta . " o la resta de existencia : " . $errorResta;
                    }

                }
            }else{
                 $res['mensaje'] = "No se pudo registrar la salida de ningun producto";
            }

        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }
        echo json_encode($res);
    }


    public function generarDetalleSalida($master,$producto,$cantidad){
        $query = "INSERT INTO salida_productos_deta (id_master,id_producto,cantidad) VALUES(?,?,?)";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(1,$master);
        $stm->bindParam(2,$producto);
        $stm->bindParam(3,$cantidad);
        return $stm->execute();
    }

    // RESTA UNA SALIDA DE PRODUCTOS
    public function restarExistencia($id,$cantMenos){
        $query = "UPDATE productos SET existencia = existencia - ? WHERE id = ? ";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(1,$cantMenos);
        $stm->bindParam(2,$id);
        return $stm->execute();
    }

    // BUSQUEDA DE SALDIA DE PRODUCTOS
    public function reporteSalidaProductos($usuario,$medico,$paciente,$fecha){

        $res = [
            'estado' => 0,
        ];

        try{
            $query = ' SELECT s.id_master as id,';
            $query .= ' concat(u.nombre, " " , if(u.apPaterno != null, u.apPaterno,"") , " " , if(u.apMaterno != null, u.apMaterno,"")) as nUsuario,';
            $query .= ' concat(m.nombre, " " , m.apPaterno , " " , if(m.apMaterno != null, m.apMaterno,"")) as nMedico,';
            $query .= ' concat(p.nombre, " " , p.apPaterno , " " , if(p.apMaterno != null, p.apMaterno,"")) as nPaciente,';
            $query .= ' s.fecha_salida as fecha,s.comentario as comentario';
            $query .= ' FROM salida_productos_master AS s ';
            $query .= ' LEFT JOIN usuarios AS u ON s.user_id = u.id';
            $query .= ' LEFT JOIN usuarios AS m ON s.medico_id = m.id AND m.id_tipo = 2';
            $query .= ' LEFT JOIN pacientes AS p ON s.paciente_id = p.id WHERE 1=1 ';

        if($usuario == 0 AND $medico == 0 AND $paciente == 0 AND $fecha == ""){

            $query.= " ORDER BY s.fecha_salida DESC LIMIT 15 ";

            }else{
                if($usuario != 0)
                    $query .= " AND user_id = :usuario ";
                if($medico != 0)
                    $query .= " AND medico_id = :medico ";
                if($paciente != 0)
                    $query .= " AND paciente_id = :paciente ";
                if(isset($fecha) AND $fecha!= "" )
                    $query .= " AND DATE_FORMAT(s.fecha_salida,'%Y-%m-%d') = STR_TO_DATE(:fecha,'%Y-%m-%d') ";
            }
            $stm = $this->pdo->prepare($query);

            if($usuario != 0)
                $stm->bindValue(":usuario", $usuario, PDO::PARAM_INT);
            if($medico != 0)
                $stm->bindValue(":medico", $medico, PDO::PARAM_INT);
            if($paciente != 0)
                $stm->bindValue(":paciente", $paciente, PDO::PARAM_INT);
            if(isset($fecha) AND $fecha!= "" )
                $stm->bindValue(":fecha", $fecha, PDO::PARAM_STR);

            $stm->execute();
            $rows = $stm->fetchAll();

            $res["estado"]=1;
            $res["mensaje"]="Generacion de reporte exitoso";
            $res["salidas"] = $rows;
        }catch(Exception $ex){
            $res["estado"]=0;
            $res["mensaje"]="Generacion de reporte fallido <br> " . $ex->getMessage();
        }

        return json_encode($res);
    }

    public function getDetalleSalidas($master){
        $res = [
            'estado' => 0,
        ];
        try{
            $query = "SELECT p.nombre,d.cantidad FROM salida_productos_deta as d LEFT JOIN productos as p ON d.id_producto = p.id WHERE d.id_master = ?";

            $stm = $this->pdo->prepare($query);
            $stm->bindParam(1,$master);
            $stm->execute();
            $rows = $stm->fetchAll();
            $res["estado"]=1;
            $res["mensaje"]="Generacion de reporte deta exitoso";
            $res["detalles"] = $rows;

        }catch(Exception $ex){
            $res["estado"]=0;
            $res["mensaje"]="Generacion de reporte fallido <br> " . $ex->getMessage();
        }
        return json_encode($res);
    }

}

if (isset($_POST['get'])) {
    if (auth()) {
        $get = $_POST['get'];
        $i = new Inventario();

        switch ($get) {
            case 'catalogo':
                $i->getInventario($_POST['page']);
                break;
            case 'pages':
                $i->countPages();
                break;
            case 'search':
                $i->searchProducto($_POST['search']);
                break;
            case 'create':
                $i->createProducto($_POST['nombre'], $_POST['fecha'], $_POST['tipo'], $_POST['presentacion'], $_POST['gramaje'], $_POST['piezas'], $_POST['lote'],$_POST['descripcion'],$_POST['existencia'], $_POST['cant_gramaje']);
                break;
            case 'getProductoById':
                $i->getProductoById($_POST['idProd']);
                break;
            case 'modifyProducto':
                $i->modifyProducto($_POST['e-nombre'], $_POST['e-fecha'], $_POST['e-tipo'], $_POST['e-presentacion'], $_POST['e-gramaje'], $_POST['e-piezas'], $_POST['e-lote'],$_POST['e-descripcion'],$_POST['e-existencia'], $_POST['e-cant_gramaje'],$_POST['idProducto']);
                break;
            case 'searchProductoToOut':
                $i->searchProductoToOut($_POST['busqueda']);
                break;
            case 'generarSalida':
                $i->generarSalida($_POST);
                break;
            case 'reporteSalidaProductos':
                echo $i->reporteSalidaProductos($_POST["usuario"], $_POST["medico"], $_POST["paciente"], $_POST["fecha"]);
                break;
            case 'getDetalleSalidas':
                echo $i->getDetalleSalidas($_POST["master"]);
                break;
            case 'getPresentacion':
                $i->getPresentacion($_POST["search"]);
                break;
            case 'getGramaje':
                $i->getGramaje($_POST["search"]);
                break;
            case 'getTipo':
                $i->getTipo($_POST["search"]);
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
