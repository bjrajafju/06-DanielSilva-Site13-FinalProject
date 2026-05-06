<?php
include_once 'includes/helpers.php';

$colors = db_get_all('colors', '1', 'id ASC');

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Colors</h2>
        <a href="color_form.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add New Color</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Color List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Preview</th>
                                <th>HEX</th>
                                <th>Name (EN)</th>
                                <th>Name (PT)</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($colors as $c):
                                $t_gb = db_get_one("color_translations", "color_id = {$c['id']} AND lang_code = 'gb'");
                                $t_pt = db_get_one("color_translations", "color_id = {$c['id']} AND lang_code = 'pt'");
                            ?>
                                <tr>
                                    <td>
                                        <div style="width: 30px; height: 30px; background: <?= $c['hex'] ?>; border-radius: 50%; border: 1px solid #ddd;"></div>
                                    </td>
                                    <td><code><?= $c['hex'] ?></code></td>
                                    <td><?= $t_gb['name'] ?? 'N/A' ?></td>
                                    <td><?= $t_pt['name'] ?? 'N/A' ?></td>
                                    <td class="text-end">
                                        <a href="color_form.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-pencil"></i></a>
                                        <a href="color_delete.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></a>
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