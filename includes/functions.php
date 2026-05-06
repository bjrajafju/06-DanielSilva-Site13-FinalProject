<?php
// Genericas para qualquer projeto
// todos
function db_get_all($table, $where = "1", $order = "id DESC", $limit = "")
{
    $sql = "SELECT * FROM $table WHERE $where ORDER BY $order $limit";
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

    if ($joins) $sql .= " $joins";

    $sql .= " WHERE $where";

    if ($group) $sql .= " GROUP BY $group";

    if ($order) $sql .= " ORDER BY $order";

    if ($limit) $sql .= " LIMIT $limit";

    return my_query($sql);
}

// insert generico
function db_insert($table, $data)
{
    global $SETTINGS;
    $fields = array_keys($data);
    $values = array_map(function ($v) use ($SETTINGS) {
        if ($v === null) return "NULL";
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

    return db_select(
        "p.*, pt.title, pt.slug, pt.short_description",
        "products p",
        "
        LEFT JOIN product_translations pt 
            ON pt.product_id = p.id 
            AND pt.lang_code = '$LANG_CODE'
        ",
        "p.is_active = 1",
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

    $where = ["p.is_active = 1", "pv.is_available = 1"];

    if (!empty($filters['colors'])) {
        $colors = array_map('intval', $filters['colors']);
        $where[] = "pv.color_id IN (" . implode(',', $colors) . ")";
    }

    if (!empty($filters['sizes'])) {
        $sizes = array_map('intval', $filters['sizes']);
        $where[] = "pv.size_id IN (" . implode(',', $sizes) . ")";
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

    return db_select_grouped(
        "p.*, pt.title, pt.slug, pt.short_description",
        "products p",
        $joins,
        $where_sql,
        "p.id",
        "p.id DESC",
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

    $id = (int)$id;
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

    $product_id = (int)$product_id;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select(
        "
        pv.id,
        s.name as size,
        c.hex,
        ct.name as color,
        pv.is_available
        ",
        "product_variants pv",
        "
        LEFT JOIN sizes s ON s.id = pv.size_id
        LEFT JOIN colors c ON c.id = pv.color_id
        LEFT JOIN color_translations ct 
            ON ct.color_id = c.id 
            AND ct.lang_code = '$LANG_CODE'
        ",
        "pv.product_id = $product_id AND pv.is_available = 1"
    );
}

function get_product_count_by_category($category_id)
{
    $category_id = (int)$category_id;
    return db_count("products", "category_id = $category_id AND is_active = 1");
}

function get_product_sizes($product_id)
{
    global $LANG_CODE;

    $product_id = (int)$product_id;
    $LANG_CODE = addslashes($LANG_CODE ?? 'pt');

    return db_select(
        "DISTINCT s.id, s.name",
        "product_variants pv",
        "
        LEFT JOIN sizes s ON s.id = pv.size_id
        ",
        "pv.product_id = $product_id AND pv.is_available = 1",
        "s.id ASC"
    );
}

function get_product_colors($product_id)
{
    global $LANG_CODE;

    $product_id = (int)$product_id;
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
        "pv.product_id = $product_id AND pv.is_available = 1",
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
    $user_id = (int)$user_id;
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
    $country_id = (int)$country_id;
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
    $cart_id = (int)$cart_id;
    return my_query("DELETE FROM cart_items WHERE cart_id = $cart_id");
}

function get_cart_items($cart_id)
{
    global $LANG_CODE;

    $cart_id = (int)$cart_id;
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

        if ($cart) return $cart;

        $cart_id = db_insert("carts", [
            'user_id' => $user_id,
            'session_id' => null
        ]);

        return db_get_one("carts", "id = $cart_id");
    }

    $cart = db_get_one("carts", "session_id = '" . addslashes($session_id) . "'");

    if ($cart) return $cart;

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

function get_session_cart()
{
    $session_id = session_id();
    return db_get_one("carts", "session_id = '" . addslashes($session_id) . "'");
}

function get_user_cart($user_id)
{
    $user_id = (int)$user_id;
    return db_get_one("carts", "user_id = $user_id");
}

function attach_cart_to_user($cart_id, $user_id)
{
    $cart_id = (int)$cart_id;
    $user_id = (int)$user_id;
    return my_query("UPDATE carts SET user_id = $user_id, session_id = NULL WHERE id = $cart_id");
}

function delete_cart($cart_id)
{
    $cart_id = (int)$cart_id;
    my_query("DELETE FROM cart_items WHERE cart_id = $cart_id");
    return my_query("DELETE FROM carts WHERE id = $cart_id");
}

function merge_carts($session_cart_id, $user_cart_id)
{
    $session_cart_id = (int)$session_cart_id;
    $user_cart_id = (int)$user_cart_id;

    $session_items = db_get_all("cart_items", "cart_id = $session_cart_id");

    foreach ($session_items as $item) {
        $variant_id = $item['variant_id'];
        $quantity = $item['quantity'];

        // Verificar se já existe no carrinho do user
        $existing = db_get_one("cart_items", "cart_id = $user_cart_id AND variant_id = $variant_id");

        if ($existing) {
            my_query("UPDATE cart_items SET quantity = quantity + $quantity WHERE id = {$existing['id']}");
        } else {
            db_insert("cart_items", [
                'cart_id' => $user_cart_id,
                'variant_id' => $variant_id,
                'quantity' => $quantity
            ]);
        }
    }

    // Apagar o carrinho antigo da sessão
    return delete_cart($session_cart_id);
}

function get_variant_id($product_id, $size_id, $color_id)
{
    $product_id = (int)$product_id;
    $size_id = (int)$size_id;
    $color_id = (int)$color_id;

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
    $cart_id = (int)$cart_id;

    // Subtotal: sum of (price * quantity)
    $sql = "
        SELECT SUM(p.price * ci.quantity) as subtotal
        FROM cart_items ci
        JOIN product_variants pv ON pv.id = ci.variant_id
        JOIN products p ON p.id = pv.product_id
        WHERE ci.cart_id = $cart_id
    ";

    $res = my_query($sql);
    $subtotal = (float)($res[0]['subtotal'] ?? 0);

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
        "pv.is_available = 1",
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
        "pv.is_available = 1",
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
        'name'    => $data['name'],
        'email'   => $data['email'],
        'subject' => $data['subject'],
        'message' => $data['message']
    ]);
}
