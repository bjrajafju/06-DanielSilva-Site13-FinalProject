<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    db_delete('messages', "id = $id");
    set_alert("Message deleted successfully!");
}

redirect("messages.php");


