<?php
include dirname(__FILE__) . '/../controladores/datos/ConexionBD.php';
include dirname(__FILE__) . '/../controladores/sesion/Session.php';
include dirname(__FILE__) . '/FileUpload.php';

error_reporting(0);

if(!isset($_SESSION)){
    session_start();
}

/**
 * Created by PhpStorm.
 * User: rk521
 * Date: 2/05/17
 * Time: 08:28 AM
 */
class Medico {
    private $pdo;
    private $filesPath = '';
    private $public_url = "";
    private $maxSize = "2m";
    private $mimesType = [
        "image",
        "document",
        "text"
    ];

    /**
     * Inventario constructor.
     */
    public function __construct() {
        $this->filesPath = dirname(__DIR__) . '/uploads/';
        $this->public_url = app_url() . "uploads/";
        $this->pdo = ConexionBD::obtenerInstancia()->obtenerBD();
    }

    /*
     * Devuelve los pacientes de primera vez que asistieron a su primera
     * cita y aún no tienen un médico asignado, que se encuentran
     * "En espera"
     */
    public function pacientesEnEspera() {
        $res = ['estado' => 0];

        try {
            $query = "SELECT pacientes.id, 
                          pacientes.nombre,
                          pacientes.apPaterno,
                          pacientes.apMaterno,
                          presupuestos.nombre as tratamiento, 
                          citas.hora_ini from 
                      ((citas INNER JOIN pacientes ON citas.pacientes_id=pacientes.id) 
                      INNER JOIN presupuestos ON citas.pacientes_id=presupuestos.pacientes_id) 
                      WHERE citas.asistencia = 3 AND citas.tipo_cita=1;";
            $stm = $this->pdo->prepare($query);

            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['pacientes'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Un médico atiende a un paciente
     */
    public function atender($paciente_id, $medico_id = null) {
        $res = ['estado' => 0];
        try {
            if ($medico_id == null) {
                if ($this->checkPermisos()) {
                    $query = "SELECT id FROM pacientes WHERE id=:id;";
                    $stm = $this->pdo->prepare($query);
                    $stm->bindValue(":id", $paciente_id, PDO::PARAM_INT);
                    $stm->execute();

                    if ($stm->rowCount() > 0) {
                        $query = "INSERT INTO relacion_medico_paciente (id_medico_principal, id_paciente) VALUES (:id_medico, :id_paciente);";
                        $stm2 = $this->pdo->prepare($query);
                        $stm2->bindValue(":id_medico", $_SESSION["Id"], PDO::PARAM_INT);
                        $stm2->bindValue(":id_paciente", $paciente_id, PDO::PARAM_INT);
                        $stm2->execute();

                        $this->removeFromListaEspera($paciente_id);

                        $res['estado'] = 1;
                        $res['mensaje'] = "Se agrego el paciente a su lista de pacientes";
                    } else {
                        $res['mensaje'] = "No se encontró el paciente: " . $paciente_id;
                    }
                } else {
                    $res['mensaje'] = "No cuentas con los permisos correspondientes";
                }
            } else {
                $query = "SELECT id FROM pacientes WHERE id=:id;";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":id", $paciente_id, PDO::PARAM_INT);
                $stm->execute();

                if ($stm->rowCount() > 0) {
                    $query = "INSERT INTO relacion_medico_paciente (id_medico_principal, id_paciente) VALUES (:id_medico, :id_paciente);";
                    $stm2 = $this->pdo->prepare($query);
                    $stm2->bindValue(":id_medico", $medico_id, PDO::PARAM_INT);
                    $stm2->bindValue(":id_paciente", $paciente_id, PDO::PARAM_INT);
                    $stm2->execute();

                    $this->removeFromListaEspera($paciente_id);

                    $res['estado'] = 1;
                    $res['mensaje'] = "Se agrego el paciente a su lista de pacientes";
                } else {
                    $res['mensaje'] = "No se encontró el paciente: " . $paciente_id;
                }
            }
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Devuelve los pacientes que tiene asignado un médico
     */
    public function misPacientes() {
        $res = ['estado' => 0];
        try {
            if ($this->checkPermisos()) {
                $query = "SELECT 
                              pacientes.id, pacientes.nombre, pacientes.apPaterno, pacientes.apMaterno, 
                              pacientes.telefono
                          FROM relacion_medico_paciente 
                          INNER JOIN pacientes ON pacientes.id=relacion_medico_paciente.id_paciente 
                          WHERE id_medico_principal=:id OR id_medico_secundario=:id;";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":id", $_SESSION["Id"], PDO::PARAM_INT);
                $stm->execute();
                $resultado = $stm->fetchAll(PDO::FETCH_OBJ);

                $res['estado'] = 1;
                $res['pacientes'] = $resultado;
            } else {
                $res['mensaje'] = "No cuentas con los permisos correspondientes";
            }
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }
    //pacientes en espera
    public function misPacientesEspera() {
        $res = ['estado' => 0];
        try {
            if ($this->checkPermisos()) {
                $query = "SELECT pacientes.id, 
                          pacientes.nombre,
                          pacientes.apPaterno,
                          pacientes.apMaterno,
                          presupuestos.nombre as tratamiento, 
                          citas.hora_ini from 
                      ((citas INNER JOIN pacientes ON citas.pacientes_id=pacientes.id) INNER JOIN
                      relacion_medico_paciente ON pacientes.id = relacion_medico_paciente.id_paciente) 
                      INNER JOIN presupuestos ON citas.pacientes_id=presupuestos.pacientes_id 
                      WHERE (citas.asistencia = 3 AND citas.tipo_cita=1) AND (id_medico_principal=:id OR id_medico_secundario=:id);";

                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":id", $_SESSION["Id"], PDO::PARAM_INT);
                $stm->execute();
                $resultado = $stm->fetchAll(PDO::FETCH_OBJ);

                $res['estado'] = 1;
                $res['pacientes'] = $resultado;
            } else {
                $res['mensaje'] = "No cuentas con los permisos correspondientes";
            }
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Devuelve el detalle de procedimientos y citas de la función misPacientes
     */
    public function detalleMiPaciente($paciente_id) {
        $res = ['estado' => 0];
        try {
            if ($this->checkPermisos()) {
                $query = "SELECT id, nombre as tratamiento, pacientes_id as paciente_id FROM presupuestos WHERE pacientes_id=:id;";
                $stm2 = $this->pdo->prepare($query);
                $stm2->bindValue(":id", $paciente_id);
                $stm2->execute();
                $procedimientos = $stm2->fetchAll(PDO::FETCH_OBJ);

                foreach ($procedimientos as $procedimiento) {
                    $query2 = "SELECT * from
                              (
                                (SELECT fecha FROM citas WHERE presupuesto_id=:id AND fecha < now() ORDER BY fecha DESC LIMIT 0,1) AS col1,
                                (SELECT fecha FROM citas WHERE presupuesto_id=:id AND fecha > now() ORDER BY fecha ASC LIMIT 0,1) AS col2
                              );";
                    $stm3 = $this->pdo->prepare($query2);
                    $stm3->bindValue(":id", $procedimiento->id);
                    $stm3->execute();
                    $ultimaCita = $stm3->fetchAll();

                    $procedimiento->last_date = $ultimaCita[0][0];
                    $procedimiento->next_date = $ultimaCita[0][1];
                }

                $res['estado'] = 1;
                $res['procedimientos'] = $procedimientos;
            } else {
                $res['mensaje'] = "No cuentas con los permisos correspondientes";
            }
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Cuando un médico ya decidio atender a un paciente lo remueve de
     * la lista de en espera
     */
    private function removeFromListaEspera($paciente_id) {
        $query = "UPDATE citas SET asistencia=1 WHERE tipo_cita = 1 AND pacientes_id = :id";
        $stm = $this->pdo->prepare($query);
        $stm->bindValue(":id", $paciente_id, PDO::PARAM_STR);
        $stm->execute();
    }

    /*
     * Primera parte del expediente, devuelve solamente:
     * - Resumen del paciente
     * - Antecedentes
     * - Historial
     */
    public function getExpediente1($paciente_id) {
        $res = ['estado' => 0];
        try {
            if ($this->checkPermisos()) {
                $query = "SELECT * FROM pacientes WHERE id = :id";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":id", $paciente_id, PDO::PARAM_INT );
                $stm->execute();
                $resultado = $stm->fetchAll();

                if (count($resultado)===1) {
                    $query = "SELECT * FROM antecedentes WHERE paciente_id = :id;";
                    $stm7 = $this->pdo->prepare($query);
                    $stm7->bindValue(":id", $paciente_id, PDO::PARAM_INT );
                    $stm7->execute();
                    $antecedentes = $stm7->fetchAll(PDO::FETCH_OBJ);

                    $res['paciente'] = $resultado[0];
                    $res['historial'] = $this->getHistorial($paciente_id);
                    $res['antecedentes'] = $antecedentes;
                    $res['estado'] = 1;
                }
                else {
                    $res['mensaje'] = "No se encontró el paciente: " . $paciente_id;
                }
            } else {
                $res['mensaje'] = "No cuentas con los permisos correspondientes";
            }
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Segunda parte del expediente, devuelve solamente:
     * - Los presupuestos
     */
    public function getExpediente2($paciente_id) {
        $res = ['estado' => 0];
        try {
            if ($this->checkPermisos()) {
                $query = "SELECT * FROM pacientes WHERE id = :id";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":id", $paciente_id, PDO::PARAM_INT );
                $stm->execute();
                $resultado = $stm->fetchAll();

                if (count($resultado)===1) {
                    $query = "SELECT presupuestos.* FROM presupuestos WHERE pacientes_id=:id";
                    $stm4 = $this->pdo->prepare($query);
                    $stm4->bindValue(":id", $paciente_id, PDO::PARAM_INT );
                    $stm4->execute();
                    $presupuestos = $stm4->fetchAll(PDO::FETCH_OBJ);

                    foreach ($presupuestos as $presupuesto) {
                        $presupuesto->tratamiento = 0;
                        $presupuesto->cirugia = 0;
                        $presupuesto->no_iniciado = 0;
                        $presupuesto->caducado = 0;

                        if ($presupuesto->tipo == 1) {
                            $presupuesto->tratamiento = 1;
                        } elseif ($presupuesto->tipo == 2) {
                            $presupuesto->cirugia = 1;
                        }

                        $query = "select SUM(monto) from pagos where id_presupuesto=:id;";
                        $stm5 = $this->pdo->prepare($query);
                        $stm5->bindValue(":id", $presupuesto->id);
                        $stm5->execute();
                        $pagado = $stm5->fetchAll();
                        $total_pagado = ( is_numeric($pagado[0][0]) ) ? $pagado[0][0] : 0;

                        if ($total_pagado > 0) {
                            $presupuesto->no_iniciado = 1;
                        }

                        $today = date("Y-m-d");
                        if ($presupuesto->vigencia < $today) {
                            $presupuesto->caducado = 1;
                        }
                    }

                    $res['presupuestos'] = $presupuestos;
                    $res['estado'] = 1;
                }
                else {
                    $res['mensaje'] = "No se encontró el paciente: " . $paciente_id;
                }
            } else {
                $res['mensaje'] = "No cuentas con los permisos correspondientes";
            }
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Tercera parte del expediente, devuelve solamente:
     * - Las Observaciones
     */
    public function getExpediente3($paciente_id) {
        $res = ['estado' => 0];
        try {
            if ($this->checkPermisos()) {
                $query = "SELECT * FROM pacientes WHERE id = :id";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":id", $paciente_id, PDO::PARAM_INT );
                $stm->execute();
                $resultado = $stm->fetchAll();

                if (count($resultado)===1) {
                    $query = "SELECT observaciones.*, usuarios.nombre, usuarios.apPaterno, usuarios.apMaterno FROM observaciones INNER JOIN usuarios ON observaciones.medico_id=usuarios.id WHERE observaciones.paciente_id = :id ORDER BY observaciones.created_at DESC;";
                    $stm6 = $this->pdo->prepare($query);
                    $stm6->bindValue(":id", $paciente_id, PDO::PARAM_INT );
                    $stm6->execute();
                    $observaciones = $stm6->fetchAll(PDO::FETCH_OBJ);

                    $res['observaciones'] = $observaciones;
                    $res['estado'] = 1;
                }
                else {
                    $res['mensaje'] = "No se encontró el paciente: " . $paciente_id;
                }
            } else {
                $res['mensaje'] = "No cuentas con los permisos correspondientes";
            }
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Agrega una observación a un paciente
     */
    public function addObservacion($paciente_id, $observacion) {
        $res = ['estado' => 0];

        try {
            if (!empty($observacion)) {
                if ($this->checkPermisos()) {
                    $query = "SELECT * FROM pacientes WHERE id = :id";
                    $stm = $this->pdo->prepare($query);
                    $stm->bindValue(":id", $paciente_id, PDO::PARAM_INT);
                    $stm->execute();
                    $resultado = $stm->fetchAll();

                    if (count($resultado) === 1) {
                        $query = "INSERT INTO observaciones (medico_id, paciente_id, observacion) VALUES (:medico_id, :paciente_id, :observacion);";
                        $stm2 = $this->pdo->prepare($query);
                        $stm2->bindValue(":medico_id", $_SESSION['Id'], PDO::PARAM_INT);
                        $stm2->bindValue(":paciente_id", $paciente_id, PDO::PARAM_INT);
                        $stm2->bindValue(":observacion", $observacion, PDO::PARAM_INT);
                        $stm2->execute();

                        $res['mensaje'] = "La observación se guardo correctamente";
                        $res['estado'] = 1;
                    } else {
                        $res['mensaje'] = "No se encontró el paciente: " . $paciente_id;
                    }
                } else {
                    $res['mensaje'] = "No cuentas con los permisos correspondientes";
                }
            } else {
                $res['mensaje'] = "Ingresa una observación";
            }
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Agrega o actualiza los antecedentes de un paciente
     */
    public function addAntecedentes($data) {
        $res = ['estado' => 0];
        $paciente_id = $data['paciente_id'];
        $quirurgicos = $data['quirurgicos'];
        $alergicos = $data['alergicos'];
        $anestecia = $data['anestecia'];
        $padecimientos = $data['padecimientos'];
        $medicamentos = $data['medicamentos'];
        $tabaquismo = $data['tabaquismo'];
        $otro = $data['otro'];

        try {
            if ($this->checkPermisos()) {
                $query = "SELECT * FROM antecedentes WHERE paciente_id = :id";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":id", $paciente_id, PDO::PARAM_INT);
                $stm->execute();
                $resultado = $stm->fetchAll();

                if (count($resultado) > 0) {
                    // Update
                    $this->updateAntecedentes($paciente_id, $quirurgicos, $alergicos, $anestecia, $padecimientos, $medicamentos, $tabaquismo, $otro);
                    $res['mensaje'] = "Los antecedentes se actualizaron correctamente";
                    $res['estado'] = 1;
                } else {
                    // Create
                    $this->createAntecedentes($paciente_id, $quirurgicos, $alergicos, $anestecia, $padecimientos, $medicamentos, $tabaquismo, $otro);
                    $res['mensaje'] = "Los antecedentes se guardaron correctamente";
                    $res['estado'] = 1;
                }
            } else {
                $res['mensaje'] = "No cuentas con los permisos correspondientes";
            }
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Si el paciente no tiene antecedentes previos, los crea
     */
    private function createAntecedentes($paciente_id, $quirurgicos, $alergicos, $anestecia, $padecimientos, $medicamentos, $tabaquismo, $otro) {
        $query = "INSERT INTO antecedentes (
                    paciente_id, medico_id, quirurgicos, alergicos, anestecia, padecimientos, medicamentos, tabaquismo, otro
                  ) VALUES (
                    :paciente_id, :medico_id, :quirurgicos, :alergicos, :anestecia, :padecimientos, :medicamentos, :tabaquismo, :otro
                  )";
        $stm = $this->pdo->prepare($query);
        $stm->bindValue(":paciente_id", $paciente_id, PDO::PARAM_INT);
        $stm->bindValue(":medico_id", $_SESSION['Id'], PDO::PARAM_INT);
        $stm->bindValue(":quirurgicos", $quirurgicos, PDO::PARAM_STR);
        $stm->bindValue(":alergicos", $alergicos, PDO::PARAM_STR);
        $stm->bindValue(":anestecia", $anestecia, PDO::PARAM_STR);
        $stm->bindValue(":padecimientos", $padecimientos, PDO::PARAM_STR);
        $stm->bindValue(":medicamentos", $medicamentos, PDO::PARAM_STR);
        $stm->bindValue(":tabaquismo", $tabaquismo, PDO::PARAM_STR);
        $stm->bindValue(":otro", $otro, PDO::PARAM_STR);
        $stm->execute();
    }

    /*
     * Si el paciente ya tiene antecedentes, solo los actualiza
     */
    private function updateAntecedentes($paciente_id, $quirurgicos, $alergicos, $anestecia, $padecimientos, $medicamentos, $tabaquismo, $otro) {
        $query = "UPDATE antecedentes SET 
                    medico_id=:medico_id,
                    quirurgicos=:quirurgicos, 
                    alergicos=:alergicos, 
                    anestecia=:anestecia, 
                    padecimientos=:padecimientos, 
                    medicamentos=:medicamentos, 
                    tabaquismo=:tabaquismo, 
                    otro=:otro
                  WHERE paciente_id=:paciente_id;
                  ";
        $stm = $this->pdo->prepare($query);
        $stm->bindValue(":paciente_id", $paciente_id, PDO::PARAM_INT);
        $stm->bindValue(":medico_id", $_SESSION['Id'], PDO::PARAM_INT);
        $stm->bindValue(":quirurgicos", $quirurgicos, PDO::PARAM_STR);
        $stm->bindValue(":alergicos", $alergicos, PDO::PARAM_STR);
        $stm->bindValue(":anestecia", $anestecia, PDO::PARAM_STR);
        $stm->bindValue(":padecimientos", $padecimientos, PDO::PARAM_STR);
        $stm->bindValue(":medicamentos", $medicamentos, PDO::PARAM_STR);
        $stm->bindValue(":tabaquismo", $tabaquismo, PDO::PARAM_STR);
        $stm->bindValue(":otro", $otro, PDO::PARAM_STR);
        $stm->execute();
    }

    /*
     * Subir documentos al servidor
     */
    public function loadDocumentos($data) {
        $res = ['estado' => 0];

        if (empty($data['paciente_id']) || empty($data['select_presupuesto']) || empty($data['nombre_documento']) || empty($data['tipo_expediente'])) {
            if (empty($data['paciente_id'])) { $res['mensaje'] = "Asigna un paciente"; }
            if (empty($data['select_presupuesto'])) { $res['mensaje'] = "Asigna un presupuesto"; }
            if (empty($data['nombre_documento'])) { $res['mensaje'] = "Ingresa un nombre de documento"; }
            if (empty($data['tipo_expediente'])) { $res['mensaje'] = "Asigna un Expediente"; }
        } else {
            try {
                if ($this->checkPermisos()) {
                    $f = new FileUpload();
                    $f->setAllowMimeType($this->mimesType);
                    $f->setAutoFilename();
                    $f->setMaxFileSize($this->maxSize);
                    $f->setDestinationDirectory($this->filesPath);
                    $f->setInput("buscar_documento");

                    $f->save();

                    if ($f->getStatus()) {
                        $url = $this->public_url . $f->getInfo()->filename;
                        $query = "INSERT INTO documentos (paciente_id, medico_id, presupuesto_id, nombre, expediente, descripcion, url) 
                          VALUES (:paciente_id, :medico_id, :presupuesto_id, :nombre, :expediente, :descripcion, :url)";
                        $stm = $this->pdo->prepare($query);
                        $stm->bindValue(":paciente_id", $data['paciente_id'], PDO::PARAM_INT);
                        $stm->bindValue(":medico_id", $_SESSION['Id'], PDO::PARAM_INT);
                        $stm->bindValue(":presupuesto_id", $data['select_presupuesto'], PDO::PARAM_INT);
                        $stm->bindValue(":nombre", $data['nombre_documento'], PDO::PARAM_INT);
                        $stm->bindValue(":expediente", $data['tipo_expediente'], PDO::PARAM_INT);
                        $stm->bindValue(":descripcion", $data['descripcion_documento'], PDO::PARAM_STR);
                        $stm->bindValue(":url", $url, PDO::PARAM_STR);
                        $stm->execute();

                        $res['estado'] = 1;
                        $res['mensaje'] = "El documento se guardo correctamente";
                    } else {
                        if ($f->getInfo()->error > 0) {
                            $res['mensaje'] = $f->getInfo()->log[3];
                        } else {
                            $res['mensaje'] = "Ocurrio un error al cargar el documento";
                        }
                    }
                } else {
                    $res['mensaje'] = "No cuentas con los permisos correspondientes";
                }
            } catch (Exception $e) {
                $res['mensaje'] = $e->getMessage();
            }
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Subir otros documentos al servidor
     */
    public function loadOtrosDocumentos($data) {
        $res = ['estado' => 0];

        if (empty($data['paciente_id']) || empty($data['nombre_otro_documento']) ) {
            if (empty($data['paciente_id'])) { $res['mensaje'] = "Asigna un paciente"; }
            if (empty($data['nombre_otro_documento'])) { $res['mensaje'] = "Ingresa un nombre de documento"; }
        } else {
            try {
                if ($this->checkPermisos()) {
                    $f = new FileUpload();
                    $f->setAllowMimeType($this->mimesType);
                    $f->setAutoFilename();
                    $f->setMaxFileSize($this->maxSize);
                    $f->setDestinationDirectory($this->filesPath);
                    $f->setInput("buscar_otro_documento");

                    $f->save();

                    if ($f->getStatus()) {
                        $query = "INSERT INTO expedientes_catalogo (tipo_expediente, nombre_expediente) 
                          VALUES (0, :nombre)";
                        $stm2 = $this->pdo->prepare($query);
                        $stm2->bindValue(":nombre", $data['nombre_otro_documento'], PDO::PARAM_INT);
                        $stm2->execute();
                        $nombre = $this->pdo->lastInsertId();

                        $url = $this->public_url . $f->getInfo()->filename;
                        $query = "INSERT INTO documentos (paciente_id, medico_id, nombre, descripcion, url) 
                          VALUES (:paciente_id, :medico_id, :nombre, :descripcion, :url)";
                        $stm = $this->pdo->prepare($query);
                        $stm->bindValue(":paciente_id", $data['paciente_id'], PDO::PARAM_INT);
                        $stm->bindValue(":medico_id", $_SESSION['Id'], PDO::PARAM_INT);
                        $stm->bindValue(":nombre", $nombre, PDO::PARAM_INT);
                        $stm->bindValue(":descripcion", $data['descripcion_otro_documento'], PDO::PARAM_STR);
                        $stm->bindValue(":url", $url, PDO::PARAM_STR);
                        $stm->execute();

                        $res['estado'] = 1;
                        $res['mensaje'] = "El documento se guardo correctamente";
                    } else {
                        if ($f->getInfo()->error > 0) {
                            $res['mensaje'] = $f->getInfo()->log[3];
                        } else {
                            $res['mensaje'] = "Ocurrio un error al cargar el documento";
                        }
                    }
                } else {
                    $res['mensaje'] = "No cuentas con los permisos correspondientes";
                }
            } catch (Exception $e) {
                $res['mensaje'] = $e->getMessage();
            }
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function getDocumentos($paciente_id) {
        $res = ['estado' => 0];

        try {
            if ($this->checkPermisos()) {
                $query = "select 
                            d.id, d.url, d.created_at, d.descripcion, d.expediente as e, d.nombre as n,
                            /*e.nombre_expediente,*/ u.nombre, u.apPaterno, u.apMaterno
                          from /*((*/documentos d 
                            inner join usuarios u on d.medico_id=u.id/*)*/
                            /*inner join expedientes_catalogo e on d.expediente=e.tipo_expediente)*/
                          where d.paciente_id=:id;";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":id", $paciente_id, PDO::PARAM_INT);
                $stm->execute();
                $resultado = $stm->fetchAll(PDO::FETCH_OBJ);

                foreach ($resultado as $r) {
                    $query = "select nombre_expediente
                              from expedientes_catalogo where id_expediente=:id;";
                    $stm2 = $this->pdo->prepare($query);
                    $stm2->bindValue(":id", $r->n, PDO::PARAM_INT);
                    $stm2->execute();
                    $resultado2 = $stm2->fetchAll();

                    $r->nombre_expediente = $resultado2[0][0];
                    $r->expediente = $this->parseTipoExpediente($r->e);
                }

                $res['documentos'] = $resultado;
                $res['estado'] = 1;
            } else {
                $res['mensaje'] = "No cuentas con los permisos correspondientes";
            }
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    private function parseTipoExpediente($ex) {
        $ex = (int)$ex;
        switch ($ex) {
            case 1:
                $res = "Laboratorios";
                break;
            case 2:
                $res = "Estudio Anexo / Complementario";
                break;
            case 3:
                $res = "Valoración Cirujano";
                break;
            case 4:
                $res = "Valoración Cardiólogo";
                break;
            case 5:
                $res = "Interconsulta";
                break;
            default:
                $res = "";
                break;
        }

        return $res;
    }
    /*
     * Devuelve el historial de procedimientos y citas de un paciente
     */
    private function getHistorial($paciente_id) {
        try {
            $query = "SELECT id, nombre, numero_sesiones, precio, porcentaje_operacion FROM presupuestos WHERE pacientes_id=:id;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":id", $paciente_id, PDO::PARAM_INT);
            $stm->execute();

            $presupuestos = $stm->fetchAll(PDO::FETCH_OBJ);
            if (count($presupuestos) > 0) {
                foreach ($presupuestos as $presupuesto) {
                    $query2 = "SELECT * from
                              (
                                (SELECT fecha FROM citas WHERE presupuesto_id=:id AND fecha < now() ORDER BY fecha DESC LIMIT 0,1) AS col1,
                                (SELECT fecha FROM citas WHERE presupuesto_id=:id AND fecha > now() ORDER BY fecha ASC LIMIT 0,1) AS col2,
                                (SELECT SUM(monto) from pagos where id_presupuesto=:id) AS col3
                              );";
                    $stm3 = $this->pdo->prepare($query2);
                    $stm3->bindValue(":id", $presupuesto->id);
                    $stm3->execute();
                    $citas = $stm3->fetchAll();

                    $presupuesto->last_date = $citas[0][0];
                    $presupuesto->next_date = $citas[0][1];
                    $presupuesto->pagado = ( is_numeric($citas[0][2]) ) ? $citas[0][2] : 0;

                    if ($presupuesto->pagado > 0) {
                        $presupuesto->porcentajePagado = ($presupuesto->pagado * 100) / $presupuesto->precio;
                    } else {
                        $presupuesto->porcentajePagado = 0;
                    }

                    $presupuesto->porcentajeRestante = 100 - $presupuesto->porcentajePagado;

                    $presupuesto->restante = $presupuesto->precio - $presupuesto->pagado;
                }
            } else {
                $presupuestos = [];
            }
        } catch (Exception $ex) {
            $presupuestos = $ex->getMessage();
        }

        return $presupuestos;
    }

    /*
     * Crea un nuevo presupuesto para un paciente
     */
    public function createPresupuesto($data) {
        $res = ['estado' => 0];

        $user_id = $data['user_id'];
        $nombre = $data['nombre'];
        $tipo = $data['tipo'];
        $descripcion = $data['descripcion'];
        $numero_sesiones = $data['numero_sesiones'];
        $precio = $data['precio'];
        $promocion = $data['promocion'];
        $contado = $data['contado'];
        $vigencia = $data['vigencia'];

        if ($user_id == null || $nombre == null || $tipo == null || $descripcion == null || $numero_sesiones == null
            || $precio == null || $promocion == null || $contado == null || $vigencia == null) {

            $res['mensaje'] = "Completa todos los campos";
        } else {
            try {
                if ($this->checkPermisos()) {
                    $query = "SELECT * FROM pacientes WHERE id=:user_id;";
                    $stm = $this->pdo->prepare($query);
                    $stm->bindValue(":user_id", $user_id, PDO::PARAM_INT);
                    $stm->execute();
                    $resultado = $stm->fetchAll();

                    if (count($resultado) == 0) {
                        $res['mensaje'] = "No se encontro el folio: " . $user_id;
                    } else {
                        $id = $this->getPresupuestoID();
                        $query = "INSERT INTO presupuestos (id, nombre, tipo, descripcion, numero_sesiones, precio, promocion,
                              contado, vigencia, pacientes_id) VALUES (:id, :nombre, :tipo, :descripcion, :numero_sesiones,
                              :precio, :promocion, :contado, :vigencia, :user_id);";

                        $stm = $this->pdo->prepare($query);
                        $stm->bindValue(":id", $id, PDO::PARAM_INT);
                        $stm->bindValue(":nombre", $nombre, PDO::PARAM_STR);
                        $stm->bindValue(":tipo", $tipo, PDO::PARAM_INT);
                        $stm->bindValue(":descripcion", $descripcion, PDO::PARAM_STR);
                        $stm->bindValue(":numero_sesiones", $numero_sesiones, PDO::PARAM_INT);
                        $stm->bindValue(":precio", $precio, PDO::PARAM_STR);
                        $stm->bindValue(":promocion", $promocion, PDO::PARAM_STR);
                        $stm->bindValue(":contado", $contado, PDO::PARAM_STR);
                        $stm->bindValue(":vigencia", $vigencia, PDO::PARAM_STR);
                        $stm->bindValue(":user_id", $user_id, PDO::PARAM_INT);
                        $stm->execute();
                        $id = $this->pdo->lastInsertId();

                        $res['estado'] = 1;
                        $res['mensaje'] = "Presupuesto creado correctamente.";
                        $res['id'] = $id;
                    }
                } else {
                    $res['mensaje'] = "No cuentas con los permisos correspondientes";
                }
            } catch (Exception $e) {
                $res['mensaje'] = $e->getMessage();
            }
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Elimina el presupuesto de un paciente
     */
    public function deletePresupuesto($presupuesto_id) {
        $res = ['estado' => 0];
        try {
            if ($this->checkPermisos()) {
                $query = "DELETE FROM presupuestos WHERE id=:id;";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":id", $presupuesto_id, PDO::PARAM_INT);
                $stm->execute();

                $res['estado'] = 1;
                $res['mensaje'] = "El presupuesto se eliminó correctamente.";
            } else {
                $res['mensaje'] = "No cuentas con los permisos correspondientes";
            }
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
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

    public function deleteFile($id) {
        $res = ['estado' => 0];

        try {
            if ($this->checkPermisos()) {
                $query = "SELECT url FROM documentos WHERE id=:id";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":id", $id, PDO::PARAM_INT);
                $stm->execute();
                $resultado = $stm->fetchAll();

                $name = basename($resultado[0][0]);

                $query = "DELETE FROM documentos WHERE id=:id";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":id", $id, PDO::PARAM_INT);
                $stm->execute();

                unlink($this->filesPath . $name);

                $res['mensaje'] = "El documento se elimino correctamente";
                $res['estado'] = 1;
            } else {
                $res['mensaje'] = "No cuentas con los permisos correspondientes";
            }
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Valida los accesos correctos para el usuario y el tipo de usuario
     */
    private function checkPermisos() {
        return ($_SESSION["accesos_medico"] == 1) ? true : false;
    }

    /*
     * Devuelve el número de pacientes en espera
     */
    public function countEnEspera() {
        $res = ['estado' => 0];

        try {
            $query = "SELECT count(pacientes.id) from 
                      ((citas INNER JOIN pacientes ON citas.pacientes_id=pacientes.id) 
                      INNER JOIN presupuestos ON citas.pacientes_id=presupuestos.pacientes_id) 
                      WHERE citas.asistencia = 3 AND citas.tipo_cita=1;";
            $stm = $this->pdo->prepare($query);

            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['pacientes'] = $resultado[0][0];
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Devuelve la lista de todos los médicos
     */
    public function getMedicos() {
        $res = ['estado' => 0];

        try {
            $query = "SELECT id, nombre, apPaterno, id_tipo FROM usuarios u INNER JOIN accesos a ON u.id=a.id_usuario WHERE (a.medico = true) and( u.id_tipo=2 OR u.id_tipo=7) and (u.id_tipo != 5);";
            $stm = $this->pdo->prepare($query);
            $stm->execute();
            $resultado = $stm->fetchAll(PDO::FETCH_OBJ);


            $res['medicos'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Actualiza el porcentaje de operación de un procedimiento
     */
    function updatePorcentajeOperacion($presupuesto_id, $porcentaje) {
        $res = ['estado' => 0];

        try {
            if ($this->checkPermisos()) {
                if ($porcentaje < 1 || $porcentaje > 100 || !is_numeric($porcentaje)) {
                    $res['mensaje'] = "El porcentaje es invalido";
                } else {
                    $query = "UPDATE presupuestos SET presupuestos.porcentaje_operacion=:porcentaje WHERE id=:presupuesto_id;";
                    $stm = $this->pdo->prepare($query);
                    $stm->bindValue(":porcentaje", $porcentaje, PDO::PARAM_INT);
                    $stm->bindValue(":presupuesto_id", $presupuesto_id, PDO::PARAM_INT);
                    $stm->execute();

                    $res['mensaje'] = "El porcentaje se actualizó correctamente";
                    $res['estado'] = 1;
                }
            } else {
                $res['mensaje'] = "No cuentas con los permisos correspondientes";
            }
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Busca un médico por nombre, apellidos o id
     */
    function searchMedicos($search) {
        $res = ['estado' => 0];

        try {
            $query = "SELECT id, nombre, apPaterno, apMaterno FROM usuarios u INNER JOIN accesos a ON u.id=a.id_usuario WHERE (a.medico=1 OR u.id_tipo=2) AND (id LIKE :search OR nombre LIKE :search OR apPaterno LIKE :search OR apMaterno LIKE :search);";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":search", "%$search%", PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll(PDO::FETCH_OBJ);


            $res['medicos'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Transfiere un paciente a otro médico
     */
    function transferirPaciente($paciente_id, $medico_id) {
        $res = ['estado' => 0];

        try {
            $query = "SELECT id_relacion_mp FROM relacion_medico_paciente WHERE id_paciente=:id_paciente AND id_medico_principal=:id_medico;";
            $stm = $this->pdo->prepare($query);
            $stm->bindValue(":id_paciente", $paciente_id, PDO::PARAM_INT);
            $stm->bindValue(":id_medico", $_SESSION['Id'], PDO::PARAM_INT);
            $stm->execute();
            $resultado = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (count($resultado) > 0) {
                // La relación médico-paciente es principal
                $query = "UPDATE relacion_medico_paciente SET id_medico_principal=:id_medico WHERE id_relacion_mp=:id;";
                $stm2 = $this->pdo->prepare($query);
                $stm2->bindValue(":id_medico", $medico_id, PDO::PARAM_INT);
                $stm2->bindValue(":id", $resultado[0]["id_relacion_mp"], PDO::PARAM_INT);
                $stm2->execute();
            } else {
                // La relación médico-paciente es secundaria
                $query = "UPDATE relacion_medico_paciente SET id_medico_secundario=:id_medico WHERE id_paciente=:id_paciente AND id_medico_secundario=:medico_actual;";
                $stm2 = $this->pdo->prepare($query);
                $stm2->bindValue(":id_paciente", $paciente_id, PDO::PARAM_INT);
                $stm2->bindValue(":id_medico", $medico_id, PDO::PARAM_INT);
                $stm2->bindValue(":medico_actual", $_SESSION['Id'], PDO::PARAM_INT);
                $stm2->execute();
            }

            $res['mensaje'] = "El paciente se traslado correctamente";
            $res['estado'] = 1;
        } catch (Exception $ex) {
            $res['mensaje'] = $ex->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }
}

if (isset($_POST['get'])) {
    if (auth()) {
        $get = $_POST['get'];
        $m = new Medico();

        switch ($get) {
            case 'enEspera':
                $m->pacientesEnEspera();
                break;
            case 'atender':
                $m->atender($_POST['paciente_id'], (isset($_POST['medico_id'])) ? $_POST['medico_id'] : null);
                break;
            case 'misPacientes':
                $m->misPacientes();
                break;
            case 'misPacientesEspera':
                $m->misPacientesEspera();
                break;  
            case 'detalleMiPaciente':
                $m->detalleMiPaciente($_POST['id']);
                break;
            case 'getExpediente1':
                $m->getExpediente1($_POST['id']);
                break;
            case 'getExpediente2':
                $m->getExpediente2($_POST['id']);
                break;
            case 'getExpediente3':
                $m->getExpediente3($_POST['id']);
                break;
            case 'addPresupuesto':
                $m->createPresupuesto($_POST);
                break;
            case 'addObservacion':
                $m->addObservacion($_POST['paciente_id'], $_POST['observacion']);
                break;
            case 'updateAntecedentes':
                $m->addAntecedentes($_POST);
                break;
            case 'uploadFile':
                $m->loadDocumentos($_POST);
                break;
            case 'uploadOtherFile':
                $m->loadOtrosDocumentos($_POST);
                break;
            case 'countEnEspera':
                $m->countEnEspera();
                break;
            case 'getDocuments':
                $m->getDocumentos($_POST['id']);
                break;
            case 'deleteFile':
                $m->deleteFile($_POST['id']);
                break;
            case 'deletePresupuesto':
                $m->deletePresupuesto($_POST['id']);
                break;
            case 'getMedicos':
                $m->getMedicos();
                break;
            case 'updatePorcentajeOperacion':
                $m->updatePorcentajeOperacion($_POST['presupuesto_id'], $_POST['porcentaje']);
                break;
            case 'searchMedicos':
                $m->searchMedicos($_POST['search']);
                break;
            case 'transferirPaciente':
                $m->transferirPaciente($_POST['paciente_id'], $_POST['medico_id']);
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