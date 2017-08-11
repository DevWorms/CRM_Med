<?php
include dirname(__FILE__) . '/Session.php';

if (!auth()) {
    goHome();
}