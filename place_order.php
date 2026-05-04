<?php
include_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: checkout.php");
    exit;
}

$cart = get_current_cart();
if (!$cart) {
    header("Location: index.php");
    exit;
}

$cart_items = get_cart_items($cart['id']);
if (!$cart_items) {
    header("Location: cart.php");
    exit;
}

$totals = get_cart_totals($cart['id']);
$user_id = $_SESSION['user_id'] ?? null;

// Billing Address Data
$billing = [
    'first_name' => $_POST['billing_first_name'] ?? '',
    'last_name' => $_POST['billing_last_name'] ?? '',
    'email' => $_POST['billing_email'] ?? '',
    'mobile' => $_POST['billing_mobile'] ?? '',
    'address_line1' => $_POST['billing_address_line1'] ?? '',
    'address_line2' => $_POST['billing_address_line2'] ?? '',
    'country_id' => (int)($_POST['billing_country_id'] ?? 0),
    'city' => $_POST['billing_city'] ?? '',
    'state' => $_POST['billing_state'] ?? '',
    'postal_code' => $_POST['billing_postal_code'] ?? '',
];

// Shipping Address Data
$use_billing_as_shipping = !isset($_POST['shipto']);
if ($use_billing_as_shipping) {
    $shipping = $billing;
} else {
    $shipping = [
        'first_name' => $_POST['shipping_first_name'] ?? '',
        'last_name' => $_POST['shipping_last_name'] ?? '',
        'email' => $_POST['shipping_email'] ?? '',
        'mobile' => $_POST['shipping_mobile'] ?? '',
        'address_line1' => $_POST['shipping_address_line1'] ?? '',
        'address_line2' => $_POST['shipping_address_line2'] ?? '',
        'country_id' => (int)($_POST['shipping_country_id'] ?? 0),
        'city' => $_POST['shipping_city'] ?? '',
        'state' => $_POST['shipping_state'] ?? '',
        'postal_code' => $_POST['shipping_postal_code'] ?? '',
    ];
}

$payment_method_id = (int)($_POST['payment_method_id'] ?? 0);

// Simple Validation
if (empty($billing['first_name']) || empty($billing['address_line1']) || !$billing['country_id'] || !$payment_method_id) {
    die("Error: Missing required fields.");
}

// 1. Save addresses to `addresses` table if logged in
if ($user_id) {
    // Helper to process address save/update
    function save_user_address($user_id, $type, $data) {
        global $SETTINGS;
        $existing = get_last_user_address($user_id, $type);
        
        $db_data = [
            'user_id' => $user_id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'mobile' => $data['mobile'],
            'address_line1' => $data['address_line1'],
            'address_line2' => $data['address_line2'],
            'city' => $data['city'],
            'state' => $data['state'],
            'postal_code' => $data['postal_code'],
            'country_id' => $data['country_id'],
            'type' => $type
        ];

        if ($existing) {
            $fields = [];
            foreach ($db_data as $k => $v) {
                if ($v === null) {
                    $fields[] = "$k = NULL";
                } else {
                    $fields[] = "$k = '" . $SETTINGS['conn']->real_escape_string($v) . "'";
                }
            }
            return my_query("UPDATE addresses SET " . implode(', ', $fields) . " WHERE id = {$existing['id']}");
        } else {
            return db_insert("addresses", $db_data);
        }
    }

    save_user_address($user_id, 'billing', $billing);
    save_user_address($user_id, 'shipping', $shipping);
}

// 2. Create Order
$order_id = db_insert("orders", [
    'user_id' => $user_id,
    'payment_method_id' => $payment_method_id,
    'subtotal' => $totals['subtotal'],
    'shipping' => $totals['shipping'],
    'total' => $totals['total'],
    'status' => 'pending'
]);

if (!$order_id) {
    die("Error: Could not create order.");
}

// 3. Create Order Items (Snapshot)
foreach ($cart_items as $item) {
    db_insert("order_items", [
        'order_id' => $order_id,
        'product_id' => $item['product_id'],
        'variant_id' => $item['variant_id'],
        'product_title' => $item['title'],
        'price' => $item['price'],
        'quantity' => $item['quantity']
    ]);
}

// 4. Save Address Snapshots
$billing_country_name = get_country_by_id($billing['country_id']);
$shipping_country_name = get_country_by_id($shipping['country_id']);

// Billing Snapshot
db_insert("order_addresses", [
    'order_id' => $order_id,
    'type' => 'billing',
    'first_name' => $billing['first_name'],
    'last_name' => $billing['last_name'],
    'mobile' => $billing['mobile'],
    'address_line1' => $billing['address_line1'],
    'address_line2' => $billing['address_line2'], 
    'city' => $billing['city'],
    'state' => $billing['state'],
    'postal_code' => $billing['postal_code'],
    'country_name' => $billing_country_name
]);

// Shipping Snapshot
db_insert("order_addresses", [
    'order_id' => $order_id,
    'type' => 'shipping',
    'first_name' => $shipping['first_name'],
    'last_name' => $shipping['last_name'],
    'mobile' => $shipping['mobile'],
    'address_line1' => $shipping['address_line1'],
    'address_line2' => $shipping['address_line2'], 
    'city' => $shipping['city'],
    'state' => $shipping['state'],
    'postal_code' => $shipping['postal_code'],
    'country_name' => $shipping_country_name
]);

// 5. Clear Cart
clear_cart($cart['id']);

header("Location: order_success.php?order_id=" . $order_id);
exit;
