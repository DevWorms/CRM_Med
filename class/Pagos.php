<?php

include dirname(__FILE__) . '/../controladores/datos/ConexionBD.php';
include dirname(__FILE__) . '/../controladores/sesion/Session.php';

date_default_timezone_set('America/Mexico_City');

if (!isset($_SESSION)) {
    session_start();
}
error_reporting(E_ALL);
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




    /**PAGOS VERSION 2**/
    public function getPagos($paciente,$presupuesto){
        $res = ['estado' => 0];
        $query = "SELECT * FROM pagos WHERE pacientes_id = :paciente AND id_presupuesto = :presupuesto";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(":paciente", $paciente);
        $stm->bindParam(":presupuesto" ,$presupuesto);
        $stm->execute();
        $res['pagos'] = $stm->fetchAll();
        $res['no_pagos'] = count($res['pagos']);
        $res['estado'] = 1 ;
        
        return json_encode($res);
    }

    public function crearPago($pago){

        $res = ['estado' => 0];
        $res['mensaje'] = "No se guardo el pago";
        //obtenemos datos del presupuesto
        $query ="SELECT * FROM presupuestos WHERE id = :presupuesto";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(":presupuesto" , $pago['presupuesto']);
        $stm->execute();
        $presupuesto = $stm->fetchAll();


        //obtenemos lo pagado para generar el SALDO que generara este pago
        $query ="SELECT * FROM pagos WHERE id_presupuesto = :presupuesto AND pacientes_id = :paciente";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(":presupuesto" , $pago['presupuesto']);
        $stm->bindParam(":paciente" , $pago['paciente_id']);
        $stm->execute();
        $pagos = $stm->fetchAll();
        $acumulado = 0;
        foreach ($pagos as $p) {
            $acumulado += $p['monto'];
        }
        //le sumamos el nuevo importe
        $acumulado += $pago['importe_pago'];

        //obtenemos el saldo que queda despeus de este pago
        $saldo = $presupuesto[0]["precio"] - $acumulado;

        //Obtener fechas
        $fechaPago = $pago['fecha'];

        if($fechaPago == "0000-00-00" || $fechaPago == "" || $fechaPago == null)
            $fechaPago = date("Y-m-d");


        //obtenido el dato del saldo generamos el pago en la BD
        $query = "INSERT INTO pagos (fecha,folio_anterior,monto,concepto,forma_pago,observaciones,
        plan_financiamiento,financiera,id_presupuesto,pacientes_id,resta,fechado) 
        VALUES (now(),:folio_anterior,:monto,:concepto,:forma_pago,:observaciones,
        :plan_financiamiento,:financiera,:id_presupuesto,:pacientes_id,:resta,:fechado)";

        $stm = $this->pdo->prepare($query);

        //  AGREGAR LA COMPARACIÓN PARA LA FECHA Y QUE QUEDE CORREGIDO DE UNA VEZ POR TODAS :D

        $stm->bindParam(":fechado",$fechaPago);
        $stm->bindParam(":folio_anterior",$pago['folio_Pagos']);
        $stm->bindParam(":monto",$pago['importe_pago']);
        $stm->bindParam(":concepto",$pago['concepto']);
        $stm->bindParam(":forma_pago",$pago['forma_pago']);
        $stm->bindParam(":observaciones",$pago['observaciones']);

        //validamos si es con financiamiento
        $financiera = "";
        $meses = 0;
        if(isset($pago['finan'])){
            $financiera = $pago['financiera'];
            $meses = $pago['meses_pago'];
        }
        $stm->bindParam(":plan_financiamiento",$meses);
        $stm->bindParam(":financiera",$financiera);
        $stm->bindParam(":id_presupuesto",$pago['presupuesto']);
        $stm->bindParam(":pacientes_id",$pago['paciente_id']);
        $stm->bindParam(":resta",$saldo);

        

        // insertamos
        if($stm->execute()){
            $res['estado'] = 1;
            $res['mensaje'] = "Se genero el pago exitosamente";
        }

        return json_encode($res);
    }

    public function getPagosPaciente($id_cliente) {
        /**
         *  SE OBTIENEN TODOS LO PAGOS DE UN CLIENTE 
         *  QUE EL CONTADOR VA A REVISAR
         */
        $res = ['estado' => 0];
        // Seleccionando datos del paciente 
        try {
            $query = "SELECT  pg.pacientes_id as 'id_paciente', 
                CONCAT(pc.nombre, ' ', pc.apPaterno, ' ', pc.apMaterno) AS nombre,
                pg.id_pago, pg.monto, pg.concepto, pg.plan_financiamiento, pg.fecha,
                pg.confirmado, pg.revisado
                FROM pagos AS pg INNER JOIN pacientes AS pc 
                ON pg.pacientes_id = pc.id 
                WHERE pg.pacientes_id = :idpaciente ;";
            $stm = $this->pdo->prepare($query);
            $stm->bindParam(":idpaciente",$id_cliente);
            if ($stm->execute()) {
                $res['estado'] = 1;
                $res['pagos'] = $stm->fetchAll();
                if(sizeof($res['pagos']) < 1) {      
                    $res['estado'] = 0;
                    $res['mensaje'] = "No se encontraron pagos";
                } else {
                    $res['mensaje'] = "Pagos encontrados";
                }
            } else {
                $res['estado'] = 0;
                $res['mensaje'] = "No se encontraron pagos";
                $res['pagos'] = $stm->fetchAll();
            }
        }catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }
        return json_encode($res);
    }

    public function confirmarPago ($idpaciente, $idpago) {
        $res = ['estado' => 0];
        try {
            $query = "UPDATE pagos 
            SET confirmado = 1, revisado = 1
            WHERE pacientes_id = :idpaciente and id_pago = :idpago ;";
            $stm = $this->pdo->prepare($query);
            $stm->bindParam(":idpaciente",$idpaciente);
            $stm->bindParam(":idpago",$idpago);
            if ($stm->execute()) {
                $res['estado'] = 1;
                $res['mensaje'] = "Pago actualizado";
            } else {
                $res['estado'] = 0;
                $res['mensaje'] = "El pago no se actualizo";
            }
        }catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }
        return json_encode($res);
    }

    public function eliminarPago ($idpaciente, $idpago) {
        $res = ['estado' => 0];
        try {
            $query = "UPDATE pagos 
            SET confirmado = 0, revisado = 1
            WHERE pacientes_id = :idpaciente and id_pago = :idpago ;";
            $stm = $this->pdo->prepare($query);
            $stm->bindParam(":idpaciente",$idpaciente);
            $stm->bindParam(":idpago",$idpago);
            if ($stm->execute()) {
                $res['estado'] = 1;
                $res['mensaje'] = "Pago actualizado";
            } else {
                $res['estado'] = 0;
                $res['mensaje'] = "El pago no se actualizo";
            }
        }catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }
        return json_encode($res);
    }
    public function noConfirmarPago ($idpaciente, $idpago) {
        $res = ['estado' => 0];
        try {
            $query = "UPDATE pagos
            SET confirmado = 0, revisado = 1
            WHERE pacientes_id = :idpaciente and id_pago = :idpago;";
            $stm = $this->pdo->prepare($query);
            $stm->bindParam(":idpaciente",$idcliente);
            $stm->bindParam(":idpago",$idpago);
            if ($stm->execute()) {
                $res['estado'] = 0;
                $res['mensaje'] = "Pago actualizado";
            } else {
                $res['estado'] = 0;
                $res['mensaje'] = "El pago no se actualizo";
            }
        }catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }
        return json_encode($res);
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
            case 'getPagos':
                echo $p->getPagos($_POST['paciente'] , $_POST['presupuesto']);
                break;
            case 'crearPago':
                echo $p->crearPago($_POST);
                break;
            case 'getPagosPaciente':
                echo $p->getPagosPaciente($_POST['idpaciente']);
                break;
            case 'confirmarPago':
                echo $p->confirmarPago($_POST['idpaciente'], $_POST['idpago']);
                break;
            case 'eliminarPago':
                echo $p->eliminarPago($_POST['idpaciente'], $_POST['idpago']);
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