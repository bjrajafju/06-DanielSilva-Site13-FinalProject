<?php
include_once 'includes/helpers.php';

// Data Aggregation
$stats = get_dashboard_stats();
$low_stock = get_low_stock_details(5);
$sales_trends = get_sales_trends(15);
$category_dist = get_category_distribution();
$top_products = get_top_selling_products_dashboard(5);

// Prepare Chart Data
$chart_labels = [];
$chart_data = [];
foreach ($sales_trends as $day) {
    $chart_labels[] = date('d M', strtotime($day['date']));
    $chart_data[] = (float) $day['revenue'];
}

$cat_labels = [];
$cat_data = [];
foreach ($category_dist as $cat) {
    $cat_labels[] = $cat['category'];
    $cat_data[] = (float) $cat['revenue'];
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<style>
    .dashboard-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: transform 0.2s;
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
    }

    .kpi-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        font-size: 1.25rem;
    }

    .trend-badge {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
        border-radius: 2rem;
    }

    .table-responsive {
        border-radius: 0.5rem;
    }

    .empty-state {
        padding: 3rem;
        text-align: center;
        color: #858796;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
</style>

<div id="content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h2 class="h4 mb-0 font-weight-bold">Visão Geral da Loja</h2>
        <div class="text-right">
            <span class="text-muted small"><?= date('l, d F Y') ?></span>
        </div>
    </div>

    <div class="container-fluid py-4">

        <!-- KPI Cards Row -->
        <div class="row">
            <!-- Monthly Revenue -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1 text-muted">Receita (Mês)
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    <?= number_format($stats['revenue'], 2) ?>€
                                </div>
                                <div class="mt-2">
                                    <?php if ($stats['revenue_growth'] >= 0): ?>
                                        <span class="badge badge-light text-success trend-badge">
                                            <i class="fas fa-arrow-up mr-1"></i>
                                            <?= number_format($stats['revenue_growth'], 1) ?>%
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-light text-danger trend-badge">
                                            <i class="fas fa-arrow-down mr-1"></i>
                                            <?= number_format(abs($stats['revenue_growth']), 1) ?>%
                                        </span>
                                    <?php endif; ?>
                                    <span class="text-muted small ml-1">vs mês anterior</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="kpi-icon bg-light-primary text-primary">
                                    <i class="fas fa-euro-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1 text-muted">Encomendas
                                    Pendentes
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800"><?= $stats['pending_orders'] ?>
                                </div>
                                <div class="mt-2 text-muted small">A aguardar ação</div>
                            </div>
                            <div class="col-auto">
                                <div class="kpi-icon bg-light-warning text-warning">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Average Order Value -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1 text-muted">Valor Médio de
                                    Encomenda
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    <?= number_format($stats['aov'], 2) ?>€
                                </div>
                                <div class="mt-2 text-muted small">Por transação</div>
                            </div>
                            <div class="col-auto">
                                <div class="kpi-icon bg-light-info text-info">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Users -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1 text-muted">Total de Clientes
                                </div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800"><?= $stats['total_users'] ?></div>
                                <div class="mt-2 text-muted small">Contas registadas</div>
                            </div>
                            <div class="col-auto">
                                <div class="kpi-icon bg-light-success text-success">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h6 class="m-0 font-weight-bold text-dark">Evolução da Receita (Últimos 15 Dias)</h6>
                    </div>
                    <div class="card-body">
                        <?php if (empty($chart_data)): ?>
                            <div class="empty-state">
                                <i class="fas fa-chart-line"></i>
                                <p>Sem dados de vendas nos últimos 15 dias.</p>
                            </div>
                        <?php else: ?>
                            <div style="position: relative; height: 300px;">
                                <canvas id="salesTrendsChart"></canvas>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h6 class="m-0 font-weight-bold text-dark">Vendas por Categoria</h6>
                    </div>
                    <div class="card-body">
                        <?php if (empty($cat_data)): ?>
                            <div class="empty-state">
                                <i class="fas fa-chart-pie"></i>
                                <p>Sem dados de categorias disponíveis.</p>
                            </div>
                        <?php else: ?>
                            <div style="position: relative; height: 300px;">
                                <canvas id="categoryDistChart"></canvas>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Tables Row -->
        <div class="row">
            <!-- Low Stock Alerts -->
            <div class="col-lg-7 mb-4">
                <div class="card dashboard-card h-100">
                    <div
                        class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-dark">Alertas de Stock <span
                                class="badge badge-danger ml-2"><?= count($low_stock) ?></span></h6>
                        <a href="product_variants.php" class="btn btn-sm btn-outline-primary">Gerir Stock</a>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($low_stock)): ?>
                            <div class="empty-state py-5">
                                <i class="fas fa-check-circle text-success"></i>
                                <p>Todos os produtos estão com stock suficiente!</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-0 px-4">Produto</th>
                                            <th class="border-0">Variante</th>
                                            <th class="border-0 text-center">Stock</th>
                                            <th class="border-0 text-right px-4">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($low_stock as $item): ?>
                                            <tr>
                                                <td class="px-4 font-weight-bold"><?= $item['title'] ?></td>
                                                <td>
                                                    <span class="small text-muted">Tam: <?= $item['size_name'] ?></span><br>
                                                    <span class="small text-muted">Cor: <?= $item['color_name'] ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-pill badge-<?= $item['stock'] <= 2 ? 'danger' : 'warning' ?>">
                                                        restam <?= $item['stock'] ?>
                                                    </span>
                                                </td>
                                                <td class="text-right px-4">
                                                    <a href="product_variant_form.php?id=<?= $item['id'] ?>"
                                                        class="btn btn-sm btn-link text-primary"><i class="fas fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="col-lg-5 mb-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h6 class="m-0 font-weight-bold text-dark">Produtos Mais Vendidos</h6>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($top_products)): ?>
                            <div class="empty-state py-5">
                                <i class="fas fa-box-open"></i>
                                <p>Ainda sem vendas registadas.</p>
                            </div>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($top_products as $p): ?>
                                    <div class="list-group-item d-flex align-items-center border-0 px-4">
                                        <img src="../<?= $p['image'] ?>" class="rounded mr-3"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <div class="small font-weight-bold"><?= $p['title'] ?></div>
                                            <div class="text-muted small"><?= $p['total_sold'] ?> vendidos</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-weight-bold text-dark">
                                                <?= number_format($p['total_revenue'], 2) ?>€
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Row -->
        <div class="row">
            <div class="col-12">
                <div class="card dashboard-card mb-4">
                    <div
                        class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-dark">Últimas Encomendas</h6>
                        <a href="orders.php" class="btn btn-sm btn-outline-secondary">Ver Todas</a>
                    </div>
                    <div class="card-body p-0">
                        <?php
                        $recent_orders = db_select("o.*, u.first_name, u.last_name", "orders o", "LEFT JOIN users u ON u.id = o.user_id", "1", "o.id DESC", "5");
                        if (empty($recent_orders)): ?>
                            <div class="empty-state py-5">
                                <i class="fas fa-shopping-cart"></i>
                                <p>Nenhuma encomenda encontrada.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light text-muted small text-uppercase">
                                        <tr>
                                            <th class="border-0 px-4">ID Encomenda</th>
                                            <th class="border-0">Cliente</th>
                                            <th class="border-0">Data</th>
                                            <th class="border-0">Total</th>
                                            <th class="border-0">Estado</th>
                                            <th class="border-0 text-right px-4">Detalhes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recent_orders as $order): ?>
                                            <tr>
                                                <td class="px-4 font-weight-bold">#<?= $order['id'] ?></td>
                                                <td><?= $order['first_name'] ? htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) : 'Guest' ?>
                                                </td>
                                                <td class="text-muted">
                                                    <?= date('d M Y, H:i', strtotime($order['created_at'])) ?>
                                                </td>
                                                <td class="font-weight-bold"><?= number_format($order['total'], 2) ?>€</td>
                                                <td>
                                                    <?php
                                                    $status_class = 'secondary';
                                                    if ($order['status'] == 'completed')
                                                        $status_class = 'success';
                                                    if ($order['status'] == 'pending')
                                                        $status_class = 'warning';
                                                    if ($order['status'] == 'cancelled')
                                                        $status_class = 'danger';
                                                    ?>
                                                    <span class="badge badge-<?= $status_class ?> px-3 py-2 text-uppercase"
                                                        style="font-size: 0.65rem;">
                                                        <?php
                                                        $status_pt = [
                                                            'pending' => 'pendente',
                                                            'paid' => 'pago',
                                                            'shipped' => 'enviado',
                                                            'completed' => 'concluída',
                                                            'cancelled' => 'cancelada'
                                                        ];
                                                        echo $status_pt[$order['status']] ?? $order['status'];
                                                        ?>
                                                    </span>
                                                </td>
                                                <td class="text-right px-4">
                                                    <a href="order_view.php?id=<?= $order['id'] ?>"
                                                        class="btn btn-sm btn-light"><i class="fas fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Chart.js and Initialization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php if (!empty($chart_data)): ?>
            // Sales Trends Chart
            const ctxSales = document.getElementById('salesTrendsChart').getContext('2d');
            new Chart(ctxSales, {
                type: 'line',
                data: {
                    labels: <?= json_encode($chart_labels) ?>,
                    datasets: [{
                        label: 'Receita (€)',
                        data: <?= json_encode($chart_data) ?>,
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: '#4e73df',
                        borderWidth: 3
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2], drawBorder: false }
                        },
                        x: {
                            grid: { display: false, drawBorder: false }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        <?php endif; ?>

        <?php if (!empty($cat_data)): ?>
            // Category Distribution Chart
            const ctxCat = document.getElementById('categoryDistChart').getContext('2d');
            new Chart(ctxCat, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($cat_labels) ?>,
                    datasets: [{
                        data: <?= json_encode($cat_data) ?>,
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                        hoverOffset: 4,
                        borderWidth: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, padding: 20 } }
                    }
                }
            });
        <?php endif; ?>
    });
</script>

<?php include 'layout/footer.php'; ?>