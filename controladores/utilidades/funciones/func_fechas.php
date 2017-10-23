<?php
function obtenerFechaHoy() {
    date_default_timezone_set('America/Mexico_City');

    $dias = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado"];
    $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    $min_seg = getdate(date("U"));
    $hora = $min_seg["hours"];
    $minuto = $min_seg["minutes"];

    if ($hora < 10) {
        $hora = "0" . $hora;
    }

    if ($minuto < 10) {
        $minuto = "0" . $minuto;
    }


    if ($hora >= 0 && $hora < 12) {
        $am_pm = "am";
    } else {
        $am_pm = "pm";
    }

    echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
}
?>