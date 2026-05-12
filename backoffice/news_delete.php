<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    db_delete('news', "id = $id");
    set_alert("Notícia eliminada com sucesso!");
}

redirect("news.php");


