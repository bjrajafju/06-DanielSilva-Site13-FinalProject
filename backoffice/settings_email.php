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
    $success_msg = "Definições guardadas com sucesso!";
}

// Handle Test Email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_test'])) {
    $to = $_POST['test_email'];
    $subject = "E-mail de Teste de " . get_setting('smtp_from_name');
    $body = "Este é um e-mail de teste para verificar se as suas definições SMTP estão corretas. Se está a ler isto, funciona!";

    if (send_email($to, $subject, $body)) {
        $success_msg = "E-mail de teste enviado com sucesso para $to!";
    } else {
        $error_msg = "Falha ao enviar e-mail de teste. Por favor, verifique as suas definições SMTP e os logs.";
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
        <h2 class="h4 mb-0">Definições de E-mail</h2>
    </div>

    <div class="container-fluid">
        <?php if ($success_msg): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $success_msg ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($error_msg): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error_msg ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Configuração SMTP</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label class="form-label">Servidor SMTP</label>
                                    <input type="text" name="smtp_host" class="form-control" value="<?= htmlspecialchars($settings['smtp_host']) ?>" placeholder="smtp.exemplo.pt" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Porta</label>
                                    <input type="number" name="smtp_port" class="form-control" value="<?= htmlspecialchars($settings['smtp_port']) ?>" placeholder="587" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nome de Utilizador</label>
                                    <input type="text" name="smtp_user" class="form-control" value="<?= htmlspecialchars($settings['smtp_user']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Palavra-passe</label>
                                    <input type="password" name="smtp_pass" class="form-control" value="<?= htmlspecialchars($settings['smtp_pass']) ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Encriptação</label>
                                    <select name="smtp_encryption" class="form-control">
                                        <option value="tls" <?= $settings['smtp_encryption'] == 'tls' ? 'selected' : '' ?>>TLS</option>
                                        <option value="ssl" <?= $settings['smtp_encryption'] == 'ssl' ? 'selected' : '' ?>>SSL</option>
                                        <option value="" <?= $settings['smtp_encryption'] == '' ? 'selected' : '' ?>>Nenhuma</option>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">E-mail do Remetente</label>
                                    <input type="email" name="smtp_from_email" class="form-control" value="<?= htmlspecialchars($settings['smtp_from_email']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nome do Remetente</label>
                                    <input type="text" name="smtp_from_name" class="form-control" value="<?= htmlspecialchars($settings['smtp_from_name']) ?>" required>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" name="save_settings" class="btn btn-primary px-4">
                                    <i class="fas fa-save mr-1"></i> Guardar Definições
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Testar Ligação</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Introduza um endereço de e-mail para enviar uma mensagem de teste usando as definições atuais.</p>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">E-mail do Destinatário</label>
                                <input type="email" name="test_email" class="form-control" placeholder="teste@exemplo.pt" required>
                            </div>
                            <button type="submit" name="send_test" class="btn btn-outline-info w-100">
                                <i class="fas fa-paper-plane mr-1"></i> Enviar E-mail de Teste
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

