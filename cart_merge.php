<?php
include_once 'includes/config.php';

$action = $_POST['action'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$session_cart = get_session_cart();
if (!$session_cart) {
    echo json_encode(['success' => true, 'message' => 'No session cart found']);
    exit;
}

$session_cart_id = $session_cart['id'];

if ($action === 'merge') {
    $user_cart = get_user_cart($user_id);

    if (!$user_cart) {
        // User não tem carrinho, basta associar o da sessão ao user
        attach_cart_to_user($session_cart_id, $user_id);
    } else {
        // User já tem carrinho, fazer merge dos itens
        merge_carts($session_cart_id, $user_cart['id']);
    }
} elseif ($action === 'discard') {
    delete_cart($session_cart_id);
}

echo json_encode(['success' => true]);
