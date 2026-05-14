<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$page_data = $id ? db_get_one('pages', "id = $id") : null;

if (!$page_data && $id) {
    redirect("pages.php");
}

$translations = $id ? get_entity_translations('page_translations', 'page_id', $id) : [];
$languages = get_active_languages();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $data = [
        'is_active' => $is_active,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($id) {
        db_update('pages', $data, "id = $id");
        $page_id = $id;
        set_alert("Página atualizada com sucesso!");
    } else {
        redirect("pages.php");
    }

    foreach ($languages as $lang) {
        $lang_code = $lang['code'];
        $title = $_POST['trans'][$lang_code]['title'];
        $content = $_POST['trans'][$lang_code]['content'];

        $trans_data = [
            'page_id' => $page_id,
            'lang_code' => $lang_code,
            'title' => $title,
            'content' => $content
        ];

        $existing = db_get_one('page_translations', "page_id = $page_id AND lang_code = '$lang_code'");
        if ($existing) {
            db_update('page_translations', $trans_data, "id = {$existing['id']}");
        } else {
            db_insert('page_translations', $trans_data);
        }
    }

    redirect("pages.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Editar Página' : 'Criar Página' ?></h2>
        <a href="pages.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Voltar à Lista</a>
    </div>

    <div class="container-fluid">
        <form action="" method="POST">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">Traduções</div>
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-3" id="langTabs" role="tablist">
                                <?php foreach ($languages as $index => $lang): ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="tab-<?= $lang['code'] ?>" data-toggle="tab" data-target="#content-<?= $lang['code'] ?>" type="button" role="tab">
                                            <?= $lang['emoji'] ?> <?= strtoupper($lang['code']) ?>
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="tab-content" id="langTabsContent">
                                <?php foreach ($languages as $index => $lang):
                                    $t = $translations[$lang['code']] ?? [];
                                ?>
                                    <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="content-<?= $lang['code'] ?>" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label">Título (<?= strtoupper($lang['code']) ?>)</label>
                                            <input type="text" name="trans[<?= $lang['code'] ?>][title]" class="form-control" value="<?= $t['title'] ?? '' ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Conteúdo (Aceita HTML)</label>
                                            <textarea name="trans[<?= $lang['code'] ?>][content]" class="form-control" rows="15"><?= $t['content'] ?? '' ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">Definições</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control" value="<?= $page_data['slug'] ?? '' ?>" disabled>
                                <div class="form-text">O slug não pode ser alterado.</div>
                            </div>
                            <div class="custom-control custom-switch mb-3">
                                <input class="custom-control-input" type="checkbox" name="is_active" id="isActive" <?= ($page_data['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="isActive">Página Ativa</label>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-save"></i> Guardar Página
                            </button>
                            <a href="pages.php" class="btn btn-outline-secondary w-100">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

