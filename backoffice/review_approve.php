<?php
include_once 'includes/helpers.php';

$id = $_GET['id'] ?? null;

if ($id) {
    if (toggle_review_approval($id)) {
        set_alert("Estado da avaliação atualizado com sucesso!", "success");
    } else {
        set_alert("Erro ao atualizar o estado da avaliação.", "danger");
    }
}

header("Location: reviews.php");
exit;


