<?php
include_once 'includes/config.php';

$slug = $_GET['slug'] ?? null;

if (!$slug) {
    header("Location: {$SETTINGS['url_site']}/index.php");
    exit;
}

$product = get_product_by_slug($slug);

if (!$product) {
    $any_product = get_product_by_slug_any_lang($slug);

    if ($any_product && !empty($any_product['slug'])) {
        header("Location: {$SETTINGS['url_site']}/detail.php?slug={$any_product['slug']}");
        exit;
    } else {
        header("Location: {$SETTINGS['url_site']}/index.php");
        exit;
    }
}

$related_products = get_products(8);
$sizes = get_product_sizes($product['product_id']);
$colors = get_product_colors($product['product_id']);
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lingua'] ?? 'pt' ?>">

<?php include 'includes/header.php'; ?>
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('detail.header.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('detail.header.breadcrumb_home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('detail.header.breadcrumb_detail') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Shop Detail Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <div class="border">
                <img class="w-100 h-100" src="<?= $SETTINGS['url_site'] ?>/<?= $product['image'] ?>" alt="<?= $product['title'] ?>">
            </div>
        </div>
        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold"><?= $product['title'] ?></h3>
            <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                    <small class="fas fa-star"></small>
                    <small class="fas fa-star"></small>
                    <small class="fas fa-star"></small>
                    <small class="fas fa-star-half-alt"></small>
                    <small class="far fa-star"></small>
                </div>
                <small class="pt-1">(50 Reviews)</small>
            </div>
            <h3 class="font-weight-semi-bold mb-4">
                <?= number_format($product['price'], 2) ?> €
            </h3>
            <p class="mb-4">
                <?= $product['short_description'] ?? '' ?>
            </p>
            <div class="d-flex mb-3">
                <p class="text-dark font-weight-medium mb-0 mr-3"><?= t('detail.product.sizes_label') ?></p>
                <form action="<?= $SETTINGS['url_site'] ?>/cart_add.php" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                    <?php foreach ($sizes as $size): ?>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio"
                                class="custom-control-input"
                                id="size-<?= $size['id'] ?>"
                                name="size"
                                value="<?= $size['id'] ?>"
                                required>

                            <label class="custom-control-label" for="size-<?= $size['id'] ?>">
                                <?= $size['name'] ?>
                            </label>
                        </div>
                    <?php endforeach; ?>

            </div>
            <div class="d-flex mb-4">
                <p class="text-dark font-weight-medium mb-0 mr-3"><?= t('detail.product.colors_label') ?></p>

                <?php foreach ($colors as $color): ?>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio"
                            class="custom-control-input"
                            id="color-<?= $color['id'] ?>"
                            name="color"
                            value="<?= $color['id'] ?>"
                            required>

                        <label class="custom-control-label" for="color-<?= $color['id'] ?>">
                            <?= $color['name'] ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="d-flex align-items-center mb-4 pt-2">
                <div class="input-group quantity mr-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-minus">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>

                    <input type="number"
                        name="quantity"
                        value="1"
                        min="1"
                        class="form-control bg-secondary text-center">

                    <div class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary px-3">
                    <i class="fa fa-shopping-cart mr-1"></i>
                    <?= t('detail.product.add_to_cart') ?>
                </button>
            </div>
            </form>
            <div class="d-flex pt-2">
                <p class="text-dark font-weight-medium mb-0 mr-2"><?= t('detail.product.share_on') ?></p>
                <div class="d-inline-flex">
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1"><?= t('detail.tabs.description') ?></a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2"><?= t('detail.tabs.information') ?></a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3"><?= t('detail.tabs.reviews') ?> (0)</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3"><?= t('detail.tabs.product_description_title') ?></h4>
                    <p><?= $product['description'] ?></p>

                </div>
                <div class="tab-pane fade" id="tab-pane-2">
                    <h4 class="mb-3"><?= t('detail.tabs.additional_information_title') ?></h4>
                    <p><?= $product['additional_info'] ?></p>
                </div>
                <div class="tab-pane fade" id="tab-pane-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4">1 review for "Colorful Stylish Shirt"</h4>
                            <div class="media mb-4">
                                <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1"
                                    style="width: 45px;">
                                <div class="media-body">
                                    <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                    <div class="text-primary mb-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum
                                        et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-4"><?= t('detail.reviews.leave_review_title') ?></h4>
                            <small><?= t('detail.reviews.email_notice') ?></small>
                            <div class="d-flex my-3">
                                <p class="mb-0 mr-2"><?= t('detail.reviews.your_rating_label') ?></p>
                                <div class="text-primary">
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                            <form>
                                <div class="form-group">
                                    <label for="message"><?= t('detail.reviews.your_review_label') ?></label>
                                    <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="name"><?= t('detail.reviews.your_name_label') ?></label>
                                    <input type="text" class="form-control" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="email"><?= t('detail.reviews.your_email_label') ?></label>
                                    <input type="email" class="form-control" id="email">
                                </div>
                                <div class="form-group mb-0">
                                    <input type="submit" value="<?= t('detail.reviews.submit_button') ?>" class="btn btn-primary px-3">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5">
            <span class="px-2"><?= t('detail.related_products.title') ?></span>
        </h2>
    </div>

    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">

                <?php
                foreach ($related_products as $related_product):
                ?>

                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100"
                                src="<?= $SETTINGS['url_site'] ?>/<?= $related_product['image'] ?>"
                                alt="<?= $related_product['title'] ?>">
                        </div>

                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">
                                <?= $related_product['title'] ?>
                            </h6>

                            <div class="d-flex justify-content-center">
                                <h6>
                                    <?= number_format($related_product['price'], 2) ?> €
                                </h6>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-center bg-light border">
                            <a href="<?= $SETTINGS['url_site'] ?>/detail.php?slug=<?= $related_product['slug'] ?>"
                                class="btn btn-sm text-dark p-0">
                                <i class="fas fa-eye text-primary mr-1"></i>
                                <?= t('products.buttons.detail') ?>
                            </a>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>
<!-- Products End -->


<?php include 'includes/footer.php'; ?>

</body>

</html>