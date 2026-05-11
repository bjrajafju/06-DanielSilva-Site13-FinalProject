<?php
include_once 'includes/config.php';

$cart_item_id = (int)($_POST['cart_item_id'] ?? 0);
$quantity = (int)($_POST['quantity'] ?? 0);

if ($cart_item_id > 0 && $quantity >= 1) {
    $cart = get_current_cart();
    if ($cart) {
        $cart_id = $cart['id'];

        // Obter preço e stock do item
        $item_data = db_select(
            "p.price, pv.stock",
            "cart_items ci",
            "JOIN product_variants pv ON pv.id = ci.variant_id JOIN products p ON p.id = pv.product_id",
            "ci.id = $cart_item_id"
        );

        $price = $item_data[0]['price'] ?? 0;
        $stock = $item_data[0]['stock'] ?? 0;

        if ($quantity > $stock) {
            echo json_encode(['success' => false, 'error' => 'out_of_stock', 'max_stock' => $stock]);
            exit;
        }

        // Atualizar quantidade garantindo que o item pertence ao carrinho do utilizador
        my_query("UPDATE cart_items SET quantity = $quantity WHERE id = $cart_item_id AND cart_id = $cart_id");

        $item_total = $price * $quantity;

        $totals = get_cart_totals($cart_id);

        echo json_encode([
            'success' => true,
            'item_total' => number_format($item_total, 2),
            'cart_subtotal' => number_format($totals['subtotal'], 2),
            'cart_total' => number_format($totals['total'], 2)
        ]);
        exit;
    }
}

echo json_encode(['success' => false]);
