<?php
include_once 'includes/helpers.php';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? addslashes($_GET['search']) : '';
$where = "1";
if ($search) {
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
        <h2 class="h4 mb-0">Produtos</h2>
        <a href="product_form.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Adicionar Novo Produto</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Lista de Produtos</span>
                <form class="d-flex" method="GET">
                    <input class="form-control form-control-sm mr-2" type="search" name="search" placeholder="Pesquisar..." value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-outline-primary btn-sm" type="submit">Pesquisar</button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Imagem</th>
                                <th>Código</th>
                                <th>Título (Padrão)</th>
                                <th>Categoria</th>
                                <th>Preço</th>
                                <th>Estado</th>
                                <th class="text-right">Ações</th>
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
                                    <td><?= $cat_trans['name'] ?? 'Sem Categoria' ?></td>
                                    <td><?= number_format($p['price'], 2) ?>€</td>
                                    <td>
                                        <span class="badge badge-<?= $p['is_active'] ? 'success' : 'danger' ?>">
                                            <?= $p['is_active'] ? 'Ativo' : 'Inativo' ?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="product_form.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                        <a href="product_delete.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></a>
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

