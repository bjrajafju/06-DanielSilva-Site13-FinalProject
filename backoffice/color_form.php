<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$color = $id ? db_get_one('colors', "id = $id") : null;
$translations = $id ? get_entity_translations('color_translations', 'color_id', $id) : [];
$languages = get_active_languages();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hex = $_POST['hex'];
    $data = ['hex' => $hex];

    if ($id) {
        db_update('colors', $data, "id = $id");
        $color_id = $id;
        set_alert("Cor atualizada com sucesso!");
    } else {
        $color_id = db_insert('colors', $data);
        set_alert("Cor criada com sucesso!");
    }

    // Handle Translations
    foreach ($languages as $lang) {
        $lang_code = $lang['code'];
        $name = $_POST['trans'][$lang_code]['name'];

        $trans_data = [
            'color_id' => $color_id,
            'lang_code' => $lang_code,
            'name' => $name
        ];

        $existing = db_get_one('color_translations', "color_id = $color_id AND lang_code = '$lang_code'");
        if ($existing) {
            db_update('color_translations', $trans_data, "id = {$existing['id']}");
        } else {
            db_insert('color_translations', $trans_data);
        }
    }

    redirect("colors.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Editar Cor' : 'Criar Cor' ?></h2>
        <a href="colors.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Voltar à Lista</a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="" method="POST">
                    <div class="card mb-4">
                        <div class="card-header">Detalhes da Cor</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Código HEX</label>
                                <div class="input-group">
                                    <input type="color" name="hex" class="form-control form-control-color"
                                        value="<?= $color['hex'] ?? '#000000' ?>" title="Choose your color">
                                    <input type="text" class="form-control" value="<?= $color['hex'] ?? '#000000' ?>"
                                        oninput="this.previousElementSibling.value = this.value"
                                        onchange="this.previousElementSibling.value = this.value">
                                </div>
                            </div>
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
                        <i class="fas fa-save"></i> Guardar Cor
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>