<?php
session_start();

if (!isset($_SESSION['lingua'])) {
    $_SESSION['lingua'] = 'gb';
}

// cenas base
$SETTINGS['servername'] = 'localhost';
$SETTINGS['username'] = 'root';
$SETTINGS['password'] = '';
$SETTINGS['dbname'] = 'pi_db';
$SETTINGS['nome_projeto'] = '06-DanielSilva-Site13-FinalProject';

// chave usada para validar o backoffice
$SETTINGS['isLoginKey'] = 'asjdhaskjgfaskjgfkasjhfskajhdsjkhdaskjh';

// cenas dos diretorios
$SETTINGS['dir_site'] = dirname(__DIR__) . '/';

$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$host = $_SERVER['HTTP_HOST'];
$current_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$base_path = str_replace(['/includes', '/backoffice/layout', '/backoffice'], '', $current_path);
$base_path = rtrim($base_path, '/');
$SETTINGS['url_site'] = $protocol . "://" . $host . $base_path;

$SETTINGS['dir_uploads'] = $SETTINGS['dir_site'] . 'uploads/';
$SETTINGS['url_uploads'] = $SETTINGS['url_site'] . '/uploads';

$SETTINGS['fotos_auth'] = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

$SETTINGS['fotos_maxUpload'] = 3000000;

$LANG_CODE = $_SESSION['lingua'] ?? 'pt';

include_once 'db.php';
include_once 'functions.php';
include_once 'auth.php';
