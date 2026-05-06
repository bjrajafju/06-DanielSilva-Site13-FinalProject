<?php
include_once 'includes/helpers.php';

$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? addslashes($_GET['search']) : '';
$where = "1";
if ($search) {
    $where = "code LIKE '%$search%' OR text LIKE '%$search%'";
}

$total_items = db_count('traduz', $where);
$total_pages = ceil($total_items / $limit);

// Group by code to show translations together
$codes = db_select("DISTINCT code", "traduz", "", $where, "code ASC", "$offset, $limit");

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Interface Translations</h2>
        <a href="traduz_form.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add New Translation</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Translation List (traduz)</span>
                <form class="d-flex" method="GET">
                    <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Search key or text..." value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-outline-primary btn-sm" type="submit">Search</button>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Code Key</th>
                                <th>Module (Inferred)</th>
                                <th>Translations</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($codes as $c):
                                $code = $c['code'];
                                $module = explode('.', $code)[0];
                                $trans = db_get_all("traduz", "code = '" . addslashes($code) . "'");
                            ?>
                                <tr>
                                    <td><code><?= $code ?></code></td>
                                    <td><span class="badge bg-secondary"><?= strtoupper($module) ?></span></td>
                                    <td>
                                        <?php foreach ($trans as $t): ?>
                                            <div class="mb-1">
                                                <small class="text-uppercase fw-bold text-muted"><?= $t['lang_code'] ?>:</small>
                                                <span><?= htmlspecialchars(substr($t['text'], 0, 100)) ?><?= strlen($t['text']) > 100 ? '...' : '' ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="traduz_form.php?code=<?= urlencode($code) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-pencil"></i></a>
                                        <a href="traduz_delete.php?code=<?= urlencode($code) ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></a>
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