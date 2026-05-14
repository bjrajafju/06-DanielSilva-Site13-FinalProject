<?php
include_once 'includes/config.php';

if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : (isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0);
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

if ($product_id && $action) {
    if ($action === 'add') {
        add_to_wishlist($user_id, $product_id);
    } elseif ($action === 'remove') {
        remove_from_wishlist($user_id, $product_id);
    }
}

$redirect = $_SERVER['HTTP_REFERER'] ?? 'wishlist.php';
header("Location: $redirect");
exit;
