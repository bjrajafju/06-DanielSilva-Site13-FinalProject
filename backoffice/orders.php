<?php
include_once 'includes/helpers.php';

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_items = db_count('orders');
$total_pages = ceil($total_items / $limit);

$orders = db_select(
    "o.*, u.first_name, u.last_name, u.email as user_email",
    "orders o",
    "LEFT JOIN users u ON u.id = o.user_id",
    "1",
    "o.id DESC",
    "$offset, $limit"
);

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Encomendas</h2>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="card">
            <div class="card-header">Lista de Encomendas</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID Encomenda</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Data</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $o): ?>
                                <tr>
                                    <td><strong>#<?= $o['id'] ?></strong></td>
                                    <td>
                                        <?= $o['first_name'] ? $o['first_name'] . ' ' . $o['last_name'] : 'Convidado' ?>
                                        <div class="small text-muted"><?= $o['user_email'] ?? 'N/A' ?></div>
                                    </td>
                                    <td><?= number_format($o['total'], 2) ?>€</td>
                                    <td>
                                        <span class="badge badge-<?=
                                                                $o['status'] == 'completed' ? 'success' : ($o['status'] == 'pending' ? 'warning' : ($o['status'] == 'cancelled' ? 'danger' : 'info'))
                                                                ?>">
                                            <?php
                                            $status_pt = [
                                                'pending' => 'PENDENTE',
                                                'paid' => 'PAGO',
                                                'shipped' => 'ENVIADO',
                                                'completed' => 'CONCLUÍDA',
                                                'cancelled' => 'CANCELADA'
                                            ];
                                            echo $status_pt[$o['status']] ?? strtoupper($o['status']);
                                            ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></td>
                                    <td class="text-right">
                                        <a href="order_view.php?id=<?= $o['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i> Ver</a>
                                        <a href="order_delete.php?id=<?= $o['id'] ?>" class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash"></i></a>
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

