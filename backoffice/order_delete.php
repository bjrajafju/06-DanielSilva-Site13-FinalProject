<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    db_delete('order_items', "order_id = $id");
    db_delete('order_addresses', "order_id = $id");
    db_delete('orders', "id = $id");
    set_alert("Encomenda eliminada com sucesso!");
}

redirect("orders.php");


