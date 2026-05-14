<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    if (db_delete('social_links', "id = $id")) {
        set_alert("Rede social removida com sucesso!");
    } else {
        set_alert("Erro ao remover rede social.", 'danger');
    }
}

redirect('social_links.php');
