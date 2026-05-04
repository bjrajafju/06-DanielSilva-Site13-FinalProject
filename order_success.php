<?php
include_once 'includes/config.php';

$order_id = (int)($_GET['order_id'] ?? 0);

include 'includes/header.php';
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('order_success.header.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('order_success.header.breadcrumb_home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('order_success.header.breadcrumb_success') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div class="container-fluid pt-5">
    <div class="row px-xl-5 justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="mb-5">
                <i class="fa fa-check-circle text-primary mb-4" style="font-size: 100px;"></i>
                <h2 class="font-weight-semi-bold mb-3"><?= t('order_success.thank_you') ?></h2>
                <p class="lead mb-4"><?= t('order_success.confirmation_message') ?></p>
                
                <?php if ($order_id): ?>
                    <div class="alert alert-info py-4">
                        <h4 class="m-0"><?= t('order_success.order_number') ?>: #<?= $order_id ?></h4>
                    </div>
                <?php endif; ?>

                <div class="mt-5">
                    <a href="index.php" class="btn btn-primary px-5 py-3 font-weight-bold"><?= t('order_success.continue_shopping') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
