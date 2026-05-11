<?php
include_once 'includes/config.php';

$cart = get_current_cart();

$items = [];
$totals = ['subtotal' => 0, 'shipping' => 0, 'total' => 0];

if ($cart) {
    $items = get_cart_items($cart['id']);
    $totals = get_cart_totals($cart['id']);
}

include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lingua'] ?? 'pt' ?>">
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('cart.header.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('cart.header.breadcrumb_home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('cart.header.breadcrumb_cart') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-12">
            <?php if (isset($_GET['error']) && $_GET['error'] === 'out_of_stock'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i> <?= t('error.out_of_stock') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th><?= t('cart.table.products') ?></th>
                        <th><?= t('cart.table.price') ?></th>
                        <th><?= t('cart.table.quantity') ?></th>
                        <th><?= t('cart.table.total') ?></th>
                        <th><?= t('cart.table.remove') ?></th>
                    </tr>
                </thead>
                <tbody class="align-middle">

                    <?php if (!$items): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <?= t('cart.table.empty') ?>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($items as $item): ?>

                        <tr data-cart-item-id="<?= $item['cart_item_id'] ?>">
                            <td class="align-middle text-left">
                                <img src="<?= $SETTINGS['url_site'] ?>/<?= $item['image'] ?>" style="width:50px;">
                                <?= $item['title'] ?>
                                <small class="d-block text-muted">
                                    <?= $item['size'] ?> / <?= $item['color'] ?>
                                </small>
                            </td>

                            <td class="align-middle">
                                <?= number_format($item['price'], 2) ?> €
                            </td>

                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <input type="number"
                                        class="form-control form-control-sm bg-secondary text-center cart-qty"
                                        min="1"
                                        value="<?= $item['quantity'] ?>">
                                </div>
                            </td>

                            <td class="align-middle">
                                <span class="item-total"><?= number_format($item['price'] * $item['quantity'], 2) ?></span> €
                            </td>

                            <td class="align-middle">
                                <button class="btn btn-sm btn-primary cart-remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0"><?= t('cart.summary.title') ?></h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium"><?= t('cart.summary.subtotal') ?></h6>
                        <h6 class="font-weight-medium"><span class="cart-subtotal"><?= number_format($totals['subtotal'], 2) ?></span> €</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium"><?= t('cart.summary.shipping') ?></h6>
                        <h6 class="font-weight-medium"><span class="cart-shipping"><?= number_format($totals['shipping'], 2) ?></span> €</h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold"><?= t('cart.summary.total') ?></h5>
                        <h5 class="font-weight-bold"><span class="cart-total"><?= number_format($totals['total'], 2) ?></span> €</h5>
                    </div>
                    <a href="<?= $SETTINGS['url_site'] ?>/checkout.php" class="btn btn-block btn-primary my-3 py-3 text-white"><?= t('cart.checkout.button') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->

<?php include 'includes/footer.php'; ?>

<script>
    const TXT_OUT_OF_STOCK = "<?= t('error.out_of_stock_max') ?>";
</script>
<script src="<?= $SETTINGS['url_site'] ?>/js/cart.js"></script>

</body>

</html>