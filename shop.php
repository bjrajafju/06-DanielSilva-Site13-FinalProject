<!DOCTYPE html>
<html lang="gb">

<?php
include_once 'includes/config.php';
include 'includes/header.php';

$selected_colors     = $_GET['colors'] ?? [];
$selected_sizes      = $_GET['sizes'] ?? [];
$selected_prices     = $_GET['price'] ?? [];
$selected_categories = $_GET['categories'] ?? [];
$selected_sort       = $_GET['sort'] ?? '';
$search              = $_GET['search'] ?? '';
$view                = $_GET['view'] ?? 'grid';

if (!is_array($selected_colors)) $selected_colors = [$selected_colors];
if (!is_array($selected_sizes)) $selected_sizes = [$selected_sizes];
if (!is_array($selected_prices)) $selected_prices = [$selected_prices];
if (!is_array($selected_categories)) $selected_categories = [$selected_categories];

$per_page = 12;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $per_page;

$filters = [
    'colors'     => $selected_colors,
    'sizes'      => $selected_sizes,
    'categories' => $selected_categories,
    'search'     => $search,
    'price'      => $selected_prices,
    'sort'       => $selected_sort
];

$total_products = get_products_filtered_count($filters);
$total_pages = ceil($total_products / $per_page);

$products = get_products_filtered($filters, $per_page, $offset);

$colors = get_filter_colors();
$sizes = get_filter_sizes();
$categories = get_filter_categories();
$price_counts = get_filter_prices();
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('shop.header.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('shop.header.breadcrumb_home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('shop.header.breadcrumb_shop') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Shop Start -->
<div class="container-fluid pt-5">
    <form method="GET">
        <input type="hidden" name="sort" value="<?= htmlspecialchars($selected_sort) ?>">
        <input type="hidden" name="view" value="<?= htmlspecialchars($view) ?>">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Categories Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4"><?= t('shop.sidebar.filter_category_title') ?></h5>
                    <?php foreach ($categories as $cat): ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input
                                type="checkbox"
                                name="categories[]"
                                value="<?= $cat['id'] ?>"
                                class="custom-control-input"
                                id="cat-<?= $cat['id'] ?>"
                                <?= in_array($cat['id'], $selected_categories) ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="cat-<?= $cat['id'] ?>">
                                <?= $cat['name'] ?>
                            </label>
                            <span class="badge border font-weight-normal"><?= $cat['total'] ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Categories End -->

                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4"><?= t('shop.sidebar.filter_price_title') ?></h5>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" name="price[]" value="0-100"
                            class="custom-control-input" id="price-1"
                            <?= in_array('0-100', $selected_prices) ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="price-1">$0 - $100</label>
                        <span class="badge border font-weight-normal"><?= $price_counts['p1'] ?></span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" name="price[]" value="100-200"
                            class="custom-control-input" id="price-2"
                            <?= in_array('100-200', $selected_prices) ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="price-2">$100 - $200</label>
                        <span class="badge border font-weight-normal"><?= $price_counts['p2'] ?></span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" name="price[]" value="200-300"
                            class="custom-control-input" id="price-3"
                            <?= in_array('200-300', $selected_prices) ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="price-3">$200 - $300</label>
                        <span class="badge border font-weight-normal"><?= $price_counts['p3'] ?></span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" name="price[]" value="300-400"
                            class="custom-control-input" id="price-4"
                            <?= in_array('300-400', $selected_prices) ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="price-4">$300 - $400</label>
                        <span class="badge border font-weight-normal"><?= $price_counts['p4'] ?></span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" name="price[]" value="400-500"
                            class="custom-control-input" id="price-5"
                            <?= in_array('400-500', $selected_prices) ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="price-5">$400 - $500</label>
                        <span class="badge border font-weight-normal"><?= $price_counts['p5'] ?></span>
                    </div>
                </div>
                <!-- Price End -->

                <!-- Color Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4"><?= t('shop.sidebar.filter_color_title') ?></h5>
                    <?php foreach ($colors as $color): ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input
                                type="checkbox"
                                name="colors[]"
                                value="<?= $color['id'] ?>"
                                class="custom-control-input"
                                id="color-<?= $color['id'] ?>"
                                <?= in_array($color['id'], $selected_colors) ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="color-<?= $color['id'] ?>">
                                <?= $color['name'] ?>
                            </label>
                            <span class="badge border font-weight-normal"><?= $color['total'] ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Color End -->

                <!-- Size Start -->
                <div class="mb-5">
                    <h5 class="font-weight-semi-bold mb-4"><?= t('shop.sidebar.filter_size_title') ?></h5>
                    <?php foreach ($sizes as $size): ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input
                                type="checkbox"
                                name="sizes[]"
                                value="<?= $size['id'] ?>"
                                class="custom-control-input"
                                id="size-<?= $size['id'] ?>"
                                <?= in_array($size['id'], $selected_sizes) ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="size-<?= $size['id'] ?>">
                                <?= $size['name'] ?>
                            </label>
                            <span class="badge border font-weight-normal"><?= $size['total'] ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Size End -->
                <div class="mt-4">
                    <button class="btn btn-primary w-100">
                        <?= t('shop.filters.apply') ?>
                    </button>
                </div>
            </div>
            <!-- Shop Sidebar End -->

            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3 <?= $view === 'list' ? 'view-list' : 'view-grid' ?>">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="input-group">
                                <input
                                    type="text"
                                    name="search"
                                    value="<?= htmlspecialchars($search) ?>"
                                    class="form-control"
                                    placeholder="<?= t('shop.products.search_placeholder') ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-primary">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex ml-4">
                                <a href="<?= build_query(['view' => 'grid']) ?>" class="btn border <?= $view === 'grid' ? 'btn-primary text-white' : '' ?>" title="Grid View">
                                    <i class="fa fa-th"></i>
                                </a>
                                <a href="<?= build_query(['view' => 'list']) ?>" class="btn border ml-2 <?= $view === 'list' ? 'btn-primary text-white' : '' ?>" title="List View">
                                    <i class="fa fa-bars"></i>
                                </a>
                            </div>
                            <div class="dropdown ml-4">
                                <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                    $sort_label = t('shop.products.sort_button');
                                    switch ($selected_sort) {
                                        case 'name_asc':
                                            $sort_label = t('shop.products.sort_nameAZ');
                                            break;
                                        case 'name_desc':
                                            $sort_label = t('shop.products.sort_nameZA');
                                            break;
                                        case 'price_asc':
                                            $sort_label = t('shop.products.sort_price_asc');
                                            break;
                                        case 'price_desc':
                                            $sort_label = t('shop.products.sort_price_desc');
                                            break;
                                    }
                                    echo $sort_label;
                                    ?>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item" href="<?= build_query(['sort' => 'name_asc', 'page' => 1]) ?>"><?= t('shop.products.sort_nameAZ') ?></a>
                                    <a class="dropdown-item" href="<?= build_query(['sort' => 'name_desc', 'page' => 1]) ?>"><?= t('shop.products.sort_nameZA') ?></a>
                                    <a class="dropdown-item" href="<?= build_query(['sort' => 'price_asc', 'page' => 1]) ?>"><?= t('shop.products.sort_price_asc') ?></a>
                                    <a class="dropdown-item" href="<?= build_query(['sort' => 'price_desc', 'page' => 1]) ?>"><?= t('shop.products.sort_price_desc') ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($products as $product): ?>
                        <div class="<?= $view === 'list' ? 'col-12 mb-3' : 'col-lg-4 col-md-6 col-sm-12 pb-1' ?>">
                            <?php if ($view === 'list'): ?>
                                <!-- List View Layout -->
                                <div class="product-list-item d-flex align-items-center p-3">
                                    <div class="product-list-img flex-shrink-0 mr-4">
                                        <a href="<?= $SETTINGS['url_site'] ?>/detail.php?slug=<?= $product['slug'] ?>">
                                            <img src="<?= $product['image'] ?>" alt="<?= $product['title'] ?>" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="product-list-info flex-grow-1">
                                        <h5 class="mb-2">
                                            <a href="<?= $SETTINGS['url_site'] ?>/detail.php?slug=<?= $product['slug'] ?>" class="text-dark font-weight-semi-bold">
                                                <?= $product['title'] ?>
                                            </a>
                                        </h5>
                                        <h4 class="text-primary font-weight-bold mb-0"><?= $product['price'] ?>€</h4>
                                    </div>
                                    <div class="product-list-action ml-4">
                                        <a href="<?= $SETTINGS['url_site'] ?>/detail.php?slug=<?= $product['slug'] ?>" class="btn btn-primary btn-sm px-4">
                                            <i class="fas fa-eye mr-1"></i> View Detail
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- Grid View Layout -->
                                <div class="card product-item border-0 mb-4">
                                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                        <img class="img-fluid w-100" src="<?= $product['image'] ?>" alt="">
                                    </div>
                                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                        <h6 class="text-truncate mb-3"><?= $product['title'] ?></h6>
                                        <div class="d-flex justify-content-center">
                                            <h6><?= $product['price'] ?>€</h6>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-center bg-light border">
                                        <a href="<?= $SETTINGS['url_site'] ?>/detail.php?slug=<?= $product['slug'] ?>"
                                            class="btn btn-sm text-dark p-0">
                                            <i class="fas fa-eye text-primary mr-1"></i>View Detail
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-12 pb-1">
                    <nav>
                        <?php if ($total_pages > 1): ?>
                            <ul class="pagination justify-content-center mb-3">

                                <!-- Previous -->
                                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= build_query(['page' => $page - 1]) ?>">
                                        &laquo;
                                    </a>
                                </li>

                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= build_query(['page' => $i]) ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Next -->
                                <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= build_query(['page' => $page + 1]) ?>">
                                        &raquo;
                                    </a>
                                </li>

                            </ul>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Shop End -->

<?php include 'includes/footer.php'; ?>

</body>

</html>