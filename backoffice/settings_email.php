<?php
include_once 'includes/helpers.php';

$success_msg = "";
$error_msg = "";

// Handle Settings Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    set_setting('smtp_host', $_POST['smtp_host']);
    set_setting('smtp_port', $_POST['smtp_port']);
    set_setting('smtp_user', $_POST['smtp_user']);
    set_setting('smtp_pass', $_POST['smtp_pass']);
    set_setting('smtp_encryption', $_POST['smtp_encryption']);
    set_setting('smtp_from_email', $_POST['smtp_from_email']);
    set_setting('smtp_from_name', $_POST['smtp_from_name']);
    $success_msg = "Settings saved successfully!";
}

// Handle Test Email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_test'])) {
    $to = $_POST['test_email'];
    $subject = "Test Email from " . get_setting('smtp_from_name');
    $body = "This is a test email to verify your SMTP settings are correct. If you are reading this, it works!";

    if (send_email($to, $subject, $body)) {
        $success_msg = "Test email sent successfully to $to!";
    } else {
        $error_msg = "Failed to send test email. Please check your SMTP settings and logs.";
    }
}

$settings = [
    'smtp_host' => get_setting('smtp_host'),
    'smtp_port' => get_setting('smtp_port'),
    'smtp_user' => get_setting('smtp_user'),
    'smtp_pass' => get_setting('smtp_pass'),
    'smtp_encryption' => get_setting('smtp_encryption'),
    'smtp_from_email' => get_setting('smtp_from_email'),
    'smtp_from_name' => get_setting('smtp_from_name'),
];

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Email Settings</h2>
    </div>

    <div class="container-fluid">
        <?php if ($success_msg): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $success_msg ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($error_msg): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error_msg ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">SMTP Configuration</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label class="form-label">SMTP Host</label>
                                    <input type="text" name="smtp_host" class="form-control" value="<?= htmlspecialchars($settings['smtp_host']) ?>" placeholder="smtp.example.com" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Port</label>
                                    <input type="number" name="smtp_port" class="form-control" value="<?= htmlspecialchars($settings['smtp_port']) ?>" placeholder="587" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="smtp_user" class="form-control" value="<?= htmlspecialchars($settings['smtp_user']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="smtp_pass" class="form-control" value="<?= htmlspecialchars($settings['smtp_pass']) ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Encryption</label>
                                    <select name="smtp_encryption" class="form-control">
                                        <option value="tls" <?= $settings['smtp_encryption'] == 'tls' ? 'selected' : '' ?>>TLS</option>
                                        <option value="ssl" <?= $settings['smtp_encryption'] == 'ssl' ? 'selected' : '' ?>>SSL</option>
                                        <option value="" <?= $settings['smtp_encryption'] == '' ? 'selected' : '' ?>>None</option>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Sender Email</label>
                                    <input type="email" name="smtp_from_email" class="form-control" value="<?= htmlspecialchars($settings['smtp_from_email']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sender Name</label>
                                    <input type="text" name="smtp_from_name" class="form-control" value="<?= htmlspecialchars($settings['smtp_from_name']) ?>" required>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" name="save_settings" class="btn btn-primary px-4">
                                    <i class="fas fa-save mr-1"></i> Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Test Connection</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Enter an email address to send a test message using the current settings above.</p>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Recipient Email</label>
                                <input type="email" name="test_email" class="form-control" placeholder="test@example.com" required>
                            </div>
                            <button type="submit" name="send_test" class="btn btn-outline-info w-100">
                                <i class="fas fa-paper-plane mr-1"></i> Send Test Email
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

