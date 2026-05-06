<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    // Check if used in addresses
    $addresses = db_get_all('addresses', "country_id = $id");
    if ($addresses) {
        set_alert("Cannot delete country because it is used in user addresses.", "danger");
    } else {
        db_delete('country_translations', "country_id = $id");
        db_delete('countries', "id = $id");
        set_alert("Country deleted successfully!");
    }
}

redirect("countries.php");
