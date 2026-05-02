<?php
include_once 'includes/config.php';

$variant_id = $_POST['variant_id'] ?? null;
$quantity = $_POST['quantity'] ?? 1;

if (!$variant_id) {
    http_response_code(400);
    exit;
}

add_to_cart((int)$variant_id, (int)$quantity);

echo json_encode(['success' => true]);
