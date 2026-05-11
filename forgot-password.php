<?php
include_once 'includes/config.php';

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';

    if (empty($email)) {
        $error_msg = t('login.error.empty_fields');
    } else {
        $res = create_password_reset($email);

        if ($res === "rate_limited") {
            $error_msg = t('forgot_password.rate_limited');
        } else {
            // Always show success to prevent account enumeration
            $success_msg = t('forgot_password.success');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lingua'] ?? 'pt' ?>">

<?php include 'includes/header.php'; ?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('forgot_password.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('login.header.breadcrumb_home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('forgot_password.title') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Forgot Password Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 justify-content-center">
        <div class="col-lg-4 col-md-6 mb-5">
            <div class="card border-secondary mb-5 shadow-sm">
                <div class="card-header bg-secondary border-0 text-center">
                    <h4 class="font-weight-semi-bold m-0"><?= t('forgot_password.title') ?></h4>
                </div>
                <div class="card-body">
                    <?php if ($success_msg): ?>
                        <div class="alert alert-success">
                            <?= $success_msg ?>
                        </div>
                        <div class="text-center mt-3">
                            <a href="login.php" class="btn btn-primary btn-block py-3 font-weight-bold">Back to Login</a>
                        </div>
                    <?php else: ?>
                        <?php if ($error_msg): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?= $error_msg ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <p class="text-muted small mb-4 text-center">
                            <?= t('forgot_password.instruction') ?>
                        </p>

                        <form action="" method="POST">
                            <div class="form-group">
                                <label><?= t('login.form.email_label') ?></label>
                                <input class="form-control py-4" type="email" name="email" placeholder="<?= t('login.form.email_placeholder') ?>" required>
                            </div>
                            <div class="pt-2">
                                <button class="btn btn-block btn-primary font-weight-bold py-3" type="submit"><?= t('header.nav.submit') ?? 'Submit' ?></button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="card-footer border-secondary bg-transparent text-center">
                    <p class="m-0"><a href="login.php" class="text-primary font-weight-bold">Back to Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Forgot Password End -->

<?php include 'includes/footer.php'; ?>