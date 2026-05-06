<?php
include_once 'includes/helpers.php';

$id = $_GET['id'] ?? null;

if ($id) {
    if (delete_review($id)) {
        set_alert("Review deleted successfully!", "success");
    } else {
        set_alert("Error deleting review.", "danger");
    }
}

header("Location: reviews.php");
exit;
