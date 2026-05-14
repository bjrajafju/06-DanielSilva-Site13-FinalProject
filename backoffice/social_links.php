<?php
include_once 'includes/helpers.php';

$social_links = db_get_all('social_links', '1', 'sort_order ASC, platform ASC');

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Redes Sociais</h2>
        <a href="social_link_form.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Adicionar Rede
            Social</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Gestão de Redes Sociais</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Ordem</th>
                                <th>Ícone</th>
                                <th>Plataforma</th>
                                <th>URL</th>
                                <th>Ativo</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($social_links)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Nenhuma rede social configurada.</td>
                                </tr>
                            <?php endif; ?>
                            <?php foreach ($social_links as $s): ?>
                                <tr>
                                    <td><?= $s['sort_order'] ?></td>
                                    <td>
                                        <div class="p-2 bg-light d-inline-block rounded border">
                                            <i class="<?= htmlspecialchars($s['icon']) ?> fa-fw fa-lg"></i>
                                        </div>
                                    </td>
                                    <td class="font-weight-bold"><?= htmlspecialchars($s['platform']) ?></td>
                                    <td>
                                        <a href="<?= htmlspecialchars($s['url']) ?>" target="_blank"
                                            class="small text-muted">
                                            <?= htmlspecialchars($s['url']) ?> <i
                                                class="fas fa-external-link-alt fa-xs"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= $s['is_active'] ? 'success' : 'danger' ?>">
                                            <?= $s['is_active'] ? 'Ativo' : 'Inativo' ?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="social_link_form.php?id=<?= $s['id'] ?>"
                                            class="btn btn-sm btn-outline-info" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="social_link_delete.php?id=<?= $s['id'] ?>"
                                            class="btn btn-sm btn-outline-danger btn-delete" title="Apagar">
                                            <i class="fas fa-trash"></i>
                                        </a>
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