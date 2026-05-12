<?php
include_once 'includes/helpers.php';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_items = db_count('messages');
$total_pages = ceil($total_items / $limit);

$messages = db_get_all('messages', '1', 'id DESC', "$offset, $limit");

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Mensagens de Contacto</h2>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Mensagens</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Estado</th>
                                <th>De</th>
                                <th>Assunto</th>
                                <th>Data</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $m): ?>
                                <tr class="<?= $m['is_read'] ? 'text-muted' : 'fw-bold' ?>">
                                    <td>
                                        <span class="badge badge-<?= $m['is_read'] ? 'secondary' : 'primary' ?>">
                                            <?= $m['is_read'] ? 'Lida' : 'Nova' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= $m['name'] ?>
                                        <div class="small text-muted"><?= $m['email'] ?></div>
                                    </td>
                                    <td><?= $m['subject'] ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($m['created_at'])) ?></td>
                                    <td class="text-right">
                                        <a href="message_view.php?id=<?= $m['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i> Ver</a>
                                        <a href="message_delete.php?id=<?= $m['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

