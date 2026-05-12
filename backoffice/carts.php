<?php
include_once 'includes/helpers.php';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_items = db_count('carts');
$total_pages = ceil($total_items / $limit);

$carts = db_select(
    "c.*, u.email as user_email",
    "carts c",
    "LEFT JOIN users u ON u.id = c.user_id",
    "1",
    "c.id DESC",
    "$offset, $limit"
);

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Active Carts</h2>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Cart Monitor</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Cart ID</th>
                                <th>User / Session</th>
                                <th>Items</th>
                                <th>Created At</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($carts as $c):
                                $item_count = db_count('cart_items', "cart_id = {$c['id']}");
                            ?>
                                <tr>
                                    <td><strong>#<?= $c['id'] ?></strong></td>
                                    <td>
                                        <?php if ($c['user_id']): ?>
                                            <span class="badge badge-primary">User</span> <?= $c['user_email'] ?>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Guest</span> <small class="text-muted"><?= substr($c['session_id'], 0, 8) ?>...</small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $item_count ?> items</td>
                                    <td><?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></td>
                                    <td class="text-right">
                                        <a href="cart_view.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i> View</a>
                                        <a href="cart_delete.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

