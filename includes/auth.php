<?php
/**
 * Authentication and Authorization Helpers
 */

/**
 * Check if a user is logged in
 * 
 * @return bool
 */
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

/**
 * Check if the logged-in user is an admin
 * 
 * @return bool
 */
function is_admin()
{
    if (!is_logged_in()) {
        return false;
    }

    // Check session first for performance
    if (isset($_SESSION['is_admin'])) {
        return (bool)$_SESSION['is_admin'];
    }

    // Fallback to database check
    $user = db_get_one("users", "id = " . (int)$_SESSION['user_id']);
    if ($user) {
        $_SESSION['is_admin'] = (bool)$user['is_admin'];
        return $_SESSION['is_admin'];
    }

    return false;
}

/**
 * Require admin role to access a page
 * Redirects to login or access denied if not authorized
 */
function require_admin()
{
    global $SETTINGS;

    if (!is_logged_in()) {
        // Redirect to login with current URL as redirect parameter
        $current_url = $_SERVER['REQUEST_URI'];
        $login_url = $SETTINGS['url_site'] . '/login.php?redirect=' . urlencode($current_url);
        header("Location: $login_url");
        exit;
    }

    if (!is_admin()) {
        // Redirect to home with error
        $home_url = $SETTINGS['url_site'] . '/index.php?error=access_denied';
        header("Location: $home_url");
        exit;
    }
}
