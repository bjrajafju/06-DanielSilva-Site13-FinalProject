<?php
include_once 'includes/helpers.php';

$countries = db_get_all('countries', '1', 'code ASC');

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Países</h2>
        <a href="country_form.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Adicionar Novo País</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Lista de Países</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome (EN)</th>
                                <th>Nome (PT)</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($countries as $c):
                                $t_gb = db_get_one("country_translations", "country_id = {$c['id']} AND lang_code = 'gb'");
                                $t_pt = db_get_one("country_translations", "country_id = {$c['id']} AND lang_code = 'pt'");
                                ?>
                                <tr>
                                    <td><code><?= $c['code'] ?></code></td>
                                    <td><?= $t_gb['name'] ?? 'N/A' ?></td>
                                    <td><?= $t_pt['name'] ?? 'N/A' ?></td>
                                    <td class="text-right">
                                        <a href="country_form.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-info"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="country_delete.php?id=<?= $c['id'] ?>"
                                            class="btn btn-sm btn-outline-danger btn-delete"><i
                                                class="fas fa-trash"></i></a>
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