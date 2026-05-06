<?php
include_once 'includes/helpers.php';

$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_items = db_count('product_variants');
$total_pages = ceil($total_items / $limit);

$variants = db_select(
    "pv.*, s.name as size_name, c.hex, p.codProd",
    "product_variants pv",
    "LEFT JOIN products p ON p.id = pv.product_id 
     LEFT JOIN sizes s ON s.id = pv.size_id 
     LEFT JOIN colors c ON c.id = pv.color_id",
    "1",
    "pv.id DESC",
    "$offset, $limit"
);

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Product Variants</h2>
        <a href="product_variant_form.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add New Variant</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Variant List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product Title</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Available</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($variants as $v):
                                $p_trans = db_get_one("product_translations", "product_id = {$v['product_id']} AND lang_code = 'gb'");
                                if (!$p_trans) $p_trans = db_get_one("product_translations", "product_id = {$v['product_id']}");

                                $c_trans = db_get_one("color_translations", "color_id = {$v['color_id']} AND lang_code = 'gb'");
                            ?>
                                <tr>
                                    <td><code><?= $v['codProd'] ?></code></td>
                                    <td><?= $p_trans['title'] ?? 'N/A' ?></td>
                                    <td><span class="badge bg-secondary"><?= $v['size_name'] ?></span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div style="width: 20px; height: 20px; background: <?= $v['hex'] ?>; border: 1px solid #ddd; margin-right: 10px;"></div>
                                            <?= $c_trans['name'] ?? 'N/A' ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $v['is_available'] ? 'success' : 'danger' ?>">
                                            <?= $v['is_available'] ? 'Yes' : 'No' ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="product_variant_form.php?id=<?= $v['id'] ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-pencil"></i></a>
                                        <a href="product_variant_delete.php?id=<?= $v['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></a>
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