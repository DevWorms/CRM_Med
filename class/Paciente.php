<?php

/**
 * Created by PhpStorm.
 * User: chemasmas
 * Date: 22/01/17
 * Time: 12:52 PM
 */

include dirname(__FILE__) . '/../controladores/datos/ConexionBD.php';
include dirname(__FILE__) . '/../controladores/sesion/Session.php';

class Paciente
{
    private $pdo;
    private $pagination = 20;

    /**
     * Pedidos constructor.
     */
    public function __construct() {
        $this->pdo = ConexionBD::obtenerInstancia()->obtenerBD();
    }

    /**
     * @param $id_paciente
     * @return string
     */
    public function getPaciente($id_paciente) {
       $query = "SELECT * FROM pacientes WHERE id = :id";
       try {
            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":id", $id_paciente, PDO::PARAM_INT );

           $stm->execute();
           $resultado = $stm->fetchAll();

           if (count($resultado)===1) {
               $res['paciente'] = $resultado;
               $res['estado'] = 1;
           }
           else{
               $res['mensaje'] = "No se encontró el paciente: " . $id_paciente;
               $res['estado'] = 0;
           }
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
            $res['estado'] = 0;
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    public function getPacienteFull($id_paciente) {
        try {
            $query = "SELECT * FROM pacientes WHERE id = :id";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":id", $id_paciente, PDO::PARAM_INT );
            $stm->execute();
            $resultado = $stm->fetchAll();

            $query = "SELECT pagos.*, presupuestos.precio, presupuestos.promocion, 
                      presupuestos.vigencia, presupuestos.nombre FROM pagos INNER JOIN presupuestos ON pagos.id_presupuesto=presupuestos.id WHERE pagos.pacientes_id=:id;";
            $stm2 = $this->pdo->prepare($query);
            $stm2->bindValue(":id", $id_paciente, PDO::PARAM_INT );
            $stm2->execute();
            $pagos = $stm2->fetchAll();

            $query = "SELECT citas.*, presupuestos.nombre FROM citas LEFT JOIN presupuestos ON citas.presupuesto_id=presupuestos.id WHERE citas.pacientes_id=:id ORDER BY fecha ASC, hora_ini ASC;";
            $stm3 = $this->pdo->prepare($query);
            $stm3->bindValue(":id", $id_paciente, PDO::PARAM_INT );
            $stm3->execute();
            $citas = $stm3->fetchAll(PDO::FETCH_OBJ);

            if (count($resultado)===1) {
                $nextDate = [];
                if (count($citas) > 0) {
                    $today = date("Y-m-d");
                    foreach ($citas as $cita) {
                        if ($cita->fecha > $today) {
                            $nextDate = $cita;
                            break;
                        }
                    }
                }
                $res['paciente'] = $resultado[0];
                $res['pagos'] = $pagos;
                $res['citas'] = $citas;
                $res['nextDate'] = $nextDate;
                $res['estado'] = 1;
            }
            else{
                $res['mensaje'] = "No se encontró el paciente: " . $id_paciente;
                $res['estado'] = 0;
            }
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
            $res['estado'] = 0;
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    /**
     * @param $nombre
     * @param $apP
     * @param $apM
     * @param $dom
     * @param $tel
     * @param $ocupacion
     * @return string
     */
    public function addPaciente($nombre, $apP, $apM, $dom, $tel, $email, $fecha, $edad, $ocp, $tel_fam, $nom_fam, $ref, $folio) {
        if (empty($nombre) || empty($apP) || empty($dom) || empty($tel) || empty($fecha) || empty($edad)) {
            $res['estado'] = 0;
            if (empty($nombre)) { $res['mensaje'] = "Ingresa un nombre";}
            if (empty($apP)) { $res['mensaje'] = "Ingresa un apellido paterno";}
            if (empty($dom)) { $res['mensaje'] = "Ingresa un domicilio";}
            if (empty($tel)) { $res['mensaje'] = "Ingresa un número de teléfono";}
            if (empty($fecha)) { $res['mensaje'] = "Ingresa la fecha de nacimiento";}
            if (empty($edad)) { $res['mensaje'] = "Ingresa la edad";}
        } else {
            if (!empty($folio)) {
                $query = "INSERT INTO pacientes(id, nombre, apPaterno, apMaterno, domicilio, telefono, ocupacion, nombreFamiliar, telefonoFamiliar, email, fecha_nacimiento, edad, referencia, created_at)
                  VALUES (:id, :nombre, :apPaterno, :apMaterno, :domicilio, :telefono, :ocupacion, :nomFam, :telFam, :email, :fecha, :edad, :ref, now());";
            } else {
                $query = "INSERT INTO pacientes(nombre, apPaterno, apMaterno, domicilio, telefono, ocupacion, nombreFamiliar, telefonoFamiliar, email, fecha_nacimiento, edad, referencia, created_at)
                  VALUES (:nombre, :apPaterno, :apMaterno, :domicilio, :telefono, :ocupacion, :nomFam, :telFam, :email, :fecha, :edad, :ref, now());";
            }

            try {
                $stm = $this->pdo->prepare($query);

                if (!empty($folio)) {
                    $stm->bindValue(":id", $folio, PDO::PARAM_INT);
                }

                $stm->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                $stm->bindValue(":apPaterno", $apP, PDO::PARAM_STR);
                $stm->bindValue(":apMaterno", $apM, PDO::PARAM_STR);
                $stm->bindValue(":domicilio", $dom, PDO::PARAM_STR);
                $stm->bindValue(":telefono", $tel, PDO::PARAM_STR);
                $stm->bindValue(":ocupacion", $ocp, PDO::PARAM_STR);
                $stm->bindValue(":nomFam", $nom_fam, PDO::PARAM_STR);
                $stm->bindValue(":telFam", $tel_fam, PDO::PARAM_STR);
                $stm->bindValue(":email", $email, PDO::PARAM_STR);
                $stm->bindValue(":fecha", $fecha, PDO::PARAM_STR);
                $stm->bindValue(":edad", $edad, PDO::PARAM_STR);
                $stm->bindValue(":ref", $ref, PDO::PARAM_STR);
                $stm->execute();

                $id = $this->pdo->lastInsertId();
                $query2 = "SELECT * FROM pacientes where id = :id;";

                $stm2 = $this->pdo->prepare($query2);
                $stm2->bindValue(":id", $id, PDO::PARAM_INT);
                $stm2->execute();

                $resultado = $stm2->fetchAll();

                if (count($resultado) === 1) {
                    $res['paciente'] = $resultado;
                    $res['estado'] = 1;
                } else {
                    $res['mensaje'] = "Usuario No hallado";
                    $res['estado'] = 0;
                }
            } catch (Exception $e) {
                $res['estado'] = 0;

                if (!$this->idExists($folio)) {
                    $res['mensaje'] = "El folio " . $folio . " ya se encuentra registrado.";
                } else {
                    $res['mensaje'] = $e->getMessage();
                }
            }
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    private function idExists($id) {
        try {
            $stm2 = $this->pdo->prepare("SELECT id FROM pacientes WHERE id = :id;");
            $stm2->bindValue(":id", $id, PDO::PARAM_INT);
            $stm2->execute();
            $resultado = $stm2->fetchAll();

            if (count($resultado) === 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    public function countPages() {
        $res = [
            'estado' => 0,
        ];

        try {
            $query = 'SELECT count(id) FROM pacientes WHERE is_paciente = "1";';
            $stm = $this->pdo->prepare($query);

            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['pages'] = ceil($resultado[0][0] / $this->pagination);
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    public function countPagesUsers() {
        $res = [
            'estado' => 0,
        ];

        try {
            $query = 'SELECT count(id) FROM pacientes WHERE is_paciente = "0";';
            $stm = $this->pdo->prepare($query);

            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['pagesUsers'] = ceil($resultado[0][0] / $this->pagination);
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    public function getPacientes($page = 1) {
        $res['estado'] = 0;
        try {
            $from = (($page - 1) * $this->pagination);
            if ($from < 0) {
                $from = 0;
            }
            $query = "SELECT * FROM pacientes WHERE is_paciente = 1 ORDER BY apPaterno ASC LIMIT :from, :to;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":from", $from, PDO::PARAM_INT );
            $stm->bindValue(":to", $this->pagination, PDO::PARAM_INT );
            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['pacientes'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
            $res['estado'] = 0;
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    public function getPacientesPrimera($page = 1) {
        $res['estado'] = 0;
        try {
            $from = (($page - 1) * $this->pagination);
            if ($from < 0) {
                $from = 0;
            }
            $query = "SELECT * FROM pacientes WHERE is_paciente = 0 ORDER BY apPaterno ASC LIMIT :from, :to;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":from", $from, PDO::PARAM_INT );
            $stm->bindValue(":to", $this->pagination, PDO::PARAM_INT );
            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['pacientes'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
            $res['estado'] = 0;
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    public function updatePaciente($data) {
        $res['estado'] = 0;
        if (empty($data['nombre']) || empty($data['apP']) || empty($data['dom']) || empty($data['tel'])) {
            $res['estado'] = 0;
            if (empty($data['nombre'])) { $res['mensaje'] = "Ingresa un nombre";}
            if (empty($data['apP'])) { $res['mensaje'] = "Ingresa un apellido paterno";}
            if (empty($data['dom'])) { $res['mensaje'] = "Ingresa un domicilio";}
            if (empty($data['tel'])) { $res['mensaje'] = "Ingresa un número de teléfono";}
        } else {
            try {
                if ($data['id'] != $data['new_id']) {
                    if ($this->validateIdPaciente($data['new_id'])) {
                        $query = "UPDATE pacientes SET 
                            id = :new_id,
                            nombre = :nombre,
                            apPaterno = :apPaterno,
                            apMaterno = :apMaterno,
                            domicilio = :domicilio,
                            telefono = :telefono,
                            ocupacion = :ocupacion,
                            nombreFamiliar = :nombreFamiliar,
                            telefonoFamiliar = :telefonoFamiliar,
                            email = :email,
                            fecha_nacimiento = :fecha_nacimiento,
                            edad = :edad,
                            referencia = :referencia,
                            updated_at = now(),
                            user_update_id = :user_update_id
                            WHERE id=:id;";

                        $stm = $this->pdo->prepare($query);

                        $stm->bindParam(":id", $data['id'], PDO::PARAM_INT);
                        $stm->bindParam(":new_id", $data['new_id'], PDO::PARAM_INT);
                        $stm->bindValue(":nombre", $data['nombre'], PDO::PARAM_STR);
                        $stm->bindValue(":apPaterno", $data['apP'], PDO::PARAM_STR);
                        $stm->bindValue(":apMaterno", $data['apM'], PDO::PARAM_STR);
                        $stm->bindValue(":domicilio", $data['dom'], PDO::PARAM_STR);
                        $stm->bindValue(":telefono", $data['tel'], PDO::PARAM_STR);
                        $stm->bindValue(":ocupacion", $data['ocp'], PDO::PARAM_STR);
                        $stm->bindValue(":nombreFamiliar", $data['nom_fam'], PDO::PARAM_STR);
                        $stm->bindValue(":telefonoFamiliar", $data['tel_fam'], PDO::PARAM_STR);
                        $stm->bindValue(":email", $data['email'], PDO::PARAM_STR);
                        $stm->bindValue(":fecha_nacimiento", $data['fecha'], PDO::PARAM_STR);
                        $stm->bindValue(":edad", $data['edad'], PDO::PARAM_INT);
                        $stm->bindValue(":referencia", $data['ref'], PDO::PARAM_STR);
                        $stm->bindValue(":user_update_id", $_SESSION["Id"], PDO::PARAM_INT);
                        $stm->execute();

                        $query = "UPDATE antecedentes SET paciente_id=:new_id WHERE paciente_id=:id;";
                        $stm2 = $this->pdo->prepare($query);
                        $stm2->bindParam(":id", $data['id'], PDO::PARAM_INT);
                        $stm2->bindParam(":new_id", $data['new_id'], PDO::PARAM_INT);
                        $stm2->execute();

                        $query = "UPDATE citas SET pacientes_id=:new_id WHERE pacientes_id=:id;";
                        $stm3 = $this->pdo->prepare($query);
                        $stm3->bindParam(":id", $data['id'], PDO::PARAM_INT);
                        $stm3->bindParam(":new_id", $data['new_id'], PDO::PARAM_INT);
                        $stm3->execute();

                        $query = "UPDATE documentos SET paciente_id=:new_id WHERE paciente_id=:id;";
                        $stm4 = $this->pdo->prepare($query);
                        $stm4->bindParam(":id", $data['id'], PDO::PARAM_INT);
                        $stm4->bindParam(":new_id", $data['new_id'], PDO::PARAM_INT);
                        $stm4->execute();

                        $query = "UPDATE observaciones SET paciente_id=:new_id WHERE paciente_id=:id;";
                        $stm5 = $this->pdo->prepare($query);
                        $stm5->bindParam(":id", $data['id'], PDO::PARAM_INT);
                        $stm5->bindParam(":new_id", $data['new_id'], PDO::PARAM_INT);
                        $stm5->execute();

                        $query = "UPDATE pagos SET pacientes_id=:new_id WHERE pacientes_id=:id;";
                        $stm6 = $this->pdo->prepare($query);
                        $stm6->bindParam(":id", $data['id'], PDO::PARAM_INT);
                        $stm6->bindParam(":new_id", $data['new_id'], PDO::PARAM_INT);
                        $stm6->execute();

                        $query = "UPDATE presupuestos SET pacientes_id=:new_id WHERE pacientes_id=:id;";
                        $stm7 = $this->pdo->prepare($query);
                        $stm7->bindParam(":id", $data['id'], PDO::PARAM_INT);
                        $stm7->bindParam(":new_id", $data['new_id'], PDO::PARAM_INT);
                        $stm7->execute();

                        $query = "UPDATE relacion_medico_paciente SET id_paciente=:new_id WHERE id_paciente=:id;";
                        $stm8 = $this->pdo->prepare($query);
                        $stm8->bindParam(":id", $data['id'], PDO::PARAM_INT);
                        $stm8->bindParam(":new_id", $data['new_id'], PDO::PARAM_INT);
                        $stm8->execute();

                        $res['id'] = $data['id'];
                        $res['estado'] = 1;
                    } else {
                        $res['mensaje'] = "El nuevo folio ingresado es incorrecto o ya se encuentra en uso";
                    }
                } else {
                    $query = "UPDATE pacientes SET 
                        nombre = :nombre,
                        apPaterno = :apPaterno,
                        apMaterno = :apMaterno,
                        domicilio = :domicilio,
                        telefono = :telefono,
                        ocupacion = :ocupacion,
                        nombreFamiliar = :nombreFamiliar,
                        telefonoFamiliar = :telefonoFamiliar,
                        email = :email,
                        fecha_nacimiento = :fecha_nacimiento,
                        edad = :edad,
                        referencia = :referencia,
                        updated_at = now(),
                        user_update_id = :user_update_id
                        WHERE id=:id;";

                    $stm = $this->pdo->prepare($query);

                    $stm->bindParam(":id", $data['id'], PDO::PARAM_INT);
                    $stm->bindValue(":nombre", $data['nombre'], PDO::PARAM_STR);
                    $stm->bindValue(":apPaterno", $data['apP'], PDO::PARAM_STR);
                    $stm->bindValue(":apMaterno", $data['apM'], PDO::PARAM_STR);
                    $stm->bindValue(":domicilio", $data['dom'], PDO::PARAM_STR);
                    $stm->bindValue(":telefono", $data['tel'], PDO::PARAM_STR);
                    $stm->bindValue(":ocupacion", $data['ocp'], PDO::PARAM_STR);
                    $stm->bindValue(":nombreFamiliar", $data['nom_fam'], PDO::PARAM_STR);
                    $stm->bindValue(":telefonoFamiliar", $data['tel_fam'], PDO::PARAM_STR);
                    $stm->bindValue(":email", $data['email'], PDO::PARAM_STR);
                    $stm->bindValue(":fecha_nacimiento", $data['fecha'], PDO::PARAM_STR);
                    $stm->bindValue(":edad", $data['edad'], PDO::PARAM_INT);
                    $stm->bindValue(":referencia", $data['ref'], PDO::PARAM_STR);
                    $stm->bindValue(":user_update_id", $_SESSION["Id"], PDO::PARAM_INT);
                    $stm->execute();

                    $res['id'] = $data['id'];
                    $res['estado'] = 1;
                }
            } catch (Exception $e) {
                $res['mensaje'] = $e->getMessage() . " " . $e->getLine();
                $res['estado'] = 0;
            }
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    /*
     * Valida que el id/folio del paciente no este en uso
     *
     */
    private function validateIdPaciente($id) {
        $query = "SELECT id FROM pacientes WHERE id=:id;";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(":id", $id, PDO::PARAM_INT);
        $stm->execute();
        $res = $stm->fetchAll();

        return (count($res) > 0) ? false : true;
    }

    public function getCitasByDay($day) {
        $res['estado'] = 0;
        try {
            $query = "SELECT * FROM citas WHERE fecha = :fecha ORDER BY hora_ini;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":fecha", $day, PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            for ($i = 0; $i < count($resultado); $i++) {
                $resultado[$i]['tipo_cita'] = $this->getCita($resultado[$i]['tipo_cita']);
            }

            $res['estado'] = 1;
            $res['citas'] = $resultado;
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        return json_encode($res);
    }

    public function getCitasByDayCallCenter($day) {
        $res['estado'] = 0;
        try {
            $query = "SELECT c.*, p.nombre, p.apPaterno, p.apMaterno FROM citas c INNER JOIN pacientes p ON p.id=c.pacientes_id WHERE fecha = :fecha ORDER BY hora_ini;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":fecha", $day, PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            for ($i = 0; $i < count($resultado); $i++) {
                $resultado[$i]['type'] = $resultado[$i]['tipo_cita'];
                $resultado[$i]['tipo_cita'] = $this->getCita($resultado[$i]['tipo_cita']);
            }

            $res['estado'] = 1;
            $res['citas'] = $resultado;
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        return json_encode($res);
    }

    /**
     * [getCountCitasHoraByFecha regrese el contendo de citas por cada horario en un dia especifico]
     * @param  [date] $fecha [fecha a buscar]
     * @return [json]        [lista de conteos]
     */
    public function getCountCitasHoraByFecha($fecha){
        $res['estado'] = 0;
        $res['mensaje'] = "No se encontraron citas";
        
        $query = "SELECT count(hora_ini) as citasXhora, fecha,hora_ini FROM citas c WHERE fecha = :fecha GROUP BY hora_ini ORDER BY hora_ini;";
        
        $stm = $this->pdo->prepare($query);
        $stm->bindValue(':fecha',$fecha);
        $stm->execute();
        $resultado = $stm->fetchAll();

        $res['estado'] = 1;
        $res['mensaje'] = "Citas encontradas";
        $res['conteo_citas'] = $resultado;

        return json_encode($res);
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

    public function createCita($data) {
        $res['estado'] = 0;
        $paciente = $data['id_paciente'];
        if (!$this->idExists($paciente)) {

            /*  
            $tratamientoPrevio = $data['tratamiento'];
            $queryAsistencia = "SELECT COUNT(0) FROM citas WHERE asistencia = 0 AND presupuesto_id = :tratamientoPrevio";
            */

            try {
                $fecha = $data['fecha'];
                $hora = $data['hora'];
                $tipo = $data['tipo'];
                $comentario = $data['comentario'];
                $tratamiento = $data['tratamiento'];

                $query = "INSERT INTO citas (fecha, hora_ini, tipo_cita, pacientes_id, comentario, presupuesto_id,usuario_id) values (:fecha, :hora_ini, :tipo_cita, :pacientes_id, :comentario, :presupuesto_id,:usuario_id);";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":fecha", $fecha, PDO::PARAM_STR);
                $stm->bindValue(":hora_ini", $hora, PDO::PARAM_STR);
                $stm->bindValue(":tipo_cita", $tipo, PDO::PARAM_INT);
                $stm->bindValue(":pacientes_id", $paciente, PDO::PARAM_INT);
                $stm->bindValue(":comentario", $comentario, PDO::PARAM_STR);
                $stm->bindValue(":presupuesto_id", $tratamiento, PDO::PARAM_INT);
                $stm->bindValue(":usuario_id", $_SESSION["Id"], PDO::PARAM_INT);
                $stm->execute();


                $res['estado'] = 1;
                $res['id'] = $this->pdo->lastInsertId();
            } catch (Exception $ex) {
                $res['mensaje'] = $ex->getMessage();
            }
        } else {
            $res['mensaje'] = "No se encontro el folio " . $paciente;
        }
        return json_encode($res);
    }

    public function updateCita($data) {
        $res['estado'] = 0;
        $paciente = $data['id_paciente'];
        $cita = $data['id_cita'];
        if (!$this->idExists($paciente)) {
            try {
                $fecha = $data['fecha'];
                $hora = $data['hora'];
                $tipo = $data['tipo'];
                $comentario = $data['comentario'];
                $tratamiento_id = $data['tratamiento'];

                $query = "UPDATE citas SET fecha=:fecha, hora_ini=:hora_ini, tipo_cita=:tipo_cita, 
                          pacientes_id=:pacientes_id, comentario=:comentario, presupuesto_id=:presupuesto_id WHERE id=:id;";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":fecha", $fecha, PDO::PARAM_STR);
                $stm->bindValue(":hora_ini", $hora, PDO::PARAM_STR);
                $stm->bindValue(":tipo_cita", $tipo, PDO::PARAM_INT);
                $stm->bindValue(":pacientes_id", $paciente, PDO::PARAM_INT);
                $stm->bindValue(":comentario", $comentario, PDO::PARAM_STR);
                $stm->bindValue(":presupuesto_id", $tratamiento_id, PDO::PARAM_INT);
                $stm->bindValue(":id", $cita, PDO::PARAM_INT);
                $stm->execute();

                $res['estado'] = 1;
                $res['mensaje'] = "La cita se actualizó correctamente";
            } catch (Exception $ex) {
                $res['mensaje'] = $ex->getMessage();
            }
        } else {
            $res['mensaje'] = "No se encontro el folio " . $paciente;
        }
        return json_encode($res);
    }

    public function deleteCita($cita_id) {
        $res['estado'] = 0;
        try {
            $query = "DELETE FROM citas WHERE id=:id;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":id", $cita_id, PDO::PARAM_INT);
            $stm->execute();

            $res['estado'] = 1;
            $res['mensaje'] = "La cita se eliminó correctamente";
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }
        return json_encode($res);
    }

    function mostrarTiposCitas() {
        $res['estado'] = 0;
        try {

            $operacion = "SELECT * FROM tipo_citas WHERE for_paciente=1";
            $sentencia = $this->pdo->prepare($operacion);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();

            $res['estado'] = 1;
            $res['tipos'] = $resultado;
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        return json_encode($res);
    }

    public function searchByLastNameOrId($param) {
        if (empty($param)) {
            $res['estado'] = 0;
            return json_encode($res);
        }
        $query = "SELECT * FROM pacientes WHERE (id LIKE :search OR apPaterno LIKE :search or apMaterno LIKE :search or nombre LIKE :search or telefono LIKE :search) and is_paciente=1 ORDER BY apPaterno;";
        try {
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":search", "%$param%", PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            if (count($resultado) > 0) {
                $res['pacientes'] = array_values($resultado);
                $res['estado'] = 1;
            }
            else {
                $res['estado'] = 0;
            }
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage() . $query;
            $res['estado'] = 0;
        }
        return json_encode($res);
    }

    public function searchAllByLastNameOrId($param) {
        if (empty($param)) {
            $res['estado'] = 0;
            return json_encode($res);
        }
        $query = "SELECT * FROM pacientes WHERE id LIKE :search OR apPaterno LIKE :search or apMaterno LIKE :search or nombre LIKE :search or telefono LIKE :search ORDER BY apPaterno;";
        try {
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":search", "%$param%", PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            if (count($resultado) > 0) {
                $res['pacientes'] = array_values($resultado);
                $res['estado'] = 1;
            }
            else {
                $res['estado'] = 0;
            }
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage() . $query;
            $res['estado'] = 0;
        }
        return json_encode($res);
    }

    public function addPacienteAndCita($nombre, $apP, $apM, $proc, $ref, $fecha, $hora, $telefono, $telefono2, $comentario) {
        if (empty($nombre) || empty($apP) || empty($telefono)) {
            $res['estado'] = 0;
            if (empty($nombre)) { $res['mensaje'] = "Ingresa un nombre";}
            if (empty($apP)) { $res['mensaje'] = "Ingresa un apellido paterno";}
            if (empty($telefono)) { $res['mensaje'] = "Ingresa un número de teléfono";}
        } else {
            try {

                // Crea el paciente
                $query = "INSERT INTO pacientes(nombre, apPaterno, apMaterno, referencia, is_paciente, created_at, telefono, telefono2)
                  VALUES (:nombre, :apPaterno, :apMaterno, :ref, 0, now(), :telefono, :telefono2);";

                $stm = $this->pdo->prepare($query);

                $stm->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                $stm->bindValue(":apPaterno", $apP, PDO::PARAM_STR);
                $stm->bindValue(":apMaterno", $apM, PDO::PARAM_STR);
                $stm->bindValue(":ref", $ref, PDO::PARAM_STR);
                $stm->bindValue(":telefono", $telefono, PDO::PARAM_STR);
                $stm->bindValue(":telefono2", $telefono2, PDO::PARAM_STR);
                $stm->execute();

                $id = $this->pdo->lastInsertId();
                $presupuesto_id = $this->getPresupuestoID();
                $query = "INSERT INTO presupuestos (id, pacientes_id, nombre) VALUES (:id,
                    :paciente_id, :proc);";
                $stm3 = $this->pdo->prepare($query);
                $stm3->bindValue(":id", $presupuesto_id, PDO::PARAM_INT);
                $stm3->bindValue(":paciente_id", $id, PDO::PARAM_INT);
                $stm3->bindValue(":proc", $proc, PDO::PARAM_STR);
                $stm3->execute();

                // Agrega la cita
                $query = "INSERT INTO citas (fecha, hora_ini, tipo_cita, pacientes_id, comentario, presupuesto_id, usuario_id) values (
                :fecha, :hora_ini, 1, :pacientes_id, :comentario, :presupuesto_id, :usuario_id);";
                $stm2 = $this->pdo->prepare($query);
                $stm2->bindValue(":fecha", $fecha, PDO::PARAM_STR);
                $stm2->bindValue(":hora_ini", $hora, PDO::PARAM_STR);
                $stm2->bindValue(":comentario", $comentario, PDO::PARAM_STR);
                $stm2->bindValue(":presupuesto_id", $presupuesto_id, PDO::PARAM_INT);
                $stm2->bindValue(":pacientes_id", $id, PDO::PARAM_INT);
                $stm2->bindValue(":usuario_id", $_SESSION["Id"], PDO::PARAM_INT);
                $stm2->execute();

                $res['mensaje'] = "Paciente y cita creados correctamente";
                $res['estado'] = 1;
            } catch (Exception $e) {
                $res['estado'] = 0;
                $res['mensaje'] = $e->getMessage();
            }
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    private function getIdProcedimiento($proc) {
        try {
            $query = "SELECT id_cita FROM tipo_citas WHERE nombre_cita=:nombre";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":nombre", $proc, PDO::PARAM_STR);
            $stm->execute();

            $resultado = $stm->fetchAll();

            if (count($resultado) > 0) {
                return $resultado[0][0];
            } else {
                $query = "INSERT INTO tipo_citas (nombre_cita, for_paciente) VALUES (:nombre, 0);";
                $stm2 = $this->pdo->prepare($query);
                $stm2->bindValue(":nombre", $proc, PDO::PARAM_STR);
                $stm2->execute();

                return $this->pdo->lastInsertId();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function tratamientos($id) {
        $res['estado'] = 0;

        try {
            $query = "SELECT id, nombre as tratamiento, pacientes_id as paciente_id FROM presupuestos WHERE pacientes_id=:id;";

            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":id", $id, PDO::PARAM_INT);
            $stm->execute();
            $tratamientos = $stm->fetchAll();

            $res['estado'] = 1;
            $res['tratamientos'] = $tratamientos;
        } catch (Exception $e) {
            $res['estado'] = 0;
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    /*
     * Devuelve el siguiente id del presupuesto, ya que la tabla no es autoincrementable
     */
    private function getPresupuestoID() {
        $query = "SELECT MAX(id) FROM presupuestos;";
        $stm = $this->pdo->prepare($query);
        $stm->execute();
        $id = $stm->fetchAll();

        return $id[0][0]+1;
    }

    public function pacienteFirstDate($id_paciente) {
        $query = "SELECT * FROM pacientes WHERE id = :id AND is_paciente=0";
        try {
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":id", $id_paciente, PDO::PARAM_INT );
            $stm->execute();
            $resultado = $stm->fetchAll();

            if (count($resultado)===1) {
                $res['paciente'] = $resultado;
                $res['estado'] = 1;

                $query = "SELECT * FROM citas WHERE pacientes_id=:id AND tipo_cita=1;";
                $stm2 = $this->pdo->prepare($query);
                $stm2->bindValue(":id", $id_paciente, PDO::PARAM_INT );
                $stm2->execute();
                $citas = $stm2->fetchAll();

                if (count($citas) > 0) {
                    $res['cita'] = $citas;
                } else {
                    $res['cita'] = [];
                }
            }
            else{
                $res['mensaje'] = "No se encontró el paciente: " . $id_paciente;
                $res['estado'] = 0;
            }
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
            $res['estado'] = 0;
        }

        // Devuelve json como respuesta
        return json_encode($res);
    }

    public function searchByLastNameOrIdFirstDate($param) {
        if (empty($param)) {
            $res['estado'] = 0;
            return json_encode($res);
        }
        $query = "SELECT * FROM pacientes WHERE (id LIKE :search OR apPaterno LIKE :search or apMaterno LIKE :search or nombre LIKE :search or telefono LIKE :search) and is_paciente=0 ORDER BY apPaterno;";
        try {
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":search", "%$param%", PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            if (count($resultado) > 0) {
                $res['pacientes'] = array_values($resultado);
                $res['estado'] = 1;
            }
            else {
                $res['estado'] = 0;
            }
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage() . $query;
            $res['estado'] = 0;
        }
        return json_encode($res);
    }
}

if (isset($_POST['get'])) {
    if (auth()) {
        $get = $_POST['get'];
        $p = new Paciente();
        switch ($get) {
            case 'paciente':
                echo $p->getPaciente($_POST['id']);
                break;
            case 'pacienteFirstDate':
                echo $p->pacienteFirstDate($_POST['id']);
                break;
            case 'autoSearchFirstDate':
                echo $p->searchByLastNameOrIdFirstDate($_POST['param']);
                break;
            case 'pacienteFull':
                echo $p->getPacienteFull($_POST['id']);
                break;
            default:
                header("Location: " . app_url() . "404");
        }
    } else {
        return json_encode(['estado' => 0, 'mensaje' => 'Error de credenciales']);
    }
} elseif (isset($_POST['post'])) {
    if (auth()) {
        $post = $_POST['post'];
        $p = new Paciente();
        switch ($post) {
            case 'add':
                $nombre = $_POST['nombre'];
                $apP = $_POST['apP'];
                $apM = $_POST['apM'];
                $dom = $_POST['dom'];
                $tel = $_POST['tel'];
                $email = $_POST['email'];
                $fecha = $_POST['fecha'];
                $edad = $_POST['edad'];
                $ocp = $_POST['ocp'];
                $tel_fam = $_POST['tel_fam'];
                $nom_fam = $_POST['nom_fam'];
                $ref = $_POST['ref'];
                $folio = (isset($_POST['folio']) ? $_POST['folio'] : null);
                echo $p->addPaciente($nombre, $apP, $apM, $dom, $tel, $email, $fecha, $edad, $ocp, $tel_fam, $nom_fam, $ref, $folio);
                break;
            case 'pacientes':
                $page = (isset($_POST['page'])) ? $_POST['page'] : null;
                echo $p->getPacientes($page);
                break;
            case 'pacientesPrimera':
                $page = (isset($_POST['page'])) ? $_POST['page'] : null;
                echo $p->getPacientesPrimera($page);
                break;
            case 'update':
                echo $p->updatePaciente($_POST);
                break;
            case 'citas':
                echo $p->getCitasByDay($_POST['fecha']);
                break;
            case 'citasCallCenter':
                echo $p->getCitasByDayCallCenter($_POST['fecha']);
                break;
            case 'createCita':
                echo $p->createCita($_POST);
                break;
            case 'pages':
                echo $p->countPages();
                break;
            case 'pagesUsers':
                echo $p->countPagesUsers();
                break;
            case 'autoSearch':
                echo $p->searchByLastNameOrId($_POST['param']);
                break;
            case 'allSearch':
                echo $p->searchAllByLastNameOrId($_POST['param']);
                break;
            case 'addPacienteAndCita':
                echo $p->addPacienteAndCita($_POST['nombre'], $_POST['apP'], $_POST['apM'], $_POST['proc'], $_POST['ref'], $_POST['fecha'], $_POST['hora'], $_POST['telefono'], $_POST['telefono2'], $_POST['comentario']);
                break;
            case 'tratamientos':
                echo $p->tratamientos($_POST['id']);
                break;
            case 'mostrarTiposCitas':
                echo $p->mostrarTiposCitas();
                break;
            case 'updateCita':
                echo $p->updateCita($_POST);
                break;
            case 'deleteCita':
                echo $p->deleteCita($_POST['cita_id']);
                break;
            case 'getCountCitasHoraByFecha':
                echo $p->getCountCitasHoraByFecha($_POST['fecha']);
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