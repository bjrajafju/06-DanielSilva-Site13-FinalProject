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

$reviews = get_product_reviews($product['product_id']);
$review_count = get_product_review_count($product['product_id']);
$average_rating = get_product_average_rating($product['product_id']);

$meta_title = $product['title'];
$meta_description = $product['short_description'];
$meta_image = $SETTINGS['url_site'] . '/' . $product['image'];
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lingua'] ?? 'pt' ?>">

<?php include 'includes/header.php'; ?>
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('detail.header.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a
                    href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('detail.header.breadcrumb_home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('detail.header.breadcrumb_detail') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Shop Detail Start -->
<div class="container-fluid py-5">
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
        <div class="col-lg-5 pb-5">
            <div class="border">
                <img class="w-100 h-100" src="<?= $SETTINGS['url_site'] ?>/<?= $product['image'] ?>"
                    alt="<?= htmlspecialchars($product['title']) ?>" loading="lazy">
            </div>
        </div>
        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold"><?= $product['title'] ?></h3>
            <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        if ($average_rating >= $i) {
                            echo '<small class="fas fa-star"></small>';
                        } elseif ($average_rating >= $i - 0.5) {
                            echo '<small class="fas fa-star-half-alt"></small>';
                        } else {
                            echo '<small class="far fa-star"></small>';
                        }
                    }
                    ?>
                </div>
                <small class="pt-1">(<?= $review_count ?> <?= t('detail.product.reviews_count_label') ?>)</small>
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
                            <input type="radio" class="custom-control-input" id="size-<?= $size['id'] ?>" name="size"
                                value="<?= $size['id'] ?>" required>

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
                        <input type="radio" class="custom-control-input" id="color-<?= $color['id'] ?>" name="color"
                            value="<?= $color['id'] ?>" required>

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

                    <input type="number" name="quantity" value="1" min="1"
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

                <!-- Wishlist Button -->
                <div class="ml-3">
                    <?php
                    $user_id = $_SESSION['user_id'] ?? null;
                    $in_wishlist = is_product_in_wishlist($user_id, $product['product_id']);
                    $wishlist_action = $in_wishlist ? 'remove' : 'add';
                    $wishlist_icon = $in_wishlist ? 'fas' : 'far';
                    ?>
                    <?php if ($user_id): ?>
                        <a href="wishlist_action.php?product_id=<?= $product['product_id'] ?>&action=<?= $wishlist_action ?>"
                            class="btn btn-outline-primary px-3">
                            <i class="<?= $wishlist_icon ?> fa-heart mr-1"></i>
                            <?= $in_wishlist ? t('detail.product.remove_from_wishlist') : t('detail.product.add_to_wishlist') ?>
                        </a>
                    <?php else: ?>
                        <a href="login.php?redirect=detail.php?slug=<?= $product['slug'] ?>"
                            class="btn btn-outline-primary px-3">
                            <i class="far fa-heart mr-1"></i>
                            <?= t('detail.product.add_to_wishlist') ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            </form>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab"
                    href="#tab-pane-1"><?= t('detail.tabs.description') ?></a>
                <a class="nav-item nav-link" data-toggle="tab"
                    href="#tab-pane-2"><?= t('detail.tabs.information') ?></a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3"><?= t('detail.tabs.reviews') ?>
                    (<?= $review_count ?>)</a>
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
                            <h4 class="mb-4"><?= $review_count ?> <?= t('detail.reviews.reviews_for_title') ?>
                                "<?= $product['title'] ?>"</h4>
                            <?php foreach ($reviews as $review): ?>
                                <div class="media mb-4">
                                    <div class="media-body">
                                        <h6><?= htmlspecialchars($review['name']) ?><small> -
                                                <i><?= date('d M Y', strtotime($review['created_at'])) ?></i></small></h6>
                                        <div class="text-primary mb-2">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="<?= $i <= $review['rating'] ? 'fas' : 'far' ?> fa-star"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <p><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php if (empty($reviews)): ?>
                                <p><?= t('detail.reviews.no_reviews') ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <form action="submit_review.php" method="POST">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <input type="hidden" name="slug" value="<?= $product['slug'] ?>">
                                <input type="hidden" name="rating" id="rating-input" value="0" required>

                                <?php if (isset($_GET['review_success'])): ?>
                                    <div class="alert alert-success">
                                        <?= t('detail.reviews.success_message') ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($_GET['review_error'])): ?>
                                    <div class="alert alert-danger">
                                        <?= t('detail.reviews.error_' . $_GET['review_error']) ?>
                                    </div>
                                <?php endif; ?>

                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2"><?= t('detail.reviews.your_rating_label') ?></p>
                                    <div class="text-primary star-rating">
                                        <i class="far fa-star" data-rating="1" style="cursor: pointer;"></i>
                                        <i class="far fa-star" data-rating="2" style="cursor: pointer;"></i>
                                        <i class="far fa-star" data-rating="3" style="cursor: pointer;"></i>
                                        <i class="far fa-star" data-rating="4" style="cursor: pointer;"></i>
                                        <i class="far fa-star" data-rating="5" style="cursor: pointer;"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="message"><?= t('detail.reviews.your_review_label') ?></label>
                                    <textarea id="message" name="comment" cols="30" rows="5" class="form-control"
                                        required></textarea>
                                </div>

                                <?php if (!isset($_SESSION['user_id'])): ?>
                                    <div class="form-group">
                                        <label for="name"><?= t('detail.reviews.your_name_label') ?></label>
                                        <input type="text" name="name" class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><?= t('detail.reviews.your_email_label') ?></label>
                                        <input type="email" name="email" class="form-control" id="email" required>
                                    </div>
                                <?php else: ?>
                                    <p><strong><?= t('detail.reviews.logged_as') ?>:</strong>
                                        <?= $_SESSION['user_first_name'] ?>     <?= $_SESSION['user_last_name'] ?></p>
                                <?php endif; ?>

                                <div class="form-group mb-0">
                                    <input type="submit" value="<?= t('detail.reviews.submit_button') ?>"
                                        class="btn btn-primary px-3">
                                </div>
                            </form>

                            <script>
                                document.querySelectorAll('.star-rating i').forEach(star => {
                                    star.addEventListener('click', function () {
                                        const rating = this.getAttribute('data-rating');
                                        document.getElementById('rating-input').value = rating;

                                        document.querySelectorAll('.star-rating i').forEach(s => {
                                            if (s.getAttribute('data-rating') <= rating) {
                                                s.classList.remove('far');
                                                s.classList.add('fas');
                                            } else {
                                                s.classList.remove('fas');
                                                s.classList.add('far');
                                            }
                                        });
                                    });

                                    star.addEventListener('mouseover', function () {
                                        const rating = this.getAttribute('data-rating');
                                        document.querySelectorAll('.star-rating i').forEach(s => {
                                            if (s.getAttribute('data-rating') <= rating) {
                                                s.classList.remove('far');
                                                s.classList.add('fas');
                                            } else {
                                                s.classList.remove('fas');
                                                s.classList.add('far');
                                            }
                                        });
                                    });

                                    star.addEventListener('mouseout', function () {
                                        const currentRating = document.getElementById('rating-input').value;
                                        document.querySelectorAll('.star-rating i').forEach(s => {
                                            if (s.getAttribute('data-rating') <= currentRating) {
                                                s.classList.remove('far');
                                                s.classList.add('fas');
                                            } else {
                                                s.classList.remove('fas');
                                                s.classList.add('far');
                                            }
                                        });
                                    });
                                });
                            </script>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const variants = <?= json_encode(get_product_variants($product['product_id'])) ?>;

                                    function updateAvailability() {
                                        const selectedSize = document.querySelector('input[name="size"]:checked')?.value;
                                        const selectedColor = document.querySelector('input[name="color"]:checked')?.value;

                                        if (selectedSize) {
                                            document.querySelectorAll('input[name="color"]').forEach(colorInput => {
                                                const hasStock = variants.some(v => v.size_id == selectedSize && v.color_id == colorInput.value && v.stock > 0);
                                                colorInput.disabled = !hasStock;
                                                const label = colorInput.nextElementSibling;
                                                colorInput.parentElement.style.opacity = hasStock ? '1' : '0.4';
                                                colorInput.parentElement.style.pointerEvents = hasStock ? 'auto' : 'none';
                                                if (!hasStock && colorInput.checked) {
                                                    colorInput.checked = false;
                                                }
                                            });
                                        }

                                        if (selectedColor) {
                                            document.querySelectorAll('input[name="size"]').forEach(sizeInput => {
                                                const hasStock = variants.some(v => v.color_id == selectedColor && v.size_id == sizeInput.value && v.stock > 0);
                                                sizeInput.disabled = !hasStock;
                                                const label = sizeInput.nextElementSibling;
                                                sizeInput.parentElement.style.opacity = hasStock ? '1' : '0.4';
                                                sizeInput.parentElement.style.pointerEvents = hasStock ? 'auto' : 'none';
                                                if (!hasStock && sizeInput.checked) {
                                                    sizeInput.checked = false;
                                                }
                                            });
                                        }

                                        if (selectedSize && selectedColor) {
                                            const variant = variants.find(v => v.size_id == selectedSize && v.color_id == selectedColor);
                                            const isValid = variant && variant.stock > 0;
                                            const addToCartBtn = document.querySelector('button[type="submit"]');
                                            if (addToCartBtn) {
                                                addToCartBtn.disabled = !isValid;
                                                if (!isValid) {
                                                    addToCartBtn.innerHTML = '<i class="fa fa-times mr-1"></i> Out of Stock';
                                                } else {
                                                    addToCartBtn.innerHTML = '<i class="fa fa-shopping-cart mr-1"></i> <?= t('detail.product.add_to_cart') ?>';
                                                }
                                            }
                                        }
                                    }

                                    document.querySelectorAll('input[name="size"], input[name="color"]').forEach(input => {
                                        input.addEventListener('change', updateAvailability);
                                    });

                                    updateAvailability();
                                });
                            </script>
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
                            <img class="img-fluid w-100" src="<?= $SETTINGS['url_site'] ?>/<?= $related_product['image'] ?>"
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