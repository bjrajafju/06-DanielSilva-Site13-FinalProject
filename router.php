<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = urldecode($uri);

if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

$routes = [
    '/shop' => 'shop.php',
    '/cart' => 'cart.php',
    '/checkout' => 'checkout.php',
    '/wishlist' => 'wishlist.php',
    '/profile' => 'profile.php',
    '/login' => 'login.php',
    '/register' => 'register.php',
    '/contact' => 'contact.php',
    '/about' => 'about.php',
    '/news' => 'news.php',
    '/sitemap.xml' => 'sitemap.php',
    '/robots.txt' => 'robots.txt'
];

if (isset($routes[$uri])) {
    require __DIR__ . '/' . $routes[$uri];
    exit;
}

if (preg_match('#^/product/([^/]+)$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/detail.php';
    exit;
}

if (preg_match('#^/news/([^/]+)$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/news-detail.php';
    exit;
}

require __DIR__ . '/index.php';
