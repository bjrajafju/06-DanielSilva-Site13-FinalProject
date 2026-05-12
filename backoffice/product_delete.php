<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    // Check for variants
    $variants = db_get_all('product_variants', "product_id = $id");
    if ($variants) {
        set_alert("Cannot delete product because it has variants. Please delete variants first.", "danger");
    } else {
        // Delete translations
        db_delete('product_translations', "product_id = $id");
        // Delete product
        db_delete('products', "id = $id");
        set_alert("Product and its translations deleted successfully!");
    }
}

redirect("products.php");


