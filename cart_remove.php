<?php
include_once 'includes/config.php';

$cart_item_id = (int)($_POST['cart_item_id'] ?? 0);

if ($cart_item_id > 0) {
    $cart = get_current_cart();
    if ($cart) {
        $cart_id = $cart['id'];

        // Remover o item garantindo que pertence ao carrinho do utilizador
        my_query("DELETE FROM cart_items WHERE id = $cart_item_id AND cart_id = $cart_id");

        $totals = get_cart_totals($cart_id);

        echo json_encode([
            'success' => true,
            'cart_subtotal' => number_format($totals['subtotal'], 2),
            'cart_total' => number_format($totals['total'], 2)
        ]);
        exit;
    }
}

echo json_encode(['success' => false]);
