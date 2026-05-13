<?php
include_once 'config.php';

?>
<!-- Footer Start -->
<div class="container-fluid bg-secondary text-dark mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <a href="<?= get_url('index.php') ?>" class="text-decoration-none">
                <h1 class="mb-4 display-5 font-weight-semi-bold"><span
                        class="text-primary font-weight-bold border border-white px-3 mr-1">D</span><?= t('footer.brand.name') ?>
                </h1>
            </a>
            <p><?= t('footer.description') ?></p>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4"><?= t('footer.quick_links.title') ?></h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="<?= get_url('index.php') ?>"><i
                                class="fa fa-angle-right mr-2"></i><?= t('footer.quick_links.home') ?></a>
                        <a class="text-dark mb-2" href="<?= get_url('shop.php') ?>"><i
                                class="fa fa-angle-right mr-2"></i><?= t('footer.quick_links.shop') ?></a>
                        <a class="text-dark mb-2" href="<?= get_url('cart.php') ?>"><i
                                class="fa fa-angle-right mr-2"></i><?= t('footer.quick_links.cart') ?></a>
                        <a class="text-dark" href="<?= get_url('contact.php') ?>"><i
                                class="fa fa-angle-right mr-2"></i><?= t('footer.quick_links.contact') ?></a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4"><?= t('footer.quick_links.title') ?></h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="<?= get_url('index.php') ?>"><i
                                class="fa fa-angle-right mr-2"></i><?= t('footer.quick_links.home') ?></a>
                        <a class="text-dark mb-2" href="<?= get_url('shop.php') ?>"><i
                                class="fa fa-angle-right mr-2"></i><?= t('footer.quick_links.shop') ?></a>
                        <a class="text-dark mb-2" href="<?= get_url('cart.php') ?>"><i
                                class="fa fa-angle-right mr-2"></i><?= t('footer.quick_links.cart') ?></a>
                        <a class="text-dark" href="<?= get_url('contact.php') ?>"><i
                                class="fa fa-angle-right mr-2"></i><?= t('footer.quick_links.contact') ?></a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4"><?= t('footer.newsletter.title') ?></h5>
                    <form action="">
                        <div class="form-group">
                            <input type="text" class="form-control border-0 py-4"
                                placeholder="<?= t('footer.newsletter.name_placeholder') ?>" required="required" />
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control border-0 py-4"
                                placeholder="<?= t('footer.newsletter.email_placeholder') ?>" required="required" />
                        </div>
                        <div>
                            <button class="btn btn-primary btn-block border-0 py-3"
                                type="submit"><?= t('footer.newsletter.button') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row border-top border-light mx-xl-5 py-4">
        <div class="col-md-6 px-xl-0">
            <p class="mb-md-0 text-center text-md-left text-dark">
                &copy; <a class="text-dark font-weight-semi-bold" href="#"><?= t('footer.copyright.site_name') ?></a>.
                <?= t('footer.copyright.rights') ?>
                <?= t('footer.copyright.designed_by') ?>
                <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a><br>
                <?= t('footer.copyright.distributed_by') ?> <a href="https://themewagon.com"
                    target="_blank">ThemeWagon</a>
            </p>
        </div>
        <div class="col-md-6 px-xl-0 text-center text-md-right">
            <img class="img-fluid" src="<?= $SETTINGS['url_site'] ?>/<?= t('footer.payments_image') ?>" alt="">
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="<?= $SETTINGS['url_site'] ?>/lib/easing/easing.min.js"></script>
<script src="<?= $SETTINGS['url_site'] ?>/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Contact Javascript File -->
<script src="<?= $SETTINGS['url_site'] ?>/mail/jqBootstrapValidation.min.js"></script>

<!-- Template Javascript -->
<script src="<?= $SETTINGS['url_site'] ?>/js/main.js"></script>