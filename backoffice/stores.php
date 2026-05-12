<?php
include_once 'includes/helpers.php';

$stores = db_get_all('stores', '1', 'id ASC');

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Lojas</h2>
        <a href="store_form.php" class="btn btn-primary btn-sm"><i class="fas fa-store"></i> Adicionar Nova Loja</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Lista de Lojas</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Nome (EN)</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th>Ativo</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stores as $s):
                                $t_gb = db_get_one("store_translations", "store_id = {$s['id']} AND lang_code = 'gb'");
                            ?>
                                <tr>
                                    <td><?= $t_gb['name'] ?? 'N/A' ?></td>
                                    <td><?= $s['email'] ?></td>
                                    <td><?= $s['phone'] ?></td>
                                    <td>
                                        <span class="badge badge-<?= $s['is_active'] ? 'success' : 'danger' ?>">
                                            <?= $s['is_active'] ? 'Ativo' : 'Inativo' ?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="store_form.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                        <a href="store_delete.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></a>
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

