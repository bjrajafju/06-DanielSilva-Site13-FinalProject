<?php
include_once 'includes/helpers.php';

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? addslashes($_GET['search']) : '';
$where = "1";
if ($search) {
    // Join with translations to search by title
    $products = db_select(
        "DISTINCT p.id",
        "products p",
        "LEFT JOIN product_translations pt ON pt.product_id = p.id",
        "pt.title LIKE '%$search%' OR p.codProd LIKE '%$search%'"
    );
    $ids = array_column($products, 'id');
    if (!empty($ids)) {
        $where = "p.id IN (" . implode(',', $ids) . ")";
    } else {
        $where = "0";
    }
}

$total_items = db_count('products p', $where);
$total_pages = ceil($total_items / $limit);

$products = db_select(
    "p.*, c.id as cat_id",
    "products p",
    "LEFT JOIN categories c ON c.id = p.category_id",
    $where,
    "p.id DESC",
    "$offset, $limit"
);

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Products</h2>
        <a href="product_form.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add New Product</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Product List</span>
                <form class="d-flex" method="GET">
                    <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-outline-primary btn-sm" type="submit">Search</button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Title (Default)</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $p):
                                $trans = db_get_one("product_translations", "product_id = {$p['id']} AND lang_code = 'gb'");
                                if (!$trans) $trans = db_get_one("product_translations", "product_id = {$p['id']}");

                                $cat_trans = db_get_one("category_translations", "category_id = " . ($p['category_id'] ?? 0) . " AND lang_code = 'gb'");
                            ?>
                                <tr>
                                    <td>
                                        <img src="../<?= $p['image'] ?>" class="img-preview" onerror="this.src='https://via.placeholder.com/50'">
                                    </td>
                                    <td><code><?= $p['codProd'] ?></code></td>
                                    <td><?= $trans['title'] ?? 'N/A' ?></td>
                                    <td><?= $cat_trans['name'] ?? 'Uncategorized' ?></td>
                                    <td><?= number_format($p['price'], 2) ?>€</td>
                                    <td>
                                        <span class="badge bg-<?= $p['is_active'] ? 'success' : 'danger' ?>">
                                            <?= $p['is_active'] ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="product_form.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-pencil"></i></a>
                                        <a href="product_delete.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-item-link page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
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