<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    // Check if used in orders
    $orders = db_get_all('orders', "payment_method_id = $id");
    if ($orders) {
        set_alert("Cannot delete payment method because it is used in orders.", "danger");
    } else {
        db_delete('payment_method_translations', "payment_method_id = $id");
        db_delete('payment_methods', "id = $id");
        set_alert("Payment method deleted successfully!");
    }
}

redirect("payment_methods.php");


