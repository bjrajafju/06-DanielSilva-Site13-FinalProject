<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$order = db_select("o.*, u.first_name, u.last_name, u.email as user_email, pm.code as pm_code", "orders o", "LEFT JOIN users u ON u.id = o.user_id LEFT JOIN payment_methods pm ON pm.id = o.payment_method_id", "o.id = $id")[0] ?? null;

if (!$order) redirect("orders.php");

$items = db_get_all('order_items', "order_id = $id");
$addresses = db_get_all('order_addresses', "order_id = $id");

// Handle Status Update
if (isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    db_update('orders', ['status' => $new_status], "id = $id");
    set_alert("Order status updated to $new_status");
    redirect("order_view.php?id=$id");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Order Details #<?= $id ?></h2>
        <a href="orders.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back to List</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="row">
            <div class="col-lg-8">
                <!-- Order Items -->
                <div class="card mb-4">
                    <div class="card-header">Items</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Variant</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td><?= $item['product_title'] ?></td>
                                            <td>ID: <?= $item['variant_id'] ?></td>
                                            <td><?= number_format($item['price'], 2) ?>€</td>
                                            <td><?= $item['quantity'] ?></td>
                                            <td class="text-right"><?= number_format($item['price'] * $item['quantity'], 2) ?>€</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">Subtotal</th>
                                        <th class="text-right"><?= number_format($order['subtotal'], 2) ?>€</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Shipping</th>
                                        <th class="text-right"><?= number_format($order['shipping'], 2) ?>€</th>
                                    </tr>
                                    <tr class="table-light">
                                        <th colspan="4" class="text-right h5">Total</th>
                                        <th class="text-right h5"><?= number_format($order['total'], 2) ?>€</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Addresses -->
                <div class="row">
                    <?php foreach ($addresses as $addr): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header"><?= ucfirst($addr['type']) ?> Address</div>
                                <div class="card-body">
                                    <strong><?= $addr['first_name'] . ' ' . $addr['last_name'] ?></strong><br>
                                    <?= $addr['address_line1'] ?><br>
                                    <?= $addr['address_line2'] ? $addr['address_line2'] . '<br>' : '' ?>
                                    <?= $addr['postal_code'] . ' ' . $addr['city'] ?><br>
                                    <?= $addr['state'] . ', ' . $addr['country_name'] ?><br>
                                    <i class="fas fa-phone"></i> <?= $addr['mobile'] ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Status -->
                <div class="card mb-4">
                    <div class="card-header">Order Status</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <select name="status" class="form-control mb-3">
                                    <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="paid" <?= $order['status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
                                    <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                                <button type="submit" name="update_status" class="btn btn-primary w-100">Update Status</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Info -->
                <div class="card mb-4">
                    <div class="card-header">Information</div>
                    <div class="card-body">
                        <p><strong>Date:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                        <p><strong>Payment Method:</strong> <?= strtoupper($order['pm_code'] ?? 'N/A') ?></p>
                        <p><strong>Customer:</strong> <?= $order['first_name'] ? $order['first_name'] . ' ' . $order['last_name'] : 'Guest' ?></p>
                        <p><strong>Email:</strong> <?= $order['user_email'] ?? 'N/A' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

