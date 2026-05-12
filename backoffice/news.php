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
    $news_ids = db_select(
        "DISTINCT news_id",
        "news_translations",
        "",
        "title LIKE '%$search%'"
    );
    $ids = array_column($news_ids, 'news_id');
    if (!empty($ids)) {
        $where = "id IN (" . implode(',', $ids) . ")";
    } else {
        $where = "0";
    }
}

$total_items = db_count('news', $where);
$total_pages = ceil($total_items / $limit);

$news_list = db_get_all('news', $where, "created_at DESC", "$offset, $limit");

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Notícias</h2>
        <a href="news_form.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Adicionar Novo Artigo</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Lista de Notícias</span>
                <form class="d-flex" method="GET">
                    <input class="form-control form-control-sm mr-2" type="search" name="search" placeholder="Pesquisar título..." value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-outline-primary btn-sm" type="submit">Pesquisar</button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Imagem</th>
                                <th>Título (Padrão)</th>
                                <th>Data</th>
                                <th>Estado</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($news_list as $n):
                                $trans = db_get_one("news_translations", "news_id = {$n['id']} AND lang_code = 'gb'");
                                if (!$trans) $trans = db_get_one("news_translations", "news_id = {$n['id']}");
                            ?>
                                <tr>
                                    <td>
                                        <img src="../<?= $n['image'] ?>" class="img-preview" onerror="this.src='https://via.placeholder.com/50'">
                                    </td>
                                    <td><?= $trans['title'] ?? 'N/A' ?></td>
                                    <td><?= date('d/m/Y', strtotime($n['created_at'])) ?></td>
                                    <td>
                                        <span class="badge badge-<?= $n['is_active'] ? 'success' : 'danger' ?>">
                                            <?= $n['is_active'] ? 'Ativo' : 'Inativo' ?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="news_form.php?id=<?= $n['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                        <a href="news_delete.php?id=<?= $n['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></a>
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
                                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
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

