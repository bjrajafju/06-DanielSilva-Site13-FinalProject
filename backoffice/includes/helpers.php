<?php
include_once __DIR__ . '/../../includes/config.php';

require_admin();

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

function get_active_languages()
{
    return db_get_all('lang', '1', 'id ASC');
}

function show_alert()
{
    if (isset($_SESSION['alert'])) {
        $type = $_SESSION['alert']['type'];
        $msg = $_SESSION['alert']['msg'];
        echo "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
                $msg
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
        unset($_SESSION['alert']);
    }
}

function set_alert($msg, $type = 'success')
{
    $_SESSION['alert'] = ['msg' => $msg, 'type' => $type];
}

function redirect($url)
{
    header("Location: $url");
    exit;
}

function get_entity_translations($table, $fk_field, $fk_value)
{
    $rows = db_get_all($table, "$fk_field = " . (int) $fk_value);
    $translations = [];
    foreach ($rows as $row) {
        $translations[$row['lang_code']] = $row;
    }
    return $translations;
}

// DASHBOARD HELPERS

function get_dashboard_stats()
{
    $currentMonthStart = date('Y-m-01 00:00:00');
    $lastMonthStart = date('Y-m-01 00:00:00', strtotime('-1 month'));
    $lastMonthEnd = date('Y-m-t 23:59:59', strtotime('-1 month'));

    // Monthly Revenue
    $revCurrent = my_query("SELECT SUM(total) as total FROM orders WHERE created_at >= '$currentMonthStart'")[0]['total'] ?? 0;
    $revLast = my_query("SELECT SUM(total) as total FROM orders WHERE created_at BETWEEN '$lastMonthStart' AND '$lastMonthEnd'")[0]['total'] ?? 0;
    $revGrowth = $revLast > 0 ? (($revCurrent - $revLast) / $revLast) * 100 : ($revCurrent > 0 ? 100 : 0);

    // Pending Orders
    $pending = db_count('orders', "status = 'pending'");

    // AOV (Average Order Value)
    $aov = my_query("SELECT AVG(total) as aov FROM orders")[0]['aov'] ?? 0;

    // Total Users
    $users = db_count('users');

    return [
        'revenue' => $revCurrent,
        'revenue_growth' => $revGrowth,
        'pending_orders' => $pending,
        'aov' => $aov,
        'total_users' => $users
    ];
}

function get_low_stock_details($limit = 5)
{
    $sql = "SELECT p.id, pt.title, s.name as size_name, c.hex as color_hex, ct.name as color_name, pv.stock 
            FROM product_variants pv
            JOIN products p ON p.id = pv.product_id
            JOIN product_translations pt ON pt.product_id = p.id AND pt.lang_code = 'gb'
            JOIN sizes s ON s.id = pv.size_id
            JOIN colors c ON c.id = pv.color_id
            JOIN color_translations ct ON ct.color_id = c.id AND ct.lang_code = 'gb'
            WHERE pv.stock <= 5
            ORDER BY pv.stock ASC
            LIMIT $limit";
    return my_query($sql);
}

function get_sales_trends($days = 15)
{
    $startDate = date('Y-m-d', strtotime("-$days days"));
    $sql = "SELECT DATE(created_at) as date, SUM(total) as revenue 
            FROM orders 
            WHERE created_at >= '$startDate'
            GROUP BY DATE(created_at)
            ORDER BY date ASC";
    return my_query($sql);
}

function get_category_distribution()
{
    // Sum total revenue per category based on order items
    $sql = "SELECT ct.name as category, SUM(oi.price * oi.quantity) as revenue
            FROM order_items oi
            JOIN product_variants pv ON pv.id = oi.variant_id
            JOIN products p ON p.id = pv.product_id
            JOIN categories c ON c.id = p.category_id
            JOIN category_translations ct ON ct.category_id = c.id AND ct.lang_code = 'gb'
            GROUP BY c.id
            ORDER BY revenue DESC
            LIMIT 5";
    return my_query($sql);
}

function get_top_selling_products_dashboard($limit = 5)
{
    $sql = "SELECT p.image, pt.title, SUM(oi.quantity) as total_sold, SUM(oi.price * oi.quantity) as total_revenue
            FROM order_items oi
            JOIN product_variants pv ON pv.id = oi.variant_id
            JOIN products p ON p.id = pv.product_id
            JOIN product_translations pt ON pt.product_id = p.id AND pt.lang_code = 'gb'
            GROUP BY p.id
            ORDER BY total_sold DESC
            LIMIT $limit";
    return my_query($sql);
}


