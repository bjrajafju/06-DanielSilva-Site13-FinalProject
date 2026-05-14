<?php
include_once 'config.php';

$categories = get_categories();

// SEO Setup
$meta_title = isset($meta_title) ? $meta_title . " | DaniShopper" : get_setting('meta_title', 'DaniShopper');
$meta_description = $meta_description ?? get_setting('meta_description', '');
$meta_keywords = $meta_keywords ?? get_setting('meta_keywords', '');
$meta_image = $meta_image ?? ($SETTINGS['url_site'] . '/' . get_setting('og_image', 'img/og-default.jpg'));
$meta_url = $SETTINGS['url_site'] . $_SERVER['REQUEST_URI'];
$favicon = get_setting('favicon', 'img/favicon.ico');
?>

<head>
    <meta charset="utf-8">
    <title><?= $meta_title ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="<?= $meta_keywords ?>" name="keywords">
    <meta content="<?= $meta_description ?>" name="description">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= $meta_title ?>">
    <meta property="og:description" content="<?= $meta_description ?>">
    <meta property="og:image" content="<?= $meta_image ?>">
    <meta property="og:url" content="<?= $meta_url ?>">
    <meta property="og:type" content="website">

    <!-- Favicon -->
    <link href="<?= $SETTINGS['url_site'] ?>/<?= $favicon ?>" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= $SETTINGS['url_site'] ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= $SETTINGS['url_site'] ?>/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <ul class="lang-switcher list-unstyled mb-0 mr-3">
                        <li class="d-inline-block">
                            <a href="<?= $SETTINGS['url_site'] ?>/trocaLingua.php?id=pt"
                                class="lang-btn text-dark px-2 <?= $_SESSION['lingua'] === 'pt' ? 'active' : '' ?>">
                                🇵🇹 <?php echo t('header.lang.pt'); ?>
                            </a>
                        </li>
                        <li class="d-inline-block">
                            <a href="<?= $SETTINGS['url_site'] ?>/trocaLingua.php?id=gb"
                                class="lang-btn text-dark px-2 <?= $_SESSION['lingua'] === 'gb' ? 'active' : '' ?>">
                                🇬🇧 <?php echo t('header.lang.en'); ?>
                            </a>
                        </li>
                    </ul>

                    <?php
                    $socials = get_social_links();
                    foreach ($socials as $s):
                    ?>
                        <a class="text-dark px-2" href="<?= htmlspecialchars($s['url']) ?>" target="_blank"
                            rel="noopener noreferrer">
                            <i class="<?= htmlspecialchars($s['icon']) ?>"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">
                        <span
                            class="text-primary font-weight-bold border px-3 mr-1">D</span><?php echo t('header.brand.name'); ?>
                    </h1>
                </a>
            </div>

            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control"
                            placeholder="<?php echo t('header.search.placeholder'); ?>">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-3 col-6 text-right">
                <a href="<?= get_url('wishlist.php') ?>" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge"><?= get_wishlist_count($_SESSION['user_id'] ?? null) ?></span>
                </a>
                <a href="<?= get_url('cart.php') ?>" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Alerts Start -->
    <div class="container-fluid pt-3">
        <div class="px-xl-5">
            <?php if (isset($_GET['error']) && $_GET['error'] === 'access_denied'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i> <?= t('login.error.access_denied') ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Alerts End -->


    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                    data-toggle="collapse" href="#navbar-vertical"
                    style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0"><?php echo t('header.categories.title'); ?></h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>

                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                    id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                    <div class="navbar-nav w-100">

                        <?php
                        foreach ($categories as $cat):
                        ?>

                            <a href="<?= get_url('shop.php?categories[]=' . $cat['id']) ?>" class="nav-item nav-link">
                                <?= $cat['name'] ?>
                            </a>

                        <?php endforeach; ?>

                    </div>
                </nav>
            </div>

            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">

                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold">
                            <span
                                class="text-primary font-weight-bold border px-3 mr-1">D</span><?php echo t('header.brand.name'); ?>
                        </h1>
                    </a>

                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">

                        <div class="navbar-nav mr-auto py-0">
                            <a href="<?= get_url('index.php') ?>"
                                class="nav-item nav-link"><?php echo t('header.nav.home'); ?></a>

                            <a href="<?= get_url('shop.php') ?>"
                                class="nav-item nav-link"><?php echo t('header.nav.shop'); ?></a>

                            <a href="<?= get_url('news.php') ?>"
                                class="nav-item nav-link"><?php echo t('menu.news'); ?></a>

                            <a href="<?= get_url('about.php') ?>"
                                class="nav-item nav-link"><?php echo t('menu.about'); ?></a>

                            <a href="<?= get_url('contact.php') ?>"
                                class="nav-item nav-link"><?php echo t('header.nav.contact'); ?></a>

                            <?php if (is_admin()): ?>
                                <a href="<?= $SETTINGS['url_site'] ?>/backoffice/index.php"
                                    class="nav-item nav-link text-primary font-weight-bold"><i
                                        class="fas fa-user-shield"></i> Backoffice</a>
                            <?php endif; ?>
                        </div>

                        <div class="navbar-nav ml-auto py-0">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-user text-primary mr-1"></i> <?= $_SESSION['user_first_name'] ?>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right rounded-0 m-0">
                                        <a href="<?= get_url('profile.php') ?>" class="dropdown-item"><i
                                                class="fas fa-id-card-alt mr-2 text-primary"></i>
                                            <?= t('header.nav.profile') ?></a>
                                        <a href="<?= get_url('profile.php?section=orders') ?>" class="dropdown-item"><i
                                                class="fas fa-box-open mr-2 text-primary"></i>
                                            <?= t('header.nav.orders') ?></a>
                                        <a href="<?= get_url('wishlist.php') ?>" class="dropdown-item"><i
                                                class="fas fa-heart mr-2 text-primary"></i>
                                            <?= t('header.nav.wishlist') ?></a>
                                        <div class="dropdown-divider"></div>
                                        <a href="<?= $SETTINGS['url_site'] ?>/logout.php" class="dropdown-item"><i
                                                class="fas fa-sign-out-alt mr-2 text-primary"></i>
                                            <?= t('header.nav.logout') ?></a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a href="<?= get_url('login.php') ?>"
                                    class="nav-item nav-link"><?php echo t('header.nav.login'); ?></a>
                                <a href="<?= get_url('register.php') ?>"
                                    class="nav-item nav-link"><?php echo t('header.nav.register'); ?></a>
                            <?php endif; ?>
                        </div>

                    </div>
                </nav>
            </div>

        </div>
    </div>
    <!-- Navbar End -->

    <!-- Cart Merge Modal -->
    <?php if (isset($_SESSION['show_cart_merge_popup']) && $_SESSION['show_cart_merge_popup']): ?>
        <div class="modal fade" id="cartMergeModal" tabindex="-1" role="dialog" aria-labelledby="cartMergeModalLabel"
            aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="cartMergeModalLabel"><?= t('cart.merge.modal_title') ?></h5>
                    </div>
                    <div class="modal-body text-center py-4">
                        <p class="mb-0"><?= t('cart.merge.modal_body') ?></p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary px-4"
                            id="btnMergeCart"><?= t('cart.merge.btn_merge') ?></button>
                        <button type="button" class="btn btn-secondary px-4"
                            id="btnDiscardCart"><?= t('cart.merge.btn_discard') ?></button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Garantir que o jQuery está carregado (o layout já inclui no footer, mas o header corre antes)
            // Por isso usamos um intervalo ou colocamos no final do body se possível.
            // Neste projeto, o footer é incluído DEPOIS do header, então o script deve correr no final.
            document.addEventListener("DOMContentLoaded", function() {
                if (typeof jQuery !== 'undefined') {
                    $('#cartMergeModal').modal('show');

                    function handleMerge(action) {
                        $.ajax({
                            url: '<?= $SETTINGS['url_site'] ?>/cart_merge.php',
                            method: 'POST',
                            data: {
                                action: action
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    $('#cartMergeModal').modal('hide');
                                    location.reload();
                                }
                            }
                        });
                    }

                    $('#btnMergeCart').on('click', function() {
                        handleMerge('merge');
                    });

                    $('#btnDiscardCart').on('click', function() {
                        handleMerge('discard');
                    });
                }
            });
        </script>
        <?php unset($_SESSION['show_cart_merge_popup']); ?>
    <?php endif; ?>