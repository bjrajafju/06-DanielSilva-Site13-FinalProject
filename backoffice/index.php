<?php
include_once 'includes/helpers.php';

$total_products = db_count('products');
$total_orders = db_count('orders');
$total_users = db_count('users');
$total_messages = db_count('messages', 'is_read = 0');

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Dashboard</h2>
        <div>
            <span class="text-muted me-3"><?= date('D, d M Y') ?></span>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Products Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Products</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_products ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-box-seam fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_orders ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-cart-check fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_users ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-people fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Unread Messages</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_messages ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-envelope fs-2 text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">Recent Orders</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $recent_orders = db_select("o.*, u.first_name, u.last_name", "orders o", "LEFT JOIN users u ON u.id = o.user_id", "1", "o.id DESC", "5");
                                    foreach ($recent_orders as $order): ?>
                                        <tr>
                                            <td>#<?= $order['id'] ?></td>
                                            <td><?= $order['first_name'] ? $order['first_name'] . ' ' . $order['last_name'] : 'Guest' ?></td>
                                            <td><?= number_format($order['total'], 2) ?>€</td>
                                            <td><span class="badge bg-<?= $order['status'] == 'completed' ? 'success' : ($order['status'] == 'pending' ? 'warning' : 'info') ?>"><?= $order['status'] ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">Recent Messages</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>From</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $recent_msgs = db_get_all("messages", "1", "id DESC", "5");
                                    foreach ($recent_msgs as $msg): ?>
                                        <tr>
                                            <td><?= $msg['name'] ?></td>
                                            <td><?= $msg['subject'] ?></td>
                                            <td><?= date('d/m/Y', strtotime($msg['created_at'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>