<!DOCTYPE html>
<html lang="<?= $_SESSION['lingua'] ?? 'pt' ?>">

<?php
include_once 'includes/config.php';
include 'includes/header.php';

$per_page = 6;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $per_page;

$total_news = get_news_count();
$total_pages = ceil($total_news / $per_page);

$news_items = get_news_list($per_page, $offset);
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('menu.news') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('header.nav.home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('menu.news') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- News List Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <?php foreach ($news_items as $news): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="<?= $SETTINGS['url_site'] ?>/<?= htmlspecialchars($news['image']) ?>" alt="<?= htmlspecialchars($news['title']) ?>" onerror="this.src='https://via.placeholder.com/400x250'">
                    </div>
                    <div class="card-body bg-light text-center p-4">
                        <h4 class="font-weight-semi-bold mb-3"><?= htmlspecialchars($news['title']) ?></h4>
                        <p class="mb-4 text-muted"><?= htmlspecialchars($news['short_description']) ?></p>
                        <a href="<?= $SETTINGS['url_site'] ?>/news-detail.php?slug=<?= $news['slug'] ?>" class="btn btn-outline-primary px-4">
                            <?= t('news.read_more') ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($news_items)): ?>
            <div class="col-12 text-center py-5">
                <h3><?= t('news.empty_list') ?></h3>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <div class="col-12 pb-1">
            <nav>
                <?php if ($total_pages > 1): ?>
                    <ul class="pagination justify-content-center mb-3">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= build_query(['page' => $page - 1]) ?>">&laquo;</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="<?= build_query(['page' => $i]) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= build_query(['page' => $page + 1]) ?>">&raquo;</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</div>
<!-- News List End -->

<?php include 'includes/footer.php'; ?>

</body>

</html>