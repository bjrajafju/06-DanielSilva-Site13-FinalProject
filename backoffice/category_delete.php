<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    // Check for products
    $products = db_get_all('products', "category_id = $id");
    if ($products) {
        set_alert("Não é possível eliminar a categoria porque possui produtos associados. Por favor, reatribua os produtos primeiro.", "danger");
    } else {
        db_delete('category_translations', "category_id = $id");
        db_delete('categories', "id = $id");
        set_alert("Categoria eliminada com sucesso!");
    }
}

redirect("categories.php");


