<?php
    require_once dirname(__FILE__) . '/../../datos/ConexionBD.php';

    /*++++++++++++++++++++++++++++++++++++++++++     
                    AQUÍ SE DEBEN PONER TODAS LAS CONSULTAS QUE SE MUESTREN EN UN
                    SELECT - BOX Y QUE HAGAN REFERENCIA A TABLAS EN LA BASE DE DATOS
                    PARA EL LLENADO DE OPCIONES
    +++++++++++++++++++++++++++++++++++++++++++++   */


    //  RECEPCION - PROGRAMAR CITAS
        
        function Mostrar_Tipos_Citas() {
            $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

            $operacion = "SELECT * FROM tipo_citas WHERE for_paciente=1";
            $sentencia = $pdo->prepare($operacion);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll();

            foreach ($resultado as $tipo_cita) {   

                if($tipo_cita["id_cita"] != 1)  { 

                    echo '<option value = "' . $tipo_cita["id_cita"] . '">' . $tipo_cita["nombre_cita"] . '</option>';
                    
                }
            }
        }


    //  MÉDICO - EXPEDIENTE : DOCUMENTOS
    
    function Mostrar_Nombre_Documentos($tipo) {
        $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

        $operacion = "SELECT * FROM expedientes_catalogo WHERE tipo_expediente = ?";
        $sentencia = $pdo->prepare($operacion);
        $sentencia->BindParam(1,$tipo);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll();
        echo "<option value='0'>Selecciona un documento</option>";
        foreach ($resultado as $expediente) {   
                echo '<option value = "' . $expediente["id_expediente"] . '">' . $expediente["nombre_expediente"] . '</option>';
        }
    }

    function mostrarExpedientesMaster(){
        $pdo = ConexionBD::obtenerInstancia()->obtenerBD();

        $operacion = "SELECT * FROM tipo_expediente";
        $sentencia = $pdo->prepare($operacion);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll();
        echo "<option value='0'>Selecciona un expediente</option>";
        foreach ($resultado as $expediente) {   
                echo '<option value = "' . $expediente["id_tipo"] . '">' . $expediente["descripcion"] . '</option>';
        }
    }

    /******** LLAMANDO FUNCIOENS DE CARGA DE EXCELES QUE REQUIEREN PARAMETROS DESDE AJAX****/
    if(isset($_POST['post'])){
        $post = $_POST['post'];
        switch ($post) {
            case 'Mostrar_Nombre_Documentos':
                echo Mostrar_Nombre_Documentos($_POST['tipo_expediente']);
                break;            
            default:
                echo json_encode(array('estado' =>0 ,'mensaje' => 'Funcion no encotrada' ));
                break;
        }
    }

?>
