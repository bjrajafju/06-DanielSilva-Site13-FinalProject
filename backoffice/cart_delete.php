<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    db_delete('cart_items', "cart_id = $id");
    db_delete('carts', "id = $id");
    set_alert("Carrinho eliminado com sucesso!");
}

redirect("carts.php");


