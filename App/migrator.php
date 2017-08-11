<?php
    $link = mysqli_connect("www.devworms.com", "worm_developer", "DW_developer_2017", "medilaser_crm_2");
    $query = "SELECT paciente_id, tratamiento, id FROM tratamientos;";
    $result = mysqli_query($link, $query);

    $index = mysqli_query($link, "SELECT MAX(id) FROM presupuestos;");
    $ires = mysqli_fetch_array($index);
    //echo mysqli_fetch_array($index)[0][0];
    $id = $ires[0];
    while ($record = mysqli_fetch_array($result)) {
        $res = mysqli_query($link, "SELECT id FROM presupuestos WHERE paciente_id=" . $record[0] . " and nombre='" . $record[1] . "');");
        $row_cnt = mysqli_num_rows($res);

        if ($row_cnt == 0) {
            $id++;
            $q = "INSERT INTO presupuestos (`id`, `precio`, `promocion`, `vigencia`, `pacientes_id`, `nombre`, `tipo`, `descripcion`, `numero_sesiones`, `contado`) VALUES (" . $id . ", null, null, null, " . $record[0] . ", '" . $record[1] . "', null, null, null, null); ";
            //echo $q. "<br>";
            mysqli_query($link, $q);

            $queryCitas = "UPDATE citas SET presupuesto_id=" . $id . " WHERE pacientes_id=" . $record[0] . " AND (presupuesto_id=" . $record[2] . " OR presupuesto_id is null);";// and presupuesto_id=id_tratamiento
            //echo $queryCitas. "<br>";
            ///$queryCitas = "UPDATE citas SET presupuesto_id=" . $id . " WHERE pacientes_id=" . $record[0] . ";";
            echo "UPDATE citas SET presupuesto_id=" . $id . " WHERE pacientes_id=" . $record[0] . " AND (presupuesto_id=" . $record[2] . " OR presupuesto_id is null);<br><br>";
            mysqli_query($link, $queryCitas);
        }
    }
?>