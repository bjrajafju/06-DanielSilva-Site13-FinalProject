<?php
include_once 'includes/helpers.php';

$sizes = db_get_all('sizes', '1', 'id ASC');

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Tamanhos</h2>
        <a href="size_form.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Adicionar Novo Tamanho</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Lista de Tamanhos</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sizes as $s): ?>
                                <tr>
                                    <td>#<?= $s['id'] ?></td>
                                    <td><span class="badge badge-secondary"><?= $s['name'] ?></span></td>
                                    <td class="text-right">
                                        <a href="size_form.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                        <a href="size_delete.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></a>
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

