<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$social = $id ? db_get_one('social_links', "id = $id") : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $platform = trim($_POST['platform']);
    $url = trim($_POST['url']);
    $icon = trim($_POST['icon']);
    $sort_order = (int) $_POST['sort_order'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $error = '';
    if (empty($platform) || empty($url) || empty($icon)) {
        $error = "Todos os campos obrigatórios devem ser preenchidos.";
    } elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
        $error = "Por favor, insira um URL válido.";
    }

    if (!$error) {
        $data = [
            'platform' => $platform,
            'url' => $url,
            'icon' => $icon,
            'sort_order' => $sort_order,
            'is_active' => $is_active
        ];

        if ($id) {
            db_update('social_links', $data, "id = $id");
            set_alert("Rede social atualizada com sucesso!");
        } else {
            db_insert('social_links', $data);
            set_alert("Rede social adicionada com sucesso!");
        }
        redirect('social_links.php');
    } else {
        set_alert($error, 'danger');
    }
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Editar Rede Social' : 'Adicionar Rede Social' ?></h2>
        <a href="social_links.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Voltar</a>
    </div>

    <div class="container-fluid">
        <?php show_alert(); ?>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header"><?= $id ? 'Editar Detalhes' : 'Novos Detalhes' ?></div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Nome da Plataforma *</label>
                                    <input type="text" name="platform" class="form-control"
                                        placeholder="Ex: Facebook, Instagram..."
                                        value="<?= htmlspecialchars($social['platform'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Ordem de Exibição</label>
                                    <input type="number" name="sort_order" class="form-control"
                                        value="<?= htmlspecialchars($social['sort_order'] ?? '0') ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold">URL da Página *</label>
                                <input type="url" name="url" class="form-control" placeholder="https://..."
                                    value="<?= htmlspecialchars($social['url'] ?? '') ?>" required>
                                <div class="form-text text-muted small">Certifique-se de incluir o http:// ou https://
                                </div>
                            </div>

                            <div class="row align-items-end mb-3">
                                <div class="col-md-9">
                                    <label class="form-label font-weight-bold">Classe do Ícone FontAwesome *</label>
                                    <input type="text" name="icon" id="iconInput" class="form-control"
                                        placeholder="Ex: fab fa-facebook-f"
                                        value="<?= htmlspecialchars($social['icon'] ?? '') ?>" required>
                                    <div class="form-text text-muted small">
                                        Pode encontrar ícones em <a
                                            href="https://fontawesome.com/icons?d=gallery&m=free"
                                            target="_blank">fontawesome.com</a>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <div class="p-3 bg-light rounded border mb-1" style="min-height: 60px;">
                                        <i id="iconPreview"
                                            class="<?= htmlspecialchars($social['icon'] ?? 'fas fa-question') ?> fa-2x text-primary"></i>
                                    </div>
                                    <small class="text-muted d-block">Preview do Ícone</small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="isActiveSwitch"
                                        name="is_active" <?= (!isset($social) || $social['is_active']) ? 'checked' : '' ?>>
                                    <label class="custom-control-label font-weight-bold" for="isActiveSwitch">Ativo
                                        (visível no site)</label>
                                </div>
                            </div>

                            <div class="text-right border-top pt-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save mr-1"></i> Guardar Alterações
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const iconInput = document.getElementById('iconInput');
        const iconPreview = document.getElementById('iconPreview');

        iconInput.addEventListener('input', function() {
            // Clear previous classes except fa-2x and text-primary
            iconPreview.className = 'fa-2x text-primary';

            const val = this.value.trim();
            if (val) {
                // FontAwesome classes usually have multiple parts like 'fab fa-facebook'
                val.split(' ').forEach(cls => {
                    if (cls) iconPreview.classList.add(cls);
                });
            } else {
                iconPreview.classList.add('fas', 'fa-question');
            }
        });
    });
</script>

<?php include 'layout/footer.php'; ?>