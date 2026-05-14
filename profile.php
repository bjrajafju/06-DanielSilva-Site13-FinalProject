<?php
include_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user = db_get_one("users", "id = $user_id");
$stats = get_user_stats($user_id);
$orders = get_user_orders($user_id);

$section = $_GET['section'] ?? 'dashboard';

$success_msg = "";
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $data = [
            'first_name' => addslashes($_POST['first_name']),
            'last_name' => addslashes($_POST['last_name']),
            'email' => addslashes($_POST['email']),
            'mobile' => addslashes($_POST['mobile'])
        ];

        $existing = db_get_one("users", "email = '{$data['email']}' AND id != $user_id");
        if ($existing) {
            $error_msg = "Email already in use.";
        } else {
            if (update_user_profile($user_id, $data)) {
                $_SESSION['user_first_name'] = $data['first_name'];
                $success_msg = "Profile updated successfully!";
                $user = db_get_one("users", "id = $user_id");
            } else {
                $error_msg = "Error updating profile.";
            }
        }
    }

    if (isset($_POST['change_password'])) {
        $current = $_POST['current_password'];
        $new = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];

        if ($new !== $confirm) {
            $error_msg = "New passwords do not match.";
        } else {
            if (change_user_password($user_id, $current, $new)) {
                $success_msg = "Password changed successfully!";
                unset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_password']);
            } else {
                $error_msg = "Incorrect current password.";
            }
        }
    }
}

include 'includes/header.php';
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('profile.header.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="index.php"><?= t('header.nav.home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('profile.header.title') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Profile Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-5">
            <div class="card border-secondary mb-3 shadow-sm">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0"><?= t('profile.menu.dashboard') ?></h4>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="?section=dashboard" class="list-group-item list-group-item-action <?= $section == 'dashboard' ? 'active' : '' ?>">
                            <i class="fas fa-tachometer-alt mr-2"></i> <?= t('profile.menu.dashboard') ?>
                        </a>
                        <a href="?section=orders" class="list-group-item list-group-item-action <?= $section == 'orders' ? 'active' : '' ?>">
                            <i class="fas fa-box mr-2"></i> <?= t('profile.menu.orders') ?>
                        </a>
                        <a href="wishlist.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-heart mr-2"></i> <?= t('header.nav.wishlist') ?>
                        </a>
                        <a href="?section=settings" class="list-group-item list-group-item-action <?= $section == 'settings' ? 'active' : '' ?>">
                            <i class="fas fa-cog mr-2"></i> <?= t('profile.menu.settings') ?>
                        </a>
                        <a href="logout.php" class="list-group-item list-group-item-action text-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i> <?= t('header.nav.logout') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">
            <?php if ($success_msg): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $success_msg ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ($error_msg): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $error_msg ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ($section == 'dashboard'): ?>
                <div class="mb-4">
                    <h3 class="font-weight-semi-bold"><?= t('profile.dashboard.greeting') ?>, <?= $_SESSION['user_first_name'] ?>!</h3>
                    <p class="text-muted"><i class="fas fa-calendar-alt mr-1"></i> <?= t('profile.dashboard.member_since') ?>: <?= date('F Y', strtotime($user['created_at'])) ?></p>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card text-center border-secondary shadow-sm">
                            <div class="card-body">
                                <h1 class="display-4 text-primary"><?= $stats['total_orders'] ?></h1>
                                <h5 class="font-weight-semi-bold"><?= t('profile.stats.total_orders') ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card text-center border-secondary shadow-sm">
                            <div class="card-body">
                                <h1 class="display-4 text-primary"><?= number_format($stats['total_spent'], 2) ?> €</h1>
                                <h5 class="font-weight-semi-bold"><?= t('profile.stats.total_spent') ?></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-secondary mb-5 shadow-sm">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0"><?= t('profile.dashboard.recent_orders') ?></h4>
                    </div>
                    <div class="card-body">
                        <?php if (empty($orders)): ?>
                            <div class="text-center py-4">
                                <p><?= t('profile.orders.empty') ?></p>
                                <a href="shop.php" class="btn btn-primary"><?= t('profile.orders.btn_shop') ?></a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center mb-0">
                                    <thead class="bg-secondary text-dark">
                                        <tr>
                                            <th><?= t('profile.orders.table.id') ?></th>
                                            <th><?= t('profile.orders.table.date') ?></th>
                                            <th><?= t('profile.orders.table.total') ?></th>
                                            <th><?= t('profile.orders.table.status') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 0; $i < min(3, count($orders)); $i++): $o = $orders[$i]; ?>
                                            <tr>
                                                <td class="align-middle">#<?= $o['id'] ?></td>
                                                <td class="align-middle"><?= date('d/m/Y', strtotime($o['created_at'])) ?></td>
                                                <td class="align-middle"><?= number_format($o['total'], 2) ?> €</td>
                                                <td class="align-middle">
                                                    <?php
                                                    $status_class = 'badge-primary';
                                                    if ($o['status'] == 'completed') $status_class = 'badge-success';
                                                    if ($o['status'] == 'pending') $status_class = 'badge-warning';
                                                    if ($o['status'] == 'cancelled') $status_class = 'badge-danger';
                                                    ?>
                                                    <span class="badge <?= $status_class ?> text-uppercase"><?= $o['status'] ?></span>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-3">
                                <a href="?section=orders" class="btn btn-outline-primary btn-sm"><?= t('profile.orders.view_details') ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif ($section == 'orders'): ?>
                <div class="card border-secondary mb-5 shadow-sm">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0"><?= t('profile.menu.orders') ?></h4>
                    </div>
                    <div class="card-body">
                        <?php if (empty($orders)): ?>
                            <p class="text-center py-4"><?= t('profile.orders.empty') ?></p>
                        <?php else: ?>
                            <div class="accordion" id="ordersAccordion">
                                <?php foreach ($orders as $o): ?>
                                    <div class="card border-secondary mb-3 shadow-sm">
                                        <div class="card-header bg-white" id="heading<?= $o['id'] ?>">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                    <h6 class="mb-0 font-weight-bold"><?= t('profile.orders.table.id') ?> <?= $o['id'] ?></h6>
                                                    <small class="text-muted"><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></small>
                                                </div>
                                                <div class="col-md-3">
                                                    <?php
                                                    $status_class = 'badge-primary';
                                                    if ($o['status'] == 'completed') $status_class = 'badge-success';
                                                    if ($o['status'] == 'pending') $status_class = 'badge-warning';
                                                    if ($o['status'] == 'cancelled') $status_class = 'badge-danger';
                                                    ?>
                                                    <span class="badge <?= $status_class ?> text-uppercase"><?= $o['status'] ?></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <h6 class="mb-0 font-weight-bold text-primary"><?= number_format($o['total'], 2) ?> €</h6>
                                                </div>
                                                <div class="col-md-3 text-right">
                                                    <button class="btn btn-sm btn-outline-primary px-3" type="button" data-toggle="collapse" data-target="#collapse<?= $o['id'] ?>">
                                                        <i class="fas fa-eye mr-1"></i> <?= t('profile.orders.view_details') ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="collapse<?= $o['id'] ?>" class="collapse" data-parent="#ordersAccordion">
                                            <div class="card-body bg-light">
                                                <table class="table table-sm table-borderless mb-0">
                                                    <thead class="border-bottom">
                                                        <tr>
                                                            <th><?= t('profile.orders.items') ?></th>
                                                            <th class="text-center">Qty</th>
                                                            <th class="text-right">Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $items = get_order_items_detailed($o['id']);
                                                        foreach ($items as $item): ?>
                                                            <tr class="border-bottom-dashed">
                                                                <td>
                                                                    <div class="d-flex align-items-center py-1">
                                                                        <img src="<?= $SETTINGS['url_site'] ?>/<?= $item['image'] ?>" alt="" style="width: 45px; height: 45px; object-fit: cover; border-radius: 4px; margin-right: 12px; border: 1px solid #dee2e6;">
                                                                        <div>
                                                                            <a href="detail.php?slug=<?= $item['slug'] ?>" class="text-dark font-weight-medium d-block"><?= $item['product_title'] ?></a>
                                                                            <small class="text-muted"><?= $item['size_name'] ?> / <?= $item['color_name'] ?></small>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center align-middle">x<?= $item['quantity'] ?></td>
                                                                <td class="text-right align-middle font-weight-semi-bold"><?= number_format($item['price'], 2) ?> €</td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>

                                                <div class="row mt-4 pt-3 border-top">
                                                    <div class="col-md-6">
                                                        <h6 class="font-weight-bold mb-3"><i class="fas fa-shipping-fast text-primary mr-2"></i> <?= t('profile.orders.shipping_address') ?></h6>
                                                        <?php $addr = get_order_address($o['id'], 'shipping'); ?>
                                                        <?php if ($addr): ?>
                                                            <p class="mb-1 text-muted"><?= htmlspecialchars($addr['first_name'] . ' ' . $addr['last_name']) ?></p>
                                                            <p class="mb-1 text-muted"><?= htmlspecialchars($addr['address_line1']) ?></p>
                                                            <?php if ($addr['address_line2']): ?>
                                                                <p class="mb-1 text-muted"><?= htmlspecialchars($addr['address_line2']) ?></p>
                                                            <?php endif; ?>
                                                            <p class="mb-1 text-muted"><?= htmlspecialchars($addr['postal_code'] . ' ' . $addr['city']) ?></p>
                                                            <p class="mb-1 text-muted"><?= htmlspecialchars($addr['country_name']) ?></p>
                                                            <p class="mb-0 text-muted"><?= htmlspecialchars($addr['mobile']) ?></p>
                                                        <?php else: ?>
                                                            <p class="text-muted">N/A</p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <div class="d-inline-block text-left" style="min-width: 200px;">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <span class="text-muted">Subtotal:</span>
                                                                <span class="font-weight-semi-bold"><?= number_format($o['subtotal'], 2) ?> €</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <span class="text-muted">Shipping:</span>
                                                                <span class="font-weight-semi-bold"><?= number_format($o['shipping'], 2) ?> €</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between pt-2 border-top">
                                                                <span class="h5 font-weight-bold text-primary">Total:</span>
                                                                <span class="h5 font-weight-bold text-primary"><?= number_format($o['total'], 2) ?> €</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif ($section == 'settings'): ?>
                <div class="row">
                    <div class="col-md-12 mb-5">
                        <div class="card border-secondary shadow-sm">
                            <div class="card-header bg-secondary border-0">
                                <h4 class="font-weight-semi-bold m-0"><?= t('profile.settings.personal_info') ?></h4>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST">
                                    <input type="hidden" name="update_profile" value="1">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label><?= t('profile.settings.first_name') ?></label>
                                            <input class="form-control" type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label><?= t('profile.settings.last_name') ?></label>
                                            <input class="form-control" type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label><?= t('profile.settings.email') ?></label>
                                            <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label><?= t('profile.settings.mobile') ?></label>
                                            <input class="form-control" type="text" name="mobile" value="<?= htmlspecialchars($user['mobile'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary font-weight-bold py-2 px-4" type="submit"><?= t('profile.settings.btn_save') ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card border-secondary shadow-sm">
                            <div class="card-header bg-secondary border-0">
                                <h4 class="font-weight-semi-bold m-0"><?= t('profile.settings.security') ?></h4>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST">
                                    <input type="hidden" name="change_password" value="1">
                                    <div class="form-group mb-4">
                                        <label><?= t('profile.settings.current_password') ?></label>
                                        <input class="form-control" type="password" name="current_password" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label><?= t('profile.settings.new_password') ?></label>
                                            <input class="form-control" type="password" name="new_password" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label><?= t('profile.settings.confirm_password') ?></label>
                                            <input class="form-control" type="password" name="confirm_password" required>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary font-weight-bold py-2 px-4" type="submit"><?= t('profile.settings.btn_save') ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Profile End -->

<style>
    .border-bottom-dashed {
        border-bottom: 1px dashed #dee2e6;
    }

    .border-bottom-dashed:last-child {
        border-bottom: none;
    }

    .list-group-item.active {
        background-color: #D19C97;
        border-color: #D19C97;
    }

    .badge-primary {
        background-color: #D19C97;
    }
</style>

<?php include 'includes/footer.php'; ?>