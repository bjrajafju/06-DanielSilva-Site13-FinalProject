<?php
include_once 'includes/helpers.php';

$sizes = db_get_all('sizes', '1', 'id ASC');

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Sizes</h2>
        <a href="size_form.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add New Size</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Size List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sizes as $s): ?>
                                <tr>
                                    <td>#<?= $s['id'] ?></td>
                                    <td><span class="badge bg-secondary"><?= $s['name'] ?></span></td>
                                    <td class="text-end">
                                        <a href="size_form.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-pencil"></i></a>
                                        <a href="size_delete.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></a>
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