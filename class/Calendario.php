<?php
include dirname(__FILE__) . '/../controladores/datos/ConexionBD.php';
include dirname(__FILE__) . '/../controladores/sesion/Session.php';

if (!isset($_SESSION)) {
    session_start();
}
/**
 * Created by PhpStorm.
 * User: rk521
 * Date: 15.02.17
 * Time: 15:58
 */
class Calendario {
    private $pdo;

    /**
     * Calendario constructor.
     */
    public function __construct() {
        $this->pdo = ConexionBD::obtenerInstancia()->obtenerBD();
    }

    /*
     * Devuelve las citas para el calendario
     * @param $start_date
     * @param $end_date
     */
    public function events($start_date = null, $end_date = null) {
        $res = ['estado' => 0];

        try {
            $operacion = "SELECT 
                            c.id as `cita_id`, 
                            c.fecha, 
                            c.hora_ini, 
                            c.hora_fin, 
                            t.nombre_cita as `tipo_cita`, 
                            c.tipo_cita as `type`,
                            c.asistencia, 
                            pr.nombre as `procedimiento`,
                            p.* ,
                            r.id_relacion_mp,
                            u.nombre as medico_nombre,
                            u.apMaterno as medico_apellido
                          FROM citas c
                            INNER JOIN pacientes p ON c.pacientes_id=p.id
                            INNER JOIN tipo_citas t ON c.tipo_cita=t.id_cita
                            LEFT JOIN relacion_medico_paciente r ON c.pacientes_id=r.id_paciente
                            LEFT JOIN usuarios u ON r.id_medico_principal=u.id 
                            LEFT JOIN presupuestos pr ON c.presupuesto_id=pr.id
                          WHERE c.fecha >= :fechaInicio AND c.fecha < :fechaFin AND c.asistencia != 2;";
            $sentencia = $this->pdo->prepare($operacion);
            $sentencia->bindParam(":fechaInicio", $start_date, PDO::PARAM_STR);
            $sentencia->bindParam(":fechaFin", $end_date, PDO::PARAM_STR);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();

            $res['estado'] = 1;
            for ($i = 0; $i < count($resultado); $i ++) {
                $resultado[$i]["color"] = $this->getColor($resultado[$i]["type"]);
            }

            $res["eventos"] = $resultado;
        } catch (Exception $e) {
            $res["mensaje"] = $e->getMessage();
        }
        echo json_encode($res);
    }

    /*
     * Devuelve el reporte de citas para la parte de administraci�n - reporte
     */
    public function reporteEventos() {
        $res = ['estado' => 0];
        try {
            //el reporte envia las asitencias y no asistencias por fecha
            $operacion = "SELECT COUNT(*) as cuantas,fecha,asistencia FROM citas WHERE fecha < now() GROUP BY fecha,asistencia";
            $sentencia = $this->pdo->prepare($operacion);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();

            $res['estado'] = 1;

            for ($i = 0; $i < count($resultado); $i ++) {
                if ($resultado[$i]["asistencia"] == 1) {
                    $resultado[$i]["color"] = "#19a4e7";

                } else if($resultado[$i]["asistencia"] == 2 || $resultado[$i]["asistencia"] == 0){
                    $resultado[$i]["color"] = "#ea62a1";

                } else if($resultado[$i]["asistencia"] == 3){
                    $resultado[$i]["color"] = "#42e7d5";

                }
                //$resultado[$i]["tipo_cita"] = $this->getCita($resultado[$i]["tipo_cita"]);
            }

            $res["eventos"] = $resultado;
        } catch (Exception $e) {
            $res["mensaje"] = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function reporteEventosDetalle($fecha,$asistencia){
        $res = ['estado' => 0];
        try {
            //el reporte envia las asitencias y no asistencias por fecha
            $operacion = "SELECT citas.fecha as fecha, citas.hora_ini as hora_ini,pacientes.nombre as nombre, pacientes.apPaterno as paterno, pacientes.apMaterno as materno, pacientes.id as idPaciente FROM citas,pacientes WHERE citas.fecha = ? AND citas.asistencia = ? AND citas.pacientes_id = pacientes.id";

            $sentencia = $this->pdo->prepare($operacion);
            $sentencia->bindParam(1,$fecha);
            $sentencia->bindParam(2,$asistencia);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();

            $res['estado'] = 1;

            $res["detalle"] = $resultado;
        } catch (Exception $e) {
            $res["mensaje"] = $e->getMessage();
        }
        echo json_encode($res);
    }

    /*
     * Actualiza si es que un paciente asistio o no a su cita
     */
    public function asistioEvento($asistencia, $id, $user_id, $reagendar = null, $nueva_fecha = null, $nueva_hora = null) {
        $res = ['estado' => 0];
        try {
            /*
             * Se utilizaran 1, 2 y 3 como valores:
             * 1 Cuando la cita NO es de primera vez y se llevo a cabo
             * 2 cuando no se llevo a cabo
             * 3 cuando la cita SI es de primera vez y SI se llevo a cabo, esto para moverlo a "Pacientes en espera"
             */

            $asistencia_bak = $asistencia;

            if ($asistencia == 1) {
                if ($this->isFirstDate($id)) {
                    $asistencia = 3;
                }
            }

            if ($reagendar == 1) {
                if ($nueva_fecha == null || $nueva_hora == null) {
                    $res['estado'] = 0;
                    $res['mensaje'] = "Ingresa una fecha y hora validas";
                } else {
                    // Se reagenda la cita y asistencia queda en 0 (En espera)
                    $operacion = "UPDATE citas SET fecha=:fecha, hora_ini=:hora WHERE id=:id;";
                    $sentencia = $this->pdo->prepare($operacion);
                    $sentencia->bindValue(":fecha", $nueva_fecha, PDO::PARAM_STR);
                    $sentencia->bindValue(":hora", $nueva_hora, PDO::PARAM_STR);
                    $sentencia->bindValue(":id", $id, PDO::PARAM_INT);
                    $sentencia->execute();
                    $res['estado'] = 1;
                }
            } else {
                // Sólo actualiza si asistio o no
                $operacion = "UPDATE citas SET asistencia=:asistio WHERE id=:id;";
                $sentencia = $this->pdo->prepare($operacion);
                $sentencia->bindValue(":asistio", $asistencia, PDO::PARAM_INT);
                $sentencia->bindValue(":id", $id, PDO::PARAM_INT);
                $sentencia->execute();
                $res['estado'] = 1;

                // Si es primera vez
                if ($this->isPaciente($user_id)) {
                    $res['redirect'] = 0;
                } else {
                    if ($asistencia_bak == 1) {
                        $operacion = "UPDATE pacientes SET is_paciente=1 WHERE id=:user_id;";
                        $sentencia = $this->pdo->prepare($operacion);
                        $sentencia->bindValue(":user_id", $user_id, PDO::PARAM_INT);
                        $sentencia->execute();


                        $res['redirect'] = 1;
                    } else {
                        $res['redirect'] = 0;
                    }
                }
            }
        } catch (Exception $e) {
            $res["mensaje"] = $e->getMessage();
        }
        echo json_encode($res);
    }

    /*
     * Valida si es una cita de primera vez
     */
    private function isFirstDate($id_cita) {
        $query = "SELECT tipo_cita FROM citas WHERE id=:id;";
        $stm = $this->pdo->prepare($query);
        $stm->bindValue(":id", $id_cita, PDO::PARAM_INT);
        $stm->execute();

        $resultado = $stm->fetchAll();

        return ($resultado[0][0] == 1) ? true : false;
    }

    /*
     * Devuelve el color para un tipo de cita
     */
    private function getColor($id_cita) {
        switch ($id_cita) {
            case 1:     //  PRIMERA VEZ
                $color_agenda = "#49d9da";
                break;
            case 5:     //  VALORACIÓN
                $color_agenda = "#88d381";
                break;
            case 6:     //  REVISIÓN
                $color_agenda = "#b6c8e7";
                break;
            default:    //  TRATAMIENTO
                $color_agenda = "#87bfb4";
        }

        return $color_agenda;
    }

    /*
     * Valida, si una persona es prospecto o ya es paciente
     */
    private function isPaciente($user_id) {
        try {
            $operacion = "SELECT is_paciente FROM pacientes WHERE id=:user_id;";
            $sentencia = $this->pdo->prepare($operacion);
            $sentencia->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();

            if ($resultado[0][0] == 1) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    private function getCita($id_cita) {
        $nombre_cita = "No archivado";

        try {
            $query = "SELECT nombre_cita FROM tipo_citas WHERE id_cita=:id";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":id", $id_cita, PDO::PARAM_INT);
            $stm->execute();

            $resultado = $stm->fetchAll();

            $nombre_cita = $resultado[0][0];
        } catch (Exception $e) {
        }

        return $nombre_cita;
    }

    function asistenciasHoy() {
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("Y-m-d");
        try {
            $query = 'SELECT DISTINCT
                            (SELECT COUNT(tipo_cita) FROM citas WHERE tipo_cita = 1 AND fecha = :fecha) AS primera,
                            (SELECT COUNT(tipo_cita) FROM citas WHERE tipo_cita = 5 AND fecha = :fecha) AS valora,
                            (SELECT COUNT(tipo_cita) FROM citas WHERE tipo_cita = 6 AND fecha = :fecha) AS revisa,
                            (SELECT COUNT(tipo_cita) FROM citas WHERE tipo_cita = 7 AND fecha = :fecha) AS trata
                        FROM citas';
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":fecha", $hoy, PDO::PARAM_STR);
            $stm->execute();

            $resultado = $stm->fetchAll();

            $res['total'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        echo json_encode($res);
    }
}

if (isset($_POST['get'])) {
    if (auth()) {
        $get = $_POST['get'];
        $f = new Calendario();

        switch ($get) {
            case 'events':
                $f->events($_POST['fecha_inicio'], $_POST['fecha_fin']);
                break;
            case 'reporteEventos':
                $f->reporteEventos();
                break;
            case 'asistencia':
                $f->asistioEvento($_POST['asistencia'], $_POST['id'], $_POST['user_id'], $_POST['reagendar'], $_POST['nueva_fecha'], $_POST['nueva_hora']);
                break;
            case 'reporteEventosDetalle':
                $f->reporteEventosDetalle($_POST['fecha'],$_POST['asistencia']);
            break;
            case 'asistenciasHoy':
                $f->asistenciasHoy();
            break;
            default:
                header("Location: " . app_url() . "404");
                break;
        }
    } else {
        return json_encode(['estado' => 0, 'mensaje' => 'Error de credenciales']);
    }
} else {
    header("Location: " . app_url() . "404");
}