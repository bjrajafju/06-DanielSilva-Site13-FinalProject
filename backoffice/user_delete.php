<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    // Check for dependencies (orders, addresses, carts)
    $orders = db_get_all('orders', "user_id = $id");
    $addresses = db_get_all('addresses', "user_id = $id");

    if ($orders || $addresses) {
        set_alert("Cannot delete user because they have linked orders or addresses.", "danger");
    } else {
        // Delete carts first
        $carts = db_get_all('carts', "user_id = $id");
        foreach ($carts as $c) {
            db_delete('cart_items', "cart_id = {$c['id']}");
            db_delete('carts', "id = {$c['id']}");
        }
        db_delete('users', "id = $id");
        set_alert("User deleted successfully!");
    }
}

redirect("users.php");
