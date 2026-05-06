<?php
include_once 'includes/helpers.php';

$code = isset($_GET['code']) ? $_GET['code'] : '';

if ($code) {
    db_delete('traduz', "code = '" . addslashes($code) . "'");
    set_alert("Translation deleted successfully!");
}

redirect("traduz.php");
