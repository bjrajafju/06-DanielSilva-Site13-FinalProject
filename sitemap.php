<?php
include_once 'includes/config.php';

header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Static Pages
$static_pages = ['', 'shop', 'cart', 'checkout', 'contact', 'about', 'news', 'login', 'register'];
foreach ($static_pages as $page) {
    echo '<url>';
    echo '<loc>' . get_url($page . ($page ? '' : '')) . '</loc>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>' . ($page == '' ? '1.0' : '0.8') . '</priority>';
    echo '</url>';
}

// Products
$products = db_get_all("product_translations", "lang_code = '" . $_SESSION['lingua'] . "'");
foreach ($products as $p) {
    echo '<url>';
    echo '<loc>' . get_url('detail.php?slug=' . $p['slug']) . '</loc>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>0.7</priority>';
    echo '</url>';
}

// News
$news = db_get_all("news_translations", "lang_code = '" . $_SESSION['lingua'] . "'");
foreach ($news as $n) {
    echo '<url>';
    echo '<loc>' . get_url('news-detail.php?slug=' . $n['slug']) . '</loc>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>0.6</priority>';
    echo '</url>';
}

echo '</urlset>';
