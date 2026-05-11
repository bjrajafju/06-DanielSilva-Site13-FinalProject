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

$cart = get_or_create_cart();
$existing_qty = get_cart_item_quantity($cart['id'], $variant_id);

if (!variant_has_stock($variant_id, $existing_qty + (int)$quantity)) {
    $referer = $_SERVER['HTTP_REFERER'] ?? $SETTINGS['url_site'];
    $sep = strpos($referer, '?') !== false ? '&' : '?';
    header("Location: " . $referer . $sep . "error=out_of_stock");
    exit;
}

add_to_cart($variant_id, (int)$quantity);

$referer = $_SERVER['HTTP_REFERER'] ?? $SETTINGS['url_site'];
header("Location: $referer");
exit;
