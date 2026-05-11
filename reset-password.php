<?php
include_once 'includes/config.php';

$token = $_GET['token'] ?? '';
$user_id = validate_reset_token($token);

$error_msg = '';
$success_msg = '';

if (!$user_id) {
    $error_msg = t('reset_password.error.invalid_token');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id) {
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($password)) {
        $error_msg = t('login.error.empty_fields');
    } elseif ($password !== $confirm) {
        $error_msg = t('reset_password.error.mismatch');
    } else {
        if (reset_user_password($user_id, $password, $token)) {
            $success_msg = t('reset_password.success');
        } else {
            $error_msg = "Error updating password.";
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
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('reset_password.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('login.header.breadcrumb_home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('reset_password.title') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Reset Password Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 justify-content-center">
        <div class="col-lg-4 col-md-6 mb-5">
            <div class="card border-secondary mb-5 shadow-sm">
                <div class="card-header bg-secondary border-0 text-center">
                    <h4 class="font-weight-semi-bold m-0"><?= t('reset_password.title') ?></h4>
                </div>
                <div class="card-body">
                    <?php if ($success_msg): ?>
                        <div class="alert alert-success text-center">
                            <?= $success_msg ?>
                        </div>
                        <div class="text-center mt-3">
                            <a href="login.php" class="btn btn-primary btn-block py-3 font-weight-bold">Login Now</a>
                        </div>
                    <?php elseif (!$user_id): ?>
                        <div class="alert alert-danger text-center">
                            <?= $error_msg ?>
                        </div>
                        <div class="text-center mt-3">
                            <a href="forgot-password.php" class="btn btn-outline-primary btn-block py-3 font-weight-bold">Request New Link</a>
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

                        <form action="" method="POST">
                            <div class="form-group">
                                <label><?= t('reset_password.new_password') ?></label>
                                <input class="form-control py-4" type="password" name="password" required minlength="6">
                            </div>
                            <div class="form-group">
                                <label><?= t('reset_password.confirm_password') ?></label>
                                <input class="form-control py-4" type="password" name="confirm_password" required minlength="6">
                            </div>
                            <div class="pt-2">
                                <button class="btn btn-block btn-primary font-weight-bold py-3" type="submit"><?= t('reset_password.title') ?></button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reset Password End -->

<?php include 'includes/footer.php'; ?>