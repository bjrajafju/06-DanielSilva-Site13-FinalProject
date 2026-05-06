<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    $lang = db_get_one('lang', "id = $id");
    if ($lang) {
        $code = $lang['code'];

        // Check if used in translations
        $count = db_count('product_translations', "lang_code = '$code'");
        if ($count > 0) {
            set_alert("Cannot delete language because it has linked translations.", "danger");
        } else {
            db_delete('lang', "id = $id");
            set_alert("Language deleted successfully!");
        }
    }
}

redirect("lang.php");
