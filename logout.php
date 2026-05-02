<?php
include_once 'includes/config.php';
session_destroy();
header("Location: " . $SETTINGS['url_site'] . "/index.php");
exit;
