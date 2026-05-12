<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$category = $id ? db_get_one('categories', "id = $id") : null;
$translations = $id ? get_entity_translations('category_translations', 'category_id', $id) : [];
$languages = get_active_languages();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Image
    $image = handle_image_upload('image', $category['image'] ?? '');

    $data = ['image' => $image];

    if ($id) {
        db_update('categories', $data, "id = $id");
        $category_id = $id;
        set_alert("Categoria atualizada com sucesso!");
    } else {
        $category_id = db_insert('categories', $data);
        set_alert("Categoria criada com sucesso!");
    }

    // Handle Translations
    foreach ($languages as $lang) {
        $lang_code = $lang['code'];
        $name = $_POST['trans'][$lang_code]['name'];

        $trans_data = [
            'category_id' => $category_id,
            'lang_code' => $lang_code,
            'name' => $name
        ];

        $existing = db_get_one('category_translations', "category_id = $category_id AND lang_code = '$lang_code'");
        if ($existing) {
            db_update('category_translations', $trans_data, "id = {$existing['id']}");
        } else {
            db_insert('category_translations', $trans_data);
        }
    }

    redirect("categories.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Editar Categoria' : 'Criar Categoria' ?></h2>
        <a href="categories.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Voltar à Lista</a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="card mb-4">
                        <div class="card-header">Imagem da Categoria</div>
                        <div class="card-body text-center">
                            <?php if (isset($category['image'])): ?>
                                <img src="../<?= $category['image'] ?>" class="img-thumbnail mb-3"
                                    style="max-height: 150px;">
                            <?php endif; ?>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">Traduções</div>
                        <div class="card-body">
                            <?php foreach ($languages as $lang):
                                $t = $translations[$lang['code']] ?? [];
                                ?>
                                <div class="mb-3">
                                    <label class="form-label"><?= $lang['emoji'] ?> Nome
                                        (<?= strtoupper($lang['code']) ?>)</label>
                                    <input type="text" name="trans[<?= $lang['code'] ?>][name]" class="form-control"
                                        value="<?= $t['name'] ?? '' ?>" required>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Guardar Categoria
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>