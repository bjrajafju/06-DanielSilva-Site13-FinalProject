<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    // Check for variants
    $variants = db_get_all('product_variants', "size_id = $id");
    if ($variants) {
        set_alert("Não é possível eliminar o tamanho porque está a ser utilizado em variantes de produtos.", "danger");
    } else {
        db_delete('sizes', "id = $id");
        set_alert("Tamanho eliminado com sucesso!");
    }
}

redirect("sizes.php");


