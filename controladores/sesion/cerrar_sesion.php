<?php
    if (!function_exists('app_url')) {
        include dirname(__FILE__) . '/../datos/config.php';
    }
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
	session_destroy();

	header("Location: " . app_url());
?>