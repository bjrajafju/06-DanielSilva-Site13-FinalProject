<?php
include_once __DIR__ . '/../../includes/config.php';

// Protect all backoffice pages
require_admin();

/**
 * Handle image upload
 */
function handle_image_upload($file_input_name, $existing_path = '')
{
    global $SETTINGS;

    if (!isset($_FILES[$file_input_name]) || $_FILES[$file_input_name]['error'] !== UPLOAD_ERR_OK) {
        return $existing_path;
    }

    $file = $_FILES[$file_input_name];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('img_', true) . '.' . $ext;

    $upload_dir = $SETTINGS['dir_site'] . 'img/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $target_path = $upload_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return 'img/' . $filename;
    }

    return $existing_path;
}

/**
 * Get active languages
 */
function get_active_languages()
{
    return db_get_all('lang', '1', 'id ASC');
}

/**
 * Alert helper
 */
function show_alert()
{
    if (isset($_SESSION['alert'])) {
        $type = $_SESSION['alert']['type'];
        $msg = $_SESSION['alert']['msg'];
        echo "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
                $msg
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
        unset($_SESSION['alert']);
    }
}

function set_alert($msg, $type = 'success')
{
    $_SESSION['alert'] = ['msg' => $msg, 'type' => $type];
}

/**
 * Redirect helper
 */
function redirect($url)
{
    header("Location: $url");
    exit;
}

/**
 * Get translation for an entity
 */
function get_entity_translations($table, $fk_field, $fk_value)
{
    $rows = db_get_all($table, "$fk_field = " . (int)$fk_value);
    $translations = [];
    foreach ($rows as $row) {
        $translations[$row['lang_code']] = $row;
    }
    return $translations;
}
