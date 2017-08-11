<?php
/**
 * Created by PhpStorm.
 * User: rk521
 * Date: 13.02.17
 * Time: 23:16
 */

if (!function_exists('app_url')) {
    include dirname(__FILE__) . '/../datos/config.php';
}

session_start();

function auth() {
    if (!empty($_SESSION['Id']) && !empty($_SESSION['Nombre'])) {
        if (hash('sha256', $_SESSION['Id']) === $_SESSION['token']) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function goHome() {
    header("Location: " . app_url());
}