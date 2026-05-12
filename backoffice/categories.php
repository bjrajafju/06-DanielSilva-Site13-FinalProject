<?php
include_once 'includes/helpers.php';

$categories = db_get_all('categories', '1', 'id ASC');

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Categories</h2>
        <a href="category_form.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New Category</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Category List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>ID</th>
                                <th>Name (EN)</th>
                                <th>Name (PT)</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $c):
                                $t_gb = db_get_one("category_translations", "category_id = {$c['id']} AND lang_code = 'gb'");
                                $t_pt = db_get_one("category_translations", "category_id = {$c['id']} AND lang_code = 'pt'");
                            ?>
                                <tr>
                                    <td>
                                        <img src="../<?= $c['image'] ?>" class="img-preview" onerror="this.src='https://via.placeholder.com/50'">
                                    </td>
                                    <td>#<?= $c['id'] ?></td>
                                    <td><?= $t_gb['name'] ?? 'N/A' ?></td>
                                    <td><?= $t_pt['name'] ?? 'N/A' ?></td>
                                    <td class="text-right">
                                        <a href="category_form.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                        <a href="category_delete.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></a>
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

