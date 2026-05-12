<?php
include_once 'includes/helpers.php';

$payment_methods = db_get_all('payment_methods', '1', 'id ASC');

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Métodos de Pagamento</h2>
        <a href="payment_method_form.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Adicionar Novo Método de Pagamento</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Lista de Métodos de Pagamento</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome (EN)</th>
                                <th>Nome (PT)</th>
                                <th>Ativo</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payment_methods as $pm):
                                $t_gb = db_get_one("payment_method_translations", "payment_method_id = {$pm['id']} AND lang_code = 'gb'");
                                $t_pt = db_get_one("payment_method_translations", "payment_method_id = {$pm['id']} AND lang_code = 'pt'");
                            ?>
                                <tr>
                                    <td><code><?= $pm['code'] ?></code></td>
                                    <td><?= $t_gb['name'] ?? 'N/A' ?></td>
                                    <td><?= $t_pt['name'] ?? 'N/A' ?></td>
                                    <td>
                                        <span class="badge badge-<?= $pm['is_active'] ? 'success' : 'danger' ?>">
                                            <?= $pm['is_active'] ? 'Ativo' : 'Inativo' ?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="payment_method_form.php?id=<?= $pm['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                                        <a href="payment_method_delete.php?id=<?= $pm['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></a>
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

