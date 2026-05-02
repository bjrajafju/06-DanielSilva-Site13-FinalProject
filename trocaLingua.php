<?php
include_once 'includes/config.php';

$lang = $_GET['id'] ?? 'gb';
$langs = db_get_all("lang");
$allowed = array_column($langs, 'code');
if (in_array($lang, $allowed)) {
    $_SESSION['lingua'] = $lang;
}

$referer = $_SERVER['HTTP_REFERER'] ?? $SETTINGS['url_site'] . '/';
header('Location: ' . $referer);
exit;
