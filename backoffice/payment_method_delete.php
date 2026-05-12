<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    // Check if used in orders
    $orders = db_get_all('orders', "payment_method_id = $id");
    if ($orders) {
        set_alert("Não é possível eliminar o método de pagamento porque está a ser utilizado em encomendas.", "danger");
    } else {
        db_delete('payment_method_translations', "payment_method_id = $id");
        db_delete('payment_methods', "id = $id");
        set_alert("Método de pagamento eliminado com sucesso!");
    }
}

redirect("payment_methods.php");


