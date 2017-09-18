<?php
    //$tabla = "medilaser_crm_2";
    $tabla = "Medilaser";
    //$link = mysqli_connect("www.devworms.com", "worm_developer", "DW_developer_2017", $tabla);
    $link = mysqli_connect("localhost", "root", "toor", $tabla);

    // Selecciona las citas que cumplen los requerimientos para actualizar
    $query = 'SELECT table_name FROM information_schema.tables where table_schema=' . $tabla . ';';
    $result = mysqli_query($link, $query);

    // TODO
    while ($record = mysqli_fetch_array($result)) {
        // Obtiene el id del usuario al azar
        echo $record[0];
    }
?>