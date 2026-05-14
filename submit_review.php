<?php
include_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'] ?? null;
    $rating = $_POST['rating'] ?? 0;
    $comment = $_POST['comment'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $slug = $_POST['slug'] ?? '';

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $name = $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'];
        $email = $_SESSION['user_email'];
    } else {
        $user_id = null;
    }

    if (!$product_id || !$rating || !$comment || (!$user_id && (!$name || !$email))) {
        header("Location: detail.php?slug=$slug&review_error=missing_fields#tab-pane-3");
        exit;
    }

    $data = [
        'product_id' => $product_id,
        'user_id' => $user_id,
        'name' => $name,
        'email' => $email,
        'rating' => $rating,
        'comment' => $comment
    ];

    if (insert_review($data)) {
        header("Location: detail.php?slug=$slug&review_success=1#tab-pane-3");
    } else {
        header("Location: detail.php?slug=$slug&review_error=db_error#tab-pane-3");
    }
    exit;
} else {
    header("Location: index.php");
    exit;
}
