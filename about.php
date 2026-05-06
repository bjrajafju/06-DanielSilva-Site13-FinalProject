<!DOCTYPE html>
<html lang="<?= $_SESSION['lingua'] ?? 'pt' ?>">

<?php
include_once 'includes/config.php';
include 'includes/header.php';
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('about.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('header.nav.home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('about.title') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- About Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-12 mb-5">
            <div class="bg-light p-30 mb-30 text-center">
                <div class="mb-4">
                    <h2 class="section-title px-5"><span class="px-2"><?= t('about.subtitle') ?></span></h2>
                </div>
                <div class="about-content">
                    <p class="mb-4"><?= t('about.text_1') ?></p>
                    <p class="mb-0"><?= t('about.text_2') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<?php include 'includes/footer.php'; ?>

</body>

</html>