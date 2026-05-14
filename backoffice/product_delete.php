<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    $variants = db_get_all('product_variants', "product_id = $id");
    if ($variants) {
        set_alert("Não é possível eliminar o produto porque possui variantes. Por favor, elimine as variantes primeiro.", "danger");
    } else {
        db_delete('product_translations', "product_id = $id");
        db_delete('products', "id = $id");
        set_alert("Produto e as suas traduções eliminados com sucesso!");
    }
}

redirect("products.php");


