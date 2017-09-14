<?php
/**
 * Created by PhpStorm.
 * User: rk521
 * Date: 13/09/17
 * Time: 03:35 PM
 */

include dirname(__FILE__) . '/../controladores/sesion/Session.php';

if (!isset($_SESSION)) {
    session_start();
}

trait Permissions {
    public function requestCitas() {
        return ($_SESSION['accesos_citas'] == 1) ? true : false;
    }

    public function requestFarmacia() {
        return ($_SESSION['accesos_farmacia'] == 1) ? true : false;
    }

    public function requestFinanciero() {
        return ($_SESSION['accesos_financiero'] == 1) ? true : false;
    }

    public function requestMedico() {
        return ($_SESSION['accesos_medico'] == 1) ? true : false;
    }

    public function requestRecepcion() {
        return ($_SESSION['accesos_recepcion'] == 1) ? true : false;
    }
}