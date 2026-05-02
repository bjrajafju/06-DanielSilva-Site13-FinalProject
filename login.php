<?php
include_once 'includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = t('login.error.empty_fields');
    } else {
        $user = db_get_one("users", "email = '" . addslashes($email) . "'");

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_first_name'] = $user['first_name'];
            $_SESSION['user_email'] = $user['email'];

            header("Location: " . $SETTINGS['url_site'] . "/index.php");
            exit;
        } else {
            $error = t('login.error.invalid_credentials');
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
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('login.header.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('login.header.breadcrumb_home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('login.header.breadcrumb_login') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Login Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 justify-content-center">
        <div class="col-lg-4 col-md-6 mb-5">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0 text-center">
                    <h4 class="font-weight-semi-bold m-0"><?= t('login.card.title') ?></h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $error ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label><?= t('login.form.email_label') ?></label>
                            <input class="form-control py-4" type="email" name="email" placeholder="<?= t('login.form.email_placeholder') ?>" required>
                        </div>
                        <div class="form-group">
                            <label><?= t('login.form.password_label') ?></label>
                            <input class="form-control py-4" type="password" name="password" placeholder="<?= t('login.form.password_placeholder') ?>" required>
                        </div>
                        <div class="pt-2">
                            <button class="btn btn-block btn-primary font-weight-bold py-3" type="submit"><?= t('login.form.submit_button') ?></button>
                        </div>
                    </form>
                </div>
                <div class="card-footer border-secondary bg-transparent text-center">
                    <p class="m-0"><?= t('login.footer.no_account') ?> <a href="register.php" class="text-primary font-weight-bold"><?= t('login.footer.register_link') ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login End -->

<?php include 'includes/footer.php'; ?>

</body>

</html>
