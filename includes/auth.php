<?php
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function is_admin()
{
    if (!is_logged_in()) {
        return false;
    }

    if (isset($_SESSION['is_admin'])) {
        return (bool)$_SESSION['is_admin'];
    }

    $user = db_get_one("users", "id = " . (int)$_SESSION['user_id']);
    if ($user) {
        $_SESSION['is_admin'] = (bool)$user['is_admin'];
        return $_SESSION['is_admin'];
    }

    return false;
}

function require_admin()
{
    global $SETTINGS;

    if (!is_logged_in()) {
        $current_url = $_SERVER['REQUEST_URI'];
        $login_url = $SETTINGS['url_site'] . '/login.php?redirect=' . urlencode($current_url);
        header("Location: $login_url");
        exit;
    }

    if (!is_admin()) {
        $home_url = $SETTINGS['url_site'] . '/index.php?error=access_denied';
        header("Location: $home_url");
        exit;
    }
}
