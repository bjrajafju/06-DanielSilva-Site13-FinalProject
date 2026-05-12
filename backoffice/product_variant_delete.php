<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    db_delete('product_variants', "id = $id");
    set_alert("Variante eliminada com sucesso!");
}

redirect("product_variants.php");


