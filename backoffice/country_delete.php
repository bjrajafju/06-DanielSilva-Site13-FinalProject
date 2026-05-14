<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    $addresses = db_get_all('addresses', "country_id = $id");
    if ($addresses) {
        set_alert("Não é possível eliminar o país porque está a ser utilizado em moradas de utilizadores.", "danger");
    } else {
        db_delete('country_translations', "country_id = $id");
        db_delete('countries', "id = $id");
        set_alert("País eliminado com sucesso!");
    }
}

redirect("countries.php");


