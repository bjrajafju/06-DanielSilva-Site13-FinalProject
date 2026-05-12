<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    db_delete('addresses', "id = $id");
    set_alert("Morada eliminada com sucesso!");
}

redirect("addresses.php");


