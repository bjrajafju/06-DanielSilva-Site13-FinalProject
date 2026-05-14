<?php
include_once 'includes/helpers.php';

$success_msg = "";
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    set_setting('meta_title', $_POST['meta_title']);
    set_setting('meta_description', $_POST['meta_description']);
    set_setting('meta_keywords', $_POST['meta_keywords']);
    set_setting('og_image', $_POST['og_image']);
    set_setting('favicon', $_POST['favicon']);
    $success_msg = "Definições de SEO guardadas com sucesso!";
}

$settings = [
    'meta_title' => get_setting('meta_title'),
    'meta_description' => get_setting('meta_description'),
    'meta_keywords' => get_setting('meta_keywords'),
    'og_image' => get_setting('og_image'),
    'favicon' => get_setting('favicon'),
];

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0">Definições de SEO</h2>
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

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Configurações Gerais de SEO</h6>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Título Padrão do Site (meta_title)</label>
                        <input type="text" name="meta_title" class="form-control"
                            value="<?= htmlspecialchars($settings['meta_title']) ?>" required>
                        <div class="form-text text-muted small">Este título aparecerá se a página não definir um
                            específico.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição Padrão (meta_description)</label>
                        <textarea name="meta_description" class="form-control"
                            rows="3"><?= htmlspecialchars($settings['meta_description']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Palavras-chave (meta_keywords)</label>
                        <input type="text" name="meta_keywords" class="form-control"
                            value="<?= htmlspecialchars($settings['meta_keywords']) ?>">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Imagem Open Graph Padrão (og_image)</label>
                            <input type="text" name="og_image" class="form-control"
                                value="<?= htmlspecialchars($settings['og_image']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Favicon Path</label>
                            <input type="text" name="favicon" class="form-control"
                                value="<?= htmlspecialchars($settings['favicon']) ?>">
                        </div>
                    </div>

                    <div class="text-right mt-4">
                        <button type="submit" name="save_settings" class="btn btn-primary px-4">
                            <i class="fas fa-save mr-1"></i> Guardar SEO
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>