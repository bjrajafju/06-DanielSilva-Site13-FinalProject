<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    // Check for products
    $products = db_get_all('products', "category_id = $id");
    if ($products) {
        set_alert("Cannot delete category because it has products. Please reassign products first.", "danger");
    } else {
        db_delete('category_translations', "category_id = $id");
        db_delete('categories', "id = $id");
        set_alert("Category deleted successfully!");
    }
}

redirect("categories.php");
