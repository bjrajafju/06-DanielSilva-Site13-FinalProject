<?php
include_once 'includes/config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $mobile = $_POST['mobile'] ?? '';

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $error = t('register.error.empty_fields');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = t('register.error.invalid_email');
    } else {
        // Verificar se email já existe
        $existing = db_get_one("users", "email = '" . addslashes($email) . "'");

        if ($existing) {
            $error = t('register.error.email_exists');
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $data = [
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'email'      => $email,
                'password'   => $hashed_password,
                'mobile'     => $mobile
            ];

            $user_id = db_insert("users", $data);

            if ($user_id) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_first_name'] = $first_name;
                $_SESSION['user_email'] = $email;

                // Verificar se existe carrinho de sessão para sugerir merge
                $session_cart = get_session_cart();
                if ($session_cart) {
                    $_SESSION['show_cart_merge_popup'] = true;
                }

                header("Location: " . $SETTINGS['url_site'] . "/index.php");
                exit;
            } else {
                $error = t('register.error.generic');
            }
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
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('register.header.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('register.header.breadcrumb_home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('register.header.breadcrumb_register') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Register Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 justify-content-center">
        <div class="col-lg-6 col-md-8 mb-5">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0 text-center">
                    <h4 class="font-weight-semi-bold m-0"><?= t('register.card.title') ?></h4>
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

                    <form action="register.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label><?= t('register.form.first_name_label') ?></label>
                                <input class="form-control py-4" type="text" name="first_name" placeholder="<?= t('register.form.first_name_placeholder') ?>" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?= t('register.form.last_name_label') ?></label>
                                <input class="form-control py-4" type="text" name="last_name" placeholder="<?= t('register.form.last_name_placeholder') ?>" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?= t('register.form.email_label') ?></label>
                                <input class="form-control py-4" type="email" name="email" placeholder="<?= t('register.form.email_placeholder') ?>" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?= t('register.form.mobile_label') ?></label>
                                <input class="form-control py-4" type="text" name="mobile" placeholder="<?= t('register.form.mobile_placeholder') ?>">
                            </div>
                            <div class="col-md-12 form-group">
                                <label><?= t('register.form.password_label') ?></label>
                                <input class="form-control py-4" type="password" name="password" placeholder="<?= t('register.form.password_placeholder') ?>" required>
                            </div>
                        </div>
                        <div class="pt-2">
                            <button class="btn btn-block btn-primary font-weight-bold py-3" type="submit"><?= t('register.form.submit_button') ?></button>
                        </div>
                    </form>
                </div>
                <div class="card-footer border-secondary bg-transparent text-center">
                    <p class="m-0"><?= t('register.footer.has_account') ?> <a href="login.php" class="text-primary font-weight-bold"><?= t('register.footer.login_link') ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register End -->

<?php include 'includes/footer.php'; ?>

</body>

</html>