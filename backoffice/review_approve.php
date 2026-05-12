<?php
include_once 'includes/helpers.php';

$id = $_GET['id'] ?? null;

if ($id) {
    if (toggle_review_approval($id)) {
        set_alert("Review status updated successfully!", "success");
    } else {
        set_alert("Error updating review status.", "danger");
    }
}

header("Location: reviews.php");
exit;


