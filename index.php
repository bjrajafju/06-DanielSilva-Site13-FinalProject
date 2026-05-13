<!DOCTYPE html>
<html lang="gb">
<?php
include_once 'includes/config.php';
$meta_title = "Home";
include 'includes/header.php';

$categories = get_categories();
$products = get_products(8);
?>

<!-- Featured Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0"><?= t('home.featured.quality_product') ?></h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0"><?= t('home.featured.free_shipping') ?></h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0"><?= t('home.featured.return_policy') ?></h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0"><?= t('home.featured.support') ?></h5>
            </div>
        </div>
    </div>
</div>
<!-- Featured End -->


<!-- Categories Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">

        <?php
        foreach ($categories as $cat):
            ?>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <p class="text-right">
                        <?= get_product_count_by_category($cat['id']) ?>     <?= t('home.categories.products'); ?>
                    </p>

                    <a href="<?= get_url('shop.php?categories[]=' . $cat['id']) ?>"
                        class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-fluid" src="<?= $cat['image'] ?>" alt="<?= htmlspecialchars($cat['name']) ?>"
                            loading="lazy">
                    </a>

                    <h5 class="font-weight-semi-bold m-0">
                        <?= $cat['name'] ?>
                    </h5>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>
<!-- Categories End -->

<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5">
            <span class="px-2"><?= t('home.trending_products.title') ?></span>
        </h2>
    </div>

    <div class="row px-xl-5 pb-3">

        <?php
        foreach ($products as $p):
            ?>

            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">

                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="<?= $p['image'] ?>" alt="<?= htmlspecialchars($p['title']) ?>"
                            loading="lazy">
                    </div>

                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">
                            <?= $p['title'] ?>
                        </h6>

                        <div class="d-flex justify-content-center">
                            <h6>$<?= number_format($p['price'], 2) ?></h6>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-center bg-light border">
                        <a href="<?= get_url('detail.php?slug=' . $p['slug']) ?>" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>
                            <?= t('products.buttons.detail') ?>
                        </a>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    </div>
</div>
<!-- Products End -->


<!-- Subscribe Start -->
<div class="container-fluid bg-secondary my-5">
    <div class="row justify-content-md-center py-5 px-xl-5">
        <div class="col-md-6 col-12 py-5">
            <div class="text-center mb-2 pb-2">
                <h2 class="section-title px-5 mb-3"><span
                        class="bg-secondary px-2"><?= t('home.subscribe.title') ?></span></h2>
                <p><?= t('home.subscribe.description') ?></p>
            </div>
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control border-white p-4"
                        placeholder="<?= t('home.subscribe.placeholder') ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary px-4">
                            <?= t('home.subscribe.button') ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Subscribe End -->


<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5">
            <span class="px-2"><?= t('home.just_arrived.title') ?></span>
        </h2>
    </div>

    <div class="row px-xl-5 pb-3">

        <?php
        foreach ($products as $p):
            ?>

            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">

                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="<?= $p['image'] ?>" alt="<?= htmlspecialchars($p['title']) ?>"
                            loading="lazy">
                    </div>

                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">
                            <?= $p['title'] ?>
                        </h6>

                        <div class="d-flex justify-content-center">
                            <h6>$<?= number_format($p['price'], 2) ?></h6>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-center bg-light border">
                        <a href="<?= get_url('detail.php?slug=' . $p['slug']) ?>" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>
                            <?= t('products.buttons.detail') ?>
                        </a>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    </div>
</div>
<!-- Products End -->


<!-- Vendor Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel vendor-carousel">
                <div class="vendor-item border p-4">
                    <img src="img/vendor-1.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="img/vendor-2.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="img/vendor-3.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="img/vendor-4.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="img/vendor-5.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="img/vendor-6.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="img/vendor-7.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="img/vendor-8.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vendor End -->

<?php include 'includes/footer.php'; ?>

</body>

</html>