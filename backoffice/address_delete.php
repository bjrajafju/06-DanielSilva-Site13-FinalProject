<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    db_delete('addresses', "id = $id");
    set_alert("Address deleted successfully!");
}

redirect("addresses.php");


