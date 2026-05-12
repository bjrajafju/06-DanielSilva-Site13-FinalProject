<?php
include_once 'includes/helpers.php';

$languages = db_get_all('lang', '1', 'id ASC');

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Idiomas</h2>
        <a href="lang_form.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Adicionar Novo Idioma</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Lista de Idiomas</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Emoji</th>
                                <th>Código</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($languages as $l): ?>
                                <tr>
                                    <td>#<?= $l['id'] ?></td>
                                    <td><span class="fs-4"><?= $l['emoji'] ?></span></td>
                                    <td><code><?= $l['code'] ?></code></td>
                                    <td class="text-right">
                                        <a href="lang_form.php?id=<?= $l['id'] ?>" class="btn btn-sm btn-outline-info"><i
                                                class="fas fa-edit"></i></a>
                                        <a href="lang_delete.php?id=<?= $l['id'] ?>"
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