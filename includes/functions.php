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
        SELECT t.*, tt.*
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
        "t.is_active = 1"
    );
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
