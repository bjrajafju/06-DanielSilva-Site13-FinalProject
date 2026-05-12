<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    // Check for variants
    $variants = db_get_all('product_variants', "color_id = $id");
    if ($variants) {
        set_alert("Não é possível eliminar a cor porque está a ser utilizada em variantes de produtos.", "danger");
    } else {
        db_delete('color_translations', "color_id = $id");
        db_delete('colors', "id = $id");
        set_alert("Cor eliminada com sucesso!");
    }
}

redirect("colors.php");


