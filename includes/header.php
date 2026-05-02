<?php
include_once 'config.php';

$categories = get_categories();
?>

<head>
    <meta charset="utf-8">
    <title>EShopper - Bootstrap Shop Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="<?= $SETTINGS['url_site'] ?>/img/favicon.ico" rel="icon">

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
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href=""><?php echo t('header.topbar.faqs'); ?></a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href=""><?php echo t('header.topbar.help'); ?></a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href=""><?php echo t('header.topbar.support'); ?></a>
                </div>
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

                    <a class="text-dark px-2" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="text-dark px-2" href=""><i class="fab fa-twitter"></i></a>
                    <a class="text-dark px-2" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="text-dark px-2" href=""><i class="fab fa-instagram"></i></a>
                    <a class="text-dark pl-2" href=""><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">
                        <span class="text-primary font-weight-bold border px-3 mr-1">D</span><?php echo t('header.brand.name'); ?>
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
                <a href="" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">0</span>
                </a>
                <a href="" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">0</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


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

                            <a href="<?= $SETTINGS['url_site'] ?>/shop.php"
                                class="nav-item nav-link">
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
                            <span class="text-primary font-weight-bold border px-3 mr-1">D</span><?php echo t('header.brand.name'); ?>
                        </h1>
                    </a>

                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">

                        <div class="navbar-nav mr-auto py-0">
                            <a href="<?= $SETTINGS['url_site'] ?>/index.php"
                                class="nav-item nav-link"><?php echo t('header.nav.home'); ?></a>

                            <a href="<?= $SETTINGS['url_site'] ?>/shop.php"
                                class="nav-item nav-link"><?php echo t('header.nav.shop'); ?></a>

                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="<?= $SETTINGS['url_site'] ?>/screens/cart.php" class="dropdown-item">Shopping Cart</a>
                                    <a href="<?= $SETTINGS['url_site'] ?>/screens/checkout.php" class="dropdown-item">Checkout</a>
                                </div>
                            </div>

                            <a href="<?= $SETTINGS['url_site'] ?>/screens/contact.php"
                                class="nav-item nav-link"><?php echo t('header.nav.contact'); ?></a>
                        </div>

                        <div class="navbar-nav ml-auto py-0">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="#" class="nav-item nav-link"><i class="fas fa-user text-primary mr-1"></i> <?= $_SESSION['user_first_name'] ?></a>
                                <a href="<?= $SETTINGS['url_site'] ?>/logout.php" class="nav-item nav-link"><?php echo t('header.nav.logout'); ?></a>
                            <?php else: ?>
                                <a href="<?= $SETTINGS['url_site'] ?>/login.php" class="nav-item nav-link"><?php echo t('header.nav.login'); ?></a>
                                <a href="<?= $SETTINGS['url_site'] ?>/register.php" class="nav-item nav-link"><?php echo t('header.nav.register'); ?></a>
                            <?php endif; ?>
                        </div>

                    </div>
                </nav>
            </div>

        </div>
    </div>
    <!-- Navbar End -->