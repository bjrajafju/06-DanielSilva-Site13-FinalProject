<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$news_data = $id ? db_get_one('news', "id = $id") : null;
$translations = $id ? get_entity_translations('news_translations', 'news_id', $id) : [];
$languages = get_active_languages();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    // Handle Image
    $image = handle_image_upload('image', $news_data['image'] ?? '');

    $data = [
        'image' => $image,
        'is_active' => $is_active,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    if ($id) {
        db_update('news', $data, "id = $id");
        $news_id = $id;
        set_alert("Notícia atualizada com sucesso!");
    } else {
        $data['created_at'] = date('Y-m-d H:i:s');
        $news_id = db_insert('news', $data);
        set_alert("Notícia criada com sucesso!");
    }

    // Handle Translations
    foreach ($languages as $lang) {
        $lang_code = $lang['code'];
        $title = $_POST['trans'][$lang_code]['title'];
        $slug = $_POST['trans'][$lang_code]['slug'] ?: strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $short_description = $_POST['trans'][$lang_code]['short_description'];
        $content = $_POST['trans'][$lang_code]['content'];

        $trans_data = [
            'news_id' => $news_id,
            'lang_code' => $lang_code,
            'title' => $title,
            'slug' => $slug,
            'short_description' => $short_description,
            'content' => $content
        ];

        $existing = db_get_one('news_translations', "news_id = $news_id AND lang_code = '$lang_code'");
        if ($existing) {
            db_update('news_translations', $trans_data, "id = {$existing['id']}");
        } else {
            db_insert('news_translations', $trans_data);
        }
    }

    redirect("news.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Editar Notícia' : 'Criar Notícia' ?></h2>
        <a href="news.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Voltar à Lista</a>
    </div>

    <div class="container-fluid">
        <form action="" method="POST" enctype="multipart/form-data">
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
                                            <label class="form-label">Slug (<?= strtoupper($lang['code']) ?>) - Gerado automaticamente se vazio</label>
                                            <input type="text" name="trans[<?= $lang['code'] ?>][slug]" class="form-control" value="<?= $t['slug'] ?? '' ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Introdução / Resumo</label>
                                            <textarea name="trans[<?= $lang['code'] ?>][short_description]" class="form-control" rows="3"><?= $t['short_description'] ?? '' ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Conteúdo Completo (Aceita HTML)</label>
                                            <textarea name="trans[<?= $lang['code'] ?>][content]" class="form-control" rows="10"><?= $t['content'] ?? '' ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Image -->
                    <div class="card mb-4">
                        <div class="card-header">Imagem do Artigo</div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <?php if (isset($news_data['image'])): ?>
                                    <img src="../<?= $news_data['image'] ?>" class="img-thumbnail mb-3" style="max-height: 200px;">
                                <?php endif; ?>
                                <input type="file" name="image" class="form-control">
                                <div class="form-text">Upload da imagem da notícia</div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">Definições</div>
                        <div class="card-body">
                            <div class="custom-control custom-switch mb-3">
                                <input class="custom-control-input" type="checkbox" name="is_active" id="isActive" <?= ($news_data['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="isActive">Artigo Ativo</label>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-save"></i> Guardar Artigo
                            </button>
                            <a href="news.php" class="btn btn-outline-secondary w-100">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

