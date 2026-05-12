<?php
include_once 'includes/helpers.php';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$status = $_GET['status'] ?? 'all';
$where = "1";
if ($status === 'pending') {
    $where = "is_approved = 0";
} elseif ($status === 'approved') {
    $where = "is_approved = 1";
}

$total_items = db_count('reviews', $where);
$total_pages = ceil($total_items / $limit);

$reviews = db_select(
    "r.*, pt.title as product_title",
    "reviews r",
    "LEFT JOIN product_translations pt ON pt.product_id = r.product_id AND pt.lang_code = 'pt'",
    $where,
    "r.created_at DESC",
    "$offset, $limit"
);

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Product Reviews</h2>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="mb-4">
            <a href="?status=all" class="btn btn-sm <?= $status === 'all' ? 'btn-primary' : 'btn-outline-primary' ?>">All</a>
            <a href="?status=pending" class="btn btn-sm <?= $status === 'pending' ? 'btn-primary' : 'btn-outline-primary' ?>">Pending</a>
            <a href="?status=approved" class="btn btn-sm <?= $status === 'approved' ? 'btn-primary' : 'btn-outline-primary' ?>">Approved</a>
        </div>

        <div class="card">
            <div class="card-header">Reviews</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Product</th>
                                <th>User</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reviews as $r): ?>
                                <tr>
                                    <td>
                                        <span class="badge badge-<?= $r['is_approved'] ? 'success' : 'warning' ?>">
                                            <?= $r['is_approved'] ? 'Approved' : 'Pending' ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($r['product_title']) ?></td>
                                    <td>
                                        <?= htmlspecialchars($r['name']) ?>
                                        <div class="small text-muted"><?= htmlspecialchars($r['email']) ?></div>
                                    </td>
                                    <td>
                                        <div class="text-warning">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="<?= $i <= $r['rating'] ? 'fas' : 'far' ?> fa-star"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </td>
                                    <td><small><?= htmlspecialchars(substr($r['comment'], 0, 50)) ?>...</small></td>
                                    <td><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></td>
                                    <td class="text-right">
                                        <a href="review_approve.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-<?= $r['is_approved'] ? 'warning' : 'success' ?>" title="<?= $r['is_approved'] ? 'Unapprove' : 'Approve' ?>">
                                            <i class="fas fa-<?= $r['is_approved'] ? 'times-circle' : 'check-circle' ?>"></i>
                                        </a>
                                        <a href="review_delete.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($reviews)): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No reviews found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?status=<?= $status ?>&page=<?= $i ?>"><?= $i ?></a>
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

