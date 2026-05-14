<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    $user_to_delete = db_get_one('users', "id = $id");

    if ($user_to_delete['is_admin']) {
        $admin_count = db_count('users', "is_admin = 1");
        if ($admin_count <= 1) {
            set_alert("Não é possível eliminar o único administrador.", "danger");
            redirect("users.php");
        }
    }

    $orders = db_get_all('orders', "user_id = $id");
    $addresses = db_get_all('addresses', "user_id = $id");

    if ($orders || $addresses) {
        set_alert("Não é possível eliminar o utilizador porque possui encomendas ou moradas associadas.", "danger");
    } else {
        $carts = db_get_all('carts', "user_id = $id");
        foreach ($carts as $c) {
            db_delete('cart_items', "cart_id = {$c['id']}");
            db_delete('carts', "id = {$c['id']}");
        }
        db_delete('users', "id = $id");
        set_alert("Utilizador eliminado com sucesso!");
    }
}

redirect("users.php");


