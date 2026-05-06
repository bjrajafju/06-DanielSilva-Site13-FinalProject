<?php
include_once 'includes/helpers.php';

$pages = db_get_all('pages', '1', 'id ASC');

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Pages</h2>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Static Pages List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Slug</th>
                                <th>Title (EN)</th>
                                <th>Title (PT)</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pages as $p):
                                $t_gb = db_get_one("page_translations", "page_id = {$p['id']} AND lang_code = 'gb'");
                                $t_pt = db_get_one("page_translations", "page_id = {$p['id']} AND lang_code = 'pt'");
                            ?>
                                <tr>
                                    <td>#<?= $p['id'] ?></td>
                                    <td><code><?= $p['slug'] ?></code></td>
                                    <td><?= $t_gb['title'] ?? 'N/A' ?></td>
                                    <td><?= $t_pt['title'] ?? 'N/A' ?></td>
                                    <td>
                                        <span class="badge bg-<?= $p['is_active'] ? 'success' : 'danger' ?>">
                                            <?= $p['is_active'] ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="page_form.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-pencil"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>