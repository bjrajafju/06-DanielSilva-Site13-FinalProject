<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    db_delete('news', "id = $id");
    set_alert("News deleted successfully!");
}

redirect("news.php");


