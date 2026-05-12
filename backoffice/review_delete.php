<?php
include_once 'includes/helpers.php';

$id = $_GET['id'] ?? null;

if ($id) {
    if (delete_review($id)) {
        set_alert("Avaliação eliminada com sucesso!", "success");
    } else {
        set_alert("Erro ao eliminar a avaliação.", "danger");
    }
}

header("Location: reviews.php");
exit;


