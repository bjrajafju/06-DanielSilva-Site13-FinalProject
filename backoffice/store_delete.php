<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    db_delete('store_translations', "store_id = $id");
    db_delete('stores', "id = $id");
    set_alert("Store deleted successfully!");
}

redirect("stores.php");


