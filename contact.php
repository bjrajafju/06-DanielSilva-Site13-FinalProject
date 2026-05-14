<!DOCTYPE html>
<html lang="gb">

<?php
include_once 'includes/config.php';
include 'includes/header.php';

$stores = get_stores();

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!$name || !$email || !$subject || !$message) {
        $error = 'All fields are required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email';
    } else {

        create_message([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ]);

        $success = true;

        $_POST = [];
    }
}

if (!empty($_POST['website'])) {
    exit;
}
?>
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?= t('contact.header.title') ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?= $SETTINGS['url_site'] ?>/index.php"><?= t('contact.header.breadcrumb_home') ?></a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?= t('contact.header.breadcrumb_contact') ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Contact Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2"><?= t('contact.form.title') ?></span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="contact-form">
                <div id="success"></div>
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <?= t('contact.form.success') ?>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="control-group">
                        <input value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" name="name" type="text" class="form-control" id="name" placeholder="<?= t('contact.form.name_placeholder') ?>"
                            required="required" data-validation-required-message="Please enter your name" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" name="email" type="email" class="form-control" id="email" placeholder="<?= t('contact.form.email_placeholder') ?>"
                            required="required" data-validation-required-message="Please enter your email" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" name="subject" type="text" class="form-control" id="subject" placeholder="<?= t('contact.form.subject_placeholder') ?>"
                            required="required" data-validation-required-message="Please enter a subject" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <textarea value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" name="message" class="form-control" rows="6" id="message" placeholder="<?= t('contact.form.message_placeholder') ?>"
                            required="required"
                            data-validation-required-message="Please enter your message"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton"><?= t('contact.form.send_button') ?></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            <h5 class="font-weight-semi-bold mb-3"><?= t('contact.info.title') ?></h5>
            <p><?= t('contact.info.description') ?></p>
            <?php foreach ($stores as $index => $store): ?>
                <div class="d-flex flex-column <?= $index > 0 ? 'mt-4' : '' ?>">
                    <h5 class="font-weight-semi-bold mb-3">
                        <?= htmlspecialchars($store['name']) ?>
                    </h5>

                    <p class="mb-2">
                        <i class="fa fa-map-marker-alt text-primary mr-3"></i>
                        <?= htmlspecialchars($store['address']) ?>
                    </p>

                    <p class="mb-2">
                        <i class="fa fa-envelope text-primary mr-3"></i>
                        <?= htmlspecialchars($store['email']) ?>
                    </p>

                    <p class="mb-2">
                        <i class="fa fa-phone-alt text-primary mr-3"></i>
                        <?= htmlspecialchars($store['phone']) ?>
                    </p>
                </div>
            <?php endforeach; ?>
            <?php if (empty($stores)): ?>
                <p><b><?= t('contact.info.no_stores') ?></b></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Contact End -->

<?php include 'includes/footer.php'; ?>

</body>

</html>