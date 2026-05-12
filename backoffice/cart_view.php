<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$cart = db_get_one('carts', "id = $id");

if (!$cart)
    redirect("carts.php");

$items = db_select(
    "ci.*, p.codProd, pt.title",
    "cart_items ci",
    "LEFT JOIN product_variants pv ON pv.id = ci.variant_id 
     LEFT JOIN products p ON p.id = pv.product_id 
     LEFT JOIN product_translations pt ON pt.product_id = p.id AND pt.lang_code = 'gb'",
    "ci.cart_id = $id"
);

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Detalhes do Carrinho #<?= $id ?></h2>
        <a href="carts.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Voltar à Lista</a>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">Itens no Carrinho</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>ID Variante</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($items)): ?>
                                <tr>
                                    <td colspan="3" class="text-center">O carrinho está vazio</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td>
                                            [<?= $item['codProd'] ?>] <?= $item['title'] ?? 'N/A' ?>
                                        </td>
                                        <td><?= $item['variant_id'] ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>