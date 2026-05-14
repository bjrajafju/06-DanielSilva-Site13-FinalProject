<?php
// Genericas para qualquer projeto
// todos
function db_get_all($table, $where = "1", $order = "id DESC", $limit = "")
{
    $sql = "SELECT * FROM $table WHERE $where ORDER BY $order";

    if ($limit) {
        $sql .= " LIMIT $limit";
    }

    return my_query($sql);
}

// um
function db_get_one($table, $where = "1")
{
    $sql = "SELECT * FROM $table WHERE $where LIMIT 1";
    $res = my_query($sql);
    return $res[0] ?? null;
}

// quantos há
function db_count($table, $where = "1")
{
    $sql = "SELECT COUNT(*) as total FROM $table WHERE $where";
    $res = my_query($sql);
    return $res[0]['total'] ?? 0;
}

// select generico
function db_select($select, $from, $joins = "", $where = "1", $order = "", $limit = "")
{
    $sql = "SELECT $select FROM $from";

    if ($joins) {
        $sql .= " $joins";
    }

    $sql .= " WHERE $where";

    if ($order) {
        $sql .= " ORDER BY $order";
    }

    if ($limit) {
        $sql .= " LIMIT $limit";
    }

    return my_query($sql);
}

// select com grouped
function db_select_grouped($select, $from, $joins = "", $where = "1", $group = "", $order = "", $limit = "")
{
    $sql = "SELECT $select FROM $from";

    if ($joins)
        $sql .= " $joins";

    $sql .= " WHERE $where";

    if ($group)
        $sql .= " GROUP BY $group";

    if ($order)
        $sql .= " ORDER BY $order";

    if ($limit)
        $sql .= " LIMIT $limit";

    return my_query($sql);
}

// insert generico
function db_insert($table, $data)
{
    global $SETTINGS;
    $fields = array_keys($data);
    $values = array_map(function ($v) use ($SETTINGS) {
        if ($v === null)
            return "NULL";
        return "'" . $SETTINGS['conn']->real_escape_string($v) . "'";
    }, array_values($data));

    $sql = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $values) . ")";
    return my_query($sql);
}

// update generico
function db_update($table, $data, $where)
{
    global $SETTINGS;
    $set = [];
    foreach ($data as $field => $value) {
        if ($value === null) {
            $set[] = "$field = NULL";
        } else {
            $set[] = "$field = '" . $SETTINGS['conn']->real_escape_string($value) . "'";
        }
    }

    $sql = "UPDATE $table SET " . implode(', ', $set) . " WHERE $where";
    return my_query($sql);
}

// delete generico
function db_delete($table, $where)
{
    $sql = "DELETE FROM $table WHERE $where";
    return my_query($sql);
}

// com tradução
function db_get_with_translation(
    $table,
    $translation_table,
    $fk,
    $where = "1",
    $order = "",
    $limit = ""
) {
    global $LANG_CODE;

    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    $sql = "
        SELECT tt.*, t.*
        FROM $table t
        LEFT JOIN $translation_table tt 
            ON tt.$fk = t.id
            AND tt.lang_code = '$LANG_CODE'
        WHERE $where
    ";

    if ($order) {
        $sql .= " ORDER BY $order";
    }

    if ($limit) {
        $sql .= " LIMIT $limit";
    }

    return my_query($sql);
}

// especificos
// texto mais estatico
function t($code, $lang_code = null)
{
    static $translations = [];

    if ($lang_code === null) {
        global $LANG_CODE;
        $lang_code = $LANG_CODE ?? 'pt';
    }

    if (!isset($translations[$lang_code])) {
        $rows = db_get_all("traduz", "lang_code = '" . addslashes($lang_code) . "'");

        $translations[$lang_code] = [];
        foreach ($rows as $row) {
            $translations[$lang_code][$row['code']] = $row['text'];
        }
    }
    return $translations[$lang_code][$code] ?? $code;
}

function get_products($limit = 8)
{
    global $LANG_CODE;

    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select_grouped(
        "p.*, pt.title, pt.slug, pt.short_description",
        "products p",
        "
        JOIN product_variants pv ON pv.product_id = p.id
        LEFT JOIN product_translations pt 
            ON pt.product_id = p.id 
            AND pt.lang_code = '$LANG_CODE'
        ",
        "p.is_active = 1 AND pv.is_available = 1 AND pv.stock > 0",
        "p.id",
        "p.id DESC",
        $limit
    );
}

function get_products_filtered($filters = [], $limit = 12, $offset = 0)
{
    global $LANG_CODE;

    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    $joins = "
        JOIN product_variants pv ON pv.product_id = p.id
        LEFT JOIN product_translations pt 
            ON pt.product_id = p.id 
            AND pt.lang_code = '$LANG_CODE'
    ";

    $where = ["p.is_active = 1", "pv.is_available = 1", "pv.stock > 0"];

    if (!empty($filters['colors'])) {
        $colors = array_map('intval', $filters['colors']);
        $where[] = "pv.color_id IN (" . implode(',', $colors) . ")";
    }

    if (!empty($filters['sizes'])) {
        $sizes = array_map('intval', $filters['sizes']);
        $where[] = "pv.size_id IN (" . implode(',', $sizes) . ")";
    }

    if (!empty($filters['categories'])) {
        $categories = array_map('intval', $filters['categories']);
        $where[] = "p.category_id IN (" . implode(',', $categories) . ")";
    }

    if (!empty($filters['search'])) {
        $search = addslashes($filters['search']);
        $where[] = "pt.title LIKE '%$search%'";
    }

    if (!empty($filters['price'])) {
        $price_conditions = [];

        foreach ($filters['price'] as $range) {
            [$min, $max] = explode('-', $range);
            $price_conditions[] = "(p.price BETWEEN $min AND $max)";
        }

        $where[] = "(" . implode(" OR ", $price_conditions) . ")";
    }

    $where_sql = implode(" AND ", $where);

    $sort = $filters['sort'] ?? '';
    $order_by = 'p.id DESC';

    switch ($sort) {
        case 'name_asc':
            $order_by = 'pt.title ASC';
            break;
        case 'name_desc':
            $order_by = 'pt.title DESC';
            break;
        case 'price_asc':
            $order_by = 'p.price ASC';
            break;
        case 'price_desc':
            $order_by = 'p.price DESC';
            break;
    }

    return db_select_grouped(
        "p.*, pt.title, pt.slug, pt.short_description",
        "products p",
        $joins,
        $where_sql,
        "p.id",
        $order_by,
        "$offset, $limit"
    );
}

function get_product_by_slug($slug)
{
    global $LANG_CODE;

    $slug = addslashes($slug);
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    $res = db_select(
        "p.*, pt.*",
        "products p",
        "
        LEFT JOIN product_translations pt 
            ON pt.product_id = p.id 
            AND pt.lang_code = '$LANG_CODE'
        ",
        "pt.slug = '$slug' AND p.is_active = 1",
        "",
        "1"
    );

    return $res[0] ?? null;
}

function get_product_by_id($id)
{
    global $LANG_CODE;

    $id = (int) $id;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    $res = db_select(
        "p.*, pt.*",
        "products p",
        "
        LEFT JOIN product_translations pt 
            ON pt.product_id = p.id 
            AND pt.lang_code = '$LANG_CODE'
        ",
        "p.id = $id AND p.is_active = 1",
        "",
        "1"
    );

    return $res[0] ?? null;
}

function get_product_by_slug_any_lang($slug)
{
    $slug = addslashes($slug);

    $res = db_select(
        "pt.product_id",
        "product_translations pt",
        "",
        "pt.slug = '$slug'",
        "",
        "1"
    );

    if (!$res) {
        return null;
    }

    $product_id = $res[0]['product_id'];

    return get_product_by_id($product_id);
}

function get_product_variants($product_id)
{
    global $LANG_CODE;

    $product_id = (int) $product_id;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select(
        "
        pv.id,
        pv.size_id,
        pv.color_id,
        s.name as size,
        c.hex,
        ct.name as color,
        pv.is_available,
        pv.stock
        ",
        "product_variants pv",
        "
        LEFT JOIN sizes s ON s.id = pv.size_id
        LEFT JOIN colors c ON c.id = pv.color_id
        LEFT JOIN color_translations ct 
            ON ct.color_id = c.id 
            AND ct.lang_code = '$LANG_CODE'
        ",
        "pv.product_id = $product_id AND pv.is_available = 1 AND pv.stock > 0"
    );
}

function get_product_count_by_category($category_id)
{
    $category_id = (int) $category_id;
    return db_count("products", "category_id = $category_id AND is_active = 1");
}

function get_product_sizes($product_id)
{
    global $LANG_CODE;

    $product_id = (int) $product_id;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select(
        "DISTINCT s.id, s.name",
        "product_variants pv",
        "
        LEFT JOIN sizes s ON s.id = pv.size_id
        ",
        "pv.product_id = $product_id AND pv.is_available = 1 AND pv.stock > 0",
        "s.id ASC"
    );
}

function get_product_colors($product_id)
{
    global $LANG_CODE;

    $product_id = (int) $product_id;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select(
        "DISTINCT c.id, c.hex, ct.name",
        "product_variants pv",
        "
        LEFT JOIN colors c ON c.id = pv.color_id
        LEFT JOIN color_translations ct 
            ON ct.color_id = c.id 
            AND ct.lang_code = '$LANG_CODE'
        ",
        "pv.product_id = $product_id AND pv.is_available = 1 AND pv.stock > 0",
        "c.id ASC"
    );
}

function get_categories()
{
    global $LANG_CODE;

    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select(
        "
        c.id,
        c.image,
        ct.name
        ",
        "categories c",
        "
        LEFT JOIN category_translations ct
            ON ct.category_id = c.id
            AND ct.lang_code = '$LANG_CODE'
        ",
        "1",
        "c.id ASC"
    );
}

function get_countries()
{
    return db_get_with_translation(
        "countries",
        "country_translations",
        "country_id",
        "1",
        "tt.name ASC"
    );
}

function get_payment_methods()
{
    return db_get_with_translation(
        "payment_methods",
        "payment_method_translations",
        "payment_method_id",
        "1"
    );
}

function get_last_user_address($user_id, $type)
{
    $user_id = (int) $user_id;
    $type = addslashes($type);

    $res = db_select(
        "*",
        "addresses",
        "",
        "user_id = $user_id AND type = '$type'",
        "created_at DESC",
        "1"
    );

    return $res[0] ?? null;
}

function get_country_by_id($country_id)
{
    global $LANG_CODE;
    $country_id = (int) $country_id;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    $res = db_select(
        "tt.name",
        "countries c",
        "JOIN country_translations tt ON tt.country_id = c.id AND tt.lang_code = '$LANG_CODE'",
        "c.id = $country_id"
    );

    return $res[0]['name'] ?? '';
}

function clear_cart($cart_id)
{
    $cart_id = (int) $cart_id;
    return my_query("DELETE FROM cart_items WHERE cart_id = $cart_id");
}

function get_cart_items($cart_id)
{
    global $LANG_CODE;

    $cart_id = (int) $cart_id;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select(
        "
        ci.id as cart_item_id,
        ci.quantity,

        pv.id as variant_id,

        p.id as product_id,
        p.image,
        p.price,

        pt.title,

        s.name as size,
        ct.name as color
        ",
        "cart_items ci",
        "
        LEFT JOIN product_variants pv ON pv.id = ci.variant_id
        LEFT JOIN products p ON p.id = pv.product_id

        LEFT JOIN product_translations pt 
            ON pt.product_id = p.id 
            AND pt.lang_code = '$LANG_CODE'

        LEFT JOIN sizes s ON s.id = pv.size_id

        LEFT JOIN colors c ON c.id = pv.color_id
        LEFT JOIN color_translations ct 
            ON ct.color_id = c.id 
            AND ct.lang_code = '$LANG_CODE'
        ",
        "ci.cart_id = $cart_id"
    );
}

function get_current_cart()
{
    $session_id = session_id();
    $user_id = $_SESSION['user_id'] ?? null;

    if ($user_id) {
        return db_get_one("carts", "user_id = $user_id");
    }

    return db_get_one("carts", "session_id = '" . addslashes($session_id) . "'");
}

function get_or_create_cart()
{
    $session_id = session_id();
    $user_id = $_SESSION['user_id'] ?? null;

    if ($user_id) {
        $cart = db_get_one("carts", "user_id = $user_id");

        if ($cart)
            return $cart;

        $cart_id = db_insert("carts", [
            'user_id' => $user_id,
            'session_id' => null
        ]);

        return db_get_one("carts", "id = $cart_id");
    }

    $cart = db_get_one("carts", "session_id = '" . addslashes($session_id) . "'");

    if ($cart)
        return $cart;

    $cart_id = db_insert("carts", [
        'user_id' => null,
        'session_id' => $session_id
    ]);

    return db_get_one("carts", "id = $cart_id");
}

function add_to_cart($variant_id, $quantity = 1)
{
    $cart = get_or_create_cart();
    $cart_id = $cart['id'];

    $existing = db_get_one(
        "cart_items",
        "cart_id = $cart_id AND variant_id = $variant_id"
    );

    if ($existing) {
        return my_query("
            UPDATE cart_items
            SET quantity = quantity + $quantity
            WHERE id = {$existing['id']}
        ");
    }

    return db_insert("cart_items", [
        'cart_id' => $cart_id,
        'variant_id' => $variant_id,
        'quantity' => $quantity
    ]);
}

function get_cart_item_quantity($cart_id, $variant_id)
{
    $cart_id = (int) $cart_id;
    $variant_id = (int) $variant_id;
    $res = db_get_one("cart_items", "cart_id = $cart_id AND variant_id = $variant_id");
    return $res ? (int) $res['quantity'] : 0;
}

function get_session_cart()
{
    $session_id = session_id();
    return db_get_one("carts", "session_id = '" . addslashes($session_id) . "'");
}

function get_user_cart($user_id)
{
    $user_id = (int) $user_id;
    return db_get_one("carts", "user_id = $user_id");
}

function attach_cart_to_user($cart_id, $user_id)
{
    $cart_id = (int) $cart_id;
    $user_id = (int) $user_id;
    return my_query("UPDATE carts SET user_id = $user_id, session_id = NULL WHERE id = $cart_id");
}

function delete_cart($cart_id)
{
    $cart_id = (int) $cart_id;
    my_query("DELETE FROM cart_items WHERE cart_id = $cart_id");
    return my_query("DELETE FROM carts WHERE id = $cart_id");
}

function merge_carts($session_cart_id, $user_cart_id)
{
    $session_cart_id = (int) $session_cart_id;
    $user_cart_id = (int) $user_cart_id;

    $session_items = db_get_all("cart_items", "cart_id = $session_cart_id");

    foreach ($session_items as $item) {
        $variant_id = $item['variant_id'];
        $quantity = $item['quantity'];

        $variant = db_get_one("product_variants", "id = $variant_id");
        $stock = $variant ? (int) $variant['stock'] : 0;

        // Verificar se já existe no carrinho do user
        $existing = db_get_one("cart_items", "cart_id = $user_cart_id AND variant_id = $variant_id");

        if ($existing) {
            $new_qty = min($existing['quantity'] + $quantity, $stock);
            my_query("UPDATE cart_items SET quantity = $new_qty WHERE id = {$existing['id']}");
        } else {
            $new_qty = min($quantity, $stock);
            if ($new_qty > 0) {
                db_insert("cart_items", [
                    'cart_id' => $user_cart_id,
                    'variant_id' => $variant_id,
                    'quantity' => $new_qty
                ]);
            }
        }
    }

    // Apagar o carrinho antigo da sessão
    return delete_cart($session_cart_id);
}

function get_variant_id($product_id, $size_id, $color_id)
{
    $product_id = (int) $product_id;
    $size_id = (int) $size_id;
    $color_id = (int) $color_id;

    $variant = db_get_one(
        "product_variants",
        "product_id = $product_id 
            AND size_id = $size_id 
            AND color_id = $color_id 
            AND is_available = 1"
    );

    return $variant['id'] ?? null;
}

function get_cart_totals($cart_id)
{
    $cart_id = (int) $cart_id;

    // Subtotal: sum of (price * quantity)
    $sql = "
        SELECT SUM(p.price * ci.quantity) as subtotal
        FROM cart_items ci
        JOIN product_variants pv ON pv.id = ci.variant_id
        JOIN products p ON p.id = pv.product_id
        WHERE ci.cart_id = $cart_id
    ";

    $res = my_query($sql);
    $subtotal = (float) ($res[0]['subtotal'] ?? 0);

    $shipping = $subtotal > 0 ? 10.0 : 0.0;
    $total = $subtotal + $shipping;

    return [
        'subtotal' => $subtotal,
        'shipping' => $shipping,
        'total' => $total
    ];
}

function get_filter_colors()
{
    global $LANG_CODE;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select_grouped(
        "
        c.id,
        c.hex,
        ct.name,
        COUNT(DISTINCT pv.product_id) as total
        ",
        "product_variants pv",
        "
        JOIN colors c ON c.id = pv.color_id
        LEFT JOIN color_translations ct 
            ON ct.color_id = c.id 
            AND ct.lang_code = '$LANG_CODE'
        ",
        "pv.is_available = 1 AND pv.stock > 0",
        "c.id",
        "ct.name ASC"
    );
}

function get_filter_sizes()
{
    return db_select_grouped(
        "
        s.id,
        s.name,
        COUNT(DISTINCT pv.product_id) as total
        ",
        "product_variants pv",
        "
        JOIN sizes s ON s.id = pv.size_id
        ",
        "pv.is_available = 1 AND pv.stock > 0",
        "s.id",
        "s.name ASC"
    );
}

function get_filter_prices()
{
    return db_select(
        "
        SUM(CASE WHEN p.price BETWEEN 0 AND 100 THEN 1 ELSE 0 END) as p1,
        SUM(CASE WHEN p.price BETWEEN 100 AND 200 THEN 1 ELSE 0 END) as p2,
        SUM(CASE WHEN p.price BETWEEN 200 AND 300 THEN 1 ELSE 0 END) as p3,
        SUM(CASE WHEN p.price BETWEEN 300 AND 400 THEN 1 ELSE 0 END) as p4,
        SUM(CASE WHEN p.price BETWEEN 400 AND 500 THEN 1 ELSE 0 END) as p5
        ",
        "products p",
        "",
        "p.is_active = 1"
    )[0];
}

function get_filter_categories()
{
    global $LANG_CODE;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select_grouped(
        "
        c.id,
        ct.name,
        COUNT(DISTINCT p.id) as total
        ",
        "products p",
        "
        JOIN product_variants pv ON pv.product_id = p.id
        JOIN categories c ON c.id = p.category_id
        LEFT JOIN category_translations ct 
            ON ct.category_id = c.id 
            AND ct.lang_code = '$LANG_CODE'
        ",
        "p.is_active = 1 AND pv.is_available = 1 AND pv.stock > 0",
        "c.id",
        "ct.name ASC"
    );
}

function get_products_filtered_count($filters = [])
{
    global $LANG_CODE;

    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    $joins = "
        JOIN product_variants pv ON pv.product_id = p.id
        LEFT JOIN product_translations pt 
            ON pt.product_id = p.id 
            AND pt.lang_code = '$LANG_CODE'
    ";

    $where = ["p.is_active = 1", "pv.is_available = 1"];

    if (!empty($filters['colors'])) {
        $colors = array_map('intval', $filters['colors']);
        $where[] = "pv.color_id IN (" . implode(',', $colors) . ")";
    }

    if (!empty($filters['sizes'])) {
        $sizes = array_map('intval', $filters['sizes']);
        $where[] = "pv.size_id IN (" . implode(',', $sizes) . ")";
    }

    if (!empty($filters['categories'])) {
        $categories = array_map('intval', $filters['categories']);
        $where[] = "p.category_id IN (" . implode(',', $categories) . ")";
    }

    if (!empty($filters['search'])) {
        $search = addslashes($filters['search']);
        $where[] = "pt.title LIKE '%$search%'";
    }

    if (!empty($filters['price'])) {
        $price_conditions = [];

        foreach ($filters['price'] as $range) {
            [$min, $max] = explode('-', $range);
            $price_conditions[] = "(p.price BETWEEN $min AND $max)";
        }

        $where[] = "(" . implode(" OR ", $price_conditions) . ")";
    }

    $where_sql = implode(" AND ", $where);

    $res = db_select(
        "COUNT(DISTINCT p.id) as total",
        "products p",
        $joins,
        $where_sql
    );

    return $res[0]['total'] ?? 0;
}

function build_query($overrides = [])
{
    $query = $_GET;

    foreach ($overrides as $key => $value) {
        $query[$key] = $value;
    }

    return '?' . http_build_query($query);
}

function get_stores()
{
    global $LANG_CODE;

    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select(
        "
        s.id,
        s.email,
        s.phone,
        st.name,
        st.address
        ",
        "stores s",
        "
        LEFT JOIN store_translations st
            ON st.store_id = s.id
            AND st.lang_code = '$LANG_CODE'
        ",
        "s.is_active = 1",
        "s.id ASC"
    );
}

function create_message($data)
{
    return db_insert("messages", [
        'name' => $data['name'],
        'email' => $data['email'],
        'subject' => $data['subject'],
        'message' => $data['message']
    ]);
}

function get_news_list($limit = 6, $offset = 0)
{
    global $LANG_CODE;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select(
        "n.*, nt.title, nt.slug, nt.short_description",
        "news n",
        "LEFT JOIN news_translations nt ON nt.news_id = n.id AND nt.lang_code = '$LANG_CODE'",
        "n.is_active = 1",
        "n.created_at DESC",
        "$offset, $limit"
    );
}

function get_news_by_slug($slug)
{
    global $LANG_CODE;
    $slug = addslashes($slug);
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    $res = db_select(
        "n.*, nt.*",
        "news n",
        "LEFT JOIN news_translations nt ON nt.news_id = n.id AND nt.lang_code = '$LANG_CODE'",
        "nt.slug = '$slug' AND n.is_active = 1",
        "",
        "1"
    );

    return $res[0] ?? null;
}

function get_news_count()
{
    return db_count("news", "is_active = 1");
}

function get_news_by_slug_any_lang($slug)
{
    $slug = addslashes($slug);

    $res = db_select(
        "nt.news_id",
        "news_translations nt",
        "",
        "nt.slug = '$slug'",
        "",
        "1"
    );

    if (!$res) {
        return null;
    }

    $news_id = $res[0]['news_id'];

    return db_select(
        "n.*, nt.*",
        "news n",
        "LEFT JOIN news_translations nt ON nt.news_id = n.id AND nt.lang_code = '" . addslashes($_SESSION['lingua'] ?? 'pt') . "'",
        "n.id = $news_id AND n.is_active = 1",
        "",
        "1"
    )[0] ?? null;
}

function get_product_reviews($product_id)
{
    $product_id = (int) $product_id;
    return db_get_all("reviews", "product_id = $product_id AND is_approved = 1", "created_at DESC");
}

function get_product_review_count($product_id)
{
    $product_id = (int) $product_id;
    return db_count("reviews", "product_id = $product_id AND is_approved = 1");
}

function get_product_average_rating($product_id)
{
    $product_id = (int) $product_id;
    $sql = "SELECT AVG(rating) as average FROM reviews WHERE product_id = $product_id AND is_approved = 1";
    $res = my_query($sql);
    return (float) ($res[0]['average'] ?? 0);
}

function insert_review($data)
{
    return db_insert("reviews", [
        'product_id' => (int) $data['product_id'],
        'user_id' => $data['user_id'] ? (int) $data['user_id'] : null,
        'name' => $data['name'],
        'email' => $data['email'],
        'rating' => (int) $data['rating'],
        'comment' => $data['comment'],
        'is_approved' => 0
    ]);
}

function toggle_review_approval($id)
{
    $id = (int) $id;
    $review = db_get_one("reviews", "id = $id");
    if (!$review)
        return false;

    $new_status = $review['is_approved'] ? 0 : 1;
    return db_update("reviews", ['is_approved' => $new_status], "id = $id");
}

function delete_review($id)
{
    $id = (int) $id;
    return db_delete("reviews", "id = $id");
}

/**
 * Wishlist Functions
 */
function add_to_wishlist($user_id, $product_id)
{
    $user_id = (int) $user_id;
    $product_id = (int) $product_id;

    if (is_product_in_wishlist($user_id, $product_id)) {
        return true;
    }

    return db_insert("wishlist", [
        'user_id' => $user_id,
        'product_id' => $product_id
    ]);
}

function remove_from_wishlist($user_id, $product_id)
{
    $user_id = (int) $user_id;
    $product_id = (int) $product_id;
    return db_delete("wishlist", "user_id = $user_id AND product_id = $product_id");
}

function is_product_in_wishlist($user_id, $product_id)
{
    if (!$user_id)
        return false;
    $user_id = (int) $user_id;
    $product_id = (int) $product_id;
    return db_count("wishlist", "user_id = $user_id AND product_id = $product_id") > 0;
}

function get_user_wishlist($user_id)
{
    global $LANG_CODE;
    $user_id = (int) $user_id;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select(
        "p.*, pt.title, pt.slug",
        "wishlist w",
        "JOIN products p ON p.id = w.product_id
         LEFT JOIN product_translations pt ON pt.product_id = p.id AND pt.lang_code = '$LANG_CODE'",
        "w.user_id = $user_id",
        "w.created_at DESC"
    );
}

function get_wishlist_count($user_id)
{
    if (!$user_id)
        return 0;
    $user_id = (int) $user_id;
    return db_count("wishlist", "user_id = $user_id");
}

/**
 * Stock Management Functions
 */
function variant_has_stock($variant_id, $quantity = 1)
{
    $variant_id = (int) $variant_id;
    $quantity = (int) $quantity;
    $variant = db_get_one("product_variants", "id = $variant_id");
    return $variant && $variant['stock'] >= $quantity;
}

function reduce_variant_stock($variant_id, $quantity)
{
    $variant_id = (int) $variant_id;
    $quantity = (int) $quantity;
    return my_query("UPDATE product_variants SET stock = stock - $quantity WHERE id = $variant_id AND stock >= $quantity");
}

/**
 * User Profile & Orders Functions
 */
function get_user_orders($user_id)
{
    $user_id = (int) $user_id;
    return db_select("*", "orders", "", "user_id = $user_id", "created_at DESC");
}

function get_order_items_detailed($order_id)
{
    global $LANG_CODE;
    $order_id = (int) $order_id;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select(
        "oi.*, p.image, pt.slug, s.name as size_name, ct.name as color_name",
        "order_items oi",
        "LEFT JOIN products p ON p.id = oi.product_id
         LEFT JOIN product_translations pt ON pt.product_id = p.id AND pt.lang_code = '$LANG_CODE'
         LEFT JOIN product_variants pv ON pv.id = oi.variant_id
         LEFT JOIN sizes s ON s.id = pv.size_id
         LEFT JOIN color_translations ct ON ct.color_id = pv.color_id AND ct.lang_code = '$LANG_CODE'",
        "oi.order_id = $order_id"
    );
}

function get_order_address($order_id, $type = 'shipping')
{
    $order_id = (int) $order_id;
    $type = addslashes($type);
    return db_get_one("order_addresses", "order_id = $order_id AND type = '$type'");
}

function get_user_stats($user_id)
{
    $user_id = (int) $user_id;
    $orders = db_get_all("orders", "user_id = $user_id");

    $total_orders = count($orders);
    $total_spent = 0;
    $last_order_date = null;

    if ($total_orders > 0) {
        foreach ($orders as $order) {
            $total_spent += $order['total'];
        }
        $last_order_date = $orders[0]['created_at']; // Since orders are DESC
    }

    return [
        'total_orders' => $total_orders,
        'total_spent' => $total_spent,
        'last_order_date' => $last_order_date
    ];
}

function update_user_profile($user_id, $data)
{
    $user_id = (int) $user_id;
    return db_update("users", $data, "id = $user_id");
}

function change_user_password($user_id, $current_password, $new_password)
{
    $user_id = (int) $user_id;
    $user = db_get_one("users", "id = $user_id");

    if (!$user || !password_verify($current_password, $user['password'])) {
        return false;
    }

    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
    return db_update("users", ['password' => $new_hash], "id = $user_id");
}

// Settings Helpers
function get_setting($key, $default = null)
{
    $key = addslashes($key);
    $res = db_get_one("settings", "settings_key = '$key'");
    return $res ? $res['settings_value'] : $default;
}

function set_setting($key, $value)
{
    $key = addslashes($key);
    $value = addslashes($value);
    $existing = db_get_one("settings", "settings_key = '$key'");
    if ($existing) {
        return db_update("settings", ['settings_value' => $value], "settings_key = '$key'");
    } else {
        return db_insert("settings", ['settings_key' => $key, 'settings_value' => $value]);
    }
}

// Email System
function send_email($to, $subject, $body, $isHtml = true)
{
    require_once 'vendor/PHPMailer/PHPMailer.php';
    require_once 'vendor/PHPMailer/SMTP.php';
    require_once 'vendor/PHPMailer/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = get_setting('smtp_host');
        $mail->SMTPAuth = true;
        $mail->Username = get_setting('smtp_user');
        $mail->Password = get_setting('smtp_pass');
        $mail->SMTPSecure = get_setting('smtp_encryption'); // tls or ssl
        $mail->Port = get_setting('smtp_port');
        $mail->CharSet = 'UTF-8';

        // Recipients
        $mail->setFrom(get_setting('smtp_from_email'), get_setting('smtp_from_name'));
        $mail->addAddress($to);

        // Content
        $mail->isHTML($isHtml);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        return false;
    }
}

// Password Reset Logic
function create_password_reset($email)
{
    $email = addslashes($email);
    $user = db_get_one("users", "email = '$email'");

    // Generic success response logic: we always say "check your email" in the UI
    if (!$user)
        return true;

    // Rate Limiting: Max 3 requests per hour per email/IP
    $ip = $_SERVER['REMOTE_ADDR'];
    $oneHourAgo = date('Y-m-d H:i:s', strtotime('-1 hour'));

    $recentRequests = db_count("password_resets", "ip_address = '$ip' AND created_at > '$oneHourAgo'");
    $recentEmailRequests = db_count("password_resets", "user_id = {$user['id']} AND created_at > '$oneHourAgo'");

    if ($recentRequests >= 3 || $recentEmailRequests >= 3) {
        return "rate_limited";
    }

    // Invalidate previous active tokens for this user
    db_delete("password_resets", "user_id = {$user['id']}");

    // Generate secure token
    $token = bin2hex(random_bytes(32));
    $token_hash = hash('sha256', $token);
    $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

    db_insert("password_resets", [
        'user_id' => $user['id'],
        'token_hash' => $token_hash,
        'expires_at' => $expires_at,
        'ip_address' => $ip
    ]);

    // Send Email
    global $SETTINGS;
    $reset_link = $SETTINGS['url_site'] . "/reset-password.php?token=" . $token;

    $subject = "Reset Your Password - " . $SETTINGS['url_site'];
    $body = "
    <html>
    <body style='font-family: Arial, sans-serif; color: #333;'>
        <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
            <h2 style='color: #D19C97;'>Password Reset Request</h2>
            <p>Hello,</p>
            <p>We received a request to reset your password. If you didn't make this request, you can safely ignore this email.</p>
            <p>To reset your password, click the button below. This link will expire in 1 hour.</p>
            <div style='text-align: center; margin: 30px 0;'>
                <a href='$reset_link' style='background-color: #D19C97; color: white; padding: 15px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Reset Password</a>
            </div>
            <p>Or copy and paste this link into your browser:</p>
            <p style='word-break: break-all; color: #666;'>$reset_link</p>
            <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
            <p style='font-size: 12px; color: #999;'>This is an automated message, please do not reply.</p>
        </div>
    </body>
    </html>";

    return send_email($email, $subject, $body);
}

function validate_reset_token($token)
{
    $token_hash = hash('sha256', $token);
    $now = date('Y-m-d H:i:s');

    $reset = db_get_one("password_resets", "token_hash = '$token_hash' AND expires_at > '$now'");
    return $reset ? $reset['user_id'] : false;
}

function reset_user_password($user_id, $new_password, $token)
{
    $user_id = (int) $user_id;
    $hashed = password_hash($new_password, PASSWORD_DEFAULT);

    if (db_update("users", ['password' => $hashed], "id = $user_id")) {
        // Delete token after successful reset
        $token_hash = hash('sha256', $token);
        db_delete("password_resets", "token_hash = '$token_hash'");
        return true;
    }
    return false;
}

// SEO & URL HELPERS
function get_url($path = '')
{
    global $SETTINGS;
    $url_parts = parse_url($SETTINGS['url_site']);
    $base = rtrim($url_parts['path'] ?? '', '/');

    // Simplistic pretty URL mapping
    if ($path == 'index.php' || $path == '')
        return $base . '/';
    if ($path == 'shop.php')
        return $base . '/shop';
    if ($path == 'cart.php')
        return $base . '/cart';
    if ($path == 'checkout.php')
        return $base . '/checkout';
    if ($path == 'wishlist.php')
        return $base . '/wishlist';
    if ($path == 'profile.php')
        return $base . '/profile';
    if ($path == 'login.php')
        return $base . '/login';
    if ($path == 'register.php')
        return $base . '/register';
    if ($path == 'contact.php')
        return $base . '/contact';
    if ($path == 'about.php')
        return $base . '/about';
    if ($path == 'news.php')
        return $base . '/news';

    // Detail pages with slugs
    if (preg_match('/detail\.php\?slug=(.+)/', $path, $matches)) {
        return $base . '/product/' . $matches[1];
    }
    if (preg_match('/news-detail\.php\?slug=(.+)/', $path, $matches)) {
        return $base . '/news/' . $matches[1];
    }
    if (preg_match('/shop\.php\?categories\[\]=(.+)/', $path, $matches)) {
        return $base . '/shop?categories[]=' . $matches[1];
    }

    return $base . '/' . ltrim($path, '/');
}

function get_social_links($only_active = true)
{
    $where = $only_active ? "is_active = 1" : "1";
    return db_get_all('social_links', $where, 'sort_order ASC, platform ASC');
}
