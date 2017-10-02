<?php
include dirname(__FILE__) . '/../controladores/datos/ConexionBD.php';
include dirname(__FILE__) . '/../controladores/sesion/Session.php';

if (!isset($_SESSION)) {
    session_start();
}

/**
 * Created by PhpStorm.
 * User: rk521
 * Date: 14.02.17
 * Time: 11:26
 */
class Usuarios
{
    private $pdo;

    /**
     * Usuarios constructor.
     */
    public function __construct()
    {
        $this->pdo = ConexionBD::obtenerInstancia()->obtenerBD();
    }

    /*
     * Crea un nuevo usuario
     */
    public function createUser($data)
    {
        $nombre = $data['nombre'];
        $apMaterno = $data['apMat'];
        $apPaterno = $data['apPat'];
        $numero = $data['username'];
        $password = hash('sha256', $data['password']);
        $password2 = hash('sha256', $data['confirm_password']);
        $tipo = (isset($data['type'])) ? $data['type'] : 0;
        $cedula = $data['cedula'];

        $perm_farmacia = (isset($data['perm_farmacia']) ? 1 : 0);
        $perm_recepcion = (isset($data['perm_recepcion']) ? 1 : 0);
        $perm_medico = (isset($data['perm_medico']) ? 1 : 0);
        $perm_financiero = (isset($data['perm_financiero']) ? 1 : 0);
        $perm_citas = (isset($data['perm_citas']) ? 1 : 0);
        $perm_admin = (isset($data['perm_admin']) ? 1 : 0);

        $res = [
            'estado' => 0,
        ];

        if (empty($nombre) || empty($apPaterno) || empty($numero) || empty($password)) {
            if (empty($password)) {
                $res['mensaje'] = "Ingresa una contraseña";
            } elseif (empty($nombre) || empty($apPaterno)) {
                $res['mensaje'] = "Ingresa un nombre y apellido";
            } elseif (empty($numero)) {
                $res['mensaje'] = "Ingresa un número de usuario";
            } else {
                $res['mensaje'] = "Completa los datos requeridos";
            }
        } else {
            if (($password === $password2) && !empty($password)) {
                // Si es médico
                if ($tipo == 2 && empty($cedula)) {
                    $res['mensaje'] = "Ingresa la cédula del médico";
                } else {
                    try {
                        $query = "SELECT numeroUsuario FROM usuarios WHERE numeroUsuario=:numeroUsuario;";
                        $stm = $this->pdo->prepare($query);
                        $stm->bindValue(":numeroUsuario", $numero, PDO::PARAM_INT);
                        $stm->execute();
                        $resultado = $stm->fetchAll();

                        if (count($resultado) > 0) {
                            $res['mensaje'] = "El número de usuario ya se encuentra registrado";
                        } else {
                            $query = "INSERT INTO usuarios (nombre, apMaterno, apPaterno, numeroUsuario, password, incorporacion, id_tipo) VALUES (
                  ?, ?, ?, ?, ?, NOW(), ? );";
                            $stm = $this->pdo->prepare($query);
                            $stm->bindValue(1, $nombre, PDO::PARAM_STR);
                            $stm->bindValue(2, $apMaterno, PDO::PARAM_STR);
                            $stm->bindValue(3, $apPaterno, PDO::PARAM_STR);
                            $stm->bindValue(4, $numero, PDO::PARAM_INT);
                            $stm->bindValue(5, $password, PDO::PARAM_STR);
                            $stm->bindValue(6, $tipo, PDO::PARAM_STR);
                            $stm->execute();

                            $id = $this->pdo->lastInsertId();

                            $query = "INSERT INTO accesos (id_usuario, farmacia, recepcion, medico, financiero, citas, admin) VALUES (
                  ?, ?, ?, ?, ?, ?, ?);";
                            $stm = $this->pdo->prepare($query);
                            $stm->bindValue(1, $id, PDO::PARAM_STR);
                            $stm->bindValue(2, $perm_farmacia, PDO::PARAM_INT);
                            $stm->bindValue(3, $perm_recepcion, PDO::PARAM_INT);
                            $stm->bindValue(4, $perm_medico, PDO::PARAM_INT);
                            $stm->bindValue(5, $perm_financiero, PDO::PARAM_INT);
                            $stm->bindValue(6, $perm_citas, PDO::PARAM_INT);
                            $stm->bindValue(7, $perm_admin, PDO::PARAM_INT);
                            $stm->execute();

                            // SI ES MEDICO 
                            if ($perm_medico == 1) {
                                $query = "INSERT INTO cedulas (id_medico, cedula) VALUES (?, ?);";
                                $stm = $this->pdo->prepare($query);
                                $stm->bindValue(1, $id, PDO::PARAM_INT);
                                $stm->bindValue(2, $cedula, PDO::PARAM_STR);
                                $stm->execute();
                            } 

                            $res['estado'] = 1;
                            $res['id'] = $id;
                        }
                    } catch (Exception $e) {
                        $res['mensaje'] = $e->getMessage() . $e->getLine();
                    }
                }
            } else {
                $res['mensaje'] = "Las contraseñas no coinciden";
            }
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    /*
     * Actualiza un usuario
     */
    public function modifyUser($data) {
        $id_usuario = $data["id_usuario"];
        $tipo_usuario = $data["e-tipousuario"];
        $nombre = $data['e-nombre'];
        $apMaterno = $data['e-materno'];
        $apPaterno = $data['e-paterno'];
        $numero = $data['e-numero'];
        $password = hash('sha256', $data['e-contrasena']);
        $password2 = hash('sha256', $data['e-ncontrasena']);

        $perm_farmacia = (isset($data['e-perm_farmacia']) ? 1 : 0);
        $perm_recepcion = (isset($data['e-perm_recepcion']) ? 1 : 0);
        $perm_medico = (isset($data['e-perm_medico']) ? 1 : 0);
        $perm_financiero = (isset($data['e-perm_financiero']) ? 1 : 0);
        $perm_citas = (isset($data['e-perm_citas']) ? 1 : 0);
        $perm_admin = (isset($data['e-perm_admin']) ? 1 : 0);

        $res = [
            'estado' => 0,
        ];

        if (($password === $password2) && !empty($password)) {
            try {
                $query = "SELECT numeroUsuario FROM usuarios WHERE numeroUsuario=:numeroUsuario AND id != :id_usuario;";
                $stm = $this->pdo->prepare($query);
                $stm->bindValue(":numeroUsuario", $numero, PDO::PARAM_INT);
                $stm->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
                $stm->execute();
                $resultado = $stm->fetchAll();

                if (count($resultado) > 0) {
                    $res['mensaje'] = "El número de usuario ya se encuentra registrado";
                } else {
                    $query = "UPDATE usuarios SET nombre= ?, apMaterno= ?, apPaterno= ?, numeroUsuario= ?, password= ?, id_tipo=? WHERE id = ? ";
                    $stm = $this->pdo->prepare($query);
                    $stm->bindValue(1, $nombre, PDO::PARAM_STR);
                    $stm->bindValue(2, $apMaterno, PDO::PARAM_STR);
                    $stm->bindValue(3, $apPaterno, PDO::PARAM_STR);
                    $stm->bindValue(4, $numero, PDO::PARAM_INT);
                    $stm->bindValue(5, $password, PDO::PARAM_STR);
                    $stm->bindValue(6, $tipo_usuario, PDO::PARAM_INT);
                    $stm->bindValue(7, $id_usuario, PDO::PARAM_INT);
                    $stm->execute();


                    $query = "UPDATE accesos SET farmacia= ?, recepcion= ?, medico= ?, financiero= ?, citas= ?, admin= ? WHERE id_usuario = ?";
                    $stm = $this->pdo->prepare($query);
                    $stm->bindValue(1, $perm_farmacia, PDO::PARAM_INT);
                    $stm->bindValue(2, $perm_recepcion, PDO::PARAM_INT);
                    $stm->bindValue(3, $perm_medico, PDO::PARAM_INT);
                    $stm->bindValue(4, $perm_financiero, PDO::PARAM_INT);
                    $stm->bindValue(5, $perm_citas, PDO::PARAM_INT);
                    $stm->bindValue(6, $perm_admin, PDO::PARAM_INT);
                    $stm->bindValue(7, $id_usuario, PDO::PARAM_STR);
                    $stm->execute();

                    $res['estado'] = 1;
                }
            } catch (Exception $e) {
                $res['mensaje'] = $e->getMessage();
            }
        } else {
            if (empty($password)) {
                $res['mensaje'] = "Ingresa una contraseña";
            } elseif (empty($nombre) || empty($apPaterno)) {
                $res['mensaje'] = "Ingresa un nombre y apellido";
            } elseif (empty($username)) {
                $res['mensaje'] = "Ingresa un número de usuario";
            } else {
                $res['mensaje'] = "Las contraseñas no coinciden";
            }
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }

    public function getListUsuarios()
    {
        $res = ["estado" => 0];

        $query = "SELECT usr.id,usr.nombre,usr.apPaterno,usr.apMaterno,usr.numeroUsuario,usr.incorporacion,usr.id_tipo, tipo.nombre_tipo_usuario,ac.farmacia,ac.recepcion,ac.medico,ac.financiero,ac.citas FROM usuarios AS usr LEFT JOIN tipo_usuarios AS tipo ON usr.id_tipo = tipo.id_tipo_usuario RIGHT JOIN accesos as ac ON ac.id_usuario = usr.id";

        $stm = $this->pdo->prepare($query);

        $stm->execute();

        $res["estado"] = 1;
        $res["rows"] = $stm->fetchAll();

        return json_encode($res);
    }

    /*
     * Busca un usuario por nombre de usuario
     */
    public function getUserSearch($search)
    {
        $search = "%" . $search . "%";
        $res = ["estado" => 0];

        $query = "SELECT usr.id,usr.nombre,usr.apPaterno,usr.apMaterno,usr.numeroUsuario,usr.incorporacion,usr.id_tipo, tipo.nombre_tipo_usuario,ac.farmacia,ac.recepcion,ac.medico,ac.financiero,ac.citas FROM usuarios AS usr LEFT JOIN tipo_usuarios AS tipo ON usr.id_tipo = tipo.id_tipo_usuario RIGHT JOIN accesos AS ac ON ac.id_usuario = usr.id WHERE usr.nombre LIKE ? OR usr.apPaterno LIKE ? OR usr.apMaterno LIKE ? OR usr.numeroUsuario lIKE ? OR tipo.nombre_tipo_usuario LIKE ? ";

        $stm = $this->pdo->prepare($query);
        $stm->bindParam(1, $search);
        $stm->bindParam(2, $search);
        $stm->bindParam(3, $search);
        $stm->bindParam(4, $search);
        $stm->bindParam(5, $search);
        $stm->execute();

        $res["estado"] = 1;
        $res["rows"] = $stm->fetchAll();

        return json_encode($res);
    }

    /*
     * Devuelve un usuario
     */
    public function getUsuario($id)
    {
        $res = ["estado" => 0];
        $query = "SELECT usr.id,usr.nombre,usr.apPaterno,usr.apMaterno,usr.numeroUsuario,usr.incorporacion,usr.id_tipo, tipo.nombre_tipo_usuario,ac.farmacia,ac.recepcion,ac.medico,ac.financiero,ac.citas, ac.admin FROM usuarios AS usr LEFT JOIN tipo_usuarios AS tipo ON usr.id_tipo = tipo.id_tipo_usuario RIGHT JOIN accesos AS ac ON ac.id_usuario = usr.id WHERE usr.id = :usuario_id";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(":usuario_id", $id);
        $stm->execute();
        $resultado = $stm->fetchAll();
        $res["estado"] = 1;
        $res["rows"] = $resultado;
        return json_encode($res);
    }

    // OBTIENE EL USUARIO CON MAS CITAS DE PRIMERA VEZ
    public function reporteUsuarioMasCitasPv()
    {
        $res = ["estado" => 0];

        try {
            /*
             * 0 = Mas citas de primera vez
             * 1 = Menos citas de primera vez
             * 2 = Mas citas totales
             * 3 = Menos citas totales
             */
            $query = "
                  (SELECT 
                    usuarios.nombre,
                    usuarios.id,
                    usuarios.apPaterno,
                    usuarios.apMaterno,
                    usuarios.numeroUsuario, 
                    SUM(CASE WHEN citas.tipo_cita = 1 THEN 1 ELSE 0 END) as citas, 
                    SUM(
                        CASE citas.asistencia 
                            WHEN 1 THEN 1 
                            WHEN 3 THEN 1 
                            ELSE 0 
                        END
                    ) as checkins
                  FROM usuarios 
                  LEFT JOIN citas ON usuarios.id = citas.usuario_id 
                  WHERE citas.usuario_id != 0 
                  GROUP BY citas.usuario_id 
                  HAVING COUNT(usuarios.id) 
                  ORDER BY citas 
                  DESC LIMIT 1)
                  
                  UNION ALL 
                  
                  (SELECT 
                    usuarios.nombre,
                    usuarios.id,
                    usuarios.apPaterno,
                    usuarios.apMaterno,
                    usuarios.numeroUsuario, 
                    SUM(CASE WHEN citas.tipo_cita = 1 THEN 1 ELSE 0 END) as citas, 
                    SUM(
                        CASE citas.asistencia 
                            WHEN 1 THEN 1 
                            WHEN 3 THEN 1 
                            ELSE 0 
                        END
                    ) as checkins
                  FROM usuarios 
                  LEFT JOIN citas ON usuarios.id = citas.usuario_id 
                  WHERE citas.usuario_id != 0 
                  GROUP BY citas.usuario_id 
                  HAVING COUNT(usuarios.id) 
                  ORDER BY citas 
                  ASC LIMIT 1)
                  
                  UNION ALL
                  
                  (SELECT
                        usuarios.nombre,
                        usuarios.id,
                        usuarios.apPaterno,
                        usuarios.apMaterno,
                        usuarios.numeroUsuario,
                        COUNT(usuarios.id) AS citas, 
                        SUM(
                            CASE citas.asistencia 
                                WHEN 1 THEN 1 
                                WHEN 3 THEN 1 
                                ELSE 0 
                            END
                        ) as checkins
                  FROM usuarios 
                  LEFT JOIN citas ON usuarios.id = citas.usuario_id 
                  WHERE citas.usuario_id != 0 
                  GROUP BY citas.usuario_id 
                  HAVING COUNT(usuarios.id) 
                  ORDER BY COUNT(usuarios.id) 
                  DESC LIMIT 1)
                    
                  UNION ALL
                  
                  (SELECT 
                        usuarios.nombre,
                        usuarios.id,
                        usuarios.apPaterno,
                        usuarios.apMaterno,
                        usuarios.numeroUsuario,
                        COUNT(usuarios.id) AS citas, 
                        SUM(
                            CASE citas.asistencia 
                                WHEN 1 THEN 1 
                                WHEN 3 THEN 1 
                                ELSE 0 
                            END
                        ) as checkins
                  FROM usuarios 
                  LEFT JOIN citas ON usuarios.id = citas.usuario_id 
                  WHERE citas.usuario_id != 0 
                  GROUP BY citas.usuario_id 
                  HAVING COUNT(usuarios.id) 
                  ORDER BY COUNT(usuarios.id) 
                  ASC LIMIT 1)
                  ";
            $stm = $this->pdo->prepare($query);
            $stm->execute();
            $resultado = $stm->fetchAll();

            $res["estado"] = 1;
            $res["rows"] = $resultado;
        } catch (Exception $ex) {
            $res["mensaje"] = $ex->getMessage();
        }
        return json_encode($res);
    }

    public function reporteCitasUsuarios()
    {
        $res = ["estado" => 0];
        $query = "SELECT usuarios.nombre,usuarios.id,usuarios.apPaterno,usuarios.apMaterno,usuarios.numeroUsuario,SUM(CASE WHEN citas.tipo_cita = 1 THEN 1 ELSE 0 END) AS primeravez,SUM(CASE WHEN citas.tipo_cita = 2 THEN 1 ELSE 0 END) AS preoperatorios,SUM(CASE WHEN citas.tipo_cita = 3 THEN 1 ELSE 0 END) AS cirugia, SUM(CASE WHEN citas.tipo_cita = 4 THEN 1 ELSE 0 END) AS postoperatorio,SUM(CASE WHEN citas.tipo_cita = 5 THEN 1 ELSE 0 END) AS valoracion,SUM(CASE WHEN citas.tipo_cita = 6 THEN 1 ELSE 0 END) AS revision, SUM(CASE WHEN citas.tipo_cita = 7 THEN 1 ELSE 0 END) as tratamiento FROM usuarios LEFT JOIN citas ON usuarios.id = citas.usuario_id WHERE citas.usuario_id != 0 GROUP BY citas.usuario_id";
        $stm = $this->pdo->prepare($query);
        $stm->execute();
        $resultado = $stm->fetchAll();
        $res["estado"] = 1;
        $res["rows"] = $resultado;
        return json_encode($res);
    }

    public function reporteCitasUsuariosBySearch($search)
    {
        $res = ["estado" => 0];
        $search = "%" . $search . "%";
        $query = "SELECT usuarios.nombre,usuarios.id,usuarios.apPaterno,usuarios.apMaterno,usuarios.numeroUsuario,SUM(CASE WHEN citas.tipo_cita = 1 THEN 1 ELSE 0 END) AS primeravez,SUM(CASE WHEN citas.tipo_cita = 2 THEN 1 ELSE 0 END) AS preoperatorios,SUM(CASE WHEN citas.tipo_cita = 3 THEN 1 ELSE 0 END) AS cirugia, SUM(CASE WHEN citas.tipo_cita = 4 THEN 1 ELSE 0 END) AS postoperatorio,SUM(CASE WHEN citas.tipo_cita = 5 THEN 1 ELSE 0 END) AS valoracion,SUM(CASE WHEN citas.tipo_cita = 6 THEN 1 ELSE 0 END) AS revision, SUM(CASE WHEN citas.tipo_cita = 7 THEN 1 ELSE 0 END) as tratamiento FROM usuarios LEFT JOIN citas ON usuarios.id = citas.usuario_id WHERE citas.usuario_id != 0 AND (usuarios.nombre LIKE ? OR usuarios.apPaterno LIKE ? OR usuarios.apMaterno LIKE ? OR usuarios.numeroUsuario lIKE ? ) GROUP BY citas.usuario_id";
        $stm = $this->pdo->prepare($query);
        $stm->bindParam(1, $search);
        $stm->bindParam(2, $search);
        $stm->bindParam(3, $search);
        $stm->bindParam(4, $search);
        $stm->execute();
        $resultado = $stm->fetchAll();
        $res["estado"] = 1;
        $res["rows"] = $resultado;
        return json_encode($res);
    }

    public function getMedicosSearch($string)
    {
        $res = [
            'estado' => 0,
        ];

        try {
            $query = "SELECT u.id, u.apPaterno, u.nombre
            from usuarios u inner join accesos a
            on u.id = a.id_usuario
            where (u.nombre like :search or u.apPaterno like :search or u.id like :search)
            and a.medico = true order by u.id asc;";

            $stm = $this->pdo->prepare($query);

            $stm->bindValue(":search", "%$string%", PDO::PARAM_STR);
            $stm->execute();
            $resultado = $stm->fetchAll();

            $res['medicos'] = $resultado;
            $res['estado'] = 1;
        } catch (Exception $e) {
            $res['mensaje'] = $e->getMessage();
        }

        // Devuelve json como respuesta
        echo json_encode($res);
    }
}

if (isset($_POST['get'])) {
    if (auth()) {
        $get = $_POST['get'];
        $f = new Usuarios();

        switch ($get) {
            case 'create':
                $f->createUser($_POST);
                break;
            case 'getListUsuarios':
                echo $f->getListUsuarios();
                break;
            case 'getUserSearch':
                echo $f->getUserSearch($_POST['search']);
                break;
            case 'getMedicosSearch':
                echo $f->getMedicosSearch($_POST['param']);
                break;
            case 'getUser';
                echo $f->getUsuario($_POST["id"]);
                break;
            case "modifyUser":
                echo $f->modifyUser($_POST);
                break;
            case 'reporteUsuarioMasCitasPv':
                echo $f->reporteUsuarioMasCitasPv();
                break;
            case 'reporteCitasUsuarios':
                echo $f->reporteCitasUsuarios();
                break;
            case "reporteCitasUsuariosBySearch";
                echo $f->reporteCitasUsuariosBySearch($_POST["search"]);
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
