<?php
include_once 'includes/config.php';

$product_id = $_POST['product_id'] ?? null;
$size_id    = $_POST['size'] ?? null;
$color_id   = $_POST['color'] ?? null;
$quantity   = $_POST['quantity'] ?? 1;

if (!$product_id || !$size_id || !$color_id) {
    die("Missing data");
}

$variant_id = get_variant_id($product_id, $size_id, $color_id);

if (!$variant_id) {
    die("Invalid variant");
}

add_to_cart($variant_id, (int)$quantity);

$referer = $_SERVER['HTTP_REFERER'] ?? $SETTINGS['url_site'];
header("Location: $referer");
exit;
