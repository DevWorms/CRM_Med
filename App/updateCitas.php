<?php
    //$link = mysqli_connect("www.devworms.com", "worm_developer", "DW_developer_2017", "medilaser_crm_2");
    $link = mysqli_connect("localhost", "root", "toor", "Medilaser");

    // Ids de los usuarios de callcenter
    $users = [
        0 => 21,
        1 => 22,
        2 => 23
    ];

    // Selecciona las citas que cumplen los requerimientos para actualizar
    $query = "SELECT id FROM citas WHERE usuario_id=0 AND tipo_cita=1;";
    $result = mysqli_query($link, $query);

    while ($record = mysqli_fetch_array($result)) {
        // Obtiene el id del usuario al azar
        $rand = rand(0, count($users) - 1);
        $user_id = $users[$rand];

        // Id de la cita a actualizar
        $cita_id = $record[0];

        // Actualizar cita
        $query = "UPDATE `citas` SET `usuario_id`=" . $user_id . " WHERE `id`=" . $cita_id;
        mysqli_query($link, $query);
        echo "Cita: " . $cita_id . "<br>Usuario: " . $user_id . "<br><br>";
    }
?>