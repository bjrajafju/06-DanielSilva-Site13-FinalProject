<?php
include_once 'includes/config.php';

if (!is_logged_in()) {
    header("Location: login.php?redirect=wishlist.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$wishlist_items = get_user_wishlist($user_id);
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lingua'] ?? 'pt' ?>">

<?php include 'includes/header.php'; ?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('wishlist.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('wishlist.header.breadcrumb_home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('wishlist.header.breadcrumb_wishlist') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Wishlist Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-12">
            <?php if (empty($wishlist_items)): ?>
                <div class="text-center py-5">
                    <i class="far fa-heart fa-4x text-primary mb-4"></i>
                    <h3><?= t('wishlist.empty') ?></h3>
                    <a href="shop.php" class="btn btn-primary mt-3"><?= t('header.nav.shop') ?></a>
                </div>
            <?php else: ?>
                <div class="row pb-3">
                    <?php foreach ($wishlist_items as $product): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="<?= $SETTINGS['url_site'] ?>/<?= $product['image'] ?>" alt="">
                                    <div class="btn-group-vertical position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                                        <a href="wishlist_action.php?product_id=<?= $product['id'] ?>&action=remove" class="btn btn-sm btn-primary shadow-sm" title="<?= t('detail.product.remove_from_wishlist') ?>">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3"><?= $product['title'] ?></h6>
                                    <div class="d-flex justify-content-center">
                                        <h6><?= number_format($product['price'], 2) ?> €</h6>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-center bg-light border">
                                    <a href="<?= $SETTINGS['url_site'] ?>/detail.php?slug=<?= $product['slug'] ?>"
                                        class="btn btn-sm text-dark p-0">
                                        <i class="fas fa-eye text-primary mr-1"></i>
                                        <?= t('products.buttons.detail') ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Wishlist End -->

<?php include 'includes/footer.php'; ?>

</body>

</html>