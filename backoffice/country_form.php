<?php
include_once 'includes/helpers.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$country = $id ? db_get_one('countries', "id = $id") : null;
$translations = $id ? get_entity_translations('country_translations', 'country_id', $id) : [];
$languages = get_active_languages();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = strtoupper($_POST['code']);
    $data = ['code' => $code];

    if ($id) {
        db_update('countries', $data, "id = $id");
        $country_id = $id;
        set_alert("País atualizado com sucesso!");
    } else {
        $country_id = db_insert('countries', $data);
        set_alert("País criado com sucesso!");
    }

    foreach ($languages as $lang) {
        $lang_code = $lang['code'];
        $name = $_POST['trans'][$lang_code]['name'];

        $trans_data = [
            'country_id' => $country_id,
            'lang_code' => $lang_code,
            'name' => $name
        ];

        $existing = db_get_one('country_translations', "country_id = $country_id AND lang_code = '$lang_code'");
        if ($existing) {
            db_update('country_translations', $trans_data, "id = {$existing['id']}");
        } else {
            db_insert('country_translations', $trans_data);
        }
    }

    redirect("countries.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div id="content">
    <div class="topbar">
        <h2 class="h4 mb-0"><?= $id ? 'Editar País' : 'Criar País' ?></h2>
        <a href="countries.php" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Voltar à Lista</a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <form action="" method="POST">
                    <div class="card mb-4">
                        <div class="card-header">Detalhes do País</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Código ISO (ex: PT, GB, US)</label>
                                <input type="text" name="code" class="form-control"
                                    value="<?= $country['code'] ?? '' ?>" maxlength="5" required>
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
                        <i class="fas fa-save"></i> Guardar País
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>