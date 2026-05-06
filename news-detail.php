<!DOCTYPE html>
<html lang="<?= $_SESSION['lingua'] ?? 'pt' ?>">

<?php
include_once 'includes/config.php';
include 'includes/header.php';

$slug = $_GET['slug'] ?? null;

if (!$slug) {
    header("Location: " . $SETTINGS['url_site'] . "/news.php");
    exit;
}

$news = get_news_by_slug($slug);

if (!$news) {
    header("Location: " . $SETTINGS['url_site'] . "/news.php");
    exit;
}
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= htmlspecialchars($news['title']) ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('header.nav.home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/news.php"><?= t('menu.news') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= htmlspecialchars($news['title']) ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- News Detail Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-8 pb-5 mx-auto">
            <div class="bg-light p-30 mb-30">
                <img class="img-fluid w-100 mb-4 rounded" src="<?= $SETTINGS['url_site'] ?>/<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" onerror="this.src='https://via.placeholder.com/800x400'">

                <h2 class="font-weight-semi-bold mb-3"><?= htmlspecialchars($news['title']) ?></h2>
                <p class="text-muted mb-4">
                    <i class="far fa-calendar-alt mr-2"></i><?= date('d M Y', strtotime($news['created_at'])) ?>
                </p>

                <div class="news-content">
                    <?= $news['content'] ?>
                </div>

                <hr class="my-5">

                <a href="<?= $SETTINGS['url_site'] ?>/news.php" class="btn btn-primary px-4">
                    <i class="fa fa-arrow-left mr-2"></i><?= t('news.back_to_list') ?>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- News Detail End -->

<?php include 'includes/footer.php'; ?>

</body>

</html>