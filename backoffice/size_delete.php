<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    // Check for variants
    $variants = db_get_all('product_variants', "size_id = $id");
    if ($variants) {
        set_alert("Cannot delete size because it is used in product variants.", "danger");
    } else {
        db_delete('sizes', "id = $id");
        set_alert("Size deleted successfully!");
    }
}

redirect("sizes.php");
